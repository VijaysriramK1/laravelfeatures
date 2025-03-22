<?php

namespace App\Http\Controllers;

use App\Models\StudentRecord;
use DateTime;
use App\SmClass;
use App\SmSection;
use App\SmAcademicYear;
use Illuminate\Support\Carbon;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Config;
use App\Scopes\StatusAcademicSchoolScope;
use Illuminate\Support\Facades\Validator;
use App\SmAssignClassTeacher;
use App\SmAssignSubject;
use App\SmBaseSetup;
use App\SmClassSection;
use App\SmClassTeacher;
use App\SmParent;
use App\SmStaff;
use App\SmStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Lesson\Entities\SmLesson;
use Modules\Lesson\Entities\SmLessonTopic;
use Modules\Lesson\Entities\SmLessonTopicDetail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class MyStudentsController extends Controller
{

    public function classWiseSectionsListIndex()
    {


        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 5) {
            $get_classwise_sections = SmClassSection::with('className')->with('sectionName')->where('academic_id', getAcademicId())->orderBy('class_id', 'asc')->orderBy('section_id', 'asc')->get();
            $blade_file_name = 'programs.my_students.admin_my_students';
        } else if (Auth::user()->role_id == 4) {

            $check_staff_details = SmStaff::where('user_id', Auth::user()->id)->first();
            $get_staff_assigned_classes_sections = SmClassTeacher::where('teacher_id', $check_staff_details->id)->where('academic_id', getAcademicId())->pluck('assign_class_teacher_id');
            $get_classwise_sections = SmAssignClassTeacher::with('class')->with('section')->where('academic_id', getAcademicId())->whereIn('id', $get_staff_assigned_classes_sections)->orderBy('class_id', 'asc')->orderBy('section_id', 'asc')->get();
            $blade_file_name = 'programs.my_students.staff_my_students';
        } else {
            $check_staff_details = SmStaff::where('user_id', Auth::user()->id)->first();
            $get_staff_assigned_classes_sections = SmClassTeacher::where('teacher_id', $check_staff_details->id)->where('academic_id', getAcademicId())->pluck('assign_class_teacher_id');
            $get_classwise_sections = SmAssignClassTeacher::with('class')->with('section')->where('academic_id', getAcademicId())->whereIn('id', $get_staff_assigned_classes_sections)->orderBy('class_id', 'asc')->orderBy('section_id', 'asc')->get();
            $blade_file_name = 'programs.my_students.staff_my_students';
        }

        return view($blade_file_name, compact('get_classwise_sections'));
    }


    public function classWiseSectionsStudentsDetailsDatatable(Request $request)
    {

        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 5) {

            if ($request->ajax()) {

                if ($request->selected_class != '' && $request->selected_section != '') {
                    $data = StudentRecord::with('studentDetail')->where('class_id', $request->selected_class)->where('section_id', $request->selected_section)->get();
                } else {
                    $get_first_data = StudentRecord::orderBy('class_id', 'asc')->orderBy('section_id', 'asc')->first();
                    $data = StudentRecord::with('studentDetail')->where('class_id', $get_first_data->class_id)->where('section_id', $get_first_data->section_id)->get();
                }

                return DataTables::of($data)
                    ->addColumn('admission_no', function ($row) {

                        return $row->studentDetail->admission_no ?? 'N/A';
                    })


                    ->addColumn('student_name', function ($row) {

                        return $row->studentDetail->full_name ?? 'N/A';
                    })


                    ->addColumn('father_name', function ($row) {
                        $parentDetails = SmParent::where('id', $row->studentDetail->parent_id)->first();
                        return $parentDetails->fathers_name ?? 'N/A' ;
                    })


                    ->addColumn('dob', function ($row) {

                        return $row->studentDetail->date_of_birth ?? 'N/A';
                    })


                    ->addColumn('class_section', function ($row) {
                        $classDetails = SmClass::where('id', $row->class_id)->first();
                        $sectionDetails = SmSection::where('id', $row->section_id)->first();
                        $class_section = strtoupper($classDetails->class_name) . " (" . strtoupper($sectionDetails->section_name) . ")";

                        return $class_section ?? 'N/A';
                    })


                    ->addColumn('gender', function ($row) {
                        $genderDetails = SmBaseSetup::where('id', $row->studentDetail->gender_id)->first();
                        return $genderDetails->base_setup_name ?? 'N/A';
                    })


                    ->addColumn('type', function ($row) {

                        return $row->studentDetail->type ?? 'N/A';
                    })


                    ->addColumn('phone', function ($row) {

                        return $row->studentDetail->mobile ?? 'N/A';
                    })

                    ->with('status', 'success')
                    ->make(true);
            }
        } else if (Auth::user()->role_id == 4) {

            if ($request->ajax()) {

                if ($request->selected_class != '' && $request->selected_section != '') {
                    $data = StudentRecord::with('studentDetail')->where('class_id', $request->selected_class)->where('section_id', $request->selected_section)->get();
                } else {
                    $get_first_data = StudentRecord::orderBy('class_id', 'asc')->orderBy('section_id', 'asc')->first();
                    $data = StudentRecord::with('studentDetail')->where('class_id', $get_first_data->class_id)->where('section_id', $get_first_data->section_id)->get();
                }

                return DataTables::of($data)
                    ->addColumn('admission_no', function ($row) {

                        return $row->studentDetail->admission_no ?? 'N/A';
                    })


                    ->addColumn('student_name', function ($row) {

                        return $row->studentDetail->full_name ?? 'N/A';
                    })


                    ->addColumn('father_name', function ($row) {
                        $parentDetails = SmParent::where('id', $row->studentDetail->parent_id)->first();
                        return $parentDetails->fathers_name ?? 'N/A';
                    })


                    ->addColumn('dob', function ($row) {

                        return $row->studentDetail->date_of_birth ?? 'N/A';
                    })


                    ->addColumn('class_section', function ($row) {
                        $classDetails = SmClass::where('id', $row->class_id)->first();
                        $sectionDetails = SmSection::where('id', $row->section_id)->first();
                        $class_section = strtoupper($classDetails->class_name) . " (" . strtoupper($sectionDetails->section_name) . ")";

                        return $class_section ?? 'N/A';
                    })


                    ->addColumn('gender', function ($row) {
                        $genderDetails = SmBaseSetup::where('id', $row->studentDetail->gender_id)->first();
                        return $genderDetails->base_setup_name ?? 'N/A';
                    })


                    ->addColumn('type', function ($row) {

                        return $row->studentDetail->type ?? 'N/A';
                    })


                    ->addColumn('phone', function ($row) {

                        return $row->studentDetail->mobile ?? 'N/A';
                    })

                    ->with('status', 'success')
                    ->make(true);
            }
        } else {
        }
        return abort(404);
    }

    public function showMyStudents(Request $request, $classId, $sectionId)
    {
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 5) {
            $students = StudentRecord::with('studentDetail')
                ->where('class_id', $classId)
                ->where('section_id', $sectionId)
                ->get();

            $get_classwise_sections = SmClassSection::where('class_id', $classId)
                ->where('section_id', $sectionId)->with('className')->with('sectionName')->orderBy('class_id', 'asc')->orderBy('section_id', 'asc')->get();
            $className = SmClass::find($classId)->class_name ?? '';
            $sectionName = SmSection::find($sectionId)->section_name ?? '';

            return view('programs.my_students.admin_my_students', compact('students', 'classId', 'sectionId', 'className', 'sectionName', 'get_classwise_sections'));
        }

        return abort(404);
    }
}
