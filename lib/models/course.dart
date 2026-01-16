class Course {
  final String title;
  final String description;
  final List<String> technologies;
  final String laptopSpecs;

  Course({
    required this.title,
    required this.description,
    required this.technologies,
    required this.laptopSpecs,
  });
}

class CourseData {
  static List<Course> courses = [
    Course(
      title: "Front-end Development",
      description: "Build beautiful and interactive user interfaces for the web.",
      technologies: ["HTML", "CSS", "JavaScript", "Flutter"],
      laptopSpecs: "Minimum 4GB RAM, 256GB SSD/HDD, Core i3 Processor",
    ),
    Course(
      title: "Backend Development",
      description: "Power applications with robust server-side logic and databases.",
      technologies: ["PHP", "Laravel", "Python", "Django"],
      laptopSpecs: "Minimum 4GB RAM, 256GB SSD/HDD, Core i3 Processor",
    ),
    Course(
      title: "Mobile Development",
      description: "Create native apps for Android and iOS devices.",
      technologies: ["Flutter", "Dart"],
      laptopSpecs: "Minimum 8GB RAM, 500GB SSD/HDD, Core i5 Processor (Mac preferred)",
    ),
    Course(
      title: "AI & Vibe Coding",
      description: "Master the art of AI prompting and modern coding techniques.",
      technologies: ["AI Prompting", "Vibe Coding"],
      laptopSpecs: "Standard Machine capable of web browsing",
    ),
    Course(
      title: "Graphics Design",
      description: "Master Visual Fundamentals, Typography, Branding, Identity Design, and Portfolio Development.",
      technologies: ["Photoshop", "Illustrator", "Lightroom", "Figma"],
      laptopSpecs: "Core i5, 16GB RAM, 512GB SSD/HDD, Dedicated GPU",
    ),
  ];
}
