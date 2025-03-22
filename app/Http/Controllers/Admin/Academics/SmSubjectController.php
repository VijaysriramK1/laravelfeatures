<?php

namespace App\Http\Controllers\Admin\Academics;

use App\SmSubject;
use App\tableList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Requests\Admin\Academics\SmSubjectRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SmSubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
        // User::checkAuth();
    }

    public function index(Request $request)
    {
        try {
            $subjects = SmSubject::orderBy('id', 'DESC')->get();
            return view('backEnd.academics.subject', compact('subjects'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function store(SmSubjectRequest $request)
    {
        try {
            $subject = new SmSubject();
            $subject->subject_name = $request->subject_name;
            $subject->subject_type = $request->subject_type;
            $subject->subject_code = $request->subject_code;
            $subject->duration = $request->duration;
            $subject->duration_type = $request->duration_type;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/subject_images'), $filename);
                $subject->image = 'uploads/subject_images/' . $filename;
            }

            if (@generalSetting()->result_type == 'mark') {
                $subject->pass_mark = $request->pass_mark;
            }
            $subject->created_by = auth()->user()->id;
            $subject->school_id = auth()->user()->school_id;
            $subject->academic_id = getAcademicId();
            $result = $subject->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Subject store error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            Toastr::error('Operation Failed: ' . $e->getMessage(), 'Failed');
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $subject = SmSubject::find($id);
            $subjects = SmSubject::orderBy('id', 'DESC')->get();
            return view('backEnd.academics.subject', compact('subject', 'subjects'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function update(SmSubjectRequest $request)
    {
        try {
            $subject = SmSubject::findOrFail($request->id);
            $subject->subject_name = $request->subject_name;
            $subject->subject_type = $request->subject_type;
            $subject->subject_code = $request->subject_code;
            $subject->duration = $request->duration;
            $subject->duration_type = $request->duration_type;

            if ($request->hasFile('image')) {
                if ($subject->image) {
                    $oldImagePath = public_path('uploads/subject_images/' . $subject->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/subject_images'), $filename);
                $subject->image = 'uploads/subject_images/' . $filename;
            }

            if (@generalSetting()->result_type == 'mark') {
                $subject->pass_mark = $request->pass_mark;
            }
            $subject->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->route('subject');
        } catch (\Exception $e) {
            Toastr::error('Operation Failed: ' . $e->getMessage(), 'Failed');
            return redirect()->back();
        }
    }


    private function convertDuration($duration, $type)
    {
        switch ($type) {
            case 'hours':
                return $duration * 60;
            case 'days':
                return $duration * 1440; // 24 * 60
            case 'weeks':
                return $duration * 10080; // 7 * 24 * 60
            default:
                return $duration;
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $tables = tableList::getTableList('subject_id', $id);
            if ($tables == null) {
                $subject = SmSubject::find($id);
                if ($subject->image) {
                    Storage::delete('public/' . $subject->image);
                }
                $subject->delete();
                Toastr::success('Operation successful', 'Success');
                return redirect('subject');
            } else {
                $msg = 'This data already used in  : ' . $tables . ' Please remove those data first';
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }
}
