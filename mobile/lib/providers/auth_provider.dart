import 'package:flutter/foundation.dart';

import '../models/user.dart';
import '../services/api_service.dart';

class AuthProvider extends ChangeNotifier {
  AuthProvider(this.api);

  final ApiService api;
  User? user;
  bool isLoading = false;
  String? error;

  Future<bool> login(String email, String password) async {
    isLoading = true;
    error = null;
    notifyListeners();
    try {
      final data = await api.login(email, password);
      user = User.fromJson(data['user'] as Map<String, dynamic>);
      return true;
    } catch (exception) {
      error = exception.toString().replaceFirst('ApiException: ', '');
      return false;
    } finally {
      isLoading = false;
      notifyListeners();
    }
  }

  Future<void> logout() async {
    await api.logout();
    user = null;
    notifyListeners();
  }
}
