@extends('backEnd.master')
@section('title')
Add Scholarship
@endsection

@push('css')
<style>
    div#table_id_wrapper {
        margin-top: 20px;
    }

    #statusFilterDropdown {
        position: absolute;
        top: 20px;
        left: 10px !important;
        width: 150px;
        margin-top: 3px;
        padding: 8px 8px 4px 8px;
        border: 0;
        background-color: white;
        overflow: hidden;
        z-index: 2002;
        border-radius: 5px;
        box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.3);
    }


    #statusFilterIcon {
        cursor: pointer;
        font-size: medium;
    }


    #statusFilterDropdown .dropdown-item {

        align-items: center;
    }


    #dateFilterSection {
        padding: 5px 10px;
        border-radius: 5px;

        position: relative;
        margin-top: 10px;
        width: auto;
        margin-left: 10px;
        z-index: 2001;
    }


    .daterangepicker {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 9999;
        background-color: white;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        border-radius: 5px;
        padding: 10px;
        display: block;
    }

    .daterangepicker .ranges {
        margin-top: 10px;
    }

    .daterangepicker .ranges li {
        cursor: pointer;
        padding: 8px;

        border-radius: 4px;
        margin-bottom: 5px;
        transition: background-color 0.3s ease;
    }

    .daterangepicker .ranges li:hover {
        background-color: #c9f7f9;
    }
</style>
@endpush

@section('mainContent')
<section class="sms-breadcrumb mb-20">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('communicate.Stipend Records')</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('communicate.Stipend')</a>
                <a href="#">@lang('communicate.Stipend Records')</a>
            </div>
        </div>
    </div>
</section>

<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="white-box">
            <div class="row">
                <div class="col-lg-12">
                    <x-table>
                        <i class="ti-filter" id="statusFilterIcon" style="font-size: medium;"></i>
                        <div id="statusFilterDropdown" class="dropdown-menu">
                            <div>
                                <h5>Status</h5>
                                <h6 class="dropdown-item" data-status="paid">Paid</h6>
                                <h6 class="dropdown-item" data-status="partial">Partial</h6>
                                <h6 class="dropdown-item" data-status="unpaid">Unpaid</h6>
                            </div>
                            <h5>Date</h5>
                            <div class="dropdown-item" id="dateFilterSection">
                                <h6 id="awardedDateInput">Select Date</h6>
                            </div>
                        </div>

                        <table id="table_id" class="table data-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>@lang('common.sl')</th>
                                    <th>@lang('communicate.Student Name')</th>
                                    <th>@lang('communicate.Class')</th>
                                    <th>@lang('communicate.Section')</th>
                                    <th>@lang('communicate.Stipend Amount')</th>
                                    <th>@lang('common.status')</th>
                                    <th>@lang('common.date')</th>
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
</section>
<div class="modal fade admin-query" id="deleteAdmissionFeesPayment" tabindex="-1" aria-labelledby="deleteAdmissionFeesPaymentLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('fees::feesModule.delete_fees_invoice')</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h4>@lang('common.are_you_sure_to_delete')</h4>
                </div>
                <div class="mt-40 d-flex justify-content-between">
                    <button type="button" class="primary-btn tr-bg" data-bs-dismiss="modal">@lang('common.cancel')</button>
                    {{ Form::open(['method' => 'POST', 'route' => 'stipend-records-delete']) }}
                    <input type="hidden" name="feesInvoiceId" value="">
                    <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>





@endsection

@include('backEnd.partials.data_table_js')
@include('backEnd.partials.date_picker_css_js')
@include('backEnd.partials.date_range_picker_css_js')
@include('backEnd.partials.server_side_datatable')

@push('script')
<script type="text/javascript" src="{{ url('Modules/Fees/Resources/assets/js/app.js') }}"></script>

<script>
    $(document).ready(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('stipend-records-datatable') }}",
                type: 'GET',
                data: function(d) {
                    if (window.selectedStatus) {
                        d.status_filter = window.selectedStatus;
                    }

                    if ($('#awardedDateInput').val()) {
                        d.awarded_date = $('#awardedDateInput').val();
                    }
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                {
                    data: 'student_name',
                    name: 'student_name'
                },
                {
                    data: 'class',
                    name: 'class'
                },
                {
                    data: 'section',
                    name: 'section'
                },
                {
                    data: 'stipend_amount',
                    name: 'stipend_amount'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'awarded_date',
                    name: 'awarded_date'
                },
                {
                    data: 'action',
                    name: 'action',

                }
            ],
            bLengthChange: false,
            bDestroy: true,
            language: {
                search: "<i class='ti-search'></i>",
                searchPlaceholder: 'Quick Search',
                paginate: {
                    next: "<i class='ti-arrow-right'></i>",
                    previous: "<i class='ti-arrow-left'></i>"
                }
            },
            dom: "Bfrtip",
            buttons: [{
                    extend: "copyHtml5",
                    text: '<i class="fa fa-files-o"></i>',
                    titleAttr: 'Copy'
                },
                {
                    extend: "excelHtml5",
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Export to Excel'
                },
                {
                    extend: "csvHtml5",
                    text: '<i class="fa fa-file-text-o"></i>',
                    titleAttr: 'Export to CSV'
                },
                {
                    extend: "pdfHtml5",
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    titleAttr: 'Export to PDF',
                    orientation: "landscape",
                    pageSize: "A4"
                },
                {
                    extend: "print",
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: 'Print'
                },
                {
                    extend: "colvis",
                    text: '<i class="fa fa-columns"></i>',
                    postfixButtons: ["colvisRestore"]
                }
            ],
            responsive: true
        });


        $('#statusFilterIcon').on('click', function(e) {
            e.stopPropagation();
            $('#statusFilterDropdown').toggle();
        });

        $('#statusFilterDropdown').on('click', '.dropdown-item', function(e) {
            e.stopPropagation();
            if ($(this).data('status')) {
                window.selectedStatus = $(this).data('status');
            }
            table.ajax.reload();
            $('#statusFilterDropdown').hide();
        });


        $('#dateFilterSection').on('click', function(e) {
            e.stopPropagation();
        });

        $('#awardedDateInput').daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'YYYY-MM-DD',
                cancelLabel: 'Clear'
            },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        });

        $('#awardedDateInput').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
            table.ajax.reload();
        });

        $('#awardedDateInput').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            table.ajax.reload();
        });
    });

    function admissionfeesInvoiceDelete(id) {
        var modal = $('#deleteAdmissionFeesPayment');
        modal.find('input[name=feesInvoiceId]').val(id);
        modal.modal('show');
    }
</script>
@endpush