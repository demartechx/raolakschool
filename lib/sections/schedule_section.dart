import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../constants/app_strings.dart';
import '../widgets/section_header.dart';
import '../widgets/glass_container.dart';

class ScheduleSection extends StatelessWidget {
  final GlobalKey? conductKey;

  const ScheduleSection({super.key, this.conductKey});

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      color: AppColors.background,
      padding: const EdgeInsets.symmetric(vertical: 80, horizontal: 24),
      child: Column(
        children: [
          const SectionHeader(
            title: "Class Schedule & Rules",
            subtitle: "What you need to know",
            isLight: false,
          ),
          
          // Schedule Card
          GlassContainer(
            color: AppColors.surface,
            opacity: 0.5,
            padding: const EdgeInsets.all(48),
            borderRadius: BorderRadius.circular(32),
            child: Container(
              constraints: const BoxConstraints(maxWidth: 900),
              child: Column(
                children: [
                  // Programming Schedule
                  _buildScheduleRow("Programming", "Every Thursday", "1:30 PM - 4:30 PM"),
                  
                  const Divider(color: Colors.white10, height: 48),
                  
                  // Graphics Schedule
                  _buildScheduleRow("Graphics Design", "Every Friday", "10:00 AM - 12:30 PM"),
                  
                  const Divider(color: Colors.white10, height: 48),

                  // Note
                  Row(
                    children: [
                      const Icon(Icons.info_outline, color: AppColors.accent),
                      const SizedBox(width: 16),
                      Expanded(
                        child: Text(
                          "Note: There will be assignments and practical projects to cover for the rest of the week.",
                          style: TextStyle(
                            color: AppColors.white.withOpacity(0.8),
                            fontSize: 16,
                            height: 1.5,
                            fontStyle: FontStyle.italic,
                          ),
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ),
          
          const SizedBox(height: 80),
          
          // Rules
          Container(
             key: conductKey,
             child: const Text(
                "CODE OF CONDUCT",
                style: TextStyle(
                  fontSize: 24,
                  fontWeight: FontWeight.bold,
                  color: AppColors.accent,
                  letterSpacing: 2,
                ),
             ),
          ),
          const SizedBox(height: 48),
          
          Container(
            constraints: const BoxConstraints(maxWidth: 800),
            child: Wrap(
              spacing: 24,
              runSpacing: 24,
              alignment: WrapAlignment.center,
              children: AppStrings.rules.map((rule) => Container(
                width: 350,
                padding: const EdgeInsets.all(24),
                decoration: BoxDecoration(
                  color: AppColors.surface,
                  borderRadius: BorderRadius.circular(16),
                  border: Border.all(color: Colors.white.withOpacity(0.05)),
                ),
                child: Row(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    const Icon(Icons.verified_user_outlined, color: AppColors.success, size: 24),
                    const SizedBox(width: 16),
                    Expanded(
                      child: Text(
                        rule,
                        style: const TextStyle(
                          fontSize: 16, 
                          color: AppColors.textSecondary,
                          height: 1.5,
                        ),
                      ),
                    ),
                  ],
                ),
              )).toList(),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildScheduleRow(String track, String day, String time) {
    return Row(
      children: [
        Expanded(
          flex: 2,
          child: Text(
            track,
            style: const TextStyle(
              color: AppColors.accent,
              fontSize: 20,
              fontWeight: FontWeight.bold,
            ),
          ),
        ),
        Container(width: 1, height: 40, color: Colors.white10),
        Expanded(
          flex: 3,
          child: Padding(
            padding: const EdgeInsets.symmetric(horizontal: 24),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Expanded(child: _buildTimeDetail("Day", day)),
                const SizedBox(width: 16),
                Expanded(child: _buildTimeDetail("Time", time)),
              ],
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildTimeDetail(String label, String value) {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          label.toUpperCase(),
          style: const TextStyle(
            color: AppColors.textSecondary,
            fontSize: 12,
            fontWeight: FontWeight.bold,
            letterSpacing: 1.5,
          ),
        ),
        const SizedBox(height: 8),
        Text(
          value,
          style: const TextStyle(
            color: AppColors.white,
            fontSize: 18,
            fontWeight: FontWeight.w600,
          ),
        ),
      ],
    );
  }
}
