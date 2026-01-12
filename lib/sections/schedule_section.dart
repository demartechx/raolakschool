import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../constants/app_strings.dart';
import '../widgets/section_header.dart';
import '../widgets/glass_container.dart';

class ScheduleSection extends StatelessWidget {
  const ScheduleSection({super.key});

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
              constraints: const BoxConstraints(maxWidth: 800),
              child: Wrap(
                spacing: 32,
                runSpacing: 24,
                alignment: WrapAlignment.spaceEvenly,
                crossAxisAlignment: WrapCrossAlignment.center,
                children: [
                  _buildTimeBlock("Day", "Thursday"),
                  Container(width: 1, height: 50, color: Colors.white10),
                  _buildTimeBlock("Time", "2 PM - 5 PM"),
                  Container(width: 1, height: 50, color: Colors.white10),
                  _buildTimeBlock("Start Date", "Feb 5, 2026"),
                ],
              ),
            ),
          ),
          
          const SizedBox(height: 80),
          
          // Rules
          const Text(
            "CODE OF CONDUCT",
            style: TextStyle(
              fontSize: 24,
              fontWeight: FontWeight.bold,
              color: AppColors.accent,
              letterSpacing: 2,
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

  Widget _buildTimeBlock(String label, String value) {
    return Column(
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
        const SizedBox(height: 12),
        Text(
          value,
          style: const TextStyle(
            color: AppColors.white,
            fontSize: 24,
            fontWeight: FontWeight.bold,
          ),
        ),
      ],
    );
  }
}
