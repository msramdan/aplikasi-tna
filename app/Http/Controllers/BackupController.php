<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BackupController extends Controller
{

    public function index()
    {
        return view('backup-database.index');
    }

    public function downloadBackup()
    {
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $filename = Carbon::now()->format('Y-m-d_H-i-s') . '.sql';
        $filePath = storage_path('app/backups/' . $filename);

        // Pastikan direktori backup ada
        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0777, true);
        }

        // Perintah untuk melakukan backup database
        $command = "mysqldump --user={$username} --password={$password} --host={$host} {$database} > {$filePath}";

        $returnVar = null;
        $output = null;

        // Jalankan perintah
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            return response()->json(['error' => 'Failed to backup the database.'], 500);
        }

        // Mengirim file sebagai response download
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
