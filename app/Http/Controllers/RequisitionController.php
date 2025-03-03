<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use App\Http\Requests\StoreRequisitionRequest;
use App\Http\Requests\UpdateRequisitionRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Enums\RequisitionUrgency;
use Illuminate\Support\Facades\Auth;
use App\Enums\RequisitionStatus;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class RequisitionController extends Controller
{
    use AuthorizesRequests;



public function index()
{
    $user = auth()->user();
    
    $requisitions = Requisition::with([
        'user.department',
        'department',
        'supervisorApprovals' => fn($q) => $q->latest()
    ]);

    if (!$user->isAdmin()) {
        $department = $user->department;
        
        $requisitions->where(function($query) use ($department) {
            // Own department's requisitions
            $query->where('department_id', $department->id)
                  // OR requisitions in statuses this department handles
                  ->orWhereIn('status', $department->handles ?? []);
        });
    }

    $requisitions = $requisitions->get()->each(fn($r) => $this->setPermissions($r));
    
    return Inertia::render('Requisition/Index', ['requisitions' => $requisitions]);
}

    protected function setPermissions(Requisition $requisition)
    {
        $user = auth()->user();
        $requisition->can_edit = $user->can('update', $requisition);
        $requisition->can_approve = $user->can('approve', $requisition);
        $requisition->can_track = $user->can('track', $requisition);
    }





    public function create()
    {   
        $urgencyOptions = array_map(fn($case) => $case->value, RequisitionUrgency::cases());
        return Inertia::render('Requisition/Create',
        ['urgencyOptions' =>$urgencyOptions]);
    }

    
    public function store(Request $request)
        {
            
            $validatedData = $request->validate([
                'typeOfProduct'=>'required|string|max:255',
                'nameOfProduct'=>'required|string|max:255',
                'description'=>'required|string|max:255',
                'purpose'=>'required|string|max:255',
                'quantity'=> 'required|integer|min:1',
                'urgency'=>'required|string|max:255',
            ]);

            $estimatedCost = $request->input('estimatedCost');
         
            $validatedData['estimatedCost']= $estimatedCost;
            $validatedData['user_id'] = Auth::id();
            $validatedData['department_id'] = Auth::user()->department_id;
            $validatedData['status'] = RequisitionStatus::SUPERVISOR->value;

        

            Requisition::create($validatedData);
    
            return redirect()->route('requisitions.index')
                             ->with('success', 'Requisition created successfully!');
        }
    
    public function show(Requisition $requisition)
        {
           

            $requisition->load('user', 'department', 'supervisorApprovals');
            return Inertia::render('Requisition/Show', [
                'requisition' => $requisition,
                'canEdit' => auth()->user()->can('update', $requisition),
            ]);
        }




    
    public function edit(Requisition $requisition)
    {
        $this->authorize('update', $requisition);
        $urgencyOptions = array_map(fn($case) => $case->value, RequisitionUrgency::cases());
        $requisition->load('user');
        return Inertia::render('Requisition/Edit', [
            'requisition' => $requisition,
            'urgencyOptions' =>$urgencyOptions
        ]);
    }

   
    public function update(Request $request, Requisition $requisition)
        {

                $validatedData = $request->validate([
                    'typeOfProduct'=>'required|string|max:255',
                    'nameOfProduct'=>'required|string|max:255',
                    'description'=>'required|string|max:255',
                    'purpose'=>'required|string|max:255',
                    'quantity'=> 'required|integer|min:1',
                    'urgency'=>'required|string|max:255',

                ]);
          

                $validatedData['estimatedCost'] = $request->input('estimatedCost');
              

            $requisition->update([
             
                'nameOfProduct'=> $validatedData['nameOfProduct'],
                'description'=> $validatedData['description'],
                'quantity'=> $validatedData['quantity'],
                'purpose'=> $validatedData['purpose'],
                'typeOfProduct'=> $validatedData['typeOfProduct'],
                'urgency'=> $validatedData['urgency'],
                'estimatedCost'=>$request->input('estimatedCost'),
            ]);

            return redirect()->route('requisitions.index')->with('success', 'Requisition updated successfully!');
        }

       
        /*
            public function track(Requisition $requisition)
            {
                $requisition->load([
                    'supervisorApprovals.approver',
                    'user.department'
                ]);
            
                return Inertia::render('Requisition/Track', [
                    'requisition' => $requisition,
                    'approvalHistory' => $requisition->supervisorApprovals 
                ]);
            }
        */

        public function track(Requisition $requisition)
            {
            
                $requisition->load([
                    'supervisorApprovals.approver',
                    'user.department'
                ]);


                $requisition->append('current_status_duration');

                return Inertia::render('Requisition/Track', [
                    'requisition' => $requisition,
                    'approvalHistory' => $requisition->supervisorApprovals
                ]);
            }


   
    public function destroy(Requisition $requisition)
    {
        {
        
            $requisition->delete();
    
            return redirect()->route('requisitions.index')->with('success', 'Requisition deleted successfully!');
        }
    }
}

