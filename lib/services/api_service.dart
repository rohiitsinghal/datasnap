import 'dart:convert';
import 'package:http/http.dart' as http;
import '../models/user_model.dart';

class ApiService {
  static const String baseUrl = 'http://datasnap.rf.gd/backend'; // For Android emulator
  // static const String baseUrl = 'http://192.168.29.67/datasnap/backend'; // For iOS simulator

  static Future<Map<String, dynamic>> submitForm(UserSubmission submission) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/api.php'),
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode(submission.toJson()),
      );

      // Debug logging - remove after fixing
      print('POST Response status: ${response.statusCode}');
      print('POST Response body: ${response.body}');

      if (response.statusCode == 200) {
        final responseData = jsonDecode(response.body);
        return responseData;
      } else {
        return {'error': 'Server error: ${response.statusCode}'};
      }
    } catch (e) {
      print('POST Exception: $e');
      return {'error': 'Network error: $e'};
    }
  }

  static Future<List<UserSubmission>> getSubmissions() async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/api.php'),
        headers: {'Content-Type': 'application/json'},
      );

      // Debug logging - remove after fixing
      print('GET Response status: ${response.statusCode}');
      print('GET Response body: ${response.body}');

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
      print('GET Exception: $e');
      throw Exception('Network error: $e');
    }
  }
}
