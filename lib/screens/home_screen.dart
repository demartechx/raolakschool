import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../sections/home_section.dart';
import '../sections/courses_section.dart';
import '../sections/schedule_section.dart';
import 'package:url_launcher/url_launcher.dart';

class HomeScreen extends StatelessWidget {
  HomeScreen({super.key});

  final ScrollController _scrollController = ScrollController();
  final GlobalKey _coursesKey = GlobalKey();
  final GlobalKey _scheduleKey = GlobalKey();


  void _scrollToSection(GlobalKey key) {
    Scrollable.ensureVisible(
      key.currentContext!,
      duration: const Duration(seconds: 1),
      curve: Curves.easeInOut,
    );
  }

  Future<void> _launchRegister() async {
    final Uri url = Uri.parse('https://school.raolak.com/portal/public/enroll');
    if (!await launchUrl(url)) {
      debugPrint("Could not launch $url");
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppColors.white,
      body: SingleChildScrollView(
        controller: _scrollController,
        child: Column(
          children: [
            HomeSection(
              onRegisterClick: _launchRegister,
              onCoursesClick: () => _scrollToSection(_coursesKey),
              onScheduleClick: () => _scrollToSection(_scheduleKey),
            ),
            Container(key: _coursesKey, child: const CoursesSection()),
            Container(key: _scheduleKey, child: const ScheduleSection()),

            
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
