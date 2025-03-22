@extends('backEnd.master')
@section('title')
    @lang('rolepermission::role.role_permission')
@endsection
@push('css')
    <style>
        .dataTables_processing {
            display: none !important;
        }

        .dataTables_paginate {
            white-space: nowrap !important;
        }

        .previous {
            display: none !important;
        }

        .dataTables_wrapper .dataTable tr td {
            padding-left: 20px;
        }
    </style>
@endpush

@section('mainContent')
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('rolepermission::role.role_permission') </h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('rolepermission::role.role_permission')</a>
                    <a href="#">@lang('rolepermission::role.role')</a>
                </div>
            </div>
        </div>
    </section>


    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-3">
                    <div class="row">
                        <div class="col-lg-12">
                            @if (isset($role))
                                {{ Form::open([
                                    'class' => 'form-horizontal',
                                    'files' => true,
                                    'route' => 'rolepermission/role-update',
                                    'method' => 'POST',
                                ]) }}
                            @else
                                @if (userPermission('rolepermission/role-store'))
                                    {{ Form::open([
                                        'class' => 'form-horizontal',
                                        'files' => true,
                                        'route' => 'rolepermission/role-store',
                                        'method' => 'POST',
                                    ]) }}
                                @endif
                            @endif
                            <div class="white-box">
                                <div class="main-title">
                                    <h3 class="mb-15">
                                        @if (isset($role))
                                            @lang('rolepermission::role.edit_role')
                                        @else
                                            @lang('rolepermission::role.add_role')
                                        @endif
                                    </h3>
                                </div>

                                <div class="add-visitor">
                                    <div class="row">
                                        <div class="col-lg-12">

                                            <div class="primary_input">
                                                <label class="primary_input_label" for="">@lang('common.name') <span
                                                        class="text-danger"> *</span></label>
                                                <input
                                                    class="primary_input_field form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                    type="text" name="name" autocomplete="off"
                                                    value="{{ isset($role) ? @$role->name : '' }}">
                                                <input type="hidden" name="id"
                                                    value="{{ isset($role) ? @$role->id : '' }}">


                                                @if ($errors->has('name'))
                                                    <span class="text-danger">
                                                        {{ $errors->first('name') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $tooltip = '';
                                        if (userPermission(418)) {
                                            $tooltip = '';
                                        } else {
                                            $tooltip = 'You have no permission to add';
                                        }
                                    @endphp
                                    <div class="row mt-40">
                                        <div class="col-lg-12 text-center">
                                            <button class="primary-btn fix-gr-bg" data-toggle="tooltip"
                                                title="{{ @$tooltip }}">
                                                <span class="ti-check"></span>
                                                {{ !isset($role) ? 'save' : 'update' }}

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
                                    <h3 class="mb-15">@lang('rolepermission::role.role_list')</h3>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <table id="role-listing-table" class="display">
                                    <thead>
                                        <tr>
                                            <th scope="col">S.No</th>
                                            <th scope="col">@lang('rolepermission::role.role')</th>
                                            <th scope="col">@lang('common.type')</th>
                                            <th scope="col">@lang('common.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#role-listing-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('school.based.rolelist') }}",
                    type: 'GET'
                },
                columns: [{
                        data: null,
                        name: 'index',
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'type',
                        name: 'type',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],

                info: true,
                pageLength: 10,
                lengthChange: false,
                autoWidth: false,
                ordering: false,
                searching: false,
                responsive: true
            });
        });


        $(document).on('click', '.roleDeleteClass', function(e) {
            var get_id = $(this).data('id');
            $('#deletePopupClose' + get_id).click();
            var role_listing_table = $("#role-listing-table").DataTable();
            var role_listing_url = "{{ route('school.based.rolelist') }}";
            $.ajax({
                url: "{{ route('school.based.roledelete') }}",
                method: 'GET',
                data: {
                    id: get_id
                },
                success: function(response) {
                    if (response.status === 'success') {
                        role_listing_table.ajax.url(role_listing_url).load();
                        toastr.success(response.message);
                    }
                }
            });
        });
    </script>
@endpush
