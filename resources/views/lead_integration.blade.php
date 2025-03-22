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
                   <a href="{{route('lead_integration')}}"> <button class="nav-link active" id="nav-general-tab" data-bs-toggle="tab" data-bs-target="#nav-general" type="button" role="tab" aria-controls="nav-general" aria-selected="true"><b>General</b></button></a>
                   <a href="{{route('lead_integration_code-index')}}"> <button class="nav-link" id="nav-integration-code-tab" data-bs-toggle="tab" data-bs-target="#nav-integration-code" type="button" role="tab" aria-controls="nav-integration-code" aria-selected="false"><b>Integration Code</b></button></a>
                   <a href="{{route('source-index')}}"><button class="nav-link" id="nav-Sources-tab" data-bs-toggle="tab" data-bs-target="#nav-Sources" type="button" role="tab" aria-controls="nav-Sources" aria-selected="false"><b>Sources</b></button></a>
                   <a href="{{route('status-index')}}">  <button class="nav-link" id="nav-Status-tab" data-bs-toggle="tab" data-bs-target="#nav-Status" type="button" role="tab" aria-controls="nav-Status" aria-selected="false"><b>Status</b></button></a>
                </div>
            </nav><br>
            <div class="tab-content card" id="nav-tabContent">
                <!-- General Tab Content -->
                <div class="tab-pane fade show active card-body" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab">
                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'lead_integration.store', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'admission-query-store']) }}
                    <div class="row">
                        <div class="col-lg-6 mt-25">
                        <div class="primary_input">
                            <label class="primary_input_label" for="source">@lang('admin.source')</label>
                            <select name="source_id" class="primary_select form-control {{ $errors->has('select_source') ? ' is-invalid' : '' }}">
                                <option data-display="@lang('admin.select_source') " value="">@lang('admin.select_source')</option>
                                @foreach($sources as $source)
                                    <option value="{{ $source->id }}" {{ $storedSourceId == $source->id ? 'selected' : '' }}>{{ $source->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('source_id') }}</span>
                        </div>
                        </div>
                        <div class="col-lg-6 mt-25">
                        <div class="primary_input">
                            <label class="primary_input_label" for="status">@lang('common.status')</label>
                            <select class="primary_select form-control {{ $errors->has('select_status') ? ' is-invalid' : '' }}" name="active_status">
                                <option data-display="@lang('admin.select_status') " value="">@lang('admin.Status') </option>
                                @foreach($status as $statuses)
                                    <option value="{{ $statuses->id }}" {{ $storedStatusId == $statuses->id ? 'selected' : '' }}>{{ $statuses->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">{{ $errors->first('active_status') }}</span>
                        </div>
                        </div>

                        <div class="col-lg-6 mt-25">
                            <div class="primary_input">
                                <label class="primary_input_label" for="source">@lang('Assigned') (Responsible)</label>
                                <select name="assigned_id" class="primary_select form-control {{ $errors->has('select_assigned') ? ' is-invalid' : '' }}">
                                    <option data-display="@lang('Assignee') " value="">@lang('Assignee') </option>
                                    @foreach($assignees as $assignee)
                                    <option value="{{ $assignee->id }}" {{ $storedAssignedId == $assignee->id ? 'selected' : '' }}>{{ $assignee->full_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger">{{ $errors->first('assigned_id') }}</span>
                            </div>
                        </div>

                        <div class="col-lg-12 text-center mt-25">
                            <div class="d-flex justify-content-between">
                                <button type="button" class="primary-btn tr-bg" onclick="window.location='{{ url()->previous() }}'">@lang('admin.cancel')</button>
                                <!-- <button class="primary-btn fix-gr-bg submit" id="save_button_query" type="submit">@lang('admin.save')</button> -->
                                <button class="primary-btn fix-gr-bg submit" id="save_button_query" type="submit">@lang('admin.save')</button>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
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
    <script>
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
        function deleteQueryModal(id) {
            var modal = $('#deleteAdmissionQueryModal');
            modal.find('input[name=id]').val(id)
            modal.modal('show');
        }

        $(document).ready(function() {
            $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                "ajax": $.fn.dataTable.pipeline({
                    url: "{{ url('admission-query-datatable') }}",
                    data: {
                        date_from: $('input[name=date_from]').val(),
                        date_to: $('input[name=date_to]').val(),
                        source: $('input[name=source]').val(),
                        status: $('input[name=status]').val(),
                    },
                    pages: "{{ generalSetting()->ss_page_load }}" // number of pages to cache
                }),
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'source_setup.name',
                        name: 'sourceSetup.name',
                        render: function(data, type, row) {
                                   return data ? data : 'N/A';
                               }
                       
                    },
                    {
                        data: 'query_date',
                        name: 'query_date'
                    },
                    {
                        data: 'follow_up_date',
                        name: 'follow_up_date'
                    },
                    {
                        data: 'next_follow_up_date',
                        name: 'next_follow_up_date'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
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
                            doc.defaultStyle = {
                                font: 'DejaVuSans'
                            }
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
                responsive: true,
            });
        });

    </script>   
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

@endsection





