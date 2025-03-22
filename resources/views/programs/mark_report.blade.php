@extends('backEnd.master')
@section('title')
Mark Report
@endsection
@push('css')
<style>
    .search-right {
        text-align: end;
    }

    .shimmerBG {
        animation-duration: 2.2s;
        animation-fill-mode: forwards;
        animation-iteration-count: infinite;
        animation-name: shimmer;
        animation-timing-function: linear;
        background: #ddd;
        background: linear-gradient(to right, #F6F6F6 8%, #F0F0F0 18%, #F6F6F6 33%);
        background-size: 1200px 100%;
    }


    @-webkit-keyframes shimmer {
        0% {
            background-position: -100% 0;
        }

        100% {
            background-position: 100% 0;
        }
    }

    @keyframes shimmer {
        0% {
            background-position: -1200px 0;
        }

        100% {
            background-position: 1200px 0;
        }
    }

    .media {
        height: 200px;
    }
</style>
@endpush
@section('mainContent')
<section class="sms-breadcrumb mb-20 up_breadcrumb">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>Mark Report</h1>
            <div class="bc-pages">
                <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                <a href="#">Mark</a>
                <a href="#">Mark Report</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box filter_card">
                    <div class="row">
                        <div class="col-lg-8 col-md-6 col-sm-6">
                            <div class="main-title mt_0_sm mt_0_md">
                                <h3 class="mb-15">Search Mark Report</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Class Selection -->
                        <div class="col-lg-3">
                            <label class="primary_input_label" for="">
                                Program
                                <span class="text-danger"> *</span>
                            </label>
                            <select id="common_select_class" name="class_id[]" multiple="multiple"
                                class="multypol_check_select active position-relative form-control{{ $errors->has('class_id') ? ' is-invalid' : '' }}">

                                @if (isset($classes))
                                @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ isset($class_id) ? ($class_id == $class->id ? 'selected' : '') : '' }}>
                                    {{ $class->class_name }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            <div class="pull-right loader loader_style" id="common_select_class_loader">
                                <img class="loader_img_style" src="{{ asset('public/backEnd/img/demo_wait.gif') }}" alt="loader">
                            </div>
                        </div>

                        <!-- Section Selection -->
                        <div class="col-lg-3">
                            <label class="primary_input_label" for="">
                                Level
                                <span class="text-danger"> </span>
                            </label>

                            <select class="primary_select form-control{{ $errors->has('section_id') ? ' is-invalid' : '' }}" id="common_select_section" name="section_id[]">
                                <option data-display="@lang('common.select_section') " value="">
                                    @lang('common.select_section')
                                </option>
                                @isset($sections)
                                @foreach ($sections as $section)
                                <option value="{{ $section->id }}" {{ isset($section_id) ? ($section_id == $section->id ? 'selected' : '') : '' }}>
                                    {{ $section->section_name }}
                                </option>
                                @endforeach
                                @endisset
                            </select>
                            <div class="pull-right loader loader_style" id="common_select_section_loader" style="margin-top: -30px; padding-right: 21px;">
                                <img src="{{ asset('public/backEnd/img/demo_wait.gif') }}" alt="" style="width: 28px; height: 28px;">
                            </div>
                            @if ($errors->has('promote_session'))
                            <span class="text-danger invalid-select" role="alert">
                                {{ $errors->first('promote_session') }}
                            </span>
                            @endif
                        </div>

                        <div class="col-lg-3 mt-30-md">
                            <label class="primary_input_label" for="">
                                Student
                                <span class="text-danger"> </span>
                            </label>
                            <select class="primary_select form-control{{ $errors->has('student_id') ? ' is-invalid' : '' }}" id="common_select_student" name="student_id[]">
                                <option data-display="@lang('common.select_section') " value="">
                                    @lang('common.select_section')
                                </option>
                                @isset($subjects)
                                @foreach ($subjects as $student)
                                <option value="{{ $student->id }}" {{ isset($student_id) ? ($student_id == $student->id ? 'selected' : '') : '' }}>
                                {{ $student->full_name }}
                                </option>
                                @endforeach
                                @endisset
                            </select>

                            <div class="pull-right loader loader_style" id="select_subject_loader">
                                <img class="loader_img_style" src="{{ asset('public/backEnd/img/demo_wait.gif') }}"
                                    alt="loader">
                            </div>
                            @if ($errors->has('current_class'))
                            <span class="text-danger invalid-select" role="alert">
                                {{ $errors->first('current_class') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-lg-3 mt-30-md" id="sectionStudentDiv">

                        </div>
                        <div class="col-lg-3 mt-30-md" id="sectionStudentDiv">

                        </div>
                        <div class="col-lg-12 mt-20 search-right">
                            <button type="submit" class="primary-btn small fix-gr-bg" id="search_promote">
                                <span class="ti-search pr-2"></span>
                                @lang('common.search')
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</section>


<!-- Display the student mark report -->
<!-- <div class="section-body" style="background: #fff; box-shadow:0px 0px 8px #ddd; padding:20px; margin:30px 0px 5px; border-radius:8px;">
    <div class="row" style="display: flex; align-items: center;">
        <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-xs-12">
            <div class="left-body d-flex" style="gap:2em; align-items:center;">
                <div class="imager" style="height: 100px; overflow:hidden; max-width: 20%; min-width: 19.98%;">
                    <img src=" {{ asset('public/backEnd/img/default.png') }}"
                        style="border-radius: 5px; height: 100%; width: 100%;" />
                </div>
                <div class="body-content">
                    <div class="top-body-head d-flex" style="gap:1em;">
                        <span style="color: #7C32FF; font-weight:600; text-transform:capitalize; font-size:14px;" class="sp-bodyHead"></span>
                        <span class="head-link" style="font-weight: 500; color:#112375;"></span>
                        @if (Auth::user() && Auth::user()->is_administrator)
                        <div class="svg-inner" style="position: relative;">
                            <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="27" height="27" rx="5" fill="#009580" />
                            </svg>
                            <svg style="position: absolute; left:10px; top:7.5px;" width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.11439 4.7418L1.64516 0.312997C1.3464 0.108323 1.04538 0 0.79517 0C0.311439 0 0.012207 0.388229 0.012207 1.03807V10.61C0.012207 11.2591 0.311062 11.6466 0.793662 11.6466C1.04425 11.6466 1.34046 11.5382 1.63988 11.3329L8.11213 6.90422C8.52836 6.61894 8.75886 6.23504 8.75886 5.82277C8.75896 5.41079 8.53109 5.02699 8.11439 4.7418Z" fill="white" />
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div class="ic-sec d-flex" style="gap: 2em; margin-top:5px;">
                        <div class="sec-ic">
                            <span class="ic"><i class="ti-alarm-clock"></i></span>
                            <span class="ic-link" style="padding-left: 3px;"></span>
                        </div>
                        <div class="sec-ic">
                            <span class="ic"><i class="ti-star"></i></span>
                            <span class="ic-link" style="padding-left: 3px;"> lessons</span>
                        </div>
                        <div class="sec-ic">
                            <span class="ic"><i class="ti-harddrives"></i></span>
                            <span class="ic-link" style="padding-left: 3px;"> topics</span>
                        </div>
                        <div class="sec-ic">
                            <span class="ic"><i class="ti-harddrives"></i></span>
                            <span class="ic-link" style="padding-left: 3px;"> subtopics</span>
                        </div>
                        <div class="sec-ic">
                            <span class="ic"><i class="fa fa-file-zip-o"></i></span>
                            <span class="ic-link" style="padding-left: 3px;">
                                Mark List
                            </span>
                        </div>

                    </div>
                    <div class="progress-sec" style="margin-top: 10px;">
                        <span class="progress-head" style="color: #47464A;">Progress</span>
                        @isset($progresscount)
                        <div class="d-flex" style="gap: 0.6em;">

                            <span id="progress-value" class="progress-value"></span>
                        </div>
                        @endisset
                    </div>
                </div>
            </div>
        </div>

    </div>
</div> -->
<div id="Reponsedata"  >
    
</div>






@endsection

@push('script')
<script type="text/javascript" src="{{ asset('public/backEnd/multiselect/js/jquery.multiselect.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $("select[multiple].active.multypol_check_select").multiselect({
            columns: 1,
            placeholder: "Select Class",
            search: true,
            searchOptions: {
                default: "Select"
            },
            selectAll: true,
        });
    });


    $('#search_promote').on('click', function(e) {
        e.preventDefault();

        var class_id = $('#common_select_class').val();
        var section_id = $('#common_select_section').val();
        var student_id = $('#common_select_student').val();
        $.ajax({
            url: "{{ route('mark-report-details') }}",
            type: 'GET',
            data: {
                class_id: class_id,
                section_id: section_id,
                student_id: student_id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                var studentIds = [];
                var studentList = '';

                if (response.length > 0) {
                    $.each(response, function(index, studentRecord) {
                        if (studentRecord.student) {
                            studentIds.push(studentRecord.student.id);
                        }
                    });
                    var svgDownload = '<div id="downloadSvg" style="cursor:pointer;text-align: center;background: #fff; box-shadow: 0px 0px 8px #ddd; padding: 20px; margin: 30px 0px 5px; border-radius: 8px;">' +
                        '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">' +
                        '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>' +
                        '<polyline points="7 10 12 15 17 10"/>' +
                        '<line x1="12" y1="15" x2="12" y2="3"/>' +
                        '</svg>' +
                        '<p>Click to download data in ZIP</p>' +
                        '</div>';

                    $('#Reponsedata').html(svgDownload);
                    $('#downloadSvg').on('click', function() {
                        downloadZip(studentIds);
                    });

                } else {
                    studentList = '<p>No students found for the selected class and section.</p>';
                    $('#Reponsedata').html(studentList);
                }
            },
            error: function(xhr) {
                toastr.error("Error: " + xhr.responseText, "Request Failed");
            }
        });
    });


    // function downloadZip(studentIds) {
    //     $.ajax({
    //         url: "{{ route('export-students') }}",  
    //         type: 'POST',
    //         data: {
    //             student_ids: studentIds,
    //             _token: '{{ csrf_token() }}'
    //         },
    //         success: function(response) {

    //             window.location.href = response.zip_url;  
    //         },
    //         error: function(xhr) {
    //             console.error("Error during ZIP download: ", xhr.responseText);
    //         }
    //     });
    // }
    function downloadZip(studentIds) {
        $.ajax({
            url: "{{ route('export-students') }}",
            method: 'POST', 
            data: {
                student_ids: studentIds 
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            xhrFields: {
                responseType: 'blob' 
            },
            success: function(data, status, xhr) {
                const blob = new Blob([data], {
                    type: xhr.getResponseHeader('Content-Type')
                });
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'student_mark_lists.zip';
                link.click();
            },
            error: function(xhr, status, error) {
                console.error('Error downloading PDFs:', error);
                toastr.error('An error occurred while downloading the files.');
            }
        });
    }

    $("#common_select_class").on("change", function() {
        var url = $("#url").val();
        var formData = {
            id: $(this).val()
        };
        $.ajax({
            type: "GET",
            data: formData,
            dataType: "json",
            url: url + "/" + "ajaxStudentClassmultipleSection",
            beforeSend: function() {
                $('#common_select_section_loader').addClass('pre_loader').removeClass('loader');
            },
            success: function(data) {
                $("#common_select_section").empty().append(
                    $("<option>", {
                        value: '',
                        text: window.jsLang('select_section'),
                    })
                );
                if (data[0].length) {
                    $.each(data[0], function(i, section) {
                        $("#common_select_section").append(
                            $("<option>", {
                                value: section.id,
                                text: section.section_name,
                            })
                        );
                    });
                }
                $('#common_select_section').niceSelect('update');
                $('#common_select_section').trigger('change');
            },
            error: function(data) {
                console.log("Error:", data);
            },
            complete: function() {
                $('#common_select_section_loader').removeClass('pre_loader').addClass('loader');
            }
        });
    });

    $("#common_select_section").on("change", function() {
        var url = $("#url").val();
        var formData = {
            id: $(this).val()
        };
        $.ajax({
            type: "GET",
            data: formData,
            dataType: "json",
            url: url + "/" + "ajaxStudentSectionStudent",
            beforeSend: function() {
                $('#select_subject_loader').addClass('pre_loader').removeClass('loader');
            },
            success: function(data) {
                $("#common_select_student").empty().append(
                    $("<option>", {
                        value: '',
                        text: window.jsLang('select_section'),
                    })
                );
                if (data[0].length) {
                    $.each(data[0], function(i, section) {
                        $("#common_select_student").append(
                            $("<option>", {
                                value: section.id,
                                text: section.full_name,
                            })
                        );
                    });
                }
                $('#common_select_student').niceSelect('update');
                $('#common_select_student').trigger('change');
            },
            error: function(data) {
                console.log("Error:", data);
            },
            complete: function() {
                $('#select_subject_loader').removeClass('pre_loader').addClass('loader');
            }
        });
    });
</script>
@endpush