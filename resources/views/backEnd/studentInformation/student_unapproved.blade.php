@extends('backEnd.master')
@section('title')
    Unapproved Students
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
            min-height: 46px;
            text-align: left;
            font-size: 14px;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }

        .select2-selection__rendered {
            margin: 8px;
        }

        .select2-selection__arrow {
            margin: 8px;
        }

        .disabled-cls {
            pointer-events: none;
            opacity: 0.5;
        }

        .tbl-scroll {
            overflow-x: scroll;
            scrollbar-width: none;
        }

        .display-hide-property {
            display: none;
        }

        .dataTables_processing {
            display: none !important;
        }

        .dataTables_wrapper .dataTable tbody tr td:nth-child(1),
        .dataTables_wrapper .dataTable tbody tr td:nth-child(5) {
            padding-left: 20px;
        }

        table.dataTable thead th:first-child {
            content: "";
        }

        table.dataTable thead th:first-child::after {
            content: "";
        }

        table.dataTable thead .sorting::after {
            top: 10px !important;
            left: 0px !important;
        }

        table.dataTable thead .sorting_asc::after {
            top: 10px !important;
            left: 0px !important;
        }

        table.dataTable thead .sorting_desc::after {
            top: 10px !important;
            left: 0px !important;
        }

        .dataTables_paginate {
            white-space: nowrap !important;
        }

        .previous {
            display: none !important;
        }

        #no-data {
            text-align: center;
            color: #777;
            padding-top: 20px !important;
        }

        table.dataTable .dataTables_empty {
            display: none;
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
    <div class="card p-3">
        <div class="main-title">
            <h3 class="mb-15">Select Criteria</h3>
        </div>
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="p-3">
                    <label class="form-label">Class</label>
                    <select id="select-class">
                        <option value="" hidden>Choose Class</option>
                    </select>
                </div>
            </div>

            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="p-3">
                    <label class="form-label">Section</label>
                    <select id="select-section">
                        <option value="" hidden>Choose Section</option>
                    </select>
                </div>
            </div>

            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="p-3">
                    <!-- empty -->
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


    <div class="card mt-3 p-3">
        <div class="main-title">
            <h3 class="mb-15">Un Approved Student List</h3>
        </div>

        <div class="tbl-scroll">
            <div id="global-table-id" class="display-hide-property">
                <table id="unapproved-table" class="display nowrap" style="width:100%;">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Admission No</th>
                            <th>Name</th>
                            <th>Dob</th>
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


        <div id="table-reload-part">
            <div class="d-flex justify-content-center mb-3">
                <div class="table-loader"></div>
            </div>
        </div>

    </div>
@endsection

@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')

@push('script')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#select-class').select2();
            $('#select-section').select2();
        });

        $(document).ready(function() {
            $.ajax({
                url: '/student-class-list',
                method: 'GET',
                success: function(response) {
                    response.forEach(function(item) {
                        $("#select-class").append("<option value='" + item.id + "'>" +
                            item.class_name + "</option>"
                        );
                    });
                }
            })
        });

        $('#select-class').on('change', function() {
            $('#select-section').find('option').not(':first').remove();
            var selected_class = $('#select-class').val();
            $.ajax({
                url: '/student-class-wise-section-list?class_id=' + selected_class,
                method: 'GET',
                success: function(response) {
                    response.forEach(function(item) {
                        $("#select-section").append("<option value='" +
                            item.sectionname.id + "'>" +
                            item.sectionname.section_name + "</option>"
                        );
                    });
                }
            });
        });


        $('#select-class, #select-section').change(function() {
            var classId = $('#select-class').val();
            var sectionId = $('#select-section').val();

            if (classId != '' && sectionId != '') {
                document.getElementById('search-btn-id').classList.remove('disabled-cls');
            } else {
                document.getElementById('search-btn-id').classList.add('disabled-cls');
            }

        });

        $(document).on('click', '.search-btn-cls', function() {
            document.getElementById('table-reload-part').classList.remove('display-hide-property');
            document.getElementById('global-table-id').classList.add('display-hide-property');
            var classId = $('#select-class').val();
            var sectionId = $('#select-section').val();
            var filter_table = $("#unapproved-table").DataTable();
            var reload_url = '/student-unapproved-list?class_id=' + classId +
                '&section_id=' + sectionId;
            filter_table.ajax.url(reload_url).load();
        });


        $(document).ready(function() {
            $('#unapproved-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/student-unapproved-list',
                    type: 'GET',
                    complete: function() {
                        document.getElementById('table-reload-part').classList.add(
                            'display-hide-property');
                        document.getElementById('global-table-id').classList.remove(
                            'display-hide-property');
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
                        data: 'admission_no',
                        name: 'admission_no',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'full_name',
                        name: 'full_name',
                        orderable: true,
                        searchable: false
                    },
                    {
                        data: 'dob',
                        name: 'dob',
                        orderable: true,
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
                ordering: true,
                searching: false,
                responsive: true
            });
        });

        $(document).on('click', '.approvedstatus', function(e) {
            document.getElementById('global-table-id').classList.add('display-hide-property');
            document.getElementById('table-reload-part').classList.remove('display-hide-property');
            var data_id = $(this).data('id');
            var filter_table = $("#unapproved-table").DataTable();
            var reload_url = '/student-unapproved-list';
            $.ajax({
                url: "/student-status-update/" + data_id + '/approvedstatus',
                method: 'GET',
                success: function(response) {
                    if (response.status === 'success') {
                        filter_table.ajax.url(reload_url).load();
                        toastr.success(response.message);
                    }
                }
            });
        });

        $(document).on('click', '.viewclick', function(e) {
            localStorage.setItem('studentpagestatus', 'view');
        });
        $(document).on('click', '.editclick', function(e) {
            localStorage.setItem('studentpagestatus', 'edit');
        });
    </script>
@endpush
