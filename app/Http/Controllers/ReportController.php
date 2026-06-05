<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    public function index(): Response
    {
        $now = Carbon::now();

        // 12 months of sign-ups.
        $months = collect(range(11, 0))->map(function (int $ago) use ($now) {
            $month = $now->copy()->subMonthsNoOverflow($ago);

            return [
                'label' => $month->format('M'),
                'count' => User::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)
                    ->count(),
            ];
        });

        // Users per role (for the distribution chart).
        $roles = Role::withCount('users')->orderByDesc('users_count')->get();

        $total = User::count();
        $verified = User::whereNotNull('email_verified_at')->count();

        return Inertia::render('Reports/Index', [
            'kpis' => [
                'total' => $total,
                'verified' => $verified,
                'verifiedRate' => $total ? round($verified / $total * 100, 1) : 0,
                'roles' => $roles->count(),
                'last30' => User::where('created_at', '>=', $now->copy()->subDays(30))->count(),
            ],
            'signups' => [
                'labels' => $months->pluck('label'),
                'data' => $months->pluck('count'),
            ],
            'roleDistribution' => [
                'labels' => $roles->pluck('name'),
                'data' => $roles->pluck('users_count'),
            ],
            'verification' => [
                'verified' => $verified,
                'unverified' => $total - $verified,
            ],
        ]);
    }
}
