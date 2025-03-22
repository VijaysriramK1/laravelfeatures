@extends('backEnd.master')
@section('title')
@lang('fees::feesModule.view_fees_invoice')
@endsection
@section('mainContent')
@push('css')
<link rel="stylesheet" href="{{url('Modules\Fees\Resources\assets\css\feesStyle.css')}}" />
<style>
    .margin_auto {
        margin-left: auto;
        margin-right: 0
    }

    html[dir="rtl"] .margin_auto {
        margin-left: 0;
        margin-right: auto;
    }

    html[dir="rtl"] .address_text p {
        margin-right: auto;
        margin-left: 0;
    }

    html[dir="rtl"] .total_count {
        margin-right: auto;
        margin-left: 0;
    }

    .invoice_wrapper {
        overflow: auto;
    }

    .table {
        min-width: 600px;
    }
</style>
@endpush

<section class="sms-breadcrumb mb-20">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>Stipend Invoice Issued To</h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">ScholarShip</a>
                <a href="">Stipend Records</a>
                <a href="#">View Stipend Records</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="max_1200 text-right">
        <a href="{{route('stipend-records-view',['id'=>$invoiceInfo->id,'state'=>'print'])}}" class="primary-btn small fix-gr-bg" target="_blank">
            <span class="ti-printer pr-2"></span>
            @lang('common.print')
        </a>
    </div>
    <div class="invoice_wrapper">
        <!-- invoice print part here -->
        <div class="invoice_print">
            <div class="container">
                <div class="invoice_part_iner">
                    <table class="table">
                        <thead>
                            <td>
                                <div class="logo_img">
                                    <img src="{{asset($generalSetting->logo)}}" alt="{{$generalSetting->school_name}}">
                                </div>
                            </td>
                            <td class="virtical_middle address_text">
                                <p>{{$generalSetting->school_name}}</p>
                                <p>{{$generalSetting->phone}}</p>
                                <p>{{$generalSetting->email}}</p>
                                <p>{{$generalSetting->address}}</p>
                            </td>
                        </thead>
                    </table>
                    <!-- middle content  -->
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <!-- single table  -->
                                    <table class="mb_30">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="addressleft_text">
                                                        <p><span>Stipend Invoice Issued To</p>
                                                        <p><span><strong>@lang('student.student_name') </span> <span class="nowrap">: {{ @$invoiceInfo->student->full_name }}</span> </strong></p>
                                                        <p><span>@lang('student.class_section')</span> <span>: {{$invoiceInfo->record->class->class_name}}({{$invoiceInfo->record->section->section_name}})</span> </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--/ single table  -->
                                </td>
                                <td>
                                    <table class="mb_30 margin_auto">
                                        <tbody>
                                            <tr>
                                                <td>

                                                    <div>
                                                        <p>
                                                            <strong>Scholarship Name</strong>:
                                                            <span>{{ optional(optional($invoiceInfo->stipends)->scholarship)->name ?? 'N/A' }}</span>
                                                        </p>


                                                        <p><span>@lang('fees.create_date') </span> <span>: {{dateConvert($invoiceInfo->start_date ?? 'N/A')}}</span> </p>
                                                        <p><span>@lang('fees.due_date') </span> <span>: {{dateConvert($invoiceInfo->end_date ?? 'N/A')}}</span> </p>
                                                        <p>
                                                            <span>@lang('fees.payment_status')</span>
                                                            <span>: {{ $status_text }}</span>
                                                        </p>

                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- invoice print part end -->
        <table class="table border_table mb_30 description_table">
            <thead>
                <tr>
                    <th>@lang('common.sl')</th>
                    <th>ScholarShip Name</th>
                    <th>ScholarShip Amount</th>
                    <th>Spitend Amount</th>

                    <th>@lang('fees::feesModule.paid_amount')</th>
                    <th class="text-right">balance</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($invoiceDetails as $key=>$invoiceDetail)

                <tr>
                    <td>{{$key+1}}</td>
                    <td>
                        {{@$invoiceDetail->scholarship->name}}

                    </td>
                    <td>
                        {{@$invoiceDetail->scholarship->coverage_type}}<br style="text-align: center;">
                        {{@$invoiceDetail->scholarship->coverage_amount}}
                    </td>
                    <td>
                        {{@$invoiceDetail->stipend_amount}}
                    </td>
                    <td>{{ $invoiceInfo->amount ?? 0}}</td>
                    <td style="text-align: end;">
                        {{ (optional($invoiceDetail)->stipend_amount ?? 0) - ($invoiceInfo->amount ?? 0) }} <!-- Subtract stipend_amount from amount -->
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                @php
                $totalStipendAmount = $invoiceDetails->sum('stipend_amount');
                $totalPaidAmount = $invoiceInfo->sum('amount') ?? 0;
                $dueBalance = ($totalStipendAmount ?? 0) - ($totalPaidAmount ?? 0);
                @endphp
                <tr>
                    <td colspan="5"></td>
                    <td colspan="2">
                        <p class="total_count"><span>@lang('fees::feesModule.total_amount')</span> <span> {{@$totalStipendAmount}}</span></p>
                    </td>
                </tr>



                <tr>
                    <td colspan="5"></td>
                    <td colspan="2">
                        <p class="total_count"><span>@lang('fees::feesModule.total_paid')</span> <span>{{ @$totalPaidAmount}}</span></p>
                    </td>
                </tr>

                <tr>
                    <td colspan="5"></td>
                    <td colspan="2">
                        <p class="total_count"><span><strong>@lang('fees::feesModule.due_balance')</span> <span>
                                {{ @$dueBalance }}
                                </strong></span></p>
                    </td>
                </tr>
            </tfoot>
        </table>

        @if($banks)
        <div class="col-lg-12">
            @if(@$invoiceDetail =='Bank')
            <table class="table border_table mb_30 description_table">
                <thead>
                    <tr>
                        <th>@lang('common.sl')</th>
                        <th>@lang('accounts.bank_name')</th>
                        <th>@lang('accounts.account_name')</th>
                        <th>@lang('accounts.account_number')</th>
                        <th>@lang('accounts.account_type')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banks as $key=>$bank)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$bank->bank_name}}</td>
                        <td>{{$bank->account_name}}</td>
                        <td>{{$bank->account_number}}</td>
                        <td>{{$bank->account_type}}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
            @else
            @endif
        </div>
        @endif
    </div>
</section>
@endsection
@push('script')
<script>
    $('[data-tooltip="tooltip"]').tooltip();
</script>
@endpush