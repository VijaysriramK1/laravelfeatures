@extends('backEnd.master')
@section('title')
    Add Stipend
@endsection
@push('css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">

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
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }

        .select2-selection__rendered {
            margin: 10px;
        }

        .select2-selection__arrow {
            margin: 10px;
        }

        .form-control:focus {
            border-color: #aaa !important;
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
    </style>
@endpush
@section('mainContent')
    <section class="sms-breadcrumb mb-20 up_breadcrumb">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h1>@lang('communicate.Add Stipend')</h1>
                </div>
                <div class="col-12 col-sm-6 d-flex justify-content-sm-end">
                    <div class="bc-pages">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none">@lang('common.dashboard')</a>
                        <a href="#" class="text-decoration-none">@lang('communicate.Scholarship')</a>
                        <a href="#">@lang('communicate.Add Stipend')</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="card p-3">
        <div class="main-title">
            <h3 class="mb-15">@lang('communicate.Select Criteria')</h3>
        </div>
        <div class="row">
            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="p-3">
                    <label class="form-label">@lang('communicate.Scholarship')</label>
                    <select id="select-scholarship">
                        <option value="" hidden>@lang('communicate.Choose Scholarship')</option>
                        @if (isset($get_scholarships) && !is_null($get_scholarships) && count($get_scholarships) > 0)
                            @foreach ($get_scholarships as $get_values)
                                <option value="{{ $get_values->id }}">{{ $get_values->name }}</option>
                            @endforeach
                        @else
                            <!-- empty -->
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="p-3">
                    <label class="form-label">@lang('communicate.Class')</label>
                    <select id="select-class">
                        <option value="" hidden>@lang('communicate.Choose Class')</option>
                        @if (isset($get_classes) && !is_null($get_classes) && count($get_classes) > 0)
                            @foreach ($get_classes as $get_values)
                                <option value="{{ $get_values->id }}">{{ $get_values->class_name }}</option>
                            @endforeach
                        @else
                            <!-- empty -->
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-12 col-xs-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                <div class="p-3">
                    <label class="form-label">@lang('communicate.Section')</label>
                    <select id="select-section">
                        <option value="" hidden>@lang('communicate.Choose Section')</option>
                    </select>
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

    <div class="tbl-scroll mt-3">
        <div id="stipend-table-global-id" class="display-hide-cls card p-3">
            <div class="row" id="btn-submit-part">
                <div class="col-6">
                    <!-- empty -->
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <a type="button" class="primary-btn fix-gr-bg nowrap btn-submit-cls">Save</a>
                </div>
            </div>



            <table id="stipend-table" class="display nowrap mt-3" style="width:100%;">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>@lang('communicate.Admission No')</th>
                        <th>@lang('communicate.Roll Number')</th>
                        <th>@lang('communicate.student_name')</th>
                        <th>@lang('communicate.Scholarship Starting Date')</th>
                        <th>@lang('communicate.Interval Type')</th>
                        <th>@lang('communicate.Cycle Count')</th>
                        <th>@lang('communicate.Maximum Stipend Amount')</th>
                        <th>@lang('communicate.Amount')</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <div id="no-data-part" class="display-hide-cls no-data-cls p-3">
                <div class="text-center">No data available.</div>
            </div>
        </div>

        <div id="table-reload-part" class="display-hide-cls card p-3">
            <div class="d-flex justify-content-center">
                <div class="table-loader"></div>
            </div>
        </div>
    </div>
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
            $('#select-scholarship').select2();
        });

        $('#select-class, #select-section, #select-scholarship').change(function() {
            var class_id = $('#select-class').val();
            var section_id = $('#select-section').val();
            var scholarship_id = $('#select-scholarship').val();

            if (class_id != '' && section_id != '' && scholarship_id != '') {
                document.getElementById('search-btn-id').classList.remove('disabled-cls');
            } else {
                document.getElementById('search-btn-id').classList.add('disabled-cls');
            }

        });

        $('#select-class').on('change', function() {
            $('#select-section').find('option').not(':first').remove();
            var selected_class = $('#select-class').val();
            $.ajax({
                url: '/stipend-selected-class-section-list?class_id=' + selected_class,
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

        $(document).on('click', '.search-btn-cls', function(e) {
            document.getElementById('table-reload-part').classList.remove('display-hide-cls');
            document.getElementById('stipend-table-global-id').classList.add('display-hide-cls');
            $('#stipend-table').DataTable().destroy();
            dataSearch();
        });

        function dataSearch() {
            var class_id = $('#select-class').val();
            var section_id = $('#select-section').val();
            var scholarship_id = $('#select-scholarship').val();
            $('#stipend-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/student-scholarship-search?class_id=' + class_id + '&section_id=' + section_id +
                        '&scholarship_id=' + scholarship_id,
                    type: 'GET',
                    complete: function() {
                        document.getElementById('table-reload-part').classList.add('display-hide-cls');
                        document.getElementById('stipend-table-global-id').classList.remove('display-hide-cls');
                    },
                    error: function() {
                        document.getElementById('no-data-part').classList.remove('display-hide-cls');
                        document.getElementById('stipend-table').classList.add('display-hide-cls');
                        document.getElementById('btn-submit-part').classList.add('display-hide-cls');
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
                        data: 'roll_number',
                        name: 'roll_number',
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
                        data: 'scholarship_starting_date',
                        name: 'scholarship_starting_date',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'interval_type',
                        name: 'interval_type',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'cycle_count',
                        name: 'cycle_count',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'stipend_amount',
                        name: 'stipend_amount',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'amount',
                        name: 'amount',
                        orderable: false,
                        searchable: false
                    }
                ],

                "drawCallback": function() {
                    var getApiDetails = this.api();
                    var getLengthData = getApiDetails.data().length === 0;

                    if (getLengthData) {
                        document.getElementById('no-data-part').classList.remove('display-hide-cls');
                        document.getElementById('stipend-table').classList.add('display-hide-cls');
                        document.getElementById('btn-submit-part').classList.add('display-hide-cls');
                        $('.dataTables_wrapper .dataTables_paginate').hide();
                        $('.dataTables_wrapper .dataTables_info').hide();
                    } else {
                        document.getElementById('no-data-part').classList.add('display-hide-cls');
                        document.getElementById('stipend-table').classList.remove('display-hide-cls');
                        document.getElementById('btn-submit-part').classList.remove('display-hide-cls');
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

        $(document).on('click', '.btn-submit-cls', function(e) {
            document.getElementById('table-reload-part').classList.remove('display-hide-cls');
            document.getElementById('stipend-table-global-id').classList.add('display-hide-cls');
            $('#stipend-table').DataTable().destroy();
            let setDetails = [];
            let studentDetails = [];

            var getStudentId = document.querySelectorAll('input[type="hidden"].student-cls');
            var getScholarshipId = document.querySelectorAll('input[type="hidden"].scholarship-cls');
            var getIntervalType = document.querySelectorAll('select#interval-type.interval-cls');
            var getCycleCount = document.querySelectorAll('input[type="number"].cycle-count-cls');
            var getAmount = document.querySelectorAll('input[type="number"].amount-cls');

            getStudentId.forEach((item, index) => {
                if (getIntervalType[index].value != '' && getCycleCount[index].value != '' && getAmount[
                        index].value != '') {
                    setDetails.push({
                        student_id: item.value,
                        scholarship_id: getScholarshipId[index].value,
                        interval_type: getIntervalType[index].value,
                        cycle_count: getCycleCount[index].value,
                        amount: getAmount[index].value
                    });

                    studentDetails.push(item.value);

                }
            });

            var collectedData = {
                collect_details: setDetails,
                student_details: studentDetails
            };

            $.ajax({
                url: '/student-stipend-adding',
                method: 'GET',
                data: collectedData,
                success: function(response) {
                    if (response.status === 'success') {
                        dataSearch();
                    }
                }
            });
        });

        $(document).on('change', '.interval-cls', function(e) {
            var selectedValue = $(this).val();
            var selectedId = $(this).data('selectid');
            document.querySelector(".cycle-count_" + selectedId).classList.remove('disabled-cls');
            $(".cycle-count_" + selectedId).val('');
            var orginalStipendAmount = $("#orginal_stipend_amount_input_" + selectedId).val();
            $("#maximum_stipend_amount_input_" + selectedId).val(orginalStipendAmount);
            $(".amount_row_" + selectedId).val(orginalStipendAmount);
            if (selectedValue == 'monthly') {
                $(".cycle-count_" + selectedId).attr('max', 12);
            } else {
                $(".cycle-count_" + selectedId).attr('max', '');
            }
        });

        function cycleCountDetails(data) {
            if (parseInt(data.value) < parseInt(data.min)) {
                data.value = '';
            } else if (data.max != '' && parseInt(data.value) > parseInt(data.max)) {
                data.value = '';
            } else if (!Number.isInteger(parseFloat(data.value)) || isNaN(data.value)) {
                data.value = '';
            } else {}
        }

        $(document).on('keyup', '.cycle-count-cls', function(e) {
            var cycleCountId = $(this).data('countid');
            $(".amount_row_" + cycleCountId).val('');
            var orginalStipendAmount = $("#orginal_stipend_amount_input_" + cycleCountId).val();
            var typedValue = $(this).val();

            if (typedValue != '' && !isNaN(typedValue) && typedValue != 0 && typedValue != 1) {
                var getCalculatedValue = orginalStipendAmount / typedValue;
                $("#maximum_stipend_amount_input_" + cycleCountId).val(getCalculatedValue);
                $(".amount_row_" + cycleCountId).val(getCalculatedValue);
            } else {
                $("#maximum_stipend_amount_input_" + cycleCountId).val(orginalStipendAmount);
                $(".amount_row_" + cycleCountId).val(orginalStipendAmount);
            }
        });

        $(document).on('keyup', '.amount-cls', function(e) {
            var amountRowId = $(this).data('amountrowid');
            var maximumStipendAmount = $("#maximum_stipend_amount_input_" + amountRowId).val();
            var amountRowValue = $(this).val();
            var amountRowMinValue = $(this).prop('min');

            if (parseInt(amountRowValue) < parseInt(amountRowMinValue)) {
                $(this).val('');
            } else if (parseInt(amountRowValue) > parseInt(maximumStipendAmount)) {
                $(this).val('');
            } else if (!Number.isInteger(parseFloat(amountRowValue)) || isNaN(amountRowValue)) {
                $(this).val('');
            } else {}
        });
    </script>
@endpush
