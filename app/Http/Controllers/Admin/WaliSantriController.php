<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WaliSantri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WaliSantriController extends Controller
{
    public function index(Request $request)
    {
        $query = WaliSantri::withCount('santri');
        if ($request->search) {
            $query->where('nama_wali', 'like', '%'.$request->search.'%')
                  ->orWhere('username', 'like', '%'.$request->search.'%');
        }
        $walis = $query->latest()->paginate(10)->withQueryString();
        return view('admin.wali.index', compact('walis'));
    }

    public function create()
    {
        return view('admin.wali.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_wali' => 'required|string|max:255',
            'username'  => 'required|string|max:50|unique:wali_santri,username',
            'password'  => 'required|string|min:6|confirmed',
            'email'     => 'nullable|email|unique:wali_santri,email',
            'no_hp'     => 'required|string|max:20',
        ]);

        WaliSantri::create([
            'nama_wali'      => $request->nama_wali,
            'username'       => $request->username,
            'password'       => Hash::make($request->password),
            'plain_password' => $request->password,
            'email'          => $request->email,
            'no_hp'          => $request->no_hp,
            'alamat'         => $request->alamat,
        ]);

        return redirect()->route('admin.wali.index')
            ->with('success', 'Akun wali santri berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $wali = WaliSantri::findOrFail($id);
        return view('admin.wali.edit', compact('wali'));
    }

    public function update(Request $request, $id)
    {
        $wali = WaliSantri::findOrFail($id);
        $request->validate([
            'nama_wali' => 'required|string|max:255',
            'username'  => 'required|string|max:50|unique:wali_santri,username,'.$id.',id_wali',
            'email'     => 'nullable|email|unique:wali_santri,email,'.$id.',id_wali',
            'no_hp'     => 'required|string|max:20',
        ]);

        $data = $request->only(['nama_wali', 'username', 'email', 'no_hp', 'alamat']);
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $data['password']       = Hash::make($request->password);
            $data['plain_password'] = $request->password;
        } elseif ($wali->no_hp !== $request->no_hp) {
            // Automatically update password to the new phone number
            $data['password']       = Hash::make($request->no_hp);
            $data['plain_password'] = $request->no_hp;
        }

        $wali->update($data);
        return redirect()->route('admin.wali.index')
            ->with('success', 'Akun wali santri berhasil diperbarui!');
    }

    public function destroy($id)
    {
        WaliSantri::findOrFail($id)->delete();
        return redirect()->route('admin.wali.index')
            ->with('success', 'Akun wali santri berhasil dihapus!');
    }
}
