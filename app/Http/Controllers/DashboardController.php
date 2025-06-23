<?php

namespace App\Http\Controllers;

use App\Models\Capsule;
use App\Models\DeliveryLog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
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
    }
} 