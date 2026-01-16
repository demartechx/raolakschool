import 'package:flutter/material.dart';
import 'package:supabase_flutter/supabase_flutter.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';
import 'package:flutter/gestures.dart';
import 'package:url_launcher/url_launcher.dart';
import '../constants/app_colors.dart';
import '../constants/app_strings.dart';
import '../widgets/section_header.dart';
import '../widgets/status_dialog.dart';

class RegistrationSection extends StatefulWidget {
  const RegistrationSection({super.key});

  @override
  State<RegistrationSection> createState() => _RegistrationSectionState();
}

class _RegistrationSectionState extends State<RegistrationSection> {
  final _formKey = GlobalKey<FormState>();
  
  // Controllers
  final _usernameController = TextEditingController();
  final _nameController = TextEditingController();
  final _emailController = TextEditingController();
  final _phoneController = TextEditingController();
  final _addressController = TextEditingController();
  final _pinController = TextEditingController();
  
  static const int _maxCapacity = 20;
  static const List<String> _courses = ["Programming", "Graphics Design"];
  
  String _selectedClass = AppStrings.courseCategoryDefault;
  bool _isSubmitting = false;
  Map<String, int> _classCounts = {};
  bool _isLoadingCounts = true;

  @override
  void initState() {
    super.initState();
    _fetchClassCounts();
  }

  Future<void> _fetchClassCounts() async {
    try {
      final response = await Supabase.instance.client.rpc('get_class_counts');
      
      final Map<String, dynamic> data = (response as Map).cast<String, dynamic>();
      final counts = <String, int>{};
      
      data.forEach((key, value) {
        counts[key] = (value as num).toInt();
      });
      
        setState(() {
          _classCounts = counts;
          _isLoadingCounts = false;

          // Auto-select available course if current default is full
          final currentCount = _classCounts[_selectedClass] ?? 0;
          if (currentCount >= _maxCapacity) {
             // Find first available course
             for (final course in _courses) {
                final courseCount = _classCounts[course] ?? 0;
                if (courseCount < _maxCapacity) {
                   _selectedClass = course;
                   break;
                }
             }
          }
        });
    } catch (e) {
      debugPrint('Error fetching class counts: $e');
      if (mounted) setState(() => _isLoadingCounts = false);
    }
  }

  @override
  void dispose() {
    _usernameController.dispose();
    _nameController.dispose();
    _emailController.dispose();
    _phoneController.dispose();
    _addressController.dispose();
    _pinController.dispose();
    super.dispose();
  }



// ... (inside class)

  void _showStatusDialog({
    required bool isSuccess,
    required String title,
    required String message,
  }) {
    showDialog(
      context: context,
      barrierColor: Colors.black.withOpacity(0.8),
      builder: (context) => StatusDialog(
        isSuccess: isSuccess,
        title: title,
        message: message,
        onRetry: () {}, // Just close and let user edit/retry
        onOk: () {
             // If success, maybe navigate home or just close
        },
      ),
    );
  }

  Future<void> _submitForm() async {
    if (_formKey.currentState!.validate()) {
      setState(() => _isSubmitting = true);
      
      try {
        final username = _usernameController.text.trim();
        final email = _emailController.text.trim();
        final phone = _phoneController.text.trim();

        // 0. Check Class Limit again (Race condition check)
        final currentCount = _classCounts[_selectedClass] ?? 0;
        if (currentCount >= _maxCapacity) {
           if (mounted) {
            _showStatusDialog(
              isSuccess: false, 
              title: "Course Full", 
              message: "Sorry, $_selectedClass is already full. Please select another course or contact support."
            );
          }
          setState(() => _isSubmitting = false);
          return;
        }

        // 1. Supabase Validation using RPC
        final String? duplicateField = await Supabase.instance.client.rpc(
          'check_duplicate_details',
          params: {
            'name_check': username,
            'email_check': email,
            'phone_check': phone,
          },
        );

        if (duplicateField != null) {
          if (mounted) {
            String errorMsg = 'This information is already registered.';
            if (duplicateField == 'username') {
              errorMsg = 'Username already taken. Please choose another.';
            } else if (duplicateField == 'email') {
              errorMsg = 'Email already registered.';
            } else if (duplicateField == 'phone') {
              errorMsg = 'Phone number already registered.';
            }

            _showStatusDialog(
              isSuccess: false, 
              title: "Registration Failed", 
              message: errorMsg
            );
          }
          return; 
        }

        // 2. Verify with Mobilenig API
        final apiResponse = await http.post(
          Uri.parse('https://mobilenig.com/portal/api/post'),
          headers: {'Content-Type': 'application/json'},
          body: jsonEncode({
            'path': 'school/process_registration',
            'data': {
              'username': username,
              'course': _selectedClass,
              'pin': _pinController.text.trim(),
            },
          }),
        );

        debugPrint('API Status Code: ${apiResponse.statusCode}');
        debugPrint('Response Bytes: ${apiResponse.bodyBytes}');
        
        String responseBody;
        try {
           responseBody = utf8.decode(apiResponse.bodyBytes, allowMalformed: true);
        } catch (e) {
           responseBody = 'Error decoding body: $e';
        }
        debugPrint('API Body (Decoded): $responseBody');

        Map<String, dynamic> responseData;
        try {
          responseData = jsonDecode(responseBody);
        } catch (e) {
           // Handle non-JSON response
           if (responseBody.trim().toLowerCase() == 'success') {
              responseData = {'message': 'success'};
           } else {
              throw FormatException('Invalid JSON response: $responseBody');
           }
        }
        
        // Check if message is 'successful'
        if (responseData['message'] != 'successful') {
           if (mounted) {
            final errorMsg = responseData['data'] ?? 'Verification failed';
            _showStatusDialog(
              isSuccess: false, 
              title: "Verification Failed", 
              message: errorMsg
            );
          }
          return;
        }

        // 3. If API success, Insert into Supabase
        await Supabase.instance.client.from('registrations').insert({
          'username': username,
          'full_name': _nameController.text.trim(),
          'email': email,
          'phone': phone,
          'address': _addressController.text.trim(),
          'class_category': _selectedClass,
        });
        
        if (mounted) {
          _showStatusDialog(
            isSuccess: true, 
            title: "Response Submitted", // As requested by user earlier? Or just Success
            message: "Registration submitted successfully! Welcome aboard."
          );
          
          _formKey.currentState!.reset();
          _usernameController.clear();
          _nameController.clear();
          _emailController.clear();
          _phoneController.clear();
          _addressController.clear();
          _pinController.clear();
        }
      } catch (e) {
        debugPrint('Error submitting form: $e');
        if (mounted) {
          String errorMessage = 'An error occurred during registration.';
          // Only parsing RPC/Postgres errors if they slip through the first check
          if (e.toString().contains('username')) errorMessage = 'Username already taken.';
          
          _showStatusDialog(
            isSuccess: false, 
            title: "Error", 
            message: errorMessage
          );
        }
      } finally {
        if (mounted) {
          setState(() => _isSubmitting = false);
        }
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      color: AppColors.background,
      padding: const EdgeInsets.symmetric(vertical: 80, horizontal: 24),
      child: Column(
        children: [
          const SectionHeader(
            title: "Secure Your Spot",
            subtitle: "Join the next cohort of innovators",
            isLight: false,
          ),
          
          // Payment Instructions
          Container(
            constraints: const BoxConstraints(maxWidth: 800),
            padding: const EdgeInsets.all(32),
            margin: const EdgeInsets.only(bottom: 64),
            decoration: BoxDecoration(
              gradient: LinearGradient(
                colors: [AppColors.primary.withOpacity(0.1), AppColors.background],
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
              ),
              borderRadius: BorderRadius.circular(24),
              border: Border.all(color: AppColors.primary.withOpacity(0.3)),
            ),
            child: Column(
              children: [
                const Text(
                  "STEP 1: APPLICATION FEE PAYMENT",
                  style: TextStyle(
                    color: AppColors.primary,
                    fontWeight: FontWeight.bold,
                    fontSize: 14,
                    letterSpacing: 2,
                  ),
                ),
                const SizedBox(height: 16),
                RichText(
                  textAlign: TextAlign.center,
                  text: TextSpan( // Changed to non-const because of recognizer
                    style: const TextStyle(color: AppColors.textSecondary, fontSize: 16, height: 1.6),
                    children: [
                      const TextSpan(text: "The training is "),
                      const TextSpan(
                        text: "TOTALLY FREE",
                        style: TextStyle(fontWeight: FontWeight.bold, color: AppColors.success),
                      ),
                      const TextSpan(text: ", but you are required to pay an application fee.\n\n"),
                      const TextSpan(text: "Register on "),
                      TextSpan(
                        text: "mobilenig.com",
                        style: const TextStyle(
                           fontWeight: FontWeight.bold,
                           color: AppColors.white,
                           decoration: TextDecoration.underline,
                        ),
                        recognizer: TapGestureRecognizer()
                          ..onTap = () async {
                            final Uri url = Uri.parse('https://mobilenig.com');
                            if (!await launchUrl(url)) {
                               debugPrint("Could not launch $url");
                            }
                          },
                      ),
                      TextSpan(text: " and fund your wallet with a minimum of "),
                      TextSpan(
                        text: "₦25,000",
                        style: TextStyle(fontWeight: FontWeight.bold, color: AppColors.success),
                      ),
                      TextSpan(text: "."),
                    ],
                  ),
                ),
              ],
            ),
          ),
          
          // Form
          Container(
            constraints: const BoxConstraints(maxWidth: 600),
            padding: const EdgeInsets.all(40),
            decoration: BoxDecoration(
              color: AppColors.surface,
              borderRadius: BorderRadius.circular(24),
              border: Border.all(color: Colors.white.withOpacity(0.05)),
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(0.2),
                  blurRadius: 40,
                  offset: const Offset(0, 20),
                ),
              ],
            ),
            child: Form(
              key: _formKey,
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                children: [
                  const Text(
                    "STEP 2: STUDENT DETAILS",
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      color: AppColors.textSecondary,
                      fontWeight: FontWeight.bold,
                      fontSize: 14,
                      letterSpacing: 2,
                    ),
                  ),
                  const SizedBox(height: 40),
                  _buildTextField("Mobilenig Username", _usernameController, Icons.account_balance_wallet),
                  const SizedBox(height: 24),
                  _buildTextField("Full Name", _nameController, Icons.person),
                  const SizedBox(height: 24),
                  _buildTextField("Email", _emailController, Icons.email, TextInputType.emailAddress),
                  const SizedBox(height: 24),
                  _buildTextField("Phone", _phoneController, Icons.phone, TextInputType.phone),
                  const SizedBox(height: 24),
                  const SizedBox(height: 24),
                  _buildTextField("Address", _addressController, Icons.location_on),
                  const SizedBox(height: 24),
                  _buildTextField("Mobilenig PIN", _pinController, Icons.lock),
                  const SizedBox(height: 24),
                  
                  // Dropdown
                  DropdownButtonFormField<String>(
                    value: _selectedClass,
                    dropdownColor: AppColors.surface,
                    style: const TextStyle(color: AppColors.white),
                    decoration: _inputDecoration("Class", Icons.class_),
                    items: _courses.map((course) {
                      final count = _classCounts[course] ?? 0;
                      final isFull = count >= _maxCapacity;
                      
                      return DropdownMenuItem<String>(
                        value: course,
                        enabled: !isFull,
                        child: Text(
                          isFull ? "$course (FULL)" : "$course ($count/$_maxCapacity spots)",
                          style: TextStyle(
                            color: isFull ? Colors.grey : AppColors.white,
                          ),
                        ),
                      );
                    }).toList(),
                    onChanged: (val) {
                      if (val != null) setState(() => _selectedClass = val);
                    },
                  ),
                  
                  const SizedBox(height: 56),
                  
                  Container(
                    height: 56,
                    decoration: BoxDecoration(
                      gradient: AppColors.primaryGradient,
                      borderRadius: BorderRadius.circular(12),
                      boxShadow: [
                        BoxShadow(
                          color: AppColors.primary.withOpacity(0.3),
                          blurRadius: 20,
                          offset: const Offset(0, 10),
                        ),
                      ],
                    ),
                    child: ElevatedButton(
                      onPressed: (_isSubmitting || (_classCounts[_selectedClass] ?? 0) >= _maxCapacity) 
                          ? null 
                          : _submitForm,
                      style: ElevatedButton.styleFrom(
                        backgroundColor: Colors.transparent,
                        shadowColor: Colors.transparent,
                        foregroundColor: Colors.white,
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(12),
                        ),
                      ),
                      child: _isSubmitting 
                        ? const SizedBox(
                            width: 24, 
                            height: 24, 
                            child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2)
                          )
                        : const Text(
                            "SUBMIT APPLICATION", 
                            style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, letterSpacing: 1)
                          ),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  InputDecoration _inputDecoration(String label, IconData icon) {
    return InputDecoration(
      labelText: label,
      labelStyle: const TextStyle(color: AppColors.textSecondary),
      prefixIcon: Icon(icon, color: AppColors.primary),
      filled: true,
      fillColor: Colors.black.withOpacity(0.2),
      border: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: BorderSide.none,
      ),
      enabledBorder: OutlineInputBorder(
         borderRadius: BorderRadius.circular(12),
         borderSide: BorderSide(color: Colors.white.withOpacity(0.05)),
      ),
      focusedBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: AppColors.primary),
      ),
      errorBorder: OutlineInputBorder(
        borderRadius: BorderRadius.circular(12),
        borderSide: const BorderSide(color: Colors.redAccent),
      ),
    );
  }

  Widget _buildTextField(String label, TextEditingController controller, IconData icon, [TextInputType type = TextInputType.text]) {
    return TextFormField(
      controller: controller,
      keyboardType: type,
      style: const TextStyle(color: AppColors.white),
      validator: (value) {
        if (value == null || value.isEmpty) {
          return 'Please enter $label';
        }
        return null;
      },
      decoration: _inputDecoration(label, icon),
    );
  }
}
