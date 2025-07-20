import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/user_model.dart';

class ApiService {
  static const String baseUrl = 'http://10.0.2.2/mobile_app_assignment/backend'; // For Android emulator
  // Use 'http://localhost/datasnap/backend' for iOS simulator
  

  static Future<Map<String, dynamic>> submitForm(UserSubmission submission) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/api.php'),
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode(submission.toJson()),
      );

      if (response.statusCode == 200) {
        return jsonDecode(response.body);
      } else {
        return {'error': 'Server error: ${response.statusCode}'};
      }
    } catch (e) {
      return {'error': 'Network error: $e'};
    }
  }

  static Future<List<UserSubmission>> getSubmissions() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/api.php'),
        headers: {'Content-Type': 'application/json'},
      );

      if (response.statusCode == 200) {
        final Map<String, dynamic> data = jsonDecode(response.body);
        final List<dynamic> submissionsJson = data['data'] ?? [];
        
        return submissionsJson
            .map((json) => UserSubmission.fromJson(json))
            .toList();
      } else {
        throw Exception('Failed to load submissions');
      }
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }
}
