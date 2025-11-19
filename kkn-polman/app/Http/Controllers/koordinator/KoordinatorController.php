<?php

namespace App\Http\Controllers\koordinator;

use App\Http\Controllers\Controller;
use App\Models\pendaftaraModel;
use Illuminate\Http\Request;

class KoordinatorController extends Controller
{
    public function verifikasiPendaftaran(Request $request)
    {
        $request->validate([
            'nim' => 'required|exists:pendaftaran_kkn,nim',
            'status' => 'required|in:complete,rejected',
        ]);

        pendaftaraModel::where('nim', $request->input('nim'))->update([
            'status' => $request->input('status'),
        ]);

        return redirect()->back()->with('success', 'Pendaftaran berhasil diverifikasi.');
    }

    public function deletePendaftaran(Request $request, $nim)
    {
        pendaftaraModel::where('nim', $nim)->delete();

        return redirect()->back()->with('success', 'Pendaftaran berhasil dihapus.');
    }
}
