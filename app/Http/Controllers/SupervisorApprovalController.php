<?php

namespace App\Http\Controllers;

use App\Models\SupervisorApproval;
use App\Models\Requisition;
use App\Http\Requests\StoreSupervisorApprovalRequest;
use App\Http\Requests\UpdateSupervisorApprovalRequest;
use App\Enums\RequisitionStatus;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\RequisitionUrgency;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;








class SupervisorApprovalController extends Controller
{
    use AuthorizesRequests; 
     


public function approve(Request $request, Requisition $requisition)
{
    $this->authorize('approve', $requisition);
    
    $currentStage = $requisition->status->value;
    $approvalStatus = null;

    switch ($currentStage) {
        case RequisitionStatus::SUPERVISOR->value:
            $approvalStatus = $requisition->typeOfProduct === 'fuel' 
                ? RequisitionStatus::ADMINISTRATION->value
                : RequisitionStatus::PROCUREMENT->value;
            break;
        case RequisitionStatus::PROCUREMENT->value:
            $approvalStatus = RequisitionStatus::FINANCE->value;
            break;
        case RequisitionStatus::ADMINISTRATION->value:
            $approvalStatus = $requisition->typeOfProduct === 'fuel' 
                ? RequisitionStatus::FULFILLED->value
                : RequisitionStatus::FINANCE->value;
            break;
        case RequisitionStatus::FINANCE->value:
            $approvalStatus = RequisitionStatus::FULFILLED->value;
            break;
        default:
            throw new \Exception("Invalid status");
    }

    $requisition->update(['status' => $approvalStatus]);

    SupervisorApproval::create([
        'comments' => $request->comments,
        'approver_id' => Auth::id(),
        'user_id' => $requisition->user_id,
        'requisition_id' => $requisition->id,
        'department_id' => $requisition->department_id,
        'status' => $approvalStatus, 
        'stage' => $currentStage 
    ]);

    return redirect()->back();
}

public function reject(Request $request, Requisition $requisition)
{
    $this->authorize('approve', $requisition);

    $currentStage = $requisition->status->value;

    SupervisorApproval::create([
        'comments' => $request->comments,
        'approver_id' => Auth::id(),
        'user_id' => $requisition->user_id,
        'requisition_id' => $requisition->id,
        'department_id' => $requisition->department_id,
        'status' => 'rejected',
        'stage' => $currentStage // Ensure stage is always set
    ]);

    return redirect()->back();
}


























    public function track(SupervisorApproval $supervisorApproval)
    {
       
       


        $supervisorApproval = SupervisorApproval::with('requisition')->get();

        return Inertia::render('Approval/Show', [
            'supervisorApproval' => $supervisorApproval,
        ]);
    
    }
 
    public function update(UpdateSupervisorApprovalRequest $request, SupervisorApproval $supervisorApproval)
    {
        
    }

    
    public function destroy(SupervisorApproval $supervisorApproval)
    {
        
    }
}
