import 'package:flutter/material.dart';
import 'constants/app_colors.dart';
import 'screens/home_screen.dart';

import 'package:supabase_flutter/supabase_flutter.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  await Supabase.initialize(
    url: 'https://fxigzbhmtvgicahzvicr.supabase.co',
    anonKey: 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImZ4aWd6YmhtdHZnaWNhaHp2aWNyIiwicm9sZSI6ImFub24iLCJpYXQiOjE3Njg1NjIyODgsImV4cCI6MjA4NDEzODI4OH0.m3oe9HAjIPW7TUKcYRajXikIqDT6MyzYVswymf0z4wg',
  );
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
