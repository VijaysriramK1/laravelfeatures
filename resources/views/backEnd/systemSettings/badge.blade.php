@extends('backEnd.master')
@section('title')
    @lang('common.bage')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('common.bage')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('system_settings.system_settings')</a>
                    <a href="#">@lang('common.bage')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if (isset($bage))
                @if (userPermission('academic-year-store'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{ route('academic-year') }}" class="primary-btn small fix-gr-bg">
                                <span class="ti-plus pr-2"></span>
                                @lang('common.add')
                            </a>
                        </div>
                    </div>
                @endif
            @endif
            <div class="row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (isset($bage))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => ['academic-year-update', @$bage->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                            @else
                                @if (userPermission('academic-year-store'))
                                    {{ Form::open([
                                        'class' => 'form-horizontal',
                                        'files' => true,
                                        'route' => 'academic-years',
                                        'method' => 'POST',
                                        'enctype' => 'multipart/form-data',
                                    ]) }}
                                @endif
                            @endif
                            <div class="white-box">
                                <div class="main-title">
                                    <h3 class="mb-15">
                                        @if (isset($bage))
                                            @lang('system_settings.edit_bage')
                                        @else
                                            @lang('system_settings.add_bage')
                                        @endif
                                    </h3>
                                </div>
                                <div class="add-visitor">

                                    <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label> @lang('system_settings.year_title')<span class="text-danger"> *</span></label>
                                                <input
                                                    class="primary_input_field form-control{{ $errors->has('title') ? ' is-invalid' : '' }}"
                                                    type="text" name="title" autocomplete="off"
                                                    value="{{ isset($bage) ? @$bage->title : old('bage') }}">
                                                <input type="hidden" name="id"
                                                    value="{{ isset($bage) ? @$bage->id : '' }}">


                                                @if ($errors->has('title'))
                                                    <span class="text-danger">
                                                        {{ $errors->first('title') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="date_of_birth">@lang('system_settings.starting_date')
                                                    <span class="text-danger">*</span></label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input
                                                                    class="primary_input_field  primary_input_field date form-control form-control{{ $errors->has('starting_date') ? ' is-invalid' : '' }}"
                                                                    id="startDate" type="text"
                                                                    placeholder=" @lang('system_settings.starting_date') *" name="starting_date"
                                                                    value="{{ isset($bage) ? date('m/d/Y', strtotime($bage->starting_date)) : date('01/01/Y') }}">
                                                            </div>
                                                        </div>
                                                        <button class="btn-date" data-id="#starting_date" type="button">
                                                            <label class="m-0 p-0" for="startDate">
                                                                <i class="ti-calendar" id="start-date-icon"></i>
                                                            </label>
                                                        </button>
                                                    </div>
                                                </div>
                                                <span class="text-danger">{{ $errors->first('starting_date') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-15">

                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="date_of_birth">@lang('system_settings.ending_date')
                                                    <span class="text-danger">*</span></label>
                                                <div class="primary_datepicker_input">
                                                    <div class="no-gutters input-right-icon">
                                                        <div class="col">
                                                            <div class="">
                                                                <input
                                                                    class="primary_input_field  primary_input_field date form-control form-control{{ $errors->has('ending_date') ? ' is-invalid' : '' }}"
                                                                    id="endDate" type="text"
                                                                    placeholder="@lang('system_settings.ending_date')*" name="ending_date"
                                                                    value="{{ isset($bage) ? date('m/d/Y', strtotime($bage->ending_date)) : date('12/31/Y') }}">
                                                            </div>
                                                        </div>
                                                        <button class="btn-date" data-id="#ending_date" type="button">
                                                            <label class="m-0 p-0" for="endDate">
                                                                <i class="ti-calendar" id="start-date-icon"></i>
                                                            </label>
                                                        </button>
                                                    </div>
                                                </div>
                                                <span class="text-danger">{{ $errors->first('ending_date') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        if (isset($bage)) {
                                            $copy_with_bage = explode(',', @$bage->copy_with_bage);
                                        }
                                    @endphp
                                    <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">

                                                <label class="primary_input_label" for="">@lang('system_settings.copy_with_bage')</label>
                                                <select multiple name="copy_with_bage[]"
                                                    class="multypol_check_select active position-relative">
                                                    <option value="App\SmClass"
                                                        @if (isset($bage)) @if (in_array('App\SmClass', @$copy_with_bage)) selected @endif
                                                        @endif >@lang('common.class') </option>
                                                    <option value="App\SmSection"
                                                        @if (isset($bage)) @if (in_array('App\SmSection', @$copy_with_bage)) selected @endif
                                                        @endif >@lang('common.section')</option>
                                                    <option value="App\SmSubject"
                                                        @if (isset($bage)) @if (in_array('App\SmSubject', @$copy_with_bage)) selected @endif
                                                        @endif >@lang('common.subject')</option>
                                                    <option value="App\SmExamType"
                                                        @if (isset($bage)) @if (in_array('App\SmExamType', @$copy_with_bage)) selected @endif
                                                        @endif >@lang('exam.exam_type') </option>
                                                    <option value="App\SmStudentCategory"
                                                        @if (isset($bage)) @if (in_array('App\SmStudentCategory', @$copy_with_bage)) selected @endif
                                                        @endif >@lang('student.student_category')</option>
                                                    <option value="App\SmFeesGroup"
                                                        @if (isset($bage)) @if (in_array('App\SmFeesGroup', @$copy_with_bage)) selected @endif
                                                        @endif >@lang('fees.fees_group')</option>
                                                    <option value="App\SmLeaveType"
                                                        @if (isset($bage)) @if (in_array('App\SmLeaveType', @$copy_with_bage)) selected @endif
                                                        @endif >@lang('leave.leave_type')</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        $tooltip = '';
                                        if (userPermission('academic-year-store')) {
                                            $tooltip = '';
                                        } else {
                                            $tooltip = 'You have no permission to add';
                                        }
                                    @endphp
                                    <div class="row mt-15">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip"
                                                title="{{ @$tooltip }}">
                                                <span class="ti-check"></span>
                                                @if (isset($bage))
                                                    @lang('common.update')
                                                @else
                                                    @lang('common.save')
                                                @endif

                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>

                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title">
                                    <h3 class="mb-15"> @lang('system_settings.bage_list')</h3>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id" class="table" cellspacing="0" width="100%">

                                        <thead>
                                            <tr>
                                                <th>@lang('common.year')</th>
                                                <th>@lang('common.title')</th>
                                                <th>@lang('system_settings.starting_date')</th>
                                                <th>@lang('system_settings.ending_date')</th>
                                                <th>@lang('common.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (academicYears() as $bage)
                                                <tr>
                                                    <td>{{ @$bage->title }}</td>
                                                    <td>
                                                        <x-drop-down>
                                                            @if (userPermission('academic-year-edit'))
                                                                <a class="dropdown-item"
                                                                    href="{{ route('academic-year-edit', [@$bage->id]) }}">@lang('common.edit')</a>
                                                            @endif
                                                            @if (userPermission('academic-year-delete'))
                                                                <a class="dropdown-item" data-toggle="modal"
                                                                    data-target="#deleteAcademicYearModal{{ @$bage->id }}"
                                                                    href="#">@lang('common.delete')</a>
                                                            @endif
                                                        </x-drop-down>
                                                    </td>
                                                </tr>
                                                <div class="modal fade admin-query"
                                                    id="deleteAcademicYearModal{{ @$bage->id }}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">@lang('system_settings.delete_bage')</h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="text-center">
                                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                                    <h5 class="text-danger">( @lang('system_settings.bage_delete_confirmation') )</h5>
                                                                </div>

                                                                <div class="mt-40 d-flex justify-content-between">
                                                                    <button type="button" class="primary-btn tr-bg"
                                                                        data-dismiss="modal">@lang('common.cancel')</button>

                                                                    {{ Form::open(['route' => ['academic-year-delete', @$bage->id], 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                                    <button class="primary-btn fix-gr-bg"
                                                                        type="submit">@lang('common.delete')</button>

                                                                    {!! Form::close() !!}
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </x-table>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
@endsection

@include('backEnd.partials.multi_select_js')
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.date_picker_css_js')
