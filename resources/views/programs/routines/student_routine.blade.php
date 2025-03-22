@extends('backEnd.master')
@section('title')
    @lang('communicate.Routines')
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <style>
        body {
            text-decoration: none !important;
        }

        .tab-btn {
          border-radius: .375rem;
          padding: 10px 20px;
          text-decoration: none;
          display: inline-block;
          color: #7C32FF !important;
          background-color: transparent;
        }
        .tab-btn.active {
          color: white !important;
          background-color: #7C32FF;
        }

        .hidden-part {
          visibility: hidden;
          width: 100%;
        }

        .tab-part {
            display: flex;
            gap: 2em;
            margin: 10px 0;
            overflow-x: auto;
            white-space: nowrap;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .tab-part::-webkit-scrollbar {
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
    <section class="sms-breadcrumb up_breadcrumb">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h1>@lang('communicate.Routines')</h1>
            </div>
            <div class="col-12 col-sm-6 d-flex justify-content-sm-end">
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none">@lang('communicate.Dashboard')</a>
                    <a href="#" class="text-decoration-none">@lang('communicate.My Programs')</a>
                    <a href="#">@lang('communicate.Routines')</a>
                </div>
            </div>
        </div>
    </section>

    <div class="row mt-5">
        <div class="col-12 col-sm-12 col-md-6">
            <span style="font-size: 17px;color:#112375;font-weight:500;">@lang('communicate.My Programs')</span>
        </div>

        <div class="col-12 col-sm-12 col-md-6 mt-3 mt-md-0 d-flex justify-content-md-end">
            <ul class="nav nav-pills" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                  <a class="tab-btn active" id="pills-home-tab" data-bs-toggle="pill" type="button" role="tab" aria-controls="pills-list" aria-selected="true" onclick="viewType('list')">List</a>
                </li>
                <li class="nav-item" role="presentation">
                  <a class="tab-btn" id="pills-profile-tab" data-bs-toggle="pill" type="button" role="tab" aria-controls="pills-calendar" aria-selected="false" onclick="viewType('calendar')">Calendar</a>
                </li>
              </ul>
        </div>
    </div>

    <div id="list-area" style="display: block;">
    <div class="tab-part">
        @if (!empty($get_classwise_sections))
            @foreach ($get_classwise_sections as $get_values)
                <div class="tab-item tabId_{{ $get_values->classname->id }}_{{ $get_values->sectionname->id }}">
                    <a class="text-decoration-none classwisetable active-tab-hover" href="javascript:void(0);"
                        data-classid="{{ $get_values->classname->id }}" data-sectionid="{{ $get_values->sectionname->id }}">
                        <b><span>{{ strtoupper($get_values->classname->class_name) ?? '' }}<span>
                                    <span>(</span>{{ strtoupper($get_values->sectionname->section_name) ?? '' }}<span>)</span>
                        </b></a>
                </div>
            @endforeach
        @else
            <!-- empty -->
        @endif
    </div>


    <div class="card mt-0 p-3">
        <div class="main-title">
            <h3 class="mb-15">@lang('communicate.Progress')</h3>
        </div>

        <div id="global-table-id" class="table-hide-property">
            <div class="tbl-scroll">
                <table id="routines-table" class="display nowrap" style="width:100%;">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>@lang('communicate.saturday')</th>
                            <th>@lang('communicate.sunday')</th>
                            <th>@lang('communicate.monday')</th>
                            <th>@lang('communicate.tuesday')</th>
                            <th>@lang('communicate.wednesday')</th>
                            <th>@lang('communicate.thursday')</th>
                            <th>@lang('communicate.friday')</th>
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
</div>

    <div id="calendar-area" class="hidden-part"></div>
@endsection

@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')

@push('script')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script>

document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar-area');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next', 
                    center: 'title',  
                    right: ''        
                },
                dayHeaders: false,
                events: function(info, successCallback, failureCallback) {
                    fetch('/calendar-view-data')
                        .then(response => response.json())
                        .then(data => {
                            var events = data.map(function(event) {
                                return {
                                    title: 'Class & Section: ' + event.class_section + '<br>' + 'Subject Name: ' + event.title + '<br>' + 'Staff Name: ' + event.staff_name + '<br>' + 'Start Time: ' + event.start_time + '<br>' + 'End Time: ' + event.end_time + '<br>' + 'Schedule Day: ' + event.day + '<br>' + 'Completed Date: ' + event.completed_date,
                                    start: event.start,
                                    end: event.end
                                };
                            });
                            successCallback(events);
                        })
                        .catch(error => {
                            console.error('Error fetching events:', error);
                            failureCallback(error);
                        });
                },
                eventContent: function(arg) {
                    return { html: arg.event.title };
                }
            });

            calendar.render();
        });

        function viewType(type) {
            if (type == 'list') {
                document.getElementById('calendar-area').style.display = 'none';
                document.getElementById('calendar-area').classList.add('hidden-part');
                document.getElementById('list-area').style.display = 'block';
            } else if (type == 'calendar') {
                document.getElementById('list-area').style.display = 'none';
                document.getElementById('calendar-area').style.display = 'block';
                document.getElementById('calendar-area').classList.remove('hidden-part');
            } else {}
        }



        $(document).ready(function() {
            $('#routines-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/selected-class-section-list",
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
                columns: [
                    {
                        data: null,
                        name: 'index',
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { data: 'saturday', name: 'saturday', orderable: false, searchable: false },
                    { data: 'sunday', name: 'sunday', orderable: false, searchable: false },
                    { data: 'monday', name: 'monday', orderable: false, searchable: false },
                    { data: 'tuesday', name: 'tuesday', orderable: false, searchable: false },
                    { data: 'wednesday', name: 'wednesday', orderable: false, searchable: false },
                    { data: 'thursday', name: 'thursday', orderable: false, searchable: false },
                    { data: 'friday', name: 'friday', orderable: false, searchable: false }
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
            var filter_table = $("#routines-table").DataTable();
            $('.tabId_' + classid + '_' + sectionid).find('.classwisetable').addClass('active-tab');
            var url = '/selected-class-section-list?selected_class=' + classid + '&selected_section=' +
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
    </script>
@endpush
