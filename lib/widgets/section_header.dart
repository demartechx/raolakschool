import 'package:flutter/material.dart';
import '../constants/app_colors.dart';

class SectionHeader extends StatelessWidget {
  final String title;
  final String? subtitle;
  final bool isLight;

  const SectionHeader({
    super.key,
    required this.title,
    this.subtitle,
    this.isLight = true,
  });

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Text(
          title,
          style: TextStyle(
            fontSize: 32,
            fontWeight: FontWeight.bold,
            color: isLight ? AppColors.primary : AppColors.white,
          ),
          textAlign: TextAlign.center,
        ),
        if (subtitle != null) ...[
          const SizedBox(height: 16),
          Text(
            subtitle!,
            style: TextStyle(
              fontSize: 18,
              color: isLight ? AppColors.textSecondary : AppColors.white.withOpacity(0.8),
            ),
            textAlign: TextAlign.center,
          ),
        ],
        const SizedBox(height: 48),
      ],
    );
  }
}
