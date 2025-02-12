<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TblFile;
use App\Models\TblDownload;
use Illuminate\Support\Facades\Log;

class StatisticsController extends Controller
{
    public function getStatistics(Request $request)
    {
        try {
            $days = $request->input('days', 15);
            $startDate = now()->subDays($days)->format('Y-m-d');

            Log::info("Consultando estadísticas desde: " . $startDate);

            $uploadedCounts = TblFile::whereDate('tbl_files.timestamp', '>=', $startDate)
                ->leftJoin('tbl_users', 'tbl_files.uploader', '=', 'tbl_users.user')
                ->selectRaw('DATE(tbl_files.timestamp) as date,
                    SUM(CASE WHEN tbl_users.level = 0 THEN 1 ELSE 0 END) as uploaded_by_clients,
                    SUM(CASE WHEN tbl_users.level = 8 THEN 1 ELSE 0 END) as uploaded_by_admins_system,
                    SUM(CASE WHEN tbl_users.level = 10 THEN 1 ELSE 0 END) as uploaded_by_admins_access')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            Log::info("Resultados de uploadedCounts:", $uploadedCounts->toArray());

            // 3. Consultar las estadísticas de descargas (NO INCLUYE las públicas)
            $downloads = TblDownload::whereDate('timestamp', '>=', $startDate)
                ->where('anonymous', false) // Excluir descargas anónimas (públicas)
                ->selectRaw('DATE(timestamp) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            Log::info("Resultados de downloads (sin publicas):", $downloads->toArray());

            // 4. Consultar las estadísticas de descargas públicas (INCLUYE logueados y deslogueados)
            $publicDownloads = TblDownload::whereDate('timestamp', '>=', $startDate)
                ->where('anonymous', true) // Descargas anónimas (públicas)
                ->selectRaw('DATE(timestamp) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            Log::info("Resultados de publicDownloads:", $publicDownloads->toArray());

            return response()->json([
                'uploadedCounts' => $uploadedCounts,
                'downloads' => $downloads,
                'publicDownloads' => $publicDownloads,
            ]);
        } catch (\Exception $e) {
            Log::error($e);

            if (config('app.debug')) {
                return response()->json(['error' => $e->getMessage()], 500);
            } else {
                return response()->json(['error' => 'Error interno del servidor.'], 500);
            }
        }
    }
}
