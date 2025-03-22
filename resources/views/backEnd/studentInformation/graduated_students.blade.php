@extends('backEnd.master')

@section('title')
    {{ @$pt }}
@endsection

@section('mainContent')
    <section class="sms-breadcrumb mb-20 up_breadcrumb">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>{{ @$pt }}</h1>
                <div class="bc-pages">
                    <a href="{{ url('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('student.student_information')</a>
                    <a href="#">{{ @$pt }}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_admin_visitor full_wide_table">
        <div class="container-fluid p-0">

            {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'graduated_students_search', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}

            <input type="hidden" id="class_id" value="{{ @$class_id }}">
            <input type="hidden" id="section_id" value="{{ @$section_id }}">
            <input type="hidden" id="admission_no" value="{{ @$admission_no }}">
            <input type="hidden" id="name" value="{{ @$name }}">

            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-8 col-md-6">
                                <div class="main-title">
                                    <h3 class="mb-15">@lang('common.select_criteria') </h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">
                            @if (moduleStatusCheck('University'))
                                @includeIf(
                                    'university::common.session_faculty_depart_academic_semester_level',
                                    ['hide' => ['USUB']]
                                )
                                <div class="col-lg-3 mt-25">
                                    <div class="primary_input ">
                                        <input class="primary_input_field" type="text" name="name"
                                            value="{{ isset($name) ? $name : '' }}">
                                        <label class="primary_input_label" for="">@lang('student.search_by_name')</label>

                                    </div>
                                </div>
                                <div class="col-lg-3 mt-25">
                                    <div class="primary_input md_mb_20">
                                        <input class="primary_input_field" type="text" name="admission_no"
                                            id="admission_no" value="{{ isset($admission_no) ? $admission_no : '' }}">
                                        <label class="primary_input_label" for="">@lang('student.search_by_admission_no')</label>

                                    </div>
                                </div>
                            @else
                                @include('backEnd.common.search_criteria', [
                                    'div' => 'col-lg-3',
                                    'required' => ['class'],
                                    'visiable' => ['class', 'section'],
                                ])
                                <div class="col-lg-3">
                                    <div class="primary_input ">
                                        <label class="primary_input_label" for="">@lang('student.search_by_name')</label>

                                        <input class="primary_input_field" type="text" name="name"
                                            value="{{ isset($name) ? $name : '' }}">

                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="primary_input md_mb_20">
                                        <label class="primary_input_label" for="">@lang('student.search_by_admission_no')</label>

                                        <input class="primary_input_field" type="text" name="admission_no"
                                            id="admission_no" value="{{ isset($admission_no) ? $admission_no : '' }}">

                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-12 mt-20 text-right">
                                <button type="submit" class="primary-btn small fix-gr-bg">
                                    <span class="ti-search pr-2"></span>
                                    @lang('common.search')
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}

            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-15">{{ @$pt }} </h3>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id" class="table data-table" cellspacing="0" width="100%">
                                        <thead>

                                            <tr>
                                                <th>@lang('student.admission_no')</th>
                                                <th>@lang('student.roll_no')</th>
                                                <th>@lang('student.name')</th>
                                                <th>@lang('common.class')</th>
                                                @if (generalSetting()->with_guardian)
                                                    <th>@lang('student.father_name')</th>
                                                @endif
                                                <th>@lang('common.date_of_birth')</th>
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
        </div>
    </section>

    <div class="modal fade admin-query" id="enableStudentModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('student.enable_student')</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="text-center">
                        <h4>@lang('student.are_you_sure_to_enable')</h4>
                    </div>

                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                        {{ Form::open(['route' => 'enable_student', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        <input type="hidden" name="id" value="" id="student_enable_i"> {{-- using js in main.js --}}
                        <button class="primary-btn fix-gr-bg" type="submit">@lang('common.enable')</button>
                        {{ Form::close() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')

@push('script')
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": $.fn.dataTable.pipeline({
                    url: "{{ route('graduated-student-list-datatable') }}",
                    data: {
                        class_id: $('#class_id').val(),
                        section_id: $('#section_id').val(),
                        name: $('#name').val(),
                        admission_no: $('#admission_no').val(),
                    },
                    pages: "{{ generalSetting()->ss_page_load }}" // number of pages to cache
                }),
                columns: [{
                        data: 'admission_no',
                        name: 'admission_no'
                    },
                    {
                        data: 'roll_no',
                        name: 'roll_no'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    @if (moduleStatusCheck('University'))
                        {
                            data: 'semester_label',
                            name: 'semester_label'
                        }, {
                            data: 'class_sec',
                            name: 'class_sec'
                        },
                    @else
                        {
                            data: 'class_sec',
                            name: 'class_sec'
                        },
                    @endif

                    @if (!moduleStatusCheck('University') && generalSetting()->with_guardian)
                        {
                            data: 'parents.fathers_name',
                            name: 'parents.fathers_name'
                        },
                    @endif {
                        data: 'dob',
                        name: 'dob'
                    },

                    {
                        data: 'gender.base_setup_name',
                        name: 'gender.base_setup_name'
                    },
                    {
                        data: 'category.category_name',
                        name: 'category.category_name'
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
                ],
                columnDefs: [{
                    visible: false,
                }, ],
                responsive: true,
            });
        });
    </script>
@endpush
