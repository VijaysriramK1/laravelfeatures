<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Student Invoice Details</title>
</head>

<body>
    <div class="container mt-3">

        <div class="row gx-5">
            <div class="col">
                <div class="p-3">
                    <div class="logo_img">
                        <img src="{{ url('public/uploads/settings/logo.png') }}" alt="logo" style="width: 230px;">
                    </div>
                </div>
            </div>
            <div class="col d-flex justify-content-end">
                <div class="p-3">
                    <p>
                    <h5>School Details</h5>
                    </p>
                    <p><span><span style="font-weight: 500;">Name</span> <span class="nowrap">:
                                <span>{{ $generalSetting->school_name ?? '' }}</span></span>
                    </p>
                    <p><span><span style="font-weight: 500;">Phone</span> <span class="nowrap">:
                                <span>{{ $generalSetting->phone ?? '' }}</span></span>
                    </p>
                    <p><span><span style="font-weight: 500;">Email</span> <span class="nowrap">:
                                <span>{{ $generalSetting->email ?? '' }}</span></span>
                    </p>
                </div>
            </div>
        </div>


        <div class="row gx-5">
            <div class="col">
                <div class="p-3">
                    <p>
                    <h5>Student Details</h5>
                    </p>
                    <p><span><span style="font-weight: 500;">Student Name</span> <span class="nowrap">:
                                <span>{{ $studentDetails->name ?? '' }}</span></span>
                    </p>
                    <p><span style="font-weight: 500;">Class</span> <span>:
                            {{ $studentDetails->class_name ?? '' }}</span>
                    </p>
                    <p><span style="font-weight: 500;">Mobile Number</span> <span>:
                            {{ $studentDetails->phone ?? '' }}</span>
                    </p>
                </div>
            </div>
            <div class="col d-flex justify-content-end">
                <div class="p-3">
                    <p>
                    <h5>Invoice Details</h5>
                    </p>
                    <p><span style="font-weight: 500;">@lang('fees.invoice_number')</span> <span>:
                            {{ $invoiceInfo->invoice_id ?? '' }}</span>
                    </p>
                    <p><span style="font-weight: 500;">@lang('fees.create_date') </span> <span>:
                            {{ dateConvert($invoiceInfo->create_date ?? '') }}</span>
                    </p>
                </div>
            </div>
        </div>


        <div class="mt-3">
            <table class="table border">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Fine</th>
                        <th scope="col">Paid Amount</th>
                        <th scope="col">Payment status</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>1</td>
                        <td>{{ $invoiceDetails->amount ?? '--' }}</td>
                        <td>{{ $invoiceDetails->fine ?? '--' }}</td>
                        <td>{{ $invoiceDetails->paid_amount ?? '--' }}</td>
                        <td>{{ $invoiceInfo->payment_status ?? 'Unpaid' }}</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
