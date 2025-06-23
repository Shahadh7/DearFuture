<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CapsuleController;
use App\Models\Capsule;
use App\Models\DeliveryLog;
use Illuminate\Http\Request;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function (Request $request) {
    $userId = $request->user()->id;
    
    $stats = [
        'total' => Capsule::where('user_id', $userId)->count(),
        'locked' => Capsule::where('user_id', $userId)->where('status', 'locked')->count(),
        'unlocked' => Capsule::where('user_id', $userId)->where('status', 'delivered')->count(),
        'drafts' => Capsule::where('user_id', $userId)->where('status', 'draft')->count(),
        'delivered_today' => DeliveryLog::where('user_id', $userId)
            ->where('status', 'delivered')
            ->whereDate('delivery_date', today())
            ->count(),
        'delivered_this_week' => DeliveryLog::where('user_id', $userId)
            ->where('status', 'delivered')
            ->whereBetween('delivery_date', [now()->startOfWeek(), now()->endOfWeek()])
            ->count(),
        'failed_deliveries' => DeliveryLog::where('user_id', $userId)
            ->where('status', 'failed')
            ->count(),
    ];

    $recentActivity = DeliveryLog::with(['capsule'])
        ->where('user_id', $userId)
        ->orderBy('delivery_date', 'desc')
        ->limit(5)
        ->get()
        ->map(function ($log) {
            return [
                'id' => $log->id,
                'type' => $log->status === 'delivered' ? 'delivery' : 'failed_delivery',
                'title' => $log->status === 'delivered' 
                    ? "Capsule '{$log->capsule->title}' delivered" 
                    : "Failed to deliver '{$log->capsule->title}'",
                'description' => $log->notes,
                'date' => $log->delivery_date->diffForHumans(),
                'status' => $log->status,
                'capsule_title' => $log->capsule->title,
            ];
        });

    return Inertia::render('Dashboard', [
        'stats' => $stats,
        'recentActivity' => $recentActivity,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::resource('capsules', CapsuleController::class);
    Route::delete('capsules/{capsule}/attachments/{media}', [CapsuleController::class, 'removeAttachment'])
        ->name('capsules.attachments.destroy');
});

Route::get('/capsules/unlock/{token}', [CapsuleController::class, 'unlock'])
    ->name('capsules.unlock');

require __DIR__.'/auth.php';
