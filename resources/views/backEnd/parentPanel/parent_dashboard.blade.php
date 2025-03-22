@php

    $check_role_based_module_permission = DB::table('assign_permissions')
        ->where('role_id', Auth::user()->role_id)
        ->where('school_id', Auth::user()->school_id)
        ->pluck('permission_id');
    $get_authorized_modules_details = DB::table('permissions')
        ->whereIn('id', $check_role_based_module_permission)
        ->where('parent_route', 'parent-dashboard')
        ->where('school_id', Auth::user()->school_id)
        ->get();

    foreach ($get_authorized_modules_details as $value) {
        $get_authorized_data[] = $value->route;
    }

    $get_the_data = $get_authorized_data;

@endphp

@extends('backEnd.master')
@section('title')
    @lang('parent.parent_dashboard')
@endsection
@push('css')
    <style>
        .QA_section .QA_table thead th {
            padding-left: 30px !important;
        }

        .customeDashboard tr td,
        #default_table tr td {
            min-width: 150px;
        }

        .table.dataTable thead .sorting::after,
        .table.dataTable thead .sorting_asc:after,
        .table.dataTable thead .sorting_desc:after {
            top: 17px !important;
        }

        .table.dataTable.homework-table thead .sorting::after,
        .table.dataTable.homework-table thead .sorting_asc:after,
        .table.dataTable.homework-table thead .sorting_desc:after {
            top: 10px !important;
        }

        .table.dataTable.attendence-table tr th,
        .table.dataTable.attendence-table tr td {
            padding: 8px !important
        }

        .check_box_table .QA_table .table tbody th:first-child,
        .QA_section.check_box_table .QA_table .table thead tr th:first-child,
        .QA_section.check_box_table .QA_table .table thead tr th {
            padding-left: 20px !important;
        }

        .customeDashboard tr td,
        #default_table tr td {
            min-width: 150px;
        }

        .table .routine-table td,
        .table th {
            padding: 12px 20px !important;
        }

        .check_box_table .QA_table .table tbody td:nth-child(2) {
            padding-left: 20px
        }

        .QA_section .QA_table th,
        .QA_section .QA_table td {
            padding: 12px 20px !important;
        }

        .QA_table {
            margin-top: 5px !important;
        }

        .fc th {
            padding: 0 !important;
        }

        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_desc:after {
            left: 16px;
            top: 10px;
        }

        .check_box_table .QA_table .table tbody td:first-child {
            padding-left: 20px
        }

        table thead tr th {
            line-height: 1.9 !important;
        }
    </style>
@endpush
@section('mainContent')
    <section class="student-details">
        <div class="container-fluid p-0">

            {{-- <div class="row"> --}}
            @foreach ($my_childrens as $children)
                <div class="white-box">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="main-title">
                                <h3 class="mb-15">@lang('parent.my_children')</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Start Student Meta Information -->
                            <div class="main-title">
                                <h3 class="mb-15"> {{ $children->full_name }}</h3>
                            </div>

                            @php
                                $student_detail = $children;

                                $issueBooks = $student_detail->bookIssue;

                                $homeworkLists = 0;
                                $totalSubjects = 0;
                                $totalOnlineExams = 0;
                                $totalTeachers = 0;
                                $totalExams = 0;
                                $feesDue = 0;
                                $totalPoint = 0;
                                $balance_fees = 0;
                                $pendingHomework = 0;

                                foreach ($student_detail->studentRecords as $record) {
                                    $homeworkLists += $record->getHomeWorkAttribute()->count();
                                    $totalSubjects += $record->getAssignSubjectAttribute()->count();
                                    $totalTeachers += $record->getStudentTeacherAttribute()->count();
                                    $totalOnlineExams += $record->getOnlineExamAttribute()->count();
                                    $totalExams += $record->examSchedule()->count();

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

                                $attendances = $student_detail->studentAttendances->where(
                                    'academic_id',
                                    generalSetting()->session_id,
                                );
                            @endphp
                        </div>
                    </div>
                    <div class="row row-gap-24">
                        @if (in_array('parent-dashboard-subject', $get_the_data))
                            @if (userPermission('parent-dashboard-subject'))
                                <div class="col-lg-3 col-md-6">
                                    <a href="{{ route('parent_subjects', $children->id) }}" class="d-block">
                                        <div class="white-box single-summery cyan">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h3>@lang('common.subject')</h3>
                                                    <p class="mb-0">@lang('parent.total_subject')</p>
                                                </div>
                                                <h1 class="gradient-color2">

                                                    {{ $totalSubjects }}

                                                </h1>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @else
                            <!-- empty -->
                        @endif

                        @if (in_array('parent-dashboard-notice', $get_the_data))
                            @if (userPermission('parent-dashboard-notice'))
                                <div class="col-lg-3 col-md-6">
                                    <a href="{{ route('parent_noticeboard') }}" class="d-block">
                                        <div class="white-box single-summery violet">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h3>@lang('parent.notice')</h3>
                                                    <p class="mb-0">@lang('parent.total_notice')</p>
                                                </div>
                                                <h1 class="gradient-color2">
                                                    @if (isset($totalNotices))
                                                        {{ count($totalNotices) }}
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

                        @if (in_array('parent-dashboard-exam', $get_the_data))
                            @if (userPermission('parent-dashboard-exam'))
                                <div class="col-lg-3 col-md-6">
                                    <a href="{{ route('parent_exam_schedule', $children->id) }}" class="d-block">
                                        <div class="white-box single-summery blue">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h3>@lang('parent.exam')</h3>
                                                    <p class="mb-0">@lang('parent.total_exam')</p>
                                                </div>
                                                <h1 class="gradient-color2">

                                                    {{ $totalExams }}
                                                </h1>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @else
                            <!-- empty -->
                        @endif


                        {{-- @if (userPermission('parent-dashboard-exam'))
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ route('parent_online_examination', $children->id) }}" class="d-block">
                                    <div class="white-box single-summery fuchsia">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h3>@lang('parent.online_exam')</h3>
                                                <p class="mb-0">@lang('parent.total_online_exam')</p>
                                            </div>
                                            <h1 class="gradient-color2">

                                                {{ $totalOnlineExams }}
                                            </h1>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif --}}

                        @if (in_array('parent-dashboard-teacher', $get_the_data))
                            @if (userPermission('parent-dashboard-teacher'))
                                <div class="col-lg-3 col-md-6">
                                    <a href="{{ route('parent_teacher_list', $children->id) }}" class="d-block">
                                        <div class="white-box single-summery cyan">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h3>@lang('parent.teachers')</h3>
                                                    <p class="mb-0">@lang('parent.total_teachers')</p>
                                                </div>
                                                <h1 class="gradient-color2">
                                                    {{ $totalTeachers }}
                                                </h1>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @else
                            <!-- empty -->
                        @endif






                        @if (in_array('parent-dashboard-issued-books', $get_the_data))
                            @if (userPermission('parent-dashboard-issued-books'))
                                <div class="col-lg-3 col-md-6">
                                    <a href="{{ route('parent_library') }}" class="d-block">
                                        <div class="white-box single-summery violet">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h3>@lang('parent.issued_book')</h3>
                                                    <p class="mb-0">@lang('parent.total_issued_book')</p>
                                                </div>
                                                <h1 class="gradient-color2">
                                                    @if (isset($issueBooks))
                                                        {{ count($issueBooks) }}
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



                        @if (in_array('parent-dashboard-pending-homeworks', $get_the_data))
                            @if (userPermission('parent-dashboard-pending-homeworks'))
                                <div class="col-lg-3 col-md-6">
                                    <a href="{{ route('parent_homework', $children->id) }}" class="d-block">
                                        <div class="white-box single-summery blue">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h3>@lang('parent.pending_home_work')</h3>
                                                    <p class="mb-0">@lang('parent.total_pending_home_work')</p>
                                                </div>
                                                <h1 class="gradient-color2">
                                                    @if (isset($homeworkLists))
                                                        {{ $homeworkLists }}
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


                        @if (in_array('parent-dashboard-attendance-in-current-month', $get_the_data))
                            @if (userPermission('parent-dashboard-attendance-in-current-month'))
                                <div class="col-lg-3 col-md-6">
                                    <a href="{{ route('parent_attendance', $children->id) }}" class="d-block">
                                        <div class="white-box single-summery fuchsia">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h3>@lang('parent.attendance_in_current_month')</h3>
                                                    <p class="mb-0">@lang('parent.total_attendance_in_current_month')</p>
                                                </div>
                                                <h1 class="gradient-color2">
                                                    @if (isset($attendances))
                                                        {{ count($attendances) }}
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

                    </div>
                </div>
            @endforeach


            @if (in_array('parent-dashboard-calendar', $get_the_data))
                @if (userPermission('parent-dashboard-calendar'))
                    <div class="row mt-40">
                        <div class="col-lg-12">
                            <div>
                                @include('backEnd.communicate.commonAcademicCalendar')
                            </div>
                        </div>
                    </div>
                @endif
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
@endsection
@include('backEnd.communicate.academic_calendar_css_js')
