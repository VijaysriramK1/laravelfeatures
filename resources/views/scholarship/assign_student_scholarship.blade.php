@extends('backEnd.master')

@section('title')
    @lang('communicate.assign_students_scholarship')
@endsection
@push('css')
<link rel="stylesheet" href="{{url('Modules\Fees\Resources\assets\css\feesStyle.css')}}" />
<style>
        .select2-selectall-container {
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 1;
            cursor: pointer;
            padding: 5px;
            border-bottom: 1px solid #eee;
        }
        .select2-selectall-container label {
            cursor: pointer;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .select2-container {
            width: 100% !important;
        }
        .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
            background-color: #732CFF !important;
            border-radius: 3px !important;
        }
        .select2-container--default .select2-selection--multiple {
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }
        .select2-container .select2-search--inline .select2-search__field {
            color: #828bb2 !important;
            font-size: 13px !important;
            padding: 5px !important;
        }
        select#select_class {
            color: #828bb2 !important;
            font-size: 13px !important;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }
        select#select_section {
            color: #828bb2 !important;
            font-size: 13px !important;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }
        select#select_group {
            color: #828bb2 !important;
            font-size: 13px !important;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }
        select#selectSectionss {
            color: #828bb2 !important;
            font-size: 13px !important;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }
        select#search_class {
            color: #828bb2 !important;
            font-size: 13px !important;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }
        select#search_section {
            color: #828bb2 !important;
            font-size: 13px !important;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }
        select#search_group {
            color: #828bb2 !important;
            font-size: 13px !important;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }
        .form-control {
            height: calc(2.6em + .75rem + 2px) !important;
        }
        button:disabled {
            background-color: #cccccc; 
            color: #666666; 
            cursor: not-allowed; 
            opacity: 0.6; 
        }
    </style>
@endpush

@section('mainContent')
    <section class="sms-breadcrumb mb-20 up_breadcrumb">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('communicate.assign_students_scholarship')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('communicate.scholarships')</a>
                    <a href="#">@lang('communicate.assign_students_scholarship')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            {{-- <div class="row align-items-center">
                
            </div> --}}
            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'scholarship-student-search', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'sma_form']) }}
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">

                            <div class="col-lg-8 col-md-6 col-6">
                                <div class="main-title">
                                    <h3 class="mb-15">@lang('admin.select_criteria')</h3>
                                </div>
                            </div>
                            <div class="col-lg-4 text-md-right col-md-6 mb-30-lg col-6 text-right ">
                                @if (userPermission('admission_query_store_a'))
                                    <button class="primary-btn-small-input primary-btn small fix-gr-bg" type="button"
                                        data-toggle="modal" data-target="#addQuery">
                                        <span class="ti-plus pr-2"></span>
                                        @lang('communicate.assign')
                                    </button>
                                @endif
                            </div>


                            <div class="col-lg-12">
                                <div class="row">

                                <div class="col-lg-4">
                                            <label class="primary_input_label" for="">
                                                {{ __('common.class') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <select
                                                class=" form-control {{ $errors->has('class') ? ' is-invalid' : '' }}"
                                                id="search_class" name="class_id">
                                                <option data-display="@lang('common.select_class') *" value="">
                                                    @lang('common.select_class') *
                                                </option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ @$class->id }}"
                                                        {{ old('class') == @$class->id ? 'selected' : '' }}>
                                                        {{ @$class->class_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('class'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('class') }}
                                                </span>
                                            @endif

                                        </div>
                               

                               

                                        <div class="col-lg-4" id="select_section_div">
                                            <label class="primary_input_label" for="">
                                                {{ __('common.section') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <select
                                                class=" form-control{{ $errors->has('section') ? ' is-invalid' : '' }}"
                                                id="search_section" name="section_id">
                                                <option data-display="@lang('common.select_section') *" value="">
                                                    @lang('common.select_section') *
                                                </option>
                                            </select>
                                            <div class="pull-right loader" id="search_select_section_loader"
                                                style="margin-top: -30px;padding-right: 21px;">
                                                <img src="{{ asset('Modules/Lesson/Resources/assets/images/pre-loader.gif') }}"
                                                    alt="" style="width: 28px;height:28px;">
                                            </div>
                                            @if ($errors->has('section'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('section') }}
                                                </span>
                                            @endif

                                        </div>


                                        <div class="col-lg-4">
                                            <label class="primary_input_label" for="">
                                                {{ __('common.group') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <select
                                                class=" form-control {{ $errors->has('class') ? ' is-invalid' : '' }}"
                                                id="search_group" name="group_id">
                                                <option data-display="@lang('common.select_group') *" value="">
                                                    @lang('common.select_group') *
                                                </option>
                                                @foreach ($groups as $group)
                                                    <option value="{{ @$group->id }}"
                                                        {{ old('group') == @$group->id ? 'selected' : '' }}>
                                                        {{ @$group->group_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('class'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('class') }}
                                                </span>
                                            @endif

                                        </div>
                                </div>
                            </div>



                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg" id="btnsubmit">
                                    <span class="ti-search pr-2"></span>
                                    @lang('admin.search')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
            <div class="row mt-40 mx-0 white-box">
                <div class="col-lg-12 p-0">
                    <div class="row">
                        <div class="col-lg-4 no-gutters">
                            <div class="main-title">
                                <h3 class="mb-15">@lang('communicate.scholarship_students_list')</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                        @if (isset($requestData))
                                <input type="hidden" name="class_id" value="{{ $requestData['class_id'] }}">
                                <input type="hidden" name="section_id" value="{{ $requestData['section_id'] }}">
                                <input type="hidden" name="group_id" value="{{ $requestData['group_id'] }}">
                            @endif 
                            <x-table>
                                <table id="table_id" class="table data-table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('common.sl')</th>
                                            <th>@lang('common.class')</th>
                                            <th>@lang('common.section')</th>
                                            <th>@lang('common.group')</th>
                                            <th>@lang('communicate.student_name')</th>
                                            <th>@lang('communicate.scolarship_name')</th>
                                            <th>@lang('communicate.scholarship_fees_amount')</th>
                                            <th>@lang('communicate.amount')</th>
                                            <th>@lang('communicate.stipend_amount')</th>
                                            <th>@lang('common.actions')</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </x-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Start Delete Add Modal -->
    <div class="modal fade admin-query" id="deleteAdmissionQueryModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('admin.delete_admission_query')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                        <h5 class="text-danger">( @lang('admin.delete_conformation')
                            )</h5>
                    </div>
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('admin.cancel')</button>
                        {{ Form::open(['route' => 'delete-student-scholarship', 'method' => 'GET', 'enctype' => 'multipart/form-data']) }}
                        <input type="hidden" name="id" value="">
                        <button class="primary-btn fix-gr-bg" type="submit">@lang('admin.delete')</button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete Add Modal -->
    <!-- Start Sibling Add Modal -->
    <div class="modal fade admin-query" id="addQuery">
    <div class="modal-dialog modal-dialog-centered large-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('communicate.assign_students_scholarship')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'assign-scholarship', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="row">

                                <div class="col-lg-4">
                                            <label class="primary_input_label" for="">
                                                {{ __('common.class') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <select
                                                class=" form-control {{ $errors->has('class') ? ' is-invalid' : '' }}"
                                                id="select_class" name="class_id">
                                                <option data-display="@lang('common.select_class') *" value="">
                                                    @lang('common.select_class') *
                                                </option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ @$class->id }}"
                                                        {{ old('class') == @$class->id ? 'selected' : '' }}>
                                                        {{ @$class->class_name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('class_id'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('class_id') }}
                                                </span>
                                            @endif

                                        </div>
                               

                               

                                        <div class="col-lg-4" id="select_section_div">
                                            <label class="primary_input_label" for="">
                                                {{ __('common.section') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <select
                                                class=" form-control{{ $errors->has('section') ? ' is-invalid' : '' }}"
                                                id="select_section" name="section_id">
                                                <option data-display="@lang('common.select_section') *" value="">
                                                    @lang('common.select_section') *
                                                </option>
                                            </select>
                                            <div class="pull-right loader" id="select_section_loader"
                                                style="margin-top: -30px;padding-right: 21px;">
                                                <img src="{{ asset('Modules/Lesson/Resources/assets/images/pre-loader.gif') }}"
                                                    alt="" style="width: 28px;height:28px;">
                                            </div>
                                            @if ($errors->has('section_id'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('section_id') }}
                                                </span>
                                            @endif

                                        </div>


                                        <div class="col-lg-4">
                                            <label class="primary_input_label" for="">
                                                {{ __('common.group') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <select
                                                class=" form-control {{ $errors->has('class') ? ' is-invalid' : '' }}"
                                                id="select_group" name="group_id">
                                                <option data-display="@lang('common.select_group') *" value="">
                                                    @lang('common.select_group') *
                                                </option>
                                                @foreach ($groups as $group)
                                                    <option value="{{ @$group->id }}"
                                                        {{ old('group') == @$group->id ? 'selected' : '' }}>
                                                        {{ @$group->group_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="pull-right loader" id="select_group_loader"
                                                style="margin-top: -30px;padding-right: 21px;">
                                                <img src="{{ asset('Modules/Lesson/Resources/assets/images/pre-loader.gif') }}"
                                                    alt="" style="width: 28px;height:28px;">
                                            </div>
                                            @if ($errors->has('group_id'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('group_id') }}
                                                </span>
                                            @endif

                                        </div>
                                </div>
                            </div>

                            <div class="col-lg-12 mt-25">
                                <div class="row">

                                <div class="col-lg-4 mt-25" id="selectSectionsDiv" style="display: block;">
                                            <label for="selectSectionss" class="mb-2">@lang('communicate.student') <span class="text-danger">*</span></label>
                                            <select id="selectSectionss" name="student_id[]" multiple="multiple"
                                                    class="form-control{{ $errors->has('student_id') ? ' is-invalid' : '' }}">
                                            </select>
                                            @if($errors->has('student_id'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('student_id') }}
                                                </span>
                                            @endif
                                        </div>


                                    <div class="col-lg-4  mt-25">
                                            <label class="primary_input_label" for="">@lang('communicate.scholarships') <span class="text-danger"> *</span></label>
                                            <select class="primary_select" name="scholarship_id" id="scholarship">
                                                <option data-display="@lang('communicate.scholarships') *" value="">
                                                    @lang('communicate.scholarships') *
                                                </option>
                                                 @foreach ($scholarships as $scholarship) 
                                                <option value="{{ $scholarship->id }}">{{ $scholarship->name }}</option>
                                                @endforeach 
                                            </select>
                                            @if($errors->has('scholarship_id'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('scholarship_id') }}
                                                </span>
                                            @endif
                                            <span class="text-danger" id="scholarshipError"></span>
                                        </div>


                                        <div class="col-lg-4 mt-25">
                                            <label class="primary_input_label" for="">@lang('communicate.scholarship_fees_amount') <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field read-only-input form-control" type="number" name="scholarship_fees_amount" id="scholarship_fees_amount">
                                            @if($errors->has('scholarship_fees_amount'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('scholarship_fees_amount') }}
                                                </span>
                                            @endif
                                            <span class="text-danger" id="assignedError"></span>
                                        </div>                                                                                                  
                                       
                                </div>
                            </div>

                            <div class="col-lg-12 mt-25">
                                <div class="row">

                                <div class="col-lg-4 mt-25">
                                            <label class="primary_input_label" for="">@lang('communicate.amount') <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field read-only-input form-control" type="number" name="amount" id="amount">
                                            @if($errors->has('amount'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('amount') }}
                                                </span>
                                            @endif
                                            <span class="text-danger" id="assignedError"></span>
                                        </div>    


                                <div class="col-lg-4 mt-25">
                                            <label class="primary_input_label" for="">@lang('communicate.stipend_amount') <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field read-only-input form-control" type="number" name="stipend_amount" id="stipend_amount">
                                            @if($errors->has('stipend_amount'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('stipend_amount') }}
                                                </span>
                                            @endif
                                            <span class="text-danger" id="assignedError"></span>
                                        </div>
                                    <div class="col-lg-4 mt-25">
                                        <label class="primary_input_label" for="">@lang('communicate.date') </label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <input class="primary_input_field date form-control" id="startDate" type="text" name="awarded_date" readonly="true" value="{{ date('m/d/Y') }}" required>
                                                </div>
                                                <button class="btn-date" data-id="#date_from" type="button">
                                                    <label class="m-0 p-0" for="startDate">
                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                    </label>
                                                </button>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="dateError"></span>
                                    </div>
                                </div>
                            </div>


                            


                            <div class="col-lg-12 text-center mt-25">
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('admin.cancel')</button>
                                    <button class="primary-btn fix-gr-bg submit" id="save_button_query" type="submit" disabled>@lang('admin.save')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

    <!-- End Sibling Add Modal -->
@endsection

@include('backEnd.partials.date_picker_css_js')
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>

    <script>
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
        function deleteQueryModal(id) {
            var modal = $('#deleteAdmissionQueryModal');
            modal.find('input[name=id]').val(id)
            modal.modal('show');
        }


        $(document).ready(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": $.fn.dataTable.pipeline({
                    url: "{{ url('assign-student-scholarship') }}",
                    data: {
                        class_id: $('input[name=class_id]').val(),
                        section_id: $('input[name=section_id]').val(),
                        group_id: $('input[name=group_id]').val(),
                    },
                    pages: "{{ generalSetting()->ss_page_load }}" // number of pages to cache
                }),
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'class_name',
                        name: 'class_name',
                        render : function(data){
                            if(data){
                                return data;
                            }else{
                                return 'N/A';
                            }
                        }
                    },
                    {
                        data: 'section_name',
                        name: 'section_name',
                        render : function(data){
                            if(data){
                                return data;
                            }else {
                                return 'N/A';
                        }
                        }
                    },
                    
                    {
                        data: 'group_name',
                        name: 'group_name',
                        render:function(data){
                            
                            if(data){
                                return data;
                            }else{
                                return 'N/A' ;
                            }
                        }   
                    },
                    {
                        data: 'student_name',
                        name: 'student_name',
                        render:function(data){

                            if(data){
                                return data;
                            }else{
                                return 'N/A' ;
                            }
                        }
                    },
                    {
                        data: 'scholarship_name',
                        name: 'scholarship_name',
                        render:function(data){

                            if(data){
                                return data;
                            }else{
                                return 'N/A' ;
                            }
                        }
                    },
                    {
                        data: 'scholarship_fees_amount',
                        name: 'scholarship_fees_amount',
                        render:function(data){

                            if(data){
                                return data;
                            }else{
                                return 'N/A' ;
                            }
                        }
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        render:function(data){

                            if(data){
                                return data;
                            }else{
                                return 'N/A' ;
                            }
                        }
                    },
                    {
                        data: 'stipend_amount',
                        name: 'stipend_amount',
                        render:function(data){

                            if(data){
                                return data;
                            }else{
                                return 'N/A' ;
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                bLengthChange: false,
                bDestroy: true,
                language: {
                    search: "<i class='ti-search'></i>",
                    searchPlaceholder: window.jsLang('quick_search'),
                    paginate: {
                        next: "<i class='ti-arrow-right'></i>",
                        previous: "<i class='ti-arrow-left'></i>",
                    },
                },
                dom: "Bfrtip",
                buttons: [{
                        extend: "copyHtml5",
                        text: '<i class="fa fa-files-o"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: window.jsLang('copy_table'),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "excelHtml5",
                        text: '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: window.jsLang('export_to_excel'),
                        title: $("#logo_title").val(),
                        margin: [10, 10, 10, 0],
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "csvHtml5",
                        text: '<i class="fa fa-file-text-o"></i>',
                        titleAttr: window.jsLang('export_to_csv'),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "pdfHtml5",
                        text: '<i class="fa fa-file-pdf-o"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: window.jsLang('export_to_pdf'),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                        orientation: "landscape",
                        pageSize: "A4",
                        margin: [0, 0, 0, 12],
                        alignment: "center",
                        header: true,
                        customize: function(doc) {
                            doc.content[1].margin = [100, 0, 100, 0]; //left, top, right, bottom
                            doc.content.splice(1, 0, {
                                margin: [0, 0, 0, 12],
                                alignment: "center",
                                image: "data:image/png;base64," + $("#logo_img").val(),
                            });
                            doc.defaultStyle = {
                                font: 'DejaVuSans'
                            }
                        },
                    },
                    {
                        extend: "print",
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: window.jsLang('print'),
                        title: $("#logo_title").val(),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "colvis",
                        text: '<i class="fa fa-columns"></i>',
                        postfixButtons: ["colvisRestore"],
                    },
                ],
                columnDefs: [{
                    visible: false,
                }, ],
                responsive: true,
            });
        });
    </script>




<script>
  
 
    $('#select_class, #select_section').on('change', function () {
        const classId = $('#select_class').val();
        const sectionId = $('#select_section').val();
        console.log(classId)
        console.log(sectionId)

        if (classId && sectionId) {
            $('#select_group').prop('disabled', true);
            $('#select_section_loader').show();

            $.ajax({
                url: '/get-groups-list',
                type: 'GET',
                data: {
                    class_id: classId,
                    section_id: sectionId
                },
                success: function (response) {
                    console.log(response)
                    console.log("group")
                    $('#select_group').empty().append('<option value="">Select Groups *</option>');

                    if (response.groups && response.groups.length > 0) {
                    response.groups.forEach(function(group) { 
                        $('#select_group').append(
                            $('<option>', {
                                value: group.id,
                                text: group.group 
                            })
                        );
                    });

                    $('#select_group').prop('disabled', false);
                    $('#select_section_loader').hide();
                }
                },
                error: function () {
                    alert('Failed to fetch groups. Please try again.');
                    $('#select_group').prop('disabled', false);
                    $('#select_section_loader').hide();
                }
            });
        }
    });




 $(document).ready(function() {
     
     const selectField = $('#selectSectionss').select2({
         placeholder: 'Select Students *',
         allowClear: true,
         closeOnSelect: false,
         dropdownParent: $('#selectSectionsDiv')
        });
        
        
        let selectAllState = false;
        
        
        $('#select_class, #select_section,#select_group').on('change', function() {
            const selectedClass = $('#select_class').val();
            const selectedSection = $('#select_section').val();
            const selectedGroup = $('#select_group').val();

            if (selectedClass && selectedSection && selectedGroup) {
                $('#selectSectionss').prop('disabled', true);
                $('#select_group_loader').show();
                $.ajax({
                    url: '/get-group-students-list',
                    type: 'GET',
                    data: {
                        class_id: selectedClass,
                        section_id: selectedSection,
                        group_id: selectedGroup
                    },
                    success: function(response) {
                        console.log(response)
                        selectField.empty();
                        
                        if (response.students && response.students.length > 0) {
                            response.students.forEach(student => {
                                selectField.append(new Option(student.full_name, student.id));
                            });
                            
                            selectAllState = false;
                            if ($('#selectAllCheckbox').length) {
                                $('#selectAllCheckbox').prop('checked', false);
                            }
                        } else {
                            selectField.append(new Option('No students found', ''));
                        }
                        selectField.trigger('change');
                        $('#selectSectionss').prop('disabled', false);
                        $('#select_group_loader').hide();
                    },
                    error: function() {
                        console.error('Error fetching students');
                        
                    }
                });
            }
        });

        // Add Select All feature to dropdown
        selectField.on('select2:open', function() {
            setTimeout(() => {
                if (!$('.select2-selectall-container').length) {
                    
                    const selectAllContainer = $('<div class="select2-selectall-container"></div>');
                    const selectAllCheckbox = $('<input type="checkbox" id="selectAllCheckbox" style="margin-right: 5px;">');
                    const selectAllLabel = $('<label for="selectAllCheckbox">Select All</label>');
                    
                    selectAllContainer.append(selectAllCheckbox).append(selectAllLabel);
                    $('.select2-results:not(:has(.select2-selectall-container))').prepend(selectAllContainer);

                    selectAllCheckbox.prop('checked', selectAllState);

                   
                    selectAllCheckbox.on('click', function(e) {
                        e.stopPropagation();
                        selectAllState = this.checked;
                        
                        
                        const options = [];
                        $('#selectSectionss option').each(function() {
                            if ($(this).val()) {
                                options.push($(this).val());
                            }
                        });

                      
                        selectField.val(selectAllState ? options : null).trigger('change');
                    });
                }
            }, 0);
        });

        
        selectField.on('change', function(e) {
            const totalOptions = $('#selectSectionss option').length;
            const selectedOptions = $('#selectSectionss option:selected').length;
            
            if (totalOptions > 0) {
                selectAllState = totalOptions === selectedOptions;
                if ($('#selectAllCheckbox').length) {
                    $('#selectAllCheckbox').prop('checked', selectAllState);
                }
            }
        });

       
        $(document).on('click', '.select2-selectall-container', function(e) {
            e.stopPropagation();
        });
    });


    // Search Filter //

    $('#search_class').on('change', function () {
        const classId = $('#search_class').val();
        console.log(classId)
       

        if (classId) {
            $('#search_section').prop('disabled', true);
            $('#select_section_loader').show();

            $.ajax({
                url: '/get-sections-list',
                type: 'GET',
                data: {
                    class_id: classId,
                },
                success: function (response) {
                    console.log(response)
                    
                    $('#search_section').empty().append('<option value="">Select Sections *</option>');

                    if (response.sections && response.sections.length > 0) {
                    response.sections.forEach(function(section) { 
                        $('#search_section').append(
                            $('<option>', {
                                value: section.id,
                                text: section.section_name 
                            })
                        );
                    });

                    $('#search_section').prop('disabled', false);
                    $('#select_section_loader').hide();
                }
                },
                error: function () {
                    alert('Failed to fetch groups. Please try again.');
                    $('#search_section').prop('disabled', false);
                    $('#select_section_loader').hide();
                }
            });
        }
    });



  $('#search_class, #search_section').on('change', function () {
        const classId = $('#search_class').val();
        const sectionId = $('#search_section').val();
        console.log(classId)
        console.log(sectionId)

        if (classId && sectionId) {
            $('#search_group').prop('disabled', true);
            $('#search_select_section_loader').show();

            $.ajax({
                url: '/get-groups-list',
                type: 'GET',
                data: {
                    class_id: classId,
                    section_id: sectionId
                },
                success: function (response) {
                    console.log(response)
                    
                    $('#search_group').empty().append('<option value="">Select Groups *</option>');

                    if (response.groups && response.groups.length > 0) {
                    response.groups.forEach(function(group) { 
                        $('#search_group').append(
                            $('<option>', {
                                value: group.id,
                                text: group.group 
                            })
                        );
                    });

                    $('#search_group').prop('disabled', false);
                    $('#search_select_section_loader').hide();
                }
                },
                error: function () {
                    alert('Failed to fetch groups. Please try again.');
                    $('#search_group').prop('disabled', false);
                    $('#search_select_section_loader').hide();
                }
            });
        }
    });
    

    // SCHOLARSHIP AMOUNT VALIDATION BASED ON SUM OF AMOUNT AND STIPEND AMOUNT && CHECK ALL THE REQUIRED FIELDS ARE FILLED //


            document.addEventListener('DOMContentLoaded', function () {
                
            const scholarshipFeesAmount = document.getElementById('scholarship_fees_amount');
            const amount = document.getElementById('amount');
            const stipendAmount = document.getElementById('stipend_amount');
            const assignedError = document.getElementById('assignedError');
            const saveButton = document.getElementById("save_button_query");

            const requiredFields = [
                document.getElementById("select_class"),
                document.getElementById("select_section"),
                document.getElementById("select_group"),
                document.getElementById("selectSectionss"),
                document.getElementById("scholarship"),
                scholarshipFeesAmount,
                amount,
                stipendAmount
            ];

            function validateAmounts() {

                const scholarshipAmount = parseFloat(scholarshipFeesAmount.value) || 0;
                const amt = parseFloat(amount.value) || 0;
                const stipendAmt = parseFloat(stipendAmount.value) || 0;

                if (amt + stipendAmt > scholarshipAmount) {

                    assignedError.textContent = 'The sum of Amount and Stipend Amount should not exceed Scholarship Fees Amount.';
                    saveButton.disabled = true;
                    saveButton.style.cursor = 'not-allowed';
                    return false;

                } else {

                    assignedError.textContent = '';
                    return true;

                }
            }

            function checkRequiredFields() {

                const allRequiredFields = requiredFields.every(field => field.value.trim() !== "");

                if (allRequiredFields && validateAmounts()) {

                    saveButton.disabled = false;
                    saveButton.style.cursor = 'pointer';

                } else {

                    saveButton.disabled = true;
                    saveButton.style.cursor = 'not-allowed';

                }
            }

            requiredFields.forEach(field => {

                field.addEventListener("change", checkRequiredFields);
                field.addEventListener("input", checkRequiredFields);

            });

            scholarshipFeesAmount.addEventListener('input', validateAmounts);
            amount.addEventListener('input', validateAmounts);
            stipendAmount.addEventListener('input', validateAmounts);

        });


</script>

@endsection
