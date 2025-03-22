@extends('backEnd.master')
@section('title') 
@lang('lesson::lesson.edit_topic')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-20">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('lesson::lesson.edit_topic')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('lesson::lesson.lesson_plan')</a>
                <a href="#">@lang('lesson::lesson.topic')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">

    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'lesson.topic.update',
    'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
 

        <div class="row">
           
            <div class="col-lg-4 col-xl-3">
                
                <div class="row">
                    <div class="col-lg-12">

                        <div class="white-box">
                        <div class="main-title">
                            <h3 class="mb-15">@if(isset($topic))
                                    @lang('lesson::lesson.edit_topic')
                                @else
                                    @lang('lesson::lesson.update_topic')
                                @endif
                               
                            </h3>
                        </div>
                            <div class="add-visitor">
                           
                                <div class="row mt-25">
                                     <div class="col-lg-12">

                                       <select class="primary_select form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_class" name="class" disabled="">
                                        <option data-display="@lang('common.select_class') *" value="">@lang('common.select_class') *</option>
                                        @foreach($classes as $class)                                      
                                        <option value="{{@$class->id}}"  {{ @$class->id == @$topic->class_id?'selected':''}}>{{@$class->class_name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('class'))
                                    <span class="text-danger invalid-select" role="alert">
                                        {{ $errors->first('class') }}
                                    </span>
                                    @endif

                                </div>
                                </div> 
                                    <input type="hidden" name="topic_id" value="{{$topic->id}}">
                                <div class="row mt-25">

                                        <div class="col-lg-12" >

                                            <select class="primary_select form-control {{ $errors->has('class') ? ' is-invalid' : '' }}" id="select_section" name="section" disabled="">
                                            <option data-display="@lang('common.select_section') *" value="">@lang('common.select_section') *</option>
                                            @foreach($sections as $section)
                                            <option value="{{@$section->id}}" {{ @$section->id == @$topic->section_id?'selected':''}}>{{@$section->section_name}}</option>
                                            @endforeach
                                        </select>
                                                @if ($errors->has('section'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('section') }}
                                                </span>
                                                 @endif

                                        </div>
                                 </div>
                                       <div class="row mt-25">
                                     <div class="col-lg-12" id="">
                                         <select class="primary_select form-control{{ $errors->has('subject') ? ' is-invalid' : '' }} select_subject" id="select_subject" name="subject" disabled="">
                                            <option data-display="@lang('common.select_section') *" value="">@lang('common.select_section') *</option>
                                            @foreach($subjects as $subject)
                                            <option value="{{@$subject->id}}" {{ @$subject->id == @$topic->subject_id?'selected':''}}>{{@$subject->subject_name}} ({{$subject->subject_type=='T' ? 'Theory' : 'Practical'}})</option>
                                            @endforeach

                                        </select>
                                        @if ($errors->has('subject'))
                                        <span class="text-danger invalid-select" role="alert">
                                            {{ $errors->first('subject') }}
                                        </span>
                                        @endif
                                      </div>  
                                </div>
                                <div class="row mt-25">

                                        <div class="col-lg-12" id="select_lesson_div">

                                           <select class="primary_select form-control{{ $errors->has('section') ? ' is-invalid' : '' }} select_lesson" id="select_lesson" name="lesson" disabled="">
                                            <option data-display="@lang('common.select_section') *" value="">@lang('common.select_section') *</option>
                                            @foreach($lessons as $lesson)
                                            <option value="{{@$lesson->id}}" {{ @$lesson->id == @$topic->lesson_id?'selected':''}}>{{@$lesson->lesson_title}}</option>
                                            @endforeach

                                                </select>
                                                @if ($errors->has('lesson'))
                                                <span class="text-danger invalid-select" role="alert">
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
                               <div class="row">
                               
                                </div>
                            <table  id="productTable">
                                <thead>
                                    <tr>
                                  
                                      
                                    </tr>
                                </thead>

                                @foreach($topicDetails as $topicData)
                                    <tbody>
                                        <input type="hidden" name="topic_detail_id[]" value="{{$topicData->id}}">
                                        <tr id="row1">
                                            <td class="pt-2">
                                                <input type="hidden" name="url" id="url" value="{{URL::to('/')}}"> 
                                                <input type="hidden" id="lang" value="@lang('lesson::lesson.title')">

                                                <!-- Enable Subtopic Toggle -->

                                                <div class="primary_input mt-4">
                                                    <label style="top: -5px">@lang('communicate.enable_sub_topic')</label>
                                                    <label class="switch_toggle">
                                                    <input type="hidden" name="sub_topic_enabled[{{$loop->index}}]" value="0">
                                                        <input type="checkbox" id="sub_topic_enabled_{{$loop->index}}" name="sub_topic_enabled[{{$loop->index}}]" value="1"
                                                            onchange="togglesubTopicFields(this, {{$loop->index}})" {{ $topicData->is_sub_topic_enabled ? 'checked' : '' }}>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>

                                                <!-- Title -->

                                                <div class="primary_input mt-3">
                                                    <label style="top: -5px">@lang('lesson::lesson.title')</label>
                                                    <input class="primary_input_field form-control{{ $errors->has('topic') ? ' is-invalid' : '' }}"
                                                        type="text" id="topic" name="topic[]" autocomplete="off" value="{{isset($topicData)? $topicData->topic_title : '' }}" required="">
                                                </div>


                                                
                                                <!-- Fields shown only if Enable Mark is active -->

                                                <div id="mark_fields_{{$loop->index}}" style="{{ $topicData->is_mark_enabled ? '' : 'display:none;' }}">
                                                    
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <div class="primary_input">
                                                                <label style="top: -5px">@lang('communicate.cgpa')</label>
                                                                <input class="primary_input_field form-control{{ $errors->has('cgpa.'.$loop->index) ? ' is-invalid' : '' }}"
                                                                    type="text" id="cgpa_{{$loop->index}}" name="cgpa[]" autocomplete="off" value="{{ old('cgpa.'.$loop->index, $topicData->cgpa) }}">
                                                                @if ($errors->has('cgpa.'.$loop->index))
                                                                <span class="text-danger">
                                                                        {{ $errors->first('cgpa.'.$loop->index) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="primary_input">
                                                                <label style="top: -5px">@lang('communicate.unit')</label>
                                                                <input class="primary_input_field form-control{{ $errors->has('unit.'.$loop->index) ? ' is-invalid' : '' }}"
                                                                    type="text" id="unit_{{$loop->index}}" name="unit[]" autocomplete="off" value="{{ old('unit.'.$loop->index, $topicData->unit) }}">
                                                                @if ($errors->has('unit.'.$loop->index))
                                                                    <span class="text-danger">
                                                                        {{ $errors->first('unit.'.$loop->index) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
    

                                                    <div id="avg_max_marks_{{$loop->index}}" style="{{ $topicData->is_sub_topic_enabled ? 'display:none;' : '' }}">
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <div class="primary_input">
                                                                <label style="top: -5px">@lang('communicate.max_marks')</label>
                                                                <input class="primary_input_field form-control{{ $errors->has('max_marks.'.$loop->index) ? ' is-invalid' : '' }}"
                                                                    type="text" id="max_marks_{{$loop->index}}" name="max_marks[]" autocomplete="off" value="{{ old('max_marks.'.$loop->index, $topicData->max_marks) }}">
                                                                @if ($errors->has('max_marks.'.$loop->index))
                                                                    <span class="text-danger">
                                                                        {{ $errors->first('max_marks.'.$loop->index) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="primary_input">
                                                                <label style="top: -5px">@lang('communicate.avg_marks')</label>
                                                                <input class="primary_input_field form-control{{ $errors->has('avg_marks.'.$loop->index) ? ' is-invalid' : '' }}"
                                                                    type="text" id="avg_marks_{{$loop->index}}" name="avg_marks[]" autocomplete="off" value="{{ old('avg_marks.'.$loop->index, $topicData->avg_marks) }}">
                                                                @if ($errors->has('avg_marks.'.$loop->index))
                                                                    <span class="text-danger">
                                                                        {{ $errors->first('avg_marks.'.$loop->index) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>

                                                <div id="image_{{$loop->index}}" style="{{ $topicData->is_sub_topic_enabled ? 'display:none;' : '' }}">
                                                    <div class="primary_input">
                                                        <label style="top: -5px">@lang('lesson::lesson.image')</label>
                                                        <input class="primary_input_field form-control{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                                            type="file" id="image" name="image[]" autocomplete="off" value="{{isset($topicData)? $topicData->image : '' }}">

                                                            @php
                                                    
                                                                $fileExtension = pathinfo($topicData->image, PATHINFO_EXTENSION);
                                                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                                                            @endphp

                                                            @if(isset($topicData->image) && !empty($topicData->image))
                                                                <div id="imagePreview_{{$loop->index}}" style="position: relative;">
                                                                   
                                                                    @if(in_array(strtolower($fileExtension), $imageExtensions))
                                                                       
                                                                        <img src="{{ asset('public/' . $topicData->image) }}" alt="Image" style="max-width: 100px; margin-top: 10px;">

                                                                    @else

                                                                        @if($fileExtension === 'pdf')

                                                                            <img src="{{ asset('public/uploads/settings/pdf-blue.png') }}" alt="PDF Icon" style="max-width: 80px; margin-top: 10px;">
                                                                        
                                                                        @elseif($fileExtension === 'csv')

                                                                            <img src="{{ asset('public/uploads/settings/csv-fileblue.png') }}" alt="CSV Icon" style="max-width: 80px; margin-top: 10px;">
                                                                        
                                                                        @elseif($fileExtension === 'doc')

                                                                            <img src="{{ asset('public/uploads/settings/doc-blue.png') }}" alt="DOC Icon" style="max-width: 80px; margin-top: 10px;">
                                                                       
                                                                         @elseif($fileExtension === 'docx')

                                                                            <img src="{{ asset('public/uploads/settings/docx-file-blue.png') }}" alt="DOCX Icon" style="max-width: 80px; margin-top: 10px;">
                                                                       
                                                                         @else
                                                                          
                                                                            <img src="{{ asset('public/backEnd/img/default.png') }}" alt="Default Icon" style="max-width: 80px; margin-top: 10px;">
                                                                       
                                                                        @endif

                                                                    @endif

                                                                    <span class="deleteImage" id="deleteImage_{{$loop->index}}" onclick="deleteImage({{$topicData->id}}, {{$loop->index}})">&times;</span>
                                                                
                                                                </div>
                                                            @endif

                                                    </div>  
                                                </div>

                                                <!-- Enable Mark Toggle -->

                                                <div class="primary_input mt-3">
                                                    <label style="top: -5px">@lang('communicate.enable_mark')</label>
                                                    <label class="switch_toggle">
                                                    <input type="hidden" name="cgpa_unit_enabled[{{$loop->index}}]" value="0">
                                                        <input type="checkbox" id="mark_enabled_{{$loop->index}}" name="cgpa_unit_enabled[{{$loop->index}}]" value="1"
                                                            onchange="toggleMarkFields(this, {{$loop->index}})" {{ $topicData->is_mark_enabled ? 'checked' : '' }}>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>

                                            </td>
                                            

                                            <td>
                                                <a href="" data-toggle="modal" data-target="#deleteTopicTitle{{$topicData->id}}">
                                                    <button style="position: relative; top: 18px; left: 5px;" class="primary-btn icon-only fix-gr-bg" type="button">
                                                        <span class="ti-trash"></span>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <div class="modal fade admin-query" id="deleteTopicTitle{{$topicData->id}}">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">@lang('common.delete_topic')</h4>
                                                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                    </div>
                                                    <div class="mt-40 d-flex justify-content-between">
                                                        <button type="button" class="primary-btn tr-bg" data-bs-dismiss="modal">@lang('common.cancel')</button>
                                                        <a href="{{route('topicTitle-delete',[$topicData->id])}}" class="primary-btn fix-gr-bg">@lang('common.delete')</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                            </table>
                        </div>
                    </div>
                </div>

                               @php 
                                  $tooltip = "";
                                  if(userPermission("topic-edit")){
                                        $tooltip = "";
                                    }else{
                                        $tooltip = "You have no permission to add";
                                    }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12">
                                        <div class="white-box">                               
                                            <div class="row mt-40">
                                                <div class="col-lg-12 text-center">
                                                  <button class="primary-btn fix-gr-bg" data-toggle="tooltip" title="{{ @$tooltip}}">
                                                        <span class="ti-check"></span>
                                                        @if(isset($data))
                                                            @lang('lesson::lesson.update_topic')
                                                        @else
                                                            @lang('lesson::lesson.update_topic')
                                                        @endif
                                                      

                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
            {{ Form::close() }}

            <div class="col-lg-8 col-xl-9 mt-4 mt-lg-0">
                <div class="white-box">

                @if(isset($topicDetails))
                @if(userPermission('lesson.topic.store'))
                <div class="row">
                    <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                        <a href="{{route('lesson.topic')}}" class="primary-btn small fix-gr-bg">
                            <span class="ti-plus"></span>
                            @lang('common.add')
                        </a>
                    </div>
                </div>

                @endif
                @endif


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
                            <table id="table_id" class="table edit-data-table table-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>@lang('common.sl')</th>                                       
                                        <th>@lang('common.class')</th>
                                        <th>@lang('common.section')</th>
                                        <th>@lang('lesson::lesson.subject')</th>
                                        <th>@lang('lesson::lesson.lesson')</th>
                                        <th>@lang('lesson::lesson.topic')</th>
                                        <th>@lang('lesson::lesson.total_mark')</th>
                                        <th>@lang('lesson::lesson.image')</th>
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
{{-- delete topic here  --}}

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
                        <button type="button" class="primary-btn tr-bg"
                                data-bs-dismiss="modal">@lang('common.cancel')</button>
                        {{ Form::open(['route' => array('topic-delete'), 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                            <input type="hidden" name="id" value="">
                        <button class="primary-btn fix-gr-bg"
                                type="submit">@lang('common.delete')</button>
                        {{ Form::close() }}
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
@push('script')
    <script type="text/javascript" src="{{url('Modules\Lesson\Resources\assets\js\app.js')}}"></script>
    <script src="{{asset('public/backEnd/')}}/js/lesson_plan.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush 

@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')
@push('script')  

<script>
   $(document).ready(function() {
       $('.edit-data-table').DataTable({
                     processing: true,
                     serverSide: true,
                     "ajax": $.fn.dataTable.pipeline( {
                           url: "{{route('get-all-topics-ajax')}}",
                           data: { 
                            },
                           pages: "{{generalSetting()->ss_page_load}}" // number of pages to cache
                           
                       } ),
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
                                name: 'max_marks',
                                render: function(data) {
                                    if (data) {
                                        return data;
                                    } else {
                                        return 'N/A';
                                    }
                                }
                            },
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
            } );
</script>
<script>
    function deleteTopic(id){
        var modal = $('#deleteTopicModal');
        modal.find('input[name=id]').val(id)
        modal.modal('show');
    }



    function togglesubTopicFields(el, index) {
    var imageField = document.getElementById('image_' + index);
    var avg_max_marks = document.getElementById('avg_max_marks_' + index);
    if (el.checked) {
        imageField.style.display = 'none';
        avg_max_marks.style.display = 'none';  
    } else {
        imageField.style.display = 'block';
        avg_max_marks.style.display = 'block';
    }
        $('#max_marks_' + index).val("");
        $('#avg_marks_' + index).val("");
        $('#image_' + index).val("");
}

function toggleMarkFields(el, index) {
    var markFields = document.getElementById('mark_fields_' + index);
    if (el.checked) {
        markFields.style.display = 'block';
    } else {
        markFields.style.display = 'none';
    }
        $('#cgpa_' + index).val("");
        $('#unit_' + index).val("");
        $('#max_marks_' + index).val("");
        $('#avg_marks_' + index).val("");
}


function deleteImage(topicId, index) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to delete this image?",
        // icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#732CFF',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        customClass: {
            cancelButton: 'cancel-button' 
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('edit-image-delete') }}?id=" + topicId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        document.getElementById('imagePreview_' + index).style.display = 'none';
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The image has been deleted.',
                            icon: null,  
                            showConfirmButton: true, 
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            'Image deletion failed. Please try again.',
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'An error occurred while deleting the image.',
                        'error'
                    );
                }
            });
        }
    });
}


</script>
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 34px; 
  height: 20px; 
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
  background-color: #ffffff; 
  transition: .4s;
  border-radius: 34px;
  box-shadow: 0 0 5px rgba(0, 0, 0, 0.2); 
}

.slider:before {
  position: absolute;
  content: "";
  height: 17px;
  width: 17px;
  border-radius: 50%;
  left: 2px;
  bottom: 1.5px;
  background-color: white;
  transition: .4s;
}

input:checked + .slider {
  background-color: #732CFF; 
}

input:checked + .slider:before {
  transform: translateX(14px); 
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
.switch_toggle input:checked + .slider {
    background: #732CFF;
}
.switch_toggle input:checked+.slider:before{
    background: #ffffff !important;
}
.switch_toggle .slider {
    background-color: #c2c5cd;
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
  color:#fff;
}


input[type="file"]::file-selector-button:hover {
  background-color: #7c32ff;
}


input[type="file"]::file-selector-button:active {
  background-color: #7c32ff;
}

.deleteImage{
    position: absolute;
    top: 0;
    right: 60%;
    cursor: pointer;
    font-size: 20px;
    color: #ffffff;
    background-color: red;
    border-radius: 50%;
    height: 18px;
    width: 17px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 5px;

}
button.swal2-cancel.cancel-button.swal2-styled.swal2-default-outline{
    display: inline-block;
    background-color: #ffffff !important;
    border: 1px solid #732CFF;
    color: #732CFF;
}
button.swal2-confirm.swal2-styled {
    background-color: #732CFF;
}
.swal2-popup.swal2-modal.swal2-icon-success.swal2-show {
    border-radius: 15px !important;
    width: 25em !important;
}
</style>
@endpush
