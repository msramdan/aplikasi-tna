<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


class ConfigStepReview extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:config step review view')->only('index');
        $this->middleware('permission:config step review edit')->only('update');
    }

    public function index()
    {
        $users = DB::table('users')->get();
        $configSteps = DB::table('config_step_review')->get();
        $steps = [
            'Biro SDM',
            'Tim Unit Pengelola Pembelajaran',
            'Penjaminan Mutu',
            'Subkoordinator',
            'Koordinator',
            'Kepala Unit Pengelola Pembelajaran'
        ];

        // Create a mapping of steps to their assigned users
        $stepReviewers = [];
        foreach ($configSteps as $configStep) {
            $stepReviewers[$configStep->remark][] = $configStep->user_review_id;
        }

        return view('config-step-review.edit', compact('users', 'steps', 'stepReviewers'));
    }

    public function submitForm(Request $request)
    {
        $steps = [
            'Biro SDM',
            'Tim Unit Pengelola Pembelajaran',
            'Penjaminan Mutu',
            'Subkoordinator',
            'Koordinator',
            'Kepala Unit Pengelola Pembelajaran'
        ];

        foreach ($steps as $index => $remark) {
            $reviewerKey = "reviewer_" . ($index + 1);
            $newUserIds = $request->input($reviewerKey, []);

            // Get existing user IDs for this remark
            $existingUserIds = DB::table('config_step_review')
                ->where('remark', $remark)
                ->pluck('user_review_id')
                ->toArray();

            // Determine which user IDs to add
            $userIdsToAdd = array_diff($newUserIds, $existingUserIds);

            // Determine which user IDs to remove
            $userIdsToRemove = array_diff($existingUserIds, $newUserIds);

            // Insert new user IDs
            foreach ($userIdsToAdd as $userId) {
                DB::table('config_step_review')->insert([
                    'remark' => $remark,
                    'user_review_id' => $userId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // Log the addition activity
                activity()
                    ->useLog('log_config_step_review')
                    ->causedBy(auth()->user())
                    ->withProperties(['remark' => $remark, 'user_review_id' => $userId])
                    ->log("User ID {$userId} ditambahkan ke config review {$remark}");
            }

            // Remove user IDs that are no longer selected
            foreach ($userIdsToRemove as $userId) {
                DB::table('config_step_review')
                    ->where('remark', $remark)
                    ->where('user_review_id', $userId)
                    ->delete();

                // Log the removal activity
                activity()
                    ->useLog('log_config_step_review')
                    ->causedBy(auth()->user())
                    ->withProperties(['remark' => $remark, 'user_review_id' => $userId])
                    ->log("User ID {$userId} dihapus dari config review {$remark}");
            }
        }

        Alert::toast('Config review berhasil diupdate', 'success');
        return redirect()->back();
    }
}
