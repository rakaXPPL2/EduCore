import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import 'providers/auth_provider.dart';
import 'providers/chat_provider.dart';
import 'screens/chat_tutor_screen.dart';
import 'screens/dashboard_screen.dart';
import 'screens/login_screen.dart';
import 'screens/verify_document_screen.dart';
import 'services/api_service.dart';

void main() {
  final api = ApiService();
  runApp(EduCoreApp(api: api));
}

class EduCoreApp extends StatelessWidget {
  const EduCoreApp({super.key, required this.api});

  final ApiService api;

  @override
  Widget build(BuildContext context) => MultiProvider(
    providers: [
      Provider.value(value: api),
      ChangeNotifierProvider(create: (_) => AuthProvider(api)),
      ChangeNotifierProvider(create: (_) => ChatProvider(api)),
    ],
    child: MaterialApp(
      title: 'EduCore',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        useMaterial3: true,
        colorScheme: ColorScheme.fromSeed(seedColor: const Color(0xff3478e5)),
        scaffoldBackgroundColor: const Color(0xfff3f7fd),
        inputDecorationTheme: const InputDecorationTheme(
          filled: true,
          fillColor: Colors.white,
          border: OutlineInputBorder(
            borderSide: BorderSide.none,
            borderRadius: BorderRadius.all(Radius.circular(14)),
          ),
        ),
      ),
      initialRoute: '/login',
      routes: {
        '/login': (_) => const LoginScreen(),
        '/dashboard': (_) => const DashboardScreen(),
        '/chat': (_) => const ChatTutorScreen(),
        '/verify': (_) => const VerifyDocumentScreen(),
      },
    ),
  );
}
