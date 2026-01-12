import 'package:flutter/material.dart';

class AppColors {
  // Orange & Dark Grey Theme
  static const Color background = Color(0xFF121212); // Very Dark Grey
  static const Color surface = Color(0xFF1E1E1E); // Lighter Dark Grey
  static const Color primary = Color(0xFFFF5722); // Deep Orange
  static const Color accent = Color(0xFFFFA726); // Lighter Orange / Amber
  
  static const Color textPrimary = Color(0xFFFFFFFF);
  static const Color textSecondary = Color(0xFFB0B0B0); // Light Grey
  
  static const Color white = Colors.white;
  static const Color success = Color(0xFF00C853); // Green Accent
  static const Color warning = Color(0xFFFFD600); // Yellow Accent
  
  // Gradients
  static const LinearGradient primaryGradient = LinearGradient(
    colors: [Color(0xFFFF5722), Color(0xFFFF8A65)],
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
  );
  
  static const LinearGradient accentGradient = LinearGradient(
    colors: [Color(0xFFFFA726), Color(0xFFFFCC80)],
    begin: Alignment.centerLeft,
    end: Alignment.centerRight,
  );
  
  static const LinearGradient cardGradient = LinearGradient(
    colors: [Color(0xFF1E1E1E), Color(0xFF252525)],
    begin: Alignment.topLeft,
    end: Alignment.bottomRight,
  );
}
