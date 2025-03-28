@push('css')
<link rel="stylesheet" href="{{ url('Modules\Fees\Resources\assets\css\feesStyle.css') }}" />
@endpush
@if (!userPermission('fees.fees-invoice-store'))
@push('css')
<style>
    div#table_id_wrapper {
        margin-top: 40px;
    }
</style>
@endpush
@endif
<section class="sms-breadcrumb mb-20">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('fees::feesModule.fees_invoice')</h1>
            <div class="bc-pages">
                <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                <a href="#">@lang('fees.fees')</a>
                <a href="#">@lang('fees::feesModule.fees_invoice')</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        <div class="white-box">
            @if (isset($role) && $role == 'admin')
            @if (userPermission('fees.fees-invoice-store'))
            <div class="row">
                <div class="col-lg-12 text-left col-md-12">
                    <a href="{{ route('admission_fees') }}" class="primary-btn small fix-gr-bg">
                        <span class="ti-plus pr-2"></span>
                        @lang('common.add')
                    </a>
                </div>
            </div>
            @endif
            @endif
            <div class="row">

                @if ((isset($role) && $role == 'admin') || $role == 'lms')
                <div class="col-lg-12">
                    <x-table>
                        <table id="table_id" class="table data-table" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>@lang('common.sl')</th>
                                    <th>  @lang('communicate.student name')</th>
                                    <th>@lang('accounts.amount')</th>
                                    <th>@lang('fees.paid')</th>
                                    <th>@lang('accounts.balance')</th>
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
                @else
                <div class="col-lg-12 student-details up_admin_visitor mt-0">
                    <ul class="nav nav-tabs tabs_scroll_nav mt-0 ml-0" role="tablist">
                        @foreach ($records as $key => $record)
                        <li class="nav-item mb-0">
                            <a class="nav-link mb-0 @if ($key == 0) active @endif "
                                href="#tab{{ $key }}" role="tab"
                                data-toggle="tab">{{ moduleStatusCheck('University') ? $record->unSemesterLabel->name : $record->class->class_name }}
                                ({{ $record->section->section_name }})
                            </a>
                        </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" style="margin-top:70px">
                        @foreach ($records as $key => $record)
                        <div role="tabpanel" class="tab-pane fade  @if ($key == 0) active show @endif" id="tab{{ $key }}">
                            <x-table>
                                <table id="table_id" class="table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('common.sl')</th>
                                            <th>Title</th>
                                            <th>@lang('accounts.amount')</th>
                                            <th>@lang('fees.paid')</th>
                                            <th>@lang('accounts.balance')</th>
                                            <th>@lang('common.status')</th>
                                            <th>@lang('common.date')</th>
                                            <th>@lang('common.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($record->feesInvoice as $key => $studentInvoice)
                                        @php
                                        $amount = $studentInvoice->Tamount;
                                        $weaver = $studentInvoice->Tweaver;
                                        $fine = $studentInvoice->Tfine;
                                        $paid_amount = $studentInvoice->Tpaidamount;
                                        $balance = $amount + $fine - ($paid_amount + $weaver);
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <a href="{{ route('fees.fees-invoice-view', ['id' => $studentInvoice->id, 'state' => 'view']) }}" target="_blank">
                                                    {{ e(@$studentInvoice->studentInfo->title) }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ @$studentInvoice->recordDetail->class->class_name }}
                                                ({{ @$studentInvoice->recordDetail->section->section_name }})
                                            </td>
                                            <td>{{ $amount }}</td>
                                            <td>{{ $weaver }}</td>
                                            <td>{{ $fine }}</td>
                                            <td>{{ $paid_amount }}</td>
                                            <td>{{ $balance }}</td>
                                            <td>
                                                @if ($balance ==0)
                                                <button class="primary-btn small bg-success text-white border-0">@lang('fees.paid')</button>
                                                @else
                                                @if ($paid_amount >0)
                                                <button class="primary-btn small bg-warning text-white border-0">@lang('fees.partial')</button>
                                                @else
                                                <button class="primary-btn small bg-danger text-white border-0">@lang('fees.unpaid')</button>
                                                @endif
                                                @endif
                                            </td>
                                            <td>{{ dateConvert($studentInvoice->created_at) }}</td>
                                            <td>
                                                <x-drop-down>
                                                    <a class="dropdown-item" href="{{ route('fees.admissionfees-invoice-view', ['id' => $InvoiceInfo->id, 'state' => 'view']) }}">
                                                        @lang('common.view')
                                                    </a>
                                                    @if ($balance = 0)
                                                    <a class="dropdown-item" href="{{ route('fees.student-fees-payment', $studentInvoice->id) }}">
                                                        @lang('inventory.add_payment')
                                                    </a>
                                                    @endif
                                                </x-drop-down>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </x-table>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Delete Modal Start --}}
<div class="modal fade admin-query"
    id="deleteAdmissionFeesPayment">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('fees::feesModule.delete_fees_invoice')</h4>
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
                    {{ Form::open(['method' => 'POST', 'route' => 'admissionfees-invoice-delete']) }}
                    <input type="hidden" name="feesInvoiceId" value="">
                    <button class="primary-btn fix-gr-bg" type="submit">@lang('common.delete')</button>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Delete Modal End --}}

{{-- View Fees Modal Start --}}
<div class="modal fade admin-query" id="viewFeesPayment">
    <div class="modal-dialog modal-dialog-centered max_modal">
        <div class="modal-content">
        </div>
    </div>
</div>
{{-- View Fees Modal End --}}

@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')
<script>
   function admissionfeesInvoiceDelete(id) {
    var modal = $('#deleteAdmissionFeesPayment');
    modal.find('input[name=feesInvoiceId]').val(id);
    modal.modal('show');
}

    function admissionviewPaymentDetailModal(id) {
        $('#viewFeesPayment').modal('show');
        let invoiceId = id;
        console.log(invoiceId);
        $.ajax({
            url: "{{ route('fees.admission-fees-view-payment') }}",
            method: "POST",
            data: {
                invoiceId: invoiceId
            },
            success: function(response) {
                $('#viewFeesPayment .modal-content').html(response);
            },
        });
    }
    $(document).ready(function() {
    $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('fees.admission-fees-invoice-datatable') }}",
            type: 'GET'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'id' },
            { data: 'student name', name: 'student name' },
            { data: 'amount', name: 'amount' },
            { data: 'paid_amount', name: 'paid_amount' },
            { data: 'balance', name: 'balance' },
            { data: 'status', name: 'status' },
            { data: 'created_date', name: 'created_date' },
            { data: 'action', name: 'action' }
        ],
        
        bLengthChange: false,
        bDestroy: true,
        language: {
            search: "<i class='ti-search'></i>",
            searchPlaceholder: window.jsLang('quick_search'),
            paginate: {
                next: "<i class='ti-arrow-right'></i>",
                previous: "<i class='ti-arrow-left'></i>",
            }
        },
        dom: "Bfrtip",
        buttons: [
            { extend: "copyHtml5", text: '<i class="fa fa-files-o"></i>', title: $("#logo_title").val(), titleAttr: window.jsLang('copy_table'), exportOptions: { columns: ':visible:not(.not-export-col)' } },
            { extend: "excelHtml5", text: '<i class="fa fa-file-excel-o"></i>', titleAttr: window.jsLang('export_to_excel'), title: $("#logo_title").val(), margin: [10, 10, 10, 0], exportOptions: { columns: ':visible:not(.not-export-col)' } },
            { extend: "csvHtml5", text: '<i class="fa fa-file-text-o"></i>', titleAttr: window.jsLang('export_to_csv'), exportOptions: { columns: ':visible:not(.not-export-col)' } },
            { extend: "pdfHtml5", text: '<i class="fa fa-file-pdf-o"></i>', title: $("#logo_title").val(), titleAttr: window.jsLang('export_to_pdf'), exportOptions: { columns: ':visible:not(.not-export-col)' }, orientation: "landscape", pageSize: "A4", margin: [0, 0, 0, 12], alignment: "center", header: true, customize: function(doc) { doc.content[1].margin = [100, 0, 100, 0]; doc.content.splice(1, 0, { margin: [0, 0, 0, 12], alignment: "center", image: "data:image/png;base64," + $("#logo_img").val(), }); doc.defaultStyle = { font: 'DejaVuSans' } } },
            { extend: "print", text: '<i class="fa fa-print"></i>', titleAttr: window.jsLang('print'), title: $("#logo_title").val(), exportOptions: { columns: ':visible:not(.not-export-col)' } },
            { extend: "colvis", text: '<i class="fa fa-columns"></i>', postfixButtons: ["colvisRestore"] }
        ],
        columnDefs: [{ visible: false }],
        responsive: true
    });
});


</script>
