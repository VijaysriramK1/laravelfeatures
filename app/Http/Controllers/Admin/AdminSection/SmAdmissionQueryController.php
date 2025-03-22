<?php

namespace App\Http\Controllers\Admin\AdminSection;

use DataTables;
use App\SmClass;
use App\SmSetupAdmin;
use App\SmAdmissionQuery;
use Illuminate\Http\Request;
use App\Jobs\Student\ReminderJob;
use App\SmAdmissionQueryFollowup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Http\Requests\Admin\AdminSection\SmAdmissionQueryRequest;
use App\Http\Requests\Admin\AdminSection\SmAdmissionQuerySearchRequest;
use App\Http\Requests\Admin\AdminSection\SmAdmissionQueryFollowUpRequest;
use App\Jobs\SendReminderEmail;
use App\Mail\ReminderNotification;
use App\Models\SmAdmissionQueryAttachment;
use App\Models\SmAdmissionQueryReminder;
use App\Models\User;
use App\SmStudent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Modules\University\Repositories\Interfaces\UnCommonRepositoryInterface;
use App\Models\AdmissionFees;
use App\Models\AdmissionFeesInvoice;
use App\Models\AdmissionFeesInvoiceChields;
use Modules\Fees\Entities\FmFeesInvoice;





class SmAdmissionQueryController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');
    }

    public function index()
    {
        try {
            $classes = SmClass::get();
            $references = SmSetupAdmin::where('type', 4)->get();
            $sources = SmSetupAdmin::where('type', 3)->get();
            $status = SmSetupAdmin::where('type', 5)->get();
            return view('backEnd.admin.admission_query', compact('references', 'classes', 'sources', 'status'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function store(SmAdmissionQueryRequest $request)
    {
        try {
            $admission_query = new SmAdmissionQuery();
            $admission_query->name = $request->name;
            $admission_query->phone = $request->phone;
            $admission_query->email = $request->email;
            $admission_query->address = $request->address;
            $admission_query->description = $request->description;
            $admission_query->date = date('Y-m-d', strtotime($request->date));
            $admission_query->next_follow_up_date = date('Y-m-d', strtotime($request->next_follow_up_date));
            $admission_query->assigned = $request->assigned;
            $admission_query->reference = $request->reference;
            $admission_query->source = $request->source;
            if (moduleStatusCheck('University')) {
                $common = App::make(UnCommonRepositoryInterface::class);
                $data = $common->storeUniversityData($admission_query, $request);
            } else {
                $admission_query->class = $request->class;
                $admission_query->academic_id = getAcademicId();
            }
            $admission_query->no_of_child = $request->no_of_child;
            $admission_query->created_by = Auth::user()->id;
            $admission_query->school_id = Auth::user()->school_id;
            $admission_query->save();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $data = [];
            $admission_query = SmAdmissionQuery::find($id);



            $classes = SmClass::get();
            $references = SmSetupAdmin::where('type', 4)->get();
            $sources = SmSetupAdmin::where('type', 3)->get();


            $active_class = SmAdmissionQuery::where('id', $id)->where('school_id', auth()->user()->school_id)->orderBy('id', 'DESC')->first();
            $amount = AdmissionFees::where('class_id', $active_class->class)->where('status', 'Active')->where('school_id', auth()->user()->school_id)->orderBy('id', 'DESC')->first();
            $paymentStatus = AdmissionFeesInvoice::where('student_id', $id)->where('student_id', $active_class->id)->where('class_id', $amount->class_id)->where('class_id', $active_class->class)->where('active_status', 1)->where('school_id', auth()->user()->school_id)->orderBy('id', 'DESC')->first();
            $balance_amount = AdmissionFeesInvoiceChields::where('admission_fees_invoice_id',$paymentStatus->id)->first();
           
            $assigned_id = SmAdmissionQuery::where('id', $id)->first();
            $assignee_name = User::where('id', $assigned_id->assigned)->first();
            $assignees = User::get();
            $student_status = SmAdmissionQuery::where('id', $id)->get();


            if (moduleStatusCheck('University')) {
                $common = App::make(UnCommonRepositoryInterface::class);
                $data = $common->getCommonData($admission_query);
            }
            return view('backEnd.admin.admission_query_edit', compact('admission_query', 'references', 'classes', 'sources', 'active_class', 'amount', 'paymentStatus', 'assignee_name', 'assignee_name', 'assignees', 'student_status','balance_amount'))->with($data);
        } catch (\Exception $e) {

            Toastr::error('Operation Failed', 'Failed');
            // dd($e->getMessage());
            return redirect()->back();
        }
    }


    public function update(Request $request)
    {
       $id=$request->input('id');
        $admission_query = SmAdmissionQuery::findOrFail($id);
            $admission_query->name = $request->name;
            $admission_query->phone = $request->phone;
            $admission_query->email = $request->email;
            $admission_query->address = $request->address;
            $admission_query->description = $request->description;
            $admission_query->date = date('Y-m-d', strtotime($request->date));
            $admission_query->next_follow_up_date = date('Y-m-d', strtotime($request->next_follow_up_date));
            $admission_query->assigned = $request->assigned;
            if ($request->reference) {
                $admission_query->reference = $request->reference;
            }
            $admission_query->source = $request->source;
            $admission_query->student_status = $request->student_status;
            if (moduleStatusCheck('University')) {
                $common = App::make(UnCommonRepositoryInterface::class);
                $data = $common->storeUniversityData($admission_query, $request);
            } else {
                $admission_query->class = $request->class;
            }
            $admission_query->no_of_child = isset($request->no_of_child) ?  $request->no_of_child : NULL ;
            $admission_query->school_id = Auth::user()->school_id;
            $admission_query->academic_id = getAcademicId();
            $admission_query->update();
            
            $feesDetails = AdmissionFees::where('class_id',$request->class)->where('status','active')->where('school_id',auth()->user()->school_id)->orderBy('id', 'DESC')->first();

            $invoice = AdmissionFeesInvoice::where('student_id', $admission_query->id)->firstOrFail();

            $invoice->invoice_id = 'INV-' . mt_rand(1, 999);
            $invoice->student_id =   $admission_query->id;
            $invoice->class_id =  $admission_query->class;
            $invoice->payment_status = 'Unpaid';
            $invoice->payment_method = $input['payment_method'] ?? NULL ;
            $invoice->bank_id =  $input['bank_id'] ?? NULL ;
            $invoice->type =  $input['type'] ?? NULL ;
            $invoice->school_id =  Auth::user()->school_id ;
            $invoice->academic_id =  getAcademicId();
            $invoice->active_status =  $input['active_status'] ?? 1 ;
            $invoice->record_id =  $feesDetails->id  ?? NULL ;
            $invoice->admission_fees_id =   $feesDetails->id ?? NULL ;
            $invoice->save();
            Toastr::success('Operation successful', 'Success');
            return redirect()->back();

    }

    public function addQuery($id)
    {
        try {
            $admission_query = SmAdmissionQuery::where('school_id', auth()->user()->school_id)->where('id', $id)->first();
            $follow_up_lists = SmAdmissionQueryFollowup::where('academic_id', getAcademicId())->where('admission_query_id', $id)->orderby('id', 'DESC')->get();
            $classes = SmClass::where('active_status', 1)->where('academic_id', getAcademicId())->where('school_id', Auth::user()->school_id)->get();
            $references = SmSetupAdmin::where('type', 4)->where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            $sources = SmSetupAdmin::where('type', 3)->where('active_status', 1)->where('school_id', Auth::user()->school_id)->get();
            return view('backEnd.admin.add_query', compact('admission_query', 'follow_up_lists', 'references', 'classes', 'sources'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function queryFollowupStore(SmAdmissionQueryFollowUpRequest $request)
    {
        DB::beginTransaction();
        try {
            $admission_query = SmAdmissionQuery::find($request->id);
            $admission_query->next_follow_up_date = date('Y-m-d', strtotime($request->next_follow_up_date));

            // $admission_query->active_status = $request->active_status ?? 2;

            if ($admission_query->active_status == 1) {
                $admission_query->follow_up_date = date('Y-m-d', strtotime($request->follow_up_date));
            } else {
                $admission_query->follow_up_date = null;
            }

            $admission_query->school_id = Auth::user()->school_id;
            $admission_query->academic_id = getAcademicId();
            $admission_query->save();

            $follow_up = new SmAdmissionQueryFollowup();
            $follow_up->admission_query_id = $admission_query->id;
            $follow_up->active_status = $request->active_status ?? 2;
            $follow_up->response = $request->response;
            $follow_up->note = $request->note;
            $follow_up->date = date('Y-m-d', strtotime($request->next_follow_up_date));
            $follow_up->created_at = now()->setTimezone('Asia/Kolkata')->format('Y-m-d H:i:s');
            $follow_up->created_by = Auth::user()->id;
            $follow_up->school_id = Auth::user()->school_id;
            $follow_up->academic_id = getAcademicId();
            $follow_up->save();

            DB::commit();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function deleteFollowUp($id)
    {
        try {
            SmAdmissionQueryFollowup::destroy($id);

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            $admission_query = SmAdmissionQuery::find($request->id);
            SmAdmissionQueryFollowup::where('admission_query_id', $admission_query->id)->delete();
            $admission_query->delete();
            DB::commit();

            Toastr::success('Operation successful', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function admissionQuerySearch(SmAdmissionQuerySearchRequest $request)
    {
        try {
            $requestData = [];
            $date_from = date('Y-m-d', strtotime($request->date_from));
            $date_to = date('Y-m-d', strtotime($request->date_to));
            // dd($date_from);
            $requestData['date_from'] = $request->date_from;
            $requestData['date_to'] = $request->date_to;
            $requestData['source'] = $request->source;
            $requestData['status'] = $request->status;

            $date_from = $request->date_from;
            $date_to = $request->date_to;
            $source_id = $request->source;
            $status_id = $request->status;
            $classes = SmClass::get();
            $references = SmSetupAdmin::where('type', 4)->get();
            $sources = SmSetupAdmin::where('type', 3)->get();
            $status = SmSetupAdmin::where('type', 5)->get();
            return view('backEnd.admin.admission_query', compact('requestData', 'references', 'classes', 'sources', 'status', 'date_from', 'date_to', 'source_id', 'status_id'));
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function admissionQueryDatatable(Request $request)
    {
        try {
            if ($request->ajax()) {
                $date_from = date('Y-m-d', strtotime($request->date_from));
                $date_to = date('Y-m-d', strtotime($request->date_to));
                $admission_queries = SmAdmissionQuery::query()->latest();
                $admission_queries->with('sourceSetup', 'className', 'user', 'referenceSetup')->orderBy('id', 'DESC');
                if ($request->date_from != "" && $request->date_to) {
                    $admission_queries->whereBetween('date', [$date_from, $date_to]);
                }
                if ($request->source != "") {
                    $admission_queries->where('source', $request->source);
                }
                if ($request->status == "Pending") {

                    $admission_queries->where('active_status', 1);
                } else if ($request->status == "Converted") {
                    $admission_queries->where('active_status', 2);
                } else {

                    $admission_queries->where('active_status', 1);
                }
                return Datatables::of($admission_queries)
                    ->addIndexColumn()
                    ->addColumn('query_date', function ($row) {
                        return dateConvert(@$row->date);
                    })
                    ->addColumn('follow_up_date', function ($row) {
                        return  $row->follow_up_date;
                        // return dateConvert(@$row->follow_up_date);
                    })
                    ->addColumn('next_follow_up_date', function ($row) {
                        return dateConvert(@$row->next_follow_up_date);
                    })
                    ->addColumn('action', function ($row) {
                        $btn = '<div class="dropdown CRM_dropdown">
                                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">' . app('translator')->get('common.select') . '</button>
                                        
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="' . route('add_query', [@$row->id]) . '">' . __('admin.add_query') . '</a>' .
                            (userPermission('admission_query_edit') === true ? '<a class="dropdown-item modalLink" data-modal-size="large-modal"
                                            title="' . __('admin.edit_admission_query') . '" href="' . route('admission_query_edit', [$row->id]) . '">' . app('translator')->get('common.view') . '</a>' : '') .

                            (userPermission('admission_query_delete') === true ? (Config::get('app.app_sync') ? '<span data-toggle="tooltip" title="Disabled For Demo"><a class="dropdown-item" href="#" >' . app('translator')->get('common.disable') . '</a></span>' :
                                '<a onclick="deleteQueryModal(' . $row->id . ');"  class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteAdmissionQueryModal" data-id="' . $row->id . '"  >' . app('translator')->get('common.delete') . '</a>') : '') .
                            '</div>
                                    </div>';
                        return $btn;
                    })
                    ->rawColumns(['action', 'date'])
                    ->make(true);
            }
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            return redirect()->back();
        }
    }

    public function storeAttachment(Request $request)
    {
        try {
            $request->validate([
                'attachment' => 'required|file',
            ]);

            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = 'uploads/admission-query/' . $fileName;

            // Store the file in the public disk
            Storage::disk('public')->put($filePath, file_get_contents($file));

            SmAdmissionQueryAttachment::create([
                'admission_query_id' => $request->admission_query_id,
                'file_name' => $fileName,
                'file_path' => $filePath,
            ]);
            Toastr::success('File uploaded successfully', 'Success');
        } catch (\Exception $e) {
            Toastr::error('File upload failed: ' . $e->getMessage(), 'Error');
        }

        return redirect()->back();
    }

    public function downloadAttachment($id)
    {
            try {
                $attachment = SmAdmissionQueryAttachment::findOrFail($id);
                $filePath = storage_path('app/public/' . $attachment->file_path);

                if (Storage::disk('public')->exists($attachment->file_path)) {
                    ob_end_clean();
                    return response()->download($filePath, $attachment->file_name);
                } else {
                    Toastr::error('File not found', 'Error');
                    return redirect()->back();
                }
            } catch (\Exception $e) {
                Toastr::error('File download failed: ' . $e->getMessage(), 'Error');
                return redirect()->back();
            }
    }

    public function deleteAttachment($id)
    {
        try {
            $attachment = SmAdmissionQueryAttachment::findOrFail($id);
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
            $attachment->delete();
            Toastr::success('File deleted successfully', 'Success');
        } catch (\Exception $e) {
            Toastr::error('File deletion failed: ' . $e->getMessage(), 'Error');
        }

        return redirect()->back();
    }

    public function setReminder(Request $request, $id)
    {
        try {
            $request->validate([
                'reminder_at' => 'required|date',
                'reminder_notes' => 'nullable|string',
                'is_notify' => 'nullable|boolean',
            ]);

            $admissionQuery = SmAdmissionQuery::findOrFail($id);

            if (!$admissionQuery) {
                Toastr::error('Admission query not found', 'Error');
                return redirect()->back();
            }

            $reminder = $admissionQuery->reminders()->create([
                'reminder_at' => $request->reminder_at,
                'reminder_notes' => $request->reminder_notes,
                'is_notify' => $request->is_notify ?? 2,
            ]);

            if ($request->is_notify == 1) {
                $job = (new ReminderJob($reminder, 'remindercreated'))->delay(Carbon::now()->addSeconds(10));
                dispatch($job);
            }

            Toastr::success('Reminder set successfully', 'Success');
        } catch (\Exception $e) {
            Toastr::error('Set reminder failed: ' . $e->getMessage(), 'Error');
        }
        return redirect()->back();
    }

    public function getReminders($id)
    {
        $admissionQuery = SmAdmissionQuery::findOrFail($id);
        $reminders = $admissionQuery->reminders;

        return response()->json($reminders);
    }

    public function deleteReminder($id)
    {
        try {
            $reminder = SmAdmissionQueryReminder::findOrFail($id);
            $reminder->delete();

            Toastr::success('Reminder deleted successfully', 'Success');
        } catch (\Exception $e) {
            Toastr::error('Reminder deleted failed: ' . $e->getMessage(), 'Error');
        }

        return redirect()->back();
    }

    public function toggleApproval(Request $request, $id)
    {
        $query = SmAdmissionQuery::findOrFail($id);
        $query->active_status = $query->active_status == 2 ? 1 : 2;
        $query->save();

        return response()->json([
            'success' => true,
            'is_approved' => $query->active_status,
            'button_text' => $query->active_status == 1 ? 'Revert to Student' : 'Convert to Student'
        ]);
    }

    public function convertToStudent(Request $request)
    {
        $admissionQuery = SmAdmissionQuery::findOrFail($request->admission_query_id);

        DB::beginTransaction();
        try {

            $admissionQuery->active_status = 2;
            $admissionQuery->save();

            $student = new SmStudent();
            $student->admission_no = mt_rand(1, 99999);
            $student->roll_no = mt_rand(1, 99999);
            $splitName = explode(' ', $admissionQuery->name, 2);
            $first_name = $splitName[0];
            $last_name = !empty($splitName[1]) ? $splitName[1] : '';
            $student->first_name = $first_name ?? NULL;
            $student->last_name = $last_name ?? NULL;
            $student->full_name = $admissionQuery->name;
            $student->email = $admissionQuery->email;
            $student->mobile = $admissionQuery->phone;
            $student->admission_date = now();
            $student->class_id = $admissionQuery->class_id;

            $student->save();

            $user = new User();
            $user->role_id = 2;
            $user->full_name = $student->full_name;
            $user->email = $student->email;
            $user->username = $student->email ?? NULL;
            $user->password = Hash::make('123456');
            $user->save();

            $student->user_id = $user->id;
            $student->role_id = $user->role_id;
            $student->school_id = Auth::user()->school_id;
            $student->active_status = 2;
            $student->save();



            DB::commit();

            return response()->json([
                'success' => true,
                'student_id' => $student->id
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false], 500);
        }
    }
}
