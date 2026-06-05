<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonthNoOverflow()->startOfMonth();

        $total = User::count();
        $verified = User::whereNotNull('email_verified_at')->count();
        $newThisMonth = User::where('created_at', '>=', $startOfMonth)->count();
        $newLastMonth = User::whereBetween('created_at', [$startOfLastMonth, $startOfMonth])->count();

        // Build the last 6 months of sign-up counts for the area chart.
        $months = collect(range(5, 0))->map(function (int $ago) use ($now) {
            $month = $now->copy()->subMonthsNoOverflow($ago);

            return [
                'label' => $month->format('M'),
                'count' => User::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
            ];
        });

        return Inertia::render('Dashboard', [
            'stats' => [
                'total' => $total,
                'verified' => $verified,
                'unverified' => $total - $verified,
                'newThisMonth' => $newThisMonth,
                'growth' => $this->percentChange($newLastMonth, $newThisMonth),
            ],
            'signups' => [
                'labels' => $months->pluck('label'),
                'data' => $months->pluck('count'),
            ],
            'recentUsers' => User::latest()->take(5)->get(['id', 'name', 'email', 'created_at']),
        ]);
    }

    private function percentChange(int $previous, int $current): float
    {
        if ($previous === 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }
}
