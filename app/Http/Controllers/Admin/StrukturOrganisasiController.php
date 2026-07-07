<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $strukturs = StrukturOrganisasi::orderBy('urutan')->get();
        return view('admin.struktur-organisasi.index', compact('strukturs'));
    }

    public function create()
    {
        return view('admin.struktur-organisasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'jabatan'  => 'required|string|max:255',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'=> 'nullable|string',
            'urutan'   => 'nullable|integer',
        ]);

        $data = $request->except('foto');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/struktur', $filename);
            $data['foto'] = $filename;
        }

        StrukturOrganisasi::create($data);

        return redirect()->route('admin.struktur-organisasi.index')
                         ->with('success', 'Data pengurus berhasil ditambahkan.');
    }

    public function edit(StrukturOrganisasi $struktur_organisasi)
    {
        return view('admin.struktur-organisasi.edit', compact('struktur_organisasi'));
    }

    public function update(Request $request, StrukturOrganisasi $struktur_organisasi)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'jabatan'  => 'required|string|max:255',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'deskripsi'=> 'nullable|string',
            'urutan'   => 'nullable|integer',
        ]);

        $data = $request->except('foto');
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('foto')) {
            if ($struktur_organisasi->foto) {
                Storage::delete('public/struktur/' . $struktur_organisasi->foto);
            }
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/struktur', $filename);
            $data['foto'] = $filename;
        }

        $struktur_organisasi->update($data);

        return redirect()->route('admin.struktur-organisasi.index')
                         ->with('success', 'Data pengurus berhasil diperbarui.');
    }

    public function destroy(StrukturOrganisasi $struktur_organisasi)
    {
        if ($struktur_organisasi->foto) {
            Storage::delete('public/struktur/' . $struktur_organisasi->foto);
        }
        $struktur_organisasi->delete();

        return redirect()->route('admin.struktur-organisasi.index')
                         ->with('success', 'Data pengurus berhasil dihapus.');
    }
}
