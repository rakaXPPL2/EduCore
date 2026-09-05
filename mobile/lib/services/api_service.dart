import 'dart:async';
import 'dart:convert';
import 'dart:io';

import 'package:flutter_secure_storage/flutter_secure_storage.dart';
import 'package:http/http.dart' as http;

import '../models/user.dart';
import 'api_exception.dart';

class ApiService {
  ApiService({http.Client? client, FlutterSecureStorage? storage})
    : _client = client ?? http.Client(),
      _storage = storage ?? const FlutterSecureStorage();

  static const baseUrl = String.fromEnvironment(
    'EDUCORE_API_URL',
    defaultValue: 'http://10.0.2.2:8000/api',
  );
  final http.Client _client;
  final FlutterSecureStorage _storage;

  Future<Map<String, dynamic>> login(String email, String password) async {
    late final http.Response response;
    try {
      response = await _client
          .post(
            Uri.parse('$baseUrl/login'),
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
            },
            body: jsonEncode({
              'email': email,
              'password': password,
              'role': 'student',
            }),
          )
          .timeout(const Duration(seconds: 10));
    } on TimeoutException {
      throw const ApiException('Koneksi ke server terlalu lama. Periksa Wi-Fi dan alamat API.');
    } on SocketException {
      throw const ApiException('Server tidak dapat dijangkau dari perangkat ini.');
    }
    final data = _decode(response);
    final token = data['token'] as String?;
    if (token == null || token.isEmpty) {
      throw const ApiException('Token login tidak diterima.');
    }
    await _storage.write(key: 'auth_token', value: token);
    return data;
  }

  Future<User> currentUser() async {
    final data = await _request('GET', '/user');
    return User.fromJson(data['user'] as Map<String, dynamic>);
  }

  Future<String> chat(String message) async {
    final data = await _request('POST', '/chat', body: {'message': message});
    return data['reply'] as String? ?? 'AI belum mengirim jawaban.';
  }

  Future<Map<String, dynamic>> verifyDocument(File file) async {
    final token = await _storage.read(key: 'auth_token');
    final request =
        http.MultipartRequest('POST', Uri.parse('$baseUrl/verify-doc'))
          ..headers['Accept'] = 'application/json'
          ..headers['Authorization'] = 'Bearer $token'
          ..files.add(await http.MultipartFile.fromPath('image', file.path));
    final response = await http.Response.fromStream(await request.send());
    return _decode(response);
  }

  Future<void> logout() => _storage.delete(key: 'auth_token');

  Future<Map<String, dynamic>> _request(
    String method,
    String path, {
    Map<String, dynamic>? body,
  }) async {
    final token = await _storage.read(key: 'auth_token');
    final headers = {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      if (token != null) 'Authorization': 'Bearer $token',
    };
    final uri = Uri.parse('$baseUrl$path');
    final response = method == 'GET'
        ? await _client.get(uri, headers: headers)
        : await _client.post(uri, headers: headers, body: jsonEncode(body));
    return _decode(response);
  }

  Map<String, dynamic> _decode(http.Response response) {
    final decoded = jsonDecode(response.body);
    final data = decoded is Map<String, dynamic>
        ? decoded
        : <String, dynamic>{};
    if (response.statusCode < 200 || response.statusCode >= 300) {
      throw ApiException(
        data['message'] as String? ??
            'Permintaan gagal (${response.statusCode}).',
      );
    }
    return data;
  }
}
