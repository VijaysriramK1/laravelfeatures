@extends('backEnd.master')
@section('title')
    @lang('communicate.sub_topic')
@endsection

@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('communicate.sub_topic')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('lesson::lesson.lesson_plan')</a>
                    <a href="#">@lang('communicate.sub_topic')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            <!-- @if (isset($data))
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
    @endif -->

            {{ Form::open([
                'class' => 'form-horizontal',
                'files' => true,
                'route' => 'sub-topic-store',
                'method' => 'POST',
                'enctype' => 'multipart/form-data',
            ]) }}

            <div class="row">

                <div class="col-lg-4 col-xl-3">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <div class="main-title">
                                    <h3 class="mb-15">
                                        @if (isset($data))
                                            @lang('communicate.add_sub_topic')
                                        @else
                                            @lang('communicate.edit_sub_topic')
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
                                                @foreach ($data['classes'] as $class)
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
                                                {{ __('lesson::lesson.lesson') }} <span class="text-danger"> *</span>
                                            </label>
                                            <select class="primary_select" id="lesson_from_subject" name="lesson">
                                                <option data-display="@lang('lesson::lesson.select_lesson') *" value="">
                                                    @lang('lesson::lesson.select_lesson')*
                                                </option>
                                                <!-- Add your options here -->
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


                                    <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <label class="primary_input_label" for="">@lang('communicate.topic') <span
                                                    class="text-danger"> *</span></label>
                                            <select class="form-select" id="select_topic" name="topic">
                                                <option data-display="@lang('communicate.select_topic') *" value="">
                                                    @lang('communicate.select_topic')*
                                                </option>

                                            </select>

                                            <div class="pull-right loader" id="select_topic_loader"
                                                style="margin-top: -30px;padding-right: 21px;">
                                                <img src="{{ asset('Modules/Lesson/Resources/assets/images/pre-loader.gif') }}"
                                                    alt="" style="width: 28px;height:28px;">
                                            </div>
                                            @if ($errors->has('topic'))
                                                <span class="text-danger invalid-select" role="alert"
                                                    style="display: block">
                                                    {{ $errors->first('topic') }}
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
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                        <div class="form-group d-flex justify-content-between align-items-center">

                                            <label class="primary_input_label mb-0">
                                                <b>@lang('communicate.add_sub_topic')</b>
                                            </label>

                                            <button type="button" class="primary-btn icon-only fix-gr-bg"
                                                onclick="addSubRowTopic();" id="addSubRowBtn" disabled>
                                                <span class="ti-plus"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>


                                <div class="row align-items-center mb-3">

                                </div>

                                <table class="" id="subtopicTable">
                                    <thead>
                                        <tr>


                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr id="row1" class="mt-40">
                                            <td>


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
                                            title="{{ @$tooltip }}">
                                            <span class="ti-check"></span>
                                            @if (isset($data))
                                              @lang('communicate.save_sub_topic')
                                            @else
                                              @lang('communicate.update_sub_topic')
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
                                    <h3 class="mb-15">@lang('communicate.sub_topic_list')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id" class="table data-table table-responsive" cellspacing="0"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>@lang('common.sl')</th>
                                                <th>@lang('common.class')</th>
                                                <th>@lang('common.section')</th>
                                                <th>@lang('lesson::lesson.subject')</th>
                                                <th>@lang('lesson::lesson.lesson')</th>
                                                <th>@lang('lesson::lesson.topic')</th>
                                                <th>@lang('communicate.sub_topic')</th>
                                                <th>@lang('communicate.total_mark')</th>
                                                {{-- <th>Max Mark</th>
                                                <th>Avg Mark</th> --}}
                                                <th>@lang('communicate.image')</th>
                                                <th>@lang('common.action')</th>
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
                        {{ Form::open(['route' => ['subtopic-delete'], 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
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
    <link href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.dataTables.css" rel="stylesheet">

    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.js"></script>
@endpush

@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')
@push('script')
    <script>
        $(document).ready(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: $.fn.dataTable.pipeline({
                    url: "{{ route('get-all-subtopics-ajax') }}",
                    data: {},
                    pages: "{{ generalSetting()->ss_page_load }}" // number of pages to cache
                }),
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'class_name',
                        name: 'class_name'
                    },
                    {
                        data: 'section_name',
                        name: 'section_name'
                    },
                    {
                        data: 'subject_name',
                        name: 'subject_name'
                    },
                    {
                        data: 'lesson_title',
                        name: 'lesson_title'
                    },
                    {
                        data: 'topics_name',
                        name: 'topics_name',
                        render :function(data){
                            if(data){
                                return data;
                            }else{
                                return 'N/A';
                            }
                        }
                    },
                    {
                        data: 'sub_topic_detail',
                        name: 'sub_topic_detail',
                        render :function(data){
                            if(data){
                                return data;
                            }else{
                                return 'N/A';
                            }
                        }
                    },
                    {
                        data: 'avg_and_max_marks_detail',
                        name: 'max_marks_detail',
                        render :function(data){
                            if(data){
                                return data;
                            }else{
                                return 'N/A';
                            }
                        }
                    },
                    // {
                    //     data: 'avg_marks_detail',
                    //     name: 'avg_marks_detail'
                    // },
                    {
                        data: 'image_detail',
                        name: 'image_detail',
                        render :function(data){
                            if(data){
                                return data;
                            }else{
                                return 'N/A';
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
                    }
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


 // ADD SUB TOPIC ROW BUTTON //
 addSubRowTopic = () => {

$("#addSubRowBtn").button("loading");
    const Title = @json(__('communicate.title'));
    const avgMark = @json(__('communicate.avg_marks'));
    const maxMark = @json(__('communicate.max_marks'));
    const numericValidation = @json(__('communicate.allowed_numeric_only'));
    const percentageValidation = @json(__('communicate.use_symbol'));

var tableLength = $("#subtopicTable tbody tr").length;
var count = tableLength > 0 ? tableLength + 1 : 1;


var newRow = "";


newRow += "<tr id='row" + count + "' class='sub-topic-row'>";

// Title Field
newRow += "<td colspan='3' class='border-top-0'>";
newRow += "<div class='primary_input mt-2'>";
newRow += "<input class='primary_input_field form-control' required type='text' placeholder='"+ Title +" *' id='sub_topic" + count + "' name='sub_topic[]' autocomplete='off'>";
newRow += "</div>";
newRow += "</td>";
newRow += "</tr>";

// Maxmark and Avg Mark
newRow += "<tr id='row" + count + "_max_avg' class='sub-topic-row'>";
newRow += "<td class='border-top-0'>";
newRow += "<div class='primary_input mt-2'>";
newRow += "<input class='primary_input_field form-control' type='number' placeholder='"+ maxMark +"' id='maxmark" + count + "' name='max_marks[]' autocomplete='off'>";
newRow += "</div>";
newRow += "<span class='text-danger error-message' id='maxmark_error_" + count + "' style='color: #7C32FF !important; font-size: 11px !important;'>";
newRow += "* " + numericValidation +" ";
newRow += "</span>";
newRow += "</td>";
newRow += "<td class='border-top-0'>";
newRow += "<div class='primary_input mt-2'>";
newRow += "<input class='primary_input_field form-control' type='number' placeholder='"+ avgMark +"' id='avg_mark" + count + "' name='avg_marks[]' autocomplete='off'>";
newRow += "</div>";
newRow += "<span class='text-danger error-message' id='avg_mark_error_" + count + "' style='color: #7C32FF !important; font-size: 11px !important;'>";
newRow += "* " + numericValidation +" ";
newRow += "</span>";
newRow += "</td>";
newRow += "</tr>";

// Image Field
newRow += "<tr id='row" + count + "_image' class='sub-topic-row'>";
newRow += "<td colspan='3' class='border-top-0'>";
newRow += "<div class='primary_input mt-2'>";
newRow += "<input class='primary_input_field form-control' type='file' id='image" + count + "' name='image[]' onchange='previewFile(event, " + count + ")'>";
newRow += "<div id='imagePreview" + count + "' class='mt-2'></div>";
newRow += "</div>";
newRow += "</td>";
newRow += "</tr>";


// Always add the Remove Button
newRow += "<tr id='row" + count + "_remove' class='sub-topic-row'>";
newRow += "<td colspan='3' class='pl-2'>";
newRow += "<button class='remove-btn primary-btn icon-only fix-gr-bg' type='button' onclick='removeForm(" + count + ")'>";
newRow += "<span class='ti-trash'></span>";
newRow += "</button>";
newRow += "</td>";
newRow += "</tr>";


$("#subtopicTable tbody").append(newRow);


$("#addSubRowBtn").button("reset");
};

function removeForm(rowId) {
// Remove all related rows
$("#subtopicTable tbody tr[id^='row" + rowId + "']").remove();
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
 // END ADD SUB TOPIC ROW BUTTON //



        function deleteTopic(id) {
            var modal = $('#deleteTopicModal');
            modal.find('input[name=id]').val(id)
            modal.modal('show');
        }


        function removeForm(rowId) {
            // Remove the main row and all related rows
            $("#subtopicTable tbody tr[id^='row" + rowId + "']").remove();
        }


        function checkRequiredFields() {
            const classSelected = $('#select_class').val() !== '';
            const sectionSelected = $('#select_section').val() !== '';
            const subjectSelected = $('#select_subject').val() !== '';
            const lessonSelected = $('#lesson_from_subject').val() !== '';
            const topicSelected = $('#select_topic').val() !== '';

            if (classSelected && sectionSelected && subjectSelected && lessonSelected && topicSelected) {
                $('#addSubRowBtn').prop('disabled', false);
                $('#saveBtn').prop('disabled', false);
            } else {
                $('#addSubRowBtn').prop('disabled', true);
                $('#saveBtn').prop('disabled', true);
            }
        }

        $(document).ready(function() {

            $(document).on('click', '.remove-btn', function() {
                const rowId = $(this).data('id');
                removeForm(rowId);
            });


            $('#addSubRowBtn').prop('disabled', true);

            $('#select_class, #select_section, #select_subject, #lesson_from_subject,#select_topic').on('change',
                function() {
                    checkRequiredFields();
                });


            checkRequiredFields();
        });

        addSubRowTopic();
        // <!------------------------------------------------------------- LESSON BASED TOPICS ------------------------------------------------------>

        console.log('HIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII')

        $('#lesson_from_subject').on('change', function() {
            var lesson_id = $(this).val();
            console.log(lesson_id)
                url = $('#url').val();
                console.log(url)

            $.ajax({
                url: url + '/lesson/adminajaxSelectTopic',
                type: 'GET',
                data: {
                    lesson_id: lesson_id
                },
                beforeSend: function() {
                    $('#select_topic_loader').addClass('pre_loader').removeClass('loader');
                },
                success: function(data) {
                console.log(data)

                    $('#select_topic').empty().append($('<option>', {
                        value: '',
                        text: 'Select Topic'
                    }));

                    data[0].forEach(function(topic) {
                        if (topic.is_sub_topic_enabled == 1) {
                            $('#select_topic').append(
                                $('<option>', {
                                    value: topic.id,
                                    text: topic.topic_title
                                })
                            );
                        }
                    });

                    $('#select_topic_loader').removeClass('pre_loader').addClass('loader');
                },
                error: function() {
                    $('#select_topic_loader').removeClass('pre_loader').addClass('loader');
                }
            });
        });




        // <!------------------------------------------------------------- LESSON BASED TOPICS ------------------------------------------------------>

       

    </script>
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 10px;
            height: 10px;
            padding: 12px 23px !important;
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

        #select_topic {
            width: 100%;
            border: 1px solid rgba(130, 139, 178, 0.3);
            border-radius: 3px;
            height: 46px;
            line-height: 44px;
            font-size: 13px;
            color: #415094;
            padding: 0px 25px;
            padding-left: 20px;
            font-weight: 300;
            border-radius:
        }

        table#table_id {
            max-height: 860px;
            overflow-y: scroll;
            overflow-x: auto;
            white-space: nowrap;
        }

        table#table_id::-webkit-scrollbar {
            width: 0.5px;
            color: #ddd;
        }
    </style>
@endpush
