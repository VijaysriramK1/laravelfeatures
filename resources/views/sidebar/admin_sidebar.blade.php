@php
    $school_config = schoolConfig();
    $current_route_details = Route::currentRouteName();
@endphp

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SG Academy Sidebar</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav id="sidebar" class="sidebar">

        <div class="sidebar-header update_sidebar">
            <a class="text-decoration-none" href="{{ route('admin-dashboard') }}" id="admin-dashboard">
                @if (!is_null($school_config->logo))
                    <img src="{{ asset($school_config->logo) }}" alt="logo">
                @else
                    <img src="{{ asset('public/uploads/settings/logo.png') }}" alt="logo">
                @endif
            </a>
            <a id="close_sidebar" class="text-decoration-none d-lg-none">
                <i class="ti-close"></i>
            </a>
        </div>
        <ul class="sidebar_menu list-unstyled" id="sidebar_menu">

            <li><span class="menu_seperator">Dashboard</span></li>

            <li>
                <a class="text-decoration-none {{ $current_route_details == 'dashboard' ? 'active' : '' }}"
                    href="/dashboard">
                    <div class="nav_icon_small">
                        <span class="fas fa-th"></span>
                    </div>

                    <div class="nav_title">
                        @if (Lang::has('communicate.common.dashboard'))
                            <span>{{ __('communicate.common.dashboard') ?? 'Dashboard' }}</span>
                        @else
                            <span>{{ __('common.dashboard') ?? 'Dashboard' }}</span>
                        @endif
                    </div>
                </a>
            </li>

            <li><span class="menu_seperator">Administration</span></li>

            <li
                class="{{ spn_active_link('admission-query', 'mm-active') }} {{ spn_active_link('visitor', 'mm-active') }} {{ spn_active_link('complaint', 'mm-active') }} {{ spn_active_link('postal-receive', 'mm-active') }} {{ spn_active_link('postal-dispatch', 'mm-active') }} {{ spn_active_link('phone-call', 'mm-active') }} {{ spn_active_link('setup-admin', 'mm-active') }} {{ spn_active_link('student-id-card', 'mm-active') }} {{ spn_active_link('student-certificate', 'mm-active') }} {{ spn_active_link('generate-certificate', 'mm-active') }} {{ spn_active_link('generate-id-card', 'mm-active') }} {{ spn_active_link('lead-integration', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['admission_query', 'visitor', 'complaint', 'postal-receive', 'postal-dispatch', 'phone-call', 'setup-admin', 'student-id-card', 'student-certificate', 'generate_certificate', 'generate_id_card', 'lead_integration']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="flaticon-analytics"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.admin.admin_section'))
                            <span>{{ __('communicate.admin.admin_section') ?? 'Admin Section' }}</span>
                        @else
                            <span>{{ __('admin.admin_section') ?? 'Admin Section' }}</span>
                        @endif

                    </div>


                </a>
                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'admission_query' ? 'active' : '' }}"
                            href="/admission-query">

                            @if (Lang::has('communicate.admin.admission_query'))
                                <span>{{ __('communicate.admin.admission_query') ?? 'Admission Query' }}</span>
                            @else
                                <span>{{ __('admin.admission_query') ?? 'Admission Query' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'visitor' ? 'active' : '' }}"
                            href="/visitor">

                            @if (Lang::has('communicate.admin.visitor_book'))
                                <span>{{ __('communicate.admin.visitor_book') ?? 'Visitor Book' }}</span>
                            @else
                                <span>{{ __('admin.visitor_book') ?? 'Visitor Book' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'complaint' ? 'active' : '' }}"
                            href="/complaint">

                            @if (Lang::has('communicate.admin.complaint'))
                                <span>{{ __('communicate.admin.complaint') ?? 'Complaint' }}</span>
                            @else
                                <span>{{ __('admin.complaint') ?? 'Complaint' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'postal-receive' ? 'active' : '' }}"
                            href="/postal-receive">

                            @if (Lang::has('communicate.admin.postal_receive'))
                                <span>{{ __('communicate.admin.postal_receive') ?? 'Postal Receive' }}</span>
                            @else
                                <span>{{ __('admin.postal_receive') ?? 'Postal Receive' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'postal-dispatch' ? 'active' : '' }}"
                            href="/postal-dispatch">

                            @if (Lang::has('communicate.admin.postal_dispatch'))
                                <span>{{ __('communicate.admin.postal_dispatch') ?? 'Postal Dispatch' }}</span>
                            @else
                                <span>{{ __('admin.postal_dispatch') ?? 'Postal Dispatch' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'phone-call' ? 'active' : '' }}"
                            href="/phone-call">

                            @if (Lang::has('communicate.admin.phone_call_log'))
                                <span>{{ __('communicate.admin.phone_call_log') ?? 'Phone Call Log' }}</span>
                            @else
                                <span>{{ __('admin.phone_call_log') ?? 'Phone Call Log' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'setup-admin' ? 'active' : '' }}"
                            href="/setup-admin">

                            @if (Lang::has('communicate.admin.admin_setup'))
                                <span>{{ __('communicate.admin.admin_setup') ?? 'Admin Setup' }}</span>
                            @else
                                <span>{{ __('admin.admin_setup') ?? 'Admin Setup' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student-id-card' ? 'active' : '' }}"
                            href="/student-id-card">

                            @if (Lang::has('communicate.admin.id_card'))
                                <span>{{ __('communicate.admin.id_card') ?? 'Student ID Card' }}</span>
                            @else
                                <span>{{ __('admin.id_card') ?? 'Student ID Card' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student-certificate' ? 'active' : '' }}"
                            href="/student-certificate">

                            @if (Lang::has('communicate.admin.student_certificate'))
                                <span>{{ __('communicate.admin.student_certificate') ?? 'Certificate' }}</span>
                            @else
                                <span>{{ __('admin.student_certificate') ?? 'Certificate' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'generate_certificate' ? 'active' : '' }}"
                            href="/generate-certificate">

                            @if (Lang::has('communicate.admin.generate_certificate'))
                                <span>{{ __('communicate.admin.generate_certificate') ?? 'Generate Certificate' }}</span>
                            @else
                                <span>{{ __('admin.generate_certificate') ?? 'Generate Certificate' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'generate_id_card' ? 'active' : '' }}"
                            href="/generate-id-card">

                            @if (Lang::has('communicate.admin.generate_id_card'))
                                <span>{{ __('communicate.admin.generate_id_card') ?? 'Generate ID Card' }}</span>
                            @else
                                <span>{{ __('admin.generate_id_card') ?? 'Generate ID Card' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'lead_integration' ? 'active' : '' }}"
                            href="/lead-integration">

                            @if (Lang::has('communicate.Lead Integration'))
                                <span>{{ __('communicate.Lead Integration') ?? 'Lead Integration' }}</span>
                            @else
                                <span>{{ __('Lead Integration') ?? 'Lead Integration' }}</span>
                            @endif

                        </a>
                    </li>



                </ul>
            </li>

            <li
                class="{{ spn_active_link('optional-subject', 'mm-active') }} {{ spn_active_link('section', 'mm-active') }} {{ spn_active_link('class', 'mm-active') }} {{ spn_active_link('subject', 'mm-active') }} {{ spn_active_link('assign-class-teacher', 'mm-active') }} {{ spn_active_link('assign-subject', 'mm-active') }} {{ spn_active_link('class-room', 'mm-active') }} {{ spn_active_link('class-routine', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['optional-subject', 'section', 'class', 'subject', 'assign-class-teacher', 'assign_subject', 'class-room', 'class_routine']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-graduation-cap"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.academics.academics'))
                            <span>{{ __('communicate.academics.academics') ?? 'Academics' }}</span>
                        @else
                            <span>{{ __('academics.academics') ?? 'Academics' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'optional-subject' ? 'active' : '' }}"
                            href="/optional-subject">

                            @if (Lang::has('communicate.academics.optional_subject'))
                                <span>{{ __('communicate.academics.optional_subject') ?? 'Optional Subject' }}</span>
                            @else
                                <span>{{ __('academics.optional_subject') ?? 'Optional Subject' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'section' ? 'active' : '' }}"
                            href="/section">

                            @if (Lang::has('communicate.common.section'))
                                <span>{{ __('communicate.common.section') ?? 'Section' }}</span>
                            @else
                                <span>{{ __('common.section') ?? 'Section' }}</span>
                            @endif

                        </a>
                    </li>


                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'class' ? 'active' : '' }}"
                            href="/class">

                            @if (Lang::has('communicate.common.class'))
                                <span>{{ __('communicate.common.class') ?? 'Class' }}</span>
                            @else
                                <span>{{ __('common.class') ?? 'Class' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'subject' ? 'active' : '' }}"
                            href="/subject">

                            @if (Lang::has('communicate.common.subjects'))
                                <span>{{ __('communicate.common.subjects') ?? 'Subjects' }}</span>
                            @else
                                <span>{{ __('common.subjects') ?? 'Subjects' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'assign-class-teacher' ? 'active' : '' }}"
                            href="/assign-class-teacher">

                            @if (Lang::has('communicate.academics.assign_class_teacher'))
                                <span>{{ __('communicate.academics.assign_class_teacher') ?? 'Assign Class Teacher' }}</span>
                            @else
                                <span>{{ __('academics.assign_class_teacher') ?? 'Assign Class Teacher' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'assign_subject' ? 'active' : '' }}"
                            href="/assign-subject">

                            @if (Lang::has('communicate.academics.assign_subject'))
                                <span>{{ __('communicate.academics.assign_subject') ?? 'Assign Subject' }}</span>
                            @else
                                <span>{{ __('academics.assign_subject') ?? 'Assign Subject' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'class-room' ? 'active' : '' }}"
                            href="/class-room">

                            @if (Lang::has('communicate.academics.class_room'))
                                <span>{{ __('communicate.academics.class_room') ?? 'Class Room' }}</span>
                            @else
                                <span>{{ __('academics.class_room') ?? 'Class Room' }}</span>
                            @endif

                        </a>
                    </li>


                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'class_routine' ? 'active' : '' }}"
                            href="/class-routine">

                            @if (Lang::has('communicate.academics.class_routine'))
                                <span>{{ __('communicate.academics.class_routine') ?? 'Class Routine' }}</span>
                            @else
                                <span>{{ __('academics.class_routine') ?? 'Class Routine' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>


            <li
                class="{{ spn_active_link('upload-content', 'mm-active') }} {{ spn_active_link('assignment-list', 'mm-active') }} {{ spn_active_link('syllabus-list', 'mm-active') }} {{ spn_active_link('other-download-list', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['upload-content', 'assignment-list', 'syllabus-list', 'other-download-list']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-solid fa-download"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.study.study_material'))
                            <span>{{ __('communicate.study.study_material') ?? 'Study Material' }}</span>
                        @else
                            <span>{{ __('study.study_material') ?? 'Study Material' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'upload-content' ? 'active' : '' }}"
                            href="/upload-content">

                            @if (Lang::has('communicate.study.upload_content'))
                                <span>{{ __('communicate.study.upload_content') ?? 'Upload Content' }}</span>
                            @else
                                <span>{{ __('study.upload_content') ?? 'Upload Content' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'assignment-list' ? 'active' : '' }}"
                            href="/assignment-list">

                            @if (Lang::has('communicate.study.assignment'))
                                <span>{{ __('communicate.study.assignment') ?? 'Assignment' }}</span>
                            @else
                                <span>{{ __('study.assignment') ?? 'Assignment' }}</span>
                            @endif

                        </a>
                    </li>


                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'syllabus-list' ? 'active' : '' }}"
                            href="/syllabus-list">

                            @if (Lang::has('communicate.study.syllabus'))
                                <span>{{ __('communicate.study.syllabus') ?? 'Syllabus' }}</span>
                            @else
                                <span>{{ __('study.syllabus') ?? 'Syllabus' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'other-download-list' ? 'active' : '' }}"
                            href="/other-download-list">

                            @if (Lang::has('communicate.study.other_download'))
                                <span>{{ __('communicate.study.other_download') ?? 'Other Downloads' }}</span>
                            @else
                                <span>{{ __('study.other_download') ?? 'Other Downloads' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>


            <li
                class="{{ spn_active_link('lesson', 'mm-active') }} {{ spn_active_link('lesson/topic', 'mm-active') }} {{ spn_active_link('lesson/topic-overview', 'mm-active') }} {{ spn_active_link('lesson/lesson-plan', 'mm-active') }} {{ spn_active_link('lesson/lessonPlan-overiew', 'mm-active') }} {{ spn_active_link('sub-topic', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['lesson', 'lesson.topic', 'topic-overview', 'lesson.lesson-planner', 'lesson.lessonPlan-overiew', 'sub-topic']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa fa-list-alt"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.lesson::lesson.lesson_plan'))
                            <span>{{ __('communicate.lesson::lesson.lesson_plan') ?? 'Lesson Plan' }}</span>
                        @else
                            <span>{{ __('lesson::lesson.lesson_plan') ?? 'Lesson Plan' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'lesson' ? 'active' : '' }}"
                            href="/lesson">

                            @if (Lang::has('communicate.lesson::lesson.lesson'))
                                <span>{{ __('communicate.lesson::lesson.lesson') ?? 'Lesson' }}</span>
                            @else
                                <span>{{ __('lesson::lesson.lesson') ?? 'Lesson' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'lesson.topic' ? 'active' : '' }}"
                            href="/lesson/topic">

                            @if (Lang::has('communicate.lesson::lesson.topic'))
                                <span>{{ __('communicate.lesson::lesson.topic') ?? 'Topic' }}</span>
                            @else
                                <span>{{ __('lesson::lesson.topic') ?? 'Topic' }}</span>
                            @endif

                        </a>
                    </li>


                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'topic-overview' ? 'active' : '' }}"
                            href="/lesson/topic-overview">

                            @if (Lang::has('communicate.lesson::lesson.topic_overview'))
                                <span>{{ __('communicate.lesson::lesson.topic_overview') ?? 'Topic Overview' }}</span>
                            @else
                                <span>{{ __('lesson::lesson.topic_overview') ?? 'Topic Overview' }}</span>
                            @endif

                        </a>
                    </li>


                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'lesson.lesson-planner' ? 'active' : '' }}"
                            href="/lesson/lesson-plan">

                            @if (Lang::has('communicate.lesson::lesson.lesson_plan'))
                                <span>{{ __('communicate.lesson::lesson.lesson_plan') ?? 'Lesson Plan' }}</span>
                            @else
                                <span>{{ __('lesson::lesson.lesson_plan') ?? 'Lesson Plan' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'lesson.lessonPlan-overiew' ? 'active' : '' }}"
                            href="/lesson/lessonPlan-overiew">

                            @if (Lang::has('communicate.lesson::lesson.lesson_plan_overview'))
                                <span>{{ __('communicate.lesson::lesson.lesson_plan_overview') ?? 'Lesson Plan Overview' }}</span>
                            @else
                                <span>{{ __('lesson::lesson.lesson_plan_overview') ?? 'Lesson Plan Overview' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'sub-topic' ? 'active' : '' }}"
                            href="/sub-topic">

                            @if (Lang::has('communicate.lesson::lesson.sub_topic'))
                                <span>{{ __('communicate.lesson::lesson.sub_topic') ?? 'Sub Topic' }}</span>
                            @else
                                <span>{{ __('lesson::lesson.sub_topic') ?? 'Sub Topic' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>


            <li
                class="{{ spn_active_link('bulkprint/student-id-card-bulk-print', 'mm-active') }} {{ spn_active_link('bulkprint/certificate-bulk-print', 'mm-active') }} {{ spn_active_link('bulkprint/payroll-bulk-print', 'mm-active') }} {{ spn_active_link('bulkprint/fees-invoice-bulk-print', 'mm-active') }} {{ spn_active_link('bulkprint/fees-invoice-bulk-print-settings', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['student-id-card-bulk-print', 'certificate-bulk-print', 'payroll', 'fees-invoice-bulk-print', 'fees-invoice-bulk-print-settings']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-print"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.bulkprint::bulk.bulk_print'))
                            <span>{{ __('communicate.bulkprint::bulk.bulk_print') ?? 'Bulk Print' }}</span>
                        @else
                            <span>{{ __('bulkprint::bulk.bulk_print') ?? 'Bulk Print' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student-id-card-bulk-print' ? 'active' : '' }}"
                            href="/bulkprint/student-id-card-bulk-print">

                            @if (Lang::has('communicate.admin.id_card'))
                                <span>{{ __('communicate.admin.id_card') ?? 'Id Card' }}</span>
                            @else
                                <span>{{ __('admin.id_card') ?? 'Id Card' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'certificate-bulk-print' ? 'active' : '' }}"
                            href="/bulkprint/certificate-bulk-print">

                            @if (Lang::has('communicate.admin.student_certificate'))
                                <span>{{ __('communicate.admin.student_certificate') ?? 'Student Certificate' }}</span>
                            @else
                                <span>{{ __('admin.student_certificate') ?? 'Student Certificate' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'payroll' ? 'active' : '' }}"
                            href="/bulkprint/payroll-bulk-print">

                            @if (Lang::has('communicate.payroll-bulk-print'))
                                <span>{{ __('communicate.payroll-bulk-print') ?? 'Payroll Bulk Print' }}</span>
                            @else
                                <span>{{ __('payroll-bulk-print') ?? 'Payroll Bulk Print' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'fees-invoice-bulk-print' ? 'active' : '' }}"
                            href="/bulkprint/fees-invoice-bulk-print">

                            @if (Lang::has('communicate.bulkprint::bulk.fees_invoice_bulk_print'))
                                <span>{{ __('communicate.bulkprint::bulk.fees_invoice_bulk_print') ?? 'Fees invoice Bulk Print' }}</span>
                            @else
                                <span>{{ __('bulkprint::bulk.fees_invoice_bulk_print') ?? 'Fees invoice Bulk Print' }}</span>
                            @endif

                        </a>
                    </li>


                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'fees-invoice-bulk-print-settings' ? 'active' : '' }}"
                            href="/bulkprint/fees-invoice-bulk-print-settings">

                            @if (Lang::has('communicate.bulkprint::bulk.fees_invoice_bulk_print_settings'))
                                <span>{{ __('communicate.bulkprint::bulk.fees_invoice_bulk_print_settings') ?? 'Fees Invoice Bulk Print Setting' }}</span>
                            @else
                                <span>{{ __('bulkprint::bulk.fees_invoice_bulk_print_settings') ?? 'Fees Invoice Bulk Print Setting' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>


            <li
                class="{{ spn_active_link('download-center/content-type', 'mm-active') }} {{ spn_active_link('download-center/content-list', 'mm-active') }} {{ spn_active_link('download-center/content-share-list', 'mm-active') }} {{ spn_active_link('download-center/video-list', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['download-center.content-type', 'download-center.content-list', 'download-center.content-share-list', 'download-center.video-list']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-solid fa-download"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.downloadCenter.download_center'))
                            <span>{{ __('communicate.downloadCenter.download_center') ?? 'Download Center' }}</span>
                        @else
                            <span>{{ __('downloadCenter.download_center') ?? 'Download Center' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'download-center.content-type' ? 'active' : '' }}"
                            href="/download-center/content-type">

                            @if (Lang::has('communicate.downloadCenter.content_type'))
                                <span>{{ __('communicate.downloadCenter.content_type') ?? 'Content Type' }}</span>
                            @else
                                <span>{{ __('downloadCenter.content_type') ?? 'Content Type' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'download-center.content-list' ? 'active' : '' }}"
                            href="/download-center/content-list">

                            @if (Lang::has('communicate.downloadCenter.content_list'))
                                <span>{{ __('communicate.downloadCenter.content_list') ?? 'Content List' }}</span>
                            @else
                                <span>{{ __('downloadCenter.content_list') ?? 'Content List' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'download-center.content-share-list' ? 'active' : '' }}"
                            href="/download-center/content-share-list">

                            @if (Lang::has('communicate.downloadCenter.shared_content_list'))
                                <span>{{ __('communicate.downloadCenter.shared_content_list') ?? 'Shared Content List' }}</span>
                            @else
                                <span>{{ __('downloadCenter.shared_content_list') ?? 'Shared Content List' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'download-center.video-list' ? 'active' : '' }}"
                            href="/download-center/video-list">

                            @if (Lang::has('communicate.downloadCenter.video_list'))
                                <span>{{ __('communicate.downloadCenter.video_list') ?? 'Video List' }}</span>
                            @else
                                <span>{{ __('downloadCenter.video_list') ?? 'Video List' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="{{ spn_active_link('program/my-programs', 'mm-active') }} {{ spn_active_link('program/program-mark', 'mm-active') }} {{ spn_active_link('program/my-students', 'mm-active') }} {{ spn_active_link('program/routines', 'mm-active') }} {{ spn_active_link('program/mark-report', 'mm-active') }} ">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['programs.myprograms', 'programs.mark', 'programs.my-student', 'programs.routines', 'mark-report']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-book"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.Program'))
                            <span>{{ __('communicate.Program') ?? 'Program' }}</span>
                        @else
                            <span>{{ __('Program') ?? 'Program' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'programs.myprograms' ? 'active' : '' }}"
                            href="/program/my-programs">

                            @if (Lang::has('communicate.My Program'))
                                <span>{{ __('communicate.My Program') ?? 'My Program' }}</span>
                            @else
                                <span>{{ __('My Program') ?? 'My Program' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'programs.mark' ? 'active' : '' }}"
                            href="/program/program-mark">

                            @if (Lang::has('communicate.Mark'))
                                <span>{{ __('communicate.Mark') ?? 'Mark' }}</span>
                            @else
                                <span>{{ __('Mark') ?? 'Mark' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'programs.my-student' ? 'active' : '' }}"
                            href="/program/my-students">

                            @if (Lang::has('communicate.My Student'))
                                <span>{{ __('communicate.My Student') ?? 'My Student' }}</span>
                            @else
                                <span>{{ __('My Student') ?? 'My Student' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'programs.routines' ? 'active' : '' }}"
                            href="/program/routines">

                            @if (Lang::has('communicate.Routines'))
                                <span>{{ __('communicate.Routines') ?? 'Routines' }}</span>
                            @else
                                <span>{{ __('Routines') ?? 'Routines' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'mark-report' ? 'active' : '' }}"
                            href="/program/mark-report">

                            @if (Lang::has('communicate.Mark Report'))
                                <span>{{ __('communicate.Mark Report') ?? 'Mark Report' }}</span>
                            @else
                                <span>{{ __('Mark Report') ?? 'Mark Report' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li><span class="menu_seperator">Student</span></li>

            <li
                class="{{ spn_active_link('student-category', 'mm-active') }} {{ spn_active_link('student-admission', 'mm-active') }} {{ spn_active_link('student-list', 'mm-active') }} {{ spn_active_link('multi-class-student', 'mm-active') }} {{ spn_active_link('delete-student-record', 'mm-active') }} {{ spn_active_link('unassigned-student', 'mm-active') }} {{ spn_active_link('student-attendance', 'mm-active') }} {{ spn_active_link('student-group', 'mm-active') }} {{ spn_active_link('student-promote', 'mm-active') }} {{ spn_active_link('disabled-student', 'mm-active') }} {{ spn_active_link('subject-wise-attendance', 'mm-active') }} {{ spn_active_link('all-student-export', 'mm-active') }} {{ spn_active_link('studentabsentnotification', 'mm-active') }} {{ spn_active_link('graduated-students', 'mm-active') }} {{ spn_active_link('unapproved-students', 'mm-active') }} {{ spn_active_link('student-attendance-request', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['student_category', 'student_admission', 'student_list', 'student.multi-class-student', 'student.delete-student-record', 'unassigned_student', 'student_attendance', 'student_group', 'student_promote', 'disabled_student', 'subject-wise-attendance', 'all-student-export', 'notification_time_setup', 'graduated_students', 'unapproved_students', 'student_attendance_request']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-user-tie"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.student.student_information'))
                            <span>{{ __('communicate.student.student_information') ?? 'Student Info' }}</span>
                        @else
                            <span>{{ __('student.student_information') ?? 'Student Info' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student_category' ? 'active' : '' }}"
                            href="/student-category">

                            @if (Lang::has('communicate.student.student_category'))
                                <span>{{ __('communicate.student.student_category') ?? 'Student Category' }}</span>
                            @else
                                <span>{{ __('student.student_category') ?? 'Student Category' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student_admission' ? 'active' : '' }}"
                            href="/student-admission">

                            @if (Lang::has('communicate.student.add_student'))
                                <span>{{ __('communicate.student.add_student') ?? 'Add Student' }}</span>
                            @else
                                <span>{{ __('student.add_student') ?? 'Add Student' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student_list' ? 'active' : '' }}"
                            href="/student-list">

                            @if (Lang::has('communicate.student.student_list'))
                                <span>{{ __('communicate.student.student_list') ?? 'Student List' }}</span>
                            @else
                                <span>{{ __('student.student_list') ?? 'Student List' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student.multi-class-student' ? 'active' : '' }}"
                            href="/multi-class-student">

                            @if (Lang::has('communicate.student.multi_class_student'))
                                <span>{{ __('communicate.student.multi_class_student') ?? 'Multi Class Student' }}</span>
                            @else
                                <span>{{ __('student.multi_class_student') ?? 'Multi Class Student' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student.delete-student-record' ? 'active' : '' }}"
                            href="/delete-student-record">

                            @if (Lang::has('communicate.student.delete_student_record'))
                                <span>{{ __('communicate.student.delete_student_record') ?? 'Delete Student Record' }}</span>
                            @else
                                <span>{{ __('student.delete_student_record') ?? 'Delete Student Record' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'unassigned_student' ? 'active' : '' }}"
                            href="/unassigned-student">

                            @if (Lang::has('communicate.student.unassigned_student'))
                                <span>{{ __('communicate.student.unassigned_student') ?? 'UnAssign Student' }}</span>
                            @else
                                <span>{{ __('student.unassigned_student') ?? 'UnAssign Student' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student_attendance' ? 'active' : '' }}"
                            href="/student-attendance">

                            @if (Lang::has('communicate.student.student_attendance'))
                                <span>{{ __('communicate.student.student_attendance') ?? 'Student Attendance' }}</span>
                            @else
                                <span>{{ __('student.student_attendance') ?? 'Student Attendance' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student_group' ? 'active' : '' }}"
                            href="/student-group">

                            @if (Lang::has('communicate.student.student_group'))
                                <span>{{ __('communicate.student.student_group') ?? 'Student Group' }}</span>
                            @else
                                <span>{{ __('student.student_group') ?? 'Student Group' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student_promote' ? 'active' : '' }}"
                            href="/student-promote">

                            @if (Lang::has('communicate.student.student_promote'))
                                <span>{{ __('communicate.student.student_promote') ?? 'Student Promote' }}</span>
                            @else
                                <span>{{ __('student.student_promote') ?? 'Student Promote' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'disabled_student' ? 'active' : '' }}"
                            href="/disabled-student">

                            @if (Lang::has('communicate.student.disabled_student'))
                                <span>{{ __('communicate.student.disabled_student') ?? 'Disabled Students' }}</span>
                            @else
                                <span>{{ __('student.disabled_student') ?? 'Disabled Students' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'subject-wise-attendance' ? 'active' : '' }}"
                            href="/subject-wise-attendance">

                            @if (Lang::has('communicate.student.subject_wise_attendance'))
                                <span>{{ __('communicate.student.subject_wise_attendance') ?? 'Subject Wise Attendance' }}</span>
                            @else
                                <span>{{ __('student.subject_wise_attendance') ?? 'Subject Wise Attendance' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'all-student-export' ? 'active' : '' }}"
                            href="/all-student-export">

                            @if (Lang::has('communicate.student.student_export'))
                                <span>{{ __('communicate.student.student_export') ?? 'Student Export' }}</span>
                            @else
                                <span>{{ __('student.student_export') ?? 'Student Export' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'notification_time_setup' ? 'active' : '' }}"
                            href="/studentabsentnotification">

                            @if (Lang::has('communicate.student.sms_sending_time'))
                                <span>{{ __('communicate.student.sms_sending_time') ?? 'Time Setup' }}</span>
                            @else
                                <span>{{ __('student.sms_sending_time') ?? 'Time Setup' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'graduated_students' ? 'active' : '' }}"
                            href="/graduated-students">

                            @if (Lang::has('communicate.student.graduated_students'))
                                <span>{{ __('communicate.student.graduated_students') ?? 'Graduated Students' }}</span>
                            @else
                                <span>{{ __('student.graduated_students') ?? 'Graduated Students' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'unapproved_students' ? 'active' : '' }}"
                            href="/unapproved-students">

                            @if (Lang::has('communicate.Unapproved Students'))
                                <span>{{ __('communicate.Unapproved Students') ?? 'Unapproved Students' }}</span>
                            @else
                                <span>{{ __('Unapproved Students') ?? 'Unapproved Students' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student_attendance_request' ? 'active' : '' }}"
                            href="/student-attendance-request">

                            @if (Lang::has('communicate.Student Attendance Request'))
                                <span>{{ __('communicate.Student Attendance Request') ?? 'Student Attendance Request' }}</span>
                            @else
                                <span>{{ __('Student Attendance Request') ?? 'Student Attendance Request' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>


            <li
                class="{{ spn_active_link('behaviour_records/incident', 'mm-active') }} {{ spn_active_link('behaviour_records/assign_incident', 'mm-active') }} {{ spn_active_link('behaviour_records/student_incident_report', 'mm-active') }} {{ spn_active_link('behaviour_records/student_behaviour_rank_report', 'mm-active') }} {{ spn_active_link('behaviour_records/class_section_wise_rank_report', 'mm-active') }} {{ spn_active_link('behaviour_records/incident_wise_report', 'mm-active') }} {{ spn_active_link('behaviour_records/setting', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['behaviour_records.incident', 'behaviour_records.assign-incident', 'behaviour_records.student_incident_report', 'behaviour_records.student_behaviour_rank_report', 'behaviour_records.class_section_wise_rank_report', 'behaviour_records.incident_wise_report', 'behaviour_records.setting']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-clipboard"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.behaviourRecords.behaviour_records'))
                            <span>{{ __('communicate.behaviourRecords.behaviour_records') ?? 'Behaviour Records' }}</span>
                        @else
                            <span>{{ __('behaviourRecords.behaviour_records') ?? 'Behaviour Records' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'behaviour_records.incident' ? 'active' : '' }}"
                            href="/behaviour_records/incident">

                            @if (Lang::has('communicate.behaviourRecords.incidents'))
                                <span>{{ __('communicate.behaviourRecords.incidents') ?? 'Incidents' }}</span>
                            @else
                                <span>{{ __('behaviourRecords.incidents') ?? 'Incidents' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'behaviour_records.assign-incident' ? 'active' : '' }}"
                            href="/behaviour_records/assign_incident">

                            @if (Lang::has('communicate.behaviourRecords.assign_incident'))
                                <span>{{ __('communicate.behaviourRecords.assign_incident') ?? 'Assign Incident' }}</span>
                            @else
                                <span>{{ __('behaviourRecords.assign_incident') ?? 'Assign Incident' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'behaviour_records.student_incident_report' ? 'active' : '' }}"
                            href="/behaviour_records/student_incident_report">

                            @if (Lang::has('communicate.behaviourRecords.student_incident_report'))
                                <span>{{ __('communicate.behaviourRecords.student_incident_report') ?? 'Student Incident Report' }}</span>
                            @else
                                <span>{{ __('behaviourRecords.student_incident_report') ?? 'Student Incident Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'behaviour_records.student_behaviour_rank_report' ? 'active' : '' }}"
                            href="/behaviour_records/student_behaviour_rank_report">

                            @if (Lang::has('communicate.behaviourRecords.behaviour_reports'))
                                <span>{{ __('communicate.behaviourRecords.behaviour_reports') ?? 'Behaviour Report' }}</span>
                            @else
                                <span>{{ __('behaviourRecords.behaviour_reports') ?? 'Behaviour Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'behaviour_records.class_section_wise_rank_report' ? 'active' : '' }}"
                            href="/behaviour_records/class_section_wise_rank_report">

                            @if (Lang::has('communicate.behaviourRecords.class_section_report'))
                                <span>{{ __('communicate.behaviourRecords.class_section_report') ?? 'Class Section Report' }}</span>
                            @else
                                <span>{{ __('behaviourRecords.class_section_report') ?? 'Class Section Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'behaviour_records.incident_wise_report' ? 'active' : '' }}"
                            href="/behaviour_records/incident_wise_report">

                            @if (Lang::has('communicate.behaviourRecords.incident_wise_report'))
                                <span>{{ __('communicate.behaviourRecords.incident_wise_report') ?? 'Incident Wise Report' }}</span>
                            @else
                                <span>{{ __('behaviourRecords.incident_wise_report') ?? 'Incident Wise Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'behaviour_records.setting' ? 'active' : '' }}"
                            href="/behaviour_records/setting">

                            @if (Lang::has('communicate.behaviourRecords.behaviour_settings'))
                                <span>{{ __('communicate.behaviourRecords.behaviour_settings') ?? 'Behaviour Settings' }}</span>
                            @else
                                <span>{{ __('behaviourRecords.behaviour_settings') ?? 'Behaviour Settings' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="{{ spn_active_link('fees/fees-group', 'mm-active') }} {{ spn_active_link('fees/fees-type', 'mm-active') }} {{ spn_active_link('fees/fees-invoice-list', 'mm-active') }} {{ spn_active_link('fees-forward', 'mm-active') }} {{ spn_active_link('fees/admissionfees-amount', 'mm-active') }} {{ spn_active_link('fees/admission-fees-invoice-list', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['fees.fees-group', 'fees.fees-type', 'fees.fees-invoice-list', 'fees_forward', 'admission_fees', 'admissionfees-invoice-list']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-money"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.fees.fees'))
                            <span>{{ __('communicate.fees.fees') ?? 'Fees' }}</span>
                        @else
                            <span>{{ __('fees.fees') ?? 'Fees' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'fees.fees-group' ? 'active' : '' }}"
                            href="/fees/fees-group">

                            @if (Lang::has('communicate.fees.fees_group'))
                                <span>{{ __('communicate.fees.fees_group') ?? 'Fees Group' }}</span>
                            @else
                                <span>{{ __('fees.fees_group') ?? 'Fees Group' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'fees.fees-type' ? 'active' : '' }}"
                            href="/fees/fees-type">

                            @if (Lang::has('communicate.fees.fees_type'))
                                <span>{{ __('communicate.fees.fees_type') ?? 'Fees Type' }}</span>
                            @else
                                <span>{{ __('fees.fees_type') ?? 'Fees Type' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'fees_forward' ? 'active' : '' }}"
                            href="/fees-forward">

                            @if (Lang::has('communicate.fees.fees_forward'))
                                <span>{{ __('communicate.fees.fees_forward') ?? 'Fees Carry Forward' }}</span>
                            @else
                                <span>{{ __('fees.fees_forward') ?? 'Fees Carry Forward' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'fees.fees-invoice-list' ? 'active' : '' }}"
                            href="/fees/fees-invoice-list">

                            @if (Lang::has('communicate.fees::feesModule.fees_invoice'))
                                <span>{{ __('communicate.fees::feesModule.fees_invoice') ?? 'Fees Invoice' }}</span>
                            @else
                                <span>{{ __('fees::feesModule.fees_invoice') ?? 'Fees Invoice' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'admission_fees' ? 'active' : '' }}"
                            href="/fees/admissionfees-amount">

                            @if (Lang::has('communicate.Admission Fees'))
                                <span>{{ __('communicate.Admission Fees') ?? 'Fees Invoice' }}</span>
                            @else
                                <span>{{ __('Admission Fees') ?? 'Fees Invoice' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'admissionfees-invoice-list' ? 'active' : '' }}"
                            href="/fees/admission-fees-invoice-list">

                            @if (Lang::has('communicate.Admission Fees Invoice'))
                                <span>{{ __('communicate.Admission Fees Invoice') ?? 'Admission Fees invoice' }}</span>
                            @else
                                <span>{{ __('Admission Fees Invoice') ?? 'Admission Fees invoice' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="{{ spn_active_link('add-homeworks', 'mm-active') }} {{ spn_active_link('homework-list', 'mm-active') }} {{ spn_active_link('homework-report', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['add-homeworks', 'homework-list', 'homework-report']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-book-open"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.homework.home_work'))
                            <span>{{ __('communicate.homework.home_work') ?? 'Homework' }}</span>
                        @else
                            <span>{{ __('homework.home_work') ?? 'Homework' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'add-homeworks' ? 'active' : '' }}"
                            href="/add-homeworks">

                            @if (Lang::has('communicate.homework.add_homework'))
                                <span>{{ __('communicate.homework.add_homework') ?? 'Add Homework' }}</span>
                            @else
                                <span>{{ __('homework.add_homework') ?? 'Add Homework' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'homework-list' ? 'active' : '' }}"
                            href="/homework-list">

                            @if (Lang::has('communicate.homework.homework_list'))
                                <span>{{ __('communicate.homework.homework_list') ?? 'Homework List' }}</span>
                            @else
                                <span>{{ __('homework.homework_list') ?? 'Homework List' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'homework-report' ? 'active' : '' }}"
                            href="/homework-report">

                            @if (Lang::has('communicate.homework.homework_report'))
                                <span>{{ __('communicate.homework.homework_report') ?? 'Homework Report' }}</span>
                            @else
                                <span>{{ __('homework.homework_report') ?? 'Homework Report' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="{{ spn_active_link('scholarships/add-scholarship', 'mm-active') }} {{ spn_active_link('scholarships/assign-student', 'mm-active') }} {{ spn_active_link('scholarships/add-stipend', 'mm-active') }} {{ spn_active_link('scholarships/stipend-records', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['add-scholarship', 'assign-student', 'add-stipend', 'stipend-records']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-graduation-cap"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.Scholarships'))
                            <span>{{ __('communicate.Scholarships') ?? 'scholarships' }}</span>
                        @else
                            <span>{{ __('Scholarships') ?? 'scholarships' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'add-scholarship' ? 'active' : '' }}"
                            href="/scholarships/add-scholarship">

                            @if (Lang::has('communicate.Add Scholarship'))
                                <span>{{ __('communicate.Add Scholarship') ?? 'Add Scholarship' }}</span>
                            @else
                                <span>{{ __('Add Scholarship') ?? 'Add Scholarship' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'assign-student' ? 'active' : '' }}"
                            href="/scholarships/assign-student">

                            @if (Lang::has('communicate.Assign Student'))
                                <span>{{ __('communicate.Assign Student') ?? 'Assign Student' }}</span>
                            @else
                                <span>{{ __('Assign Student') ?? 'Assign Student' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'add-stipend' ? 'active' : '' }}"
                            href="/scholarships/add-stipend">

                            @if (Lang::has('communicate.Add Stipend'))
                                <span>{{ __('communicate.Add Stipend') ?? 'Add Stipend' }}</span>
                            @else
                                <span>{{ __('Add Stipend') ?? 'Add Stipend' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'stipend-records' ? 'active' : '' }}"
                            href="/scholarships/stipend-records">

                            @if (Lang::has('communicate.Stipend Records'))
                                <span>{{ __('communicate.Stipend Records') ?? 'Stipend Records' }}</span>
                            @else
                                <span>{{ __('Stipend Records') ?? 'Stipend Records' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li><span class="menu_seperator">Exam</span></li>

            <li
                class="{{ spn_active_link('exam-type', 'mm-active') }} {{ spn_active_link('exam', 'mm-active') }} {{ spn_active_link('exam-schedule', 'mm-active') }} {{ spn_active_link('exam-attendance', 'mm-active') }} {{ spn_active_link('marks-register', 'mm-active') }} {{ spn_active_link('marks-grade', 'mm-active') }} {{ spn_active_link('send-marks-by-sms', 'mm-active') }} {{ spn_active_link('custom-marksheet-report', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['exam-type', 'exam', 'exam_schedule', 'exam_attendance', 'marks_register', 'marks-grade', 'send_marks_by_sms', 'custom-marksheet-report']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fa fa-map-o"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.exam.examination'))
                            <span>{{ __('communicate.exam.examination') ?? 'Examination' }}</span>
                        @else
                            <span>{{ __('exam.examination') ?? 'Examination' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'exam-type' ? 'active' : '' }}"
                            href="/exam-type">

                            @if (Lang::has('communicate.exam.exam_type'))
                                <span>{{ __('communicate.exam.exam_type') ?? 'Exam Type' }}</span>
                            @else
                                <span>{{ __('exam.exam_type') ?? 'Exam Type' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'exam' ? 'active' : '' }}"
                            href="/exam">

                            @if (Lang::has('communicate.exam.exam_setup'))
                                <span>{{ __('communicate.exam.exam_setup') ?? 'Exam Setup' }}</span>
                            @else
                                <span>{{ __('exam.exam_setup') ?? 'Exam Setup' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'exam_schedule' ? 'active' : '' }}"
                            href="/exam-schedule">

                            @if (Lang::has('communicate.exam.exam_schedule'))
                                <span>{{ __('communicate.exam.exam_schedule') ?? 'Subject Mark Sheet' }}</span>
                            @else
                                <span>{{ __('exam.exam_schedule') ?? 'Subject Mark Sheet' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'exam_attendance' ? 'active' : '' }}"
                            href="/exam-attendance">

                            @if (Lang::has('communicate.exam.exam_attendance'))
                                <span>{{ __('communicate.exam.exam_attendance') ?? 'Final Mark Sheet' }}</span>
                            @else
                                <span>{{ __('exam.exam_attendance') ?? 'Final Mark Sheet' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'marks_register' ? 'active' : '' }}"
                            href="/marks-register">

                            @if (Lang::has('communicate.exam.marks_register'))
                                <span>{{ __('communicate.exam.marks_register') ?? 'Student Final Mark Sheet' }}</span>
                            @else
                                <span>{{ __('exam.marks_register') ?? 'Student Final Mark Sheet' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'marks-grade' ? 'active' : '' }}"
                            href="/marks-grade">

                            @if (Lang::has('communicate.exam.marks_grade'))
                                <span>{{ __('communicate.exam.marks_grade') ?? 'Marks Grade' }}</span>
                            @else
                                <span>{{ __('exam.marks_grade') ?? 'Marks Grade' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'send_marks_by_sms' ? 'active' : '' }}"
                            href="/send-marks-by-sms">

                            @if (Lang::has('communicate.exam.send_marks_by_sms'))
                                <span>{{ __('communicate.exam.send_marks_by_sms') ?? 'Send Marks By SMS' }}</span>
                            @else
                                <span>{{ __('exam.send_marks_by_sms') ?? 'Send Marks By SMS' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'custom-marksheet-report' ? 'active' : '' }}"
                            href="/custom-marksheet-report">

                            @if (Lang::has('communicate.exam.marksheet_report'))
                                <span>{{ __('communicate.exam.marksheet_report') ?? 'MarkSheet Report' }}</span>
                            @else
                                <span>{{ __('exam.marksheet_report') ?? 'MarkSheet Report' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="{{ spn_active_link('examplan/admitcard', 'mm-active') }} {{ spn_active_link('examplan/seatplan', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['examplan.admitcard.index', 'examplan.seatplan.index']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="flaticon-test"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.examplan::exp.exam_plan'))
                            <span>{{ __('communicate.examplan::exp.exam_plan') ?? 'ExamPlan' }}</span>
                        @else
                            <span>{{ __('examplan::exp.exam_plan') ?? 'ExamPlan' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'examplan.admitcard.index' ? 'active' : '' }}"
                            href="/examplan/admitcard">

                            @if (Lang::has('communicate.examplan::exp.admit_card'))
                                <span>{{ __('communicate.examplan::exp.admit_card') ?? 'Admit Card' }}</span>
                            @else
                                <span>{{ __('examplan::exp.admit_card') ?? 'Admit Card' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'examplan.seatplan.index' ? 'active' : '' }}"
                            href="/examplan/seatplan">

                            @if (Lang::has('communicate.examplan::exp.seat_plan'))
                                <span>{{ __('communicate.examplan::exp.seat_plan') ?? 'Seat Plan' }}</span>
                            @else
                                <span>{{ __('examplan::exp.seat_plan') ?? 'Seat Plan' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="{{ spn_active_link('question-group', 'mm-active') }} {{ spn_active_link('question-bank', 'mm-active') }} {{ spn_active_link('online-exam', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['question-group', 'question-bank', 'online-exam']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-globe"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.exam.online_exam'))
                            <span>{{ __('communicate.exam.online_exam') ?? 'Online Exam' }}</span>
                        @else
                            <span>{{ __('exam.online_exam') ?? 'Online Exam' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'question-group' ? 'active' : '' }}"
                            href="/question-group">

                            @if (Lang::has('communicate.exam.question_group'))
                                <span>{{ __('communicate.exam.question_group') ?? 'Question Group' }}</span>
                            @else
                                <span>{{ __('exam.question_group') ?? 'Question Group' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'question-bank' ? 'active' : '' }}"
                            href="/question-bank">

                            @if (Lang::has('communicate.exam.question_bank'))
                                <span>{{ __('communicate.exam.question_bank') ?? 'Question Bank' }}</span>
                            @else
                                <span>{{ __('exam.question_bank') ?? 'Question Bank' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'online-exam' ? 'active' : '' }}"
                            href="/online-exam">

                            @if (Lang::has('communicate.exam.online_exam'))
                                <span>{{ __('communicate.exam.online_exam') ?? 'Online Exam' }}</span>
                            @else
                                <span>{{ __('exam.online_exam') ?? 'Online Exam' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li><span class="menu_seperator">HR</span></li>

            <li
                class="{{ spn_active_link('designation', 'mm-active') }} {{ spn_active_link('department', 'mm-active') }} {{ spn_active_link('add-staff', 'mm-active') }} {{ spn_active_link('staff-directory', 'mm-active') }} {{ spn_active_link('staff-attendance', 'mm-active') }} {{ spn_active_link('payroll', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['designation', 'department', 'addStaff', 'staff_directory', 'staff_attendance', 'payroll']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-users-cog"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.hr.human_resource'))
                            <span>{{ __('communicate.hr.human_resource') ?? 'Human Resource' }}</span>
                        @else
                            <span>{{ __('hr.human_resource') ?? 'Human Resource' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'designation' ? 'active' : '' }}"
                            href="/designation">

                            @if (Lang::has('communicate.hr.designation'))
                                <span>{{ __('communicate.hr.designation') ?? 'Designation' }}</span>
                            @else
                                <span>{{ __('hr.designation') ?? 'Designation' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'department' ? 'active' : '' }}"
                            href="/department">

                            @if (Lang::has('communicate.hr.department'))
                                <span>{{ __('communicate.hr.department') ?? 'Department' }}</span>
                            @else
                                <span>{{ __('hr.department') ?? 'Department' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'addStaff' ? 'active' : '' }}"
                            href="/add-staff">

                            @if (Lang::has('communicate.common.add_staff'))
                                <span>{{ __('communicate.common.add_staff') ?? 'Add Staff' }}</span>
                            @else
                                <span>{{ __('common.add_staff') ?? 'Add Staff' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'staff_directory' ? 'active' : '' }}"
                            href="/staff-directory">

                            @if (Lang::has('communicate.hr.staff_directory'))
                                <span>{{ __('communicate.hr.staff_directory') ?? 'Staff Directory' }}</span>
                            @else
                                <span>{{ __('hr.staff_directory') ?? 'Staff Directory' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'staff_attendance' ? 'active' : '' }}"
                            href="/staff-attendance">

                            @if (Lang::has('communicate.hr.staff_attendance'))
                                <span>{{ __('communicate.hr.staff_attendance') ?? 'Staff Attendance' }}</span>
                            @else
                                <span>{{ __('hr.staff_attendance') ?? 'Staff Attendance' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'payroll' ? 'active' : '' }}"
                            href="/payroll">

                            @if (Lang::has('communicate.hr.payroll'))
                                <span>{{ __('communicate.hr.payroll') ?? 'Payroll' }}</span>
                            @else
                                <span>{{ __('hr.payroll') ?? 'Payroll' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="{{ spn_active_link('teacher-approved-evaluation-report', 'mm-active') }} {{ spn_active_link('teacher-pending-evaluation-report', 'mm-active') }} {{ spn_active_link('teacher-wise-evaluation-report', 'mm-active') }} {{ spn_active_link('teacher-evaluation-setting', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['teacher-approved-evaluation-report', 'teacher-pending-evaluation-report', 'teacher-wise-evaluation-report', 'teacher-evaluation-setting']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-star"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.teacherEvaluation.teacher_evaluation'))
                            <span>{{ __('communicate.teacherEvaluation.teacher_evaluation') ?? 'Teacher Evaluation' }}</span>
                        @else
                            <span>{{ __('teacherEvaluation.teacher_evaluation') ?? 'Teacher Evaluation' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'teacher-approved-evaluation-report' ? 'active' : '' }}"
                            href="/teacher-approved-evaluation-report">

                            @if (Lang::has('communicate.teacherEvaluation.approved_evaluation_report'))
                                <span>{{ __('communicate.teacherEvaluation.approved_evaluation_report') ?? 'Approved Evaluation Report' }}</span>
                            @else
                                <span>{{ __('teacherEvaluation.approved_evaluation_report') ?? 'Approved Evaluation Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'teacher-pending-evaluation-report' ? 'active' : '' }}"
                            href="/teacher-pending-evaluation-report">

                            @if (Lang::has('communicate.teacherEvaluation.pending_evaluation_report'))
                                <span>{{ __('communicate.teacherEvaluation.pending_evaluation_report') ?? 'Pending Evaluation Report' }}</span>
                            @else
                                <span>{{ __('teacherEvaluation.pending_evaluation_report') ?? 'Pending Evaluation Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'teacher-wise-evaluation-report' ? 'active' : '' }}"
                            href="/teacher-wise-evaluation-report">

                            @if (Lang::has('communicate.teacherEvaluation.teacher_wise_evaluation_report'))
                                <span>{{ __('communicate.teacherEvaluation.teacher_wise_evaluation_report') ?? 'Wise Evaluation Report' }}</span>
                            @else
                                <span>{{ __('teacherEvaluation.teacher_wise_evaluation_report') ?? 'Wise Evaluation Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'teacher-evaluation-setting' ? 'active' : '' }}"
                            href="/teacher-evaluation-setting">

                            @if (Lang::has('communicate.teacherEvaluation.settings'))
                                <span>{{ __('communicate.teacherEvaluation.settings') ?? 'Setting' }}</span>
                            @else
                                <span>{{ __('teacherEvaluation.settings') ?? 'Setting' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="{{ spn_active_link('apply-leave', 'mm-active') }} {{ spn_active_link('approve-leave', 'mm-active') }} {{ spn_active_link('pending-leave', 'mm-active') }} {{ spn_active_link('leave-define', 'mm-active') }} {{ spn_active_link('leave-type', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['apply-leave', 'approve-leave', 'pending-leave', 'leave-define', 'leave-type']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="flaticon-slumber"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.leave.leave'))
                            <span>{{ __('communicate.leave.leave') ?? 'Leave' }}</span>
                        @else
                            <span>{{ __('leave.leave') ?? 'Leave' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'apply-leave' ? 'active' : '' }}"
                            href="/apply-leave">

                            @if (Lang::has('communicate.leave.apply_leave'))
                                <span>{{ __('communicate.leave.apply_leave') ?? 'Apply Leave' }}</span>
                            @else
                                <span>{{ __('leave.apply_leave') ?? 'Apply Leave' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'approve-leave' ? 'active' : '' }}"
                            href="/approve-leave">

                            @if (Lang::has('communicate.leave.approve_leave_request'))
                                <span>{{ __('communicate.leave.approve_leave_request') ?? 'Approve Leave Request' }}</span>
                            @else
                                <span>{{ __('leave.approve_leave_request') ?? 'Approve Leave Request' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'pending-leave' ? 'active' : '' }}"
                            href="/pending-leave">

                            @if (Lang::has('communicate.leave.pending_leave_request'))
                                <span>{{ __('communicate.leave.pending_leave_request') ?? 'Pending Leave' }}</span>
                            @else
                                <span>{{ __('leave.pending_leave_request') ?? 'Pending Leave' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'leave-define' ? 'active' : '' }}"
                            href="/leave-define">

                            @if (Lang::has('communicate.leave.leave_define'))
                                <span>{{ __('communicate.leave.leave_define') ?? 'Leave Define' }}</span>
                            @else
                                <span>{{ __('leave.leave_define') ?? 'Leave Define' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'leave-type' ? 'active' : '' }}"
                            href="/leave-type">

                            @if (Lang::has('communicate.leave.leave_type'))
                                <span>{{ __('communicate.leave.leave_type') ?? 'Leave Type' }}</span>
                            @else
                                <span>{{ __('leave.leave_type') ?? 'Leave Type' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="{{ spn_active_link('login-access-control', 'mm-active') }} {{ spn_active_link('rolepermission/role', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['login-access-control', 'rolepermission/role']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="flaticon-authentication"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.rolepermission::role.role_&_permission'))
                            <span>{{ __('communicate.rolepermission::role.role_&_permission') ?? 'Role & Permission' }}</span>
                        @else
                            <span>{{ __('rolepermission::role.role_&_permission') ?? 'Role & Permission' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'login-access-control' ? 'active' : '' }}"
                            href="/login-access-control">

                            @if (Lang::has('communicate.rolepermission::role.login_permission'))
                                <span>{{ __('communicate.rolepermission::role.login_permission') ?? 'Login Permission' }}</span>
                            @else
                                <span>{{ __('rolepermission::role.login_permission') ?? 'Login Permission' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'rolepermission/role' ? 'active' : '' }}"
                            href="/rolepermission/role">

                            @if (Lang::has('communicate.rolepermission::role.role'))
                                <span>{{ __('communicate.rolepermission::role.role') ?? 'Role' }}</span>
                            @else
                                <span>{{ __('rolepermission::role.role') ?? 'Role' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'due_fees_login_permission' ? 'active' : '' }}"
                            href="/due_fees_login_permission">

                            @if (Lang::has('communicate.rolepermission::role.due_fees_login_permission'))
                                <span>{{ __('communicate.rolepermission::role.due_fees_login_permission') ?? 'Due Fees Login Permission' }}</span>
                            @else
                                <span>{{ __('rolepermission::role.due_fees_login_permission') ?? 'Due Fees Login Permission' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>


            <li><span class="menu_seperator">Accounts</span></li>


            <li
                class="{{ spn_active_link('wallet/pending-diposit', 'mm-active') }} {{ spn_active_link('wallet/approve-diposit', 'mm-active') }} {{ spn_active_link('wallet/reject-diposit', 'mm-active') }} {{ spn_active_link('wallet/wallet-transaction', 'mm-active') }} {{ spn_active_link('wallet/wallet-refund-request', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['wallet.pending-diposit', 'wallet.approve-diposit', 'wallet.reject-diposit', 'wallet.wallet-transaction', 'wallet.wallet-refund-request']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="ti-wallet"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.wallet::wallet.wallet'))
                            <span>{{ __('communicate.wallet::wallet.wallet') ?? 'Wallet' }}</span>
                        @else
                            <span>{{ __('wallet::wallet.wallet') ?? 'Wallet' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'wallet.pending-diposit' ? 'active' : '' }}"
                            href="/wallet/pending-diposit">

                            @if (Lang::has('communicate.wallet::wallet.pending_deposit'))
                                <span>{{ __('communicate.wallet::wallet.pending_deposit') ?? 'Pending Diposite' }}</span>
                            @else
                                <span>{{ __('wallet::wallet.pending_deposit') ?? 'Pending Diposite' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'wallet.approve-diposit' ? 'active' : '' }}"
                            href="/wallet/approve-diposit">

                            @if (Lang::has('communicate.wallet::wallet.approve_deposit'))
                                <span>{{ __('communicate.wallet::wallet.approve_deposit') ?? 'Approve Diposite' }}</span>
                            @else
                                <span>{{ __('wallet::wallet.approve_deposit') ?? 'Approve Diposite' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'wallet.reject-diposit' ? 'active' : '' }}"
                            href="/wallet/reject-diposit">

                            @if (Lang::has('communicate.wallet::wallet.reject_deposit'))
                                <span>{{ __('communicate.wallet::wallet.reject_deposit') ?? 'Reject Diposite' }}</span>
                            @else
                                <span>{{ __('wallet::wallet.reject_deposit') ?? 'Reject Diposite' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'wallet.wallet-transaction' ? 'active' : '' }}"
                            href="/wallet/wallet-transaction">

                            @if (Lang::has('communicate.wallet::wallet.wallet_transaction'))
                                <span>{{ __('communicate.wallet::wallet.wallet_transaction') ?? 'Wallet Transaction' }}</span>
                            @else
                                <span>{{ __('wallet::wallet.wallet_transaction') ?? 'Wallet Transaction' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'wallet.wallet-refund-request' ? 'active' : '' }}"
                            href="/wallet/wallet-refund-request">

                            @if (Lang::has('communicate.wallet::wallet.refund_request'))
                                <span>{{ __('communicate.wallet::wallet.refund_request') ?? 'Wallet Refund Request' }}</span>
                            @else
                                <span>{{ __('wallet::wallet.refund_request') ?? 'Wallet Refund Request' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="{{ spn_active_link('profit', 'mm-active') }} {{ spn_active_link('add-income', 'mm-active') }} {{ spn_active_link('add-expense', 'mm-active') }} {{ spn_active_link('chart-of-account', 'mm-active') }} {{ spn_active_link('bank-account', 'mm-active') }} {{ spn_active_link('fund-transfer', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['profit', 'add_income', 'add_expense', 'chart-of-account', 'bank-account', 'fund-transfer']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-university"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.accounts.accounts'))
                            <span>{{ __('communicate.accounts.accounts') ?? 'Accounts' }}</span>
                        @else
                            <span>{{ __('accounts.accounts') ?? 'Accounts' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'profit' ? 'active' : '' }}"
                            href="/profit">

                            @if (Lang::has('communicate.accounts.profit_&_loss'))
                                <span>{{ __('communicate.accounts.profit_&_loss') ?? 'Profit & Loss' }}</span>
                            @else
                                <span>{{ __('accounts.profit_&_loss') ?? 'Profit & Loss' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'add_income' ? 'active' : '' }}"
                            href="/add-income">

                            @if (Lang::has('communicate.accounts.income'))
                                <span>{{ __('communicate.accounts.income') ?? 'Income' }}</span>
                            @else
                                <span>{{ __('accounts.income') ?? 'Income' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'add-expense' ? 'active' : '' }}"
                            href="/add-expense">

                            @if (Lang::has('communicate.accounts.expense'))
                                <span>{{ __('communicate.accounts.expense') ?? 'Expense' }}</span>
                            @else
                                <span>{{ __('accounts.expense') ?? 'Expense' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'chart-of-account' ? 'active' : '' }}"
                            href="/chart-of-account">

                            @if (Lang::has('communicate.accounts.chart_of_account'))
                                <span>{{ __('communicate.accounts.chart_of_account') ?? 'Chart of Account' }}</span>
                            @else
                                <span>{{ __('accounts.chart_of_account') ?? 'Chart of Account' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'bank-account' ? 'active' : '' }}"
                            href="/bank-account">

                            @if (Lang::has('communicate.accounts.bank_account'))
                                <span>{{ __('communicate.accounts.bank_account') ?? 'Bank Account' }}</span>
                            @else
                                <span>{{ __('accounts.bank_account') ?? 'Bank Account' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'fund-transfer' ? 'active' : '' }}"
                            href="/fund-transfer">

                            @if (Lang::has('communicate.accounts.fund_transfer'))
                                <span>{{ __('communicate.accounts.fund_transfer') ?? 'Fund Transfer' }}</span>
                            @else
                                <span>{{ __('accounts.fund_transfer') ?? 'Fund Transfer' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>


            <!-- <li
                class="{{ spn_active_link('item-category', 'mm-active') }} {{ spn_active_link('item-list', 'mm-active') }} {{ spn_active_link('item-store', 'mm-active') }} {{ spn_active_link('suppliers', 'mm-active') }} {{ spn_active_link('item-receive', 'mm-active') }} {{ spn_active_link('item-receive-list', 'mm-active') }} {{ spn_active_link('item-sell-list', 'mm-active') }} {{ spn_active_link('item-issue', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['item-category', 'item-list', 'item-store', 'suppliers', 'item-receive', 'item-receive-list', 'item-sell-list', 'item-issue']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="flaticon-inventory"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.inventory.inventory'))
                            <span>{{ __('communicate.inventory.inventory') ?? 'Inventory' }}</span>
                        @else
                            <span>{{ __('inventory.inventory') ?? 'Inventory' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'item-category' ? 'active' : '' }}"
                            href="/item-category">

                            @if (Lang::has('communicate.inventory.item_category'))
                                <span>{{ __('communicate.inventory.item_category') ?? 'Item Category' }}</span>
                            @else
                                <span>{{ __('inventory.item_category') ?? 'Item Category' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'item-list' ? 'active' : '' }}"
                            href="/item-list">

                            @if (Lang::has('communicate.inventory.item_list'))
                                <span>{{ __('communicate.inventory.item_list') ?? 'Item List' }}</span>
                            @else
                                <span>{{ __('inventory.item_list') ?? 'Item List' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'item-store' ? 'active' : '' }}"
                            href="/item-store">

                            @if (Lang::has('communicate.inventory.item_store'))
                                <span>{{ __('communicate.inventory.item_store') ?? 'Item Store' }}</span>
                            @else
                                <span>{{ __('inventory.item_store') ?? 'Item Store' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'suppliers' ? 'active' : '' }}"
                            href="/suppliers">

                            @if (Lang::has('communicate.inventory.supplier'))
                                <span>{{ __('communicate.inventory.supplier') ?? 'Supplier' }}</span>
                            @else
                                <span>{{ __('inventory.supplier') ?? 'Supplier' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'item-receive' ? 'active' : '' }}"
                            href="/item-receive-list">

                            @if (Lang::has('communicate.inventory.item_receive'))
                                <span>{{ __('communicate.inventory.item_receive') ?? 'Item Receive' }}</span>
                            @else
                                <span>{{ __('inventory.item_receive') ?? 'Item Receive' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'item-receive-list' ? 'active' : '' }}"
                            href="/item-receive-list">

                            @if (Lang::has('communicate.inventory.item_receive_list'))
                                <span>{{ __('communicate.inventory.item_receive_list') ?? 'Item Receive List' }}</span>
                            @else
                                <span>{{ __('inventory.item_receive_list') ?? 'Item Receive List' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'item-sell-list' ? 'active' : '' }}"
                            href="/item-sell-list">

                            @if (Lang::has('communicate.inventory.item_sell'))
                                <span>{{ __('communicate.inventory.item_sell') ?? 'Item Sell' }}</span>
                            @else
                                <span>{{ __('inventory.item_sell') ?? 'Item Sell' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'item-issue' ? 'active' : '' }}"
                            href="/item-issue">

                            @if (Lang::has('communicate.inventory.item_issue'))
                                <span>{{ __('communicate.inventory.item_issue') ?? 'Item Issue' }}</span>
                            @else
                                <span>{{ __('inventory.item_issue') ?? 'Item Issue' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li> -->


            <li><span class="menu_seperator">Utilities</span></li>

            <li
                class="{{ spn_active_link('chat/open', 'mm-active') }} {{ spn_active_link('chat/invitation/index', 'mm-active') }} {{ spn_active_link('chat/users/blocked', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['chat.index', 'chat.invitation', 'chat.blocked.users']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa fa-weixin"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.chat::chat.chat'))
                            <span>{{ __('communicate.chat::chat.chat') ?? 'Chat' }}</span>
                        @else
                            <span>{{ __('chat::chat.chat') ?? 'Chat' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'chat.index' ? 'active' : '' }}"
                            href="/chat/open">

                            @if (Lang::has('communicate.chat::chat.chat_box'))
                                <span>{{ __('communicate.chat::chat.chat_box') ?? 'Chat box' }}</span>
                            @else
                                <span>{{ __('chat::chat.chat_box') ?? 'Chat box' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'chat.invitation' ? 'active' : '' }}"
                            href="/chat/invitation/index">

                            @if (Lang::has('communicate.chat::chat.invitation'))
                                <span>{{ __('communicate.chat::chat.invitation') ?? 'Invitation' }}</span>
                            @else
                                <span>{{ __('chat::chat.invitation') ?? 'Invitation' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'chat.blocked.users' ? 'active' : '' }}"
                            href="/chat/users/blocked">

                            @if (Lang::has('communicate.chat::chat.blocked_user'))
                                <span>{{ __('communicate.chat::chat.blocked_user') ?? 'Blocked User' }}</span>
                            @else
                                <span>{{ __('chat::chat.blocked_user') ?? 'Blocked User' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>


            <li
                class="{{ spn_active_link('notice-list', 'mm-active') }} {{ spn_active_link('send-email-sms-view', 'mm-active') }} {{ spn_active_link('email-sms-log', 'mm-active') }} {{ spn_active_link('event', 'mm-active') }} {{ spn_active_link('academic-calendar', 'mm-active') }} {{ spn_active_link('templatesettings/email-template', 'mm-active') }} {{ spn_active_link('templatesettings/sms-template', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['notice-list', 'send-email-sms-view', 'email-sms-log', 'event', 'academic-calendar', 'templatesettings.email-template', 'templatesettings.sms-template']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-bullhorn"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.communicate.communicate'))
                            <span>{{ __('communicate.communicate.communicate') ?? 'Communicate' }}</span>
                        @else
                            <span>{{ __('communicate.communicate') ?? 'Communicate' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'notice-list' ? 'active' : '' }}"
                            href="/notice-list">

                            @if (Lang::has('communicate.communicate.notice_board'))
                                <span>{{ __('communicate.communicate.notice_board') ?? 'Notice Board' }}</span>
                            @else
                                <span>{{ __('communicate.notice_board') ?? 'Notice Board' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'send-email-sms-view' ? 'active' : '' }}"
                            href="/send-email-sms-view">

                            @if (Lang::has('communicate.communicate.send_email_\/_sms'))
                                <span>{{ __('communicate.communicate.send_email_\/_sms') ?? 'Send Email / SMS' }}</span>
                            @else
                                <span>{{ __('communicate.send_email_\/_sms') ?? 'Send Email / SMS' }}</span>
                            @endif

                        </a>
                    </li>

                    <!-- <li>
                        <a class="text-decoration-none {{ $current_route_details == 'email-sms-log' ? 'active' : '' }}"
                            href="/email-sms-log">

                            @if (Lang::has('communicate.communicate.email_sms_log'))
                                <span>{{ __('communicate.communicate.email_sms_log') ?? 'Email / SMS Log' }}</span>
                            @else
                                <span>{{ __('communicate.email_sms_log') ?? 'Email / SMS Log' }}</span>
                            @endif
                        </a>
                    </li> -->

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'email-sms-log' ? 'active' : '' }}"
                            href="/email-sms-log">

                            @if (Lang::has('communicate.communicate.email_sms_log'))
                                <span>{{ __('communicate.communicate.email_sms_log') ?? 'Email / SMS Log' }}</span>
                            @else
                                <span>{{ __('communicate.email_sms_log') ?? 'Email / SMS Log' }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'event' ? 'active' : '' }}"
                            href="/event">

                            @if (Lang::has('communicate.communicate.event'))
                                <span>{{ __('communicate.communicate.event') ?? 'Event' }}</span>
                            @else
                                <span>{{ __('communicate.event') ?? 'Event' }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'academic-calendar' ? 'active' : '' }}"
                            href="/academic-calendar">

                            @if (Lang::has('communicate.communicate.calendar'))
                                <span>{{ __('communicate.communicate.calendar') ?? 'Calendar' }}</span>
                            @else
                                <span>{{ __('communicate.calendar') ?? 'Calendar' }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'templatesettings.email-template' ? 'active' : '' }}"
                            href="/templatesettings/email-template">

                            @if (Lang::has('communicate.communicate.email_template'))
                                <span>{{ __('communicate.communicate.email_template') ?? 'Email Template' }}</span>
                            @else
                                <span>{{ __('communicate.email_template') ?? 'Email Template' }}</span>
                            @endif
                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'templatesettings.sms-template' ? 'active' : '' }}"
                            href="/templatesettings/sms-template">

                            @if (Lang::has('communicate.communicate.sms_template'))
                                <span>{{ __('communicate.communicate.sms_template') ?? 'Sms Template' }}</span>
                            @else
                                <span>{{ __('communicate.sms_template') ?? 'Sms Template' }}</span>
                            @endif
                        </a>
                    </li>
                </ul>
            </li>


            <li
                class="{{ spn_active_link('background-setting', 'mm-active') }} {{ spn_active_link('color-style', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['background-setting', 'color-style']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-bezier-curve"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.style.style'))
                            <span>{{ __('communicate.style.style') ?? 'Style' }}</span>
                        @else
                            <span>{{ __('style.style') ?? 'Style' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'background-setting' ? 'active' : '' }}"
                            href="/background-setting">

                            @if (Lang::has('communicate.style.background_settings'))
                                <span>{{ __('communicate.style.background_settings') ?? 'Background Settings' }}</span>
                            @else
                                <span>{{ __('style.background_settings') ?? 'Background Settings' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'color-style' ? 'active' : '' }}"
                            href="/color-style">

                            @if (Lang::has('communicate.style.color_theme'))
                                <span>{{ __('communicate.style.color_theme') ?? 'Color Theme' }}</span>
                            @else
                                <span>{{ __('style.color_theme') ?? 'Color Theme' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li><span class="menu_seperator">Report</span></li>

            <li
                class="{{ spn_active_link('student-attendance-report', 'mm-active') }} {{ spn_active_link('subject-attendance-report', 'mm-active') }} {{ spn_active_link('evaluation-report', 'mm-active') }} {{ spn_active_link('student-transport-report', 'mm-active') }} {{ spn_active_link('student-dormitory-report', 'mm-active') }} {{ spn_active_link('guardian-report', 'mm-active') }} {{ spn_active_link('student-history', 'mm-active') }} {{ spn_active_link('student-login-report', 'mm-active') }} {{ spn_active_link('class-report', 'mm-active') }} {{ spn_active_link('class-routine-report', 'mm-active') }} {{ spn_active_link('user-log', 'mm-active') }} {{ spn_active_link('student-report', 'mm-active') }} {{ spn_active_link('previous-record', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['student_attendance_report', 'subject-attendance-report', 'evaluation-report', 'student_transport_report_index', 'student_dormitory_report_index', 'guardian_report', 'student_history', 'student_login_report', 'class_report', 'class_routine_report', 'user_log', 'student_report', 'previous-record']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-users"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.common.student_report'))
                            <span>{{ __('communicate.common.student_report') ?? 'Student Report' }}</span>
                        @else
                            <span>{{ __('common.student_report') ?? 'Student Report' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student_attendance_report' ? 'active' : '' }}"
                            href="/student-attendance-report">

                            @if (Lang::has('communicate.student.student_attendance_report'))
                                <span>{{ __('communicate.student.student_attendance_report') ?? 'Student Attendance Report' }}</span>
                            @else
                                <span>{{ __('student.student_attendance_report') ?? 'Student Attendance Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'subject-attendance-report' ? 'active' : '' }}"
                            href="/subject-attendance-report">

                            @if (Lang::has('communicate.student.subject_attendance_report'))
                                <span>{{ __('communicate.student.subject_attendance_report') ?? 'Subject Wise Attendance Report' }}</span>
                            @else
                                <span>{{ __('student.subject_attendance_report') ?? 'Subject Wise Attendance Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'evaluation-report' ? 'active' : '' }}"
                            href="/evaluation-report">

                            @if (Lang::has('communicate.homework.evaluation_report'))
                                <span>{{ __('communicate.homework.evaluation_report') ?? 'Homework Evaluation Report' }}</span>
                            @else
                                <span>{{ __('homework.evaluation_report') ?? 'Homework Evaluation Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <!-- <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student_transport_report_index' ? 'active' : '' }}"
                            href="/student-transport-report">

                            @if (Lang::has('communicate.transport.student_transport_report'))
                                <span>{{ __('communicate.transport.student_transport_report') ?? 'Student Transport Report' }}</span>
                            @else
                                <span>{{ __('transport.student_transport_report') ?? 'Student Transport Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student_dormitory_report_index' ? 'active' : '' }}"
                            href="/student-dormitory-report">

                            @if (Lang::has('communicate.dormitory.student_dormitory_report'))
                                <span>{{ __('communicate.dormitory.student_dormitory_report') ?? 'Student Dormitory Report' }}</span>
                            @else
                                <span>{{ __('dormitory.student_dormitory_report') ?? 'Student Dormitory Report' }}</span>
                            @endif

                        </a>
                    </li> -->

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'guardian_report' ? 'active' : '' }}"
                            href="/guardian-report">

                            @if (Lang::has('communicate.reports.guardian_report'))
                                <span>{{ __('communicate.reports.guardian_report') ?? 'Guardian Reports' }}</span>
                            @else
                                <span>{{ __('reports.guardian_report') ?? 'Guardian Reports' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student_history' ? 'active' : '' }}"
                            href="/student-history">

                            @if (Lang::has('communicate.reports.student_history'))
                                <span>{{ __('communicate.reports.student_history') ?? 'Student History' }}</span>
                            @else
                                <span>{{ __('reports.student_history') ?? 'Student History' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student_login_report' ? 'active' : '' }}"
                            href="/student-login-report">

                            @if (Lang::has('communicate.reports.student_login_report'))
                                <span>{{ __('communicate.reports.student_login_report') ?? 'Student Login Report' }}</span>
                            @else
                                <span>{{ __('reports.student_login_report') ?? 'Student Login Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'class_report' ? 'active' : '' }}"
                            href="/class-report">

                            @if (Lang::has('communicate.reports.class_report'))
                                <span>{{ __('communicate.reports.class_report') ?? 'Class Report' }}</span>
                            @else
                                <span>{{ __('reports.class_report') ?? 'Class Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'class_routine_report' ? 'active' : '' }}"
                            href="/class-routine-report">

                            @if (Lang::has('communicate.reports.class_routine'))
                                <span>{{ __('communicate.reports.class_routine') ?? 'Class Routine' }}</span>
                            @else
                                <span>{{ __('reports.class_routine') ?? 'Class Routine' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'user_log' ? 'active' : '' }}"
                            href="/user-log">

                            @if (Lang::has('communicate.reports.user_log'))
                                <span>{{ __('communicate.reports.user_log') ?? 'User Log' }}</span>
                            @else
                                <span>{{ __('reports.user_log') ?? 'User Log' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student_report' ? 'active' : '' }}"
                            href="/student-report">

                            @if (Lang::has('communicate.reports.student_report'))
                                <span>{{ __('communicate.reports.student_report') ?? 'Student Report' }}</span>
                            @else
                                <span>{{ __('reports.student_report') ?? 'Student Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'previous-record' ? 'active' : '' }}"
                            href="/previous-record">

                            @if (Lang::has('communicate.reports.previous_record'))
                                <span>{{ __('communicate.reports.previous_record') ?? 'previous record' }}</span>
                            @else
                                <span>{{ __('reports.previous_record') ?? 'previous record' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="{{ spn_active_link('exam-routine-report', 'mm-active') }} {{ spn_active_link('merit-list-report', 'mm-active') }} {{ spn_active_link('online-exam-report', 'mm-active') }} {{ spn_active_link('mark-sheet-report-student', 'mm-active') }} {{ spn_active_link('tabulation-sheet-report', 'mm-active') }} {{ spn_active_link('progress-card-report', 'mm-active') }} {{ spn_active_link('custom-progress-card-report-percent', 'mm-active') }} {{ spn_active_link('previous-class-results', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['exam_routine_report', 'merit_list_report', 'online_exam_report', 'mark_sheet_report_student', 'tabulation_sheet_report', 'progress_card_report', 'custom_progress_card_report_percent', 'previous-class-results']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="ti-agenda"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.common.exam_report'))
                            <span>{{ __('communicate.common.exam_report') ?? 'Exam Report' }}</span>
                        @else
                            <span>{{ __('common.exam_report') ?? 'Exam Report' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'exam_routine_report' ? 'active' : '' }}"
                            href="/exam-routine-report">

                            @if (Lang::has('communicate.reports.exam_routine'))
                                <span>{{ __('communicate.reports.exam_routine') ?? 'Exam Routine' }}</span>
                            @else
                                <span>{{ __('reports.exam_routine') ?? 'Exam Routine' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'merit_list_report' ? 'active' : '' }}"
                            href="/merit-list-report">

                            @if (Lang::has('communicate.reports.merit_list_report'))
                                <span>{{ __('communicate.reports.merit_list_report') ?? 'Merit List Report' }}</span>
                            @else
                                <span>{{ __('reports.merit_list_report') ?? 'Merit List Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'online_exam_report' ? 'active' : '' }}"
                            href="/online-exam-report">

                            @if (Lang::has('communicate.reports.online_exam_report'))
                                <span>{{ __('communicate.reports.online_exam_report') ?? 'Online Exam Report' }}</span>
                            @else
                                <span>{{ __('reports.online_exam_report') ?? 'Online Exam Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'mark_sheet_report_student' ? 'active' : '' }}"
                            href="/mark-sheet-report-student">

                            @if (Lang::has('communicate.reports.mark_sheet_report'))
                                <span>{{ __('communicate.reports.mark_sheet_report') ?? 'Mark Sheet Report' }}</span>
                            @else
                                <span>{{ __('reports.mark_sheet_report') ?? 'Mark Sheet Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'tabulation_sheet_report' ? 'active' : '' }}"
                            href="/tabulation-sheet-report">

                            @if (Lang::has('communicate.reports.tabulation_sheet_report'))
                                <span>{{ __('communicate.reports.tabulation_sheet_report') ?? 'Tabulation Sheet Report' }}</span>
                            @else
                                <span>{{ __('reports.tabulation_sheet_report') ?? 'Tabulation Sheet Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'progress_card_report' ? 'active' : '' }}"
                            href="/progress-card-report">

                            @if (Lang::has('communicate.reports.progress_card_report'))
                                <span>{{ __('communicate.reports.progress_card_report') ?? 'Progress Card Report' }}</span>
                            @else
                                <span>{{ __('reports.progress_card_report') ?? 'Progress Card Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'custom_progress_card_report_percent' ? 'active' : '' }}"
                            href="/custom-progress-card-report-percent">

                            @if (Lang::has('communicate.reports.progress_card_report_100_percent'))
                                <span>{{ __('communicate.reports.progress_card_report_100_percent') ?? 'Progress Card Report' }}</span>
                            @else
                                <span>{{ __('reports.progress_card_report_100_percent') ?? 'Progress Card Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'previous-class-results' ? 'active' : '' }}"
                            href="/previous-class-results">

                            @if (Lang::has('communicate.reports.previous_result'))
                                <span>{{ __('communicate.reports.previous_result') ?? 'Previous Result' }}</span>
                            @else
                                <span>{{ __('reports.previous_result') ?? 'Previous Result' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="{{ spn_active_link('staff-attendance-report', 'mm-active') }} {{ spn_active_link('payroll-report', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['staff_attendance_report', 'payroll-report']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-user-tag"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.common.staff_report'))
                            <span>{{ __('communicate.common.staff_report') ?? 'Staff Report' }}</span>
                        @else
                            <span>{{ __('common.staff_report') ?? 'Staff Report' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'staff_attendance_report' ? 'active' : '' }}"
                            href="/staff-attendance-report">

                            @if (Lang::has('communicate.hr.staff_attendance_report'))
                                <span>{{ __('communicate.hr.staff_attendance_report') ?? 'Staff Attendance Report' }}</span>
                            @else
                                <span>{{ __('hr.staff_attendance_report') ?? 'Staff Attendance Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'payroll-report' ? 'active' : '' }}"
                            href="/payroll-report">

                            @if (Lang::has('communicate.hr.payroll_report'))
                                <span>{{ __('communicate.hr.payroll_report') ?? 'Payroll Report' }}</span>
                            @else
                                <span>{{ __('hr.payroll_report') ?? 'Payroll Report' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="{{ spn_active_link('fees/due-fees', 'mm-active') }} {{ spn_active_link('fees/fine-report', 'mm-active') }} {{ spn_active_link('fees/payment-report', 'mm-active') }} {{ spn_active_link('fees/balance-report', 'mm-active') }} {{ spn_active_link('fees/waiver-report', 'mm-active') }} {{ spn_active_link('wallet/wallet-report', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['fees.due-fees', 'fees.fine-report', 'fees.payment-report', 'fees.balance-report', 'fees.waiver-report', 'wallet.wallet-report']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-server"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.common.fees_report'))
                            <span>{{ __('communicate.common.fees_report') ?? 'Fees Report' }}</span>
                        @else
                            <span>{{ __('common.fees_report') ?? 'Fees Report' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'fees.due-fees' ? 'active' : '' }}"
                            href="/fees/due-fees">

                            @if (Lang::has('communicate.fees::feesModule.fees_due_report'))
                                <span>{{ __('communicate.fees::feesModule.fees_due_report') ?? 'Fees Due Report' }}</span>
                            @else
                                <span>{{ __('fees::feesModule.fees_due_report') ?? 'Fees Due Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'fees.fine-report' ? 'active' : '' }}"
                            href="/fees/fine-report">

                            @if (Lang::has('communicate.accounts.fine_report'))
                                <span>{{ __('communicate.accounts.fine_report') ?? 'Fine Report' }}</span>
                            @else
                                <span>{{ __('accounts.fine_report') ?? 'Fine Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'fees.payment-report' ? 'active' : '' }}"
                            href="/fees/payment-report">

                            @if (Lang::has('communicate.fees::feesModule.payment_report'))
                                <span>{{ __('communicate.fees::feesModule.payment_report') ?? 'Payment Report' }}</span>
                            @else
                                <span>{{ __('fees::feesModule.payment_report') ?? 'Payment Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'fees.balance-report' ? 'active' : '' }}"
                            href="/fees/balance-report">

                            @if (Lang::has('communicate.fees::feesModule.balance_report'))
                                <span>{{ __('communicate.fees::feesModule.balance_report') ?? 'Balance Report' }}</span>
                            @else
                                <span>{{ __('fees::feesModule.balance_report') ?? 'Balance Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'fees.waiver-report' ? 'active' : '' }}"
                            href="/fees/waiver-report">

                            @if (Lang::has('communicate.fees::feesModule.waiver_report'))
                                <span>{{ __('communicate.fees::feesModule.waiver_report') ?? 'Waiver Report' }}</span>
                            @else
                                <span>{{ __('fees::feesModule.waiver_report') ?? 'Waiver Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'wallet.wallet-report' ? 'active' : '' }}"
                            href="/wallet/wallet-report">

                            @if (Lang::has('communicate.wallet::wallet.wallet_report'))
                                <span>{{ __('communicate.wallet::wallet.wallet_report') ?? 'Wallet Report' }}</span>
                            @else
                                <span>{{ __('wallet::wallet.wallet_report') ?? 'Wallet Report' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>


            <li
                class="{{ spn_active_link('accounts-payroll-report', 'mm-active') }} {{ spn_active_link('transaction', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['accounts-payroll-report', 'transaction']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-money"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.common.accounts_report'))
                            <span>{{ __('communicate.common.accounts_report') ?? 'Accounts Report' }}</span>
                        @else
                            <span>{{ __('common.accounts_report') ?? 'Accounts Report' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'accounts-payroll-report' ? 'active' : '' }}"
                            href="/accounts-payroll-report">

                            @if (Lang::has('communicate.accounts.payroll_report'))
                                <span>{{ __('communicate.accounts.payroll_report') ?? 'Payroll Report' }}</span>
                            @else
                                <span>{{ __('accounts.payroll_report') ?? 'Payroll Report' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'transaction' ? 'active' : '' }}"
                            href="/transaction">

                            @if (Lang::has('communicate.accounts.transaction'))
                                <span>{{ __('communicate.accounts.transaction') ?? 'Transaction Report' }}</span>
                            @else
                                <span>{{ __('accounts.transaction') ?? 'Transaction Report' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li><span class="menu_seperator">Settings Section</span></li>

            <li
                class="{{ spn_active_link('student-registration-custom-field', 'mm-active') }} {{ spn_active_link('staff-reg-custom-field', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['student-reg-custom-field', 'staff-reg-custom-field']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="flaticon-slumber"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.student.custom_field'))
                            <span>{{ __('communicate.student.custom_field') ?? 'Custom Field' }}</span>
                        @else
                            <span>{{ __('student.custom_field') ?? 'Custom Field' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student-reg-custom-field' ? 'active' : '' }}"
                            href="/student-registration-custom-field">

                            @if (Lang::has('communicate.student.student_registration'))
                                <span>{{ __('communicate.student.student_registration') ?? 'Student Registration' }}</span>
                            @else
                                <span>{{ __('student.student_registration') ?? 'Student Registration' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'staff-reg-custom-field' ? 'active' : '' }}"
                            href="/staff-reg-custom-field">

                            @if (Lang::has('communicate.hr.staff_registration'))
                                <span>{{ __('communicate.hr.staff_registration') ?? 'Staff Registration' }}</span>
                            @else
                                <span>{{ __('hr.staff_registration') ?? 'Staff Registration' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="{{ spn_active_link('student-settings', 'mm-active') }} {{ spn_active_link('two_factor_auth_setting', 'mm-active') }} {{ spn_active_link('lesson/lessonPlan-setting', 'mm-active') }} {{ spn_active_link('staff-settings', 'mm-active') }} {{ spn_active_link('chat/settings', 'mm-active') }} {{ spn_active_link('general-settings', 'mm-active') }} {{ spn_active_link('optional-subject-setup', 'mm-active') }} {{ spn_active_link('academic-year', 'mm-active') }} {{ spn_active_link('holiday', 'mm-active') }} {{ spn_active_link('notification_settings', 'mm-active') }} {{ spn_active_link('plugin/tawk-setting', 'mm-active') }} {{ spn_active_link('plugin/facebook-messenger-setting', 'mm-active') }} {{ spn_active_link('manage-currency', 'mm-active') }} {{ spn_active_link('email-settings', 'mm-active') }} {{ spn_active_link('payment-method-settings', 'mm-active') }} {{ spn_active_link('base-setup', 'mm-active') }} {{ spn_active_link('sms-settings', 'mm-active') }} {{ spn_active_link('weekend', 'mm-active') }} {{ spn_active_link('language-settings', 'mm-active') }} {{ spn_active_link('backup-settings', 'mm-active') }} {{ spn_active_link('button-disable-enable', 'mm-active') }} {{ spn_active_link('update-system', 'mm-active') }} {{ spn_active_link('api/permission', 'mm-active') }} {{ spn_active_link('language-list', 'mm-active') }} {{ spn_active_link('preloader-setting', 'mm-active') }} {{ spn_active_link('utility', 'mm-active') }} {{ spn_active_link('badges', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['student_settings', 'two_factor_auth_setting', 'lesson.lessonPlan-setting', 'staff_settings', 'chat.settings', 'general-settings', 'class_optional', 'academic-year', 'holiday', 'notification_settings', 'tawkSetting', 'messengerSetting', 'manage-currency', 'email-settings', 'payment-method-settings', 'base_setup', 'sms-settings', 'weekend', 'language-settings', 'backup-settings', 'button-disable-enable', 'update-system', 'api/permission', 'language-list', 'setting.preloader', 'utility', 'badges']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-cogs"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.common.general_settings'))
                            <span>{{ __('communicate.common.general_settings') ?? 'General Settings' }}</span>
                        @else
                            <span>{{ __('common.general_settings') ?? 'General Settings' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'student_settings' ? 'active' : '' }}"
                            href="/student-settings">

                            @if (Lang::has('communicate.student.student_settings'))
                                <span>{{ __('communicate.student.student_settings') ?? 'Student Settings' }}</span>
                            @else
                                <span>{{ __('student.student_settings') ?? 'Student Settings' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'two_factor_auth_setting' ? 'active' : '' }}"
                            href="/two_factor_auth_setting">

                            @if (Lang::has('communicate.auth.two_factor_setting'))
                                <span>{{ __('communicate.auth.two_factor_setting') ?? 'Two Factor Setting' }}</span>
                            @else
                                <span>{{ __('auth.two_factor_setting') ?? 'Two Factor Setting' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'lesson.lessonPlan-setting' ? 'active' : '' }}"
                            href="/lesson/lessonPlan-setting">

                            @if (Lang::has('communicate.lesson::lesson.lesson_plan_setting'))
                                <span>{{ __('communicate.lesson::lesson.lesson_plan_setting') ?? 'Lesson Plan Setting' }}</span>
                            @else
                                <span>{{ __('lesson::lesson.lesson_plan_setting') ?? 'Lesson Plan Setting' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'staff_settings' ? 'active' : '' }}"
                            href="/staff-settings">

                            @if (Lang::has('communicate.hr.staff_settings'))
                                <span>{{ __('communicate.hr.staff_settings') ?? 'Staff Settings' }}</span>
                            @else
                                <span>{{ __('hr.staff_settings') ?? 'Staff Settings' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'chat.settings' ? 'active' : '' }}"
                            href="/chat/settings">

                            @if (Lang::has('communicate.chat::chat.chat_settings'))
                                <span>{{ __('communicate.chat::chat.chat_settings') ?? 'Chat Settings' }}</span>
                            @else
                                <span>{{ __('chat::chat.chat_settings') ?? 'Chat Settings' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'general-settings' ? 'active' : '' }}"
                            href="/general-settings">

                            @if (Lang::has('communicate.system_settings.general_settings'))
                                <span>{{ __('communicate.system_settings.general_settings') ?? 'General Settings' }}</span>
                            @else
                                <span>{{ __('system_settings.general_settings') ?? 'General Settings' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'class_optional' ? 'active' : '' }}"
                            href="/optional-subject-setup">

                            @if (Lang::has('communicate.system_settings.optional_subject'))
                                <span>{{ __('communicate.system_settings.optional_subject') ?? 'Optional Subject Setup' }}</span>
                            @else
                                <span>{{ __('system_settings.optional_subject') ?? 'Optional Subject Setup' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'academic-year' ? 'active' : '' }}"
                            href="/academic-year">

                            @if (Lang::has('communicate.common.academic_year'))
                                <span>{{ __('communicate.common.academic_year') ?? 'Academic Year' }}</span>
                            @else
                                <span>{{ __('common.academic_year') ?? 'Academic Year' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'holiday' ? 'active' : '' }}"
                            href="/holiday">

                            @if (Lang::has('communicate.system_settings.holiday'))
                                <span>{{ __('communicate.system_settings.holiday') ?? 'Holiday' }}</span>
                            @else
                                <span>{{ __('system_settings.holiday') ?? 'Holiday' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'notification_settings' ? 'active' : '' }}"
                            href="/notification_settings">

                            @if (Lang::has('communicate.system_settings.notification_setting'))
                                <span>{{ __('communicate.system_settings.notification_setting') ?? 'Notification Setting' }}</span>
                            @else
                                <span>{{ __('system_settings.notification_setting') ?? 'Notification Setting' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'tawkSetting' ? 'active' : '' }}"
                            href="/plugin/tawk-setting">

                            @if (Lang::has('communicate.system_settings.tawk_to_chat'))
                                <span>{{ __('communicate.system_settings.tawk_to_chat') ?? 'Tawk To Chat' }}</span>
                            @else
                                <span>{{ __('system_settings.tawk_to_chat') ?? 'Tawk To Chat' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'messengerSetting' ? 'active' : '' }}"
                            href="/plugin/facebook-messenger-setting">

                            @if (Lang::has('communicate.system_settings.Messenger Chat'))
                                <span>{{ __('communicate.system_settings.Messenger Chat') ?? 'Messenger Chat' }}</span>
                            @else
                                <span>{{ __('system_settings.Messenger Chat') ?? 'Messenger Chat' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'manage-currency' ? 'active' : '' }}"
                            href="/manage-currency">

                            @if (Lang::has('communicate.system_settings.manage_currency'))
                                <span>{{ __('communicate.system_settings.manage_currency') ?? 'Manage Currency' }}</span>
                            @else
                                <span>{{ __('system_settings.manage_currency') ?? 'Manage Currency' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'email-settings' ? 'active' : '' }}"
                            href="/email-settings">

                            @if (Lang::has('communicate.system_settings.email_settings'))
                                <span>{{ __('communicate.system_settings.email_settings') ?? 'Email Setting' }}</span>
                            @else
                                <span>{{ __('system_settings.email_settings') ?? 'Email Setting' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'payment-method-settings' ? 'active' : '' }}"
                            href="/payment-method-settings">

                            @if (Lang::has('communicate.system_settings.payment_settings'))
                                <span>{{ __('communicate.system_settings.payment_settings') ?? 'Payment Method Settings' }}</span>
                            @else
                                <span>{{ __('system_settings.payment_settings') ?? 'Payment Method Settings' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'base_setup' ? 'active' : '' }}"
                            href="/base-setup">

                            @if (Lang::has('communicate.system_settings.base_setup'))
                                <span>{{ __('communicate.system_settings.base_setup') ?? 'Base Setup' }}</span>
                            @else
                                <span>{{ __('system_settings.base_setup') ?? 'Base Setup' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'sms-settings' ? 'active' : '' }}"
                            href="/sms-settings">

                            @if (Lang::has('communicate.system_settings.sms_settings'))
                                <span>{{ __('communicate.system_settings.sms_settings') ?? 'Sms Settings' }}</span>
                            @else
                                <span>{{ __('system_settings.sms_settings') ?? 'Sms Settings' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'weekend' ? 'active' : '' }}"
                            href="/weekend">

                            @if (Lang::has('communicate.system_settings.weekend'))
                                <span>{{ __('communicate.system_settings.weekend') ?? 'Weekend' }}</span>
                            @else
                                <span>{{ __('system_settings.weekend') ?? 'Weekend' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'language-settings' ? 'active' : '' }}"
                            href="/language-settings">

                            @if (Lang::has('communicate.system_settings.language_settings'))
                                <span>{{ __('communicate.system_settings.language_settings') ?? 'Language Settings' }}</span>
                            @else
                                <span>{{ __('system_settings.language_settings') ?? 'Language Settings' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'backup-settings' ? 'active' : '' }}"
                            href="/backup-settings">

                            @if (Lang::has('communicate.system_settings.backup'))
                                <span>{{ __('communicate.system_settings.backup') ?? 'Backup' }}</span>
                            @else
                                <span>{{ __('system_settings.backup') ?? 'Backup' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'button-disable-enable' ? 'active' : '' }}"
                            href="/button-disable-enable">

                            @if (Lang::has('communicate.system_settings.dashboard_setup'))
                                <span>{{ __('communicate.system_settings.dashboard_setup') ?? 'Header Option' }}</span>
                            @else
                                <span>{{ __('system_settings.dashboard_setup') ?? 'Header Option' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'update-system' ? 'active' : '' }}"
                            href="/update-system">

                            @if (Lang::has('communicate.system_settings.about_&_update'))
                                <span>{{ __('communicate.system_settings.about_&_update') ?? 'About & Update' }}</span>
                            @else
                                <span>{{ __('system_settings.about_&_update') ?? 'About & Update' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'api/permission' ? 'active' : '' }}"
                            href="/api/permission">

                            @if (Lang::has('communicate.system_settings.api_permission'))
                                <span>{{ __('communicate.system_settings.api_permission') ?? 'API Permission' }}</span>
                            @else
                                <span>{{ __('system_settings.api_permission') ?? 'API Permission' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'language-list' ? 'active' : '' }}"
                            href="/language-list">

                            @if (Lang::has('communicate.system_settings.language'))
                                <span>{{ __('communicate.system_settings.language') ?? 'Language' }}</span>
                            @else
                                <span>{{ __('system_settings.language') ?? 'Language' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'setting.preloader' ? 'active' : '' }}"
                            href="/preloader-setting">

                            @if (Lang::has('communicate.system_settings.Preloader Settings'))
                                <span>{{ __('communicate.system_settings.Preloader Settings') ?? 'Preloader Setting' }}</span>
                            @else
                                <span>{{ __('system_settings.Preloader Settings') ?? 'Preloader Setting' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'utility' ? 'active' : '' }}"
                            href="/utility">

                            @if (Lang::has('communicate.system_settings.utilities'))
                                <span>{{ __('communicate.system_settings.utilities') ?? 'Utilities' }}</span>
                            @else
                                <span>{{ __('system_settings.utilities') ?? 'Utilities' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'badges' ? 'active' : '' }}"
                            href="/badges">

                            @if (Lang::has('communicate.admin.badges'))
                                <span>{{ __('communicate.admin.badges') ?? 'Badges' }}</span>
                            @else
                                <span>{{ __('admin.badges') ?? 'Badges' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>


            <li
                class="{{ spn_active_link('theme/index', 'mm-active') }} {{ spn_active_link('header/build', 'mm-active') }} {{ spn_active_link('footer/build', 'mm-active') }} {{ spn_active_link('admin-home-page', 'mm-active') }} {{ spn_active_link('news', 'mm-active') }} {{ spn_active_link('news-category', 'mm-active') }} {{ spn_active_link('testimonial', 'mm-active') }} {{ spn_active_link('course-list', 'mm-active') }} {{ spn_active_link('contact-page', 'mm-active') }} {{ spn_active_link('contact-message', 'mm-active') }} {{ spn_active_link('about-page', 'mm-active') }} {{ spn_active_link('news-heading-update', 'mm-active') }} {{ spn_active_link('course-heading-update', 'mm-active') }} {{ spn_active_link('custom-links', 'mm-active') }} {{ spn_active_link('social-media', 'mm-active') }} {{ spn_active_link('header-menu-manager', 'mm-active') }} {{ spn_active_link('page-list', 'mm-active') }} {{ spn_active_link('course-category', 'mm-active') }} {{ spn_active_link('course-details-heading', 'mm-active') }} {{ spn_active_link('class-exam-routine-page', 'mm-active') }} {{ spn_active_link('exam-result-page', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['theme.index', 'pagebuilder.header', 'pagebuilder.footer', 'admin-home-page', 'news_index', 'news-category', 'testimonial_index', 'course-list', 'conpactPage', 'contactMessage', 'about-page', 'news-heading-update', 'course-heading-update', 'custom-links', 'social-media', 'header-menu-manager', 'page-list', 'course-category', 'course-details-heading', 'class-exam-routine-page', 'exam-result-page']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="flaticon-software"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.common.frontend_cms'))
                            <span>{{ __('communicate.common.frontend_cms') ?? 'Frontend CMS' }}</span>
                        @else
                            <span>{{ __('common.frontend_cms') ?? 'Frontend CMS' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'theme.index' ? 'active' : '' }}"
                            href="/theme/index">

                            @if (Lang::has('communicate.front_settings.Manage Theme'))
                                <span>{{ __('communicate.front_settings.Manage Theme') ?? 'Manage Theme' }}</span>
                            @else
                                <span>{{ __('front_settings.Manage Theme') ?? 'Manage Theme' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'pagebuilder.header' ? 'active' : '' }}"
                            href="/header/build">

                            @if (Lang::has('communicate.front_settings.Header Content'))
                                <span>{{ __('communicate.front_settings.Header Content') ?? 'Header Content' }}</span>
                            @else
                                <span>{{ __('front_settings.Header Content') ?? 'Header Content' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'pagebuilder.footer' ? 'active' : '' }}"
                            href="/footer/build">

                            @if (Lang::has('communicate.front_settings.Footer Content'))
                                <span>{{ __('communicate.front_settings.Footer Content') ?? 'Footer Content' }}</span>
                            @else
                                <span>{{ __('front_settings.Footer Content') ?? 'Footer Content' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'admin-home-page' ? 'active' : '' }}"
                            href="/admin-home-page">

                            @if (Lang::has('communicate.front_settings.home_page'))
                                <span>{{ __('communicate.front_settings.home_page') ?? 'Home Page' }}</span>
                            @else
                                <span>{{ __('front_settings.home_page') ?? 'Home Page' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'news_index' ? 'active' : '' }}"
                            href="/news">

                            @if (Lang::has('communicate.front_settings.news_list'))
                                <span>{{ __('communicate.front_settings.news_list') ?? 'News List' }}</span>
                            @else
                                <span>{{ __('front_settings.news_list') ?? 'News List' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'news-category' ? 'active' : '' }}"
                            href="/news-category">

                            @if (Lang::has('communicate.front_settings.news'))
                                <span>{{ __('communicate.front_settings.news') ?? 'News Category' }}</span>
                            @else
                                <span>{{ __('front_settings.news') ?? 'News Category' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'testimonial_index' ? 'active' : '' }}"
                            href="/testimonial">

                            @if (Lang::has('communicate.front_settings.testimonial'))
                                <span>{{ __('communicate.front_settings.testimonial') ?? 'Testimonial' }}</span>
                            @else
                                <span>{{ __('front_settings.testimonial') ?? 'Testimonial' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'course-list' ? 'active' : '' }}"
                            href="/course-list">

                            @if (Lang::has('communicate.front_settings.course_list'))
                                <span>{{ __('communicate.front_settings.course_list') ?? 'Course List' }}</span>
                            @else
                                <span>{{ __('front_settings.course_list') ?? 'Course List' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'conpactPage' ? 'active' : '' }}"
                            href="/contact-page">

                            @if (Lang::has('communicate.front_settings.contact_page'))
                                <span>{{ __('communicate.front_settings.contact_page') ?? 'Contact Page' }}</span>
                            @else
                                <span>{{ __('front_settings.contact_page') ?? 'Contact Page' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'contactMessage' ? 'active' : '' }}"
                            href="/contact-message">

                            @if (Lang::has('communicate.front_settings.contact_message'))
                                <span>{{ __('communicate.front_settings.contact_message') ?? 'Contact Messages' }}</span>
                            @else
                                <span>{{ __('front_settings.contact_message') ?? 'Contact Messages' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'about-page' ? 'active' : '' }}"
                            href="/about-page">

                            @if (Lang::has('communicate.front_settings.about_us'))
                                <span>{{ __('communicate.front_settings.about_us') ?? 'About Us' }}</span>
                            @else
                                <span>{{ __('front_settings.about_us') ?? 'About Us' }}</span>
                            @endif

                        </a>
                    </li>


                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'news-heading-update' ? 'active' : '' }}"
                            href="/news-heading-update">

                            @if (Lang::has('communicate.front_settings.news_heading'))
                                <span>{{ __('communicate.front_settings.news_heading') ?? 'News Heading' }}</span>
                            @else
                                <span>{{ __('front_settings.news_heading') ?? 'News Heading' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'course-heading-update' ? 'active' : '' }}"
                            href="/course-heading-update">

                            @if (Lang::has('communicate.front_settings.course_heading'))
                                <span>{{ __('communicate.front_settings.course_heading') ?? 'Course Details Heading' }}</span>
                            @else
                                <span>{{ __('front_settings.course_heading') ?? 'Course Details Heading' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'custom-links' ? 'active' : '' }}"
                            href="/custom-links">

                            @if (Lang::has('communicate.front_settings.footer_widget'))
                                <span>{{ __('communicate.front_settings.footer_widget') ?? 'Footer Widget' }}</span>
                            @else
                                <span>{{ __('front_settings.footer_widget') ?? 'Footer Widget' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'social-media' ? 'active' : '' }}"
                            href="/social-media">

                            @if (Lang::has('communicate.front_settings.social_media'))
                                <span>{{ __('communicate.front_settings.social_media') ?? 'Social Media' }}</span>
                            @else
                                <span>{{ __('front_settings.social_media') ?? 'Social Media' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'header-menu-manager' ? 'active' : '' }}"
                            href="/header-menu-manager">

                            @if (Lang::has('communicate.front_settings.header_menu_manager'))
                                <span>{{ __('communicate.front_settings.header_menu_manager') ?? 'Menu Manager' }}</span>
                            @else
                                <span>{{ __('front_settings.header_menu_manager') ?? 'Menu Manager' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'page-list' ? 'active' : '' }}"
                            href="/page-list">

                            @if (Lang::has('communicate.front_settings.pages'))
                                <span>{{ __('communicate.front_settings.pages') ?? 'Pages' }}</span>
                            @else
                                <span>{{ __('front_settings.pages') ?? 'Pages' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'course-category' ? 'active' : '' }}"
                            href="/course-category">

                            @if (Lang::has('communicate.front_settings.course_category'))
                                <span>{{ __('communicate.front_settings.course_category') ?? 'Course Category' }}</span>
                            @else
                                <span>{{ __('front_settings.course_category') ?? 'Course Category' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'course-details-heading' ? 'active' : '' }}"
                            href="/course-details-heading">

                            @if (Lang::has('communicate.front_settings.course_details_heading'))
                                <span>{{ __('communicate.front_settings.course_details_heading') ?? 'Course Details Heading' }}</span>
                            @else
                                <span>{{ __('front_settings.course_details_heading') ?? 'Course Details Heading' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'class-exam-routine-page' ? 'active' : '' }}"
                            href="/class-exam-routine-page">

                            @if (Lang::has('communicate.front_settings.class_exam_routine_page'))
                                <span>{{ __('communicate.front_settings.class_exam_routine_page') ?? 'Class/Exam Routine' }}</span>
                            @else
                                <span>{{ __('front_settings.class_exam_routine_page') ?? 'Class/Exam Routine' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'exam-result-page' ? 'active' : '' }}"
                            href="/exam-result-page">

                            @if (Lang::has('communicate.front_settings.exam_result'))
                                <span>{{ __('communicate.front_settings.exam_result') ?? 'Exam Result' }}</span>
                            @else
                                <span>{{ __('front_settings.exam_result') ?? 'Exam Result' }}</span>
                            @endif

                        </a>
                    </li>


                </ul>
            </li>


            <li class="{{ spn_active_link('fees/fees-invoice-settings', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['fees.fees-invoice-settings']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-landmark"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.common.fees_settings'))
                            <span>{{ __('communicate.common.fees_settings') ?? 'Fees Settings' }}</span>
                        @else
                            <span>{{ __('common.fees_settings') ?? 'Fees Settings' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'fees.fees-invoice-settings' ? 'active' : '' }}"
                            href="/fees/fees-invoice-settings">

                            @if (Lang::has('communicate.fees::feesModule.fees_invoice_settings'))
                                <span>{{ __('communicate.fees::feesModule.fees_invoice_settings') ?? 'Fees Invoice Settings' }}</span>
                            @else
                                <span>{{ __('fees::feesModule.fees_invoice_settings') ?? 'Fees Invoice Settings' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>


            <li
                class="{{ spn_active_link('exam-settings', 'mm-active') }} {{ spn_active_link('custom-result-setting', 'mm-active') }} {{ spn_active_link('exam-report-position', 'mm-active') }} {{ spn_active_link('all-exam-report-position', 'mm-active') }} {{ spn_active_link('exam-signature-settings', 'mm-active') }} {{ spn_active_link('examplan/admitcard/setting', 'mm-active') }} {{ spn_active_link('examplan/seatplan/setting', 'mm-active') }}">
                <a href="javascript:void(0)"
                    class="has-arrow text-decoration-none {{ in_array($current_route_details, ['exam-settings', 'custom-result-setting', 'exam-report-position', 'all-exam-report-position', 'exam-signature-settings', 'examplan.admitcard.setting', 'examplan.seatplan.setting']) ? 'active' : '' }}"
                    aria-expanded="false">
                    <div class="nav_icon_small">
                        <span class="fas fa-book"></span>
                    </div>
                    <div class="nav_title">
                        @if (Lang::has('communicate.common.exam_settings'))
                            <span>{{ __('communicate.common.exam_settings') ?? 'Exam Settings' }}</span>
                        @else
                            <span>{{ __('common.exam_settings') ?? 'Exam Settings' }}</span>
                        @endif
                    </div>
                </a>


                <ul class="mm-collapse">
                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'exam-settings' ? 'active' : '' }}"
                            href="/exam-settings">

                            @if (Lang::has('communicate.exam.format_settings'))
                                <span>{{ __('communicate.exam.format_settings') ?? 'Format Settings' }}</span>
                            @else
                                <span>{{ __('exam.format_settings') ?? 'Format Settings' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'custom-result-setting' ? 'active' : '' }}"
                            href="/custom-result-setting">

                            @if (Lang::has('communicate.exam.setup_exam_rule'))
                                <span>{{ __('communicate.exam.setup_exam_rule') ?? 'Setup Exam Rule' }}</span>
                            @else
                                <span>{{ __('exam.setup_exam_rule') ?? 'Setup Exam Rule' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'exam-report-position' ? 'active' : '' }}"
                            href="/exam-report-position">

                            @if (Lang::has('communicate.exam.position'))
                                <span>{{ __('communicate.exam.position') ?? 'Position Setup' }}</span>
                            @else
                                <span>{{ __('exam.position') ?? 'Position Setup' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'all-exam-report-position' ? 'active' : '' }}"
                            href="/all-exam-report-position">

                            @if (Lang::has('communicate.exam.all_exam_position'))
                                <span>{{ __('communicate.exam.all_exam_position') ?? 'All Exam Position' }}</span>
                            @else
                                <span>{{ __('exam.all_exam_position') ?? 'All Exam Position' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'exam-signature-settings' ? 'active' : '' }}"
                            href="/exam-signature-settings">

                            @if (Lang::has('communicate.exam.exam_signature_settings'))
                                <span>{{ __('communicate.exam.exam_signature_settings') ?? 'Exam Signature Settings' }}</span>
                            @else
                                <span>{{ __('exam.exam_signature_settings') ?? 'Exam Signature Settings' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'examplan.admitcard.setting' ? 'active' : '' }}"
                            href="/examplan/admitcard/setting">

                            @if (Lang::has('communicate.examplan::exp.admit_card_setting'))
                                <span>{{ __('communicate.examplan::exp.admit_card_setting') ?? 'Admit Card Setting' }}</span>
                            @else
                                <span>{{ __('examplan::exp.admit_card_setting') ?? 'Admit Card Setting' }}</span>
                            @endif

                        </a>
                    </li>

                    <li>
                        <a class="text-decoration-none {{ $current_route_details == 'examplan.seatplan.setting' ? 'active' : '' }}"
                            href="/examplan/seatplan/setting">

                            @if (Lang::has('communicate.examplan::exp.seat_plan_setting'))
                                <span>{{ __('communicate.examplan::exp.seat_plan_setting') ?? 'Seat Plan Setting' }}</span>
                            @else
                                <span>{{ __('examplan::exp.seat_plan_setting') ?? 'Seat Plan Setting' }}</span>
                            @endif

                        </a>
                    </li>
                </ul>
            </li>





        </ul>

    </nav>

    <!-- sidebar part end -->
    @push('script')
        <script>
            $(document).ready(function() {
                var sections = [];
                $('.menu_seperator').each(function() {
                    sections.push($(this).data('section'));
                });

                jQuery.each(sections, function(index, section) {
                    if ($('.' + section).length == 0) {
                        $('#seperator_' + section).addClass('d-none');
                    } else {
                        $('#seperator_' + section).removeClass('d-none');
                    }
                });
            })
        </script>
    @endpush
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
