<style>
    .input-right-icon button {
        position: absolute;
        top: 50%;
        right: 15px;
        display: inline-block;
        transform: translateY(-50%);
    }

    .input-right-icon button i {
        position: unset;
    }

    .head-tab {
        background: #0e72c8 ;
        color: #fff;
        padding: 2px 15px;
        border-radius: 3px;
        display: inline;
        font-weight: 500;
        font-size: 15px;
    }
    .general-head-tab {
        background: #0e72c8  ;
        color: #fff;
        padding: 2px 15px;
        border-radius: 3px;
        display: inline;
        font-weight: 500;
        font-size: 15px;
    }
    .payment-head-tab {
        background: #0e72c8 ;
        color: #fff;
        padding: 2px 15px;
        border-radius: 3px;
        display: inline;
        font-weight: 500;
        font-size: 15px;
    }

    #removeIc {
        display: flex;
        align-items: center;
        position: absolute;
        right: 10px;
        top: 10px;
    }

    /* Tab navigation styles */
    .tab {
        overflow: hidden;
        border-bottom: 1px solid gainsboro;
    }

    .tab button {
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 30px;
        font-size: 15px;
        color: rgb(163, 162, 162);
        background: none;
        transition: 0.3s;
    }

    .tab button:hover {
        color: #7c32ff;
        border-bottom: 2px solid #7c32ff;
    }

    .tab button.active {
        color: #7c32ff;
        font-weight: 600;
        border-bottom: 2px solid #7c32ff;
    }

    .tabcontent {
        display: none;
        padding: 20px;
        border-top: none;
    }

    .tabcontent.show {
        display: block;
    }

    .notes-list {
        max-height: 500px;
        /* overflow-y: auto; */
    }

    .single-note {
        background-color: #f9f9f9;
        border-left: 4px solid #7c32ff;
        padding: 15px;
        margin-bottom: 15px;
        position: relative;
    }

    .single-note h5 {
        color: #7c32ff;
        margin-bottom: 10px;
    }

    .active-note {
        background-color: #f9f9f9;
        border-left: 4px solid #7c32ff;
        padding: 15px;
        position: relative;
    }

    .active-note h5 {
        color: #7c32ff;
        margin-bottom: 10px;
    }

    .active-note::before,
    .active-note::after {
        content: '';
        position: absolute;
        left: -6px;
        width: 9.5px;
        height: 9.5px;
        border: 1px solid #7c32ff;
        background-color: rgb(252, 249, 249);
        border-radius: 50%;
    }

    .active-note::before {
        top: -4px;
    }

    .active-note::after {
        bottom: -4px;
    }

    .upload-container {
        width: 100%;
        padding: 20px;
        border: 2px dashed #ccc;
        border-radius: 5px;
        text-align: center;
        margin-bottom: 20px;
    }

    .upload-container {
        transition: all 0.2s ease;
    }

    .upload-container.is-dragover {
        background-color: #f7f7f7;
        border-color: #7c32ff;
    }

    .upload-label {
        display: block;
        font-size: 18px;
        color: #777;
        cursor: pointer;
        padding: 40px 0;
    }

    .upload-label i {
        font-size: 48px;
        margin-bottom: 10px;
    }

    .upload-btn {
        margin-top: 10px;
    }

    .files-container {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 20px;
    }

    .file-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    .file-item {
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 15px;
        display: flex;
        align-items: center;
    }

    .file-icon {
        font-size: 24px;
        margin-right: 15px;
        color: #7c32ff;
    }

    .file-info {
        flex-grow: 1;
    }

    .file-name {
        display: block;
        font-weight: bold;
    }

    .file-size {
        font-size: 12px;
        color: #777;
    }

    .file-actions {
        display: flex;
        gap: 5px;
    }

    .badge-active {
        padding: 3px 8px;
        background-color: rgb(24, 104, 24);
        border-radius: 10px;
        color: #fff;
        font-size: 11px;
        border-color: rgb(168, 252, 168)
    }

    .badge-inactive {
        padding: 3px 8px;
        background-color: #7c32ff;
        border-radius: 10px;
        color: #fff;
        font-size: 11px;
        border-color: rgb(178, 158, 253)
    }

    .status-badge.badge-active {
        display: contents !important;
    }

    .status-badge.badge-inactive {
        display: contents !important;
    }
    #convertToStudentBtn{
        background-color:#209c42  !important;
    }
    #btn-view-covertToStudent{
        background-color:#209c42  !important;
    }
    #btn-edit{
        background-color:#d6822d  !important; 
    }
    #btn-view{
        background-color:#d6822d  !important; 
    }
</style>


<div class="container-fluid">
    <div class="tab d-flex w-100 border-none">
        <button class="tablinks" onclick="openTab(event, 'Profile')">Profile</button>
        <button class="tablinks" onclick="openTab(event, 'Attachments')">Attachments
            <span
                style="padding:2px 8px;background-color:#8e4ffc;border-radius:50%;color:#fff;font-weight:500;font-size:12px;">
                {{ @$admission_query->attachments->count() }}</span>
        </button>
        <button class="tablinks" onclick="openTab(event, 'Reminder')">Reminders <span
                style="padding:2px 8px;background-color:#8e4ffc;border-radius:50%;color:#fff;font-weight:500;font-size:12px;">
                {{ @$admission_query->reminders->count() }}</span></button>
        <button class="tablinks" onclick="openTab(event, 'Notes')">Notes
            <span
                style="padding:2px 8px;background-color:#8e4ffc;border-radius:50%;color:#fff;font-weight:500;font-size:12px;">
                {{ @$admission_query->followups->count() }}</span></button>
        <button class="tablinks" onclick="openTab(event, 'Activity')">Activity Logs</button>
    </div>

    <div id="Profile" class="tabcontent">
        <div class="row justify-content-right">
            <div class="col-lg-12">
                <div class="d-flex w-100 justify-content-end" style="gap: 0.5em">
                    <button type="button" class="primary-btn fix-gr-bg" id="convertToStudentBtn">
                        <i class="ti-user" id="student-user"></i>Convert to Student
                    </button>
                    <button type="button" class="primary-btn fix-gr-bg" id="btn-edit" onclick="openTab(event, 'Edit')">Edit</button>
                    {{-- <div class="dropdown">
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                            More
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="#">Move to junk</a>
                            <a class="dropdown-item" href="#">Move to lost</a>
                        </div>
                    </div> --}}
                </div>
                <hr class="w-100" />
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                        <div class="head-tab">Leads Information</div>

                        <div class="body-tab mt-2">
                            <div class="mt-1">
                                <span class="text-dark">Name</span>
                                <span class="d-block">{{ @$admission_query->name }}</span>
                            </div>
                            <div class="mt-1">
                                <span class="text-dark">Class</span>
                                <span
                                    class="d-block text-capitalize">{{ @$admission_query->className->class_name ?? 'N/A' }}</span>
                            </div>
                            <div class="mt-1">
                                <span class="text-dark">Email Address</span>
                                <span class="d-block">{{ @$admission_query->email }}</span>
                            </div>
                            <div class="mt-1">
                                <span class="text-dark">Phone</span>
                                <span class="d-block">{{ @$admission_query->phone }}</span>
                            </div>
                            <div class="mt-1">
                                <span class="text-dark">Address</span>
                                <span class="d-block">{{ @$admission_query->address }}</span>
                            </div>
                            <div class="mt-1">
                                <span class="text-dark">Description</span>
                                <span class="d-block">{{ @$admission_query->description }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                        <div class="general-head-tab font-bold">General Information</div>

                        <div class="body-tab mt-2">
                            <div class="mt-1">
                                <span class="text-dark">Status</span>
                                <div class="d-block">
                                    <div class="status-badge">
                                        @if ($admission_query->student_status == 1)
                                            <span
                                                style="padding: 3px 8px;background-color:rgb(24, 104, 24);border-radius:10px;color:#fff;font-size:11px;border-color:rgb(168, 252, 168)">Active</span>
                                        @else
                                            <span
                                               class="badge badge-danger" style="padding: 5px 8px;border-radius:10px;color:#fff;font-size:11px;border-color:rgb(178, 158, 253)">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="mt-1">
                                <span class="text-dark">Source</span>
                                <span class="d-block">{{ @$admission_query->sourceSetup->name ?? 'N/A' }}</span>
                            </div>
                            <div class="mt-1">
                                <span class="text-dark">Assigned</span>
                                <span class="d-block">{{ @$assignee_name->full_name }}</span>
                            </div>
                            <div class="mt-1">
                                <span class="text-dark">Created At</span>
                                <span
                                    class="d-block">{{ Carbon::parse(@$admission_query->created_at)->diffForHumans() }}</span>
                            </div>
                            <div class="mt-1">
                                <span class="text-dark">Last Contact</span>
                                <span
                                    class="d-block">{{ Carbon::parse(@$admission_query->follow_up_date)->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                        <div class="payment-head-tab font-bold">Payment Status</div>

                        <div class="mt-1">
                            <span class="text-dark">Status</span>
                            <div class="d-block">
                                <div class="status-badge">
                                                                    @if ($paymentStatus->payment_status == 'paid')
                                        <span class="badge badge-success"
                                            style="padding: 5px 8px;border-radius:10px;color:#fff;font-size:12px;border-color:rgb(178, 158, 253)">Paid</span>
                                            @elseif ($paymentStatus->payment_status == 'partial')
                                        <span class="badge badge-warning"
                                            style="padding: 5px 8px;border-radius:10px;color:#fff;font-size:12px;border-color:rgb(178, 158, 253)">partial</span>
                                            @elseif (!$paymentStatus->payment_status || $paymentStatus->payment_status == 'null')
                                        <span class="badge badge-info"
                                            style="padding: 5px 8px;border-radius:10px;color:#fff;font-size:12px;border-color:rgb(178, 158, 253)">NULL</span>

                                    @else
                                        <span class="badge badge-danger"
                                            style="padding: 5px 8px;border-radius:10px;color:#fff;font-size:11px;border-color:rgb(168, 252, 168)">unpaid</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-1">
                            <span class="text-dark">Total Amount</span>
                            <span class="d-block">{{ @$amount->amount }}</span>
                        </div>

                        <div class="mt-1">
                            <span class="text-dark">Due Amount</span>
                            <span class="d-block">{{ @$balance_amount->due_amount }}</span>
                        </div>

                        <div class="mt-1">
                            <span class="text-dark">Paid Amount</span>
                            <span class="d-block">{{ @$balance_amount->paid_amount }}</span>
                        </div>
                        @if ($paymentStatus->payment_status == 'paid')
                        @else
                        <a href="{{ url('fees/admin-fees-payment/' . $paymentStatus->id) }}" type="button"
                            class="btn btn-primary" id="makePayment" style="margin-top: 14px;border-radius:20px;">
                            <i class="ti-credit-card" id="student-user"></i> <b>Make Payment</b>
                        </a>
                @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row my-5">
            <div class="head-lead w-100" style="background-color:#7c32ff;color:#fff;padding:4px 20px;font-weight:600;">
                Latest Activity
            </div>
            <div class="col-lg-12 mt-2">
                <div class="notes-list">
                    @if ($latestFollowUp = $admission_query->followUps()->latest()->first())
                        <div class="single-note">
                            <h5>{{ Carbon::parse($latestFollowUp->created_at)->diffForHumans() }}</h5>
                            <p>{{ $latestFollowUp->note }}</p>
                        </div>
                    @else
                        <p>No log available.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <div id="Edit" class="tabcontent">
        <div class="d-flex w-100 justify-content-end" style="gap: 0.5em">
            <button type="button" class="primary-btn fix-gr-bg submit" id="btn-view-covertToStudent"><i class="ti-user" id="student-user"></i>
                Convert to Student</button>
            <button type="button" class="primary-btn small fix-gr-bg submit" id="btn-view"
                onclick="openTab(event, 'Profile')">View</button>
        </div>
        <hr class="w-100" />
        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'admission_query_update', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'admission-query-store']) }}
        <input type="hidden" name="id" value="{{ @$admission_query->id }}">
        <div class="row">
            <div class="" id="editAdmissionQuery">
                <div class="container-fluid">
                    <form action="">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('common.name') <span
                                                    class="text-danger"> *</span></label>
                                            <input class="primary_input_field read-only-input form-control"
                                                type="text" name="name" id="name"
                                                value="{{ @$admission_query->name }}" required>

                                            <span class="text-danger" id="nameError">
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="primary_input">
                                            <label class="primary_input_label"
                                                for="">@lang('common.phone')</label>
                                            <input oninput="phoneCheck(this)"
                                                class="primary_input_field read-only-input form-control"
                                                type="text" name="phone" id="phone"
                                                value="{{ @$admission_query->phone }}">

                                            </span>


                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="primary_input">
                                            <label class="primary_input_label"
                                                for="">@lang('common.email')</label>
                                            <input oninput="emailCheck(this)"
                                                class="primary_input_field read-only-input form-control"
                                                type="text" name="email"
                                                value="{{ @$admission_query->email }}">


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-25">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('common.address')
                                                <span></span>
                                            </label>
                                            <textarea class="primary_input_field form-control has-content" cols="0" rows="3" name="address"
                                                id="address">{{ @$admission_query->address }}</textarea>

                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('common.description')
                                                <span></span>
                                            </label>
                                            <textarea class="primary_input_field form-control has-content" cols="0" rows="3" name="description"
                                                id="description">{{ @$admission_query->description }}</textarea>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-25">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="primary_input">
                                                    <label class="primary_input_label"
                                                        for="">@lang('common.date')</label>
                                                    <div class="position-relative">
                                                        <input
                                                            class="primary_input_field  primary_input_field date form-control form-control has-content"
                                                            id="startDate" type="text" name="date"
                                                            value="{{ @$admission_query->date != '' ? date('m/d/Y', strtotime(@$admission_query->date)) : date('m/d/Y') }}">
                                                        <button class="btn-date" data-id="#date_from" type="button">
                                                            <label class="m-0 p-0" for="startDate">
                                                                <i class="ti-calendar" id="start-date-icon"></i>
                                                            </label>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="no-gutters input-right-icon">
                                            <div class="col">
                                                <div class="primary_input">
                                                    <label class="primary_input_label"
                                                        for="">@lang('academics.next_follow_up_date')</label>
                                                    <div class="position-relative">
                                                        <input
                                                            class="primary_input_field  primary_input_field date form-control form-control has-content"
                                                            id="endDate" type="text" name="next_follow_up_date"
                                                            value="{{ @$admission_query->next_follow_up_date != '' ? date('m/d/Y', strtotime(@$admission_query->next_follow_up_date)) : date('m/d/Y') }}">
                                                        <button class="btn-date" data-id="#date_from" type="button">
                                                            <label class="m-0 p-0" for="endDate">
                                                                <i class="ti-calendar" id="end-date-icon"></i>
                                                            </label>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="primary_input">
                                        <label class="primary_input_label" for="">@lang('admin.assigned')
                                            *<span></span></label>
                                        <select class="primary_select " name="assigned" id="assigned" required>
                                            <option data-display="@lang('academics.assigned') *" value="">
                                                @lang('academics.assigned') *
                                            </option>
                                            @foreach ($assignees as $assignee)
                                                <option value="{{ @$assignee->id }}"
                                                    {{ @$assignee->id == @$assignee_name->id ? 'selected' : '' }}>
                                                    {{ @$assignee->full_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="assignedError">
                                        </span>
                                            <!-- <label class="primary_input_label" for="">@lang('academics.assigned')
                                                <span></span></label>
                                            <input class="primary_input_field read-only-input form-control"
                                                type="text" name="assigned"
                                                value="{{ @$admission_query->assigned }}" id="assigned" required>

                                            <span class="text-danger" id="assignedError"> </span> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-25">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label class="primary_input_label" for="">@lang('academics.reference')
                                            <span></span></label>
                                        <select class="primary_select " name="reference" id="reference">
                                            <option data-display="@lang('academics.reference')" value="">@lang('academics.reference')
                                            </option>
                                            @foreach ($references as $reference)
                                                <option value="{{ @$reference->id }}"
                                                    {{ @$reference->id == @$admission_query->reference ? 'selected' : '' }}>
                                                    {{ @$reference->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="referenceError"></span>
                                    </div>
                                    <div class="col-lg-3">
                                        <label class="primary_input_label" for="">@lang('admin.source')
                                            *<span></span></label>
                                        <select class="primary_select " name="source" id="source" required>
                                            <option data-display="@lang('academics.source') *" value="">
                                                @lang('academics.source') *
                                            </option>
                                            @foreach ($sources as $source)
                                                <option value="{{ @$source->id }}"
                                                    {{ @$source->id == @$admission_query->source ? 'selected' : '' }}>
                                                    {{ @$source->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="sourceError">
                                        </span>
                                    </div>

                                    <div class="col-lg-3">
                                        <label class="primary_input_label" for="">Student Status
                                            *<span></span></label>
                                        <select class="primary_select " name="student_status" id="student_status" required>
                                        <option data-display="Student Status *" value="">Student Status *</option>
                                                @foreach($student_status as $status)
                                                    <option value="1" {{$status->student_status == 1 ? 'selected' : ''}}>
                                                        Active
                                                    </option>
                                                    <option value="2" {{$status->student_status == 2 ? 'selected' : ''}}>
                                                        Inactive
                                                    </option>
                                                @endforeach
                                        </select>
                                        <span class="text-danger" id="studentStatusError">
                                        </span>
                                    </div>
                                    @if (moduleStatusCheck('University') == false)
                                        <div class="col-lg-3">
                                            <label class="primary_input_label" for="">@lang('common.class')
                                                *<span></span></label>
                                            <select class="primary_select " name="class" id="class"
                                                id="class" required>

                                                <option data-display="@lang('common.class')" value="">
                                                    @lang('common.class')
                                                </option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ @$class->id }}"
                                                        {{ @$class->id == @$admission_query->class ? 'selected' : '' }}>
                                                        {{ @$class->class_name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="classError"></span>
                                        </div>
                                    @endif
                                    <div class="col-lg-3 mt-25">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('academics.number_of_child')
                                                <span></span></label>
                                            <input oninput="numberCheck(this)"
                                                class="primary_input_field form-control has-content" type="text"
                                                name="no_of_child" value="{{ @$admission_query->no_of_child }}"
                                                id="no_of_child">

                                            <!-- <span class="text-danger" id="no_of_childError"></span> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (moduleStatusCheck('University'))
                                <div class="col-lg-12 mt-25">
                                    <div class="row">
                                        @if (moduleStatusCheck('University'))
                                            @includeIf(
                                                'university::common.session_faculty_depart_academic_semester_level',
                                                [
                                                    'div' => 'col-lg-4',
                                                    'niceSelect' => 'niceSelect1',
                                                    'rowMt' => 'mt-25',
                                                    'hide' => ['USUB'],
                                                    'required' => ['USN', 'UF', 'UD', 'UA', 'US', 'USL'],
                                                ]
                                            )
                                            <input type="hidden" name="un_academic_id" id="select_academic"
                                                value="{{ getAcademicId() }}">
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-12 text-center mt-30">
                                <div class="mt-40 d-flex justify-content-between">
                                    <button type="button" class="primary-btn tr-bg"
                                        data-dismiss="modal">@lang('common.cancel')</button>
                                    <button class="primary-btn fix-gr-bg submit" id="update_button_query"
                                        type="submit">@lang('common.update')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>

    <div id="Attachments" class="tabcontent">
        <div class="upload-container">
            <form action="{{ route('admission_query_attachment_store') }}" method="POST"
                enctype="multipart/form-data" class="upload-form">
                @csrf
                <input type="hidden" name="admission_query_id" value="{{ @$admission_query->id }}">
                <div class="form-group">
                    <label for="attachment" class="upload-label">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Choose a file or drag it here</span>
                    </label>
                    <input type="file" class="form-control-file" id="attachment" name="attachment" hidden>
                </div>
                <button type="submit" class="primary-btn small fix-gr-bg">Upload</button>
            </form>
        </div>

        <div class="mt-4">
            <h5>Attached Files</h5>
            <ul class="list-group">
                @foreach ($admission_query->attachments as $attachment)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $attachment->file_name }}
                        <div class="d-flex align-items-baseline gap-10">
                            <a href="{{ route('admission_query_attachment_download', $attachment->id) }}"
                                class="primary-btn small fix-gr-bg">Download</a>
                            <form action="{{ route('admission_query_attachment_delete', $attachment->id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this file?')">Delete</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="fileModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fileModalLabel">File Preview</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe id="filePreview" src="" style="width: 100%; height: 500px;"
                            frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="Reminder" class="tabcontent">
        <button id="openReminderModal" class="primary-btn small fix-gr-bg mt-1">
            <i class="fas fa-bell"></i> Set Reminder
        </button>

        <div class="mt-4">
            {{-- <div class="table-responsive">
                <table class="table table-bordered w-100 scrolled_table">
                    <thead style="background: lightgray;">
                        <tr>
                            <th style="font-size: 15px;font-weight:500;">Remider Date & Time</th>
                            <th style="font-size: 15px;font-weight:500;">Reminder Notes</th>
                            <th style="font-size: 15px;font-weight:500;">Is Notified</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admission_query->reminders as $reminder)
                            <tr>
                                <td class="px-2">
                                    {{ \Carbon\Carbon::parse($reminder->reminder_at)->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-2">{{ $reminder->reminder_notes }}</td>
                                <td class="px-2">{{ $reminder->is_notify }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> --}}

            <x-table>
                <table id="table_ids" class="table balance-custom-table" cellspacing="0" width="100%">

                    <thead>
                        <tr>
                            <th>Remider Date&Time</th>
                            <th>Remider Notes</th>
                            <th>Is Notified</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($admission_query->reminders as $reminder)
                            <tr>
                                <td>{{ $reminder->reminder_at }}</td>
                                <td>{{ $reminder->reminder_notes }}</td>
                                <td>
                                    {{ $reminder->is_notify == 1 ? 'Yes' : 'No' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-table>
        </div>
    </div>
    <!-- Reminder Modal -->
    <div class="modal fade" id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="reminderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reminderModalLabel">Set Reminder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admission_set_reminder', ['id' => @$admission_query->id]) }}"
                        method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="reminder_at">Reminder Date & Time</label>
                            <input class="form-control" type="datetime-local" name="reminder_at" required />
                        </div>
                        <div class="form-group">
                            <label for="reminder_note">Reminder Note:</label>
                            <textarea id="reminder_notes" name="reminder_notes" placeholder="Reminder notes..." class="form-control"
                                rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="is_notify" id="is_notify" class="custom-control-input"
                                    value='1'>
                                <label class="custom-control-label" for="is_notify">Is notify for email?</label>
                            </div>
                        </div>
                        <button type="submit" class="primary-btn small fix-gr-bg mt-1">Set Reminder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div id="Notes" class="tabcontent">
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('query_followup_store') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ @$admission_query->id }}">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="no-gutters input-right-icon">
                                    <div class="col">
                                        <div class="primary_input">
                                            <label class="primary_input_label"
                                                for="">@lang('academics.next_follow_up_date')</label>
                                            <div class="position-relative">
                                                <input
                                                    class="primary_input_field  primary_input_field date form-control form-control has-content"
                                                    id="endDate" type="text" name="next_follow_up_date"
                                                    autocomplete="on"
                                                    value="{{ @$admission_query->next_follow_up_date != '' ? date('m/d/Y', strtotime(@$admission_query->next_follow_up_date)) : date('m/d/Y') }}">
                                                <button class="btn-date" data-id="#date_from" type="button">
                                                    <label class="m-0 p-0" for="endDate">
                                                        <i class="ti-calendar" id="end-date-icon"></i>
                                                    </label>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="response">Response
                                        <span></span></label>
                                    <input class="primary_input_field read-only-input form-control" name="response"
                                        placeholder="Enter response here..." required>
                                    <span class="text-danger" id="responseError"> </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <div class="primary_input">
                            <label class="primary_input_label" for="">Add Note</label>
                            <textarea class="primary_input_field form-control" name="note" id="note" rows="5"
                                placeholder="Enter your note here..."></textarea>
                        </div>
                    </div>
                    <br />
                    <div class="col-lg-6 mt-3" id="follow_up_date_div" style="display: none;">
                        <div class="no-gutters input-right-icon">
                            <div class="col">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="">Contacted Date</label>
                                    <div class="position-relative">
                                        <input class="primary_input_field date form-control" id="follow_up_date"
                                            type="text" name="follow_up_date" autocomplete="off">
                                        <button class="btn-date" data-id="#follow_up_date" type="button">
                                            <i class="ti-calendar" id="start-date-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-3">
                        <div class="d-flex" style="align-items: baseline;gap:0.4em;">
                            <input type="radio" name="active_status" id="active_status_1" value="1"
                                class="common-radio relationButton" onclick="toggleFollowUpDate(1)"
                                style="margin-top: 4px;">
                            <label for="active_status_1">I got in touch with this lead</label>
                        </div>

                        <div class="d-flex" style="align-items: baseline;gap:0.4em;">
                            <input type="radio" name="active_status" id="active_status_2" value="2"
                                class="common-radio relationButton" onclick="toggleFollowUpDate(2)" checked
                                style="margin-top: 4px;">
                            <label for="active_status_2">I have not contacted this lead</label>
                        </div>
                    </div>

                </div>
                <div class="row mt-20">
                    <div class="col-lg-12 text-right">
                        <button type="submit" class="primary-btn small fix-gr-bg">Save Note</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-40">
        <div class="col-lg-12">
            <div class="white-box">
                <h3 class="mb-30">Previous Notes</h3>
                <div class="notes-list">
                    @forelse($admission_query->followups as $followup)
                        <div class="single-note mb-20">
                            <h5>
                                @if ($followup->active_status == 1)
                                    <i class="fas fa-phone-alt mr-2" style="color: green;"></i>
                                @endif
                                {{ $followup->created_at->format('M d, Y h:i A') }}
                            </h5>
                            <p>{{ $followup->note }}</p>
                            <i class="ti-trash delete-note" id="removeIc"
                                onclick="deleteFollowUp({{ $followup->id }})"
                                style="float: right; cursor: pointer;color:indianred;align-items:center;"></i>
                        </div>
                    @empty
                        <p>No notes available.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div id="Activity" class="tabcontent">

    <div class="notes-list">
        @php
            $activities = $admission_query->followups
                ->concat($admission_query->reminders)
                ->concat($admission_query->attachments)
                ->sortByDesc('created_at');
        @endphp

        @foreach ($activities as $activity)
            <div class="active-note">
                <h5>{{ Carbon::parse($activity->created_at)->diffForHumans() }}</h5>
                @if ($activity->note != '' || $activity->note != null)
                    <p>Note : <span class="text-dark fw-bold">{{ $activity->note }}</span></p>
                @elseif($activity->reminder_notes != null || $activity->reminder_notes != '')
                    <p>Reminder set : <span class="text-dark fw-bold">{{ $activity->reminder_notes }}</span></p>
                @elseif($activity->file_name != null)
                    <p>Attachement uploaded : <span class="text-dark fw-bold">{{ $activity->file_name }}</span>
                    </p>
                @else
                    <p>No Notes And Reminders logs available.</p>
                @endif
            </div>
        @endforeach
    </div>



    <!-- /****************************Edit student log************************************/    -->


    <div class="notes-list">

        <div class="active-note">

            @if (isset($admission_query->updated_at) && $admission_query->updated_at != $admission_query->created_at)
                <h5>{{ Carbon::parse($admission_query->updated_at)->diffForHumans() }}</h5>
                <p>Status : <span class="text-dark fw-bold">Student Updated...!</span></p>
            @elseif(isset($admission_query->active_status) && $admission_query->active_status == 2)
                <h5>{{ Carbon::parse($admission_query->updated_at)->diffForHumans() }}</h5>
                <p>Status : <span class="text-dark fw-bold">Student Updated...!</span></p>
            @else
                <p>No Student Updation logs available.</p>
            @endif
        </div>

    </div>



    <!-- /****************************Edit student log************************************/    -->

    <!-- /****************************Status Active Or InActive student log************************************/    -->


    <div class="notes-list">

        <div class="active-note">

            @if (isset($admission_query->student_status) && $admission_query->student_status == 1)
                <h5>{{ Carbon::parse($admission_query->created_at)->diffForHumans() }}</h5>
                <p>Status : <span class="text-dark fw-bold">Student Active</span></p>
            @elseif(isset($admission_query->student_status) && $admission_query->student_status == 2)
                <h5>{{ Carbon::parse($admission_query->created_at)->diffForHumans() }}</h5>
                <p>Status : <span class="text-dark fw-bold">Student InActive</span></p>
            @else
                <p>No Active Or InActive logs available.</p>
            @endif
        </div>

    </div>


    <!-- /****************************Status Active Or InActive student log************************************/    -->

    <!-- /****************************Status Paid Or UnPaid student log************************************/    -->


    <div class="notes-list">

        <div class="active-note">

                    @if (isset($paymentStatus->payment_status))

                    @php
                        $timeDifference = Carbon::parse($paymentStatus->created_at)->diffForHumans();
                         $updatedTime = Carbon::parse($paymentStatus->updated_at)->diffForHumans();
                    @endphp

                    @if ($paymentStatus->payment_status == 'Unpaid')
                        <h5>{{ $timeDifference }}</h5>
                        <p>Status : <span class="text-dark fw-bold"> Payment Unpaid</span></p>
                    @elseif($paymentStatus->payment_status == 'partial')
                        <h5>{{ $updatedTime }}</h5>
                        <p>Status : <span class="text-dark fw-bold"> Payment Partially Paid</span></p>
                    @elseif($paymentStatus->payment_status == 'paid')
                        <h5>{{ $updatedTime }}</h5>
                        <p>Status : <span class="text-dark fw-bold"> Payment Paid</span></p>
                    @endif

                    @else
                        <p>No Payment logs available.</p>
                    @endif
        </div>

    </div>




    <!-- /****************************Status Paid Or UnPaid student log************************************/    -->

    <!-- /****************************Student Attachment log************************************/    -->



    {{-- <div class="notes-list">
            @php 

            $attachments = $admission_query->attachments()->where('status', '!=',NULL)->orderBy('id','DESC')->first();
            @endphp
                <div class="active-note">

                @if (isset($attachments->status) && $attachments->status == 2)
                    <h5>{{ Carbon::parse($attachments->created_at)->diffForHumans() }}</h5>
                    <p>Status : <span class="text-dark fw-bold"> Attachment Uploaded</span></p>
                @elseif(isset($attachments->status) && $attachments->status == 1 )
                    <h5>{{ Carbon::parse($attachments->created_at)->diffForHumans() }}</h5>
                    <p>Status : <span class="text-dark fw-bold"> Attachment Not Yet Uploaded</span></p>
                @else 
                    <p>No Attachments available.</p>
                @endif
                </div>  
         
        </div> --}}




    <!-- /****************************Student Attachment log************************************/    -->




    <!-- /****************************Student convert log************************************/    -->



    <div>
        <div class="notes-list">

            <div class="active-note">

                @if (isset($admission_query->active_status) && $admission_query->active_status == 2)
                    <h5>{{ Carbon::parse($admission_query->created_at)->diffForHumans() }}</h5>
                    <p>Status : <span class="text-dark fw-bold"> Student Converted</span></p>
                @elseif(isset($admission_query->active_status) && $admission_query->active_status == 1)
                    <h5>{{ Carbon::parse($admission_query->created_at)->diffForHumans() }}</h5>
                    <p>Status : <span class="text-dark fw-bold"> Student Registered Successfully</span></p>
                @else
                    <p>Student Convertion not available .</p>
                @endif
            </div>

        </div>
    </div>


    <!-- /****************************Student convert log************************************/    -->





</div>


</div>

{{ Form::close() }}

@include('backEnd.partials.date_picker_css_js')
<script>
    $('.input-right-icon button').on("click", function() {
        $(this).parent().find("input").focus();
    });

    $("#search-icon").on("click", function() {
        $("#search").focus();
    });

    $("#start-date-icon").on("click", function() {
        $("#startDate").focus();
    });

    $("#end-date-icon").on("click", function() {
        $("#endDate").focus();
    });

    $(".primary_input_field.date").datepicker({
        autoclose: true,
        setDate: new Date(),
    });
    $(".primary_input_field.date").on("changeDate", function(ev) {
        // $(this).datepicker('hide');
        $(this).focus();
    });

    $(".primary_input_field.time").datetimepicker({
        format: "LT",
    });

    if ($(".niceSelect1").length) {
        $(".niceSelect1").niceSelect();
    }

    $(".primary_select").niceSelect('destroy');
    $(".primary_select").niceSelect();

    function toggleFollowUpDate(status) {
        if (status == 1) {
            $('#follow_up_date_div').show();
        } else {
            $('#follow_up_date_div').hide();
        }
    }

    $(document).ready(function() {
        $('#active_status_2').prop('checked', true);
        toggleFollowUpDate(2);
    });

    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    document.querySelector(".tablinks").click();


    function deleteFollowUp(id) {

        $.ajax({
            type: "GET",
            url: "{{ route('delete_follow_up', '') }}/" + id,
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                console.log(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

    }

    $(document).ready(function() {
        $('.view-file').on('click', function() {
            var fileUrl = $(this).data('file');
            $('#filePreview').attr('src', fileUrl);
        });

        $('#fileModal').on('hidden.bs.modal', function() {
            $('#filePreview').attr('src', '');
        });
    });

    $(document).ready(function() {
        $('.upload-form button[type="submit"]').prop('disabled', true);

        $('#attachment').on('change', function(e) {
            var fileName = e.target.files[0] ? e.target.files[0].name : 'Choose a file or drag it here';
            $('.upload-label span').text(fileName);

            if (e.target.files.length > 0) {
                $('.upload-form button[type="submit"]').prop('disabled', false);
            } else {
                $('.upload-form button[type="submit"]').prop('disabled', true);
            }
        });

        $('.upload-container').on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
            })
            .on('dragover dragenter', function() {
                $(this).addClass('is-dragover');
            })
            .on('dragleave dragend drop', function() {
                $(this).removeClass('is-dragover');
            })
            .on('drop', function(e) {
                var file = e.originalEvent.dataTransfer.files[0];
                $('#attachment')[0].files = e.originalEvent.dataTransfer.files;
                $('.upload-label span').text(file ? file.name : 'Choose a file or drag it here');

                if ($('#attachment')[0].files.length > 0) {
                    $('.upload-form button[type="submit"]').prop('disabled', false);
                } else {
                    $('.upload-form button[type="submit"]').prop('disabled', true);
                }
            });


        $('.upload-label').on('click', function(e) {
            e.preventDefault();
            $('#attachment').click();
        });
    });


    $(document).ready(function() {
        $('#openReminderModal').on('click', function() {
            $('#reminderModal').modal('show');
        });
    });

    // $(document).ready(function() {
    //     $('#convertToStudentBtn').on('click', function() {
    //         var button = $(this);
    //         $.ajax({
    //             url: "{{ route('admission_query.toggle_approval', $admission_query->id) }}",
    //             type: 'POST',
    //             data: {
    //                 _token: '{{ csrf_token() }}'
    //             },
    //             success: function(response) {
    //                 if (response.success) {
    //                     // Update button text
    //                     button.text(response.button_text);

    //                     // Update status badge
    //                     var statusBadge = $('.status-badge');
    //                     if (response.is_approved == 1) {
    //                         statusBadge.removeClass('badge-inactive').addClass(
    //                             'badge-active');
    //                         statusBadge.html(
    //                             '<span style="padding: 3px 8px;background-color:rgb(24, 104, 24);border-radius:10px;color:#fff;font-size:11px;border-color:rgb(168, 252, 168)">Active</span>'
    //                         );
    //                     } else {
    //                         statusBadge.removeClass('badge-active').addClass(
    //                             'badge-inactive');
    //                         statusBadge.html(
    //                             '<span style="padding: 3px 8px;background-color:#7c32ff;border-radius:10px;color:#fff;font-size:11px;border-color:rgb(178, 158, 253)">Inactive</span>'
    //                         );
    //                     }

    //                 }
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error(error);
    //                 toastr.error('An error occurred while updating status');
    //             }
    //         });
    //     });
    // });

    $('#admission-query-update-form').on('submit', function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    toastr.success('Admission query updated successfully');
                    // Optionally, update the UI or redirect
                } else {
                    toastr.error('Failed to update admission query');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                toastr.error('An error occurred while updating admission query');
            }
        });
    });

    $(document).ready(function() {
        $('#convertToStudentBtn').on('click', function() {
            var $this = $(this);
            var admissionQueryId = {{ $admission_query->id }};
            $this.prop('disabled', true);
            $.ajax({
                url: "{{ route('admission_query.convert_to_student') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    admission_query_id: admissionQueryId
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Student created successfully');
                        // window.location.href = "/student-view/" + response.student_id;
                        window.location.href = "/unapproved-students";
                    } else {
                        toastr.error('Failed to create student'); 
                        $this.prop('disabled', false);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    toastr.error('An error occurred while creating student');
                    $this.prop('disabled', false);
                }
            });
        });
    });
</script>
