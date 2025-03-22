@extends('backEnd.master')
@section('title')
    @lang('student.student_list')
@endsection
@push('css')
    <style>
        .dataTables_processing {
            display: none !important;
        }
    </style>
@endpush
@section('mainContent')
    <section class="sms-breadcrumb mb-20 up_breadcrumb">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('student.manage_student')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('student.student_information')</a>
                    <a href="#">@lang('student.student_list')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student-list-search', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'sma_form']) }}
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box filter_card">
                        <div class="row">
                            <div class="col-lg-8 col-md-6 col-sm-6">
                                <div class="main-title mt_0_sm mt_0_md">
                                    <h3 class="mb-15">@lang('common.select_criteria')</h3>
                                </div>
                            </div>

                            @if (userPermission('student_admission'))
                                <div class="col-lg-4 text-md-right text-left col-md-6 mb-30-lg col-sm-6 text_sm_right">
                                    <a href="{{ route('student_admission') }}" class="primary-btn small fix-gr-bg">
                                        <span class="ti-plus pr-2"></span>
                                        @lang('student.add_student')
                                    </a>
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">


                            @if (moduleStatusCheck('University'))
                                @includeIf(
                                    'university::common.session_faculty_depart_academic_semester_level',
                                    ['mt' => 'mt-30', 'hide' => ['USUB'], 'required' => ['USEC']]
                                )
                                <div class="col-lg-3 mt-25">
                                    <div class="primary_input ">
                                        <input class="primary_input_field" type="text" placeholder="Name" name="name"
                                            value="{{ isset($name) ? $name : '' }}">
                                        <label class="primary_input_label" for="">@lang('student.search_by_name')</label>

                                    </div>
                                </div>
                                <div class="col-lg-3 mt-25">
                                    <div class="primary_input md_mb_20">
                                        <label class="primary_input_label" for="">@lang('student.search_by_roll_no')</label>
                                        <input class="primary_input_field" type="text" placeholder="Roll" name="roll_no"
                                            value="{{ isset($roll_no) ? $roll_no : '' }}">

                                    </div>
                                </div>
                            @else
                                @include('backEnd.common.search_criteria', [
                                    'mt' => 'mt-0',
                                    'div' => 'col-lg-3',
                                    'required' => ['academic'],
                                    'visiable' => ['academic', 'class', 'section'],
                                ])
                                <div class="col-lg-2">
                                    <div class="primary_input sm_mb_20 ">
                                        <label class="primary_input_label" for="">@lang('student.search_by_name')</label>

                                        <input class="primary_input_field" type="text" placeholder="Name" name="name"
                                            value="{{ isset($name) ? $name : old('name') }}">

                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <div class="primary_input sm_mb_20 ">
                                        <label class="primary_input_label" for="">@lang('student.search_by_roll')</label>
                                        <input class="primary_input_field" type="text" placeholder="Roll" name="roll_no"
                                            value="{{ isset($roll_no) ? $roll_no : old('roll_no') }}">


                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg" id="btnsubmit">
                                    <span class="ti-search pr-2"></span>
                                    @lang('common.search')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="academic_id" value="{{ @$academic_year }}">
            <input type="hidden" id="class" value="{{ @$class_id }}">
            <input type="hidden" id="section" value="{{ @$section }}">
            <input type="hidden" id="roll" value="{{ @$roll_no }}">
            <input type="hidden" id="name" value="{{ @$name }}">
            <input type="hidden" id="un_session" value="{{ @$data['un_session_id'] }}">
            <input type="hidden" id="un_academic" value="{{ @$data['un_academic_id'] }}">
            <input type="hidden" id="un_faculty" value="{{ @$data['un_faculty_id'] }}">
            <input type="hidden" id="un_department" value="{{ @$data['un_department_id'] }}">
            <input type="hidden" id="un_semester_label" value="{{ @$data['un_semester_label_id'] }}">
            <input type="hidden" id="un_section" value="{{ @$data['un_section_id'] }}">
            {{ Form::close() }}
            {{-- @if (@$students) --}}
            <div class="row mt-40 full_wide_table">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-15">@lang('student.student_list')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id"
                                        class="table data-table Crm_table_active3 no-footer dtr-inline collapsed"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                {{-- <th>Status</th> --}}
                                                <th>@lang('student.admission_no')</th>
                                                @if (generalSetting()->badge_system)
                                                    <th>@lang('admin.badge')</th>
                                                @endif
                                                <th>@lang('student.name')</th>
                                                @if (!moduleStatusCheck('University') && generalSetting()->with_guardian)
                                                    <th>@lang('student.father_name')</th>
                                                @endif
                                                <th>Status</th>
                                                <th>@lang('student.date_of_birth')</th>
                                                @if (moduleStatusCheck('University'))
                                                    <th>@lang('university::un.semester_label')</th>
                                                    <th>@lang('university::un.fac_dept')</th>
                                                @else
                                                    <th>@lang('student.class_sec')</th>
                                                @endif

                                                <th>@lang('common.gender')</th>
                                                <th>@lang('common.type')</th>
                                                <th>@lang('common.phone')</th>
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
            {{-- @endif --}}
        </div>
    </section>
    {{-- disable student  --}}
    <div class="modal fade admin-query" id="deleteStudentModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('student.disable_student')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <h4>@lang('student.are_you_sure_to_disable')</h4>
                    </div>
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                        {{ Form::open(['route' => 'student-delete', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        <input type="hidden" name="id" value="{{ @$student->id }}" id="student_delete_i">
                        {{-- using js in main.js --}}
                        <button class="primary-btn fix-gr-bg" type="submit">@lang('common.disable')</button>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="csvImportModal" tabindex="-1" role="dialog" aria-labelledby="csvImportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="csvImportModalLabel">Import CSV</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <a href="{{ url('/public/backEnd/bulksample/students.xlsx') }}">
                            <button class="primary-btn tr-bg text-uppercase bord-rad">
                                @lang('student.download_sample_file')
                                <span class="pl ti-download"></span>
                            </button>
                        </a>
                    </div>
                    {{ Form::open([
                        'class' => 'form-horizontal',
                        'files' => true,
                        'route' => 'student_bulk_store',
                        'method' => 'POST',
                        'enctype' => 'multipart/form-data',
                        'id' => 'student_form',
                    ]) }}
                    <div class="row">
                        <div class="col-lg-12">


                            <div class="">
                                <div class="">

                                    <input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">
                                    <div class="row mb-40 mt-30">

                                        @if (moduleStatusCheck('University'))
                                            @includeIf(
                                                'university::common.session_faculty_depart_academic_semester_level',
                                                [
                                                    'hide' => ['USUB'],
                                                    'required' => ['US', 'UD', 'USN', 'USL', 'UA', 'USEC'],
                                                ]
                                            )
                                            <div class="col-lg-3 mt-25">
                                                <div class="row no-gutters input-right-icon">
                                                    <div class="col">
                                                        <div class="primary_input">
                                                            <input
                                                                class="primary_input_field form-control {{ $errors->has('file') ? ' is-invalid' : '' }}"
                                                                type="text" id="placeholderPhoto"
                                                                placeholder="Excel file" readonly>

                                                            @if ($errors->has('file'))
                                                                <span class="text-danger">
                                                                    {{ $errors->first('file') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <button class="primary-btn-small-input" type="button">
                                                            <label class="primary-btn small fix-gr-bg"
                                                                for="photo">@lang('common.browse')</label>
                                                            <input type="file" class="d-none" name="file"
                                                                id="photo">
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-lg-6">
                                                <div class="primary_input ">
                                                    <select
                                                        class="primary_select  form-control{{ $errors->has('session') ? ' is-invalid' : '' }}"
                                                        name="session" id="academic_year">
                                                        <option data-display="@lang('common.academic_year') *" value="">
                                                            @lang('common.academic_year') *</option>
                                                        @foreach ($sessions as $session)
                                                            <option value="{{ $session->id }}"
                                                                {{ old('session') == $session->id ? 'selected' : '' }}>
                                                                {{ $session->year }}[{{ $session->title }}]</option>
                                                        @endforeach
                                                    </select>

                                                    @if ($errors->has('session'))
                                                        <span class="text-danger invalid-select" role="alert">
                                                            {{ $errors->first('session') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="primary_input" id="class-div">
                                                    <select
                                                        class="primary_select  form-control{{ $errors->has('class') ? ' is-invalid' : '' }}"
                                                        name="class" id="classSelectStudent">
                                                        <option data-display="@lang('common.class') *" value="">
                                                            @lang('common.class') *</option>
                                                    </select>
                                                    <div class="pull-right loader loader_style" id="select_class_loader">
                                                        <img class="loader_img_style"
                                                            src="{{ asset('public/backEnd/img/demo_wait.gif') }}"
                                                            alt="loader">
                                                    </div>

                                                    @if ($errors->has('class'))
                                                        <span class="text-danger invalid-select" role="alert">
                                                            {{ $errors->first('class') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mt-20">
                                                <div class="primary_input" id="sectionStudentDiv">
                                                    <select
                                                        class="primary_select  form-control{{ $errors->has('section') ? ' is-invalid' : '' }}"
                                                        name="section" id="sectionSelectStudent">
                                                        <option data-display="@lang('common.section') *" value="">
                                                            @lang('common.section') *</option>
                                                    </select>
                                                    <div class="pull-right loader loader_style"
                                                        id="select_section_loader">
                                                        <img class="loader_img_style"
                                                            src="{{ asset('public/backEnd/img/demo_wait.gif') }}"
                                                            alt="loader">
                                                    </div>

                                                    @if ($errors->has('section'))
                                                        <span class="text-danger invalid-select" role="alert">
                                                            {{ $errors->first('section') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-6 mt-20">

                                                <div class="primary_input">
                                                    <div class="primary_file_uploader">
                                                        <input
                                                            class="primary_input_field form-control {{ $errors->has('file') ? ' is-invalid' : '' }}"
                                                            type="text" id="placeholderPhoto" placeholder="Excel file"
                                                            readonly>
                                                        <button class="" type="button">
                                                            <label class="primary-btn small fix-gr-bg"
                                                                for="upload_content_file"><span
                                                                    class="ripple rippleEffect"
                                                                    style="width: 56.8125px; height: 56.8125px; top: -16.4062px; left: 10.4219px;"></span>@lang('common.browse')</label>
                                                            <input type="file" class="d-none" name="file"
                                                                id="upload_content_file">
                                                        </button>
                                                    </div>

                                                    @if ($errors->has('file'))
                                                        <span class="text-danger d-block">
                                                            {{ $errors->first('file') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="primary-btn fix-gr-bg">
                        <span class="ti-check"></span>
                        @lang('student.import_student')
                    </button>
                </div>
            </div>
        </div>
    </div>

    @php
        if (isset($academic_year) || isset($class_id)) {
            $ajax_url = url(
                'student-list-datatable?academic_year=' .
                    $academic_year .
                    '&class=' .
                    $class_id .
                    '&section=' .
                    $section .
                    '&roll_no=' .
                    $roll_no .
                    '&name=' .
                    $name,
            );
        } else {
            $ajax_url = url('student-list-datatable');
        }
    @endphp
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 17px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 3px;
            bottom: 7px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        .switch::after {
            display:none;
         }
        input:checked+.slider {
            background-color: #7c32ff;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #7c32ff;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .status-label {
            margin-left: 10px;
        }
    </style>
@endsection

@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": $.fn.dataTable.pipeline({
                    url: "{{ url('student-list-datatable') }}",
                    data: {
                        academic_year: $('#academic_id').val(),
                        class: $('#class').val(),
                        section: $('#section').val(),
                        roll_no: $('#roll').val(),
                        name: $('#name').val(),
                        un_session_id: $('#un_session').val(),
                        un_academic_id: $('#un_academic').val(),
                        un_faculty_id: $('#un_faculty').val(),
                        un_department_id: $('#un_department').val(),
                        un_semester_label_id: $('#un_semester_label').val(),
                        un_section_id: $('#un_section').val(),
                    },
                    pages: "{{ generalSetting()->ss_page_load }}" // number of pages to cache
                }),
                columns: [

                    {
                        data: 'admission_no',
                        name: 'admission_no'
                    },
                    @if (generalSetting()->badge_system)
                        {
                            data: 'student_badge',
                            name: 'student_badge'
                        },
                    @endif {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    @if (!moduleStatusCheck('University') && generalSetting()->with_guardian)
                        {
                            data: 'parents.fathers_name',
                            name: 'parents.fathers_name',
                            render : function(data){
                                if(data){
                                    return data;
                                }else{
                                    return ' -- ';
                                }

                            }
                        },
                    @endif {
                        data: 'active_status',
                        name: 'status',
                        render: function(data, type, row) {
                            var checked = data == 1 ? 'checked' : '';
                            return '<label class="switch">' +
                                '<input type="checkbox" class="status-toggle" data-id="' + row.id +
                                '" ' + checked + '>' +
                                '<span class="slider round"></span>' +
                                '</label>'
                        }
                    },
                    {
                        data: 'dob',
                        name: 'dob',
                        render : function(data){
                            if(data){
                                return data;
                            }else{
                            return ' -- ';
                            }
                        }
                        
                    },
                    @if (moduleStatusCheck('University'))
                        {
                            data: 'semester_label',
                            name: 'semester_label',
                            render : function(data){
                            if(data){
                                return data;
                            }else{
                            return ' -- ';
                            }
                        }

                        }, 
                        {
                            data: 'class_sec',
                            name: 'class_sec',
                            render : function(data){
                            if(data){
                                return data;
                            }else{
                            return ' -- ';
                            }
                        }

                        },
                    @else
                        {
                            data: 'class_sec',
                            name: 'class_sec',
                            render : function(data){
                            if(data){
                                return data;
                            }else{
                            return ' -- ';
                            }
                        }
                        },
                    @endif {
                        data: 'gender.base_setup_name',
                        name: 'gender.base_setup_name',
                        render : function(data){
                            if(data){
                                return data;
                            }else{
                            return ' -- ';
                            }
                        }

                    },
                    {
                        data: 'category.category_name',
                        name: 'category.category_name',
                        render : function(data){
                            if(data){
                                return data;
                            }else{
                            return ' -- ';
                            }
                        }
                    },
                    {
                        data: 'mobile',
                        name: 'sm_students.mobile'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'first_name',
                        name: 'first_name',
                        visible: false
                    },
                    {
                        data: 'last_name',
                        name: 'last_name',
                        visible: false
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
                    {
                        text: '<i class="fa fa-file-excel-o"></i> Import CSV',
                        action: function() {
                            $('#csvImportModal').modal('show');
                        }
                    },

                ],
                columnDefs: [{
                    visible: false,
                }, ],
                responsive: true,
            });


        });

        $(document).on('click', '.approvedstatus', function(e) {
            var data_id = $(this).data('id');
            var global_table = $(".data-table").DataTable();
            var global_url = '/student-list-datatable';
            $.ajax({
                url: "/student-status-update/" + data_id + '/approvedstatus',
                method: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        global_table.ajax.url(global_url).load();
                        toastr.success(response.message);
                    }
                }
            });
        });

        $(document).on('click', '.unapprovedstatus', function(e) {
            var data_id = $(this).data('id');
            var global_table = $(".data-table").DataTable();
            var global_url = '/student-list-datatable';
            $.ajax({
                url: "/student-status-update/" + data_id + '/unapprovedstatus',
                method: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        global_table.ajax.url(global_url).load();
                        toastr.success(response.message);
                    }
                }
            });
        });
        $(document).ready(function() {
            // Download sample CSV
            $('#downloadSampleCsv').click(function() {
                window.location.href = "{{ route('download_student_file') }}";
            });

            // Import CSV
            $('#importCsvBtn').click(function() {
                var formData = new FormData($('#csvImportForm')[0]);
                $.ajax({
                    url: "{{ route('student_bulk_store') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            toastr.success(response.message);
                            $('#csvImportModal').modal('hide');
                            $('.data-table').DataTable().ajax.reload();
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr) {
                        toastr.error(xhr.responseJSON?.message ||
                            'Error occurred while importing CSV');
                    }
                });
            });
        });
        $(document).on('change', '.status-toggle', function() {
            var checkbox = $(this);
            var studentId = checkbox.data('id');
            var isApproved = checkbox.prop('checked') ? 1 : 2;
            var statusLabel = checkbox.closest('td').find('.status-label');
            var row = checkbox.closest('tr');

            $.ajax({
                url: "/student-status-update/" + studentId + '/' + (isApproved === 1 ?
                    'approvedstatus' :
                    'unapprovedstatus'),
                method: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        statusLabel.text(isApproved === 1 ? 'Approve' : 'Unapprove');

                        var rowData = studentTable.row(row).data();
                        rowData.active_status = isApproved;
                        studentTable.row(row).data(rowData).draw(false);

                        toastr.success('Status updated successfully');
                    } else {
                        checkbox.prop('checked', !checkbox.prop('checked'));
                        toastr.error('Failed to update status');
                    }
                },
                error: function() {
                    checkbox.prop('checked', !checkbox.prop('checked'));
                    toastr.error('Error occurred while updating status');
                }
            });
        });

        $(document).on('click', '.viewclick', function(e) {
            localStorage.setItem('studentpagestatus', 'view');
        });

        $(document).on('click', '.editclick', function(e) {
            localStorage.setItem('studentpagestatus', 'edit');
        });
    </script>
@endpush
