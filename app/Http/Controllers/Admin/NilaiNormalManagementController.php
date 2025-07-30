<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NilaiNormal;
use Illuminate\Http\Request;

class NilaiNormalManagementController extends Controller
{
    public function index()
    {
        $nilaiNormals = NilaiNormal::orderBy('updated_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.nilai_normal.index', compact('nilaiNormals'));
    }

    public function create()
    {
        return view('admin.nilai_normal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'test_name' => 'required|string|max:100',
            'parameter' => 'required|string|max:100',
            'unit' => 'required|string|max:20',
            'normal_min' => 'nullable|numeric',
            'normal_max' => 'nullable|numeric',
            'gender' => 'nullable|in:L,P',
            'age_min' => 'required|integer|min:0',
            'age_max' => 'required|integer|min:0',
            'notes' => 'nullable|string',
            'referensi' => 'required|string|max:100'
        ]);

        NilaiNormal::create($request->all());

        return redirect()->route('admin.nilai-normal.index')
            ->with('success', 'Nilai normal berhasil ditambahkan.');
    }

    public function show(NilaiNormal $nilaiNormal)
    {
        return view('admin.nilai_normal.show', compact('nilaiNormal'));
    }

    public function edit(NilaiNormal $nilaiNormal)
    {
        return view('admin.nilai_normal.edit', compact('nilaiNormal'));
    }

    public function update(Request $request, NilaiNormal $nilaiNormal)
    {
        $request->validate([
            'test_name' => 'required|string|max:100',
            'parameter' => 'required|string|max:100',
            'unit' => 'required|string|max:20',
            'normal_min' => 'nullable|numeric',
            'normal_max' => 'nullable|numeric',
            'gender' => 'nullable|in:L,P',
            'age_min' => 'required|integer|min:0',
            'age_max' => 'required|integer|min:0',
            'notes' => 'nullable|string',
            'referensi' => 'required|string|max:100'
        ]);

        $nilaiNormal->update($request->all());

        return redirect()->route('admin.nilai-normal.index')
            ->with('success', 'Nilai normal berhasil diperbarui.');
    }

    public function destroy(NilaiNormal $nilaiNormal)
    {
        $nilaiNormal->delete();

        return redirect()->route('admin.nilai-normal.index')
            ->with('success', 'Nilai normal berhasil dihapus.');
    }
}
