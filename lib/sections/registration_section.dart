import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../constants/app_strings.dart';
import '../widgets/section_header.dart';

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
  
  String _selectedClass = AppStrings.courseCategoryDefault;
  bool _isSubmitting = false;

  @override
  void dispose() {
    _usernameController.dispose();
    _nameController.dispose();
    _emailController.dispose();
    _phoneController.dispose();
    _addressController.dispose();
    super.dispose();
  }

  Future<void> _submitForm() async {
    if (_formKey.currentState!.validate()) {
      setState(() => _isSubmitting = true);
      
      // Simulate backend delay
      await Future.delayed(const Duration(seconds: 2));
      
      if (mounted) {
        setState(() => _isSubmitting = false);
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(
            content: Text('Registration submitted successfully! Welcome aboard.'),
            backgroundColor: AppColors.success,
            behavior: SnackBarBehavior.floating,
          ),
        );
        _formKey.currentState!.reset();
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
                  text: const TextSpan(
                    style: TextStyle(color: AppColors.textSecondary, fontSize: 16, height: 1.6),
                    children: [
                      TextSpan(text: "The training is "),
                      TextSpan(
                        text: "TOTALLY FREE",
                        style: TextStyle(fontWeight: FontWeight.bold, color: AppColors.success),
                      ),
                      TextSpan(text: ", but you are required to pay an application fee.\n\n"),
                      TextSpan(text: "Register on "),
                      TextSpan(
                        text: "mobilenig.com",
                        style: TextStyle(fontWeight: FontWeight.bold, color: AppColors.white),
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
                  _buildTextField("Address", _addressController, Icons.location_on),
                  const SizedBox(height: 24),
                  
                  // Dropdown
                  DropdownButtonFormField<String>(
                    value: _selectedClass,
                    dropdownColor: AppColors.surface,
                    style: const TextStyle(color: AppColors.white),
                    decoration: _inputDecoration("Class", Icons.class_),
                    items: const [
                      DropdownMenuItem(
                        value: "Programming",
                        child: Text("Programming"),
                      ),
                    ],
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
                      onPressed: _isSubmitting ? null : _submitForm,
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
