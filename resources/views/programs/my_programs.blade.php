@extends('backEnd.master')

@section('title')
    @lang('admin.my_programs')
@endsection

@section('mainContent')
    <style>
        .tab-container {
            display: flex;
            gap: 2em;
            margin: 10px 0;
            overflow-x: auto;
            white-space: nowrap;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .tab-container::-webkit-scrollbar {
            display: none;
        }

        span.tab-sec.active {
            color: #112375;
            font-weight: 500;
            border-bottom: 3px solid #7C32FF;
            padding-bottom: 10px;
        }

        span.tab-sec {
            font-size: 14px;
            cursor: pointer;
            text-transform: uppercase;
        }

        span.tab-sec:hover {
            color: #112375;
            font-weight: 500;
            border-bottom: 3px solid #7C32FF;
            padding-bottom: 10px;
        }

        .collapse-section {
            margin-left: 12%;
            max-height: 450px;
            overflow-y: auto;
            white-space: nowrap;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .collapse-section::-webkit-scrollbar {
            display: none;
        }

        .collase-main {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 0px 8px #ddd;
            margin-bottom: 10px;
        }

        span.lock {
            position: absolute;
            left: 9%;
            top: 40px;
            color: #fff;
            font-size: 26px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 10px;
            height: 8px;
            padding: 12px 25px !important;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 19px;
            width: 19px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        .switch::after {
            display: none;
        }

        input:checked+.slider {
            background-color: #7c32ff;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #7c32ff;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .status-label {
            margin-left: 10px;
        }

        .section-body {
            cursor: pointer;
        }

        .row-inner .row {
            cursor: pointer;
        }

        .collase-main {
            cursor: pointer;
        }

        a.inner-link {
            cursor: pointer;
        }

        img.img-log {
            filter: contrast(0.3);
        }

        .button-with-tooltip {
            position: relative;
            display: inline-block;
        }

        .info-icon {
            font-size: 24px;
            /* margin-left: 8px; */
            cursor: pointer;
        }

        .tooltip {
            position: absolute;
            top: -25px;
            left: 50%;
            transform: translateX(-50%);
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: visible;
            /* Always visible */
            background-color: #000;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 100%;
            left: 50%;
            margin-left: -60px;
            opacity: 1;
            /* Always opaque */
        }

        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #000 transparent transparent transparent;
        }

        span.tooltip-content {
            position: absolute;
            z-index: 999;
            display: none;
            bottom: 32px;
            background: #1B1B1B;
            color: #fff;
            padding: 10px;
            min-width: 150px;
            border-radius: 5px;
            text-align: start;
            text-transform: capitalize;
        }

        .button-with-tooltip:hover {
            span.tooltip-content {
                display: block;
            }
        }

        #class-routines-carousel {
            margin-bottom: 20px;
        }

        #class-routines-carousel .carousel-inner {
            border-radius: 8px;
            overflow: hidden;
        }

        #class-routines-carousel .carousel-item {
            transition: transform 0.6s ease-in-out;
        }

        #class-routines-carousel .card-sec {
            margin-bottom: 0;
        }

        .topics-container {
            display: flex;
            flex-direction: column;
            row-gap: 8px;
        }

        .progress-bar[aria-valuenow="0"] {
            padding-right: 0px;
        }
    </style>


    <section class="sms-breadcrumb mb-20 up_breadcrumb">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('communicate.My Programs')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('communicate.Progress')</a>
                <a href="#">@lang('communicate.My Programs')</a>
                  
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area up_admin_visitor">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="head-programs">
                        <span class="fw-bold d-block" style="color: #112375; font-size: 25px; font-weight: 500;">
                        @php
                        $hour = date('G');
                        if ($hour >= 5 && $hour < 12) {
                            echo __('communicate.morning');
                        } elseif ($hour >= 12 && $hour < 16) {
                            echo __('communicate.afternoon');
                        } elseif ($hour >= 16 && $hour < 19) {
                            echo __('communicate.evening');
                        } else {
                            echo __('communicate.night');
                        }
                        @endphp

                            <span style="text-transform: capitalize;">{{ Auth::user()->full_name }}</span>
                        </span>

                        <div style="margin-top: 10px;">
                            <span class="bottom-head" style="padding-top: 15px; color: gray;">
                            @lang('communicate.Today') {{ \Carbon\Carbon::now()->setTimezone('Asia/Kolkata')->format('M d, Y | h:i A') }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-xs-12">
                    @if (Auth::user()->role_id == 1)
                        <div class="form-group">
                            <form id="teacherForm" action="{{ route('programs.myprograms') }}" method="GET">
                                <select class="primary_select form-control" id="teacher" name="teacher"
                                    onchange="this.form.submit()">
                                    <option value="" {{ request('teacher') == null ? 'selected' : '' }}>Select Teacher
                                    </option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}"
                                            {{ request('teacher') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        @elseif(Auth::user()->role_id == 5)
                        <div class="form-group">
                            <form id="teacherForm" action="{{ route('programs.myprograms') }}" method="GET">
                                <select class="primary_select form-control" id="teacher" name="teacher"
                                    onchange="this.form.submit()">
                                    <option value="" {{ request('teacher') == null ? 'selected' : '' }}>Select Teacher
                                    </option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}"
                                            {{ request('teacher') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div id="class-routines-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    {{-- <div class="card-sec"
                        style="background: #fff;box-shadow:0px 0px 8px #ddd;padding:20px;margin:30px 0px;border-radius:8px;">
                        <div class="row">
                            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <div class="left-card d-flex" style="gap: 2em;align-items:center;">
                                    <div class="card-svg">
                                        <svg width="72" height="59" viewBox="0 0 72 59" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="3.53599" cy="56.1766" r="1.1273" fill="#F9A826" />
                                            <rect x="19.0049" y="54.2799" width="2.96543" height="2.96543" fill="#FF6584" />
                                            <circle cx="19.0223" cy="56.2589" r="1.1273" fill="#F9A826" />
                                            <path d="M19.5011 0L12.8779 10.3386L27.1068 4.87236L19.5011 0Z"
                                                fill="#F1F1F1" />
                                            <path
                                                d="M27.6588 5.59411L12.4906 11.4213L0 30.9188L40.9229 57.1349L60.4738 26.6161L27.6588 5.59411Z"
                                                fill="#F1F1F1" />
                                            <path
                                                d="M52.2199 16.4949L52.2772 16.554L51.4522 14.5663L43.6386 22.2586L41.8569 26.552L52.2199 16.4949Z"
                                                fill="#F9A826" />
                                            <path
                                                d="M51.4182 14.4842L50.4498 12.1506L45.3943 18.0279L43.8008 21.8679L51.3605 14.4255L51.4182 14.4842Z"
                                                fill="#F9A826" />
                                            <path
                                                d="M50.3519 12.0116L50.4143 12.0654L49.1414 8.99801L45.5967 17.5398L50.3519 12.0116Z"
                                                fill="#F9A826" />
                                            <path
                                                d="M59.1571 33.1333L52.3109 16.6359L41.6972 26.9364L39.1256 33.1333L29.1099 57.2686H49.1413H69.1729L59.1571 33.1333Z"
                                                fill="#F9A826" />
                                            <path d="M0.643066 57.2774H71.5275" stroke="#3F3D56" stroke-width="2" />
                                            <path d="M53.337 42.0296L46.3818 51.1248V54.7696L55.4602 42.0296H53.337Z"
                                                fill="#3F3D56" />
                                            <path d="M50.3486 42.0296L46.3818 46.817V50.8536L53.1297 42.0296H50.3486Z"
                                                fill="#3F3D56" />
                                            <path d="M50.1347 42.0296H46.3818V46.5588L50.1347 42.0296Z" fill="#3F3D56" />
                                            <path d="M55.6624 42.0296L46.3818 55.0535V57.2686H69.4463V42.0296H55.6624Z"
                                                fill="#3F3D56" />
                                            <circle cx="65.4923" cy="33.3804" r="6.50746" fill="#2F2E41" />
                                            <rect x="68.458" y="42.0295" width="1.97695" height="3.54204"
                                                transform="rotate(-180 68.458 42.0295)" fill="#2F2E41" />
                                            <rect x="64.5039" y="42.0295" width="1.97695" height="3.54204"
                                                transform="rotate(-180 64.5039 42.0295)" fill="#2F2E41" />
                                            <ellipse cx="66.8105" cy="42.0707" rx="1.64746" ry="0.617797"
                                                fill="#2F2E41" />
                                            <ellipse cx="62.8564" cy="41.9884" rx="1.64746" ry="0.617797"
                                                fill="#2F2E41" />
                                            <circle cx="65.3276" cy="31.7329" r="2.22407" fill="white" />
                                            <circle cx="65.3278" cy="31.7329" r="0.741356" fill="#3F3D56" />
                                            <path
                                                d="M71.8052 27.3286C72.3306 24.9754 70.651 22.5976 68.0536 22.0177C65.4562 21.4377 62.9246 22.8752 62.3992 25.2284C61.8737 27.5816 63.5951 28.4495 66.1925 29.0294C68.7899 29.6094 71.2797 29.6818 71.8052 27.3286Z"
                                                fill="#F9A826" />
                                            <path d="M14.6774 32.4743V57.2685" stroke="#3F3D56" stroke-width="2" />
                                            <rect x="0.25293" y="22.919" width="28.8305" height="19.1105" fill="#F9A826" />
                                            <rect x="3.54785" y="27.6967" width="22.2407" height="0.658984"
                                                fill="#F1F1F1" />
                                            <rect x="3.54785" y="29.9207" width="22.2407" height="0.658984"
                                                fill="#F1F1F1" />
                                            <rect x="3.54785" y="32.1448" width="22.2407" height="0.658984"
                                                fill="#F1F1F1" />
                                            <rect x="20.0225" y="36.5929" width="5.76611" height="0.658984"
                                                fill="#F1F1F1" />
                                            <ellipse cx="14.6685" cy="22.919" rx="2.47119" ry="1.31797"
                                                fill="#3F3D56" />
                                        </svg>
                                    </div>
                                    <div class="card-condent">
                                        <span class="muted-content">Reminder : Today
                                            {{ \Carbon\Carbon::now()->setTimezone('Asia/Kolkata')->format('M d, Y | h:i A') }}</span>
                                        <div class="d-flex" style="gap:1em;margin-top:3px;">
                                            <span class="place-content"
                                                style="color:#112375;font-weight:500;font-size:18px;">KERTAS KERJA (KK):
                                                ANALYSE JOB
                                                ORDER/CHANGE REQUEST</span>
                                            <span class="contact-content"><i class="ti-user"></i> by Rose Poole</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <div class="text-center"
                                    style="display: flex;align-items: center;justify-content: end;height: 100%;">
                                    <button class="primary-btn-small-input primary-btn small fix-gr-bg"
                                        data-toggle="tooltip" data-placement="top" title="Tooltip on top">4
                                        Hours</button>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="section-sec" style="margin: 20px">
                <span class="head-section" style="font-size: 17px;color:#112375;font-weight:500;">@lang('communicate.My Programs')</span>

                <div class="tab-container" data-has-classes="{{ $classes->isNotEmpty() ? 'true' : 'false' }}">
                    @if ($classes->isNotEmpty())
                        @foreach ($classes as $class)
                            @if (isset($classSections[$class->id]))
                                @foreach ($classSections[$class->id] as $section)
                                    <span class="tab-sec @if ($loop->first && $loop->parent->first) active @endif"
                                        data-class-id="{{ $class->id }}" data-section-id="{{ $section->id }}">
                                        {{ $class->class_name }} ({{ $section->section_name }})
                                        @if (Auth::user()->role_id == 1  &&
                                                isset($subjectCounts[$class->id . '-' . $section->id]) &&
                                                $subjectCounts[$class->id . '-' . $section->id] > 0)
                                            <span
                                                class="badge badge-primary">{{ $subjectCounts[$class->id . '-' . $section->id] }}</span>
                                        @elseif( Auth::user()->role_id == 5 &&
                                                isset($subjectCounts[$class->id . '-' . $section->id]) &&
                                                $subjectCounts[$class->id . '-' . $section->id] > 0)
                                                <span
                                                class="badge badge-primary">{{ $subjectCounts[$class->id . '-' . $section->id] }}</span>
                                        @endif
                                    </span>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                </div>

                @if ($classes->isNotEmpty())
                    <div class="subject-container" id="subject-container">

                    </div>
                @else
                    <div class="empty-message"
                        style="text-align: center; padding: 50px; background: #fff; margin: 30px 0; border-radius: 8px; box-shadow: 0px 0px 8px #ddd;">
                        <h3 style="color: #47464A;">No subjects available</h3>
                        <p style="color: #77838F;">Please select a class to view subjects.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- Modal Structure -->
    <div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestModalLabel">Subject-Request Lock/Unlock Note</h5>
                    <button type="button" class="close" onclick="closeModal('requestModal')" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span>
                        Please provide the unlock request note below, clearly specifying the purpose for unlocking the
                        marks/subject.
                    </span>
                    <br />
                    <br />
                    <form id="requestForm">
                        <input type="hidden" id="subjectId" name="subject_id">
                        <input type="hidden" id="classId" name="class_id">
                        <input type="hidden" id="sectionId" name="section_id">
                        <input type="hidden" id="requestStatus" name="status">
                        <div class="form-group">
                            <label for="notes">Notes:</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Add your notes here..."
                                required></textarea>
                        </div>
                        <div style="text-align:center;">
                            <button type="button" class="primary-btn-small-input primary-btn small fix-gr-bg"
                                onclick="submitRequest()">Send
                                Request</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestModalLabel">Media Preview</h5>
                    <button type="button" class="close" onclick="closeModal('mediaModal')" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Media content will be injected here -->
                    <div id="mediaPreviewContent" style="text-align:center;">
                        <!-- Media (Image, Video, or PDF) will be displayed here -->
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
        const skeletonCSS = `
.skeleton {
    background: #f0f0f0;
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}
@keyframes loading {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}
`;

        // Add this style tag to your HTML
        const styleTag = document.createElement('style');
        styleTag.textContent = skeletonCSS;
        document.head.appendChild(styleTag);

        function toggleCollapse(id, isActive, authUserId) {

            if (isActive != 1 && authUserId != 1) {
                return;
            }
            var collapse = document.getElementById(id);
            var icon = document.getElementById('icon-' + id.replace('collapse-', ''));

            var allCollapses = document.querySelectorAll('[id^="collapse-"]');
            allCollapses.forEach(function(el) {
                if (el !== collapse && el.style.display === 'block') {
                    el.style.display = 'none';
                    var previousIcon = document.getElementById('icon-' + el.id.replace('collapse-', ''));
                    previousIcon.classList.remove('ti-minus');
                    previousIcon.classList.add('ti-plus');
                }
            });

            if (collapse.style.display === 'none') {
                collapse.style.display = 'block';
                icon.classList.remove('ti-plus');
                icon.classList.add('ti-minus');
            } else {
                collapse.style.display = 'none';
                icon.classList.remove('ti-minus');
                icon.classList.add('ti-plus');
            }
        }

        function toggleLesson(lessonId) {
            var lessonCollapse = document.getElementById(lessonId);
            var lessonIcon = document.getElementById('icon-' + lessonId.replace('collapse-', ''));

            var allLessons = document.querySelectorAll('[id^="collapse-lesson-"]');
            allLessons.forEach(function(el) {
                if (el !== lessonCollapse && el.style.display === 'block') {
                    el.style.display = 'none';
                    var previousLessonIcon = document.getElementById('icon-' + el.id.replace('collapse-', ''));
                    previousLessonIcon.classList.remove('ti-minus');
                    previousLessonIcon.classList.add('ti-plus');
                }
            });

            if (lessonCollapse.style.display === 'none') {
                lessonCollapse.style.display = 'block';
                lessonIcon.classList.remove('ti-plus');
                lessonIcon.classList.add('ti-minus');
            } else {
                lessonCollapse.style.display = 'none';
                lessonIcon.classList.remove('ti-minus');
                lessonIcon.classList.add('ti-plus');
            }
        }

        // $('#teacher').on('change', function() {
        //     var teacherId = $(this).val();
        //     $.ajax({
        //         type: 'GET',
        //         url: '{{ route('programs.myprograms') }}',
        //         data: {
        //             teacher: teacherId
        //         },
        //         success: function(response) {
        //             // Update the classes dropdown with the response data
        //         },
        //         error: function(xhr, status, error) {
        //             console.log(xhr.responseText);
        //         }
        //     });
        // });

        const user = @json($user);
        let teacherId = '';

        let subjectsData = [];

        if (user.role_id == 1 || user.role_id == 5) {
            document.getElementById('teacher').addEventListener('change', function() {
                this.form.submit();
                teacherId = document.getElementById('teacher').value;
            });
        }

        let activeTab = null;

        function activateTab(element, classId, sectionId) {
            document.querySelectorAll('.tab-sec').forEach(tab => {
                tab.classList.remove('active');
            });

            element.classList.add('active');
            activeTab = element;

            showSkeletonLoader();
            fetchSubjects(classId, sectionId);
        }

        function showSkeletonLoader() {
            const subjectContainer = document.getElementById('subject-container');
            subjectContainer.innerHTML = `
        <div class="section-body skeleton" style="height: 200px; margin: 30px 0px 5px;"></div>
        <div class="section-body skeleton" style="height: 200px; margin: 30px 0px 5px;"></div>
        <div class="section-body skeleton" style="height: 200px; margin: 30px 0px 5px;"></div>
    `;
        }

        function showEmptyMessage() {
            const subjectContainer = document.getElementById('subject-container');
            subjectContainer.innerHTML = `
        <div class="empty-message" style="text-align: center; padding: 50px; background: #fff; margin: 30px 0; border-radius: 8px; box-shadow: 0px 0px 8px #ddd;">
            <h3 style="color: #47464A;">No subjects available</h3>
            <p style="color: #77838F;">Please select a class to view subjects.</p>
        </div>
    `;
        }

        function initializeSubjects() {
            const tabContainer = document.querySelector('.tab-container');
            if (!tabContainer || tabContainer.getAttribute('data-has-classes') !== 'true') {
                showEmptyMessage();
                return;
            }

            const firstTab = document.querySelector('.tab-sec');
            if (firstTab) {
                const classId = firstTab.getAttribute('data-class-id');
                const sectionId = firstTab.getAttribute('data-section-id');
                activateTab(firstTab, classId, sectionId);
            } else {
                showEmptyMessage();
            }

            document.querySelectorAll('.tab-sec').forEach(tab => {
                tab.addEventListener('click', function() {
                    const classId = this.getAttribute('data-class-id');
                    const sectionId = this.getAttribute('data-section-id');
                    activateTab(this, classId, sectionId);
                });
            });
        }

        document.addEventListener('DOMContentLoaded', initializeSubjects);

        let dropdownCounter = 0;

        function fetchSubjects(classId, sectionId) {
            const urlParams = new URLSearchParams(window.location.search);
            const teacherId = urlParams.get('teacher') ?? '';

            const url = `class-subjects/${classId}/${sectionId}?teacher=${teacherId}`;
            fetch(url, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log("d", data);
                    if (data.subjects && data.subjects.length > 0) {
                        data.subjects.forEach(subject => {
                            const progress = calculateSubjectProgress(subject);
                        });
                    }
                    subjectsData = data.subjects;
                    console.log(subjectsData);
                    const subjectContainer = document.getElementById('subject-container');
                    const classRoutinesCarousel = document.getElementById('class-routines-carousel');
                    const carouselInner = classRoutinesCarousel.querySelector('.carousel-inner');

                    subjectContainer.innerHTML = '';
                    carouselInner.innerHTML = '';

                    // Render class routines in carousel
                    if (data.class_routines && data.class_routines.length > 0) {
                        data.class_routines.forEach((routine, index) => {
                            const parseTimeString = (timeString) => {
                                if (!timeString) {
                                    console.error('Time string is undefined or null');
                                    return null;
                                }

                                console.log('Parsing time string:', timeString);

                                try {
                                    const [hours, minutes, seconds] = timeString.split(':').map(Number);
                                    return {
                                        hours,
                                        minutes,
                                        seconds
                                    };
                                } catch (error) {
                                    console.error('Error parsing time:', error);
                                    return null;
                                }
                            };

                            const startTime = parseTimeString(routine.start_time);
                            const endTime = parseTimeString(routine.end_time);

                            // Calculate duration
                            let durationText = 'Duration unknown';
                            if (startTime && endTime) {
                                const startMinutes = startTime.hours * 60 + startTime.minutes;
                                const endMinutes = endTime.hours * 60 + endTime.minutes;
                                let durationMinutes = endMinutes - startMinutes;
                                if (durationMinutes < 0) durationMinutes += 24 *
                                    60; // Adjust for crossing midnight

                                if (durationMinutes < 60) {
                                    durationText = `${durationMinutes} mins`;
                                } else {
                                    const hours = Math.floor(durationMinutes / 60);
                                    const minutes = durationMinutes % 60;
                                    durationText =
                                        `${hours} hour${hours > 1 ? 's' : ''}${minutes > 0 ? ` ${minutes} min${minutes > 1 ? 's' : ''}` : ''}`;
                                }
                            }

                            const formatTime = (time) => {
                                if (!time) return 'Time unknown';
                                const {
                                    hours,
                                    minutes
                                } = time;
                                const ampm = hours >= 12 ? 'PM' : 'AM';
                                const formattedHours = hours % 12 || 12;
                                return `${formattedHours}:${minutes.toString().padStart(2, '0')} ${ampm}`;
                            };

                            const routineHtml = `
                        <div class="carousel-item ${index === 0 ? 'active' : ''}">
                            <div class="card-sec"
                        style="background: #fff;box-shadow:0px 0px 8px #ddd;padding:20px;margin:30px 0px;border-radius:8px;">
                        <div class="row">
                            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <div class="left-card d-flex" style="gap: 2em;align-items:center;">
                                    <div class="card-svg">
                                        <svg width="72" height="59" viewBox="0 0 72 59" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="3.53599" cy="56.1766" r="1.1273" fill="#F9A826" />
                                            <rect x="19.0049" y="54.2799" width="2.96543" height="2.96543" fill="#FF6584" />
                                            <circle cx="19.0223" cy="56.2589" r="1.1273" fill="#F9A826" />
                                            <path d="M19.5011 0L12.8779 10.3386L27.1068 4.87236L19.5011 0Z"
                                                fill="#F1F1F1" />
                                            <path
                                                d="M27.6588 5.59411L12.4906 11.4213L0 30.9188L40.9229 57.1349L60.4738 26.6161L27.6588 5.59411Z"
                                                fill="#F1F1F1" />
                                            <path
                                                d="M52.2199 16.4949L52.2772 16.554L51.4522 14.5663L43.6386 22.2586L41.8569 26.552L52.2199 16.4949Z"
                                                fill="#F9A826" />
                                            <path
                                                d="M51.4182 14.4842L50.4498 12.1506L45.3943 18.0279L43.8008 21.8679L51.3605 14.4255L51.4182 14.4842Z"
                                                fill="#F9A826" />
                                            <path
                                                d="M50.3519 12.0116L50.4143 12.0654L49.1414 8.99801L45.5967 17.5398L50.3519 12.0116Z"
                                                fill="#F9A826" />
                                            <path
                                                d="M59.1571 33.1333L52.3109 16.6359L41.6972 26.9364L39.1256 33.1333L29.1099 57.2686H49.1413H69.1729L59.1571 33.1333Z"
                                                fill="#F9A826" />
                                            <path d="M0.643066 57.2774H71.5275" stroke="#3F3D56" stroke-width="2" />
                                            <path d="M53.337 42.0296L46.3818 51.1248V54.7696L55.4602 42.0296H53.337Z"
                                                fill="#3F3D56" />
                                            <path d="M50.3486 42.0296L46.3818 46.817V50.8536L53.1297 42.0296H50.3486Z"
                                                fill="#3F3D56" />
                                            <path d="M50.1347 42.0296H46.3818V46.5588L50.1347 42.0296Z" fill="#3F3D56" />
                                            <path d="M55.6624 42.0296L46.3818 55.0535V57.2686H69.4463V42.0296H55.6624Z"
                                                fill="#3F3D56" />
                                            <circle cx="65.4923" cy="33.3804" r="6.50746" fill="#2F2E41" />
                                            <rect x="68.458" y="42.0295" width="1.97695" height="3.54204"
                                                transform="rotate(-180 68.458 42.0295)" fill="#2F2E41" />
                                            <rect x="64.5039" y="42.0295" width="1.97695" height="3.54204"
                                                transform="rotate(-180 64.5039 42.0295)" fill="#2F2E41" />
                                            <ellipse cx="66.8105" cy="42.0707" rx="1.64746" ry="0.617797"
                                                fill="#2F2E41" />
                                            <ellipse cx="62.8564" cy="41.9884" rx="1.64746" ry="0.617797"
                                                fill="#2F2E41" />
                                            <circle cx="65.3276" cy="31.7329" r="2.22407" fill="white" />
                                            <circle cx="65.3278" cy="31.7329" r="0.741356" fill="#3F3D56" />
                                            <path
                                                d="M71.8052 27.3286C72.3306 24.9754 70.651 22.5976 68.0536 22.0177C65.4562 21.4377 62.9246 22.8752 62.3992 25.2284C61.8737 27.5816 63.5951 28.4495 66.1925 29.0294C68.7899 29.6094 71.2797 29.6818 71.8052 27.3286Z"
                                                fill="#F9A826" />
                                            <path d="M14.6774 32.4743V57.2685" stroke="#3F3D56" stroke-width="2" />
                                            <rect x="0.25293" y="22.919" width="28.8305" height="19.1105" fill="#F9A826" />
                                            <rect x="3.54785" y="27.6967" width="22.2407" height="0.658984"
                                                fill="#F1F1F1" />
                                            <rect x="3.54785" y="29.9207" width="22.2407" height="0.658984"
                                                fill="#F1F1F1" />
                                            <rect x="3.54785" y="32.1448" width="22.2407" height="0.658984"
                                                fill="#F1F1F1" />
                                            <rect x="20.0225" y="36.5929" width="5.76611" height="0.658984"
                                                fill="#F1F1F1" />
                                            <ellipse cx="14.6685" cy="22.919" rx="2.47119" ry="1.31797"
                                                fill="#3F3D56" />
                                        </svg>
                                    </div>
                                    <div class="card-condent">
                                        <span class="muted-content">Reminder : Today
                                            {{ \Carbon\Carbon::now()->setTimezone('Asia/Kolkata')->format('M d, Y') }} |
                                            ${formatTime(startTime)}</span>
                                        <div class="d-flex" style="gap:1em;margin-top:3px;align-items:baseline;justify-content:space-between;">
                                            <span class="place-content"
                                                style="color:#112375;font-weight:500;font-size:18px;text-transform:uppercase;">${routine.class.class_name}(${routine.section.section_name}):
                                        ${routine.subject.subject_name}</span>
                                            <span class="contact-content"><i class="ti-user"></i> by ${routine.teacher_detail ? routine.teacher_detail.full_name : 'Staff'}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                                <div class="text-center"
                                    style="display: flex;align-items: center;justify-content: end;height: 100%;">
                                    <button class="primary-btn-small-input primary-btn small fix-gr-bg"
                                        >
                                        ${durationText}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                        </div>
                    `;
                            carouselInner.innerHTML += routineHtml;
                        });

                        // Initialize the carousel
                        $('#class-routines-carousel').carousel({
                            interval: 2000 // Change slide every 2 seconds
                        });

                        // Show the carousel if there are routines
                        classRoutinesCarousel.style.display = 'block';
                    } else {
                        // Hide the carousel if there are no routines
                        classRoutinesCarousel.style.display = 'none';
                    }

                    if (data.subjects && data.subjects.length > 0) {
                        data.subjects.forEach(subject => {
                            const imageUrl = subject.image ?
                                `{{ asset('public/') }}/${subject.image}` :
                                `{{ asset('public/backEnd/img/default.png') }}`;

                            const progress = calculateSubjectProgress(subject);

                            dropdownCounter++;
                            const dropdownId = `dropdown-${dropdownCounter}`;

                            let lessonsHtml = '';
                            if (subject.lessons && subject.lessons.length > 0) {
                                lessonsHtml = subject.lessons.map(lesson => `
                            <div class="collase-main" onclick="toggleLesson('collapse-lesson-${lesson.id}')">
                                <span class="head-accordian">
                                    <i class="ti-plus" id="icon-lesson-${lesson.id}" style="color: red;font-weight:600;"></i>
                                    <span style="margin-left: 5px;font-weight:500;text-transform:uppercase;font-size:15px;color:#272727">
                                        ${lesson.lesson_title}
                                    </span>
                                </span>
                            </div>
                            <div id="collapse-lesson-${lesson.id}" class="collapse-body" style="display: none;margin-bottom:5px;margin-left: 3em;">
                                    <div class="topics-container" id="topics-${lesson.id}">
                                        ${renderTopics(lesson.topics)}
                                    </div>
                                </div>
                        `).join('');
                            }

                            const subjectHtml = `
                    <div class="section-body" style="background: #fff;box-shadow:0px 0px 8px #ddd;padding:20px;margin:30px 0px 5px;border-radius:8px;">
                        <div class="row" style="display: flex;align-items: center;" onclick="toggleCollapse('collapse-${subject.id}',${subject.is_active}, ${user.role_id})">
                            <div class="col-xl-9 col-lg-9 col-md-8 col-sm-12 col-xs-12">
                                <div class="left-body d-flex" style="gap:2em;align-items:center;">
                                    <div class="imager" style="height: 100px;overflow:hidden;max-width: 20%;min-width: 19.98%;">
                                        <img src="${imageUrl}" style="border-radius: 5px;height:100%;width:100%;" class="${subject.is_active == 2 || subject.is_active == 5 ? 'img-log' : ''}"/>
                                            ${subject.is_active == 2 || subject.is_active == 5 ? '<span class="lock"><i class="ti-lock"></i></span>' : ''}
                                    </div>

                                    <div class="body-content">
                                        <div class="top-body-head d-flex" style="gap:1em;">
                                            <span style="color: #7C32FF;font-weight:600;text-transform:capitalize;font-size:14px;" class="sp-bodyHead">${subject.subject_code}</span>
                                            <span class="head-link" style="font-weight: 500;color:#112375;text-transform:uppercase;">${subject.subject_name}</span>
                                            ${subject.is_active == 2 || subject.is_active == 5 ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <div class="svg-inner" style="position: relative;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <svg width="27" height="27" viewBox="0 0 27 27" fill="none"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <rect width="27" height="27" rx="5" fill="#7C32FF" />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </svg>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <svg style="position: absolute;left:9px;top:7px;" width="10"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            height="14" viewBox="0 0 10 14" fill="none"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                d="M8.11133 5.53705H7.72753V3.20561C7.72753 1.51192 6.34994 0.134155 4.65661 0.134155C2.96292 0.134155 1.58516 1.51192 1.58516 3.20561V5.53705H1.20136C0.540861 5.53705 0.00537109 6.07236 0.00537109 6.73304V12.281C0.00537109 12.9415 0.540861 13.477 1.20136 13.477H8.11133C8.77182 13.477 9.30749 12.9415 9.30749 12.281V6.73304C9.30749 6.07236 8.77182 5.53705 8.11133 5.53705ZM2.65972 3.20561C2.65972 2.10454 3.55554 1.20872 4.65661 1.20872C5.75732 1.20872 6.65297 2.10454 6.65297 3.20561V5.53705H2.65972V3.20561ZM5.26839 10.9398V9.44648C5.55476 9.25056 5.74281 8.92174 5.74281 8.54887C5.74281 7.94872 5.25639 7.46213 4.65643 7.46213C4.05647 7.46213 3.57005 7.94854 3.57005 8.54887C3.57005 8.92174 3.7581 9.25091 4.04465 9.44648V10.9398C4.04465 11.2777 4.31848 11.5515 4.65643 11.5515C4.99456 11.5515 5.26839 11.2777 5.26839 10.9398Z"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                fill="white" />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </svg>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        `
                                        : `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="svg-inner" style="position: relative;">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <svg width="27" height="27" viewBox="0 0 27 27"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <rect width="27" height="27" rx="5"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            fill="#009580" />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </svg>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <svg style="position: absolute;left:10px;top:7.5px;"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        width="9" height="12" viewBox="0 0 9 12"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <path
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            d="M8.11439 4.7418L1.64516 0.312997C1.3464 0.108323 1.04538 0 0.79517 0C0.311439 0 0.012207 0.388229 0.012207 1.03807V10.61C0.012207 11.2591 0.311062 11.6466 0.793662 11.6466C1.04425 11.6466 1.34046 11.5382 1.63988 11.3329L8.11213 6.90422C8.52836 6.61894 8.75886 6.23504 8.75886 5.82277C8.75896 5.41079 8.53109 5.02699 8.11439 4.7418Z"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            fill="white" />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </svg>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                `
                                     }
                                        </div>
                                        <div class="ic-sec d-flex" style="gap: 2em;margin-top:5px;">
                                            <div class="sec-ic">
                                                <span class="ic"><i class="ti-alarm-clock"></i></span>
                                                <span class="ic-link" style="padding-left: 3px;"> ${subject.duration ? subject.duration : 'null'} ${subject.duration && subject.duration_type ? subject.duration_type : ''}</span>
                                            </div>
                                            <div class="sec-ic">
                                                <span class="ic"><i class="ti-star"></i></span>
                                                <span class="ic-link" style="padding-left: 3px;">${subject.lesson_count} @lang('communicate.lessons') </span>
                                            </div>
                                            <div class="sec-ic">
                                                <span class="ic"><i class="ti-harddrives"></i></span>
                                                <span class="ic-link" style="padding-left: 3px;">${subject.topic_count} @lang('communicate.topics') </span>
                                            </div>
                                            <div class="sec-ic">
                                                <span class="ic"><i class="ti-harddrives"></i></span>
                                                <span class="ic-link" style="padding-left: 3px;">${subject.sub_topic_count} @lang('communicate.subtopics') </span>
                                            </div>
                                        </div>
                                       
                                    
                                        <div id="subject-${subject.id }" class="d-flex" style="gap: 0.6em;margin-top:5px;align-items:baseline;">
                                          <div class="progress" style="margin-top: 8px;height:8px;width:100%;">
                                              <div class="progress-bar" role="progressbar" style="width: 0%;height:15px;background: #FFAB2A;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                          </div>
                                          <span class="progress-value">0%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 col-xs-12">    
                                <div class="d-flex" style="gap:3em;justify-content:end;">
                                    <div>
                                     ${getButtonContent(subject,user)}
                                     </div>     
                                </div>
                            </div>
                    </div>
                    </div>
                     <div id="collapse-${subject.id}" class="collapse-section" style="display: none; margin-top: 20px;">
                            ${lessonsHtml}
                        </div>
                    `;
                            subjectContainer.innerHTML += subjectHtml;
                        });
                    } else {
                        setTimeout(() => {
                            showEmptyMessage();
                        }, 1500);

                    }
                })
                .catch(error => {
                    console.error('Error fetching subjects:', error);
                    // setTimeout(() => {
                    //     showEmptyMessage();
                    // }, 2500);
                });
        }

        function toggleDropdown(event, dropdownId) {
            event.stopPropagation();
            const dropdownMenu = document.getElementById(`${dropdownId}-menu`);
            dropdownMenu.style.display = dropdownMenu.style.display === 'none' ? 'block' : 'none';
        }

        // document.addEventListener('click', function(event) {
        //     if (!event.target.matches('.ic-dropdown')) {
        //         const dropdowns = document.getElementsByClassName('dropdown-menu');
        //         for (let i = 0; i < dropdowns.length; i++) {
        //             dropdowns[i].style.display = 'none';
        //         }
        //     }
        // });


        function openRequestModal(event, statusLabel, statusValue, subjectId, classId, sectionId) {
            event.stopPropagation();

            document.getElementById('subjectId').value = subjectId;
            document.getElementById('classId').value = classId;
            document.getElementById('sectionId').value = sectionId;
            document.getElementById('requestStatus').value = statusValue;
            document.getElementById('requestModalLabel').innerText = statusLabel;

            $('#requestModal').modal('show');
        }

        function closeModal(modalId) {
            $('#' + modalId).modal('hide');
        }

        function submitRequest() {
            const status = document.getElementById('requestStatus').value;
            const notes = document.getElementById('notes').value;
            const subjectId = document.getElementById('subjectId').value;
            const classId = document.getElementById('classId').value;
            const sectionId = document.getElementById('sectionId').value;

            if (!notes) {
                toastr.error('Please enter valid request notes.');
                return;
            }

            if (status === '' || status === null) {
                alert('Status is not set. Please try again.');
                return;
            }

            updateSubjectStatus(subjectId, classId, sectionId, status, notes);
            closeModal('requestModal');
        }

        function updateSubjectStatus(subjectId, classId, sectionId, status, notes) {
            fetch(`/update-subject-lock`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        subject_id: subjectId,
                        class_id: classId,
                        section_id: sectionId,
                        status: status,
                        notes: notes
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success('Subject status updated successfully');
                        $('#requestModal').modal('hide');
                        // Optionally, update the UI here
                    } else {
                        console.log("Error updating subject.");
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                });
        }

        function getButtonContent(subject, user) {
            let htmlContent = '';

            const tooltipContent = subject.notes ? `
    <span class="contact-content"><i class="ti-user"></i> by ${subject.teacher ? subject.teacher.full_name : 'Staff'}</span><br/>
    <span style="font-size:13px;color:#cbc8c8;padding-top:2px;">${subject.notes}</span>` : '';

            if (user.role_id == 1 || user.role_id == 5) {
                let statusLabel;
                if (subject.is_active == 1) {
                     statusLabel = '@lang("communicate.Un-locked")';
                    //statusLabel = '@lang("communicate.lock")';
                } else if (subject.is_active == 3) {
                    statusLabel = '@lang("communicate.Un-locked")';
                } else if (subject.is_active == 4) {
                    statusLabel = '@lang("communicate.Unlock Request")';
                } else if (subject.is_active == 5) {
                    statusLabel = '@lang("communicate.lock")';
                } else if (subject.is_active == 6) {
                    statusLabel = '@lang("communicate.Un-locked")';
                } else {
                    statusLabel = '@lang("communicate.lock")';
                }
                const buttonColor = subject.is_active == 1 || subject.is_active == 3 || subject.is_active == 6 ? '#009580' :
                    '#e74c3c';

                htmlContent = `
<div class="progress-sec" style="text-align:right;">
    <div class="button-with-tooltip">
        ${(subject.is_active == 4) && subject.notes != null ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <span class="tooltip-content">${tooltipContent}</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ` : ``}
    <li class="nav-item submenu dropdown">  
        <button id="status-label-${subject.id}"
            class="primary-btn-small-input primary-btn small fix-gr-bg dropdown-toggle"
            data-toggle="dropdown" role="button" aria-haspopup="true"
            style="background-color: ${buttonColor} !important" aria-expanded="false"
           data-toggle="tooltip" data-placement="top" title="${subject.notes ? subject.notes :'' }">
            ${statusLabel}${(subject.is_active == 4) ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="info-icon" fill="none" viewBox="0 0 24 24" stroke="#333" width="22" height=22">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m0-4h.01M12 18a6 6 0 110-12 6 6 0 010 12z" />
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </svg>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ` : ``}
        </button>
        
        <ul class="dropdown-menu">
            ${subject.is_active != 4 ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <li class="nav-item">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <a class="nav-link" style="color: #47464A" data-subject-id="${subject.id}" data-class-id="${subject.class_id}" data-section-id="${subject.section_id}" onclick="updateSubjectStatus(${subject.id}, ${subject.class_id}, ${subject.section_id},2,'')">@lang("communicate.lock")</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <li class="nav-item">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <a class="nav-link" style="color: #47464A" data-subject-id="${subject.id}" data-class-id="${subject.class_id}" data-section-id="${subject.section_id}" onclick="updateSubjectStatus(${subject.id}, ${subject.class_id}, ${subject.section_id},1,'')">@lang("communicate.Un-locked")</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ` : `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <li class="nav-item">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ${subject.is_active == 4 ? `
                        <a class="nav-link" style="color: #47464A" data-subject-id="${subject.id}" data-class-id="${subject.class_id}" data-section-id="${subject.section_id}" onclick="updateSubjectStatus(${subject.id}, ${subject.class_id}, ${subject.section_id},1,'')">Un-Lock</a>
                    ` : `
                        <a class="nav-link" style="color: #47464A" data-subject-id="${subject.id}" data-class-id="${subject.class_id}" data-section-id="${subject.section_id}" onclick="updateSubjectStatus(${subject.id}, ${subject.class_id}, ${subject.section_id},2,'')">@lang("communicate.lock")</a>
                    `}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <li class="nav-item">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ${subject.is_active == 4 ? `
                                                    <a class="nav-link" style="color: #47464A" data-subject-id="${subject.id}" data-class-id="${subject.class_id}" data-section-id="${subject.section_id}" onclick="updateSubjectStatus(${subject.id}, ${subject.class_id}, ${subject.section_id},5,'')">@lang("communicate.Reject")</a>
                                                    `:`
                                                    <a class="nav-link" style="color: #47464A" data-subject-id="${subject.id}" data-class-id="${subject.class_id}" data-section-id="${subject.section_id}" onclick="updateSubjectStatus(${subject.id}, ${subject.class_id}, ${subject.section_id},6,'')">@lang("communicate.Reject")</a>
                                                    `}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </li>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    `}
        </ul>
    </li>
     ${tooltipContent ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <span class="tooltip">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <i class="info-icon">i</i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <span class="tooltiptext">${tooltipContent}</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ` : ''}
    </div>
</div>
`;
            } else if (user.role_id == 4 && subject.is_active != 1) {
                let statusLabel;
                let isDisabled = false;

                if (subject.is_active == 1) {
                    statusLabel = '';
                    isDisabled = true;
                } else if (subject.is_active == 2) {
                    statusLabel = 'Request Unlock';
                } else if (subject.is_active == 4) {
                    statusLabel = 'Unlock Request Sent';
                    isDisabled = true;
                } else if (subject.is_active == 5) {
                    statusLabel = 'Resend UnLock Request';
                } else {
                    statusLabel = '';
                    isDisabled = true;
                }

                const buttonColor = '#7c32ff';
                const statusValue = subject.is_active == 1 ? 3 : 4;

                htmlContent = `
<div class="progress-sec" style="text-align:right;display: ${subject.is_active == 3 || subject.is_active == 6 ? 'none' : '' } !important">
    <button id="status-label-${subject.id}"
        class="btn small"
        role="button" aria-haspopup="true"
        style="background-color: ${subject.is_active == 5 || subject.is_active == 6 ? '#f0eeee' : buttonColor} !important;
       color: ${subject.is_active == 5 || subject.is_active == 6 ? '#7c32ff' : '#fff'} !important;
      border-color: ${subject.is_active == 5 || subject.is_active == 6 ? buttonColor : ''} !important;
      border-radius: ${subject.is_active == 5 || subject.is_active == 6 ? '15px' : '6px'} !important;
      font-weight: 500;" aria-expanded="false"
        data-subject-id="${subject.id}" data-class-id="${subject.class_id}" data-section-id="${subject.section_id}"
       ${(subject.is_active == 1 || subject.is_active == 2 || subject.is_active == 5 || subject.is_active == 6 ) ? `onclick="openRequestModal(event, '${statusLabel}', ${statusValue}, ${subject.id}, ${subject.class_id}, ${subject.section_id})"` : ''}
        ${isDisabled ? 'disabled' : ''}>
        ${statusLabel}
    </button>
</div>
`;
            }

            return htmlContent;
        }


        document.querySelector('.your-container-class').innerHTML = getButtonContent(subject, user);

        function renderTopics(topics) {
            if (!Array.isArray(topics)) {
                console.error('Topics is not an array:', topics);
                return '';
            }

            return topics.map(topic => `
        <div class="topic">
            <div class="inner-child-body" style="border: 1px solid #ddd;border-radius:5px;">
                <div class="topic-header">
                    <div class="row" style="align-items: center;background: #F3F3F3;padding: 10px 20px;margin: 0;">
                        <div class="col-8">
                            <div class="d-flex" style="align-items: center;gap: 1.5em;background: #F3F3F3;">
                                <div class="left-topicHeader">
                                    <i class="ti-plus" id="icon-${topic.id}" style="color: red;font-weight:600;cursor:pointer;" onclick="toggleSubtopics(${topic.id})"></i>
                                </div>
                                <div class="right-topicHeader">
                                    <span class="inner-content-head d-block" style="color: #112375;font-size:14px;font-weight:500;text-transform:uppercase;">${topic.topic_title}</span>
                                    ${renderToggleOrMark(topic)}
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="inner-right_sec d-flex" style="gap: 3em;justify-content:end;">
                            ${topic.completed_date ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <span class="inner-time" style="font-size: 12px;">${formatDate(topic.completed_date)}</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                `:``}
                                 ${topic && (!topic.sub_topics || topic.sub_topics.length === 0) ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <a class="inner-link" style="color: #7C32FF;font-weight:600;font-size:13px; cursor:pointer;" onclick="openMediaModal('${topic.image}')">Preview</a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                `:``}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sub-topicSec" id="subtopics-${topic.id}" style="padding:15px 45px;display:none;">
                    ${topic.sub_topics ? renderSubtopics(topic.sub_topics) : ''}
                </div>
            </div>
        </div>
    `).join('');
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = date.getDate().toString().padStart(2, '0');
            const month = date.toLocaleString('en-US', {
                month: 'short'
            });
            const year = date.getFullYear();

            return `${day}, ${month} ${year}`;
        }

        function renderSubtopics(subtopics) {
            if (!Array.isArray(subtopics)) {
                console.error('Subtopics is not an array:', subtopics);
                return '';
            }

            return subtopics.map(subtopic => `
        <div class="row-inner row" style="display:flex;align-items: center;margin-top:10px;">
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="left-inner-child d-flex" style="gap:1.5em;align-items:center;">
                    <div class="svg-inner" style="position: relative;">
                        <div class="subtopic-icon" data-subtopic-id="${subtopic.id }">
                         ${renderSubtopicIcon(subtopic.id,subtopic.completed_status)}
                        </div>
                    </div>
                    <div class="content-inner">
                        <span class="inner-content-head d-block" style="color: #112375;font-size:14px;font-weight:500;">${subtopic.sub_topic_title}</span>
                        ${renderSubToggleOrMark(subtopic)}
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="inner-right_sec d-flex" style="gap: 3em;justify-content:end;">
                    <span class="inner-time" style="font-size: 12px;">${subtopic.completed_status == 1 ? subtopic.completed_date : ''} </span>
                    <a class="inner-link" style="color: ${user && user.role_id == 2 && !subtopic.completed_status == 1 ? '#ddd' : '#7C32FF'};font-weight:600;font-size:13px;" onclick="openMediaModal('${subtopic.image}')">Preview</a>
                </div>
            </div>
        </div>
        <br/>
    `).join('');
        }

        function renderToggleOrMark(item) {
            if (user && user.role_id == 2) {
                return `<span class="mark-inner">Mark : <span style="color: ${item.avg_marks === null || item.avg_marks < 35 ? 'red' : 'green' };">${item.avg_marks ?? 'N/A'}</span>/${item.max_marks ?? 'N/A'}</span>`;
            } else {
                let allSubtopicsCompleted = item.sub_topics &&
                    item.sub_topics.length > 0 &&
                    item.sub_topics.every(subtopic => subtopic.completed_status == 1);

                if (allSubtopicsCompleted) {
                    item.completed_status = 1;
                }

                return `
        <div class="d-flex" style="gap:1em;">
            <span class="toggle-head">${item.completed_status == 1 ? 'Completed' : 'Incompleted'}</span>
        <label class="switch">
            <input type="checkbox" onchange="handleInputChange(event)" class="status-toggle" data-topic-id="${item.id}" data-subject-id="${item.subject_id}" ${item.completed_status == 1 ? 'checked' : ''}>
            <span class="slider round"></span>
        </label>
        </div>
    `;
            }
        }

        function renderSubToggleOrMark(item) {
            if (user && user.role_id == 2) {
                return `<span class="mark-inner">Mark : <span style="color: ${item.avg_marks === null || item.avg_marks < 35 ? 'red' : 'green' };">${item.avg_marks ?? 'N/A'}</span>/${item.max_marks ?? 'N/A'}</span>`;
            } else {
                return `
            <div class="d-flex" style="gap:1em;">
                <span class="toggle-head">${item.completed_status == 1 ? 'Completed' : 'Incompleted'}</span>
            <label class="switch">
                <input type="checkbox" onchange="handleSubTopicInputChange(event)" class="status-toggle" data-subtopic-id="${item.id}" data-subject-id="${item.subject_id}" ${item.completed_status == 1 ? 'checked' : ''}>
                <span class="slider round"></span>
            </label>
            </div>
        `;
            }
        }

        function handleInputChange(event) {
            const isChecked = event.target.checked;
            const inputValue = isChecked ? 1 : 2;
            const topicId = event.target.getAttribute('data-topic-id');
            const subjectId = event.target.getAttribute('data-subject-id');

            const toggleHead = event.target.closest('.d-flex').querySelector('.toggle-head');
            toggleHead.textContent = isChecked ? 'Completed' : 'Incompleted';

            $.ajax({
                url: '{{ route('topic.updateStatus') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    topicId: topicId,
                    status: inputValue
                },
                success: function(response) {
                    updateSubjectsData(subjectId, topicId, inputValue);

                    // if (isChecked) {
                    updateSubtopicsStatus(subjectId, topicId, inputValue);
                    // }
                    updateSubjectProgress(subjectId);

                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr.status, xhr.statusText);
                }
            });
        }

        function updateSubtopicsStatus(subjectId, topicId, status) {
            const subject = subjectsData.find(s => s.id == subjectId);
            if (subject) {
                subject.lessons.forEach(lesson => {
                    lesson.topics.forEach(topic => {
                        if (topic.id == topicId && topic.sub_topics) {
                            topic.sub_topics.forEach(subTopic => {
                                subTopic.completed_status = status;
                                updateSubTopicToggleUI(subTopic.id, status);
                                updateSubtopicIcon(subTopic.id, status);
                            });
                        }
                    });
                });
            }

            $.ajax({
                url: "{{ route('subtopics.updateStatusBulk') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    topicId: topicId,
                    status: status
                },
                success: function(response) {
                    updateSubjectsData(subjectId, topicId, status);
                },
                error: function(xhr) {
                    console.error('AJAX Error updating subtopics:', xhr.status, xhr.statusText);
                }
            });
        }

        function updateSubTopicToggleUI(subTopicId, isCompleted) {
            const subTopicToggle = document.querySelector(`input[data-subtopic-id="${subTopicId}"]`);
            if (subTopicToggle) {
                subTopicToggle.checked = isCompleted == 1;
                const toggleHead = subTopicToggle.closest('.d-flex').querySelector('.toggle-head');
                toggleHead.textContent = isCompleted ? 'Completed' : 'Incompleted';
            }
        }

        function updateSubjectsData(subjectId, topicId, newStatus) {

            const subject = subjectsData.find(s => s.id == subjectId);
            if (subject) {
                subject.lessons.forEach(lesson => {
                    lesson.topics.forEach(topic => {
                        if (topic.id == topicId) {
                            topic.completed_status = newStatus;
                        } else if (topic.sub_topics) {
                            topic.sub_topics.forEach(subTopic => {
                                if (subTopic.id == topicId) {
                                    subTopic.completed_status = newStatus;
                                }
                            });
                        }
                    });
                });
            }
        }

        function updateSubjectProgress(subjectId) {
            const subject = subjectsData.find(s => s.id == subjectId);

            if (subject) {
                const percentage = calculateSubjectProgress(subject);
                renderProgressBar(percentage, subjectId);
            }
        }


        function handleSubTopicInputChange(event) {
            const isChecked = event.target.checked;
            const inputValue = isChecked ? 1 : 2;
            const subTopicId = event.target.getAttribute('data-subtopic-id');
            const subjectId = event.target.getAttribute('data-subject-id');

            const toggleHead = event.target.closest('.d-flex').querySelector('.toggle-head');
            toggleHead.textContent = isChecked ? 'Completed' : 'Incompleted';

            $.ajax({
                url: '{{ route('subtopic.updateStatus') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    subTopicId: subTopicId,
                    status: inputValue
                },
                success: function(response) {
                    updateSubjectsData(subjectId, subTopicId, inputValue);
                    updateSubjectProgress(subjectId);
                    updateParentTopic(subjectId, subTopicId, inputValue);
                    updateSubtopicIcon(subTopicId, inputValue);
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr.status, xhr.statusText);
                }
            });
        }

        function updateParentTopic(subjectId, subTopicId, newStatus) {
            const subject = subjectsData.find(s => s.id == subjectId);
            if (subject) {
                subject.lessons.forEach(lesson => {
                    lesson.topics.forEach(topic => {
                        if (topic.sub_topics && topic.sub_topics.some(st => st.id == subTopicId)) {
                            const allSubtopicsCompleted = topic.sub_topics.every(st => st
                                .completed_status == 1);
                            if (allSubtopicsCompleted) {
                                topic.completed_status = 1;
                                updateTopicToggleUI(topic.id, true);
                            } else {
                                topic.completed_status = 2;
                                updateTopicToggleUI(topic.id, false);
                            }
                        }
                    });
                });
            }
        }

        function updateTopicToggleUI(topicId, isCompleted) {
            const topicToggle = document.querySelector(`input[data-topic-id="${topicId}"]`);
            if (topicToggle) {
                topicToggle.checked = isCompleted;
                const toggleHead = topicToggle.closest('.d-flex').querySelector('.toggle-head');
                toggleHead.textContent = isCompleted ? 'Completed' : 'Incompleted';
            }
        }

        function renderSubtopicIcon(subtopicId, completedStatus) {
            const iconColor = completedStatus == 1 ? '#009580' : '#7C32FF';
            const iconPath = completedStatus == 1 ?
                'M8.11439 4.7418L1.64516 0.312997C1.3464 0.108323 1.04538 0 0.79517 0C0.311439 0 0.012207 0.388229 0.012207 1.03807V10.61C0.012207 11.2591 0.311062 11.6466 0.793662 11.6466C1.04425 11.6466 1.34046 11.5382 1.63988 11.3329L8.11213 6.90422C8.52836 6.61894 8.75886 6.23504 8.75886 5.82277C8.75896 5.41079 8.53109 5.02699 8.11439 4.7418Z' :
                'M8.11133 5.53705H7.72753V3.20561C7.72753 1.51192 6.34994 0.134155 4.65661 0.134155C2.96292 0.134155 1.58516 1.51192 1.58516 3.20561V5.53705H1.20136C0.540861 5.53705 0.00537109 6.07236 0.00537109 6.73304V12.281C0.00537109 12.9415 0.540861 13.477 1.20136 13.477H8.11133C8.77182 13.477 9.30749 12.9415 9.30749 12.281V6.73304C9.30749 6.07236 8.77182 5.53705 8.11133 5.53705ZM2.65972 3.20561C2.65972 2.10454 3.55554 1.20872 4.65661 1.20872C5.75732 1.20872 6.65297 2.10454 6.65297 3.20561V5.53705H2.65972V3.20561ZM5.26839 10.9398V9.44648C5.55476 9.25056 5.74281 8.92174 5.74281 8.54887C5.74281 7.94872 5.25639 7.46213 4.65643 7.46213C4.05647 7.46213 3.57005 7.94854 3.57005 8.54887C3.57005 8.92174 3.7581 9.25091 4.04465 9.44648V10.9398C4.04465 11.2777 4.31848 11.5515 4.65643 11.5515C4.99456 11.5515 5.26839 11.2777 5.26839 10.9398Z';

            return `
        <svg width="27" height="27" viewBox="0 0 27 27" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="27" height="27" rx="5" fill="${iconColor}" />
        </svg>
        <svg style="position: absolute;left:${completedStatus == 1 ? '10px' : '9px'};top:7px;" width="${completedStatus == 1 ? '9' : '10'}" height="${completedStatus == 1 ? '12' : '14'}" viewBox="0 0 ${completedStatus == 1 ? '9 12' : '10 14'}" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="${iconPath}" fill="white"/>
        </svg>
    `;
        }

        function updateSubtopicIcon(subtopicId, newStatus) {
            const iconContainer = document.querySelector(`.subtopic-icon[data-subtopic-id="${subtopicId}"]`);
            if (iconContainer) {
                iconContainer.innerHTML = renderSubtopicIcon(subtopicId, newStatus);
            }
        }

        document.querySelectorAll('.status-change-input').forEach(input => {
            input.addEventListener('change', function(event) {
                const subtopicId = event.target.dataset.subtopicId;
                const newStatus = event.target.value;

                updateSubtopicIcon(subtopicId, newStatus);
            });
        });



        function toggleSubtopics(topicId) {
            const subtopicsContainer = document.getElementById(`subtopics-${topicId}`);
            const icon = document.getElementById(`icon-${topicId}`);

            const allSubtopics = document.querySelectorAll('[id^="subtopics-"]');
            allSubtopics.forEach(function(el) {
                if (el !== subtopicsContainer && el.style.display === 'block') {
                    el.style.display = 'none';
                    const previousIcon = document.getElementById(`icon-${el.id.replace('subtopics-', '')}`);
                    previousIcon.classList.remove('ti-minus');
                    previousIcon.classList.add('ti-plus');
                }
            });

            if (subtopicsContainer.style.display === 'none') {
                subtopicsContainer.style.display = 'block';
                icon.classList.remove('ti-plus');
                icon.classList.add('ti-minus');
            } else {
                subtopicsContainer.style.display = 'none';
                icon.classList.remove('ti-minus');
                icon.classList.add('ti-plus');
            }
        }

        function getFileType(fileName) {
            const extension = fileName.split('.').pop().toLowerCase();

            console.log("d", extension);

            if (extension.includes('png', 'jpg', 'jpeg', 'gif')) {
                return 'image';
                console.log('image');

            } else if (extension.includes('mp4', 'webm', 'ogg')) {
                return 'video';
                console.log('video');
            } else if (extension.includes('pdf')) {
                return 'pdf';
                console.log('pdf');
            }

        }


        function openMediaModal(mediaFile) {
            const mediaPreviewContent = document.getElementById('mediaPreviewContent');
            const baseImagePath = "{{ asset('public/') }}";
            mediaPreviewContent.innerHTML = '';

            const defaultImagePath = `{{ asset('public/backEnd/img/default.png') }}`;

            const filePath = mediaFile ? `${baseImagePath}/${mediaFile}` : defaultImagePath;

            const fileType = getFileType(mediaFile);

            console.log(filePath);

            if (fileType === 'image') {
                mediaPreviewContent.innerHTML = `
            <img src="${filePath}" onerror="this.src='${defaultImagePath}';" alt="Image Preview" style="max-width: 100%; height: auto;">
        `;
            } else if (fileType === 'video') {
                mediaPreviewContent.innerHTML = `
            <video controls style="max-width: 100%; height: auto;">
                <source src="${filePath}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        `;
            } else if (fileType === 'pdf') {
                mediaPreviewContent.innerHTML = `
            <embed src="${filePath}" width="100%" height="500px" type="application/pdf">
        `;
            } else {
                mediaPreviewContent.innerHTML = `
            <p>Unsupported file type. Please upload a valid image, video, or PDF file.</p>
        `;
            }

            $('#mediaModal').modal('show');
        }

        function calculateSubjectProgress(subject) {
            let totalItems = 0;
            let completedItems = 0;

            subject.lessons.forEach(lesson => {
                lesson.topics.forEach(topic => {
                    if (topic.sub_topics && topic.sub_topics.length > 0) {
                        topic.sub_topics.forEach(subTopic => {
                            totalItems++;
                            if (subTopic.completed_status == 1) {
                                completedItems++;
                            }
                        });
                    } else {
                        totalItems++;
                        if (topic.completed_status == 1) {
                            completedItems++;
                        }
                    }
                });
            });

            const percentage = totalItems > 0 ? Math.round((completedItems / totalItems) * 100) : 0;

            setTimeout(() => {
                renderProgressBar(percentage, subject.id);
            }, 50);

            return percentage;

        }

        function renderProgressBar(percentage, subjectId) {

            const progressBarContainer = document.querySelector(`#subject-${subjectId} .progress-bar`);
            const progressValueContainer = document.querySelector(`#subject-${subjectId} .progress-value`);

            if (progressBarContainer && progressValueContainer) {
                progressBarContainer.style.width = `${percentage}%`;
                progressBarContainer.setAttribute('aria-valuenow', percentage);
                progressValueContainer.textContent = `${percentage}%`;
            } else {
                console.error('Progress bar container not found for subject:', subjectId);
            }
        }
    </script>
@endsection
