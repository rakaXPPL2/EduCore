<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\LokerPkl;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LokerPklController extends Controller
{
    /**
     * Display a listing of lowongan PKL.
     */
    public function index(): View
    {
        $lokerPkls = LokerPkl::latest()->get();

        return view('loker-pkl', [
            'title' => 'Lowongan PKL - SMKN 1 Garut',
            'lokerPkls' => $lokerPkls,
        ]);
    }

    /**
     * Store a newly created loker PKL.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'caption' => 'required|string|max:1000',
            'hasil_analisis' => 'nullable|array',
            'rekomendasi_jurusan' => 'nullable|array',
        ]);

        $lokerPkl = LokerPkl::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lowongan PKL berhasil ditambahkan',
            'data' => $lokerPkl,
        ], 201);
    }

    /**
     * Display the specified loker PKL.
     */
    public function show(LokerPkl $lokerPkl): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $lokerPkl,
        ]);
    }

    /**
     * Update the specified loker PKL.
     */
    public function update(Request $request, LokerPkl $lokerPkl): JsonResponse
    {
        $validated = $request->validate([
            'caption' => 'sometimes|required|string|max:1000',
            'hasil_analisis' => 'nullable|array',
            'rekomendasi_jurusan' => 'nullable|array',
        ]);

        $lokerPkl->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Lowongan PKL berhasil diperbarui',
            'data' => $lokerPkl,
        ]);
    }

    /**
     * Remove the specified loker PKL.
     */
    public function destroy(LokerPkl $lokerPkl): JsonResponse
    {
        $lokerPkl->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lowongan PKL berhasil dihapus',
        ]);
    }
}
