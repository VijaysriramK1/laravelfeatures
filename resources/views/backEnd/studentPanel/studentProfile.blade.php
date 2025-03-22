@php

    $check_role_based_module_permission = DB::table('assign_permissions')
        ->where('role_id', Auth::user()->role_id)
        ->where('school_id', Auth::user()->school_id)
        ->pluck('permission_id');
    $get_authorized_modules_details = DB::table('permissions')
        ->whereIn('id', $check_role_based_module_permission)
        ->where('parent_route', 'student-dashboard')
        ->where('school_id', Auth::user()->school_id)
        ->get();

    foreach ($get_authorized_modules_details as $value) {
        $get_authorized_data[] = $value->route;
    }

    $get_the_data = $get_authorized_data;

@endphp

@extends('backEnd.master')
@section('title')
    @lang('student.my_profile')
@endsection
@push('css')
    <style>
        table#table_id thead tr th:not(:first-child) {
            padding-left: 30px !important;
        }

        table#table_id tbody tr td:not(:first-child),
        table#table_id tbody tr td:nth-child(2) {
            padding-left: 30px !important;
        }

        .leave_table {
            overflow: hidden;
        }

        .table tbody tr:last-child td,
        .table tbody tr:last-child th {
            border-bottom: none;
        }

        .QA_section .QA_table .table.school-table-style-parent-fees thead th,
        .QA_section .QA_table .table.school-table-style-parent-fees thead td {
            padding: 16px 30px !important;
        }

        .fc th {
            padding: 0 !important;
        }
    </style>
@endpush
@section('mainContent')
    @php
        @$setting = generalSetting();
        if (!empty(@$setting->currency_symbol)) {
            @$currency = @$setting->currency_symbol;
        } else {
            @$currency = '$';
        }
    @endphp
    <section class="student-details">
        <div class="container-fluid p-0">
            <div class="white-box">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Start Student Meta Information -->
                        <div class="main-title">
                            <h3 class="mb-15">@lang('student.welcome_to') <strong> {{ @$student_detail->full_name }}</strong> </h3>
                        </div>
                    </div>
                </div>
                <div class="row row-gap-30">

                    @if (in_array('dashboard-subject', $get_the_data))
                        @if (userPermission('dashboard-subject'))
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('student_subject') }}" class="d-block">
                                    <div class="white-box single-summery cyan">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3>@lang('common.subject')</h3>
                                                <p class="mb-0">@lang('student.total_subject')</p>
                                            </div>
                                            <h1 class="gradient-color2">
                                                @if (isset($totalSubjects))
                                                    {{ count(@$totalSubjects) }}
                                                @endif
                                            </h1>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @else
                        <!-- empty -->
                    @endif


                    @if (in_array('dashboard-notice', $get_the_data))
                        @if (userPermission('dashboard-notice') && userPermission('student_noticeboard'))
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('student_noticeboard') }}" class="d-block">
                                    <div class="white-box single-summery violet">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3>@lang('student.notice')</h3>
                                                <p class="mb-0">@lang('student.total_notice')</p>
                                            </div>
                                            <h1 class="gradient-color2">
                                                @if (isset($totalNotices))
                                                    {{ count(@$totalNotices) }}
                                                @endif
                                            </h1>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @else
                        <!-- empty -->
                    @endif





                    @if (in_array('dashboard-exam', $get_the_data))
                        @if (userPermission('dashboard-exam'))
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('student_exam_schedule') }}" class="d-block">
                                    <div class="white-box single-summery violet">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3>@lang('student.exam')</h3>
                                                <p class="mb-0">@lang('student.total_exam')</p>
                                            </div>
                                            <h1 class="gradient-color2">
                                                @if (isset($exams))
                                                    {{ count(@$exams) }}
                                                @endif
                                            </h1>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @else
                        <!-- empty -->
                    @endif



                    @if (in_array('dashboard-online-exam', $get_the_data))
                        @if (userPermission('dashboard-online-exam'))
                            <div class="col-lg-3 col-md-6">
                                @if (moduleStatusCheck('OnlineExam'))
                                    <a href="{{ route('om_student_online_exam') }}" class="d-block">
                                    @else
                                        <a href="{{ route('student_online_exam') }}" class="d-block">
                                @endif
                                <div class="white-box single-summery blue">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h3>@lang('student.online_exam')</h3>
                                            <p class="mb-0">@lang('student.total_online_exam')</p>
                                        </div>
                                        <h1 class="gradient-color2">
                                            @if (isset($online_exams))
                                                {{ count(@$online_exams) }}
                                            @endif
                                        </h1>
                                    </div>
                                </div>
                                </a>
                            </div>
                        @endif
                    @else
                        <!-- empty -->
                    @endif


                    @if (in_array('dashboard-teachers', $get_the_data))
                        @if (userPermission('dashboard-teachers'))
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('student_teacher') }}" class="d-block">
                                    <div class="white-box single-summery fuchsia">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3>@lang('student.teachers')</h3>
                                                <p class="mb-0">@lang('student.total_teachers')</p>
                                            </div>
                                            <h1 class="gradient-color2">
                                                @if (isset($teachers))
                                                    {{ count(@$teachers) }}
                                                @endif
                                            </h1>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @else
                        <!-- empty -->
                    @endif

                    @if (in_array('dashboard-issued-books', $get_the_data))
                        @if (userPermission('dashboard-issued-books'))
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('student_book_issue') }}" class="d-block">
                                    <div class="white-box single-summery cyan">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3>@lang('student.issued_book')</h3>
                                                <p class="mb-0">@lang('student.total_issued_book')</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @else
                        <!-- empty -->
                    @endif


                    @if (in_array('dashboard-pending-homeworks', $get_the_data))
                        @if (userPermission('dashboard-pending-homeworks'))
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('student_homework') }}" class="d-block">
                                    <div class="white-box single-summery violet">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3>@lang('student.pending_home_work')</h3>
                                                <p class="mb-0">@lang('student.total_pending_home_work')</p>
                                            </div>
                                            <h1 class="gradient-color2">
                                                @if (isset($homeworkLists))
                                                    {{ count(@$homeworkLists) }}
                                                @endif
                                            </h1>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @else
                        <!-- empty -->
                    @endif


                    @if (in_array('dashboard-attendance-in-current-month', $get_the_data))
                        @if (userPermission('dashboard-attendance-in-current-month'))
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('student_my_attendance') }}" class="d-block">
                                    <div class="white-box single-summery blue">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3>@lang('student.attendance_in_current_month')</h3>
                                                <p class="mb-0">@lang('student.total_attendance_in_current_month')</p>
                                            </div>
                                            <h1 class="gradient-color2">
                                                @if (isset($attendances))
                                                    {{ count(@$attendances) }}
                                                @endif
                                            </h1>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @else
                        <!-- empty -->
                    @endif



                    @php
                        $feesDue = 0;
                        $totalPoint = 0;
                        $balance_fees = 0;
                        foreach ($student_detail->studentRecords as $record) {
                            foreach ($record->feesInvoice as $key => $studentInvoice) {
                                $amount = $studentInvoice->Tamount;
                                $weaver = $studentInvoice->Tweaver;
                                $fine = $studentInvoice->Tfine;
                                $paid_amount = $studentInvoice->Tpaidamount;
                                $sub_total = $studentInvoice->Tsubtotal;
                                $feesDue = $amount + $fine - ($paid_amount + $weaver);
                            }
                            foreach ($record->directFeesInstallments as $feesInstallment) {
                                $balance_fees +=
                                    discount_fees($feesInstallment->amount, $feesInstallment->discount_amount) -
                                    $feesInstallment->paid_amount;
                            }
                            foreach ($record->incidents as $incident) {
                                $totalPoint += $incident->point;
                            }
                        }
                    @endphp

                </div>
            </div>
            <div class="row mt-40">
                @if (userPermission('student_class_routine'))
                    @include('backEnd.studentPanel._class_routine_content', [
                        'sm_weekends' => $sm_weekends,
                        'records' => $records,
                        'routineDashboard' => $routineDashboard,
                    ])
                @endif

                @if (in_array('dashboard-teachers', $get_the_data))
                    @if (userPermission('student_teacher'))
                        <div class="container-fluid mt-40">
                            <div class="row">
                                <div class="col-lg-12">
                                    @include('backEnd.studentPanel.inc._teacher_list')
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- empty -->
                @endif

                @if (userPermission('leave'))
                    <div class="container-fluid mt-40">
                        <div class="row">
                            <div class="col-lg-12">
                                @include('backEnd.studentPanel.inc._leave_type')
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if (in_array('dashboard-calendar', $get_the_data))
                <div class="white-box mt-40">
                    @if (userPermission('dashboard-calendar'))
                        <div class="row">
                            <div class="col-lg-12">
                                @include('backEnd.communicate.commonAcademicCalendar')
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <!-- empty -->
            @endif
        </div>
    </section>

    <div id="fullCalModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span
                            class="sr-only">close</span></button>
                    <h4 id="modalTitle" class="modal-title"></h4>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="There are no image" id="image" height="150" width="auto">
                    <div id="modalBody"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    $count_event = 0;
    @$calendar_events = [];
    foreach ($holidays as $k => $holiday) {
        @$calendar_events[$k]['title'] = $holiday->holiday_title;
    
        $calendar_events[$k]['start'] = $holiday->from_date;
    
        $calendar_events[$k]['end'] = Carbon::parse($holiday->to_date)
            ->addDays(1)
            ->format('Y-m-d');
    
        $calendar_events[$k]['description'] = $holiday->details;
    
        $calendar_events[$k]['url'] = $holiday->upload_image_file;
    
        $count_event = $k;
        $count_event++;
    }
    
    foreach ($events as $k => $event) {
        @$calendar_events[$count_event]['title'] = $event->event_title;
    
        $calendar_events[$count_event]['start'] = $event->from_date;
    
        $calendar_events[$count_event]['end'] = Carbon::parse($event->to_date)
            ->addDays(1)
            ->format('Y-m-d');
        $calendar_events[$count_event]['description'] = $event->event_des;
        $calendar_events[$count_event]['url'] = $event->uplad_image_file;
        $count_event++;
    }
    ?>

@endsection
@include('backEnd.communicate.academic_calendar_css_js')
