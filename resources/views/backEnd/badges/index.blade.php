@extends('backEnd.master')
@section('title')
    @lang('admin.badge_list')
@endsection
@section('mainContent')

    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('admin.badge_list')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('dormitory.dormitory')</a>
                    <a href="#">@lang('admin.badge_list')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_st_admin_visitor">
        <div class="container-fluid p-0">
            @if (isset($badge))
                @if (userPermission('badge-store'))
                    <div class="row">
                        <div class="offset-lg-10 col-lg-2 text-right col-md-12 mb-20">
                            <a href="{{ route('badges') }}" class="primary-btn small fix-gr-bg">
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
                            @if (isset($badge))
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => ['badge-update', $badge->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) }}
                            @else
                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'badge-store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
                            @endif
                            <div class="white-box">
                                <div class="main-title">
                                    <h3 class="mb-15">
                                        @if (isset($badge))
                                            @lang('admin.edit_badge')
                                        @else
                                            @lang('admin.add_badge')
                                        @endif
                                    </h3>
                                </div>
                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('admin.badge_name') <span
                                                        class="text-danger"> *</span></label>
                                                <input
                                                    class="primary_input_field form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                    type="text" name="name" autocomplete="off"
                                                    value="{{ isset($badge) ? $badge->name : old('name') }}">
                                                <input type="hidden" name="id"
                                                    value="{{ isset($badge) ? $badge->id : '' }}">
                                                @if ($errors->has('name'))
                                                    <span class="text-danger">
                                                        {{ $errors->first('name') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('common.description')
                                                    <span></span></label>
                                                <textarea class="primary_input_field form-control" cols="0" rows="4" name="description">{{ isset($badge) ? $badge->description : old('description') }}</textarea>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row mt-25">
                                        <div class="col-lg-12">
                                            <label class="primary_input_label" for="active_status">@lang('common.status')
                                                <span></span></label>
                                            <select
                                                class="primary_select form-control{{ $errors->has('active_status') ? ' is-invalid' : '' }}"
                                                name="active_status" id="active_status">
                                                <option data-display="@lang('student.status') *" value="">
                                                    @lang('student.status') *</option>
                                                <option value="1"
                                                    {{ isset($badge) ? ($badge->active_status == 1 ? 'selected' : '') : '' }}>
                                                    @lang('common.active')</option>
                                                <option value="0"
                                                    {{ isset($badge) ? ($badge->active_status == 0 ? 'selected' : '') : '' }}>
                                                    @lang('common.inactive')</option>
                                            </select>
                                            @if ($errors->has('active_status'))
                                                <span class="text-danger invalid-select d-block" role="alert">
                                                    {{ $errors->first('active_status') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div> --}}
                                    <div class="row mt-15">
                                        <div class="col-lg-12">
                                            <div class="primary_input">
                                                <label>
                                                    {{ __('common.image') }}
                                                    <span class="text-danger"> *</span>
                                                </label>
                                                <div class="primary_file_uploader">
                                                    <input class="primary_input_field" type="text"
                                                        id="placeholderBadgeImage"
                                                        placeholder="{{ isset($badge->image) && $badge->image != '' ? getFilePath3($badge->image) : __('common.photo') . '*' }}"
                                                        disabled>
                                                    <button class="" type="button">
                                                        <label class="primary-btn small fix-gr-bg"
                                                            for="addBadgeImage">{{ __('common.browse') }}</label>
                                                        <input type="file" class="d-none" name="image"
                                                            id="addBadgeImage">
                                                    </button>
                                                </div>
                                                <span class="text-danger">{{ $errors->first('image') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-25 text-center">
                                            <img class="previewImageSize {{ @$badge->image ? '' : 'd-none' }}"
                                                src="{{ @$badge->image ? asset($badge->image) : '' }}" alt=""
                                                id="badgeImageShow" height="100%" width="100%">
                                        </div>
                                    </div>
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip"
                                                title="{{ @$tooltip }}">
                                                <span class="ti-check"></span>
                                                @if (isset($badge))
                                                    @lang('admin.update_badge')
                                                @else
                                                    @lang('admin.save_badge')
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
                                    <h3 class="mb-15"> @lang('admin.badge_list')</h3>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <x-table>
                                    <table id="table_id" class="table" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>@lang('common.sl')</th>
                                                <th>@lang('common.image')</th>
                                                <th>@lang('admin.badge_name')</th>
                                                <th>@lang('common.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($badges as $key => $badge)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td> <img class="student-meta-img img-100"
                                                            src="{{ asset($badge->image) }}" alt=""></td>
                                                    <td>{{ @$badge->name }}</td>
                                                    <td>
                                                        <x-drop-down>

                                                            <a class="dropdown-item"
                                                                href="{{ route('badge-edit', [$badge->id]) }}">@lang('common.edit')</a>

                                                            <a class="dropdown-item" data-toggle="modal"
                                                                data-target="#deleteDormitoryListModal{{ @$badge->id }}"
                                                                href="#">@lang('common.delete')</a>

                                                        </x-drop-down>
                                                    </td>
                                                </tr>
                                                <div class="modal fade admin-query"
                                                    id="deleteDormitoryListModal{{ @$badge->id }}">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">@lang('dormitory.delete_dormitory')</h4>
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="text-center">
                                                                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                                                                </div>
                                                                <div class="mt-40 d-flex justify-content-between">
                                                                    <button type="button" class="primary-btn tr-bg"
                                                                        data-dismiss="modal">@lang('common.cancel')</button>
                                                                    {{ Form::open(['route' => ['badge-delete', $badge->id], 'method' => 'DELETE', 'enctype' => 'multipart/form-data']) }}
                                                                    <button class="primary-btn fix-gr-bg"
                                                                        type="submit">@lang('common.delete')</button>
                                                                    {{ Form::close() }}
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
            </div>
        </div>
    </section>
@endsection
@include('backEnd.partials.data_table_js')

@section('script')
    <script src="{{ asset('public/backEnd/') }}/js/croppie.js"></script>
    <script src="{{ asset('public/backEnd/') }}/js/st_addmision.js"></script>
    <script>
        $(document).ready(function() {
            function getFileName(value, placeholder) {
                if (value) {
                    var startIndex = (value.indexOf('\\') >= 0 ? value.lastIndexOf('\\') : value.lastIndexOf('/'));
                    var filename = value.substring(startIndex);
                    if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                        filename = filename.substring(1);
                    }
                    $(placeholder).attr('placeholder', '');
                    $(placeholder).attr('placeholder', filename);
                }
            }
        });

        $(document).on('change', '#addBadgeImage', function(event) {
            $('#badgeImageShow').removeClass('d-none');
            getFileName($(this).val(), '#placeholderBadgesName');
            imageChangeWithFile($(this)[0], '#badgeImageShow');
        });
    </script>
@endsection
