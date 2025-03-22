@extends('backEnd.master')
@section('title')
    @lang('lesson::lesson.add_topic')
@endsection

@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('lesson::lesson.add_topic')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('lesson::lesson.lesson_plan')</a>
                    <a href="#">@lang('lesson::lesson.topic')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if (isset($data))
                @if (userPermission('lesson.topic.store'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{ route('exam') }}" class="primary-btn small fix-gr-bg">
                                <span class="ti-plus"></span>
                                @lang('common.add')
                            </a>
                        </div>
                    </div>
                @endif
            @endif

            @if (userPermission('lesson.topic.store'))
                {{ Form::open([
                    'class' => 'form-horizontal',
                    'files' => true,
                    'route' => 'lesson.topic.store',
                    'method' => 'POST',
                    'enctype' => 'multipart/form-data',
                ]) }}
            @endif


            <div class="row">

                <div class="col-lg-4 col-xl-3">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <div class="main-title">
                                    <h3 class="mb-15">
                                        @if (isset($data))
                                            @lang('lesson::lesson.edit_topic')
                                        @else
                                            @lang('lesson::lesson.add_topic')
                                        @endif
                                    </h3>
                                </div>
                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="primary_input_label" for="">
                                                {{ __('common.class') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <select
                                                class="primary_select form-control {{ $errors->has('class') ? ' is-invalid' : '' }}"
                                                id="select_class" name="class">
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
                                    </div>
                                    <div class="row mt-15">

                                        <div class="col-lg-12" id="select_section_div">
                                            <label class="primary_input_label" for="">
                                                {{ __('common.section') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <select
                                                class="primary_select form-control{{ $errors->has('section') ? ' is-invalid' : '' }}"
                                                id="select_section" name="section">
                                                <option data-display="@lang('common.select_section') *" value="">
                                                    @lang('common.select_section') *
                                                </option>
                                            </select>
                                            <div class="pull-right loader" id="select_section_loader"
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
                                    </div>
                                    <div class="row mt-15">
                                        <div class="col-lg-12" id="select_subject_div">
                                            <label class="primary_input_label" for="">
                                                {{ __('common.subject') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <select
                                                class="primary_select form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}select_subject"
                                                id="select_subject" name="subject">
                                                <option data-display="@lang('lesson::lesson.select_subject') *" value="">
                                                    @lang('lesson::lesson.select_subject')*</option>

                                            </select>

                                            <div class="pull-right loader" id="select_subject_loader"
                                                style="margin-top: -30px;padding-right: 21px;">
                                                <img src="{{ asset('Modules/Lesson/Resources/assets/images/pre-loader.gif') }}"
                                                    alt="" style="width: 28px;height:28px;">
                                            </div>
                                            @if ($errors->has('subject'))
                                                <span class="text-danger invalid-select" role="alert"
                                                    style="display: block">
                                                    {{ $errors->first('subject') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mt-15">

                                        <div class="col-lg-12" id="select_lesson_div">
                                            <label class="primary_input_label" for="">
                                                {{ __('lesson::lesson.lesson') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <select class="primary_select" id="lesson_from_subject" name="lesson">
                                                <option data-display="@lang('lesson::lesson.select_lesson') *" value="">
                                                    @lang('lesson::lesson.select_lesson')*</option>

                                            </select>

                                            <div class="pull-right loader" id="select_lesson_loader"
                                                style="margin-top: -30px;padding-right: 21px;">
                                                <img src="{{ asset('Modules/Lesson/Resources/assets/images/pre-loader.gif') }}"
                                                    alt="" style="width: 28px;height:28px;">
                                            </div>
                                            @if ($errors->has('lesson'))
                                                <span class="text-danger invalid-select" role="alert"
                                                    style="display: block">
                                                    {{ $errors->first('lesson') }}
                                                </span>
                                            @endif

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box mt-10">
                                <div class="row align-items-center mb-3">

                                    <div
                                        class="col-xl-12 col-lg-12 col-md-12 col-12 d-flex justify-content-between align-items-center">
                                        <div class="form-group mb-0">
                                            <h3 class="mb-0" style="font-weight: 400;">
                                                @if (isset($data))
                                                    @lang('lesson::lesson.edit_topic')
                                                @else
                                                    @lang('lesson::lesson.add_topic')
                                                @endif
                                            </h3>
                                        </div>
                                        <!-- Plus Icon Button -->
                                        <div class="text-right ml-auto">
                                            <button type="button" class="primary-btn icon-only fix-gr-bg" id="addRowBtn"
                                                onclick="addRowTopic(is_sub_topic_enabled ?? 0 );" disabled>
                                                <span class="ti-plus"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="row align-items-center mb-3"></div>

                                <table class="" id="productTable">
                                    <thead>
                                        <tr>
                                            <input type="hidden" name="url" id="url"
                                                value="{{ URL::to('/') }}">
                                            <input type="hidden" name="is_sub_topic_enabled[]" id="is_sub_topic_enabled"
                                                value="0">
                                            {{-- <input type="hidden" name="cgpa_unit_enabled[]" id="cgpa_unit_enabled"
                                                value="0"> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="row1" class="mt-40">
                                            <td>

                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    @php
                        $tooltip = '';
                        if (userPermission('lesson.topic.store')) {
                            $tooltip = '';
                        } else {
                            $tooltip = 'You have no permission to add';
                        }
                    @endphp
                    <div class="row mt-40">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-center">
                                        <button class="primary-btn fix-gr-bg" data-toggle="tooltip"
                                            title="{{ @$tooltip }}" id="saveBtn">
                                            <span class="ti-check"></span>
                                            @if (isset($data))
                                                @lang('lesson::lesson.update_topic')
                                            @else
                                                @lang('lesson::lesson.save_topic')
                                            @endif


                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{ Form::close() }}

                <div class="col-lg-8 col-xl-9">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-15">@lang('lesson::lesson.topic_list')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id" class="table data-table table-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>@lang('common.sl')</th>
                                                <th>@lang('common.class')</th>
                                                <th>@lang('common.section')</th>
                                                <th>@lang('lesson::lesson.subject')</th>
                                                <th>@lang('lesson::lesson.lesson')</th>
                                                <th>@lang('lesson::lesson.topic')</th>
                                                {{-- <th>CGPA</th>
                                                <th>Unit</th> --}}
                                                <th>@lang('lesson::lesson.total_mark')</th>
                                                {{-- <th>Avg Mark</th> --}}
                                                <th>@lang('lesson::lesson.image')</th>
                                                <th>@lang('common.action')</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            {{-- @php $count =1  @endphp
                                        @foreach ($topics as $data)
    
                                            <tr>
                                                <td>{{$count++}}</td>
    
                                        <td>{{$data->class !=""?$data->class->class_name:""}}</td>
                                        <td>{{$data->section !=""?$data->section->section_name:""}}</td>
                                        <td>{{$data->subject !=""?$data->subject->subject_name:""}}</td>
                                        <td>{{$data->lesson !=""?$data->lesson->lesson_title:""}} </td>
    
                                        <td>
                                            @foreach ($data->topics as $topicData)
                                            {{$topicData->topic_title}}
                                            {{!$loop->last ? ',' : ''}}
                                            <br>
                                            @endforeach
                                        </td>
    
    
                                        <td>
                                            <x-drop-down />
                                            @if (userPermission('topic-edit'))
                                            <a class="dropdown-item"
                                                href="{{route('topic-edit', $data->id)}}">@lang('common.edit')</a>
                                            @endif
                                            @if (userPermission('topic-delete'))
                                            <a class="dropdown-item" data-toggle="modal"
                                                data-target="#deleteExamModal{{$data->id}}"
                                                href="#">@lang('common.delete')</a>
                                            @endif
                        </div>
    
                    </div>
                    </td>
                    </tr>
                    <div class="modal fade admin-query" id="deleteExamModal{{$data->id}}">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">@lang('lesson::lesson.delete_topic')</h4>
                                    <button type="button" class="close" data-bs-dismiss="modal">&times;
                                    </button>
                                </div>
    
                                <div class="modal-body">
                                    <div class="text-center">
                                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                                    </div>
    
                                    <div class="mt-40 d-flex justify-content-between">
                                        <button type="button" class="primary-btn tr-bg"
                                        data-bs-dismiss="modal">@lang('common.cancel')</button>
                                        {{ Form::open(['route' => array('topic-delete',$data->id), 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                        <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
                                        {{ Form::close() }}
                                    </div>
                                </div>
    
                            </div>
                        </div>
                    </div>
                    @endforeach --}}
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
    {{-- delete topic modal  --}}
    <div class="modal fade admin-query" id="deleteTopicModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('lesson::lesson.delete_topic')</h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;
                    </button>
                </div>

                <div class="modal-body">
                    <div class="text-center">
                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                    </div>

                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg" data-bs-dismiss="modal">@lang('common.cancel')</button>
                        {{ Form::open(['route' => ['topic-delete'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                        <input type="hidden" name="id" value="">
                        <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
                        {{ Form::close() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script type="text/javascript" src="{{ url('Modules\Lesson\Resources\assets\js\app.js') }}"></script>
    <script src="{{ asset('public/backEnd/') }}/js/lesson_plan.js"></script>
@endpush

@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')
@push('script')
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": $.fn.dataTable.pipeline({
                    url: "{{ route('get-all-topics-ajax') }}",
                    data: {},
                    pages: "{{ generalSetting()->ss_page_load }}" // number of pages to cache

                }),
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'class.class_name',
                        name: 'class_name'
                    },
                    {
                        data: 'section.section_name',
                        name: 'section_name'
                    },
                    {
                        data: 'subject.subject_name',
                        name: 'subject_name'
                    },
                    {
                        data: 'lesson.lesson_title',
                        name: 'lesson_title'
                    },
                    {
                        data: 'topics_name',
                        name: 'topics_name',
                    },
                    // {
                    //     data: 'cgpa_detail',
                    //     name: 'cgpa',
                    //     render: function(data) {
                    //         if (data) {
                    //             return data;
                    //         } else {
                    //             return 'N/A';
                    //         }
                    //     }
                    // },
                    // {
                    //     data: 'unit_detail',
                    //     name: 'unit',
                    //     render: function(data) {
                    //         if (data) {
                    //             return data;
                    //         } else {
                    //             return 'N/A';
                    //         }
                    //     }
                    // },
                    {
                        data: 'avg_and_max_marks_detail',
                        name: 'max_marks',
                        render: function(data) {
                            if (data) {
                                return data;
                            } else {
                                return 'N/A';
                            }
                        }
                    },
                    // {
                    //     data: 'avg_marks_detail',
                    //     name: 'avg_marks',
                    //     render: function(data) {
                    //         if (data) {
                    //             return data;
                    //         } else {
                    //             return 'N/A';
                    //         }
                    //     }
                    // },
                    {
                        data: 'image_detail',
                        name: 'image',
                        render: function(data) {
                            if (data) {
                                return data;
                            } else {
                                return 'N/A';
                            }
                        }
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
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
                // responsive: true,
            });
        });
    </script>
    <script>
        function deleteTopic(id) {
            var modal = $('#deleteTopicModal');
            modal.find('input[name=id]').val(id)
            modal.modal('show');
        }

        function removeForm(rowId) {
            // Remove the main row and all related rows
            $("#productTable tbody tr[id^='row" + rowId + "']").remove();
        }

        function resetTableRows() {
            // Remove all rows
            $("#productTable tbody").empty();

            addRowTopic();
        }


        addRowTopic(is_sub_topic_enabled ?? 0);




    // ADD ROW TOPIC  BUTTON //
    function addRowTopic() {
    console.log("is_sub_topic_enabled: ", is_sub_topic_enabled);

        const enableSubTopic = @json(__('communicate.enable_sub_topic'));
        const enableMark = @json(__('communicate.enable_mark'));
        const Title = @json(__('communicate.title'));
        const cgpa = @json(__('communicate.cgpa'));
        const unit = @json(__('communicate.unit'));
        const avgMark = @json(__('communicate.avg_marks'));
        const maxMark = @json(__('communicate.max_marks'));
        const numericValidation = @json(__('communicate.allowed_numeric_only'));
        const percentageValidation = @json(__('communicate.use_symbol'));

    $("#addRowBtn").button("loading");

    var tableLength = $("#productTable tbody tr").length;
    var count = tableLength > 0 ? tableLength + 1 : 1;

    var newRow = "";

    // Title Field
    newRow += "<tr id='row" + count + "_title' class='topic-row'>";

    // Enable Sub Topic Toggle
    newRow += "<input type='hidden' id='sub_topic_enabled" + count + "' name='sub_topic_enabled[]' value = '0'>";
    newRow += "<input type='hidden' id='cgpa_unit_enabled" + count + "' name='cgpa_unit_enabled[]' value = '0'>";

    newRow += "<tr id='row" + count + "_toggle' class='topic-row mt-3'>";
    newRow += "<td colspan='3'>";
    newRow += "<div class='primary_input' style='display:flex;align-items:center;gap:0.5em;margin-top:20px;margin-bottom:10px;'>";
    newRow += "<label class='mb-0'>"+ enableSubTopic +"</label>";
    newRow += "<label class='switch mb-0'>";
    newRow += "<input type='checkbox' id='toggleSwitch" + count + "' onclick='toggleFields(" + count + ")'>";
    newRow += "<span class='slider round'></span>";
    newRow += "</label>";
    newRow += "</div>";
    newRow += "</td>";
    newRow += "</tr>";

    // Title Field
    newRow += "<tr id='row" + count + "_title' class='topic-row'>";
    newRow += "<td colspan='3'>";
    newRow += "<div class='primary_input mt-2'>";
    newRow += "<input class='primary_input_field form-control' type='text' placeholder='"+ Title +" *' id='topic" + count + "' name='topic[]' autocomplete='off'>";
    newRow += "</div>";
    newRow += "</td>";
    newRow += "</tr>";


    // CGPA and Unit Fields
    newRow += "<tr id='row" + count + "_cgpa_unit' class='topic-row' style='display:none;'>";
    newRow += "<td>";
    newRow += "<div class='primary_input mt-2'>";
    newRow += "<input class='primary_input_field form-control' type='number' placeholder='"+ cgpa +"' id='cgpa" + count + "' name='cgpa[]' autocomplete='off'>";
    newRow += "</div>";
    newRow += "<span class='text-danger error-message' id='cgpa_error_" + count + "' style='color: #7C32FF !important; font-size: 11px !important;'>";
    newRow += "* " + numericValidation +" ";
    newRow += "</span>";
    newRow += "</td>";
    newRow += "<td>";
    newRow += "<div class='primary_input mt-2'>";
    newRow += "<input class='primary_input_field form-control' type='text' placeholder='"+ unit +"' id='unit" + count + "' name='unit[]' autocomplete='off'>";
    newRow += "</div>";
    newRow += "<span class='text-danger error-message' id='unit_error_" + count + "' style='color: #7C32FF !important; font-size: 11px !important;'>";
    newRow += "* " + percentageValidation + " ";
    newRow += "</span>";
    newRow += "</td>";
    newRow += "</tr>";

    // Maxmark and Avg Mark Fields
    newRow += "<tr id='row" + count + "_max_avg' class='topic-row' style='display:none;'>";
    newRow += "<td>";
    newRow += "<div class='primary_input mt-2'>";
    newRow += "<input class='primary_input_field form-control' type='number' placeholder='"+ maxMark +"' id='maxmark" + count + "' name='max_marks[]' autocomplete='off'>";
    newRow += "</div>";
    newRow += "<span class='text-danger error-message' id='maxmark_error_" + count + "' style='color: #7C32FF !important; font-size: 11px !important;'>";
    newRow += "* " + numericValidation +" ";
    newRow += "</span>";
    newRow += "</td>";
    newRow += "<td>";
    newRow += "<div class='primary_input mt-2'>";
    newRow += "<input class='primary_input_field form-control' type='number' placeholder='"+ avgMark +"' id='avg_mark" + count + "' name='avg_marks[]' autocomplete='off'>";
    newRow += "</div>";
    newRow += "<span class='text-danger error-message' id='avg_mark_error_" + count + "' style='color: #7C32FF !important; font-size: 11px !important;'>";
    newRow += "* " + numericValidation +" ";
    newRow += "</span>";
    newRow += "</td>";
    newRow += "</tr>";

    // Image Field (Visible initially)
    newRow += "<tr id='row" + count + "_image' class='topic-row'>";
    newRow += "<td colspan='3'>";
    newRow += "<div class='primary_input mt-2'>";
    newRow += "<input class='primary_input_field form-control' type='file' id='image" + count + "' name='image[]'  onchange='previewFile(event, " + count + ")'>";
    newRow += "<div id='imagePreview" + count + "' class='mt-2'></div>";
    newRow += "</div>";
    newRow += "</td>";
    newRow += "</tr>";

    // CGPA and Unit Toggle
    newRow += "<tr id='row" + count + "_cgpaunittoggle' class='topic-row'>";
    newRow += "<td colspan='3'>";
    newRow += "<div class='primary_input mt-2' style='display:flex;align-items:center;gap:0.5em;margin:5px 0px;'>";
    newRow += "<label>"+ enableMark +"</label>";
    newRow += "<label class='switch-1'>";
    newRow += "<input type='checkbox' id='cgpaUnitSwitch" + count + "' onclick='toggleCgpaUnit(" + count + ")'>";
    newRow += "<span class='slider round'></span>";
    newRow += "</label>";
    newRow += "</div>";
    newRow += "</td>";
    newRow += "</tr>";


    // }
    // Always add the Remove Button
    newRow += "<tr id='row" + count + "_remove' class='topic-row'>";
    newRow += "<td colspan='3' class='pl-2'>";
    newRow += "<button class='remove-btn primary-btn icon-only fix-gr-bg' type='button' data-id='" + count + "'>";
    newRow += "<span class='ti-trash'></span>";
    newRow += "</button>";
    newRow += "</td>";
    newRow += "</tr>";

    $("#productTable tbody").append(newRow);

    $("#addRowBtn").button("reset");
}

function removeForm(rowId) {
    // Remove all related rows
    $("#productTable tbody tr[id^='row" + rowId + "']").remove();
}

function previewFile(event, count) {
    const file = event.target.files[0];
    const previewContainer = document.getElementById('imagePreview' + count);
    previewContainer.innerHTML = ""; 

    const pdfIconSrc = "{{ asset('public/uploads/settings/pdf-blue.png') }}";
    const csvIconSrc = "{{ asset('public/uploads/settings/csv-fileblue.png') }}";
    const docIconSrc = "{{ asset('public/uploads/settings/doc-blue.png') }}";
    const docxIconSrc = "{{ asset('public/uploads/settings/docx-file-blue.png') }}";
    

    if (file) {
        const fileType = file.type;
        const reader = new FileReader();

        if (fileType.startsWith("image/")) { 

            reader.onload = function(e) {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.style.maxWidth = "100px";
                img.style.marginTop = "10px";
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        } else {
            
            let iconSrc = "";

            if (fileType === "application/pdf") {

                iconSrc = pdfIconSrc; 

            } else if (fileType === "text/csv" || file.name.endsWith(".csv")) {

                iconSrc = csvIconSrc; 

            } else if (fileType === "application/vnd.openxmlformats-officedocument.wordprocessingml.document" && file.name.endsWith(".docx"))  {

                iconSrc = docxIconSrc;

            } else if (fileType === "application/msword" && file.name.endsWith(".doc")) {

                iconSrc = docIconSrc;

            } else {

                iconSrc = " -- "; 

            }

            const iconImage = document.createElement("img");
            iconImage.src = iconSrc;
            iconImage.style.maxWidth = "70px";
            iconImage.style.marginTop = "0px";
            previewContainer.appendChild(iconImage);
        }
    }
}


// END ADD ROW TOPOIC BUTTON //


    </script>

    <script>
        let is_sub_topic_enabled = 0;

        // Function to check if all required fields are selected
        function checkRequiredFields() {
            const classSelected = $('#select_class').val() !== '';
            const sectionSelected = $('#select_section').val() !== '';
            const subjectSelected = $('#select_subject').val() !== '';
            const lessonSelected = $('#lesson_from_subject').val() !== '';

            if (classSelected && sectionSelected && subjectSelected && lessonSelected) {
                $('#addRowBtn').prop('disabled', false);
                $('#saveBtn').prop('disabled', false);
            } else {
                $('#addRowBtn').prop('disabled', true);
                $('#saveBtn').prop('disabled', true);
            }
        }

        // function toggleFields(element) {
        //     is_sub_topic_enabled = element.checked ? 1 : 0;
        //     $('#is_sub_topic_enabled').val(is_sub_topic_enabled);

        //     let newlyCreatedTopicIds = [];

        //     // Perform the AJAX request to update the sub-topic status
        //     $.ajax({
        //         url: '/enable-sub-topic',
        //         type: 'POST',
        //         data: {
        //             status: is_sub_topic_enabled,
        //             newly_created_topic_ids: newlyCreatedTopicIds,
        //             _token: '{{ csrf_token() }}'
        //         },
        //         success: function(response) {
        //             toastr.success(
        //                 is_sub_topic_enabled ? "Sub Topic Enabled Successfully" :
        //                 "Sub Topic Disabled Successfully", {
        //                     iconClass: "customer-info",
        //                 }, {
        //                     timeOut: 1500,
        //                 }
        //             );
        //             resetTableRows();
        //             // The toggle status is updated, so the correct value is passed to addRowTopic
        //         },
        //         error: function(xhr) {
        //             toastr.error(
        //                 "Error updating toggle status", {
        //                     iconClass: "customer-error",
        //                 }, {
        //                     timeOut: 1500,
        //                 }
        //             );
        //         }
        //     });
        // }

        // <!-------------------------------------------------------------SUB TOPIC ENABLE OR DISABLE------------------------------------------------->
        function toggleFields(count) {
            const checkbox = document.getElementById('toggleSwitch' + count);
            const titleField = document.getElementById('topic' + count);
            const cgpaUnitRow = document.getElementById('row' + count + '_cgpa_unit');
            const maxAvgRow = document.getElementById('row' + count + '_max_avg');
            const imageRow = document.getElementById('row' + count + '_image');
            const cgpaUnitToggle = document.getElementById('row' + count + '_cgpaunittoggle');
            const subTopicEnabled = document.getElementById('sub_topic_enabled' + count);
            const isSubTopic = document.getElementById('is_sub_topic_enabled' + count);


            if (document.getElementById('toggleSwitch' + count).checked) {
                // titleField.disabled = false;    
                // cgpaUnitToggle.style.display = 'table-row';
                // cgpaUnitRow.style.display = 'none';
                maxAvgRow.style.display = 'none';
                imageRow.style.display = 'none';
                subTopicEnabled.value = checkbox.checked ? '1' : '0';
                isSubTopic.value = checkbox.checked ? '1' : '0';
            } else {
                // titleField.disabled = false;
                cgpaUnitToggle.style.display = 'table-row';
                // cgpaUnitRow.style.display = 'none';
                maxAvgRow.style.display = 'table-row';
                imageRow.style.display = 'table-row';
                subTopicEnabled.value = checkbox.checked ? '1' : '0';
                isSubTopic.value = checkbox.checked ? '1' : '0';
            }
        }

        function toggleCgpaUnit(count) {
            const cgpaUnitRow = document.getElementById('row' + count + '_cgpa_unit');
            const maxAvgRow = document.getElementById('row' + count + '_max_avg');
            const cgpaUnitEnabled = document.getElementById('cgpa_unit_enabled' + count);

            const cgpaUnitSwitchChecked = document.getElementById('cgpaUnitSwitch' + count).checked;
            const enableSubTopicChecked = document.getElementById('toggleSwitch' + count).checked;

   
            if (cgpaUnitSwitchChecked ) {
                
                cgpaUnitRow.style.display = 'table-row';
                maxAvgRow.style.display = enableSubTopicChecked ? 'none' : 'table-row';
                cgpaUnitEnabled.value = 1;
                
            } 
            else {
                
                cgpaUnitRow.style.display = 'none';
                maxAvgRow.style.display = 'none';
                cgpaUnitEnabled.value = 0;
            }

        }


        // <!-------------------------------------------------------------SUB TOPIC ENABLE OR DISABLE------------------------------------------------->

        $(document).ready(function() {
            is_sub_topic_enabled = 0;

            $(document).on('click', '.remove-btn', function() {
                const rowId = $(this).data('id');
                removeForm(rowId);
            });


            $('#addRowBtn').prop('disabled', true);

            $('#select_class, #select_section, #select_subject, #lesson_from_subject').on('change', function() {
                checkRequiredFields();
            });

            $('#toggleFieldsBtn').on('change', function() {
                toggleFields(this);
            });

            checkRequiredFields();
        });


  
    </script>

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 10px;
            height: 10px;
            padding: 12px 23px !important;
            /* margin-left: 45%; */
        }

        .switch-1 {
            position: relative;
            display: inline-block;
            width: 10px;
            height: 10px;
            padding: 12px 23px !important;
            /* margin-left: 38%; */
        }


        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .switch-1 input {
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
            height: 17px;
            width: 17px;
            border-radius: 50%;
            left: 2px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
        }


        input:checked+.slider {
            background-color: #7c32ff;
        }


        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .switch::after {
            display: none;
        }

        .switch-1::after {
            display: none;
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .form-container {
            position: relative;
            padding: 20px;
        }


        .form-header {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
        }


        .delete-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: #ff0000;
        }


        .form-content {
            margin-top: 30px;
        }

        input[type="file"]::file-selector-button {
            border-radius: 4px;
            height: 30px;
            cursor: pointer;
            background-color: #7c32ff;
            border: 1px solid #7c32ff;
            box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.05);
            transition: background-color 200ms;
            color: #fff;
        }


        input[type="file"]::file-selector-button:hover {
            background-color: #7c32ff;
        }


        input[type="file"]::file-selector-button:active {
            background-color: #7c32ff;
        }
    </style>
@endpush
