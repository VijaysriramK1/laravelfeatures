@extends('backEnd.master')
@section('title')
    @lang('lesson::lesson.lesson_plan_overview')
@endsection
@push('css')
    <style>
        .tbl-scroll {
            overflow-x: scroll;
            scrollbar-width: none;
        }

        .display-hide-cls {
            display: none;
        }

        .dataTables_paginate {
            white-space: nowrap !important;
        }

        .previous {
            display: none !important;
        }

        .dataTables_processing {
            display: none !important;
        }

        .dataTables_wrapper .dataTable tr td {
            padding-left: 20px;
        }

        table.dataTable thead th:first-child {
            content: "";
        }

        table.dataTable thead th:first-child::after {
            content: "";
        }

        .no-data-cls {
            text-align: center;
            color: #777;
            padding-top: 20px !important;
        }

        table.dataTable .dataTables_empty {
            display: none;
        }

        .disabled-cls {
            pointer-events: none;
            opacity: 0.5;
        }

        .table-loader {
            width: 48px;
            height: 48px;
            border: 3px solid #FFF;
            border-radius: 50%;
            display: inline-block;
            position: relative;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        .table-loader::after {
            content: '';
            box-sizing: border-box;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 3px solid;
            border-color: #FF3D00 transparent;
        }

        @keyframes rotation {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 1200px) {
            .dataTables_filter label {
                top: -20px;
                left: 50% !important;
            }
        }

        @media (max-width: 991px) {
            .dataTables_filter label {
                top: -20px !important;
                width: 100%;
            }

        }

        @media (max-width: 767px) {
            .dataTables_filter label {
                top: -20px !important;
                width: 100%;
            }

            .dt-buttons {
                bottom: 100px !important;
                top: auto !important
            }
        }

        @media screen and (max-width: 640px) {
            div.dt-buttons {
                display: none;
            }

            .dataTables_filter label {
                top: -60px !important;
                width: 100%;
                float: right;
            }

            .main-title {
                margin-bottom: 40px
            }
        }
    </style>
@endpush
@section('mainContent')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ url('Modules/Lesson/Resources/assets/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ url('Modules/Lesson/Resources/assets/css/lesson_plan.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#progressbar").progressbar({
                value: @isset($percentage)
                    {{ $percentage }}
                @endisset
            });
        });
    </script>


    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('lesson::lesson.lesson_plan_overview')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('lesson::lesson.lesson')</a>
                    <a href="#">@lang('lesson::lesson.lesson_plan_overview')</a>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="row">
            <div class="col-lg-12">

                <div class="white-box">
                    <div class="row">
                        <div class="col-lg-3 mt-30-md">
                            <label class="primary_input_label" for="">
                                {{ __('common.teacher') }}
                                <span class="text-danger"> *</span>
                            </label>
                            <select class="primary_select form-control" name="teacher" id="select-teacher">
                                <option data-display="@lang('common.select_teacher') *" value="">@lang('common.select_teacher') *
                                </option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}"
                                        {{ isset($teacher_id) ? ($teacher_id == $teacher->id ? 'selected' : '') : '' }}>
                                        {{ $teacher->full_name }}</option>
                                @endforeach
                            </select>
                        </div>


                        @includeIf('backEnd.common.search_criteria', [
                            'div' => 'col-lg-3',
                            'required' => ['class', 'section', 'subject'],
                            'visiable' => ['class', 'section', 'subject'],
                            'subject' => true,
                        ])


                        <div class="col-lg-12 mt-20 text-right">
                            <a id="search-btn-id" type="button"
                                class="search-btn-cls primary-btn small fix-gr-bg disabled-cls">
                                <span class="ti-search pr-2"></span>
                                @lang('common.search')
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tbl-scroll mt-3">
            <div id="lesson-plan-table-global-id" class="display-hide-cls card p-3">
                <table id="lesson-plan-table" class="display nowrap" style="width:100%;">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>@lang('lesson::lesson.lesson')</th>
                            <th>@lang('lesson::lesson.topic')</th>
                            <th>@lang('communicate.Sub Topics')</th>
                            <th>@lang('communicate.Starting Date')</th>
                            <th>@lang('communicate.Ending Date')</th>
                            <th>@lang('lesson::lesson.completed_date')</th>
                            <th>@lang('common.status')</th>
                            <th>@lang('common.action')</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <div id="no-data-part" class="display-hide-cls no-data-cls p-3">
                    No data available
                </div>
            </div>

            <div id="table-reload-part" class="display-hide-cls card p-3">
                <div class="d-flex justify-content-center">
                    <div class="table-loader"></div>
                </div>
            </div>
        </div>
    </section>


    <div class="modal fade" id="popupOpen" tabindex="-1" aria-labelledby="popupOpenLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="popupOpenLabel" style="font-size: 16px;">Status Edit</h1>
                    <a href="javascript:void(0);" class="text-decoration-none text-white" data-bs-dismiss="modal"
                        aria-label="Close"><i class="bi bi-x text-white" style="font-size: 20px !important;"></i></a>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="popup-id" value="" />
                    <div>
                        <label class="form-label"><strong>Complete Date</strong> </label>
                        <input type="text" id="popup-complete-date" class="form-control" placeholder="Choose Date"
                            autocomplete="off" />
                    </div>

                    <div class="mt-2">
                        <label class="form-label"><strong>Complete Status</strong> </label>
                        <select class="primary_select form-control" id="popup-complete-status">
                            <option value="" hidden>Select Status</option>
                            <option value="Completed">Completed</option>
                            <option value="In Completed">In Completed</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="popupClose"
                        style="display: none;">Close</button>
                    <a id="popop-submit-btn-id" type="button"
                        class="primary-btn fix-gr-bg nowrap popop-submit-btn-cls disabled-cls">Submit</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.date_picker_css_js')
@push('script')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".weekend_switch_topic").on("change", function() {
                var id = $(this).data("id");
                $('#lessonplan_id').val(id);
                $('#calessonplan_id').val(id);

                if ($(this).is(":checked")) {
                    var status = "1";
                    var modal = $('#showReasonModal');
                    modal.modal('show');

                } else {
                    var status = "0";
                    var modal = $('#CancelModal');
                    modal.modal('show');
                }


            });
        });

        $(document).ready(function() {
            $("#popup-complete-date").datepicker();
        });

        $('#select-teacher, #common_select_class, #common_select_section, #common_select_subject').change(function() {
            var teacherId = $('#select-teacher').val();
            var classId = $('#common_select_class').val();
            var sectionId = $('#common_select_section').val();
            var subjectId = $('#common_select_subject').val();

            if (teacherId != '' && classId != '' && sectionId != '' && subjectId != '') {
                document.getElementById('search-btn-id').classList.remove('disabled-cls');
            } else {
                document.getElementById('search-btn-id').classList.add('disabled-cls');
            }

        });

        $(document).on('click', '.search-btn-cls', function(e) {
            document.getElementById('table-reload-part').classList.remove('display-hide-cls');
            document.getElementById('lesson-plan-table-global-id').classList.add('display-hide-cls');
            $('#lesson-plan-table').DataTable().destroy();
            dataSearch();
        });


        function dataSearch() {
            var classId = $('#common_select_class').val();
            var sectionId = $('#common_select_section').val();
            var subjectId = $('#common_select_subject').val();
            var teacherId = $('#select-teacher').val();
            $('#lesson-plan-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/lesson-plan-overview-search?class_id=' + classId + '&section_id=' + sectionId +
                        '&subject_id=' + subjectId + '&teacher_id=' + teacherId,
                    type: 'GET',
                    complete: function() {
                        document.getElementById('table-reload-part').classList.add('display-hide-cls');
                        document.getElementById('lesson-plan-table-global-id').classList.remove(
                            'display-hide-cls');
                    },
                    error: function() {
                        document.getElementById('no-data-part').classList.remove('display-hide-cls');
                        document.getElementById('lesson-plan-table').classList.add('display-hide-cls');
                        $('.dataTables_wrapper .dataTables_paginate').hide();
                        $('.dataTables_wrapper .dataTables_info').hide();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'lesson',
                        name: 'lesson',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'topic',
                        name: 'topic',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'sub_topic',
                        name: 'sub_topic',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {

                            if (!Array.isArray(data)) {
                                return '--';
                            } else {
                                let subtopicHtml = [];
                                data.forEach(item => {
                                    if (item.sub_topic_name.length > 0) {
                                        subtopicHtml.push(item.sub_topic_name.join('<div></div>'));
                                    } else {
                                        var emptyContent = '--';
                                        subtopicHtml.push(emptyContent);
                                    }
                                });
                                return subtopicHtml;
                            }

                        }
                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'end_date',
                        name: 'end_date',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'complete_date',
                        name: 'complete_date',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],

                "drawCallback": function() {
                    var getApiDetails = this.api();
                    var getLengthData = getApiDetails.data().length === 0;

                    if (getLengthData) {
                        document.getElementById('no-data-part').classList.remove('display-hide-cls');
                        document.getElementById('lesson-plan-table').classList.add('display-hide-cls');
                        $('.dataTables_wrapper .dataTables_paginate').hide();
                        $('.dataTables_wrapper .dataTables_info').hide();
                    } else {
                        document.getElementById('no-data-part').classList.add('display-hide-cls');
                        document.getElementById('lesson-plan-table').classList.remove('display-hide-cls');
                        $('.dataTables_wrapper .dataTables_paginate').show();
                        $('.dataTables_wrapper .dataTables_info').show();
                    }
                },

                info: true,
                pageLength: 10,
                lengthChange: false,
                autoWidth: false,
                ordering: false,
                searching: false,
                responsive: true
            });
        }

        $(document).on('click', '.popup-open-btn-cls', function(e) {
            var popupId = $(this).data('popup_id');
            $('#popup-id').val(popupId);
            popupSubmitBtnCondition();
        });

        $('#popupOpen').on('hidden.bs.modal', function() {
            $('#popup-id').val('');
            $('#popup-complete-date').val('');
            $('#popup-complete-status').val('');
        });


        $('#popup-complete-date, #popup-complete-status').change(function() {
            popupSubmitBtnCondition();
        });

        function popupSubmitBtnCondition() {
            var popupId = $('#popup-id').val();
            var completeDate = $('#popup-complete-date').val();
            var completeStatus = $('#popup-complete-status').val();

            if (popupId != '' && completeDate != '' && completeStatus != '') {
                document.getElementById('popop-submit-btn-id').classList.remove('disabled-cls');
            } else {
                document.getElementById('popop-submit-btn-id').classList.add('disabled-cls');
            }
        }


        $(document).on('click', '.popop-submit-btn-cls', function(e) {
            document.getElementById('lesson-plan-table-global-id').classList.add('display-hide-cls');
            document.getElementById('table-reload-part').classList.remove('display-hide-cls');
            $('#popupClose').click();
            var popupId = $('#popup-id').val();
            var teacherId = $('#select-teacher').val();
            var classId = $('#common_select_class').val();
            var subjectId = $('#common_select_subject').val();
            var sectionId = $('#common_select_section').val();
            var completeDate = $('#popup-complete-date').val();
            var completeStatus = $('#popup-complete-status').val();
            var reloadUrl = '/lesson-plan-overview-search?class_id=' + classId + '&section_id=' + sectionId +
                '&subject_id=' + subjectId + '&teacher_id=' + teacherId;
            var reloadTable = $("#lesson-plan-table").DataTable();
            $.ajax({
                url: '/lesson-plan-overview-status-update?id=' + popupId + '&completed_date=' +
                    completeDate + '&status=' + completeStatus,
                method: 'GET',
                success: function(response) {
                    if (response.status == 'success') {
                        reloadTable.ajax.url(reloadUrl).load();
                        toastr.success(response.message);
                    }
                }
            });
        });
    </script>
@endpush
