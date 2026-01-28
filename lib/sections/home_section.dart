import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../constants/app_strings.dart';
import '../widgets/glass_container.dart';

import 'package:flutter_animate/flutter_animate.dart';
import 'package:url_launcher/url_launcher.dart';

class HomeSection extends StatelessWidget {
  final VoidCallback onRegisterClick;
  final VoidCallback onCoursesClick;
  final VoidCallback onScheduleClick;

  const HomeSection({
    super.key,
    required this.onRegisterClick,
    required this.onCoursesClick,
    required this.onScheduleClick,
  });

  Future<void> _launchLogin() async {
    final Uri url = Uri.parse('https://school.raolak.com/portal/public/login');
    if (!await launchUrl(url)) {
      debugPrint("Could not launch $url");
    }
  }

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      clipBehavior: Clip.hardEdge,
      decoration: const BoxDecoration(
        color: Color(0xFF020617),
      ),
      child: Stack(
        children: [
          // Ambient Glow 1 (Brand Orange)
          Positioned(
            top: -100,
            right: -50,
            child: Container(
              width: 400,
              height: 400,
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                color: const Color(0xFFF97316).withOpacity(0.15),
                boxShadow: [
                  BoxShadow(
                    color: const Color(0xFFF97316).withOpacity(0.2),
                    blurRadius: 200,
                    spreadRadius: 50,
                  ),
                ],
              ),
            ),
          ),
          
           // Ambient Glow 2 (Accent Blue/Purple)
          Positioned(
            bottom: -100,
            left: -50,
            child: Container(
              width: 400,
              height: 400,
              decoration: BoxDecoration(
                 shape: BoxShape.circle,
                color: const Color(0xFF6366F1).withOpacity(0.15),
                boxShadow: [
                  BoxShadow(
                    color: const Color(0xFF6366F1).withOpacity(0.2),
                    blurRadius: 200,
                    spreadRadius: 50,
                  ),
                ],
              ),
            ),
          ),

          // Main Content
          Center(
            child: Padding(
              padding: const EdgeInsets.only(top: 180, bottom: 96, left: 24, right: 24), // Increased top padding for margin
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  // Logo
                  Hero(
                    tag: 'hero_logo',
                    child: Image.asset(
                      "assets/images/logo_transparent.png",
                      height: 120, 
                    ),
                  ).animate().fadeIn(duration: 800.ms).scale(delay: 200.ms),
                  
                  const SizedBox(height: 48),

                  // Big Headline
                  Text(
                    "Master the\nFuture of Tech",
                    textAlign: TextAlign.center,
                    style: TextStyle(
                      fontSize: 56, // Massive
                      height: 1.1,
                      fontWeight: FontWeight.w900,
                      letterSpacing: -1.5,
                      color: Colors.white,
                      shadows: [
                        Shadow(
                          color: Colors.white.withOpacity(0.1),
                          offset: const Offset(0, 4),
                          blurRadius: 20,
                        ),
                      ],
                    ),
                  ).animate().fadeIn(delay: 300.ms, duration: 800.ms).moveY(begin: 30, end: 0),

                  const SizedBox(height: 24),

                  // Subtext
                  Container(
                    constraints: const BoxConstraints(maxWidth: 600),
                    child: Text(
                      "Join the elite tech school where tuition is 100% FREE. Expert mentors, physical classes, and real-world projects.",
                      textAlign: TextAlign.center,
                      style: TextStyle(
                        fontSize: 18,
                        height: 1.6,
                        color: Colors.blueGrey.shade200,
                        fontWeight: FontWeight.w400,
                      ),
                    ),
                  ).animate().fadeIn(delay: 500.ms, duration: 800.ms).moveY(begin: 20, end: 0),
                  
                  const SizedBox(height: 48),
                  
                  // Feature Pills
                  Wrap(
                    spacing: 16,
                    runSpacing: 16,
                    alignment: WrapAlignment.center,
                    children: [
                      _buildFeaturePill(Icons.verified_user_outlined, "100% Tuition Free"),
                      _buildFeaturePill(Icons.map_outlined, AppStrings.location),
                    ],
                  ).animate().fadeIn(delay: 700.ms).slideX(begin: 0.2, end: 0),

                  const SizedBox(height: 56),

                  // Action Buttons
                  Wrap(
                    spacing: 20,
                    runSpacing: 20,
                    children: [
                      // Primary Button
                      Container(
                        decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(50),
                          gradient: const LinearGradient(
                            colors: [Color(0xFFF97316), Color(0xFFEA580C)], // Orange Gradient
                          ),
                          boxShadow: [
                            BoxShadow(
                              color: const Color(0xFFF97316).withOpacity(0.4),
                              blurRadius: 20,
                              offset: const Offset(0, 8),
                            ),
                          ],
                        ),
                        child: ElevatedButton(
                          onPressed: onRegisterClick,
                          style: ElevatedButton.styleFrom(
                            backgroundColor: Colors.transparent,
                            shadowColor: Colors.transparent,
                            foregroundColor: Colors.white,
                            padding: const EdgeInsets.symmetric(horizontal: 40, vertical: 20),
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(50),
                            ),
                          ),
                          child: const Text(
                            "APPLY NOW",
                            style: TextStyle(
                              fontSize: 16,
                              fontWeight: FontWeight.bold,
                              letterSpacing: 1,
                            ),
                          ),
                        ),
                      ),
                    ],
                  ).animate().fadeIn(delay: 900.ms).scale(),
                ],
              ),
            ),
          ),
          
          // Responsive, Elevated Navigation Menu (Moved to END of Stack for Top Z-Index)
          Positioned(
            top: 20,
            left: 20,
            right: 20,
            child: LayoutBuilder(
              builder: (context, constraints) {
                bool isMobile = MediaQuery.of(context).size.width < 900;
                
                return Center(
                  child: Container(
                    constraints: const BoxConstraints(maxWidth: 1200),
                    padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 16),
                    decoration: BoxDecoration(
                      color: const Color(0xFF0F172A).withOpacity(0.7), // Glass dark
                      borderRadius: BorderRadius.circular(100),
                      border: Border.all(color: Colors.white.withOpacity(0.1)),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.black.withOpacity(0.2),
                          blurRadius: 20,
                          offset: const Offset(0, 10),
                        ),
                      ],
                    ),
                    child: Row(
                      mainAxisAlignment: MainAxisAlignment.spaceBetween,
                      children: [
                        // Brand
                        const Text(
                          "RAOLAK TECH",
                          style: TextStyle(
                            color: Colors.white,
                            fontWeight: FontWeight.bold,
                            fontSize: 20,
                            letterSpacing: 2,
                          ),
                        ),

                        // Nav Items
                        if (isMobile)
                          PopupMenuButton<String>(
                            icon: const Icon(Icons.menu, color: Colors.white),
                            color: const Color(0xFF1E293B),
                            onSelected: (value) {
                              if (value == 'Courses') onCoursesClick();
                              if (value == 'Schedule') onScheduleClick();
                              if (value == 'Conduct') onScheduleClick();
                              if (value == 'Login') _launchLogin();
                              if (value == 'Apply') onRegisterClick();
                            },
                            itemBuilder: (BuildContext context) => [
                              const PopupMenuItem(value: 'Courses', child: Text('Courses', style: TextStyle(color: Colors.white))),
                              const PopupMenuItem(value: 'Schedule', child: Text('Schedule', style: TextStyle(color: Colors.white))),
                              const PopupMenuItem(value: 'Conduct', child: Text('Code of Conduct', style: TextStyle(color: Colors.white))),
                              const PopupMenuItem(value: 'Login', child: Text('Login', style: TextStyle(color: Colors.white))),
                              const PopupMenuItem(value: 'Apply', child: Text('Apply Now', style: TextStyle(color: AppColors.primary, fontWeight: FontWeight.bold))),
                            ],
                          )
                        else
                          Row(
                            children: [
                              _buildNavLink("Courses", onCoursesClick),
                              const SizedBox(width: 24),
                              _buildNavLink("Schedule", onScheduleClick),
                              const SizedBox(width: 24),
                              _buildNavLink("Code of Conduct", onScheduleClick),
                              const SizedBox(width: 24),
                              _buildNavLink("Login", _launchLogin),
                              const SizedBox(width: 32),
                              ElevatedButton(
                                onPressed: onRegisterClick,
                                style: ElevatedButton.styleFrom(
                                  backgroundColor: AppColors.primary,
                                  foregroundColor: Colors.white,
                                  padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
                                  shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(20)),
                                ),
                                child: const Text("APPLY NOW", style: TextStyle(fontWeight: FontWeight.bold)),
                              ),
                            ],
                          ),
                      ],
                    ),
                  ),
                );
              },
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildNavLink(String text, VoidCallback onTap) {
    return MouseRegion(
      cursor: SystemMouseCursors.click,
      child: GestureDetector(
        onTap: onTap,
        child: Text(
          text,
          style: TextStyle(
            color: Colors.white.withOpacity(0.9),
            fontWeight: FontWeight.w500,
            fontSize: 15,
          ),
        ),
      ),
    );
  }

  Widget _buildFeaturePill(IconData icon, String text) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
      decoration: BoxDecoration(
        color: Colors.white.withOpacity(0.05),
        borderRadius: BorderRadius.circular(20),
        border: Border.all(color: Colors.white.withOpacity(0.05)),
      ),
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(icon, color: const Color(0xFFF97316), size: 16),
          const SizedBox(width: 8),
          Text(
            text,
            style: TextStyle(
              color: Colors.blueGrey.shade100,
              fontSize: 14,
              fontWeight: FontWeight.w500,
            ),
          ),
        ],
      ),
    );
  }
}
