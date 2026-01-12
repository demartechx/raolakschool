import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../sections/home_section.dart';
import '../sections/courses_section.dart';
import '../sections/schedule_section.dart';
import '../sections/registration_section.dart';

class HomeScreen extends StatelessWidget {
  HomeScreen({super.key});

  final ScrollController _scrollController = ScrollController();
  final GlobalKey _registrationKey = GlobalKey();

  void _scrollToRegistration() {
    Scrollable.ensureVisible(
      _registrationKey.currentContext!,
      duration: const Duration(seconds: 1),
      curve: Curves.easeInOut,
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.white,
      body: SingleChildScrollView(
        controller: _scrollController,
        child: Column(
          children: [
            HomeSection(onRegisterClick: _scrollToRegistration),
            const CoursesSection(),
            const ScheduleSection(),
            Container(key: _registrationKey, child: const RegistrationSection()),
            
            // Footer
            Container(
              padding: const EdgeInsets.all(24),
              color: AppColors.primary,
              width: double.infinity,
              child: const Text(
                "© 2026 RAOLAK TECH SCHOOL. All Rights Reserved.",
                textAlign: TextAlign.center,
                style: TextStyle(color: Colors.white54, fontSize: 14),
              ),
            ),
          ],
        ),
      ),
    );
  }
}
