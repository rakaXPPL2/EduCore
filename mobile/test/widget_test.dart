import 'package:flutter_test/flutter_test.dart';

import 'package:mobile/main.dart';
import 'package:mobile/services/api_service.dart';

void main() {
  testWidgets('EduCore shows the login screen', (tester) async {
    await tester.pumpWidget(EduCoreApp(api: ApiService()));

    expect(find.text('EduCore'), findsOneWidget);
    expect(find.text('Masuk ke EduCore'), findsOneWidget);
  });
}
