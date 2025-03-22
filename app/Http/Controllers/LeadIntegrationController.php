<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Supports\Facades\Exception;
use Illuminate\Support\Facades\Validator;
use App\SmAdmissionQuery;
use Log;
use Illuminate\Support\Facades\Auth;
use App\SmSetupAdmin;
use App\SmStaff;
use Illuminate\Support\Facades\DB;

// use App\Http\Requests\Admin\AdminSection\SmAdmissionQueryRequest;

class LeadIntegrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $sources = DB::table('sm_setup_admins')->where('type', 3)->get();
        $status = DB::table('sm_setup_admins')->where('type',5)->get();
        $assignees = DB::table('sm_staffs')->where('active_status',1)->get();


        $storedSourceId = DB::table('sm_setup_admins')->where('type', 3)->where('general_status', 1)->pluck('id')->first();
        $storedStatusId = DB::table('sm_setup_admins')->where('type', 5)->where('general_status', 1)->pluck('id')->first();
        $storedAssignedId = DB::table('sm_staffs')->where('active_status', 1)->where('general_staff_status', 1)->pluck('id')->first();

        return view('lead_integration',compact('sources','status','assignees','storedSourceId','storedStatusId','storedAssignedId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->all();

        $sourceData = SmSetupAdmin::where('type', 3)->where('id', $request->source_id)->first();
        $statusData = SmSetupAdmin::where('type', 5)->where('id', $request->active_status)->first();
        $assigneesData = SmStaff::where('active_status',1)->where('id',$request->assigned_id)->first();
       
        SmSetupAdmin::where('type', 3)->where('general_status', 1)->where('id', '!=', $request->source_id)->update(['general_status' => null]);
        SmSetupAdmin::where('type', 5)->where('general_status', 1)->where('id', '!=', $request->active_status)->update(['general_status' => null]);
        SmStaff::where('general_staff_status', 1)->where('id', '!=', $request->assigned_id)->update(['general_staff_status' => null]);
        
        if ($sourceData || $statusData || $assigneesData) {
          
            if ($sourceData) {
                $sourceData->general_status = 1;
                $sourceData->save();
            }
        
            if ($statusData) {
                $statusData->general_status = 1;
                $statusData->save();
            }
        
            if ($assigneesData) {
                $assigneesData->general_staff_status = 1;
                $assigneesData->save();
            }
        
         
            $successMessages = [];
            if ($sourceData && $statusData && $assigneesData) {
                $successMessages[] = 'Source, Status & Assignee Successfully created';
            } elseif ($sourceData && $assigneesData) {
                $successMessages[] = 'Source & Assignee Successfully created';
            } elseif ($sourceData && $statusData) {
                $successMessages[] = 'Source & Status Successfully created';
            } elseif ($assigneesData && $statusData) {
                $successMessages[] = 'Assignee & Status Successfully created';
            } elseif ($sourceData) {
                $successMessages[] = 'Source Successfully created';
            } elseif ($statusData) {
                $successMessages[] = 'Status Successfully created';
            } elseif ($assigneesData) {
                $successMessages[] = 'Assignee Successfully created';
            }
        
            
            foreach ($successMessages as $message) {
                Toastr::success($message, 'Success');
            }
        } else {
            Toastr::error('Operation Failed', 'Failed');
        }
        
        
        return redirect()->back();
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SmAdmissionQueryRequest $request, string $id=null)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}
