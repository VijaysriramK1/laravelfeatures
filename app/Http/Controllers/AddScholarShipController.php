<?php

namespace App\Http\Controllers;

use App\Models\ScholarShips;
use App\Models\StudentRecord;
use App\SmClass;
use App\SmFeesGroup;
use App\SmStudentGroup;
use Brian2694\Toastr\Facades\Toastr;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Modules\Fees\Entities\FmFeesType;

class AddScholarShipController extends Controller
{
    public function index()
    {
        $scholarships = ScholarShips::orderBy('id', 'asc')
            ->paginate(10);
        $feeIds = $scholarships->flatMap(function ($scholarship) {
            return is_array(json_decode($scholarship->applicable_fee_ids))
                ? json_decode($scholarship->applicable_fee_ids)
                : [];
        })->unique()->toArray();
        $applicable_fee_ids = FmFeesType::whereIn('id', $feeIds)->pluck('name', 'id')->toArray();
        $feestypes = FmFeesType::all();

        return view('scholarship.add_scholarship', compact('scholarships', 'feestypes', 'applicable_fee_ids'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'coverage_type' => 'required|string',
            'coverage_amount' => [
                'required_if:coverage_type,Percentage,Fixed', 
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->coverage_type === 'Percentage' && ($value < 0 || $value > 100)) {
                        $fail('The coverage amount must be between 0 and 100 for Percentage type.');
                    }
                },
            ],
            'applicable_fee_ids' => 'required|array',
        ], [], [
            'name' => 'Scholarship Name',
            'coverage_amount' => 'Amount',
            'coverage_type' => 'Coverage Type',
            'applicable_fee_ids' => 'Fee Types',
        ]);



        $scholarship = new ScholarShips();
        $scholarship->name = $request->name;
        $scholarship->description = $request->description;
        $scholarship->eligibility_criteria = $request->eligibility_criteria ?? null;
        $scholarship->coverage_amount = $request->coverage_amount ?? null;
        $scholarship->coverage_type = $request->coverage_type ?? null;
        $scholarship->applicable_fee_ids = json_encode($request->applicable_fee_ids);
        $scholarship->academic_year_id = $request->academic_year_id ?? 1;
        $scholarship->save();

        Toastr::success('Scholarship added successfully');
        return redirect()->route('add-scholarship');
    }




    public function edit($id)
    {

        $item = ScholarShips::findOrFail($id);
        $scholarships = ScholarShips::all();
        $feeIds = $scholarships->flatMap(function ($scholarship) {
            return is_array(json_decode($scholarship->applicable_fee_ids))
                ? json_decode($scholarship->applicable_fee_ids)
                : [];
        })->unique()->toArray();
        $applicable_fee_ids = FmFeesType::whereIn('id', $feeIds)->pluck('name', 'id')->toArray();
        $scholarships = ScholarShips::paginate(10);
        $feestypes = FmFeesType::all();
        return view('scholarship.add_scholarship', compact('scholarships', 'item', 'feestypes', 'applicable_fee_ids'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'coverage_type' => 'required|string',
            'coverage_amount' => [
                'required_if:coverage_type,Percentage,Fixed', 
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->coverage_type === 'Percentage' && ($value < 0 || $value > 100)) {
                        $fail('The coverage amount must be between 0 and 100 for Percentage type.');
                    }
                },
            ],
            'applicable_fee_ids' => 'required|array',
        ], [], [
            'name' => 'Scholarship Name',
            'coverage_amount' => 'Amount',
            'coverage_type' => 'Coverage Type',
            'applicable_fee_ids' => 'Fee Types',
        ]);


        $scholarship = ScholarShips::findOrFail($id);
        $scholarship->name = $request->name;
        $scholarship->description = $request->description;
        $scholarship->eligibility_criteria = $request->eligibility_criteria ?? null;
        $scholarship->coverage_amount = $request->coverage_amount ?? null;
        $scholarship->coverage_type = $request->coverage_type ?? null;
        $scholarship->applicable_fee_ids = json_encode($request->applicable_fee_ids) ?? null;
        $scholarship->academic_year_id = $request->academic_year_id ?? 1;
        $scholarship->update();
        return redirect()->route('add-scholarship');
    }

    public function destroy($id)
    {
        ScholarShips::findOrFail($id)->delete();

        Toastr::Success('ScholarShip deleted successfully');
        return redirect()->route('add-scholarship');
    }
}
