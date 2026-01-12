import 'package:flutter/material.dart';
import '../constants/app_colors.dart';
import '../models/course.dart';
import '../widgets/section_header.dart';
import '../widgets/course_card.dart';

class CoursesSection extends StatelessWidget {
  const CoursesSection({super.key});

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      color: AppColors.background,
      padding: const EdgeInsets.symmetric(vertical: 80, horizontal: 24),
      child: Column(
        children: [
          const SectionHeader(
            title: "Available Courses",
            subtitle: "Choose your path in tech",
            isLight: false,
          ),
          Wrap(
            alignment: WrapAlignment.center,
            spacing: 24,
            runSpacing: 24,
            children: CourseData.courses
                .map((course) => CourseCard(course: course))
                .toList(),
          ),
        ],
      ),
    );
  }
}
