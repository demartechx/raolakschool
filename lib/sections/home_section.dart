import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../constants/app_strings.dart';
import '../widgets/glass_container.dart';

class HomeSection extends StatelessWidget {
  final VoidCallback onRegisterClick;

  const HomeSection({super.key, required this.onRegisterClick});

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      decoration: const BoxDecoration(
        color: AppColors.background,
        image: DecorationImage(
          image: NetworkImage("https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop"), // Reliable Classroom setting
          fit: BoxFit.cover,
          opacity: 0.2,
        ),
      ),
      child: Stack(
        children: [
          // Gradient Overlay
          Container(
            decoration: BoxDecoration(
              gradient: LinearGradient(
                begin: Alignment.topCenter,
                end: Alignment.bottomCenter,
                colors: [
                  AppColors.background.withOpacity(0.8),
                  AppColors.background,
                ],
              ),
            ),
          ),
          
          Center(
            child: Padding(
              padding: const EdgeInsets.symmetric(vertical: 120, horizontal: 24),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  _buildGlowingTitle(),
                  const SizedBox(height: 24),
                  GlassContainer(
                    padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
                    borderRadius: BorderRadius.circular(50),
                    child: Column(
                      children: [
                        const Text(
                          AppStrings.tagline,
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            fontSize: 18,
                            color: AppColors.accent,
                            letterSpacing: 2,
                            fontWeight: FontWeight.w600,
                          ),
                        ),
                        const SizedBox(height: 8),
                        Text(
                          "Tuition is 100% FREE • Application Fee: ₦25,000",
                          textAlign: TextAlign.center,
                          style: TextStyle(
                            fontSize: 14,
                            color: AppColors.white.withOpacity(0.9),
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                      ],
                    ),
                  ),
                  const SizedBox(height: 64),
                  
                  // Info Cards
                  Wrap(
                    spacing: 24,
                    runSpacing: 24,
                    alignment: WrapAlignment.center,
                    children: [
                      _buildInfoGlass(Icons.location_on, AppStrings.location),
                      _buildInfoGlass(Icons.rocket_launch, "Launch: ${AppStrings.startDate}"),
                    ],
                  ),
                  
                  const SizedBox(height: 64),
                  
                  // CTA Button with Glow
                  Container(
                    decoration: BoxDecoration(
                      boxShadow: [
                        BoxShadow(
                          color: AppColors.primary.withOpacity(0.5),
                          blurRadius: 30,
                          spreadRadius: 2,
                          offset: const Offset(0, 5),
                        ),
                      ],
                    ),
                    child: ElevatedButton(
                      onPressed: onRegisterClick,
                      style: ElevatedButton.styleFrom(
                        backgroundColor: AppColors.primary,
                        foregroundColor: AppColors.white,
                        padding: const EdgeInsets.symmetric(horizontal: 50, vertical: 25),
                        shape: RoundedRectangleBorder(
                          borderRadius: BorderRadius.circular(30),
                        ),
                        elevation: 0, 
                      ),
                      child: const Text(
                        "JOIN THE FUTURE",
                        style: TextStyle(
                          fontSize: 18,
                          fontWeight: FontWeight.bold,
                          letterSpacing: 2,
                        ),
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

  Widget _buildGlowingTitle() {
    return ShaderMask(
      shaderCallback: (bounds) => const LinearGradient(
        colors: [AppColors.white, AppColors.accent],
        begin: Alignment.topCenter,
        end: Alignment.bottomCenter,
      ).createShader(bounds),
      child: const Text(
        AppStrings.schoolName,
        textAlign: TextAlign.center,
        style: TextStyle(
          fontSize: 64,
          fontWeight: FontWeight.w900,
          color: Colors.white, // Required for shader
          letterSpacing: -2,
          height: 1.1,
        ),
      ),
    );
  }

  Widget _buildInfoGlass(IconData icon, String text) {
    return GlassContainer(
      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 12),
      borderRadius: BorderRadius.circular(12),
      color: Colors.white,
      opacity: 0.05,
      child: Row(
        mainAxisSize: MainAxisSize.min,
        children: [
          Icon(icon, color: AppColors.textSecondary, size: 20),
          const SizedBox(width: 12),
          Text(
            text,
            style: const TextStyle(color: AppColors.textPrimary, fontSize: 16),
          ),
        ],
      ),
    );
  }
}
