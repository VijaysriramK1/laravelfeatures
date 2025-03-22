@extends('backEnd.master')

@section('title')
    @lang('Lead Integration')
@endsection

@section('mainContent')
<section class="sms-breadcrumb mb-20 up_breadcrumb">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('Lead Integration')</h1>
            <div class="bc-pages">
                <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                <a href="#">@lang('admin.admin_section')</a>
                <a href="#">@lang('Lead Integration')</a>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-title">
                <!-- <h3>@lang('Lead Integration')</h3> -->
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                   <a href="{{route('lead_integration')}}"> <button class="nav-link " id="nav-general-tab" data-bs-toggle="tab" data-bs-target="#nav-general" type="button" role="tab" aria-controls="nav-general" aria-selected="true"><b>General</b></button></a>
                   <a href="{{route('lead_integration_code-index')}}"> <button class="nav-link" id="nav-integration-code-tab" data-bs-toggle="tab" data-bs-target="#nav-integration-code" type="button" role="tab" aria-controls="nav-integration-code" aria-selected="false"><b>Integration Code</b></button></a>
                   <a href="{{route('source-index')}}"> <button class="nav-link active" id="nav-Sources-tab" data-bs-toggle="tab" data-bs-target="#nav-Sources" type="button" role="tab" aria-controls="nav-Sources" aria-selected="false"><b>Sources</b></button></a>
                   <a href="{{route('status-index')}}"> <button class="nav-link" id="nav-Status-tab" data-bs-toggle="tab" data-bs-target="#nav-Status" type="button" role="tab" aria-controls="nav-Status" aria-selected="false"><b>Status</b></button></a>
                </div>
            </nav><br>
           
                                    <!-- Sources Tab Content -->
                                    
                        <div class="container-fluid p-0">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            @if (isset($source))
                                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => ['source-update', $source->id], 'method' => 'PUT']) }}
                                            @else
                                                {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'source-store', 'method' => 'POST']) }}
                                            @endif
                                            <div class="white-box">
                                                <div class="main-title">
                                                    <h3 class="mb-15">
                                                        @if (isset($source))
                                                            @lang('Edit Source')
                                                        @else
                                                            @lang('Add Source')
                                                        @endif
                                                    </h3>
                                                </div>
                                                <div class="add-visitor">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="primary_input">
                                                                <label class="primary_input_label" for="name">@lang('Source Title') <span class="text-danger"> *</span></label>
                                                                <input
                                                                    class="primary_input_field form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                                    type="text" name="name" id="name" autocomplete="off"
                                                                    value="{{ isset($source) ? $source->name : old('name') }}">
                                                                <input type="hidden" name="type" value="3">
                                                                @if ($errors->has('name'))
                                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-40">
                                                        <div class="col-lg-12 text-center">
                                                            <button class="primary-btn fix-gr-bg submit" data-toggle="tooltip" title="{{ @$tooltip }}">
                                                                <span class="ti-check"></span>
                                                                @if (isset($source))
                                                                    @lang('Update Source')
                                                                @else
                                                                    @lang('Save Source')
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
                                                    <h3 class="mb-15"> @lang('Source List')</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <x-table>
                                                    <table id="table_id" class="table" cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>SL</th>
                                                                <th>Source Name</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($sources as $key => $source)
                                                                <tr>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td>{{ $source->name }}</td>
                                                                    <td>
                                                                        <x-drop-down>
                                                                            <a class="dropdown-item" href="{{ route('source-edit', [$source->id]) }}">Edit</a>
                                                                            <a class="dropdown-item" data-toggle="modal" data-target="#deleteDormitoryListModal{{ $source->id }}" href="#">Delete</a>
                                                                        </x-drop-down>
                                                                    </td>
                                                                </tr>
                                                                <div class="modal fade admin-query" id="deleteDormitoryListModal{{ $source->id }}">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Delete Source</h4>
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="text-center">
                                                                                    <h4>Are you sure to delete this Source ?</h4>
                                                                                </div>
                                                                                <div class="mt-40 d-flex justify-content-between">
                                                                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">Cancel</button>
                                                                                    {{ Form::open(['route' => ['source-delete', $source->id], 'method' => 'DELETE']) }}
                                                                                        <button class="primary-btn fix-gr-bg" type="submit">Delete</button>
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

            </div>
        </div>
    </div>
</div>
@endsection

@include('backEnd.partials.date_picker_css_js')
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')
@section('script')
  
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

@endsection





