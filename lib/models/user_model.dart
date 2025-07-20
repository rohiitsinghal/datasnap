class UserSubmission {
  final String? id;
  final String name;
  final String email;
  final String phone;
  final String dateOfBirth;
  final String gender;
  final String? createdAt;

  UserSubmission({
    this.id,
    required this.name,
    required this.email,
    required this.phone,
    required this.dateOfBirth,
    required this.gender,
    this.createdAt,
  });

  Map<String, dynamic> toJson() {
    return {
      'name': name,
      'email': email,
      'phone': phone,
      'date_of_birth': dateOfBirth,
      'gender': gender,
    };
  }

  factory UserSubmission.fromJson(Map<String, dynamic> json) {
    return UserSubmission(
      id: json['id']?.toString(),
      name: json['name'] ?? '',
      email: json['email'] ?? '',
      phone: json['phone'] ?? '',
      dateOfBirth: json['date_of_birth'] ?? '',
      gender: json['gender'] ?? '',
      createdAt: json['created_at'],
    );
  }
}
