<?php

namespace App\Http\Controllers\Admin\Academics;

use App\tableList;
use App\Models\Badge;
use App\ApiBaseMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\Academics\BadgeRequest;
use Illuminate\Support\Facades\Log;

class BadgeController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
    }

    public function index(Request $request)
    {
        try {
            $badges = Badge::query();
            $badges = $badges->where('active_status', '=', 1)->where('school_id', auth()->user()->school_id)->orderBy('id', 'desc')->get();

            return view('backEnd.badges.index', compact('badges'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function store(BadgeRequest $request)
    {
        DB::beginTransaction();
        try {
            $badge = new Badge();
            $badge->name = $request->name;
            $badge->created_by = auth()->user()->id;
            $badge->school_id = Auth::user()->school_id;

            if ($request->hasFile('image')) {

                $file = $request->file('image');
                $images = Image::make($file)->insert($file);
                $pathImage = 'public/uploads/badges/';
                if (!file_exists($pathImage)) {
                    mkdir($pathImage, 0777, true);
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    $images->save('public/uploads/badges/' . $name);
                    $imageName = 'public/uploads/badges/' . $name;
                    Session::put('image', $imageName);
                } else {
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    if (file_exists(Session::get('image')) || file_exists($badge->image)) {
                        File::delete($badge->image);
                        File::delete(Session::get('image'));
                    }
                    $images->save('public/uploads/badges/' . $name);
                    $imageName = 'public/uploads/badges/' . $name;
                    Session::put('image', $imageName);
                    $badge->image = $imageName;
                }
            }
            $badge->save();
            DB::commit();
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {

            // DB::rollBack();                
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $badge = Badge::find($id);
            $badges = Badge::where('active_status', '=', 1)->orderBy('id', 'desc')->where('school_id', Auth::user()->school_id)->get();

            return view('backEnd.badges.index', compact('badge', 'badges'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => "required|max:200"
        ]);

        $is_duplicate = Badge::where('school_id', Auth::user()->school_id)->where('name', $request->name)->where('id', '!=', $request->id)->first();
        if ($is_duplicate) {
            Toastr::error('Duplicate badge name found!', 'Failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($validator->fails()) {
            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendError('Validation Error.', $validator->errors());
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $badge = Badge::findOrFail($id);
            $badge->name = $request->name;
            $badge->updated_by = auth()->user()->id;

            Session::put('image', '');
            if ($request->hasFile('image')) {

                $file = $request->file('image');
                $images = Image::make($file)->insert($file);
                $pathImage = 'public/uploads/badges/';
                if (!file_exists($pathImage)) {
                    mkdir($pathImage, 0777, true);
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    $images->save('public/uploads/badges/' . $name);
                    $imageName = 'public/uploads/badges/' . $name;
                    Session::put('image', $imageName);
                    $badge->image = $imageName;
                } else {
                    $name = md5($file->getClientOriginalName() . time()) . "." . "png";
                    if (file_exists(Session::get('image')) || file_exists($badge->image)) {
                        File::delete($badge->image);
                        File::delete(Session::get('image'));
                    }
                    $images->save('public/uploads/badges/' . $name);
                    $imageName = 'public/uploads/badges/' . $name;
                    Session::put('image', $imageName);
                    $badge->image = $imageName;
                }
            }
            $badge->save();

            Log::info($imageName ?? "imageName");
            DB::commit();

            if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                return ApiBaseMethod::sendResponse(null, 'Badge has been updated successfully');
            } else {
                Toastr::success('Operation successful', 'Success');

                return redirect('badges');
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            DB::rollBack();
        }

        if (ApiBaseMethod::checkUrl($request->fullUrl())) {
            return ApiBaseMethod::sendError('Something went wrong, please try again.');
        }
        Toastr::error('Operation Failed', 'Failed');
        return redirect()->back();
    }

    public function delete(Request $request, $id)
    {
        try {
            $tables = tableList::getTableList('class_id', $id);

            if ($tables == null || $tables == "badges, ") {

                DB::beginTransaction();

                $badge = Badge::destroy($id);
                DB::commit();
                if (ApiBaseMethod::checkUrl($request->fullUrl())) {
                    if ($badge) {
                        return ApiBaseMethod::sendResponse(null, 'Class has been deleted successfully');
                    } else {
                        return ApiBaseMethod::sendError('Something went wrong, please try again.');
                    }
                }

                Toastr::success('Operation successful', 'Success');
                return redirect('class');
            } else {
                DB::rollback();
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
