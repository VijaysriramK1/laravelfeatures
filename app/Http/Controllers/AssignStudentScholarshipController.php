<?php

namespace App\Http\Controllers;

use App\Models\AssignStudentScholarship;
use App\Models\ScholarShips;
use App\Models\StudentRecord;
use App\Models\StudentScholarship;
use App\SmClass;
use App\SmClassSection;
use App\SmSection;
use App\SmStudent;
use App\SmStudentGroup;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Jobs\Scholarship\ScholarshipJob;

class AssignStudentScholarshipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = SmClass::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
        $groups = SmStudentGroup::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
        $scholarships = ScholarShips::where('academic_year_id', getAcademicId())->get();
        return view('scholarship.assign_student_scholarship',compact('classes','groups','scholarships'));
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
      try{
            $input = $request->all();
          
            $rules = [
                'class_id' => 'required',
                'section_id' => 'required',
                'group_id' => 'required',
                'student_id' => 'required|array',
                'scholarship_id' => 'required',
                'scholarship_fees_amount' => 'required|numeric',
                'amount' => 'required|numeric',
                'stipend_amount' => 'required|numeric',
                
            ];

            $messages = [
                'class_id.required' => 'The class field is required.',
                'section_id.required' => 'The section field is required.',
                'group_id.required' => 'The group field is required.',
                'student_id.required' => 'The student field is required.',
                'scholarship_id.required' => 'The scholarship field is required.',
                'scholarship_fees_amount.required' => 'The scholarship fees amount field is required.',
                'amount.required' => 'The amount field is required.',
                'amount.numeric' => 'The amount must be a numeric value.',
                'stipend_amount.required' => 'The stipend amount field is required.',
                'stipend_amount.numeric' => 'The stipend amount must be a numeric value.',
            ];
            

           $validator = Validator::make($input,$rules,$messages);
           if($validator->fails()){
             return redirect()->back()->withErrors($validator)->withInput();
           }
           
     
           $studentIds = $request->input('student_id');
           
           foreach ($studentIds as $studentId) {
          
               $assignStudentScholarship = new StudentScholarship();
            
               $assignStudentScholarship->class_id = $request->input('class_id');
               $assignStudentScholarship->section_id = $request->input('section_id');
               $assignStudentScholarship->group_id = $request->input('group_id');


               $assignStudentScholarship->student_id = $studentId;
               $assignStudentScholarship->scholarship_id =  $request->input('scholarship_id');
               $assignStudentScholarship->scholarship_fees_amount =  $request->input('scholarship_fees_amount');
               $assignStudentScholarship->amount =  $request->input('amount');
               $assignStudentScholarship->stipend_amount = $request->input('stipend_amount');
               $assignStudentScholarship->awarded_date = Carbon::parse($request->input('awarded_date'))->format('Y-m-d') ?? NULL;
               $assignStudentScholarship->academic_id = getAcademicId();
               $assignStudentScholarship->save();

               $job = (new ScholarshipJob($assignStudentScholarship, 'studentassigned'))->delay(Carbon::now()->addSeconds(10));
               dispatch($job);
            }

           Toastr::success('Operation successful', 'Success');
           return redirect()->back();
         } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
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
    public function edit($id)
    {
        $scholarshipStudents = StudentScholarship::findOrFail($id);
        $classes = SmClass::where('id', $scholarshipStudents->class_id)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->first();
        $sections = SmSection::where('id', $scholarshipStudents->section_id)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->first();
        $students = SmStudent::where('id', $scholarshipStudents->student_id)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->first();
        $groups = SmStudentGroup::where('id', $scholarshipStudents->group_id)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->first();
        $scholarships = ScholarShips::where('academic_year_id', getAcademicId())->get();
        return view('scholarship.edit_student_scholarship',compact('scholarshipStudents','classes','sections','students','groups','scholarships'));
        

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try{
                $input = $request->all();
                
                $rules = [
                    'scholarship_id' => 'required',
                    'amount' => 'required|numeric',
                    'scholarship_fees_amount' => 'required|numeric',
                    'stipend_amount' => 'required|numeric', 
                ];

                $messages = [
                    'scholarship_id.required' => 'The scholarship field is required.',
                    'scholarship_fees_amount.required' => 'The amount field is required.',
                    'amount.required' => 'The amount field is required.',
                    'stipend_amount.required' => 'The stipend amount field is required.',
                ];

            $validator = Validator::make($input,$rules,$messages);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
                $id = $request->input('assigned_student_scholarship_id');
            
                $assignStudentScholarship = StudentScholarship::findOrFail($id);
                
                $assignStudentScholarship->class_id = $request->input('class_id');
                $assignStudentScholarship->section_id = $request->input('section_id');
                $assignStudentScholarship->group_id = $request->input('group_id');
                $assignStudentScholarship->student_id = $request->input('student_id');
                $assignStudentScholarship->scholarship_id =  $request->input('scholarship_id');
                $assignStudentScholarship->scholarship_fees_amount =  $request->input('scholarship_fees_amount');
                $assignStudentScholarship->amount =  $request->input('amount');
                $assignStudentScholarship->stipend_amount = $request->input('stipend_amount');
                $assignStudentScholarship->awarded_date = Carbon::parse($request->input('awarded_date'))->format('Y-m-d') ?? NULL;
                $assignStudentScholarship->academic_id = getAcademicId();
                $assignStudentScholarship->update();
                

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function studentScholarshipDelete(Request $request)
    {
        try{
            
                $id = $request->id;
                $assignStudentScholarshipData = StudentScholarship::find($id);
                $assignStudentScholarshipData->destroy($assignStudentScholarshipData->id);
                Toastr::success('Operation successful', 'Success');
                return redirect()->back();

        } catch (\Exception $e) {

                Toastr::error('Operation Failed', 'Failed');
                return redirect()->back();

        }
    }

   
    public function getStudentsList(Request $request)
    {
        
        $get_group_students_List = StudentRecord::where('class_id',$request->class_id)->where('section_id',$request->section_id)->where('group_id',$request->group_id)->pluck('student_id');
        $studentsList = SmStudent::whereIn('id',$get_group_students_List)->get();

        return response()->json(['students' => $studentsList]);
    }

    public function getGroupsList(Request $request)
    {
        $sectionIds = StudentRecord::where('class_id', $request->class_id)->where('section_id', $request->section_id)->pluck('group_id');
        
        $groupData = SmStudentGroup::whereIn('id', $sectionIds)->get(['id', 'group']); 
    
        return response()->json(['groups'=>$groupData]);

    }


    public function getSectionsList(Request $request)
    {
        $sectionIds = SmClassSection::where('class_id', $request->class_id)->pluck('section_id');
        
        $sectionData = SmSection::whereIn('id', $sectionIds)->get(['id', 'section_name']); 
    
        return response()->json(['sections'=>$sectionData]);

    }

    public function ScholarshipStudentSearch(Request $request)
    {
       
        $requestData = [];

            $requestData['class_id'] = $request->class_id;
            $requestData['section_id'] = $request->section_id;
            $requestData['group_id'] = $request->group_id;

            $class_id = $request->class_id;
            $section_id = $request->section_id;
            $group_id = $request->group_id;

            $classes = SmClass::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            $groups = SmStudentGroup::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            $scholarships = ScholarShips::where('academic_year_id', getAcademicId())->get();
          
            return view('scholarship.assign_student_scholarship', compact('requestData',  'class_id', 'section_id', 'group_id','classes','groups','scholarships'));

    }


     public function AssignStudentScholarshipDatatable(Request $request)
     {
        
        if ($request->ajax()) {

            $studentScholarshipDetails = StudentScholarship::query();

            if ($request->class_id != '' && $request->section_id != '' && $request->group_id != '' ) {
               
                $studentScholarshipDetails = StudentScholarship::where('class_id',$request->class_id)->where('section_id',$request->section_id)->where('group_id',$request->group_id)->get();
            } 
            elseif ($request->class_id != '' && $request->section_id !='' ) {

                $studentScholarshipDetails = StudentScholarship::where('class_id',$request->class_id)->where('section_id',$request->section_id)->get();
               
            } 
            else{

                $studentScholarshipDetails = StudentScholarship::query()->get();
            }

            return Datatables::of($studentScholarshipDetails)
                ->addIndexColumn()
                ->addColumn('class_name', function ($row) {
                    $classes = SmClass::where('id',$row->class_id)->get();
                    $class_name = "";
                    foreach ($classes as $class) {
                        $class_name = $class->class_name;
                    }
                    return $class_name;
                })
                ->addColumn('section_name', function ($row) {
                    $sections = SmSection::where('id',$row->section_id)->get();
                    $section_name = "";
                    foreach ($sections as $section) {
                        $section_name = $section->section_name;
                    }
                    return $section_name;
                })
                ->addColumn('group_name', function ($row) {
                    $groups = SmStudentGroup::where('id',$row->group_id)->get();
                    $group_name = "";
                    foreach ($groups as $group) {
                        $group_name = $group->group;
                    }
                    return $group_name;
                })
                ->addColumn('student_name', function ($row) {
                    $students = SmStudent::where('id',$row->student_id)->get();
                    $student_name = "";
                    foreach ($students as $student) {
                        $student_name = $student->full_name;
                    }
                    return $student_name;
                })
                ->addColumn('scholarship_name', function ($row) {
                    $studentScholarships = ScholarShips::where('id',$row->scholarship_id)->get();
                    $scholarship_name = "";
                    foreach ($studentScholarships as $studentScholarship) {
                        $scholarship_name = $studentScholarship->name;
                    }
                    return $scholarship_name;
                })
                ->addColumn('scholarship_fees_amount', function ($row) {
                    return $row->scholarship_fees_amount;
                })
                ->addColumn('amount', function ($row) {
                    return $row->amount;
                })
                ->addColumn('stipend_amount', function ($row) {
                    return $row->stipend_amount;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="dropdown CRM_dropdown">
                                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">' . app('translator')->get('common.select') . '</button>
                                    
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#"></a>' .
                        (userPermission('admission_query_edit') === true ? '<a class="dropdown-item modalLink" data-modal-size="large-modal"
                                        title="' . __('communicate.edit_student_scholarship') . '" href="' . route('edit-student-scholarships', [$row->id]) . '">' . app('translator')->get('common.edit') . '</a>' : '') .

                        (userPermission('admission_query_delete') === true ? (Config::get('app.app_sync') ? '<span data-toggle="tooltip" title="Disabled For Demo"><a class="dropdown-item" href="#" >' . app('translator')->get('common.disable') . '</a></span>' :
                            '<a onclick="deleteQueryModal(' . $row->id . ');"  class="dropdown-item" href="' . route('delete-student-scholarship', [$row->id]) . '" data-toggle="modal" data-target="#deleteAdmissionQueryModal" data-id="' . $row->id . '"  >' . app('translator')->get('common.delete') . '</a>') : '') .
                        '</div>
                                </div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

}
