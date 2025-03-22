@extends('backEnd.master')
@section('title')
@if(isset($item))
Edit Amount
@else
Add Amount
@endif
@endsection
@section('mainContent')
@push('css')
<link rel="stylesheet" href="{{url('Modules\Fees\Resources\assets\css\feesStyle.css')}}" />

<style>
    .multiselect-dropdown {
        display: none;
        padding: 2px 5px 0px 5px;
        border-radius: 4px;
        border: solid 1px #ced4da;
        background-color: white;
        position: relative;
        background-image: none;
        width: 244px;
    }

    @media (max-width: 2000px) {
        .multiselect-dropdown {
            width: 100%;
            flex: 0 0 100%;
        }
    }

    .multiselect-dropdown::after {
        content: '\f0d7';
        display: block;
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        color: #828bb2;
        font-size: 14px;
        transition: all 0.15s ease-in-out;
    }

    .multiselect-dropdown.open::after {
        content: '\f0d8';
    }

    .multiselect-dropdown span.optext {
        margin-bottom: 12px;
        margin-right: 0.5em;
        padding: 1px 0;
        border-radius: 4px;
        display: inline-block;
        background-color: lightgray;
        padding: 1px 0.75em;
    }

    .multiselect-dropdown span.placeholder {
        margin-right: 0.5em;
        margin-bottom: 2px;
        padding: 1px 0;
        border-radius: 4px;
        display: inline-block;
    }

    .multiselect-dropdown span.optext .optdel {
        float: right;
        margin: 0 -6px 1px 5px;
        font-size: 0.7em;
        cursor: pointer;
        color: #666;
        margin-top: 12px;
    }

    .multiselect-dropdown span.optext .optdel:hover {
        color: #c66;
    }

    .multiselect-dropdown span.placeholder {
        width: 100%;
        border-radius: 3px;
        height: 48px;
        line-height: 44px;
        font-size: 13px;
        color: #415094;
        padding: 0px 25px;
        padding-left: 20px;
        font-weight: 300;
    }

    .multiselect-dropdown-list-wrapper {
        box-shadow: gray 0 3px 8px;
        z-index: 100;
        padding: 2px;
        border-radius: 4px;
        border: solid 10px white;
        display: none;
        margin: -1px;
        position: absolute;
        top: 55px;
        left: 0;
        right: 0;
        background: white;
    }

    .multiselect-dropdown-list-wrapper .multiselect-dropdown-search {
        margin-bottom: 5px;
    }

    .multiselect-dropdown-list {
        padding: 2px;
        height: 15rem;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .multiselect-dropdown-list::-webkit-scrollbar {
        width: 6px;
    }

    .multiselect-dropdown-list::-webkit-scrollbar-thumb {
        background-color: #bec4ca;
        border-radius: 3px;
    }

    .multiselect-dropdown-list div {
        padding: 5px;
    }

    .multiselect-dropdown-list input {
        height: 1.15em;
        width: 1.15em;
        margin-right: 0.35em;
    }

    .multiselect-dropdown-list div:hover {
        background-color: #ced4da;
    }

    .multiselect-dropdown span.maxselected {
        width: 100%;
        height: 38px;
        border-radius: 3px;
        line-height: 44px;
        font-size: 13px;
        color: #415094;
        padding: 0px 25px;
        padding-left: 20px;
        font-weight: 300;
    }

    .multiselect-dropdown-all-selector {
        border-bottom: solid 1px #999;
    }

    .ti-calendar:before {
        position: relative !important;
        top: 5px !important;
    }

    .school-table-style tr th {
        padding: 10px 18px 10px 10px !important;
    }

    .school-table-style tr td {
        padding: 20px 10px 20px 10px !important;
    }

    .school-table-style tfoot tr td {
        padding: 10px 10px 10px 10px !important;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }

    .pagination a,
    .pagination span {
        display: inline-block;
        padding: 8px 16px;
        margin: 0 4px;
        text-decoration: none;
        color: #007bff;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .pagination a:hover,
    .pagination a:focus {
        background-color: #e9ecef;
        border-color: #ddd;
    }

    .pagination .active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
        pointer-events: none;
    }

    .pagination .disabled {
        color: #6c757d;
        border-color: #ddd;
        pointer-events: none;
        cursor: not-allowed;
    }

    .multypol_check_select {
        display: inline-block;
        margin: 0;
    }

    .multypol_check_select,
    .multypol_check_select .checkmark {
        position: relative;
        width: 18px;
        height: 18px;
        flex: 18px 0 0;
        line-height: 18px;
    }

    .multypol_check_select .checkmark {
        top: 0;
        left: 0;
        display: block;
        cursor: pointer;
        border-radius: 50%;
    }

    .multypol_check_select input {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
    }

    .multypol_check_select input:checked~.checkmark:after {
        width: 100%;
        height: 100%;
        border: 0;
        transition: 0.3s;
        transform: scale(0);
    }

    .multypol_check_select input:checked~.checkmark {
        background: linear-gradient(90deg, #7c32ff 0.47%, #c738d8);
        box-shadow: 0 5px 10px rgba(108, 39, 255, 0.25);
        transition: 0.3s;
    }

    .multypol_check_select input:checked~.checkmark:before {
        content: "\E64C";
        font-family: themify;
        position: absolute;
        display: block;
        top: 0;
        left: 3px;
        text-indent: 1px;
        color: #828bb2;
        background-color: transparent;
        border: 0;
        transform: rotate(8deg);
        font-size: 10px;
        font-weight: 600;
        line-height: 18px;
        z-index: 99;
        color: #fff;
        transition: 0.3s;
    }

    .multypol_check_select .checkmark:after {
        position: absolute;
        display: block;
        top: 0;
        left: 0;
        content: "";
        width: 18px;
        height: 18px;
        background: transparent;
        border-radius: 50px;
        border: 1px solid #828bb2;
        transition: 0.3s;
        transform: scale(1);
    }

    .multypol_check_select.small_checkbox {
        width: 13px;
        height: 13px;
        flex: 13px 0 0;
    }

    .multypol_check_select.small_checkbox input:checked~.checkmark:before {
        left: 2px;
        font-size: 7px;
        line-height: 13px;
        top: -1px;
    }

    .multypol_check_select.small_checkbox .checkmark {
        width: 13px;
        height: 13px;
        flex: 13px 0 0;
    }

    .multypol_check_select.small_checkbox .checkmark:after {
        width: 13px;
        height: 13px;
    }
</style>
@endpush
<section class="sms-breadcrumb mb-20">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>
                @if(isset($item))
                @lang('communicate.Edit Amount')
                @else
                @lang('communicate.Add Amount')
                @endif
            </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('fees.fees')</a>
                <a href="{{route('fees.fees-invoice-list')}}">@lang('fees.fees_invoice')</a>
                <a href="#">@if(isset($item)) @lang('common.edit') @else @lang('common.add') @endif</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($item))
        {{ Form::open(['class' => 'form-horizontal', 'method' => 'POST', 'route' => ['update-amount', $item->id]]) }}
        @else
        {{ Form::open(['class' => 'form-horizontal', 'method' => 'POST', 'route' => 'fees.fees-invoice-post']) }}
        @endif
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <div class="main-title">
                                <h3 class="mb-15">
                                    @if(isset($item))
                                    @lang('communicate.Edit Amount')
                                    @else
                                    @lang('communicate.Add Amount')
                                    @endif
                                </h3>
                            </div>
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12 d-flex">
                                        <!-- <div>Add Amount- &nbsp;</div> -->
                                        <div class="d-flex" id="showValue"></div>
                                    </div>
                                </div>
                                @if (moduleStatusCheck('University'))
                                @includeIf('university::common.session_faculty_depart_academic_semester_level',
                                ['required' =>
                                ['USN', 'UD', 'UA', 'US', 'USL','USEC'],'hide'=> ['USUB'],
                                'div'=>'col-lg-12','row'=>1,
                                'mt'=>'mt-0','disabled'=>true
                                ])
                                <div class="row">
                                    <div class="col-lg-12 mt-15" id="select_un_student_div">
                                        <label class="primary_input_label" for="">
                                            {{ __('common.student') }}
                                            <span class="text-danger"> *</span>
                                        </label>
                                        {{ Form::select('student_id', @$students ?? [""=>__('common.select_student').'*'], isset($invoiceInfo) ? $invoiceInfo->student_id : null , ['class' => 'primary_select  form-control'. ($errors->has('student_id') ? ' is-invalid' : ''), 'id'=>'select_un_student',  isset($invoiceInfo) ? 'disabled' : '']) }}
                                        <div class="pull-right loader loader_style" id="select_un_student_loader">
                                            <img class="loader_img_style" src="{{asset('public/backEnd/img/demo_wait.gif')}}" alt="loader">
                                        </div>
                                        @if ($errors->has('student_id'))
                                        <span class="text-danger custom-error-message" role="alert">
                                            Add Amount
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-lg-12 mt-15" id="select_un_student_div">
                                        <label class="primary_input_label" for="title">
                                            @lang('communicate.title')
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" id="title" value="{{isset($item) ? $item->title : old('title')}}" style="height: 45px;">
                                        @if($errors->has('title'))
                                        <span class="text-danger" role="alert">
                                            {{ $errors->first('title') }}</span>
                                        @endif
                                    </div>

                                    <div class="col-lg-12 mt-15" id="selectSectionsDiv" style="display: block;">
                                        <label for="checkbox" class="mb-2"> {{ __('common.class') }} <span class="text-danger">*</span></label>
                                        <select id="selectSectionss" name="class_id[]" multiple="multiple"
                                            class="multypol_check_select active position-relative form-control{{ $errors->has('section_id') ? ' is-invalid' : '' }}">

                                            @foreach ($classes as $class)
                                            <option value="{{ $class->id }}" {{ isset($item) && $item->class_id == $class->id ? 'selected' : '' }}>
                                                {{ $class->class_name }}
                                            </option>
                                            @endforeach
                                            @if($errors->has('class_id'))
                                            <span class="text-danger invalid-select" role="alert">
                                                {{ $errors->first('class_id') }}
                                            </span>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-lg-12 mt-15">
                                        <label class="primary_input_label" for="">
                                            @lang('communicate.Payment Method')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <select class="primary_select form-control{{ $errors->has('payment_method') ? ' is-invalid' : '' }}" name="payment_method" id="selectPaymentMethod">
                                            <option data-display="@lang('communicate.Payment Method')*" value="">@lang('fees.payment_method')*</option>
                                            @foreach ($paymentMethods as $paymentMethod)
                                            <option value="{{$paymentMethod->method}}" {{isset($item)? ($item->payment_method == $paymentMethod->method?'selected':''):(old('payment_method') == $paymentMethod->method ? 'selected' : '')}}>{{$paymentMethod->method}}</option>
                                            @endforeach

                                        </select>
                                        @if($errors->has('payment_method'))
                                        <span class="text-danger" role="alert">
                                            {{ $errors->first('payment_method') }}</span>
                                        @endif
                                    </div>
                                    <div class="col-lg-12 mt-15">
                                        <label class="primary_input_label" for="amount">
                                            @lang('communicate.amount')
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" id="amount" value="{{isset($item) ? $item->amount : old('amount')}}" style="height: 45px;">
                                        @if($errors->has('amount'))
                                        <span class="text-danger" role="alert">
                                            {{ $errors->first('amount') }}</span>
                                        @endif
                                    </div>
                                    <!-- <div class="col-lg-12 mt-15">
                                        <label class="primary_input_label" for="amount">
                                            Paid AMOUNT
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <input type="text" placeholder="Paid Amount" class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="balance"   style="height: 45px;">
                                        @if($errors->has('amount'))
                                        <span class="text-danger" role="alert">
                                            {{ $errors->first('amount') }}</span>
                                        @endif
                                    </div> -->
                                    <div class="col-lg-12 mt-15">
                                        <label class="primary_input_label" for="status">
                                            {{ __('common.status') }}
                                            <span class="text-danger"> *</span>
                                        </label>
                                        <select class="primary_select form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" name="status" id="status">
                                            <option data-display="@lang('common.select_status') *" value="">@lang('common.select_status') *</option>
                                            <option value="Active" {{isset($item) && $item->status == 'Active' ? 'selected' : ''}}>Active</option>
                                            <option value="Deactive" {{isset($item) && $item->status == 'Deactive' ? 'selected' : ''}}>Deactive</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                </div>
                                @endif
                                @php
                                $tooltip = "";
                                @endphp
                                <input type="hidden" value="{{@$invoiceInfo->id}}" id="newFeesEditId">
                                <div class="row mt-15">
                                    <div class="col-lg-12 text-center">
                                        <button class="primary-btn fix-gr-bg">
                                            <span class="ti-check"></span>
                                            @if (isset($item))
                                            @lang('common.update')
                                            @else
                                            @lang('common.save')

                                            @endif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="white-box">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="main-title">
                                <h3 class="mb-30">
                                    @if(isset($item))
                                    @lang('communicate.Edit Amount')
                                    @else
                                    @lang('communicate.Add Amount')
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-15">
                        <div class="col-lg-12">
                            <div class="pb-0 fees_invoice_type_div">
                                <div class="row">
                                    <div class="col-lg-12">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="weaverType" value="amount">
                            <div class="big-table">
                                <table class="table school-table-style fees_invoice_type_table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('communicate.#ID')</th>
                                            <th> @lang('communicate.title')</th>
                                            <th> {{ __('common.class') }}</th>
                                            <th> @lang('communicate.Payment Method')</th>
                                            <th>@lang('communicate.amount')</th>
                                            <th>{{ __('common.status') }}</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($admissionfees as $item)
                                        <tr>
                                            <td></td>
                                            <td>{{$item->title}}</td>
                                            <td>{{ $item->class ? $item->class->class_name : 'N/A' }}</td>
                                            <td>{{$item->payment_method}}</td>
                                            <td>{{$item->amount}}</td>

                                            <td style="font-size: medium;color:white">
                                                <span class="badge centered-badge 
                                                        @if($item->status == 'Active') 
                                                            bg-success
                                                        @else 
                                                            bg-danger
                                                        @endif">
                                                    {{ $item->status }}
                                                </span>
                                            </td>



                                            <td>
                                                <a href="{{ route('edit-amount', ['id' => $item->id]) }}"> <i class="fas fa-edit fa-xs" style="font-size: 12px;"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteFeesPayment" data-id="{{ $item->id }}" style="background-color: transparent;"><i class="fas fa-trash fa-xs" style="font-size: 12px;color:blue"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination">
                                    {{ $admissionfees->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @include('backEnd.partials.data_table_js')
            {{ Form::close() }}
        </div>
        <!-- Delete maodel start -->
        <div class="modal fade admin-query" id="deleteFeesPayment">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Admission Fees</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="text-center">
                            <h4>@lang('common.are_you_sure_to_delete')</h4>
                        </div>
                        <div class="mt-40 d-flex justify-content-between">
                            <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                            @if(isset($item))
                            <a href="{{ route('delete-amount', ['id' => $item->id]) }}"> <button class="primary-btn fix-gr-bg" type="submit">
                                    @lang('common.delete')</button></a>
                            @else
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete model end -->
</section>
@endsection
@include('backEnd.partials.date_picker_css_js')

@push('script')
<script type="text/javascript" src="{{url('Modules\Fees\Resources\assets\js\app.js')}}"></script>
<script>
    selectPosition({
        !!feesInvoiceSettings() - > invoice_positions!!
    });
</script>
<!-- All Select class -->
<script>
    function formatState(state) {
        if (!state.id) {
            return state.text;
        }

        return $state;
    };
</script>
<script type="text/javascript" src="{{asset('public/backEnd/multiselect/')}}/js/jquery.multiselect.js"></script>
<script type="text/javascript">
    $(function() {
        $("select[multiple].active.multypol_check_select").multiselect({
            columns: 1,
            placeholder: " @lang('communicate.Select Class')",
            search: true,
            searchOptions: {
                default: "Select"
            },
            selectAll: true,
        });
    });
</script>
@endpush