@extends('backEnd.master')
@section('title')
    @lang('student.student_attendance')
@endsection
@push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            text-decoration: none !important;
        }

        .select2-selection {
            box-shadow: 0;
            border: 0;
            border-radius: 0;
            outline: 0;
            min-height: 48px;
            text-align: left;
            font-size: 14px;
        }

        .select2-selection__rendered {
            margin: 10px;
        }

        .select2-selection__arrow {
            margin: 10px;
        }

        .select2-container--default .select2-selection--single {
          width: 100%; 
          border: 1px solid rgba(130, 139, 178, 0.3); 
          height: 46px; 
          line-height: 44px; 
          font-size: 13px; 
          color: #415094; 
          font-weight: 300;
        }
        .select2-container--default .select2-results__option {
           font-size: 13px; 
           color: #415094; 
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: rgba(130, 139, 178, 0.3) transparent transparent transparent; 
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
           background-color: rgba(130, 139, 178, 0.1); 
           color: #7c32ff;
        }
        .select2-container--default .select2-search--dropdown .select2-search__field {
           box-sizing: border-box;
           background-color: #fff; 
           border: 1px solid rgba(130, 139, 178, 0.3); 
           border-radius: 3px;
           box-shadow: none; 
           color: #333;
           display: inline-block;
           vertical-align: middle; 
           padding: 0 8px;
           width: 100% !important;
           height: 36px; 
           line-height: 36px; 
           outline: 0 !important; 
        }
        .select2-container--default .select2-results__option:first-child {
           color: #7c32ff; 
        }

        .select2-dropdown {
            border: 1px solid rgba(130, 139, 178, 0.3); 
            border-radius: 4px; /* Border radius */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .date-chooser {
          width: 100%; 
          border: 1px solid rgba(130, 139, 178, 0.3); 
          border-radius: 4px;
          min-height: 48px;
          font-size: 13px; 
          height: 28px;
          color: #415094; 
          font-weight: 300;
        }
        .date-chooser:focus {
          outline: none;
          border-color: rgba(130, 139, 178, 0.3) !important;
          box-shadow: none;
        }
        .form-control:focus {
            border-color: rgba(130, 139, 178, 0.3) !important;
        }

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

        #no-data {
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

        input[type="radio"]:disabled+label {
            opacity: 0.8;
            pointer-events: none;
        }

        .modal-content {
            border-radius: 0px !important;
        }

        .modal-content .modal-header {
            border-radius: 0px 0px 0px 0px !important;
            padding: 10px !important;
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
    </style>
@endpush
@section('mainContent')
    <section class="sms-breadcrumb mb-20 up_breadcrumb">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h1>@lang('student.student_attendance')</h1>
                </div>
                <div class="col-12 col-sm-6 d-flex justify-content-sm-end">
                    <div class="bc-pages">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none">@lang('common.dashboard')</a>
                        <a href="#" class="text-decoration-none">@lang('student.student_information')</a>
                        <a href="#">@lang('student.student_attendance')</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="white-box filter_card">
        <div class="main-title">
            <h3 class="mb-15">Select Criteria</h3>
        </div>
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="p-3">
                    <label class="primary_input_label">Class <span class="text-danger">*</span></label>
                    <select id="select-class">
                        <option value="" hidden>Choose Class</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="p-3">
                    <label class="primary_input_label">Section <span class="text-danger">*</span></label>
                    <select id="select-section">
                        <option value="" hidden>Choose Section</option>
                    </select>
                </div>
            </div>


            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="p-3">
                    <label class="primary_input_label">Attendance Date <span class="text-danger">*</span></label>
                    <input type="text" class="form-control date-chooser" placeholder="Choose Date" id="select-date"
                        autocomplete="off">
                </div>
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-end">
            <a id="search-btn-id" type="button" class="search-btn-cls primary-btn small fix-gr-bg disabled-cls">
                <span class="ti-search pr-2"></span>
                @lang('common.search')
            </a>
        </div>
    </div>

    <div id="attendance-table-global-id" class="display-hide-cls card mt-3 p-3">

        <div class="row">
            <div class="col-6">
                <div class="main-title">
                    <h3 class="mb-15">Student Attendance</h3>
                </div>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <div id="attendance-btn-part">
                    <div class="d-flex justify-content-end">
                        <a id="attendance-btn-id" type="button"
                            class="primary-btn fix-gr-bg nowrap attendance-btn-cls display-hide-cls disabled-cls">@lang('student.attendance')</a>
                    </div>

                    <a type="button" class="primary-btn fix-gr-bg nowrap request-btn-cls display-hide-cls"
                        data-bs-toggle="modal" data-bs-target="#openPopup">
                        Request
                    </a>
                </div>
            </div>
        </div>

        <div class="tbl-scroll">
            <table id="attendance-table" class="mt-3 display nowrap" style="width:100%;">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Admission No</th>
                        <th>Student Name</th>
                        <th>Roll Number</th>
                        <th>Attendance</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <div id="no-data" style="display: none;">
                No data available
            </div>
        </div>

    </div>

    <div id="table-reload-part" class="display-hide-cls card mt-3 p-3">
        <div class="main-title">
            <h3 class="mb-15">Student Attendance</h3>
        </div>
        <div class="d-flex justify-content-center mb-3">
            <div class="table-loader"></div>
        </div>
    </div>

    <!-- popup -->
    <div class="modal fade" id="openPopup" tabindex="-1" aria-labelledby="openPopupLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="openPopupLabel" style="font-size: 16px;">Send Request</h1>
                    <a href="javascript:void(0);" class="text-decoration-none text-white" data-bs-dismiss="modal"
                        aria-label="Close"><i class="bi bi-x fs-3 text-white"></i></a>
                </div>
                <div class="modal-body">
                    <div>
                        <label class="form-label"><strong>Request Notes</strong> <span>(Optional)</span></label>
                        <textarea id="request-note" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="requestModalClose"
                        style="display: none;">Close</button>
                    <a type="button" class="primary-btn fix-gr-bg nowrap request-send-cls">Send</a>
                </div>
            </div>
        </div>
    </div>
    <!-- popup -->
@endsection
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.date_picker_css_js')


@push('script')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#select-class').select2();
            $('#select-section').select2();
            $("#select-date").datepicker({
                maxDate: new Date()
            });
        });

        $('#select-class, #select-section, #select-date').change(function() {
            var class_id = $('#select-class').val();
            var section_id = $('#select-section').val();
            var attendance_date = $('#select-date').val();

            if (class_id != '' && section_id != '' && attendance_date != '') {
                document.getElementById('search-btn-id').classList.remove('disabled-cls');
            } else {
                document.getElementById('search-btn-id').classList.add('disabled-cls');
            }

        });

        $(document).ready(function() {
            $.ajax({
                url: '/attendance-class-list',
                method: 'GET',
                success: function(response) {
                    response.forEach(function(item) {
                        $("#select-class").append("<option value='" + item.class.id + "'>" +
                            item.class.class_name + "</option>"
                        );
                    });
                }
            })
        });

        $('#select-class').on('change', function() {
            $('#select-section').find('option').not(':first').remove();
            var selected_class = $('#select-class').val();
            $.ajax({
                url: '/attendance-section-list?class_id=' + selected_class,
                method: 'GET',
                success: function(response) {
                    response.forEach(function(item) {
                        $("#select-section").append("<option value='" + item.section
                            .id + "'>" + item.section.section_name + "</option>"
                        );
                    });
                }
            });
        });

        $(document).on('click', '.search-btn-cls', function(e) {
            document.getElementById('table-reload-part').classList.remove('display-hide-cls');
            document.getElementById('attendance-table-global-id').classList.add('display-hide-cls');
            $('#attendance-table').DataTable().destroy();
            var getDate = new Date();
            var currentDate = String(getDate.getMonth() + 1).padStart(2, '0') + '/' + String(getDate.getDate())
                .padStart(2, '0') + '/' + getDate.getFullYear();
            var attendance_date = $('#select-date').val();

            if (currentDate === attendance_date) {
                attendanceList();
                document.querySelector(".attendance-btn-cls").classList.remove(
                    'display-hide-cls');
                document.querySelector(".request-btn-cls").classList.add(
                    'display-hide-cls');
            } else {
                attendanceStatus();
            }
        });

        function attendanceList() {
            var class_id = $('#select-class').val();
            var section_id = $('#select-section').val();
            var attendance_date = $('#select-date').val();
            $('#attendance-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/staff-attendance-search?class_id=' + class_id +
                        '&section_id=' + section_id + '&attendance_date=' + attendance_date,
                    type: 'GET',
                    complete: function() {
                        document.getElementById('table-reload-part').classList.add(
                            'display-hide-cls');
                        document.getElementById('attendance-table-global-id').classList.remove(
                            'display-hide-cls');
                        radioChecked();
                    },
                    error: function() {
                        $('#no-data').show();
                        $('#attendance-btn-part').hide();
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
                        data: 'admission_no',
                        name: 'admission_no',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'student_name',
                        name: 'student_name',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'roll_number',
                        name: 'roll_number',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'attendance',
                        name: 'attendance',
                        orderable: false,
                        searchable: false
                    }
                ],

                "drawCallback": function() {
                    var getApiDetails = this.api();
                    var getLengthData = getApiDetails.data().length === 0;

                    if (getLengthData) {
                        $('#no-data').show();
                        $('#attendance-btn-part').hide();
                        $('.dataTables_wrapper .dataTables_paginate').hide();
                        $('.dataTables_wrapper .dataTables_info').hide();
                    } else {
                        $('#no-data').hide();
                        $('#attendance-btn-part').show();
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

        function attendanceStatus() {

            var collectedData = {
                class_id: $('#select-class').val(),
                section_id: $('#select-section').val(),
                attendance_date: $('#select-date').val()
            };

            $.ajax({
                url: '/class-section-wise-attendance-status',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(collectedData),
                success: function(response) {
                    if (response.current_status === 'approve') {
                        attendanceList();
                        document.querySelector(".attendance-btn-cls").classList.remove(
                            'display-hide-cls');
                        document.querySelector(".request-btn-cls").classList.add('display-hide-cls');
                    } else {
                        attendanceList();
                        document.querySelector(".request-btn-cls").classList.remove('display-hide-cls');
                        document.querySelector(".attendance-btn-cls").classList.add(
                            'display-hide-cls');

                    }
                }
            });
        }

        $(document).on('click', '.attendance-btn-cls', function(e) {
            document.getElementById('table-reload-part').classList.remove('display-hide-cls');
            document.getElementById('attendance-table-global-id').classList.add('display-hide-cls');

            var classId = $('#select-class').val();
            var sectionId = $('#select-section').val();
            var attendanceDate = $('#select-date').val();
            var attendanceTable = $('#attendance-table').DataTable();
            var reloadUrl = '/staff-attendance-search?class_id=' + classId + '&section_id=' +
                sectionId + '&attendance_date=' + attendanceDate;
            let setDetails = [];

            attendanceTable.rows().every(function() {
                var getDetails = this.node();
                var studentId = $(getDetails).find('td').eq(2).find('input[type="hidden"]').val();
                var attendanceType = $(getDetails).find('td').eq(4).find('input[type="radio"]:checked')
                    .val();
                setDetails.push({
                    student_id: studentId,
                    attendance_type: attendanceType

                });
            });

            var collectedData = {
                class_id: classId,
                section_id: sectionId,
                attendance_date: attendanceDate,
                collect_details: setDetails
            };

            $.ajax({
                url: '/class-section-wise-attendance-update',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(collectedData),
                success: function(response) {
                    if (response.status === 'success') {
                        attendanceTable.ajax.url(reloadUrl).load();
                        toastr.success(response.message);
                    }
                }
            });
        });


        $(document).on('click', '.request-send-cls', function() {
            var classId = $('#select-class').val();
            var sectionId = $('#select-section').val();
            var attendanceDate = $('#select-date').val();
            var requestNote = $('#request-note').val();

            var collectedData = {
                class_id: classId,
                section_id: sectionId,
                attendance_date: attendanceDate,
                request_notes: requestNote
            };

            $.ajax({
                url: '/class-section-wise-attendance-request',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(collectedData),
                success: function(response) {
                    if (response.status === 'success') {
                        $('#requestModalClose').click();
                        toastr.success(response.message);
                    }
                }
            });
        });

        $('#openPopup').on('hidden.bs.modal', function() {
            $('#request-note').val('');
        });

        $(document).on('click', '.radio-btn-cls', function(e) {
            radioChecked();
        });


        function radioChecked() {

            let getTotalCount = 0;
            let getCheckedCount = 0;

            $('#attendance-table tbody tr').each(function() {
                var radioInput = $(this).find('td').eq(4).find('input[type="radio"]');

                if (radioInput.length > 0) {
                    getTotalCount++;
                }

                if (radioInput.length > 0 && radioInput.is(':checked')) {
                    getCheckedCount++;
                }
            });

            if (getTotalCount == getCheckedCount) {
                document.getElementById('attendance-btn-id').classList.remove('disabled-cls');
            } else {
                document.getElementById('attendance-btn-id').classList.add('disabled-cls');
            }

        }
    </script>
@endpush
