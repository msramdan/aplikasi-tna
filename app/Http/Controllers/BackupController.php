<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class BackupController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:backup database view')->only('index', 'downloadBackup');
    }

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

        // Ensure the backup directory exists
        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0777, true);
        }

        // Command to backup the database
        $command = "mysqldump --user={$username} --password={$password} --host={$host} {$database} > {$filePath}";

        $returnVar = null;
        $output = null;

        // Execute the command
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            return response()->json(['error' => 'Gagal mencadangkan basis data.'], 500);
        }

        // Get the authenticated user
        $user = auth()->user();

        $attributes = [
            'file_name' => $filename,
            'tanggal' => date('Y-m-d H:i:s'),
        ];

        // Log activity
        activity('log_backup_database')
            ->performedOn($user) // Assuming you want to associate the activity with the user model
            ->causedBy($user)
            ->event('Backup database')
            ->withProperties(['attributes' => $attributes])
            ->log("User {$user->name} melakukan backup database");

        // Send the file as a download response
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
