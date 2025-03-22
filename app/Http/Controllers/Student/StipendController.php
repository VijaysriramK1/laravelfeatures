<?php

namespace App\Http\Controllers\Student;

use App\SmClass;
use App\SmClassSection;
use App\Models\StudentRecord;
use App\Models\ScholarShips;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\StudentScholarship;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StipendController extends Controller
{
    public function stipendPage()
    {
        $get_scholarships = ScholarShips::orderby("id", "asc")->get();
        $get_classes = SmClass::where('school_id', Auth::user()->school_id)->orderby("id", "asc")->get();
        return view('stipends.admin_stipend', compact('get_scholarships', 'get_classes'));
    }

    public function selectedClassSectionList(Request $request)
    {
        $get_sections = SmClassSection::with('sectionname')->where('class_id', $request->class_id)->where('school_id', Auth::user()->school_id)->orderby("id", "asc")->get();
        return response()->json($get_sections);
    }

    public function studentScholarshipSearch(Request $request)
    {
        if ($request->ajax()) {
            $check_scholarship = DB::table('student_scholarships')->where('scholarship_id', $request->scholarship_id)->get();
            $data = StudentRecord::with('student')->whereIn('student_id', $check_scholarship->pluck('student_id'))->where('class_id', $request->class_id)->where('section_id', $request->section_id)->where('school_id', Auth::user()->school_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('admission_no', function ($row) {
                    return $row->student->admission_no ?? '--';
                })
                ->addColumn('roll_number', function ($row) {
                    return $row->student->roll_no ?? '--';
                })
                ->addColumn('student_name', function ($row) use ($check_scholarship) {
                    $get_first_name = $row->student->first_name ?? '--';
                    $get_last_name = $row->student->last_name ?? '';
                    $get_student_scholarship_details = $check_scholarship->where('student_id', $row->student_id)->first();
                    return '<div>
                            <input type="hidden" class="student-cls" value="' . $row->student_id . '" /> 
                            <input type="hidden" class="scholarship-cls" value="' . $get_student_scholarship_details->scholarship_id . '" /> 
                            <span>' . $get_first_name . ' ' . $get_last_name . '</span>
                            </div>';
                })

                ->addColumn('scholarship_starting_date', function ($row) use ($check_scholarship) {
                    $get_stipends_details = DB::table('stipends')->where('student_id', $row->student_id)->first();
                    $get_student_scholarship_details = $check_scholarship->where('student_id', $row->student_id)->first();
                    
                    if (!empty($get_stipends_details)) {
                        if($get_stipends_details->start_date != '' && $get_stipends_details->start_date != NULL){
                            return Carbon::parse($get_stipends_details->start_date)->format('d-m-Y');
                        }else{
                            return Carbon::parse($get_student_scholarship_details->awarded_date)->format('d-m-Y');
                        }
                    } else {
                        return Carbon::parse($get_student_scholarship_details->awarded_date)->format('d-m-Y');
                    }
                })

                ->addColumn('interval_type', function ($row) {
                    $get_stipends_details = DB::table('stipends')->where('student_id', $row->student_id)->first();

                    if (!empty($get_stipends_details)) {
                        if ($get_stipends_details->interval_type != '' && $get_stipends_details->interval_type != NULL) {
                            $content = '<select id="interval-type" class="form-select interval-cls" data-selectid="' . $row->id . '" style="color: #828bb2 !important; width: 150px;">
                        <option value="" hidden>Choose Type</option>
                        <option value="monthly" ' . ($get_stipends_details->interval_type == 'hourly' ? 'selected' : '') . '>hourly</option>
                        <option value="monthly" ' . ($get_stipends_details->interval_type == 'monthly' ? 'selected' : '') . '>monthly</option>
                        <option value="yearly" ' . ($get_stipends_details->interval_type == 'yearly' ? 'selected' : '') . '>yearly</option>
                        </select>';
                        } else {
                            $content = '<select id="interval-type" class="form-select interval-cls" data-selectid="' . $row->id . '" style="color: #828bb2 !important; width: 150px;">
                            <option value="" hidden>Choose Type</option>
                            <option value="hourly">hourly</option>
                            <option value="monthly">monthly</option>
                            <option value="yearly">yearly</option>
                            </select>';
                        }
                    } else {
                        $content = '<select id="interval-type" class="form-select interval-cls" data-selectid="' . $row->id . '" style="color: #828bb2 !important; width: 150px;">
                        <option value="" hidden>Choose Type</option>
                        <option value="hourly">hourly</option>
                        <option value="monthly">monthly</option>
                        <option value="yearly">yearly</option>
                        </select>';
                    }
                    return $content;
                })

                ->addColumn('cycle_count', function ($row) {

                    $get_stipends_details = DB::table('stipends')->where('student_id', $row->student_id)->first();

                    if (!empty($get_stipends_details)) {
                        $cycle_count_value = $get_stipends_details->cycle_count ?? '';

                        if ($get_stipends_details->interval_type == 'monthly') {
                            return '<input type="number" class="form-control cycle-count-cls cycle-count_' . $row->id . '" value="' . $cycle_count_value . '" data-countid="' . $row->id . '" min="1" max="12" onkeyup=cycleCountDetails(this) style="color: #828bb2 !important; width: 100px;">';
                        } else if ($get_stipends_details->interval_type == 'yearly') {
                            return '<input type="number" class="form-control cycle-count-cls cycle-count_' . $row->id . '" value="' . $cycle_count_value . '" data-countid="' . $row->id . '" min="1" max="" onkeyup=cycleCountDetails(this) style="color: #828bb2 !important; width: 100px;">';
                        } else if ($get_stipends_details->interval_type == 'hourly'){
                            return '<input type="number" class="form-control cycle-count-cls cycle-count_' . $row->id . '" value="' . $cycle_count_value . '" data-countid="' . $row->id . '" min="1" max="" onkeyup=cycleCountDetails(this) style="color: #828bb2 !important; width: 100px;">';
                        } else {
                            return '<input type="number" class="form-control disabled-cls cycle-count-cls cycle-count_' . $row->id . '" value="' . $cycle_count_value . '" data-countid="' . $row->id . '" min="1" max="" onkeyup=cycleCountDetails(this) style="color: #828bb2 !important; width: 100px;">';
                        }
                    } else {
                        return '<input type="number" class="form-control disabled-cls cycle-count-cls cycle-count_' . $row->id . '" value="" data-countid="' . $row->id . '" min="1" max="" onkeyup=cycleCountDetails(this) style="color: #828bb2 !important; width: 100px;">';
                    }
                })

                ->addColumn('stipend_amount', function ($row) use ($check_scholarship) {
                    $get_student_scholarship_details = $check_scholarship->where('student_id', $row->student_id)->first();
                    $get_stipends_details = DB::table('stipends')->where('student_id', $row->student_id)->first();

                    if ($get_student_scholarship_details->stipend_amount != '' && $get_student_scholarship_details->stipend_amount != NULL) {

                        $orginal_stipend_amount = $get_student_scholarship_details->stipend_amount;

                        if (!empty($get_stipends_details)) {
                            if ($get_stipends_details->cycle_count != '' && $get_stipends_details->cycle_count != NULL) {
                                $stipend_amount = $get_student_scholarship_details->stipend_amount / $get_stipends_details->cycle_count;
                            } else {
                                $stipend_amount = $get_student_scholarship_details->stipend_amount;
                            }
                        } else {
                            $stipend_amount = $get_student_scholarship_details->stipend_amount;
                        }
                    } else {
                        $orginal_stipend_amount = '';
                        $stipend_amount = '';
                    }

                    return '<input type="hidden" id="orginal_stipend_amount_input_' . $row->id . '" value="' . $orginal_stipend_amount . '" /> <input type="hidden" id="maximum_stipend_amount_input_' . $row->id . '" value="' . $stipend_amount . '" /> <span>' . $orginal_stipend_amount . '</span>';
                })

                ->addColumn('amount', function ($row) use ($check_scholarship) {
                    $get_student_scholarship_details = $check_scholarship->where('student_id', $row->student_id)->first();
                    $get_stipends_details = DB::table('stipends')->where('student_id', $row->student_id)->first();

                    if ($get_student_scholarship_details->stipend_amount != '' && $get_student_scholarship_details->stipend_amount != NULL) {
                        if (!empty($get_stipends_details)) {
                            if ($get_stipends_details->cycle_count != '' && $get_stipends_details->cycle_count != NULL) {
                                $stipend_amount = $get_student_scholarship_details->stipend_amount / $get_stipends_details->cycle_count;
                            } else {
                                $stipend_amount = $get_student_scholarship_details->stipend_amount;
                            }
                        } else {
                            $stipend_amount = $get_student_scholarship_details->stipend_amount;
                        }
                    } else {
                        $stipend_amount = '';
                    }

                    return '<input type="number" class="form-control amount-cls amount_row_' . $row->id . '" value="' . $stipend_amount . '" data-amountrowid="' . $row->id . '" min="1" max="" style="color: #828bb2 !important; width: 100px;" />';
                })
                ->rawColumns(['student_name', 'interval_type', 'cycle_count', 'stipend_amount', 'amount'])
                ->with('status', 'success')
                ->make(true);
        }

        return abort(404);
    }

    public function studentStipendAdding(Request $request)
    {
        if ($request->has('student_details')) {
            DB::table('stipends')->whereIn('student_id', $request->student_details)->delete();

            foreach ($request->collect_details as $val) {

               $get_student_scholarship = StudentScholarship::where('scholarship_id', $val['scholarship_id'])->where('student_id', $val['student_id'])->first();
               
               $stipend = DB::table('stipends')->insertGetId([
                    'student_id' => $val['student_id'],
                    'scholarship_id' => $val['scholarship_id'],
                    'interval_type' => $val['interval_type'],
                    'cycle_count' => $val['cycle_count'],
                    'start_date' => $get_student_scholarship->awarded_date,
                    'amount' => $val['amount'],
                ]);


                DB::table('stipend_payments')->insert([
                    'student_id' => $val['student_id'],
                    'stipend_id' => $stipend,
                    'stipends_amount' => $val['amount'],
                    'start_date' => $get_student_scholarship->awarded_date,
                ]);
            }
            return response()->json(['status' => 'success', 'message' => 'Successfully updated.']);
        } else {
            return response()->json(['status' => 'success', 'message' => 'Successfully updated.']);
        }
    }
}
