@extends('backEnd.master')
@section('title')
    Student Attendance Request
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            text-decoration: none !important;
        }

        .tab-content {
            overflow: hidden;
            white-space: nowrap;
            width: 100%;
            cursor: pointer;
        }

        .tab-part {
            display: inline-block;
            user-select: none;
        }

        .tab-item {
            display: inline-block;
            padding-top: 9px;
            margin: 0px 20px;
            padding-bottom: 16px;
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

        .classwisetable {
            color: #828bb2;
            font-weight: 500;
        }

        .active-tab {
            color: black;
            border-bottom-width: 3px;
            border-bottom-style: solid;
            border-bottom-color: #7C32FF;
            transition: padding-top 0s, border-bottom-width 0s, border-bottom-color 0s !important;
        }

        .active-tab-hover:hover {
            color: black;
            border-bottom-width: 3px;
            border-bottom-style: solid;
            border-bottom-color: #7C32FF;
            transition: padding-top 0s, border-bottom-width 0s, border-bottom-color 0s !important;
        }

        .table-hide-property {
            display: none;
        }

        .tbl-scroll {
            overflow-x: scroll;
            scrollbar-width: none;
        }

        #no-data {
            text-align: center;
            color: #777;
            padding-top: 20px !important;
        }

        table.dataTable .dataTables_empty {
            display: none;
        }

        .danger-btn {
            background: #d33333;
            letter-spacing: 1px;
            line-height: 30px;
            padding: 0 10px;
            border-radius: 6px;
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
                    <h1>Student Attendance Request</h1>
                </div>
                <div class="col-12 col-sm-6 d-flex justify-content-sm-end">
                    <div class="bc-pages">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none">@lang('common.dashboard')</a>
                        <a href="#" class="text-decoration-none">@lang('student.student_information')</a>
                        <a href="#">Student Attendance Request</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="mt-5">

        <div class="tab-content">
            <div class="tab-part">
                @if (!empty($get_classwise_sections))
                    @foreach ($get_classwise_sections as $get_values)
                        <div class="tab-item tabId_{{ $get_values->class->id }}_{{ $get_values->section->id }}">
                            <a class="text-decoration-none classwisetable active-tab-hover" href="javascript:void(0);"
                                data-classid="{{ $get_values->class->id }}" data-sectionid="{{ $get_values->section->id }}">
                                <span>{{ strtoupper($get_values->class->class_name) ?? '' }}<span>
                                        <span>{{ strtoupper($get_values->section->section_name) ?? '' }}<span>(</span><span>{{ $get_values->get_count ?? '' }}</span><span>)</span></span></span>
                            </a>
                        </div>
                    @endforeach
                @else
                    <!-- empty -->
                @endif
            </div>
        </div>

    </div>

    <div class="card mt-0 p-3">
        <div id="global-table-id" class="table-hide-property">
            <div class="tbl-scroll">
                <table id="request-table" class="display nowrap" style="width:100%;">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Teacher Name</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Attendance Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <div id="no-data" style="display: none;">
                    No data available
                </div>
            </div>
        </div>

        <div class="table-reload-animation">
            <div class="d-flex justify-content-center mb-3">
                <div class="table-loader"></div>
            </div>
        </div>

    </div>
@endsection

@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')

@push('script')
    <script>
        $(document).ready(function() {
            var tabContent = document.querySelector('.tab-content');
            let isDragging = false;
            let startX, scrollLeft;

            tabContent.addEventListener('mousedown', (e) => {
                isDragging = true;
                startX = e.pageX - tabContent.offsetLeft;
                scrollLeft = tabContent.scrollLeft;
                tabContent.style.cursor = 'grabbing';
            });

            tabContent.addEventListener('mouseleave', () => {
                isDragging = false;
                tabContent.style.cursor = 'pointer';
            });

            tabContent.addEventListener('mouseup', () => {
                isDragging = false;
                tabContent.style.cursor = 'pointer';
            });

            tabContent.addEventListener('mousemove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
                var getOffsetLeft = e.pageX - tabContent.offsetLeft;
                var setCalculate = (getOffsetLeft - startX) * 1.5;
                tabContent.scrollLeft = scrollLeft - setCalculate;
            });

            tabContent.addEventListener('dragstart', (e) => {
                e.preventDefault();
            });

            tabContent.addEventListener('touchstart', (e) => {
                isDragging = true;
                startX = e.touches[0].pageX - tabContent.offsetLeft;
                scrollLeft = tabContent.scrollLeft;
                tabContent.style.cursor = 'grabbing';
            });

            tabContent.addEventListener('touchend', () => {
                isDragging = false;
                tabContent.style.cursor = 'pointer';
            });

            tabContent.addEventListener('touchmove', (e) => {
                if (!isDragging) return;
                e.preventDefault();
                var getOffsetLeft = e.touches[0].pageX - tabContent.offsetLeft;
                var setCalculate = (getOffsetLeft - startX) * 1.5;
                tabContent.scrollLeft = scrollLeft - setCalculate;
            });
        });

        $(document).ready(function() {
            $('#request-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/class-section-wise-attendance-details",
                    type: 'GET',
                    complete: function() {
                        document.querySelector(".table-reload-animation").style.display = "none";
                        document.getElementById('global-table-id').classList.remove(
                            'table-hide-property');
                    },
                    error: function() {
                        $('#no-data').show();
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
                        data: 'teacher_full_name',
                        name: 'teacher_full_name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'class',
                        name: 'class',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'section',
                        name: 'section',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'attendance_date',
                        name: 'attendance_date',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status_update',
                        name: 'status_update',
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
                        $('#no-data').show();
                        $('.dataTables_wrapper .dataTables_paginate').hide();
                        $('.dataTables_wrapper .dataTables_info').hide();
                    } else {
                        $('#no-data').hide();
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
        });

        $(document).ready(function() {
            var gettabclass = $('.classwisetable');
            gettabclass.first().addClass('active-tab');
        });

        $('.classwisetable').on('click', function() {
            $('.classwisetable').each(function() {
                $(this).removeClass('active-tab');
            });
        });

        $(document).on('click', '.classwisetable', function(e) {
            document.getElementById('global-table-id').classList.add('table-hide-property');
            document.querySelector(".table-reload-animation").style.display = "block";
            var classid = $(this).data('classid');
            var sectionid = $(this).data('sectionid');
            var filter_table = $("#request-table").DataTable();
            $('.tabId_' + classid + '_' + sectionid).find('.classwisetable').addClass('active-tab');
            var url = '/class-section-wise-attendance-details?selected_class=' + classid + '&selected_section=' +
                sectionid;
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    if (response.status == 'success') {
                        filter_table.ajax.url(url).load();
                    }
                }
            });
        });


        $(document).on('click', '.approve-cls', function() {
            document.getElementById('global-table-id').classList.add('table-hide-property');
            document.querySelector(".table-reload-animation").style.display = "block";
            var classid = $(this).data('classid');
            var sectionid = $(this).data('sectionid');
            var filter_table = $("#request-table").DataTable();
            var reload_url = '/class-section-wise-attendance-details?selected_class=' + classid +
                '&selected_section=' + sectionid;

            var collectedData = {
                id: $(this).data('id'),
                type: 'approve'
            };
            $.ajax({
                url: '/attendance-request-update',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(collectedData),
                success: function(response) {
                    if (response.status === 'success') {
                        filter_table.ajax.url(reload_url).load();
                        toastr.success(response.message);
                    }
                }
            });
        });


        $(document).on('click', '.disapprove-cls', function() {
            document.getElementById('global-table-id').classList.add('table-hide-property');
            document.querySelector(".table-reload-animation").style.display = "block";
            var classid = $(this).data('classid');
            var sectionid = $(this).data('sectionid');
            var filter_table = $("#request-table").DataTable();
            var reload_url = '/class-section-wise-attendance-details?selected_class=' + classid +
                '&selected_section=' + sectionid;

            var collectedData = {
                id: $(this).data('id'),
                type: 'disapprove'
            };
            $.ajax({
                url: '/attendance-request-update',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(collectedData),
                success: function(response) {
                    if (response.status === 'success') {
                        filter_table.ajax.url(reload_url).load();
                        toastr.success(response.message);
                    }
                }
            });
        });


        $(document).on('click', '.delete-cls', function() {
            document.getElementById('global-table-id').classList.add('table-hide-property');
            document.querySelector(".table-reload-animation").style.display = "block";
            var classid = $(this).data('classid');
            var sectionid = $(this).data('sectionid');
            var filter_table = $("#request-table").DataTable();
            var reload_url = '/class-section-wise-attendance-details?selected_class=' + classid +
                '&selected_section=' + sectionid;

            var collectedData = {
                id: $(this).data('id'),
            };
            $.ajax({
                url: '/attendance-request-delete',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(collectedData),
                success: function(response) {
                    if (response.status === 'success') {
                        filter_table.ajax.url(reload_url).load();
                        toastr.success(response.message);
                    }
                }
            });
        });
    </script>
@endpush
