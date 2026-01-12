import 'package:flutter/material.dart';
import 'constants/app_colors.dart';
import 'screens/home_screen.dart';

void main() {
  runApp(const RaolakSchoolApp());
}

class RaolakSchoolApp extends StatelessWidget {
  const RaolakSchoolApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'RAOLAK TECH SCHOOL',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        primaryColor: AppColors.primary,
        scaffoldBackgroundColor: AppColors.background,
        colorScheme: ColorScheme.fromSwatch().copyWith(
          primary: AppColors.primary,
          secondary: AppColors.accent,
        ),
        useMaterial3: true,
        fontFamily: 'Roboto', // Using default sans-serif for now, could be improved with GoogleFonts
      ),
      home: HomeScreen(),
    );
  }
}
