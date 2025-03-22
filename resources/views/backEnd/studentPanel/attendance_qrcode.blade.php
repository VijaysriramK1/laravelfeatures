@extends('backEnd.master')
@section('title')
    @lang('student.attendance')
@endsection
@section('mainContent')
    <section class="sms-breadcrumb mb-40 white-box">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('student.attendance')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="{{ route('student_my_attendance') }}">@lang('student.attendance')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="main-title">
                        <h3 class="mb-30">Scan QR for Attendance</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="reader" width="500px"></div>
                </div>
                <div class="col-lg-12 start_qr_scan_container">
                    <div class="d-flex flex-column justify-content-center white-box align-items-center"
                        style="height:300px;">
                        <span class="fa fa-qrcode pr-2 mb-2" style="color:#11f511;font-size:60px;"></span>
                        <h2>Scan to add attendance..! </h2>
                        <p class="mb-2">Place submit your attendance for today.</p>
                        <a id="start_qr_scan" class="primary-btn small fix-gr-bg mt-3">
                            <span class="fa fa-qrcode pr-2"></span>
                            Start Scan
                        </a>
                    </div>
                </div>
                <div class="col-lg-12 stop_qr_scan_container mt-2" style="display: none;">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <a id="stop_qr_scan" class="primary-btn small fix-gr-bg">
                            <span class="fa fa-qrcode pr-2"></span>
                            Stop Scan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('script')
    <script src="{{ asset('backEnd/vendors/html5-qrcode/html5-qrcode.min.js') }}" type="text/javascript"></script>
@endpush
@push('script')
    <script>
        $(document).ready(function() {
            var loading = false;
            const html5QrCode = new Html5Qrcode("reader");
            const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                if (loading) return;
                loading = true;
                submitAttendance(decodedText);
                setTimeout(function() {
                    loading = false;
                }, 3000);
            };
            const config = {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                }
            };


            $("#start_qr_scan").click(function() {
                $(".stop_qr_scan_container").show();
                $(".start_qr_scan_container").hide();
                html5QrCode.start({
                    facingMode: "environment"
                }, config, qrCodeSuccessCallback);
            });

            $("#stop_qr_scan").click(function() {
                $(".start_qr_scan_container").show();
                $(".stop_qr_scan_container").hide();
                html5QrCode.stop().then((ignore) => {}).catch((err) => {});
            });


            // var html5QrcodeScanner = new Html5QrcodeScanner(
            //     "reader", {
            //         fps: 10,
            //         qrbox: 250
            //     });
            // html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        });

        function submitAttendance(code) {
            var formdata = {
                'code': code,
            };
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                data: formdata,
                async: false,
                // dataType: "json",
                url: "/student-attendance-qr",
                success: function(data) {
                    // console.log(formdata);
                    $("#stop_qr_scan").trigger('click');
                    toastr.success(data.message);
                    window.location.href = "/student-my-attendance";
                },
                error: function(data) {
                    toastr.error(data.responseJSON.message);
                    // console.log("Error:", data);
                },
                complete: function() {
                    // loading = false;
                }
            });
        }


        function onScanSuccess(decodedText, decodedResult) {
            submitAttendance(decodedText);
            console.log(`Scan result: ${decodedText}`, decodedResult);
        }

        function onScanFailure(error) {
            // toastr.error('Code scan error');
            // console.warn(`Code scan error = ${error}`);
        }
    </script>
@endpush
