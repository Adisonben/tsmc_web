<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginHistory;
use App\Models\WorkRecord;
use App\Models\Vehicle;
use App\Models\VehicleAssignment;
use App\Models\RepairHistory;
use App\Models\LogBook;
use App\Models\FormSubmissions;
use App\Models\Form;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // For organization filtering if necessary
        $orgId = Auth::user()->is_tsm ? session('connected_org') : Auth::user()->userDetail->org;

        $today = Carbon::today();
        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();

        // 1. User Login Today
        $loginsToday = LoginHistory::whereHas('getUser.userDetail', function ($q) use ($orgId) {
            if ($orgId)
                $q->where('org', $orgId);
        })->whereDate('created_at', $today)
            ->distinct('user_id')
            ->count('user_id');

        // 2. Active Workforce
        $totalUsers = User::whereHas('userDetail', function ($q) use ($orgId) {
            if ($orgId)
                $q->where('org', $orgId);
        })->count();

        $activeWorkers = WorkRecord::whereHas('getUser.userDetail', function ($q) use ($orgId) {
            if ($orgId)
                $q->where('org', $orgId);
        })->whereNull('end_at')->count();

        // 3. Fleet Utilization
        $totalVehicles = Vehicle::when($orgId, function ($q) use ($orgId) {
            return $q->where('org_id', $orgId);
        })->count();

        $activeVehicles = VehicleAssignment::whereHas('getVehicle', function ($q) use ($orgId) {
            if ($orgId)
                $q->where('org_id', $orgId);
        })->count();

        // 4. Completed Vehicle Repairs (This Month)
        $completedRepairs = RepairHistory::when($orgId, function ($q) use ($orgId) {
            return $q->where('org_id', $orgId);
        })->whereMonth('repair_date', Carbon::now()->month)->count();

        // 5. Log Book Success / Total
        $totalLogBooks = LogBook::when($orgId, function ($q) use ($orgId) {
            return $q->where('org_id', $orgId);
        })->count();

        $successLogBooks = LogBook::when($orgId, function ($q) use ($orgId) {
            return $q->where('org_id', $orgId);
        })->withCount('entries')->get()->where('entries_count', 112)->count();

        $logBooks = LogBook::when($orgId, function ($q) use ($orgId) {
            return $q->where('org_id', $orgId);
        })->with(['kmSchedules', 'monthSchedules'])->latest()->take(5)->get();

        // 6. Pending Form Submissions Today
        $formsToday = FormSubmissions::when($orgId, function ($q) use ($orgId) {
            return $q->where('org', $orgId);
        })->whereDate('created_at', $today)->count();

        // --- Chart Data ---
        // Chart 1: Check-ins Last 7 Days
        $checkinsData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $count = WorkRecord::whereHas('getUser.userDetail', function ($q) use ($orgId) {
                if ($orgId)
                    $q->where('org', $orgId);
            })->whereDate('created_at', $date)->count();
            $checkinsData['labels'][] = $date->format('D, d M');
            $checkinsData['data'][] = $count;
        }

        // Chart 2: Forms by Category (Mocked structure for view)
        $formsByCategory = FormSubmissions::when($orgId, function ($q) use ($orgId) {
            return $q->where('org', $orgId);
        })->selectRaw('form_id, count(*) as count')
            ->groupBy('form_id')
            ->with('getForm.formCategory')
            ->take(5)->get();

        // --- Recent Activity Feeds ---
        // A. Recent Work Records
        $recentWorkRecords = WorkRecord::whereHas('getUser.userDetail', function ($q) use ($orgId) {
            if ($orgId)
                $q->where('org', $orgId);
        })->with('getUser.userDetail')->latest()->take(5)->get();

        // B. Recent Submissions
        $recentSubmissions = FormSubmissions::when($orgId, function ($q) use ($orgId) {
            return $q->where('org', $orgId);
        })->with(['getUser', 'getForm'])->latest()->take(5)->get();

        // C. Latest Posts
        $recentPosts = \App\Models\Post::whereHas('getUser', function ($q) use ($orgId) {
            if ($orgId)
                $q->where('org', $orgId);
        })->latest()->take(5)->get();

        // D. Performance Reports Exports Count for This Month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $performanceReportsThisMonth = Form::where('is_sub_form', false)
        ->where(function ($query) use ($orgId) {
            if ($orgId) {
                $query->where('org', $orgId)->orWhere('is_default', true);
            } else {
                $query->where('is_default', true);
            }
        })
        ->withCount(['exportPerformanceReports as monthly_exports_count' => function ($query) use ($orgId, $startOfMonth, $endOfMonth) {
            $query->where('org', $orgId)
                  ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        }])
        ->get();

        return view('dashboard.index', compact(
            'loginsToday',
            'activeWorkers',
            'totalUsers',
            'activeVehicles',
            'totalVehicles',
            'completedRepairs',
            'successLogBooks',
            'totalLogBooks',
            'formsToday',
            'logBooks',
            'checkinsData',
            'formsByCategory',
            'recentWorkRecords',
            'recentSubmissions',
            'recentPosts',
            'performanceReportsThisMonth'
        ));
    }
}
