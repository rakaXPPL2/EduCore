class User {
  const User({
    required this.id,
    required this.name,
    required this.email,
    required this.role,
    this.studentClass,
    this.teacherSubject,
  });

  final int id;
  final String name;
  final String email;
  final String role;
  final String? studentClass;
  final String? teacherSubject;

  factory User.fromJson(Map<String, dynamic> json) => User(
    id: (json['id'] as num?)?.toInt() ?? 0,
    name: json['name'] as String? ?? 'Siswa EduCore',
    email: json['email'] as String? ?? '',
    role: json['role'] as String? ?? 'student',
    studentClass: json['student_class'] as String?,
    teacherSubject: json['teacher_subject'] as String?,
  );
}
