import 'dart:io';

import 'package:flutter/material.dart';
import 'package:image_picker/image_picker.dart';
import 'package:provider/provider.dart';

import '../services/api_exception.dart';
import '../services/api_service.dart';

class VerifyDocumentScreen extends StatefulWidget {
  const VerifyDocumentScreen({super.key});

  @override
  State<VerifyDocumentScreen> createState() => _VerifyDocumentScreenState();
}

class _VerifyDocumentScreenState extends State<VerifyDocumentScreen> {
  final picker = ImagePicker();
  File? image;
  bool loading = false;
  String? result;

  Future<void> pick(ImageSource source) async {
    final picked = await picker.pickImage(source: source, imageQuality: 85);
    if (picked == null) return;
    setState(() {
      image = File(picked.path);
      result = null;
    });
  }

  Future<void> upload() async {
    if (image == null) return;
    setState(() => loading = true);
    try {
      final data = await context.read<ApiService>().verifyDocument(image!);
      result =
          data['message'] as String? ??
          data['reason'] as String? ??
          'Dokumen berhasil diperiksa.';
    } on ApiException catch (exception) {
      result = exception.message;
    } finally {
      if (mounted) setState(() => loading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Verifikasi Surat PKL')),
      body: ListView(
        padding: const EdgeInsets.all(20),
        children: [
          Text(
            'Pilih foto surat izin PKL yang jelas.',
            style: Theme.of(context).textTheme.titleMedium,
          ),
          const SizedBox(height: 16),
          if (image != null)
            ClipRRect(
              borderRadius: BorderRadius.circular(16),
              child: Image.file(image!, height: 280, fit: BoxFit.cover),
            )
          else
            Container(
              height: 220,
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(16),
              ),
              child: const Icon(Icons.image_search, size: 64),
            ),
          const SizedBox(height: 16),
          Row(
            children: [
              Expanded(
                child: OutlinedButton.icon(
                  onPressed: () => pick(ImageSource.camera),
                  icon: const Icon(Icons.camera_alt),
                  label: const Text('Kamera'),
                ),
              ),
              const SizedBox(width: 10),
              Expanded(
                child: OutlinedButton.icon(
                  onPressed: () => pick(ImageSource.gallery),
                  icon: const Icon(Icons.photo_library),
                  label: const Text('Galeri'),
                ),
              ),
            ],
          ),
          const SizedBox(height: 12),
          FilledButton.icon(
            onPressed: image == null || loading ? null : upload,
            icon: loading
                ? const SizedBox.square(
                    dimension: 18,
                    child: CircularProgressIndicator(strokeWidth: 2),
                  )
                : const Icon(Icons.cloud_upload),
            label: const Text('Verifikasi dokumen'),
          ),
          if (result != null) ...[
            const SizedBox(height: 18),
            Card(
              child: Padding(
                padding: const EdgeInsets.all(16),
                child: Text(result!),
              ),
            ),
          ],
        ],
      ),
    );
  }
}
