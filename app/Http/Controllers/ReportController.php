<?php

namespace App\Http\Controllers;
use App\Models\Requisition;
use App\Models\SupervisorApproval;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSupervisorApprovalRequest;
use App\Http\Requests\UpdateSupervisorApprovalRequest;
use App\Enums\RequisitionStatus;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use App\Enums\RequisitionUrgency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ReportController extends Controller
{

    public function reports()
    {
        $user = auth()->user();
    
        // Get ALL requisitions the USER CAN ACCESS (department + status-based access)
        $requisitions = Requisition::query()
            ->with(['user.department', 'department'])
            ->when(!$user->isAdmin(), function ($query) use ($user) {
                $department = $user->department;
                $query->where(function ($q) use ($department) {
                    $q->where('department_id', $department->id)
                      ->orWhereIn('status', $department->handles ?? []);
                });
            })
            ->get();
  
        $userStatusCounts = $requisitions
            ->where('user_id', $user->id) 
            ->groupBy('status')
            ->map(fn($group) => $group->count());
    
        
        $departmentStatusCounts = $requisitions
            ->where('department_id', $user->department_id)
            ->groupBy('status')
            ->map(fn($group) => $group->count());

            ////////// Usser Counts///////
            $userRequisitions = $requisitions->where('user_id', $user->id);

            $todayCount = $userRequisitions->where('created_at', '>=', now()->startOfDay())->count();
            $thisWeekCount = $userRequisitions->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
            $currentMonthCount = $userRequisitions->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();
            $currentYearCount = $userRequisitions->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])->count();
        
            // Combine all counts into an array
            $userTimePeriodCounts = [
                'today' => $todayCount,
                'this_week' => $thisWeekCount,
                'current_month' => $currentMonthCount,
                'current_year' => $currentYearCount,
            ];

            /////// Department Counts
            $departmentsRequisitions = $requisitions->where('department_id', $user->department_id);

            $dep_todayCount = $departmentsRequisitions->where('created_at', '>=', now()->startOfDay())->count();
            $dep_thisWeekCount = $departmentsRequisitions->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
            $dep_currentMonthCount = $departmentsRequisitions->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count();
            $dep_currentYearCount = $departmentsRequisitions->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])->count();
        
            // Combine all counts into an array
            $depTimePeriodCounts = [
                'dep_today' =>  $dep_todayCount,
                'dep_this_week' => $dep_thisWeekCount,
                'dep_current_month' => $dep_currentMonthCount,
                'dep_current_year' =>$dep_currentYearCount,
            ];


    
        return Inertia::render('Reports/Index', [
            'userData' => [
                'labels' => $userStatusCounts->keys()->toArray(),
                'datasets' => [[
                    'data' => $userStatusCounts->values()->toArray(),
                    'backgroundColor' => ['#3B82F6', '#10B981', '#F59E0B', '#EF4444']
                ]]
            ],
            'departmentData' => [
                'labels' => $departmentStatusCounts->keys()->toArray(),
                'datasets' => [[
                    'data' => $departmentStatusCounts->values()->toArray(),
                    'backgroundColor' => ['#8B5CF6', '#EC4899', '#6EE7B7']
                ]]
            ],
            'statusLabels' => RequisitionStatus::getLabels(),
            'userTimePeriodCounts' => $userTimePeriodCounts,
            'depTimePeriodCounts' => $depTimePeriodCounts,
        ]);
    }

    public function today(Request $request)
    {
        $user = $request->user();
        $requisitions = Requisition::query()
            ->where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->with(['user.department', 'department']) 
            ->get();

        return Inertia::render('Reports/User/Today', [
            'requisitions' => $requisitions,
        ]);
    }

public function thisWeek(Request $request)
    {
        $user = $request->user();
        $requisitions = Requisition::query()
            ->where('user_id', $user->id)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->with(['user.department', 'department']);

        return Inertia::render('Reports/User/ThisWeek
        ', [
            'requisitions' => $requisitions,
        ]);
    }

    public function thisMonth(Request $request)
    {
        $user = $request->user();
        $requisitions = Requisition::query()
            ->where('user_id', $user->id)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->with(['user.department', 'department']);

        return Inertia::render('Reports/User/ThisMonth.vue
        ', [
            'requisitions' => $requisitions,
        ]);
    }

    public function thisYear(Request $request)
    {
        $user = $request->user();
        $requisitions = Requisition::query()
            ->where('user_id', $user->id)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->with(['user.department', 'department']);

        return Inertia::render('Reports/User/ThisYear.vue
        ', [
            'requisitions' => $requisitions,
        ]);
    }




}

