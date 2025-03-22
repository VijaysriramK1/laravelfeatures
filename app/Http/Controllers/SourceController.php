<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Supports\Facades\Exception;
use Illuminate\Support\Facades\Validator;
use App\SmSetupAdmin;
use App\SmStaff;

class SourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sources = SmSetupAdmin::where('type', 3)->where('school_id',auth()->user()->school_id)->get();
        return view('lead_source', compact('sources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $input = $request->all();
           
            $rules = [
                'name' => ['required','max:255','string','unique:sm_setup_admins,name'],
                'type' => ['required','integer'],
            ];

            $messages = [
                'name.required' => 'This field is required.',
            ];
    
            $validator = Validator::make($input,$rules,$messages);
            if($validator->fails()){
               
                return redirect()->back()->withErrors($validator)->withInput();
            
            }
    
            $data = new SmSetupAdmin();
            $data->type = $input['type'];
            $data->name = $input['name'];
            $data->description = $input['description'] ?? NULL;
            $data->active_status = 1;
            $data->created_by = Auth::user()->id;
            $data->updated_by = 1;
            $data->school_id  = Auth::user()->school_id;
            $data->academic_id   = getAcademicId();
          
            $data->save();
            Toastr::success('Operation Successfull','Success');
            return redirect('lead-integration/source');

        }catch(\Exception $e){
            Toastr::error('Operation Failed','Failed');
            return redirect('lead-integration/source');
        }
       
        
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
      
        try{
            
            $source = SmSetupAdmin::find(intval($id));
            $sources = SmSetupAdmin::where('type', 3)->where('school_id',auth()->user()->school_id)->get();
            return view('lead_source', compact('source','sources'));

        }catch(\Exception $e){
            Toastr::error('Operation Failed','Error');
            return redirect('lead-integration/source');
        }
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        try {
            $input = $request->all();

            $rules = [
                'name' => ['string', 'max:255', 'required'],
                'type' => ['integer', 'required'],
            ];

            $validator = Validator::make($input, $rules);
            if ($validator->fails()) {
                Toastr::error('Validation Error', 'Error');
                return redirect('lead-integration/source')->withErrors($validator)->withInput();
            }

            $data = SmSetupAdmin::find($id);
            $data->type = $input['type'];
            $data->name = $input['name'];
            $data->description = $input['description'] ?? NULL;
            $data->active_status = 1;
            $data->created_by = Auth::user()->id;
            $data->updated_by = 1;
            $data->school_id  = Auth::user()->school_id;
            $data->academic_id   = getAcademicId();
            $data->save();

            Toastr::success('Updated Successfully', 'Success');
            return redirect('lead-integration/source');

        } catch (\Exception $e) {
            return redirect('lead-integration/source');
            Toastr::error('Updation Failed', 'Failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       
            try {

                $data = SmSetupAdmin::find($id);
                $data->delete();
                Toastr::success('Deleted Successfully', 'Success');
                return redirect('lead-integration/source');
    
            } catch (\Exception $e) {
                return redirect('lead-integration/source');
                Toastr::error('Deletion Failed', 'Failed');
            
        }
    }
    
}

