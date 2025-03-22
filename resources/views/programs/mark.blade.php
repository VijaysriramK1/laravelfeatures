@extends('backEnd.master')
@section('title')
Mark
@endsection
@push('css')
<style>
    span.tab-sec.active {
        color: #112375;
        font-weight: 500;
        border-bottom: 3px solid #7C32FF;
        padding-bottom: 10px;
    }

    span.tab-sec {
        font-size: 14px;
        cursor: pointer;
    }

    span.tab-sec:hover {
        color: #112375;
        font-weight: 500;
        border-bottom: 3px solid #7C32FF;
        padding-bottom: 10px;
    }

    .collapse-section {
        margin-left: 12%;
    }

    .collase-main {
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0px 0px 8px #ddd;
        margin-bottom: 10px;
    }

    span.lock {
        position: absolute;
        left: 9%;
        top: 40px;
        color: #fff;
        font-size: 26px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 10px;
        height: 8px;
        padding: 12px 25px !important;
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
        height: 19px;
        width: 19px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    .switch::after {
        display: none;
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

    .section-body {
        cursor: pointer;
    }

    .row-inner .row {
        cursor: pointer;
    }

    .collase-main {
        cursor: pointer;
    }

    a.inner-link {
        cursor: pointer;
    }

    .dataTables_processing {
        display: none !important;
    }

    .single-line {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .primary_input_field {
        display: inline-block;
    }


    .text-right {
        text-align: right !important;
        margin-top: -52px;
        margin-bottom: 14px;
    }

    .dataTables_filter {
        display: none;
    }

    .dt-buttons {
        margin-right: 120px;
    }

    .search-right {
        text-align: right;
    }

    .input-group-inline {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .consistent-input {
        width: 45px;
        max-width: 100%;
        display: inline-block;
        margin-right: 5px;
        max-height: 35px
    }

    .icon-text {
        font-size: 15px;
        color: green;
        margin-left: 4px;
    }

    span {
        margin-right: 3px;

    }


    .svg-container {
        position: relative;
        display: inline-block;
    }

    .icon {
        position: absolute;
        left: 8px;
        top: 5.5px;
        fill: white;
    }

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
        display: none;
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

    .buttom-text-right {
        text-align: right !important;
        margin-top: 11px;
    }

    .input-group-inline .amount {
        color: black;
        /* Default color */
    }

    .danger-btn {
        display: inline-block;

        letter-spacing: 1px;
        font-family: "Poppins", sans-serif;
        font-size: 12px;
        font-weight: 500;
        line-height: 40px;
        padding: 0px 20px;
        outline: none !important;
        text-align: center;
        cursor: pointer;
        text-transform: uppercase;
        border: 0;
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        -webkit-transition: all 0.4s ease 0s;
        -moz-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
    }

    .light-btn {
        display: inline-block;
        color: var(--base_color);
        background-color: transparent;
        letter-spacing: 1px;
        font-family: "Poppins", sans-serif;
        font-size: 12px;
        font-weight: 500;
        line-height: 40px;
        padding: 0px 20px;
        outline: none !important;
        text-align: center;
        cursor: pointer;
        text-transform: uppercase;
        border: 1PX solid var(--base_color);
        border-radius: 10px;
        position: relative;
        overflow: hidden;
        -webkit-transition: all 0.4s ease 0s;
        -moz-transition: all 0.4s ease 0s;
        -o-transition: all 0.4s ease 0s;
        transition: all 0.4s ease 0s;
    }

    .icon_documents {
        position: relative;
        float: right;
        background: transparent;
        border: 1px solid #7c32ff;
        border-radius: 31px;
        height: 30px;
        line-height: 27px;
        transition: all 0.4s ease;
        /* Simplified transition */
        right: 90px;
        z-index: 10;
        /* Ensures icons are on top */
    }

    .icon_documents1 {
        position: relative;
        float: right;
        background: transparent;
        border: 1px solid #7c32ff;
        border-radius: 31px;
        height: 30px;
        line-height: 27px;
        transition: all 0.4s ease;
        /* Simplified transition */
        top: -20px;
        z-index: 10;
        /* Ensures icons are on top */
    }

    .icon_documents a,
    .icon_documents i {
        display: inline-block;
        /* Ensures icons are inline */
        cursor: pointer;
        /* Changes cursor to pointer for clickable icons */
        padding: 0 10px;
        /* Add padding around icons */
    }

    .icon_documents i {
        font-size: small;
        color: #333;
        transition: color 0.3s ease;
        /* Smooth color change on hover */
    }

    .icon_documents i:hover {
        color: #7c32ff;
        /* Change color on hover for better feedback */
    }
    .icon_documents1 a,
    .icon_documents1 i {
        display: inline-block;
        /* Ensures icons are inline */
        cursor: pointer;
        /* Changes cursor to pointer for clickable icons */
        padding: 0 10px;
        /* Add padding around icons */
    }

    .icon_documents1 i {
        font-size: small;
        color: #333;
        transition: color 0.3s ease;
        /* Smooth color change on hover */
    }

    .icon_documents1 i:hover {
        color: #7c32ff;
        /* Change color on hover for better feedback */
    }

    .text-right {
        right: -222px !important;

    }

    .tab-container {
        display: flex;
        gap: 2em;
        margin: 10px 0;
        overflow-x: auto;
        white-space: nowrap;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .tab-container::-webkit-scrollbar {
        display: none;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 19px;
        width: 19px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    .switch::after {
        display: none;
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

    .loader {
        border: 6px solid #f3f3f3;
        /* Light grey */
        border-top: 6px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 2s linear infinite;
        margin: 20px auto;
        /* Center the loader */
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
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
            <h1>@lang('communicate.Mark')</h1>
            <div class="bc-pages">
                <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                <a href="#">@lang('communicate.Progress')</a>
                <a href="#">@lang('communicate.Mark')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_admin_visitor">
    <div class="container-fluid p-0">
        @if($user->role_id == 1 || $user->role_id == 5)
        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'student-search', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'sma_form' ]) }}
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box filter_card">
                    <div class="row">
                        <div class="col-lg-8 col-md-6 col-sm-6">
                            <div class="main-title mt_0_sm mt_0_md">
                                <h3 class="mb-15">@lang('communicate.Mark')</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="primary_input_label" for="">
                                @lang('communicate.Progress')
                                <span class="text-danger"> *</span>
                            </label>
                            <select class="primary_select form-control{{ $errors->has('class_id') ? ' is-invalid' : '' }}" name="class" id="common_select_class">
                                <option data-display="@lang('common.select_class')" value="">
                                    {{ __('common.select_class') }}
                                </option>
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
                        <div class="col-lg-3">
                            <label class="primary_input_label" for="">
                                @lang('communicate.Level')
                                <span class="text-danger"> *</span>
                            </label>

                            <select class="primary_select form-control{{ $errors->has('section_id') ? ' is-invalid' : '' }}" id="common_select_section" name="section_id">
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
                                @lang('communicate.Competency Unit')
                                <span class="text-danger"> *</span>
                            </label>

                            <select class="primary_select form-control{{ $errors->has('section_id') ? ' is-invalid' : '' }}" id="common_select_Subject" name="subject_id">
                                <option data-display="@lang('common.select_subject') " value="">
                                    @lang('common.select_subject')
                                </option>
                                @isset($subjects)
                                @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">
                                    {{ $subject->subject_name }}
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
        {{ Form::close() }}
        @elseif($user->role_id == 4)
        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'teacher-search', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'sma_form' ]) }}
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box filter_card">
                    <div class="row">
                        <div class="col-lg-8 col-md-6 col-sm-6">
                            <div class="main-title mt_0_sm mt_0_md">
                                <h3 class="mb-15">@lang('communicate.Mark')</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <label class="primary_input_label" for="">
                                @lang('communicate.Progress')
                                <span class="text-danger"> *</span>
                            </label>
                            <select class="primary_select form-control{{ $errors->has('class_id') ? ' is-invalid' : '' }}" name="class" id="common_select_class">
                                <option data-display="@lang('common.select_class')" value="">
                                    {{ __('common.select_class') }}
                                </option>
                                @if (isset($assign_subjects))
                                @foreach ($assign_subjects as $class)
                                <option value="{{ $class->class_id }}" {{ isset($class_id) ? ($class_id == $class->class_id ? 'selected' : '') : '' }}>
                                    {{ $class->class->class_name }} <!-- Access the class relation -->
                                </option>
                                @endforeach
                                @endif

                            </select>
                            <div class="pull-right loader loader_style" id="common_select_class_loader">
                                <img class="loader_img_style" src="{{ asset('public/backEnd/img/demo_wait.gif') }}" alt="loader">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <label class="primary_input_label" for="">
                                @lang('communicate.Level')
                                <span class="text-danger"> *</span>
                            </label>

                            <select class="primary_select form-control{{ $errors->has('section_id') ? ' is-invalid' : '' }}" id="common_select_section" name="section_id">
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
                                @lang('communicate.Competency Unit')
                                <span class="text-danger"> *</span>
                            </label>

                            <select class="primary_select form-control{{ $errors->has('section_id') ? ' is-invalid' : '' }}" id="common_select_Subject" name="subject_id">
                                <option data-display="@lang('common.select_subject') " value="">
                                    @lang('common.select_subject')
                                </option>
                                @isset($subjects)
                                @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}">
                                    {{ $subject->subject_name }}
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
        {{ Form::close() }}

        {{-- @if (@$students) --}}
        @elseif($user->role_id == 2)
        <!-- HTML Structure -->
        <div class="section-sec" style="margin: 20px">
            <span class="head-section" style="font-size: 17px;color:#112375;font-weight:500;">My Mark</span>
            <div class="tab-container" data-has-classes="{{ $classes->isNotEmpty() ? 'true' : 'false' }}">
                @foreach ($smstudents as $index => $smstudent)
                <span class="tab-sec {{ $index == 0 ? 'active' : '' }}"
                    data-class-id="{{ $smstudent->class->id }}"
                    data-section-id="{{ $smstudent->section->id }}">
                    {{ $smstudent->class->class_name }}({{$smstudent->section->section_name}})
                </span>
                @endforeach
            </div>
        </div>
        <!-- Container to display the subjects -->
        <div id="subject-container">
            <div class="shimmerBG media" style="display: none;">
                <!-- Placeholder for content while loading -->
            </div>
        </div>

        <div id="toggle"></div>
        <!-- JavaScript -->
        <script>
            $(document).ready(function() {
                var firstClassId = $('.tab-sec.active').data('class-id');
                var firstSectionId = $('.tab-sec.active').data('section-id');


                if (firstClassId) {
                    loadSubjects(firstClassId, firstSectionId);
                }


                $('.tab-sec').on('click', function() {
                    $('.tab-sec').removeClass('active');
                    $(this).addClass('active');
                    var classId = $(this).data('class-id');
                    var sectionId = $(this).data('section-id');
                    loadSubjects(classId, sectionId);
                });


                function loadSubjects(classId, sectionId) {
                    $('#subject-container').html('<div class="shimmerBG media"></div>').show();
                    $.ajax({
                        url: '/get-subjects',
                        method: 'GET',
                        data: {
                            class_id: classId,
                            section_id: sectionId
                        },
                        success: function(response) {
                            $('#subject-container').empty();
                            if (response.subjects.length > 0) {
                                response.subjects.forEach(function(subject) {
                                    $('#subject-container').append(createSubjectHTML(subject));
                                });
                                $('#subject-container').show();
                            } else {
                                $('#subject-container').html('<p>No subjects found for this class.</p>').show();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error fetching subjects:', error);
                            $('#subject-container').html('<p>Error fetching subjects. Please try again later.</p>').show();
                        }
                    });
                }

                function createSubjectHTML(subject) {
                    const hasLessons = subject.lesson_count > 0;
                    const progress = subject.progress ? subject.progress.toFixed(2) : 0;

                    let lessonsHTML = '';
                    let topicsHTML = '';
                    let subtopicHTML = '';
                    let dataHTML = '';


                    if (hasLessons) {
                        subject.lessons.forEach(lesson => {
                            if (lesson.id !== 2) {
                                const enabledTopics = lesson.topics.filter(topic => topic.is_mark_enabled === 1);
                                const colspan = enabledTopics.reduce((carry, topic) => {
                                    return carry + (topic.subtopics.length > 0 ? topic.subtopics.length + 3 : 1);
                                }, 0) + 2;

                                if (enabledTopics.length > 0) {
                                    lessonsHTML += `   
                        <th colspan="${colspan}" class="text-center" style="background-color: white;">
                            ${lesson.lesson_title || 'No Lesson Title'}
                        </th>
                    `;

                                    let topicRowHTML = '';
                                    let subtopicRowHTML = '';
                                    let sumMarks = 0;

                                    enabledTopics.forEach(topic => {
                                        if (topic.subtopics.length > 0) {
                                            const topicColspan = topic.subtopics.length + 3;
                                            const marks = topic.max_marks || 0;
                                            sumMarks += marks;
                                            topicRowHTML += `
                                <th class="text-center" colspan="${topicColspan}" id="header_${topic.id}" 
                                    data-cgpa="${topic.cgpa || 1}" data-max_marks="${topic.max_marks}" data-topic-id="${topic.id}">
                                    ${topic.topic_title} - ${topic.cgpa || ''} ${topic.unit || ''}<br style="text-align: center;">${topic.mark_marks || ''}
                                </th>`;

                                            topic.subtopics.forEach(subtopic => {
                                                subtopicRowHTML += `
                                    <th class="text-center" data-max_marks="${subtopic.max_marks}" data-subtopic-id="${subtopic.id}" id="subtopic_${subtopic.id}">
                                        ${subtopic.sub_topic_title}<br>${subtopic.max_marks}
                                    </th>`;
                                            });

                                            subtopicRowHTML += `
                                <th class="text-center" style="background-color: #FFDD00;" id="totalmarks_${topic.id}">
                                    Total
                                </th>
                                <th class="text-center" style="background-color: #FFDD00;">
                                    Average
                                </th>
                                <th class="text-center" style="background-color: #FFAB2A;">
                                    Percentage
                                </th>`;
                                        } else {
                                            topicRowHTML += `
                                <th class="text-center" rowspan="2" id="header_${topic.id}" 
                                    data-cgpa="${topic.cgpa || 1}" data-max_marks="${topic.max_marks}" data-topic-id="${topic.id}">
                                    ${topic.topic_title} - ${topic.cgpa || ''} ${topic.unit || ''}<br>
                                </th>`;
                                        }
                                    });

                                    topicRowHTML += `
                        <th rowspan="2" class="text-center" style="background-color: #00C875;">
                            Grand Total<br>
                        </th>
                        <th rowspan="2" class="text-center" style="background-color: #5CA3FF;">
                            Grand Percentage<br>
                        </th>`;

                                    topicsHTML += topicRowHTML;
                                    subtopicHTML += subtopicRowHTML;
                                }
                            }
                        });


                        const studentDetail = subject.student_record.student_detail;
                        const studentMarks = subject.student_Mark;

                        if (studentDetail && Array.isArray(studentMarks)) {
                            let studentMarksHTML = `
                <tr>
                    <td>${studentDetail.id}</td>
                    <td>${studentDetail.full_name}
                    
                                </td>
            `;

                            subject.lessons.forEach(lesson => {
                                if (lesson.topics.some(topic => topic.is_mark_enabled) && lesson.id !== 2) {
                                    lesson.topics.forEach(topic => {
                                        if (topic.is_mark_enabled === 1) {
                                            if (topic.subtopics.length > 0) {
                                                topic.subtopics.forEach(subtopic => {

                                                    const mark = studentMarks.find(m =>
                                                        m.topic_id === topic.id.toString() &&
                                                        m.lesson_id === lesson.id.toString() &&
                                                        m.student_id === studentDetail.id.toString() &&
                                                        m.sub_topic_id === subtopic.id.toString()
                                                    );

                                                    studentMarksHTML += ` 
                                        <td class="single-line text-center" 
                                            data-student-id="${studentDetail.id}"
                                            data-topic-id="${topic.id}"
                                            data-subtopic-id="${subtopic.id}"
                                            data-lesson-id="${lesson.id}">
                                            ${mark?.mark_value || '0'}
                                        </td>`;
                                                });


                                                const topicTotalMark = studentMarks.find(m =>
                                                    m.topic_id === topic.id.toString() &&
                                                    m.lesson_id === lesson.id.toString() &&
                                                    m.student_id === studentDetail.id.toString()
                                                );

                                                studentMarksHTML += `
                                    <td class="text-center totalSumDisplay"
                                        data-student-id="${studentDetail.id}"
                                        data-topic-id="${topic.id}"
                                        data-lesson-id="${lesson.id}">
                                        ${topicTotalMark?.total || '0'}
                                    </td>
                                    <td class="text-center" id="averageMarkDisplay_${studentDetail.id}_${topic.id}">
                                        ${topicTotalMark?.average || '0'}
                                    </td>
                                    <td class="text-center" id="percentageMarkDisplay_${studentDetail.id}_${topic.id}">
                                        ${topicTotalMark?.percentage || '0'}
                                    </td>`;
                                            } else {

                                                const mark = studentMarks.find(m =>
                                                    m.topic_id === topic.id.toString() &&
                                                    m.lesson_id === lesson.id.toString() &&
                                                    m.student_id === studentDetail.id.toString() &&
                                                    m.sub_topic_id === "0"
                                                );

                                                studentMarksHTML += `
                                    <td class="single-line text-center" 
                                        data-student-id="${studentDetail.id}"
                                        data-topic-id="${topic.id}"
                                        data-lesson-id="${lesson.id}">
                                        ${mark?.mark_value || '0'}
                                    </td>`;
                                            }
                                        }
                                    });


                                    const grandTotalMark = studentMarks.find(m =>
                                        m.lesson_id === lesson.id.toString() &&
                                        m.student_id === studentDetail.id.toString()
                                    );

                                    studentMarksHTML += `
                        <td id="grandtotal_lesson_${lesson.id}_${studentDetail.id}" style="text-align: center;">
                            ${grandTotalMark?.grand_total || '0'}
                        </td>
                        <td id="grandtotal_${lesson.id}_${studentDetail.id}" style="text-align: center;">
                            ${grandTotalMark?.grand_percentage || '0'}
                        </td>`;
                                }
                            });


                            const overallMark = studentMarks.find(m =>
                                m.student_id === studentDetail.id.toString() &&
                                m.overall_percpercentage
                            );


                            studentMarksHTML += `
    <td id="overall_${studentDetail.id}" style="text-align: center;">
        ${overallMark?.overall_percpercentage || '0%'}
    </td>
</tr>`;
                            dataHTML += studentMarksHTML;
                        } else {
                            dataHTML += `<tr><td colspan="100%" class="text-center">No students available.</td></tr>`;
                        }

                    } else {
                        lessonsHTML = `  
            <tr>
                <td colspan="100%" class="text-center">No lessons available for this subject.</td>
            </tr>`;
                    }
                    return `
        <div class="section-body" style="background: #fff; box-shadow:0px 0px 8px #ddd; padding:20px; margin:30px 0px 5px; border-radius:8px;"
            onclick="toggleLesson('table-section-${subject.id}')">
            <div class="row" style="display: flex; align-items: center;">
                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-xs-12">
                    <div class="left-body d-flex" style="gap: 2em; align-items:center;">
                        <div class="imager" style="height: 100px; overflow:hidden; max-width: 20%; min-width: 19.98%;">
                            <img src="${subject.image ? '/public/' + subject.image : '/public/backEnd/img/default.png'}" style="border-radius: 5px; height: 100%; width: 100%;" />
                        </div>
                        <div class="body-content">
                            <div class="top-body-head d-flex" style="gap: 1em;">
                                <span style="color: #7C32FF; font-weight:600; text-transform:capitalize; font-size:14px;" class="sp-bodyHead">${subject.subject_code}</span>
                                <span class="head-link" style="font-weight: 500; color:#112375;">${subject.subject_name}</span>
                            </div>
                            <div class="ic-sec d-flex" style="gap: 2em; margin-top: 5px;">
                                <div class="sec-ic">
                                    <span class="ic"><i class="ti-alarm-clock"></i></span>
                                    <span class="ic-link" style="padding-left: 3px;">${subject.duration || 'N/A'} ${subject.duration_type || ''}</span>
                                </div>
                                <div class="sec-ic">
                                    <span class="ic"><i class="ti-star"></i></span>
                                    <span class="ic-link" style="padding-left: 3px;">${subject.lesson_count ?? '0'} @lang('communicate.lessons')</span>
                                </div>
                                <div class="sec-ic">
                                    <span class="ic"><i class="ti-harddrives"></i></span>
                                    <span class="ic-link" style="padding-left: 3px;">${subject.topics_count ?? '0'} @lang('communicate.topics')</span>
                                </div>
                                <div class="sec-ic">
                                    <span class="ic"><i class="ti-harddrives"></i></span>
                                    <span class="ic-link" style="padding-left: 3px;">${subject.subtopics_count ?? '0'} @lang('communicate.subtopics')</span>
                                </div>
                                <div class="sec-ic">
                                <span class="ic">
                                    <i class="fa fa-file-zip-o"></i>
                                </span>
                                <span class="ic-link" style="padding-left: 3px;" onclick="event.stopPropagation();downloadPDF('${subject.id}')">
                                   @lang('communicate.Download Marksheet')
                                </span>
                                 </div>
                             </div>
                            <div class="progress-sec" style="margin-top: 10px;">
                                <span class="progress-head" style="color: #47464A;">Progress</span>
                                <div class="d-flex" style="gap: 0.6em;">
                                    <div class="progress" style="margin-top: 8px; height: 8px; width: 100%;">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: ${progress}%; height: 15px; background: #FFAB2A;" aria-valuenow="${progress}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span style="font-weight: 600; color: #47464A;">${progress}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-40 full_wide_table" id="table-section-${subject.id}" style="display:none;">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-15">Add Marks</h3>
                                    <h3 class="mb-15" style="color: gray;font-size:small">Add mark for each activities here</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <div class="icon_documents1">
                                        <i class="fa fa-files-o" id="copyTableButton" title="copy" onclick="event.stopPropagation();"></i>
                                        <i class="fa fa-file-excel-o" id="export-excel" onclick="event.stopPropagation();downloadTableAsCSV()" title="Download CSV"></i>
                                        <i class="fa fa-file-text-o" onclick="event.stopPropagation();downloadTableAsText()" title="Download text"></i>
                                        <i class="fa fa-file-pdf-o" onclick="event.stopPropagation();downloadTableAsPDF()" title="Download pdf"></i>
                                        <i class="fa fa-print" onclick="event.stopPropagation();printTable()" title="print"></i>
                                        <i class="fa fa-columns"></i>
                                    </div>
                                    <div class="col-lg-12 mt-20 text-right">
                                       
                                    </div>
                                    <div class="table-responsive table-bordered">
                                        <table>
                                            <thead>
                                            
                                                <tr>
                                                    <th rowspan="3" class="align-middle text-center" style="background-color: #F6F8FA;">ID</th>
                                                    <th rowspan="3" class="align-middle text-center" style="background-color: #F6F8FA;">Students</th>
                                                      
                                                    ${lessonsHTML}
                                                    <th rowspan="3" class="align-middle text-center" style="background-color: #FFAB2A">
                                                        Overall Percentage
                                                    </th>
                                                </tr>
                                             
                                                <tr>
                                                    ${topicsHTML} 
                                                </tr>
                                                <tr>
                                                    ${subtopicHTML}
                                                </tr>
                                            </thead>
                                            <tbody id="result">
                                               ${dataHTML}
                                            </tbody>
                                        </table>
                                    </div>
                                </x-table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
                }

                window.toggleLesson = function(lessonId) {
                    const lessonSection = $(`#${lessonId}`);
                    const hasContent = lessonSection.find('[data-topic-id]').length > 0;
                    if (hasContent) {
                        lessonSection.slideToggle();
                    } else {
                        toastr.error('No topics available to display.');
                    }
                };

            });

            // zip files
            function downloadPDF(subjectId) {
                $.ajax({
                    url: `/subject/download-pdfs/${subjectId}`,
                    method: 'GET',
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
                        alert('An error occurred while downloading the files.');
                    }
                });
            }

            // copy table
            function showToast(message) {
                const toast = document.createElement('div');
                toast.textContent = message;
                toast.style.position = 'fixed';
                toast.style.bottom = '20px';
                toast.style.right = '20px';
                toast.style.backgroundColor = '#4CAF50';
                toast.style.color = 'white';
                toast.style.padding = '10px 20px';
                toast.style.borderRadius = '5px';
                toast.style.zIndex = '1000';
                document.body.appendChild(toast);
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 3000);
            }

            function copyTableData() {
                const table = document.querySelector('table');
                const rows = Array.from(table.rows);
                const formattedContent = rows.map(row =>
                    Array.from(row.cells).map(cell => {
                        return cell.querySelector('input') ? cell.querySelector('input').value : cell.textContent;
                    }).join('\t')
                ).join('\n');
                const tempElement = document.createElement('textarea');
                tempElement.value = formattedContent;
                document.body.appendChild(tempElement);
                tempElement.select();
                document.execCommand('copy');
                document.body.removeChild(tempElement);
                showToast('Table copied successfully!');
            }
            document.querySelector('#copyTableButton').addEventListener('click', copyTableData);

            // table print
            function printTable() {
                const table = document.querySelector('table');
                const newWindow = window.open('', '', 'width=800,height=600');


                newWindow.document.write('<html><head><title>Print Table</title>');
                newWindow.document.write('<style>table { width: 100%; border-collapse: collapse; }');
                newWindow.document.write('th, td { border: 1px solid #000; padding: 8px; text-align: left; }</style>');
                newWindow.document.write('</head><body>');
                newWindow.document.write(table.outerHTML);
                newWindow.document.write('</body></html>');

                newWindow.document.close();
                newWindow.print();
                newWindow.close();
            }

            // download the pdf
            function downloadTableAsPDF() {
                const table = document.querySelector('table');
                let tableData = {
                    headers: [],
                    rows: [],
                    styles: []
                };
                const thead = table.querySelector('thead');
                if (thead) {
                    Array.from(thead.rows).forEach((row) => {
                        const headerRow = [];
                        Array.from(row.cells).forEach((cell) => {
                            headerRow.push({
                                content: cell.innerText.trim(),
                                rowspan: cell.rowSpan || 1,
                                colspan: cell.colSpan || 1,
                                backgroundColor: window.getComputedStyle(cell).backgroundColor,
                                className: cell.className
                            });
                        });
                        tableData.headers.push(headerRow);
                    });
                }

                const tbody = table.querySelector('tbody');
                if (tbody) {
                    Array.from(tbody.rows).forEach((row) => {
                        const rowData = [];
                        Array.from(row.cells).forEach((cell) => {
                            const input = cell.querySelector('input');
                            const value = input ? input.value : cell.innerText.trim();

                            rowData.push({
                                content: value,
                                backgroundColor: window.getComputedStyle(cell).backgroundColor,
                                className: cell.className,
                                isInput: !!input
                            });
                        });
                        tableData.rows.push(rowData);
                    });
                }

                const styles = new Set();
                table.querySelectorAll('[class]').forEach(element => {
                    element.classList.forEach(className => {
                        const style = window.getComputedStyle(element);
                        styles.add({
                            className,
                            backgroundColor: style.backgroundColor,
                            color: style.color,
                            textAlign: style.textAlign
                        });
                    });
                });
                tableData.styles = Array.from(styles);

                $.ajax({
                    url: "{{ route('marktable.pdf') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: "application/json",
                    data: JSON.stringify({
                        tableData: tableData
                    }),
                    success: function(response) {
                        const blob = new Blob([response], {
                            type: 'application/pdf'
                        });
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'mark_table.pdf';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        window.URL.revokeObjectURL(url);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Error generating PDF. Please try again.');
                    },
                    xhrFields: {
                        responseType: 'blob'
                    }
                });
            }

            // download the text File
            function downloadTableAsText() {
                const table = document.querySelector('table');
                let tableData = '';


                const thead = table.querySelector('thead');
                if (thead) {
                    Array.from(thead.rows).forEach((row) => {
                        Array.from(row.cells).forEach((cell) => {
                            tableData += cell.innerText.trim() + '\t';
                        });
                        tableData += '\n';
                    });
                }

                const tbody = table.querySelector('tbody');
                if (tbody) {
                    Array.from(tbody.rows).forEach((row) => {
                        Array.from(row.cells).forEach((cell) => {
                            const input = cell.querySelector('input');
                            const value = input ? input.value : cell.innerText.trim();
                            tableData += value + '\t';
                        });
                        tableData += '\n';
                    });
                }
                $.ajax({
                    url: "{{ route('marktable.text') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: "application/json",
                    data: JSON.stringify({
                        tableData: tableData
                    }),
                    success: function(response) {
                        const blob = new Blob([response], {
                            type: 'text/plain'
                        });
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'mark_table.txt';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        window.URL.revokeObjectURL(url);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Error generating text file. Please try again.');
                    },
                    xhrFields: {
                        responseType: 'blob'
                    }
                });
            }

            // download the CSV File

            function downloadTableAsCSV() {
                const table = document.querySelector('table');
                let csvContent = [];
                const maxCols = calculateMaxColumns(table);

                const thead = table.querySelector('thead');
                if (thead) {
                    const headerRows = Array.from(thead.rows);

                    let headerTracking = Array(headerRows.length).fill().map(() => Array(maxCols).fill(''));


                    headerRows.forEach((row, rowIndex) => {
                        let colIndex = 0;

                        Array.from(row.cells).forEach(cell => {
                            const colspan = parseInt(cell.getAttribute('colspan')) || 1;
                            const rowspan = parseInt(cell.getAttribute('rowspan')) || 1;
                            const cellText = cell.innerText.trim().replace(/\n/g, ' ');


                            while (headerTracking[rowIndex][colIndex] !== '') {
                                colIndex++;
                            }


                            for (let i = 0; i < rowspan; i++) {
                                for (let j = 0; j < colspan; j++) {
                                    if (rowIndex + i < headerRows.length) {
                                        headerTracking[rowIndex + i][colIndex + j] = cellText;
                                    }
                                }
                            }

                            colIndex += colspan;
                        });
                    });


                    headerTracking.forEach(row => {
                        csvContent.push(row.map(cell => `"${cell}"`).join(','));
                    });
                }


                const tbody = table.querySelector('tbody');
                if (tbody) {
                    Array.from(tbody.rows).forEach(row => {
                        const rowData = Array.from(row.cells).map(cell => {
                            const input = cell.querySelector('input');
                            const value = input ? input.value : cell.innerText.trim();
                            return `"${value.replace(/"/g, '""')}"`;
                        });

                        while (rowData.length < maxCols) {
                            rowData.push('""');
                        }

                        csvContent.push(rowData.join(','));
                    });
                }


                const csvString = csvContent.join('\n');


                const blob = new Blob(["\ufeff" + csvString], {
                    type: 'text/csv;charset=utf-8'
                });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'mark_table.csv';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            }


            function calculateMaxColumns(table) {
                let maxCols = 0;
                const rows = Array.from(table.rows);

                rows.forEach(row => {
                    let colCount = 0;
                    Array.from(row.cells).forEach(cell => {
                        const colspan = parseInt(cell.getAttribute('colspan')) || 1;
                        colCount += colspan;
                    });
                    maxCols = Math.max(maxCols, colCount);
                });

                return maxCols;
            }

            function submitTableData(csvString) {
                $.ajax({
                    url: route('marktable.csv'),
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    contentType: "application/json",
                    data: JSON.stringify({
                        tableData: csvString
                    }),
                    success: function(response) {
                        const blob = new Blob([response], {
                            type: 'text/csv'
                        });
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'mark_table.csv';
                        document.body.appendChild(a);
                        a.click();
                        document.body.removeChild(a);
                        window.URL.revokeObjectURL(url);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Error generating CSV. Please try again.');
                    },
                    xhrFields: {
                        responseType: 'blob'
                    }
                });
            }
        </script>

        @else
        @endif
        <!-- Subject Name -->
        <!-- subject name Admin page -->
        @if(isset($assign_subjects) && $assign_subjects->count() > 0)
        @if($user->role_id == 1 ||$user->role_id == 5)
        @foreach($assign_subjects as $assign_subject)
        <div class="section-body" style="background: #fff; box-shadow:0px 0px 8px #ddd; padding:20px; margin:30px 0px 5px; border-radius:8px;"
            onclick="toggleCollapse('table-section-{{$assign_subject->id ?? null}}')">
            <div class="row" style="display: flex; align-items: center;">
                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-xs-12">
                    <div class="left-body d-flex" style="gap:2em; align-items:center;">
                        <div class="imager" style="height: 100px; overflow:hidden; max-width: 20%; min-width: 19.98%;">
                            <img src="{{ $assign_subject->subject->image ?  asset('public/' . $assign_subject->subject->image) : asset('public/backEnd/img/default.png') }}"
                                style="border-radius: 5px; height: 100%; width: 100%;" />
                        </div>
                        <div class="body-content">
                            <div class="top-body-head d-flex" style="gap:1em;">
                                <span style="color: #7C32FF; font-weight:600; text-transform:capitalize; font-size:14px;" class="sp-bodyHead">{{ $assign_subject->subject->subject_code }}</span>
                                <span class="head-link" style="font-weight: 500; color:#112375;">{{ $assign_subject->subject->subject_name }}</span>
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
                                    <span class="ic-link" style="padding-left: 3px;">{{ $assign_subject->subject->duration }} @if($assign_subject->subject->duration_type == 'hours')
                                        @lang('communicate.hours')
                                        @elseif($assign_subject->subject->duration_type == 'weeks')
                                        @lang('communicate.weeks')
                                        @elseif($assign_subject->subject->duration_type == 'days')
                                        @lang('communicate.days')
                                        @endif</span>
                                </div>
                                <div class="sec-ic">
                                    <span class="ic"><i class="ti-star"></i></span>
                                    <span class="ic-link" style="padding-left: 3px;">{{$lesson_count}} @lang('communicate.lessons')</< /span>
                                </div>
                                <div class="sec-ic">
                                    <span class="ic"><i class="ti-harddrives"></i></span>
                                    <span class="ic-link" style="padding-left: 3px;">{{$topicscount}} @lang('communicate.topics')</span>
                                </div>
                                <div class="sec-ic">
                                    <span class="ic"><i class="ti-harddrives"></i></span>
                                    <span class="ic-link" style="padding-left: 3px;">{{$subtopicscount}} @lang('communicate.subtopics')</span>
                                </div>
                                <div class="sec-ic">
                                    <span class="ic"><i class="fa fa-file-zip-o"></i></span>
                                    <span class="ic-link" style="padding-left: 3px;" onclick="downloadPDFs({{ $assign_subject->subject_id }})">
                                        @lang('communicate.Download Marksheet')
                                    </span>
                                </div>

                            </div>
                            <div class="progress-sec" style="margin-top: 10px;">
                                <span class="progress-head" style="color: #47464A;">@lang('communicate.Progress')</span>
                                @isset($progresscount)
                                <div class="d-flex" style="gap: 0.6em;">
                                    <div class="progress" style="margin-top: 8px; height:8px; width:100%;">
                                        <div id="progress-bar" class="progress-bar" role="progressbar"
                                            style="width: {{$progresscount}}%; height: 15px; background: #FFAB2A;"
                                            aria-valuenow="{{$progresscount}}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span id="progress-value" class="progress-value">{{$progresscount}}%</span>
                                </div>
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <div style="text-align: right;">
                        <div class="nav-item submenu dropdown">
                            <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="<i class='fas fa-user-alt'></i> {{$assign_subject->teacher->full_name ?? null}}<br>{{$assign_subject->marks_notes}}" data-bs-placement="top">
                                @if ($assign_subject->is_marks_locked == 1 || $assign_subject->is_marks_locked == 5)
                                <button class="primary-btn small fix-gr-bg dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="event.stopPropagation();">
                                    @lang('communicate.Locked')
                                </button>
                                @elseif ($assign_subject->is_marks_locked == 2)
                                <button class="btn btn-success small fix-gr-bg dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="event.stopPropagation();">
                                    @lang('communicate.Un-locked')
                                </button>
                                @elseif ($assign_subject->is_marks_locked == 4)
                                <button class="btn btn-danger small fix-gr-bg dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="event.stopPropagation();">
                                    @lang('communicate.Unlock Request')
                                </button>
                                @endif

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" onclick="event.stopPropagation();">
                                    @if ($assign_subject->is_marks_locked == 2)
                                    <a class="dropdown-item" href="#" style="color: #47464A" onclick="func1(event, 'lock')">@lang('communicate.lock')</a>
                                    <a class="dropdown-item" href="#" style="color: #47464A" onclick="func1(event, 'unlock')">@lang('communicate.Unlock')</a>
                                    @elseif ($assign_subject->is_marks_locked == 4)
                                    <a class="dropdown-item" href="#" style="color: #47464A" onclick="func1(event, 'unlock')">@lang('communicate.Unlock')</a>
                                    <a class="dropdown-item" href="#" style="color: #47464A" onclick="func1(event, 'reject')">@lang('communicate.Reject')</a>
                                    @else
                                    <a class="dropdown-item" href="#" style="color: #47464A" onclick="func1(event, 'lock')">@lang('communicate.lock')</a>
                                    <a class="dropdown-item" href="#" style="color: #47464A" onclick="func1(event, 'unlock')">@lang('communicate.Unlock')</a>
                                    @endif
                                </div>
                            </span>

                            <script>
                                function func1(event, action) {
                                    event.preventDefault();
                                    const subjectId = '{{ $assign_subject->id }}';
                                    const url = '/assign-subject/' + subjectId + '/' + action;
                                    $.ajax({
                                        url: url,
                                        type: 'PATCH',
                                        contentType: 'application/json',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        success: function(data) {
                                            const button = document.getElementById('dropdownMenuButton');
                                            button.innerText = {
                                                'lock': 'Locked',
                                                'unlock': 'Un-locked',
                                                'reject': 'Unlock Request'
                                            } [action] || button.innerText;

                                            toastr.success(data.message);
                                            location.reload();

                                            const dropdownMenu = event.target.closest('.dropdown-menu');
                                            if (dropdownMenu) {
                                                const dropdownToggle = dropdownMenu.previousElementSibling;
                                                const bsDropdown = new bootstrap.Dropdown(dropdownToggle);
                                                bsDropdown.hide();
                                            }
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('There was a problem with your AJAX operation:', error);
                                            toastr.error('Something went wrong. Please try again.');
                                        }
                                    });
                                }
                            </script>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endforeach
        @else

        @endif
        <!-- subject name Teacher page -->
        @elseif($user->role_id == 4)
        @if(isset($assign_teacher_subjects) && $assign_teacher_subjects->count() > 0)
        @foreach($assign_teacher_subjects as $assign_subject)
        <div class="section-body" style="background: #fff; box-shadow: 0px 0px 8px #ddd; padding: 20px; margin: 30px 0px 5px; border-radius: 8px;" onclick="toggleCollapse('table-section-{{$assign_subject->id ?? null}}')">
            <div class="row" style="display: flex; align-items: center;">
                <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-xs-12">
                    <div class="left-body d-flex" style="gap: 2em; align-items: center;">
                        <div class="imager" style="height: 100px; overflow: hidden; max-width: 20%; min-width: 19.98%;">
                            <img src="{{ $assign_subject->subject->image ? asset('public/' . $assign_subject->subject->image) : asset('public/backEnd/img/default.png') }}" style="border-radius: 5px; height: 100%; width: 100%;" />
                        </div>
                        <div class="body-content">
                            <div class="top-body-head d-flex" style="gap: 1em;">
                                <span style="color: #7C32FF; font-weight: 600; text-transform: capitalize; font-size: 14px;" class="sp-bodyHead">{{ $assign_subject->subject->subject_code }}</span>
                                <span class="head-link" style="font-weight: 500; color: #112375;">{{ $assign_subject->subject->subject_name }}</span>
                                @if (Auth::user() && Auth::user()->is_administrator)
                                @if ($assign_subject->is_marks_locked == 1 || $assign_subject->is_marks_locked == 4 ||$assign_subject->is_marks_locked == 5)
                                <div class="svg-inner" style="position: relative;">
                                    <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="27" height="27" rx="5" fill="#7C32FF" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M17.1113 11.5371H16.7275V9.20561C16.7275 7.51192 15.3499 6.13416 13.6566 6.13416C11.9629 6.13416 10.5852 7.51192 10.5852 9.20561V11.5371H10.2014C9.54086 11.5371 9.00537 12.0724 9.00537 12.733V18.281C9.00537 18.9415 9.54086 19.477 10.2014 19.477H17.1113C17.7718 19.477 18.3075 18.9415 18.3075 18.281V12.733C18.3075 12.0724 17.7718 11.5371 17.1113 11.5371ZM11.6597 9.20561C11.6597 8.10454 12.5555 7.20872 13.6566 7.20872C14.7573 7.20872 15.653 8.10454 15.653 9.20561V11.5371H11.6597V9.20561ZM14.2684 16.9398V15.4465C14.5548 15.2506 14.7428 14.9217 14.7428 14.5489C14.7428 13.9487 14.2564 13.4621 13.6564 13.4621C13.0565 13.4621 12.57 13.9485 12.57 14.5489C12.57 14.9217 12.7581 15.2509 13.0446 15.4465V16.9398C13.0446 17.2777 13.3185 17.5515 13.6564 17.5515C13.9946 17.5515 14.2684 17.2777 14.2684 16.9398Z" fill="white" />
                                    </svg>
                                </div>
                                @else
                                <div class="svg-inner" style="position: relative;">
                                    <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect width="27" height="27" rx="5" fill="#009580" />
                                    </svg>
                                    <svg style="position: absolute; left:10px; top:7.5px;" width="9" height="12" viewBox="0 0 9 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.11439 4.7418L1.64516 0.312997C1.3464 0.108323 1.04538 0 0.79517 0C0.311439 0 0.012207 0.388229 0.012207 1.03807V10.61C0.012207 11.2591 0.311062 11.6466 0.793662 11.6466C1.04425 11.6466 1.34046 11.5382 1.63988 11.3329L8.11213 6.90422C8.52836 6.61894 8.75886 6.23504 8.75886 5.82277C8.75896 5.41079 8.53109 5.02699 8.11439 4.7418Z" fill="white" />
                                    </svg>
                                </div>
                                @endif
                                @endif
                            </div>
                            <div class="ic-sec d-flex" style="gap: 2em; margin-top: 5px;">
                                <div class="sec-ic">
                                    <span class="ic"><i class="ti-alarm-clock"></i></span>
                                    <span class="ic-link" style="padding-left: 3px;">{{ $assign_subject->subject->duration }} @if($assign_subject->subject->duration_type == 'hours')
                                        @lang('communicate.hours')
                                        @elseif($assign_subject->subject->duration_type == 'weeks')
                                        @lang('communicate.weeks')
                                        @elseif($assign_subject->subject->duration_type == 'days')
                                        @lang('communicate.days')
                                        @endif</span>
                                </div>
                                <div class="sec-ic">
                                    <span class="ic"><i class="ti-star"></i></span>
                                    <span class="ic-link" style="padding-left: 3px;">{{$lesson_count}} @lang('communicate.lessons')</span>
                                </div>
                                <div class="sec-ic">
                                    <span class="ic"><i class="ti-harddrives"></i></span>
                                    <span class="ic-link" style="padding-left: 3px;">{{$topicscount}} @lang('communicate.topics')</span>
                                </div>
                                <div class="sec-ic">
                                    <span class="ic"><i class="ti-harddrives"></i></span>
                                    <span class="ic-link" style="padding-left: 3px;">{{$subtopicscount}} @lang('communicate.subtopics')</span>
                                </div>
                                <div class="sec-ic">
                                    <span class="ic"><i class="fa fa-file-zip-o"></i></span>
                                    <span class="ic-link" style="padding-left: 3px;" onclick="downloadPDFs({{ $assign_subject->subject_id }})">
                                        @lang('communicate.Download Marksheet')
                                    </span>
                                </div>
                            </div>
                            <div class="progress-sec" style="margin-top: 10px;">
                                <span class="progress-head" style="color: #47464A;">@lang('communicate.Progress')</span>
                                <div class="d-flex" style="gap: 0.6em;">
                                    <div class="progress" style="margin-top: 8px; height:8px; width:100%;">
                                        <div id="progress-bar" class="progress-bar" role="progressbar"
                                            style="width: {{$progresscount}}%; height: 15px; background: #FFAB2A;"
                                            aria-valuenow="{{$progresscount}}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                    <span id="progress-value" class="progress-value">{{$progresscount}}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                    <div style="text-align: right;">
                        <li class="nav-item submenu dropdown">

                            @if($assign_subject->is_marks_locked == 1 || $assign_subject->is_marks_locked == 5)
                            <button type="button" class="primary-btn-small-input primary-btn small fix-gr-bg unlock-btn" onclick="openModal('unlock', '{{ $assign_subject->id }}')"> @lang('communicate.Send Unlock Request')</button>
                            @elseif($assign_subject->is_marks_locked == 4 )
                            <button type="button" class="primary-btn-small-input light-btn small fix-gr-bg lock-btn" disabled> @lang('communicate.Unlock Request Sent')</button>
                            @elseif($assign_subject->is_marks_locked == 2)
                            <button type="button" class="primary-btn-small-input light-btn small fix-gr-bg lock-btn" disabled> @lang('communicate.Mark-Unlocked')</button>
                            @endif
                        </li>
                    </div>
                </div>

                <!-- Modal for lock/unlock request -->
                <div class="modal fade" id="unlockRequestModal" tabindex="-1" role="dialog" aria-labelledby="unlockRequestModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="unlockRequestModalLabel">Marks - Request Notes</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="lockUnlockForm" onsubmit="submitRequest(event)">
                                @csrf
                                <div class="modal-body">
                                    <label for="note" class="primary_input_label">Please provide the request note below, clearly specifying the purpose.</label>
                                    <div class="form-group">
                                        <label class="primary_input_label" for="note">Note <span class="text-danger">*</span></label>
                                        <textarea class="primary_input_field form-control" name="notes" id="note" rows="5" placeholder="Enter your note here..." required></textarea>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="primary-btn-small-input primary-btn small fix-gr-bg">Send Request</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let currentAction = '';
            let subjectId = '';

            function openModal(action, id) {
                currentAction = action;
                subjectId = id;
                $('#unlockRequestModal').modal('show');
            }

            function submitRequest(event) {
                event.preventDefault();
                const action = currentAction === 'lock' ? 'lock request' : 'unlock request';
                const url = '/lock-request/' + subjectId + '/' + action;

                const formData = {
                    notes: $('#note').val()
                };

                $.ajax({
                    url: url,
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.success) {
                            toastr.success(data.message);
                            location.reload();
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        toastr.error('Something went wrong. Please try again.');
                    }
                });
            }
        </script>

        @endforeach
        @else
        @endif

        <!-- subject name Student page -->
        @elseif($user->role_id == 2)

        @else
        @endif
        <!-- End Subject Name-->

        <!-- Admin table -->
        @if($user->role_id == 1 ||$user->role_id == 5)
        @if(isset($lessons) && $lessons->count() > 0)
        @isset($assign_subject)
        <!-- <div id="loading-indicator" style="display: none;">
            <p>Downloading files, please wait...</p>
        </div> -->
        <form method="post" id='form'>
            <input type="hidden" name="assign_subject_id" id="assign_subject_id" value="{{ $assign_subject->id ?? null }}">

            <div class="row mt-40 full_wide_table" id="table-section-{{ $assign_subject->id ?? null}}" style="display:none;">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-15">Add Marks</h3>
                                    <h3 class="mb-15" style="color: gray;font-size:small">Add mark for each activities here</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <div class="icon_documents">
                                        <i class="fa fa-files-o" id="copyTableButton" title="copy"></i>
                                        <i class="fa fa-file-excel-o" id="export-excel" onclick="downloadTableAsCSV()" title="Download CSV"></i>
                                        <i class="fa fa-file-text-o" onclick="downloadTableAsText()" title="Download text"></i>
                                        <i class="fa fa-file-pdf-o" onclick="downloadTableAsPDF()" title="Download pdf"></i>
                                        <i class="fa fa-print" onclick="printTable()" title="print"></i>
                                        <i class="fa fa-columns"></i>
                                    </div>
                                    <div class="col-lg-12 mt-20 text-right">
                                        <button type="submit" class="primary-btn small fix-gr-bg" id="search_promote">
                                            Save
                                        </button>
                                    </div>
                                    <div class="table-responsive table-bordered">
                                        <table>
                                            <thead class="table-bordered">
                                                <tr>
                                                    <th rowspan="3" class="align-middle text-center" style="background-color: #F6F8FA;">ID</th>
                                                    <th rowspan="3" class="align-middle text-center" style="background-color: #F6F8FA;">Name</th>
                                                    @foreach($lessons as $lesson)
                                                    @if($lesson->id != 2)
                                                    @php
                                                    // Filter topics to only include those with is_mark_enabled = 1
                                                    $enabledTopics = $lesson->topics->filter(function($topic) {
                                                    return $topic->is_mark_enabled == 1;
                                                    });

                                                    // Calculate colspan for enabled lesson topics including subtopics and Grand Total & Grand Percentage
                                                    $colspan = $enabledTopics->reduce(function($carry, $topic) {
                                                    return $carry + (count($topic->subtopics) > 0 ? count($topic->subtopics) + 3 : 1);
                                                    }, 0) + 2; // +2 for Grand Total and Grand Percentage
                                                    @endphp

                                                    @if($enabledTopics->count() > 0)
                                                    <th colspan="{{ $colspan }}" class="text-center" style="background-color: white;" name='lesson_title'>
                                                        {{ $lesson->lesson_title ?? 'No Lesson Title' }}
                                                    </th>
                                                    @endif
                                                    @endif
                                                    @endforeach

                                                    <th rowspan="3" class="align-middle text-center" style="background-color: #FFAB2A" data-subject-id="{{ $assign_subject->subject_id }}">
                                                        Overall Percentage<br>{{ $OverallPercentage }} {{ $topic->unit ?? '' }}
                                                    </th>
                                                </tr>


                                                <tr style="background-color:#F6F8FA;">
                                                    @if($selectedFields)
                                                    @foreach($lessons as $lesson)
                                                    @if($lesson->id != 2 && $lesson->topics->count() > 0)
                                                    @php
                                                    $sumMarks = 0;
                                                    // Get only enabled topics for easier processing
                                                    $enabledTopics = $lesson->topics->filter(fn($topic) => $topic->is_mark_enabled == 1);
                                                    @endphp

                                                    @foreach($enabledTopics as $topic)
                                                    @php
                                                    $topicColspan = count($topic->subtopics) > 0 ? count($topic->subtopics) + 3 : 2;
                                                    $lessonData = collect($max_marks)->firstWhere('id', $topic->id);
                                                    $Marks = $lessonData ? $lessonData['total_max_marks'] : 0;

                                                    $MarksData = $cgpa->firstWhere('lesson_id', $lesson->id);
                                                    $cgpamark = $MarksData ? $MarksData->cgpa_mark : 0;

                                                    $sumMarks += $Marks;
                                                    @endphp

                                                    @if($topic->subtopics->count() > 0)
                                                    <th class="text-center" colspan="{{ $topicColspan }}" id="header_{{ $topic->id }}" data-cgpa="{{ $topic->cgpa ?? 1 }}" data-max_marks="{{ $topic->max_marks }}" data-avg_marks="{{ $topic->avg_marks }}" data-topic-id="{{ $topic->id }}">
                                                        {{ $topic->topic_title }} - {{ $topic->cgpa ?? '' }} {{ $topic->unit ?? '' }}<br style="text-align: center;">{{ $topic->max_marks ?? '' }}<br>
                                                    </th>
                                                    @else
                                                    <th class="text-center" rowspan="2" id="header_{{ $topic->id }}" data-cgpa="{{ $topic->cgpa ?? 1 }}" data-max_marks="{{ $topic->max_marks }}" data-topic-id="{{ $topic->id }}" data-avg_marks="{{ $topic->avg_marks }}">
                                                        {{ $topic->topic_title }} - {{ $topic->cgpa ?? '' }} {{ $topic->unit ?? '' }}<br style="text-align: center;">{{ $topic->max_marks ?? '' }}<br>
                                                    </th>
                                                    @endif
                                                    @endforeach

                                                    @php
                                                    $lessonData = collect($lessonidcall)->firstWhere('lesson_id', $lesson->id);
                                                    $totalMarks = $lessonData ? $lessonData['total_max_marks'] : 0;
                                                    @endphp

                                                    @if($enabledTopics->isNotEmpty())
                                                    <th rowspan="2" class="text-center" style="background-color: #00C875;" id="grandTotal_{{ $lesson->id }}">
                                                        Grand Total<br>
                                                        <span id="totalMarks_{{ $lesson->id }}">{{ $totalMarks + $sumMarks }}</span>
                                                    </th>
                                                    <th rowspan="2" class="text-center" style="background-color: #5CA3FF;" id="grandPercentage_{{ $lesson->id }}">
                                                        Grand Percentage<br>{{ $cgpamark }} {{ $topic->unit ?? '' }}
                                                    </th>
                                                    @endif
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                </tr>

                                                <tr>
                                                    @foreach($lessons as $lesson)
                                                    @if($lesson->id != 2)
                                                    @if($lesson->topics->count() > 0)
                                                    @foreach($lesson->topics as $topic)
                                                    @if($topic->subtopics->count() > 0)
                                                    @php $totalMarks = 0; @endphp
                                                    @foreach($topic->subtopics as $subtopic)
                                                    @php $totalMarks += $subtopic->max_marks; @endphp
                                                    @if($lesson->topics->count() > 0)
                                                    <th class="text-center" data-max_marks="{{ $subtopic->max_marks }}" data-avg_marks="{{ $subtopic->avg_marks }}" data-subtopic-id="{{ $subtopic->id }}"
                                                        id="subtopic_{{ $subtopic->id }}">
                                                        {{ $subtopic->sub_topic_title }}<br>{{ $subtopic->max_marks }}
                                                    </th>
                                                    @endif
                                                    @endforeach
                                                    <!-- Total, Average, and Percentage for the Topic -->
                                                    <th class="text-center" style="background-color: #FFDD00;" id="header_{{ $topic->id }}" data-totalmarks="{{ $totalMarks }}">
                                                        Total <br>{{ $totalMarks }}
                                                    </th>
                                                    <th class="text-center" style="background-color: #FFDD00;">
                                                        Average <br>{{ number_format($totalMarks / $topic->subtopics->count(), 2) }}
                                                    </th>
                                                    <th class="text-center" style="background-color: #FFAB2A;">
                                                        Percentage <br>{{ $topic->cgpa ?? '' }} {{ $topic->unit ?? '' }}
                                                    </th>
                                                    @else
                                                    <!-- Default empty columns when no subtopics exist -->
                                                    <!-- <th class="text-center" colspan="3" style="background-color: #F6F8FA;"></th> -->
                                                    @endif
                                                    @endforeach
                                                    @else
                                                    <!-- Default empty columns when no topics exist -->

                                                    @endif
                                                    @endif
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody style="border-right: none;">
                                                @foreach($students as $student)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center" data-student-id="{{ $student->id }}">{{ $student->full_name }}
                                                        <br>
                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white download-pdf" aria-hidden="true" data-student-id="{{ $student->id }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" style="color: #3498db;">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4" />
                                                        </svg>
                                                    </td>

                                                    @foreach($lessons as $lesson)
                                                    @if($lesson->topics->contains('is_mark_enabled', 1))
                                                    @if($lesson->id != 2)
                                                    @foreach($lesson->topics as $topic)
                                                    @if($topic->is_mark_enabled == 1) <!-- Check if the topic is enabled -->
                                                    @if($topic->subtopics->count() > 0)
                                                    @foreach($topic->subtopics as $subtopic)
                                                    <!-- Check if the subtopic is enabled -->
                                                    <td class="single-line text-center">
                                                        @if($studentmarkdata->isEmpty())
                                                        <input type="text" class="primary_input_field form-control consistent-input amount"
                                                            data-student-id="{{ $student->id }}"
                                                            data-topic-id="{{ $topic->id }}"
                                                            data-subtopic-id="{{ $subtopic->id }}"
                                                            data-lesson-id="{{ $lesson->id }}"
                                                            data-subject-id="{{ $assign_subject->subject_id }}"
                                                            name="marks" value="">
                                                        @else
                                                        @php
                                                        $foundMarkValue = null;
                                                        $isBelowThreshold = false;

                                                        foreach ($studentmarkdata as $mark) {
                                                        // Check if the current mark matches the student and subtopic
                                                        if ($mark->student_id == $student->id &&
                                                        $mark->topic_id == $topic->id &&
                                                        $mark->lesson_id == $lesson->id &&
                                                        $mark->sub_topic_id == $subtopic->id) {

                                                        $foundMarkValue = $mark->mark_value;

                                                        // Check if the mark is below the average threshold
                                                        if ($foundMarkValue < $subtopicaverageMark) {
                                                            $isBelowThreshold=true;
                                                            }
                                                            break; // Break out of the loop once found
                                                            }
                                                            }
                                                            @endphp

                                                            <input type="text" class="primary_input_field form-control consistent-input amount @if($isBelowThreshold) border-danger text-danger @endif"
                                                            data-student-id="{{ $student->id }}"
                                                            data-topic-id="{{ $topic->id }}"
                                                            data-subtopic-id="{{ $subtopic->id }}"
                                                            data-lesson-id="{{ $lesson->id }}"
                                                            data-subject-id="{{ $assign_subject->subject_id }}"
                                                            name="marks" value="{{ $foundMarkValue ?? '' }}">
                                                            @endif
                                                    </td>


                                                    @endforeach

                                                    <!-- Total, Average, and Percentage for the Topic -->
                                                    <td class="text-center totalSumDisplay"
                                                        data-student-id="{{ $student->id }}"
                                                        data-topic-id="{{ $topic->id }}"
                                                        data-lesson-id="{{ $lesson->id }}"
                                                        id="totalSumDisplay_{{ $student->id }}_{{ $topic->id }}">

                                                        @if($studentmarkdata->isEmpty())
                                                        0
                                                        @else
                                                        @php
                                                        $studentmark = $studentmarkdata->firstWhere(function ($mark) use ($student, $topic, $lesson) {
                                                        return $mark->student_id == $student->id &&
                                                        $mark->topic_id == $topic->id &&
                                                        $mark->lesson_id == $lesson->id;
                                                        });
                                                        @endphp

                                                        {{ $studentmark ? $studentmark->total : 0 }}
                                                        @endif
                                                    </td>

                                                    <td class="text-center" id="averageMarkDisplay_{{ $student->id }}_{{ $topic->id }}">
                                                        @if($studentmarkdata->isEmpty())
                                                        0
                                                        @else
                                                        @php
                                                        $studentmark = $studentmarkdata->firstWhere(function ($mark) use ($student, $topic, $lesson) {
                                                        return $mark->student_id == $student->id &&
                                                        $mark->topic_id == $topic->id &&
                                                        $mark->lesson_id == $lesson->id;
                                                        });
                                                        @endphp

                                                        {{ $studentmark ? $studentmark->average ?? 0 : 0 }}
                                                        @endif
                                                    </td>

                                                    <td class="text-center" id="percentageMarkDisplay_{{ $student->id }}_{{ $topic->id }}">
                                                        @if($studentmarkdata->isEmpty())
                                                        0
                                                        @else
                                                        @php
                                                        $studentmark = $studentmarkdata->firstWhere(function ($mark) use ($student, $topic, $lesson) {
                                                        return $mark->student_id == $student->id &&
                                                        $mark->topic_id == $topic->id &&
                                                        $mark->lesson_id == $lesson->id;
                                                        });
                                                        @endphp

                                                        {{ $studentmark ? $studentmark->percentage ?? 0 : 0 }}
                                                        @endif
                                                    </td>
                                                    @else
                                                    <!-- Default empty columns for topics without subtopics -->
                                                    <td class="single-line text-center">
                                                        @if($studentmarkdata->isEmpty())
                                                        <input type="text" class="primary_input_field form-control consistent-input amount2"
                                                            data-student-id="{{ $student->id }}"
                                                            data-topic-id="{{ $topic->id }}"
                                                            data-lesson-id="{{ $lesson->id }}"
                                                            data-subject-id="{{ $assign_subject->subject_id }}"
                                                            name="marks" value="">
                                                        @else
                                                        @php
                                                        $foundMarkValue = null;
                                                        $isBelowThreshold = false;

                                                        foreach ($studentmarkdata as $mark) {
                                                        if ($mark->student_id == $student->id &&
                                                        $mark->topic_id == $topic->id &&
                                                        $mark->lesson_id == $lesson->id) {
                                                        $foundMarkValue = $mark->mark_value;
                                                        // Check if the found mark is below the average mark
                                                        if ($foundMarkValue < $averageMark) {
                                                            $isBelowThreshold=true;
                                                            }
                                                            break;
                                                            }
                                                            }
                                                            @endphp

                                                            <input type="text" class="primary_input_field form-control consistent-input amount2 @if($isBelowThreshold) border-danger text-danger @endif"
                                                            data-student-id="{{ $student->id }}"
                                                            data-topic-id="{{ $topic->id }}"
                                                            data-lesson-id="{{ $lesson->id }}"
                                                            data-subject-id="{{ $assign_subject->subject_id }}"
                                                            name="marks" value="{{ $foundMarkValue ?? '' }}">
                                                            @endif
                                                    </td>

                                                    @endif
                                                    @endif
                                                    @endforeach

                                                    <!-- Grand Total for the lesson -->
                                                    @if($lesson->topics->count() > 0)
                                                    <td id="grandtotal_lesson_{{ $lesson->id }}_{{ $student->id }}" style="text-align: center;">
                                                        @if($studentmarkdata->isEmpty())
                                                        <!-- If there are no records, display 0 -->
                                                        0
                                                        @else
                                                        @php
                                                        $studentmark = $studentmarkdata->firstWhere(function ($mark) use ($student, $topic, $lesson) {
                                                        return $mark->student_id == $student->id &&

                                                        $mark->lesson_id == $lesson->id;
                                                        });
                                                        @endphp

                                                        @if($studentmark)
                                                        <!-- If a matching record is found, display the total -->
                                                        {{ $studentmark->grand_total ?? 0 }}
                                                        @else
                                                        <!-- If no matching record is found, display 0 -->
                                                        0
                                                        @endif
                                                        @endif

                                                    </td>
                                                    @endif


                                                    <!-- Grand Total for Student, Topic, and Lesson -->
                                                    @if($lesson->topics->count() > 0)
                                                    <td id="grandtotal_{{ $lesson->id }}_{{ $student->id }}" style="text-align: center;">
                                                        @if($studentmarkdata->isEmpty())
                                                        <!-- If there are no records, display 0 -->
                                                        0
                                                        @else
                                                        @php
                                                        $studentmark = $studentmarkdata->firstWhere(function ($mark) use ($student, $topic, $lesson) {
                                                        return $mark->student_id == $student->id &&

                                                        $mark->lesson_id == $lesson->id;
                                                        });
                                                        @endphp

                                                        @if($studentmark)
                                                        <!-- If a matching record is found, display the total -->
                                                        {{ $studentmark->grand_percentage ?? 0 }}
                                                        @else
                                                        <!-- If no matching record is found, display 0 -->
                                                        0
                                                        @endif
                                                        @endif

                                                    </td>
                                                    @endif
                                                    @endif
                                                    @endif
                                                    @endforeach

                                                    <td id="overall_{{ $student->id }}_{{$assign_subject->subject_id}}" style="text-align: center;" data-subject-id="{{ $assign_subject->subject_id }}">
                                                        @if($studentmarkdata->isEmpty())
                                                        <!-- If there are no records, display 0 -->
                                                        0
                                                        @else
                                                        @php
                                                       
                                                        $studentmark = $studentmarkdata->first(function ($mark) use ($student, $assign_subject) {
                                                        return $mark->student_id == $student->id && $mark->subject_id == $assign_subject->subject_id;
                                                        });
                                                        @endphp

                                                        @if($studentmark)
                                                        <!-- If a matching record is found, display the total -->
                                                        {{ $studentmark->overall_percpercentage ?? 0 }}
                                                        @else
                                                        <!-- If no matching record is found, display 0 -->
                                                        0
                                                        @endif
                                                        @endif
                                                    </td>

                                                    <input type="hidden" id="mark_value_{{ $student->id }}">

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </x-table>
                            </div>
                        </div>
                        <div class="col-lg-12 buttom-text-right">
                            <button type="submit" class="primary-btn small fix-gr-bg" id="search_promote">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @endisset
        @else
        @endif

        <!-- staff Table-->

        @elseif($user->role_id == 4)
        @if(isset($lessons) && $lessons->count() > 0)
        @if($isLocked)
        <form method="post" id='form'>
            <input type="hidden" name="assign_subject_id" id="assign_subject_id" value="{{ $assign_subject->id ?? null }}">

            <div class="row mt-40 full_wide_table" id="table-section-{{ $assign_subject->id ?? null}}" style="display:none;">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-15">Add Marks</h3>
                                    <h3 class="mb-15" style="color: gray;font-size:small">Add mark for each activities here</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <div class="icon_documents">
                                        <i class="fa fa-files-o" id="copyTableButton" title="copy"></i>
                                        <i class="fa fa-file-excel-o" id="export-excel" onclick="downloadTableAsCSV()" title="Download CSV"></i>
                                        <i class="fa fa-file-text-o" onclick="downloadTableAsText()" title="Download text"></i>
                                        <i class="fa fa-file-pdf-o" onclick="downloadTableAsPDF()" title="Download pdf"></i>
                                        <i class="fa fa-print" onclick="printTable()" title="print"></i>
                                        <i class="fa fa-columns"></i>
                                    </div>
                                    <div class="col-lg-12 mt-20 text-right">
                                        <button type="submit" class="primary-btn small fix-gr-bg" id="search_promote">
                                            Save
                                        </button>
                                    </div>
                                    <div class="table-responsive table-bordered">
                                        <table>
                                            <thead class="table-bordered">
                                                <tr>
                                                    <th rowspan="3" class="align-middle text-center" style="background-color: #F6F8FA;">ID</th>
                                                    <th rowspan="3" class="align-middle text-center" style="background-color: #F6F8FA;">Name</th>
                                                    @foreach($lessons as $lesson)
                                                    @if($lesson->id != 2)
                                                    @php
                                                    // Filter topics to only include those with is_mark_enabled = 1
                                                    $enabledTopics = $lesson->topics->filter(function($topic) {
                                                    return $topic->is_mark_enabled == 1;
                                                    });

                                                    // Calculate colspan for enabled lesson topics including subtopics and Grand Total & Grand Percentage
                                                    $colspan = $enabledTopics->reduce(function($carry, $topic) {
                                                    return $carry + (count($topic->subtopics) > 0 ? count($topic->subtopics) + 3 : 1);
                                                    }, 0) + 2; // +2 for Grand Total and Grand Percentage
                                                    @endphp

                                                    @if($enabledTopics->count() > 0)
                                                    <th colspan="{{ $colspan }}" class="text-center" style="background-color: white;" name='lesson_title'>
                                                        {{ $lesson->lesson_title ?? 'No Lesson Title' }}
                                                    </th>
                                                    @endif
                                                    @endif
                                                    @endforeach

                                                    <th rowspan="3" class="align-middle text-center" style="background-color: #FFAB2A" data-subject-id="{{ $assign_subject->subject_id }}">
                                                        Overall Percentage<br>{{ $OverallPercentage }} {{ $topic->unit ?? '' }}
                                                    </th>
                                                </tr>


                                                <tr style="background-color:#F6F8FA;">
                                                    @if($selectedFields)
                                                    @foreach($lessons as $lesson)
                                                    @if($lesson->id != 2 && $lesson->topics->count() > 0)
                                                    @php
                                                    $sumMarks = 0;
                                                    // Get only enabled topics for easier processing
                                                    $enabledTopics = $lesson->topics->filter(fn($topic) => $topic->is_mark_enabled == 1);
                                                    @endphp

                                                    @foreach($enabledTopics as $topic)
                                                    @php
                                                    $topicColspan = count($topic->subtopics) > 0 ? count($topic->subtopics) + 3 : 2;
                                                    $lessonData = collect($max_marks)->firstWhere('id', $topic->id);
                                                    $Marks = $lessonData ? $lessonData['total_max_marks'] : 0;

                                                    $MarksData = $cgpa->firstWhere('lesson_id', $lesson->id);
                                                    $cgpamark = $MarksData ? $MarksData->cgpa_mark : 0;

                                                    $sumMarks += $Marks;
                                                    @endphp

                                                    @if($topic->subtopics->count() > 0)
                                                    <th class="text-center" colspan="{{ $topicColspan }}" id="header_{{ $topic->id }}" data-cgpa="{{ $topic->cgpa ?? 1 }}" data-max_marks="{{ $topic->max_marks }}" data-avg_marks="{{ $topic->avg_marks }}" data-topic-id="{{ $topic->id }}">
                                                        {{ $topic->topic_title }} - {{ $topic->cgpa ?? '' }} {{ $topic->unit ?? '' }}<br style="text-align: center;">{{ $topic->max_marks ?? '' }}<br>
                                                    </th>
                                                    @else
                                                    <th class="text-center" rowspan="2" id="header_{{ $topic->id }}" data-cgpa="{{ $topic->cgpa ?? 1 }}" data-max_marks="{{ $topic->max_marks }}" data-topic-id="{{ $topic->id }}" data-avg_marks="{{ $topic->avg_marks }}">
                                                        {{ $topic->topic_title }} - {{ $topic->cgpa ?? '' }} {{ $topic->unit ?? '' }}<br style="text-align: center;">{{ $topic->max_marks ?? '' }}<br>
                                                    </th>
                                                    @endif
                                                    @endforeach

                                                    @php
                                                    $lessonData = collect($lessonidcall)->firstWhere('lesson_id', $lesson->id);
                                                    $totalMarks = $lessonData ? $lessonData['total_max_marks'] : 0;
                                                    @endphp

                                                    @if($enabledTopics->isNotEmpty())
                                                    <th rowspan="2" class="text-center" style="background-color: #00C875;" id="grandTotal_{{ $lesson->id }}">
                                                        Grand Total<br>
                                                        <span id="totalMarks_{{ $lesson->id }}">{{ $totalMarks + $sumMarks }}</span>
                                                    </th>
                                                    <th rowspan="2" class="text-center" style="background-color: #5CA3FF;" id="grandPercentage_{{ $lesson->id }}">
                                                        Grand Percentage<br>{{ $cgpamark }} {{ $topic->unit ?? '' }}
                                                    </th>
                                                    @endif
                                                    @endif
                                                    @endforeach
                                                    @endif
                                                </tr>

                                                <tr>
                                                    @foreach($lessons as $lesson)
                                                    @if($lesson->id != 2)
                                                    @if($lesson->topics->count() > 0)
                                                    @foreach($lesson->topics as $topic)
                                                    @if($topic->subtopics->count() > 0)
                                                    @php $totalMarks = 0; @endphp
                                                    @foreach($topic->subtopics as $subtopic)
                                                    @php $totalMarks += $subtopic->max_marks; @endphp
                                                    @if($lesson->topics->count() > 0)
                                                    <th class="text-center" data-max_marks="{{ $subtopic->max_marks }}" data-avg_marks="{{ $subtopic->avg_marks }}" data-subtopic-id="{{ $subtopic->id }}"
                                                        id="subtopic_{{ $subtopic->id }}">
                                                        {{ $subtopic->sub_topic_title }}<br>{{ $subtopic->max_marks }}
                                                    </th>
                                                    @endif
                                                    @endforeach
                                                    <!-- Total, Average, and Percentage for the Topic -->
                                                    <th class="text-center" style="background-color: #FFDD00;" id="header_{{ $topic->id }}" data-totalmarks="{{ $totalMarks }}">
                                                        Total <br>{{ $totalMarks }}
                                                    </th>
                                                    <th class="text-center" style="background-color: #FFDD00;">
                                                        Average <br>{{ number_format($totalMarks / $topic->subtopics->count(), 2) }}
                                                    </th>
                                                    <th class="text-center" style="background-color: #FFAB2A;">
                                                        Percentage <br>{{ $topic->cgpa ?? '' }} {{ $topic->unit ?? '' }}
                                                    </th>
                                                    @else
                                                    <!-- Default empty columns when no subtopics exist -->
                                                    <!-- <th class="text-center" colspan="3" style="background-color: #F6F8FA;"></th> -->
                                                    @endif
                                                    @endforeach
                                                    @else
                                                    <!-- Default empty columns when no topics exist -->

                                                    @endif
                                                    @endif
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody style="border-right: none;">
                                                @foreach($students as $student)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center" data-student-id="{{ $student->id }}">{{ $student->full_name }}
                                                        <br>
                                                        <svg class="w-6 h-6 text-gray-800 dark:text-white download-pdf" aria-hidden="true" data-student-id="{{ $student->id }}" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" style="color: #3498db;">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 15v2a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3v-2m-8 1V4m0 12-4-4m4 4 4-4" />
                                                        </svg>
                                                    </td>

                                                    @foreach($lessons as $lesson)
                                                    @if($lesson->topics->contains('is_mark_enabled', 1))
                                                    @if($lesson->id != 2)
                                                    @foreach($lesson->topics as $topic)
                                                    @if($topic->is_mark_enabled == 1) <!-- Check if the topic is enabled -->
                                                    @if($topic->subtopics->count() > 0)
                                                    @foreach($topic->subtopics as $subtopic)
                                                    <!-- Check if the subtopic is enabled -->
                                                    <td class="single-line text-center">
                                                        @if($studentmarkdata->isEmpty())
                                                        <input type="text" class="primary_input_field form-control consistent-input amount"
                                                            data-student-id="{{ $student->id }}"
                                                            data-topic-id="{{ $topic->id }}"
                                                            data-subtopic-id="{{ $subtopic->id }}"
                                                            data-lesson-id="{{ $lesson->id }}"
                                                            data-subject-id="{{ $assign_subject->subject_id }}"
                                                            name="marks" value="">
                                                        @else
                                                        @php
                                                        $foundMarkValue = null;
                                                        $isBelowThreshold = false;

                                                        foreach ($studentmarkdata as $mark) {
                                                        // Check if the current mark matches the student and subtopic
                                                        if ($mark->student_id == $student->id &&
                                                        $mark->topic_id == $topic->id &&
                                                        $mark->lesson_id == $lesson->id &&
                                                        $mark->sub_topic_id == $subtopic->id) {

                                                        $foundMarkValue = $mark->mark_value;

                                                        // Check if the mark is below the average threshold
                                                        if ($foundMarkValue < $subtopicaverageMark) {
                                                            $isBelowThreshold=true;
                                                            }
                                                            break; // Break out of the loop once found
                                                            }
                                                            }
                                                            @endphp

                                                            <input type="text" class="primary_input_field form-control consistent-input amount @if($isBelowThreshold) border-danger text-danger @endif"
                                                            data-student-id="{{ $student->id }}"
                                                            data-topic-id="{{ $topic->id }}"
                                                            data-subtopic-id="{{ $subtopic->id }}"
                                                            data-lesson-id="{{ $lesson->id }}"
                                                            data-subject-id="{{ $assign_subject->subject_id }}"
                                                            name="marks" value="{{ $foundMarkValue ?? '' }}">
                                                            @endif
                                                    </td>


                                                    @endforeach

                                                    <!-- Total, Average, and Percentage for the Topic -->
                                                    <td class="text-center totalSumDisplay"
                                                        data-student-id="{{ $student->id }}"
                                                        data-topic-id="{{ $topic->id }}"
                                                        data-lesson-id="{{ $lesson->id }}"
                                                        id="totalSumDisplay_{{ $student->id }}_{{ $topic->id }}">

                                                        @if($studentmarkdata->isEmpty())
                                                        0
                                                        @else
                                                        @php
                                                        $studentmark = $studentmarkdata->firstWhere(function ($mark) use ($student, $topic, $lesson) {
                                                        return $mark->student_id == $student->id &&
                                                        $mark->topic_id == $topic->id &&
                                                        $mark->lesson_id == $lesson->id;
                                                        });
                                                        @endphp

                                                        {{ $studentmark ? $studentmark->total : 0 }}
                                                        @endif
                                                    </td>

                                                    <td class="text-center" id="averageMarkDisplay_{{ $student->id }}_{{ $topic->id }}">
                                                        @if($studentmarkdata->isEmpty())
                                                        0
                                                        @else
                                                        @php
                                                        $studentmark = $studentmarkdata->firstWhere(function ($mark) use ($student, $topic, $lesson) {
                                                        return $mark->student_id == $student->id &&
                                                        $mark->topic_id == $topic->id &&
                                                        $mark->lesson_id == $lesson->id;
                                                        });
                                                        @endphp

                                                        {{ $studentmark ? $studentmark->average ?? 0 : 0 }}
                                                        @endif
                                                    </td>

                                                    <td class="text-center" id="percentageMarkDisplay_{{ $student->id }}_{{ $topic->id }}">
                                                        @if($studentmarkdata->isEmpty())
                                                        0
                                                        @else
                                                        @php
                                                        $studentmark = $studentmarkdata->firstWhere(function ($mark) use ($student, $topic, $lesson) {
                                                        return $mark->student_id == $student->id &&
                                                        $mark->topic_id == $topic->id &&
                                                        $mark->lesson_id == $lesson->id;
                                                        });
                                                        @endphp

                                                        {{ $studentmark ? $studentmark->percentage ?? 0 : 0 }}
                                                        @endif
                                                    </td>
                                                    @else
                                                    <!-- Default empty columns for topics without subtopics -->
                                                    <td class="single-line text-center">
                                                        @if($studentmarkdata->isEmpty())
                                                        <input type="text" class="primary_input_field form-control consistent-input amount2"
                                                            data-student-id="{{ $student->id }}"
                                                            data-topic-id="{{ $topic->id }}"
                                                            data-lesson-id="{{ $lesson->id }}"
                                                            data-subject-id="{{ $assign_subject->subject_id }}"
                                                            name="marks" value="">
                                                        @else
                                                        @php
                                                        $foundMarkValue = null;
                                                        $isBelowThreshold = false;

                                                        foreach ($studentmarkdata as $mark) {
                                                        if ($mark->student_id == $student->id &&
                                                        $mark->topic_id == $topic->id &&
                                                        $mark->lesson_id == $lesson->id) {
                                                        $foundMarkValue = $mark->mark_value;
                                                        // Check if the found mark is below the average mark
                                                        if ($foundMarkValue < $averageMark) {
                                                            $isBelowThreshold=true;
                                                            }
                                                            break;
                                                            }
                                                            }
                                                            @endphp

                                                            <input type="text" class="primary_input_field form-control consistent-input amount2 @if($isBelowThreshold) border-danger text-danger @endif"
                                                            data-student-id="{{ $student->id }}"
                                                            data-topic-id="{{ $topic->id }}"
                                                            data-lesson-id="{{ $lesson->id }}"
                                                            data-subject-id="{{ $assign_subject->subject_id }}"
                                                            name="marks" value="{{ $foundMarkValue ?? '' }}">
                                                            @endif
                                                    </td>

                                                    @endif
                                                    @endif
                                                    @endforeach

                                                    <!-- Grand Total for the lesson -->
                                                    @if($lesson->topics->count() > 0)
                                                    <td id="grandtotal_lesson_{{ $lesson->id }}_{{ $student->id }}" style="text-align: center;">
                                                        @if($studentmarkdata->isEmpty())
                                                        <!-- If there are no records, display 0 -->
                                                        0
                                                        @else
                                                        @php
                                                        $studentmark = $studentmarkdata->firstWhere(function ($mark) use ($student, $topic, $lesson) {
                                                        return $mark->student_id == $student->id &&

                                                        $mark->lesson_id == $lesson->id;
                                                        });
                                                        @endphp

                                                        @if($studentmark)
                                                        <!-- If a matching record is found, display the total -->
                                                        {{ $studentmark->grand_total ?? 0 }}
                                                        @else
                                                        <!-- If no matching record is found, display 0 -->
                                                        0
                                                        @endif
                                                        @endif

                                                    </td>
                                                    @endif


                                                    <!-- Grand Total for Student, Topic, and Lesson -->
                                                    @if($lesson->topics->count() > 0)
                                                    <td id="grandtotal_{{ $lesson->id }}_{{ $student->id }}" style="text-align: center;">
                                                        @if($studentmarkdata->isEmpty())
                                                        <!-- If there are no records, display 0 -->
                                                        0
                                                        @else
                                                        @php
                                                        $studentmark = $studentmarkdata->firstWhere(function ($mark) use ($student, $topic, $lesson) {
                                                        return $mark->student_id == $student->id &&

                                                        $mark->lesson_id == $lesson->id;
                                                        });
                                                        @endphp

                                                        @if($studentmark)
                                                        <!-- If a matching record is found, display the total -->
                                                        {{ $studentmark->grand_percentage ?? 0 }}
                                                        @else
                                                        <!-- If no matching record is found, display 0 -->
                                                        0
                                                        @endif
                                                        @endif

                                                    </td>
                                                    @endif
                                                    @endif
                                                    @endif
                                                    @endforeach

                                                    <td id="overall_{{ $student->id }}_{{$assign_subject->subject_id}}" style="text-align: center;" data-subject-id="{{ $assign_subject->subject_id }}">
                                                        @if($studentmarkdata->isEmpty())
                                                        <!-- If there are no records, display 0 -->
                                                        0
                                                        @else
                                                        @php
                                                       
                                                        $studentmark = $studentmarkdata->first(function ($mark) use ($student, $assign_subject) {
                                                        return $mark->student_id == $student->id && $mark->subject_id == $assign_subject->subject_id;
                                                        });
                                                        @endphp

                                                        @if($studentmark)
                                                        <!-- If a matching record is found, display the total -->
                                                        {{ $studentmark->overall_percpercentage ?? 0 }}
                                                        @else
                                                        <!-- If no matching record is found, display 0 -->
                                                        0
                                                        @endif
                                                        @endif
                                                    </td>

                                                    <input type="hidden" id="mark_value_{{ $student->id }}">

                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </x-table>
                            </div>
                        </div>
                        <div class="col-lg-12 buttom-text-right">
                            <button type="submit" class="primary-btn small fix-gr-bg" id="search_promote">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @else
        @endif
        @else
        @endif

        <!-- Student Table -->
        @elseif($user->role_id == 2)

        @else
        @endif
        {{-- @endif --}}
    </div>
</section>
{{-- disable student  --}}
<style>
</style>
@endsection
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    function toggleCollapse(sectionId) {
        var section = document.getElementById(sectionId);
        if (section.style.display === "none" || section.style.display === "") {
            section.style.display = "block";
        } else {
            section.style.display = "none";
        }
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
            url: url + "/" + "ajaxStudentClassSection",
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
            url: url + "/" + "ajaxStudentSectionSubject",
            beforeSend: function() {
                $('#select_subject_loader').addClass('pre_loader').removeClass('loader');
            },
            success: function(data) {
                $("#common_select_Subject").empty().append(
                    $("<option>", {
                        value: '',
                        text: window.jsLang('select_section'),
                    })
                );
                if (data[0].length) {
                    $.each(data[0], function(i, section) {
                        $("#common_select_Subject").append(
                            $("<option>", {
                                value: section.id,
                                text: section.subject_name,
                            })
                        );
                    });
                }
                $('#common_select_Subject').niceSelect('update');
                $('#common_select_Subject').trigger('change');
            },
            error: function(data) {
                console.log("Error:", data);
            },
            complete: function() {
                $('#select_subject_loader').removeClass('pre_loader').addClass('loader');
            }
        });
    });

    $("#select_class_teacher").on("change", function() {
        var url = $("#url").val();
        var formData = {
            id: $(this).val()
        };
        $.ajax({
            type: "GET",
            data: formData,
            dataType: "json",
            url: url + "/" + "ajaxClassteacherSection",
            beforeSend: function() {
                $('#common_select_section_loader').addClass('pre_loader').removeClass('loader');
            },
            success: function(data) {
                $("#select_section_teacher").empty().append(
                    $("<option>", {
                        value: '',
                        text: window.jsLang('select_section'),
                    })
                );
                if (data[0].length) {
                    $.each(data[0], function(i, section) {
                        $("#select_section_teacher").append(
                            $("<option>", {
                                value: section.id,
                                text: section.section_name,
                            })
                        );
                    });
                }
                $('#select_section_teacher').niceSelect('update');
                $('#select_section_teacher').trigger('change');
            },
            error: function(data) {
                console.log("Error:", data);
            },
            complete: function() {
                $('#common_select_section_loader').removeClass('pre_loader').addClass('loader');
            }
        });
    });

    $("#select_section_teacher").on("change", function() {
        var url = $("#url").val();
        var formData = {
            id: $(this).val()
        };
        $.ajax({
            type: "GET",
            data: formData,
            dataType: "json",
            url: url + "/" + "ajaxClassteacherSubject",
            beforeSend: function() {
                $('#select_subject_loader').addClass('pre_loader').removeClass('loader');
            },
            success: function(data) {
                $("#select_Subject_teacher").empty().append(
                    $("<option>", {
                        value: '',
                        text: window.jsLang('select_section'),
                    })
                );
                if (data[0].length) {
                    $.each(data[0], function(i, section) {
                        $("#select_Subject_teacher").append(
                            $("<option>", {
                                value: section.id,
                                text: section.subject_name,
                            })
                        );
                    });
                }
                $('#select_Subject_teacher').niceSelect('update');
                $('#select_Subject_teacher').trigger('change');
            },
            error: function(data) {
                console.log("Error:", data);
            },
            complete: function() {
                $('#select_subject_loader').removeClass('pre_loader').addClass('loader');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const inputFields = document.querySelectorAll('.amount');

        inputFields.forEach(function(inputField) {
            const minLength = parseFloat(inputField.getAttribute('data-min-length'));

            inputField.addEventListener('input', function() {
                const value = parseFloat(this.value);

                if (!isNaN(value) && value < minLength) {
                    this.style.color = 'red';
                } else {
                    this.style.color = 'black';
                }
            });
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl, {
                html: true
            });
        });
    });
</script>
@isset($cgpamark)
<!-- mark data form save -->
<script>
    $(document).ready(function() {
        $('#form').on('submit', function(e) {
            e.preventDefault();
            let assignSubjectId = $('#assign_subject_id').val();
            const marksData = calculateMarks();

            if (marksData.marks.length === 0) {
                toastr.error('No marks to save.');
                return;
            }

            const totalMarks = {};
            $('.consistent-input').each(function() {
                const studentId = $(this).data('student-id');
                const mark = parseFloat($(this).val()) || 0;
                totalMarks[studentId] = (totalMarks[studentId] || 0) + mark;
            });

            $.ajax({
                url: "{{ route('save.marks') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    marks: JSON.stringify(marksData.marks),
                    assign_subject_id: assignSubjectId,
                    total_marks: totalMarks,
                    summary: JSON.stringify(marksData.summary)
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        window.location.replace("{{ route('programs.mark') }}");
                    } else {
                        toastr.error('Failed to save marks');
                    }
                },
                error: function(xhr) {
                    alert('An error occurred. Please try again.');
                }
            });
        });

        function calculateMarks() {
            let marks = [];
            let summary = {};

            $('.consistent-input').each(function() {
                const studentId = $(this).data('student-id');
                const topicId = $(this).data('topic-id');
                const subtopicId = $(this).data('subtopic-id') || null;
                const lessonId = $(this).data('lesson-id');
                const subjectId = $(this).data('subject-id');
                const mark = parseFloat($(this).val()) || 0;
                let overallPercentage = parseFloat($('#overall_' + studentId + '_' + subjectId).text()) || 0;


                if (!summary[studentId]) {
                    summary[studentId] = {
                        total: 0,
                        average: 0,
                        percentage: 0,
                        grandtotal: 0,
                        grandpercentage: 0,
                    };
                }


                summary[studentId].total = parseFloat($('#totalSumDisplay_' + studentId + '_' + topicId).text()) || 0;
                summary[studentId].average = parseFloat($('#averageMarkDisplay_' + studentId + '_' + topicId).text()) || 0;
                summary[studentId].percentage = parseFloat($('#percentageMarkDisplay_' + studentId + '_' + topicId).text()) || 0;
                summary[studentId].grandtotal = parseFloat($('#grandtotal_lesson_' + lessonId + '_' + studentId).text()) || 0;
                summary[studentId].grandpercentage = parseFloat($('#grandtotal_' + lessonId + '_' + studentId).text()) || 0;


                const markData = {
                    student_id: studentId,
                    topic_id: topicId,
                    sub_topic_id: subtopicId,
                    lesson_id: lessonId,
                    mark: mark,
                    total: summary[studentId].total,
                    average: summary[studentId].average,
                    percentage: summary[studentId].percentage,
                    grandtotal: summary[studentId].grandtotal,
                    grandpercentage: summary[studentId].grandpercentage,
                    overallPercentage: overallPercentage
                };

                marks.push(markData);
            });

            return {
                marks,
                summary
            };
        }
    });
</script>



<!-- mark data form  -->
@isset($count_topic)


<script>
    $(document).ready(function() {
        function updateSubtopicTotal(studentId, topicId, lessonId) {
            let totalSubtopic = 0;
            const inputs = $(`.amount[data-student-id="${studentId}"][data-topic-id="${topicId}"][data-lesson-id="${lessonId}"]`);

            inputs.each(function() {
                const value = parseFloat($(this).val()) || 0;
                const subtopicId = $(this).data('subtopic-id');
                const max_marks = parseFloat($(`#subtopic_${subtopicId}`).data('max_marks')) || 0;
                const avg_mark = parseFloat($(`#subtopic_${subtopicId}`).data('avg_marks')) || 0;
                console.log(`Subtopic ID: ${subtopicId}, Max Marks: ${max_marks}`);
                const minMarks = 0;
                if (value < minMarks || value > max_marks) {
                    toastr.error(`The entered value must be less than the max mark`);
                    $(this).val('');
                } else {
                    if (value < avg_mark) {
                        $(this).css({

                            color: 'red'
                        });
                    } else {
                        $(this).css({

                            color: 'grey'
                        });
                    }
                    totalSubtopic += value;
                }
            });

            const subtopicsCount = inputs.length;
            const headerElement = document.getElementById('header_' + topicId);
            const percentageCount = parseFloat(headerElement.getAttribute('data-cgpa') || '1');
            const average = subtopicsCount > 0 ? (totalSubtopic / subtopicsCount) : 0;
            const totalMarks = parseFloat(getTotalMarksForTopic(topicId)) || 0;

            const percentage = totalMarks > 0 ? (totalSubtopic / totalMarks) * percentageCount : 0;
            $(`#totalSumDisplay_${studentId}_${topicId}`).text(totalSubtopic.toFixed(2));
            $(`#averageMarkDisplay_${studentId}_${topicId}`).text(average.toFixed(2));
            $(`#percentageMarkDisplay_${studentId}_${topicId}`).text(percentage.toFixed(2));

            return totalSubtopic;
        }


        function updateTopicTotal(studentId, topicId, lessonId) {
            const topicValue = parseFloat($(`.amount2[data-student-id="${studentId}"][data-topic-id="${topicId}"][data-lesson-id="${lessonId}"]`).val()) || 0;
            return topicValue;
        }

        function updateGrandTotal(studentId, lessonId, topicId) {
            let grandTotal = 0;
            const totalMarks = parseFloat($(`#totalMarks_${lessonId}`).text()) || 0;
            $(`.totalSumDisplay[data-student-id="${studentId}"][data-lesson-id="${lessonId}"]`).each(function() {
                grandTotal += parseFloat($(this).text()) || 0;
            });
            $(`.amount2[data-student-id="${studentId}"][data-lesson-id="${lessonId}"]`).each(function() {
                const value = parseFloat($(this).val()) || 0;
                const subtopicId = $(this).data('topic-id');
                const max_marks = parseFloat($(`#header_${subtopicId}`).data('max_marks')) || 0;
                const avg_mark = parseFloat($(`#header_${subtopicId}`).data('avg_marks')) || 0;
                console.log(`Subtopic ID: ${subtopicId}, Max Marks: ${max_marks}`);
                const minMarks = 0;
                if (value < minMarks || value > max_marks) {
                    toastr.error(`The entered value must be less than the max mark`);
                    $(this).val('');
                } else {
                    if (value < avg_mark) {
                        $(this).css({

                            color: 'red'
                        });
                    } else {
                        $(this).css({

                            color: 'grey'
                        });
                    }
                    grandTotal += value;
                }
            });
            $(`#grandtotal_lesson_${lessonId}_${studentId}`).text(grandTotal.toFixed(2));
            return grandTotal;
        }

        const cgpaData = @json($cgpa).reduce((acc, item) => {
            acc[item.lesson_id] = item.cgpa_mark;
            return acc;
        }, {});

        function updateOverallTotal(studentId, topicId, lessonId, subjectId) {
            const subtopicTotal = updateSubtopicTotal(studentId, topicId, lessonId);
            const topicTotal = updateTopicTotal(studentId, topicId, lessonId);
            const grandTotal = updateGrandTotal(studentId, lessonId);
            const totalCGPA = parseFloat(cgpaData[lessonId]) || 0;
            const totalmark = parseFloat($(`#totalMarks_${lessonId}`).text()) || 0;
            const percentage = totalmark > 0 ? (grandTotal / totalmark * totalCGPA) : 0;
            $(`#grandtotal_${lessonId}_${studentId}`).text(percentage.toFixed(2) + '%');
            let overallTotal = 0;
            $(`[id^="grandtotal_"][id$="_${studentId}"]:not([id^="grandtotal_lesson_"])`).each(function() {
                const value = parseFloat($(this).text().replace('%', '')) || 0;
                if (!isNaN(value)) {
                    overallTotal += value;
                }
            });
            console.log("Overall Percentage:", overallTotal.toFixed(2) + '%');
            $(`#overall_${studentId}_${subjectId}`).text(overallTotal.toFixed(2) + '%');
        }
        $('.amount').on('input', function() {
            const studentId = $(this).data('student-id');
            const topicId = $(this).data('topic-id');
            const lessonId = $(this).data('lesson-id');
            const subjectId = $(this).data('subject-id');
            updateOverallTotal(studentId, topicId, lessonId, subjectId);
        });

        function getTotalMarksForTopic(topicId) {
            var totalMarksData = @json($count_topic);
            var topicData = totalMarksData.find(item => item.topic_id == topicId);
            return topicData ? topicData.total_max_marks : 0;
        }

        function getTotalMarksForLesson(lessonId) {
            var cgpa = @json($cgpa);
            var lessonData = totalMarksData.find(item => item.lesson_id == lessonId);
            return lessonData ? lessonData.cgpa_mark : 0;
        }

        $('.amount2').on('input', function() {
            const studentId = $(this).data('student-id');
            const topicId = $(this).data('topic-id');
            const lessonId = $(this).data('lesson-id');
            const subjectId = $(this).data('subject-id');
            updateOverallTotal(studentId, topicId, lessonId, subjectId);
        });
    });
</script>
@endisset

<!-- download in the excel -->
<script>
    function downloadTableAsCSV() {
        const table = document.querySelector('table');
        let csvContent = [];
        const maxCols = calculateMaxColumns(table);

        const thead = table.querySelector('thead');
        if (thead) {
            const headerRows = Array.from(thead.rows);

            let headerTracking = Array(headerRows.length).fill().map(() => Array(maxCols).fill(''));


            headerRows.forEach((row, rowIndex) => {
                let colIndex = 0;

                Array.from(row.cells).forEach(cell => {
                    const colspan = parseInt(cell.getAttribute('colspan')) || 1;
                    const rowspan = parseInt(cell.getAttribute('rowspan')) || 1;
                    const cellText = cell.innerText.trim().replace(/\n/g, ' ');


                    while (headerTracking[rowIndex][colIndex] !== '') {
                        colIndex++;
                    }


                    for (let i = 0; i < rowspan; i++) {
                        for (let j = 0; j < colspan; j++) {
                            if (rowIndex + i < headerRows.length) {
                                headerTracking[rowIndex + i][colIndex + j] = cellText;
                            }
                        }
                    }

                    colIndex += colspan;
                });
            });


            headerTracking.forEach(row => {
                csvContent.push(row.map(cell => `"${cell}"`).join(','));
            });
        }


        const tbody = table.querySelector('tbody');
        if (tbody) {
            Array.from(tbody.rows).forEach(row => {
                const rowData = Array.from(row.cells).map(cell => {
                    const input = cell.querySelector('input');
                    const value = input ? input.value : cell.innerText.trim();
                    return `"${value.replace(/"/g, '""')}"`;
                });

                while (rowData.length < maxCols) {
                    rowData.push('""');
                }

                csvContent.push(rowData.join(','));
            });
        }


        const csvString = csvContent.join('\n');


        const blob = new Blob(["\ufeff" + csvString], {
            type: 'text/csv;charset=utf-8'
        });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = 'mark_table.csv';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    }


    function calculateMaxColumns(table) {
        let maxCols = 0;
        const rows = Array.from(table.rows);

        rows.forEach(row => {
            let colCount = 0;
            Array.from(row.cells).forEach(cell => {
                const colspan = parseInt(cell.getAttribute('colspan')) || 1;
                colCount += colspan;
            });
            maxCols = Math.max(maxCols, colCount);
        });

        return maxCols;
    }

    function submitTableData(csvString) {
        $.ajax({
            url: route('marktable.csv'),
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            contentType: "application/json",
            data: JSON.stringify({
                tableData: csvString
            }),
            success: function(response) {
                const blob = new Blob([response], {
                    type: 'text/csv'
                });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'mark_table.csv';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Error generating CSV. Please try again.');
            },
            xhrFields: {
                responseType: 'blob'
            }
        });
    }
</script>



<!-- download in the table pdf -->
<script>
    function downloadTableAsPDF() {
        const table = document.querySelector('table');
        let tableData = {
            headers: [],
            rows: [],
            styles: []
        };
        const thead = table.querySelector('thead');
        if (thead) {
            Array.from(thead.rows).forEach((row) => {
                const headerRow = [];
                Array.from(row.cells).forEach((cell) => {
                    headerRow.push({
                        content: cell.innerText.trim(),
                        rowspan: cell.rowSpan || 1,
                        colspan: cell.colSpan || 1,
                        backgroundColor: window.getComputedStyle(cell).backgroundColor,
                        className: cell.className
                    });
                });
                tableData.headers.push(headerRow);
            });
        }

        const tbody = table.querySelector('tbody');
        if (tbody) {
            Array.from(tbody.rows).forEach((row) => {
                const rowData = [];
                Array.from(row.cells).forEach((cell) => {
                    const input = cell.querySelector('input');
                    const value = input ? input.value : cell.innerText.trim();

                    rowData.push({
                        content: value,
                        backgroundColor: window.getComputedStyle(cell).backgroundColor,
                        className: cell.className,
                        isInput: !!input
                    });
                });
                tableData.rows.push(rowData);
            });
        }

        const styles = new Set();
        table.querySelectorAll('[class]').forEach(element => {
            element.classList.forEach(className => {
                const style = window.getComputedStyle(element);
                styles.add({
                    className,
                    backgroundColor: style.backgroundColor,
                    color: style.color,
                    textAlign: style.textAlign
                });
            });
        });
        tableData.styles = Array.from(styles);

        $.ajax({
            url: "{{ route('marktable.pdf') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: "application/json",
            data: JSON.stringify({
                tableData: tableData
            }),
            success: function(response) {
                const blob = new Blob([response], {
                    type: 'application/pdf'
                });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'mark_table.pdf';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Error generating PDF. Please try again.');
            },
            xhrFields: {
                responseType: 'blob'
            }
        });
    }
</script>



<!-- download in the table txt -->
<script>
    function downloadTableAsText() {
        const table = document.querySelector('table');
        let tableData = '';


        const thead = table.querySelector('thead');
        if (thead) {
            Array.from(thead.rows).forEach((row) => {
                Array.from(row.cells).forEach((cell) => {
                    tableData += cell.innerText.trim() + '\t';
                });
                tableData += '\n';
            });
        }

        const tbody = table.querySelector('tbody');
        if (tbody) {
            Array.from(tbody.rows).forEach((row) => {
                Array.from(row.cells).forEach((cell) => {
                    const input = cell.querySelector('input');
                    const value = input ? input.value : cell.innerText.trim();
                    tableData += value + '\t';
                });
                tableData += '\n';
            });
        }
        $.ajax({
            url: "{{ route('marktable.text') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: "application/json",
            data: JSON.stringify({
                tableData: tableData
            }),
            success: function(response) {
                const blob = new Blob([response], {
                    type: 'text/plain'
                });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'mark_table.txt';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Error generating text file. Please try again.');
            },
            xhrFields: {
                responseType: 'blob'
            }
        });
    }
</script>
<!-- print table -->
<script>
    function printTable() {
        const table = document.querySelector('table');
        const newWindow = window.open('', '', 'width=800,height=600');


        newWindow.document.write('<html><head><title>Print Table</title>');
        newWindow.document.write('<style>table { width: 100%; border-collapse: collapse; }');
        newWindow.document.write('th, td { border: 1px solid #000; padding: 8px; text-align: left; }</style>');
        newWindow.document.write('</head><body>');
        newWindow.document.write(table.outerHTML);
        newWindow.document.write('</body></html>');

        newWindow.document.close();
        newWindow.print();
        newWindow.close();
    }
</script>
<!-- table copy -->
<script>
    function showToast(message) {
        const toast = document.createElement('div');
        toast.textContent = message;
        toast.style.position = 'fixed';
        toast.style.bottom = '20px';
        toast.style.right = '20px';
        toast.style.backgroundColor = '#4CAF50';
        toast.style.color = 'white';
        toast.style.padding = '10px 20px';
        toast.style.borderRadius = '5px';
        toast.style.zIndex = '1000';
        document.body.appendChild(toast);
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 3000);
    }

    function copyTableData() {
        const table = document.querySelector('table');
        const rows = Array.from(table.rows);
        const formattedContent = rows.map(row =>
            Array.from(row.cells).map(cell => {
                return cell.querySelector('input') ? cell.querySelector('input').value : cell.textContent;
            }).join('\t')
        ).join('\n');
        const tempElement = document.createElement('textarea');
        tempElement.value = formattedContent;
        document.body.appendChild(tempElement);
        tempElement.select();
        document.execCommand('copy');
        document.body.removeChild(tempElement);
        showToast('Table copied successfully!');
    }
    document.querySelector('#copyTableButton').addEventListener('click', copyTableData);
</script>

<!-- student mark sheet download -->
<script>
    $(document).on('click', '.download-pdf', function(e) {
        e.preventDefault();


        let studentId = $(this).data('student-id');


        $.ajax({
            url: "{{ route('download.pdf') }}",
            type: 'GET',
            data: {
                student_id: studentId
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(response);
                link.download = 'student_' + studentId + '_report.pdf';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function(xhr, status, error) {
                console.error("An error occurred: " + error);
                alert("Failed to download the PDF.");
            }
        });
    });
</script>
<!-- Zip file download in mark list -->
<script>
    function downloadPDFs(subjectId) {
        $.ajax({
            url: `/subject/download-pdfs/${subjectId}`,
            method: 'GET',
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
                alert('An error occurred while downloading the files.');
            }
        });
    }
</script>



@endisset
@endpush