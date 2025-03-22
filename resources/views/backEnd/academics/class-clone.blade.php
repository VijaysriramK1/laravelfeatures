@extends('backEnd.master')
@section('title')
@lang('common.clone_class')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-20">
    <div class="container-fluid">
    @if(isset($classById))
        <div class="row justify-content-between">
            <h1>@lang('common.class')</h1>
            <div class="bc-pages">
                <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                <a href="#">@lang('academics.academics')</a>
                <a href="{{ route('class') }}">@lang('common.class')</a>
                <a href="#">@lang('common.clone_class')</a>
            </div>
        </div>
        @elseif(isset($subjectId))
        <div class="row justify-content-between">
            <h1>subject</h1>
            <div class="bc-pages">
                <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                <a href="#">@lang('academics.academics')</a>
                <a href="{{ route('subject') }}">subject</a>
                <a href="#">clone subject</a>
            </div>
        </div>
        @elseif(isset($lessonId))
        <div class="row justify-content-between">
            <h1>lesson</h1>
            <div class="bc-pages">
                <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                <a href="#">@lang('academics.academics')</a>
                <a href="{{ route('lesson') }}">lesson</a>
                <a href="#">clone lesson</a>
            </div>
        </div>
        @elseif(isset($data))
        <div class="row justify-content-between">
            <h1>Topics</h1>
            <div class="bc-pages">
                <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                <a href="#">@lang('academics.academics')</a>
                <a href="{{ url('/lesson/topic') }}">Topics</a>
                <a href="#">clone Topics</a>
            </div>
        </div>
        
        @elseif(isset($subTopicDetails))
        <div class="row justify-content-between">
            <h1>sub topics</h1>
            <div class="bc-pages">
                <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                <a href="#">@lang('academics.academics')</a>
                <a href="{{ route('sub-topic') }}">sub topics</a>
                <a href="#">sub topics</a>
            </div>
        </div>
        @else
        @endif
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container p-0">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-lg-12">
                        @if(isset($classById))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'class_clone_save', 'method' => 'POST']) }}
                        <div class="white-box">
                            <div class="main-title">
                                <h3 class="mb-15">
                                    @lang('common.clone_class')
                                </h3>
                            </div>
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('common.name') <span
                                                    class="text-danger"> *</span></label>
                                            <b>{{ isset($classById) ? @$classById->class_name : '' }}
                                            
                                            </b>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-25">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">Start Date <span
                                                    class="text-danger"> *</span></label>
                                            <input
                                                class="primary_input_field form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}"
                                                type="date" name="start_date" autocomplete="off" value="{{ old('start_date') }}" required>
                                            <input type="hidden" name="id"
                                                value="{{ isset($classById) ? $classById->id : '' }}">



                                            @if ($errors->has('name'))
                                            <span class="text-danger">
                                                {{ @$errors->first('name') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-25">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">End Date<span class="text-danger"> *</span></label>
                                            <input
                                                class="primary_input_field form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}"
                                                type="date" name="end_date" autocomplete="off" value="{{ old('end_date') }}" required>

                                        </div>
                                    </div>
                                </div>

                                @if (generalSetting()->result_type == 'mark')
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('exam.pass_mark')
                                                <span class="text-danger"> *</span></label>
                                            <input
                                                class="primary_input_field form-control{{ @$errors->has('pass_mark') ? ' is-invalid' : '' }}"
                                                type="text" name="pass_mark" autocomplete="off"
                                                value="{{ isset($classById) ? @$classById->pass_mark : '' }}">


                                            @if ($errors->has('pass_mark'))
                                            <span class="text-danger">
                                                {{ @$errors->first('pass_mark') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                                {{-- <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">

                                                <label class="primary_input_label" for="">@lang('common.copy_items')</label>
                                                <select multiple name="copy_items[]"
                                                    class="multypol_check_select active position-relative">
                                                    <option value="section">@lang('common.section')</option>
                                                    <option value="subject">@lang('common.subject')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                @php
                                $tooltip = '';
                                if (userPermission('class_store')) {
                                $tooltip = '';
                                } else {
                                $tooltip = 'You have no permission to add';
                                }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-end">
                                        <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip"
                                            title="{{ $tooltip }}">
                                            <span class="ti-check"></span>
                                            @lang('academics.save_class')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                        @elseif(isset($subjectId))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'subject_clone_save', 'method' => 'POST']) }}
                        <div class="white-box">
                            <div class="main-title">
                                <h3 class="mb-15">
                                    @lang('common.clone_class')
                                </h3>
                            </div>
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('common.name') <span
                                                    class="text-danger"> *</span></label>
                                            <b>
                                                {{ isset($subjectId) ? @$subjectId->subject_name : '' }}
                                            </b>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-25">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">Start Date <span
                                                    class="text-danger"> *</span></label>
                                            <input
                                                class="primary_input_field form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}"
                                                type="date" name="start_date" autocomplete="off" value="{{ old('start_date') }}" required>

                                            <input type="hidden" name="id"
                                                value="{{ isset($subjectId) ? $subjectId->id : '' }}">


                                            @if ($errors->has('name'))
                                            <span class="text-danger">
                                                {{ @$errors->first('name') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-25">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">End Date<span class="text-danger"> *</span></label>
                                            <input
                                                class="primary_input_field form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}"
                                                type="date" name="end_date" autocomplete="off" value="{{ old('end_date') }}" required>

                                        </div>
                                    </div>
                                </div>

                                @if (generalSetting()->result_type == 'mark')
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('exam.pass_mark')
                                                <span class="text-danger"> *</span></label>
                                            <input
                                                class="primary_input_field form-control{{ @$errors->has('pass_mark') ? ' is-invalid' : '' }}"
                                                type="text" name="pass_mark" autocomplete="off"
                                                value="{{ isset($classById) ? @$classById->pass_mark : '' }}">


                                            @if ($errors->has('pass_mark'))
                                            <span class="text-danger">
                                                {{ @$errors->first('pass_mark') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                                {{-- <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">

                                                <label class="primary_input_label" for="">@lang('common.copy_items')</label>
                                                <select multiple name="copy_items[]"
                                                    class="multypol_check_select active position-relative">
                                                    <option value="section">@lang('common.section')</option>
                                                    <option value="subject">@lang('common.subject')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                @php
                                $tooltip = '';
                                if (userPermission('class_store')) {
                                $tooltip = '';
                                } else {
                                $tooltip = 'You have no permission to add';
                                }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-end">
                                        <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip"
                                            title="{{ $tooltip }}">
                                            <span class="ti-check"></span>
                                            @lang('academics.save_subject')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                        @elseif(isset($lessonId))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'lesson_clone_save', 'method' => 'POST']) }}
                        <div class="white-box">
                            <div class="main-title">
                                <h3 class="mb-15">
                                   clone lesson
                                </h3>
                            </div>
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('common.name') <span
                                                    class="text-danger"> *</span></label>
                                            <b>

                                                @isset($lessonId)
                                                <ul>
                                                    @foreach($lessonId as $lesson)
                                                    <li>{{ $lesson->lesson_title ?? 'No lesson title' }}</li>
                                                    @endforeach
                                                </ul>
                                                @endisset

                                            </b>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-25">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">Start Date <span
                                                    class="text-danger"> *</span></label>
                                            <input
                                                class="primary_input_field form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}"
                                                type="date" name="start_date" autocomplete="off" value="{{ old('start_date') }}" required>
                                            @foreach($lessonId as $lesson)
                                            <input type="hidden" name="lesson[]" value="{{ $lesson->id }}">
                                            @endforeach
                                            @if ($errors->has('name'))
                                            <span class="text-danger">
                                                {{ @$errors->first('name') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-25">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">End Date<span class="text-danger"> *</span></label>
                                            <input
                                                class="primary_input_field form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}"
                                                type="date" name="end_date" autocomplete="off" value="{{ old('end_date') }}" required>

                                        </div>
                                    </div>
                                </div>

                                @if (generalSetting()->result_type == 'mark')
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('exam.pass_mark')
                                                <span class="text-danger"> *</span></label>
                                            <input
                                                class="primary_input_field form-control{{ @$errors->has('pass_mark') ? ' is-invalid' : '' }}"
                                                type="text" name="pass_mark" autocomplete="off"
                                                value="{{ isset($classById) ? @$classById->pass_mark : '' }}">


                                            @if ($errors->has('pass_mark'))
                                            <span class="text-danger">
                                                {{ @$errors->first('pass_mark') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                                {{-- <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">

                                                <label class="primary_input_label" for="">@lang('common.copy_items')</label>
                                                <select multiple name="copy_items[]"
                                                    class="multypol_check_select active position-relative">
                                                    <option value="section">@lang('common.section')</option>
                                                    <option value="subject">@lang('common.subject')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                @php
                                $tooltip = '';
                                if (userPermission('class_store')) {
                                $tooltip = '';
                                } else {
                                $tooltip = 'You have no permission to add';
                                }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-end">
                                        <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip"
                                            title="{{ $tooltip }}">
                                            <span class="ti-check"></span>
                                            save lesson
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                        @elseif(isset($data))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'topic_clone_save', 'method' => 'POST']) }}
                        <div class="white-box">
                            <div class="main-title">
                                <h3 class="mb-15">
                                clone topic
                                </h3>
                            </div>
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('common.name') <span
                                                    class="text-danger"> *</span></label>
                                            <b>

                                            @isset($data)
                                                <ul>
                                                    @foreach($data as $topic)
                                                    <li>{{ $topic->topic_title ?? 'No topic title' }}</li>
                                                    @endforeach
                                                </ul>
                                                @endisset

                                            </b>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-25">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">Start Date <span
                                                    class="text-danger"> *</span></label>
                                            <input
                                                class="primary_input_field form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}"
                                                type="date" name="start_date" autocomplete="off" value="{{ old('start_date') }}" required>
                                            @foreach($data as $topic)
                                            <input type="hidden" name="topic[]" value="{{ $topic->id }}">
                                            @endforeach
                                            @if ($errors->has('name'))
                                            <span class="text-danger">
                                                {{ @$errors->first('name') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-25">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">End Date<span class="text-danger"> *</span></label>
                                            <input
                                                class="primary_input_field form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}"
                                                type="date" name="end_date" autocomplete="off" value="{{ old('end_date') }}" required>

                                        </div>
                                    </div>
                                </div>

                                @if (generalSetting()->result_type == 'mark')
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('exam.pass_mark')
                                                <span class="text-danger"> *</span></label>
                                            <input
                                                class="primary_input_field form-control{{ @$errors->has('pass_mark') ? ' is-invalid' : '' }}"
                                                type="text" name="pass_mark" autocomplete="off"
                                                value="{{ isset($classById) ? @$classById->pass_mark : '' }}">


                                            @if ($errors->has('pass_mark'))
                                            <span class="text-danger">
                                                {{ @$errors->first('pass_mark') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                                {{-- <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">

                                                <label class="primary_input_label" for="">@lang('common.copy_items')</label>
                                                <select multiple name="copy_items[]"
                                                    class="multypol_check_select active position-relative">
                                                    <option value="section">@lang('common.section')</option>
                                                    <option value="subject">@lang('common.subject')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                @php
                                $tooltip = '';
                                if (userPermission('class_store')) {
                                $tooltip = '';
                                } else {
                                $tooltip = 'You have no permission to add';
                                }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-end">
                                        <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip"
                                            title="{{ $tooltip }}">
                                            <span class="ti-check"></span>
                                           save Topic
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                        @elseif(isset($subTopicDetails))
                        {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'subtopic_clone_save', 'method' => 'POST']) }}
                        <div class="white-box">
                            <div class="main-title">
                                <h3 class="mb-15">
                                clone subtopics
                                </h3>
                            </div>
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('common.name') <span
                                                    class="text-danger"> *</span></label>
                                            <b>

                                            @isset($subTopicDetails)
                                                <ul>
                                                    @foreach($subTopicDetails as $subTopic)
                                                    <li>{{ $subTopic->sub_topic_title ?? 'No topic title' }}</li>
                                                    @endforeach
                                                </ul>
                                                @endisset

                                            </b>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-25">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">Start Date <span
                                                    class="text-danger"> *</span></label>
                                            <input
                                                class="primary_input_field form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}"
                                                type="date" name="start_date" autocomplete="off" value="{{ old('start_date') }}" required>
                                            @foreach($subTopicDetails as $subtopic)
                                            <input type="hidden" name="subtopic[]" value="{{ $subtopic->id }}">
                                            @endforeach
                                            @if ($errors->has('name'))
                                            <span class="text-danger">
                                                {{ @$errors->first('name') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-25">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">End Date<span class="text-danger"> *</span></label>
                                            <input
                                                class="primary_input_field form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}"
                                                type="date" name="end_date" autocomplete="off" value="{{ old('end_date') }}" required>

                                        </div>
                                    </div>
                                </div>

                                @if (generalSetting()->result_type == 'mark')
                                <div class="row mt-25">
                                    <div class="col-lg-12">
                                        <div class="primary_input">
                                            <label class="primary_input_label" for="">@lang('exam.pass_mark')
                                                <span class="text-danger"> *</span></label>
                                            <input
                                                class="primary_input_field form-control{{ @$errors->has('pass_mark') ? ' is-invalid' : '' }}"
                                                type="text" name="pass_mark" autocomplete="off"
                                                value="{{ isset($classById) ? @$classById->pass_mark : '' }}">


                                            @if ($errors->has('pass_mark'))
                                            <span class="text-danger">
                                                {{ @$errors->first('pass_mark') }}
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                                {{-- <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">

                                                <label class="primary_input_label" for="">@lang('common.copy_items')</label>
                                                <select multiple name="copy_items[]"
                                                    class="multypol_check_select active position-relative">
                                                    <option value="section">@lang('common.section')</option>
                                                    <option value="subject">@lang('common.subject')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div> --}}
                                @php
                                $tooltip = '';
                                if (userPermission('class_store')) {
                                $tooltip = '';
                                } else {
                                $tooltip = 'You have no permission to add';
                                }
                                @endphp
                                <div class="row mt-40">
                                    <div class="col-lg-12 text-end">
                                        <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip"
                                            title="{{ $tooltip }}">
                                            <span class="ti-check"></span>
                                            @lang('academics.save_lesson')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                        @else
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@include('backEnd.partials.date_picker_css_js')
@include('backEnd.partials.multi_select_js')
@include('backEnd.partials.data_table_js')