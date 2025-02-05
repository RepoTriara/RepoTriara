<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TblFile;
use App\Models\TblDownload;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function getStatistics(Request $request)
    {
        $days = $request->input('days', 15);
        $startDate = now()->subDays($days)->format('Y-m-d');

        // 📌 Subidos por clientes (level = 0)
        $uploadedByClients = TblFile::whereHas('uploaderUser', function ($query) {
            $query->where('level', 0);  // Filtramos por clientes
        })
        ->whereDate('timestamp', '>=', $startDate)
        ->selectRaw('DATE(timestamp) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // 📌 Subidos por Administradores de Sistema (level = 8)
        $uploadedByAdminsSystem = TblFile::whereHas('uploaderUser', function ($query) {
            $query->where('level', 8);  // Filtramos por administradores de sistema
        })
        ->whereDate('timestamp', '>=', $startDate)
        ->selectRaw('DATE(timestamp) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // 📌 Subidos por Administradores de Accesos (level = 10)
        $uploadedByAdminsAccess = TblFile::whereHas('uploaderUser', function ($query) {
            $query->where('level', 10);  // Filtramos por administradores de accesos
        })
        ->whereDate('timestamp', '>=', $startDate)
        ->selectRaw('DATE(timestamp) as date, COUNT(*) as count')
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        // 📌 Descargas totales
        $downloads = TblDownload::whereDate('timestamp', '>=', $startDate)
            ->selectRaw('DATE(timestamp) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // 📌 Descargas públicas (anónimas)
        $publicDownloads = TblDownload::where('anonymous', true)
            ->whereDate('timestamp', '>=', $startDate)
            ->selectRaw('DATE(timestamp) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return response()->json([
            'uploadedByClients' => $uploadedByClients,
            'uploadedByAdminsSystem' => $uploadedByAdminsSystem,
            'uploadedByAdminsAccess' => $uploadedByAdminsAccess,
            'downloads' => $downloads,
            'publicDownloads' => $publicDownloads,
        ]);
    }

}
