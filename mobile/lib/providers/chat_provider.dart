import 'package:flutter/foundation.dart';

import '../models/chat_message.dart';
import '../services/api_service.dart';

class ChatProvider extends ChangeNotifier {
  ChatProvider(this.api);

  final ApiService api;
  final messages = <ChatMessage>[];
  bool isLoading = false;
  String? error;

  Future<void> send(String text) async {
    final message = text.trim();
    if (message.isEmpty || isLoading) return;
    messages.add(ChatMessage(text: message, isUser: true));
    isLoading = true;
    error = null;
    notifyListeners();
    try {
      final reply = await api.chat(message);
      messages.add(ChatMessage(text: reply, isUser: false));
    } catch (exception) {
      error = exception.toString().replaceFirst('ApiException: ', '');
      messages.add(
        const ChatMessage(
          text: 'Maaf, AI sedang tidak tersedia. Coba lagi sebentar.',
          isUser: false,
        ),
      );
    } finally {
      isLoading = false;
      notifyListeners();
    }
  }
}
