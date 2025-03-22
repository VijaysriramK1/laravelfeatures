@extends('backEnd.master')
@section('title')
    @lang('communicate.my_students')
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <style>
        body {
            text-decoration: none !important;
        }
        #heading-my-students{
            color: #112375 !important;
            font-weight: 650;
            font-size: larger;
        }
        #heading-my-routines{
            color: #112375 !important;
            font-weight: 600;

        }
        .classwisetable{
            font-weight: 300;
            font-size: 14px;
            color: #828BB2 !important; 
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

        .active-tab {
            border-bottom-width: 3px;
            border-bottom-style: solid;
            border-bottom-color: #7C32FF;
            color: #112375 !important;
            font-weight: 300;
            transition: padding-top 0s, border-bottom-width 0s, border-bottom-color 0s !important;
        }

        .active-tab-hover:hover {
            border-bottom-width: 3px;
            border-bottom-style: solid;
            border-bottom-color: #7C32FF;
            color: #112375 !important;
            transition: padding-top 0s, border-bottom-width 0s, border-bottom-color 0s !important;
        }

        .owl-carousel .owl-item {
            padding-left: 20px;
        }
        .owl-item {
            width: auto !important; 
            margin-right: 2px; 
        }
        .table-hide-property {
            display: none;
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
        .owl-stage {
            width: max-content !important;
        }
        a.text-decoration-none.classwisetable.text-dark.active-tab-hover.active-tab {
            color: #112375 !important;
        }
        a.text-dark:focus, a.text-dark:hover {
            color: #112375 !important;
        }
        .student-list-card {
            border-radius: 5px;
            /* box-shadow: 0 4px 8px rgb(0 0 0 / 38%); */
        }

        .student-list-title {
            font-family: 'Arial', sans-serif;
        }

        .student-table {
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .no-data-message {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
    </style>
@endpush
@section('mainContent')
    <section class="sms-breadcrumb mb-3 up_breadcrumb">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h1><b id="heading-my-students">@lang('communicate.my_students')</b></h1>
            </div>

            <div class="col-12 col-sm-6 d-flex justify-content-sm-end">
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}" class="text-decoration-none">@lang('common.dashboard')</a>
                    <a href="#" class="text-decoration-none">@lang('communicate.my_programs')</a>
                    <a href="#">@lang('communicate.my_students')</a>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h1><b id="heading-my-routines">@lang('communicate.my_programs')</b></h1>
        </div>
    </section>

    <div class="mt-4">
        <div class="owl-carousel">
            @foreach ($get_classwise_sections as $get_values)
                <div class="item tabId_{{ $get_values->className->id }}_{{ $get_values->sectionName->id }}">
                    <a class="text-decoration-none classwisetable text-dark active-tab-hover" href="javascript:void(0);"
                        data-classid="{{ $get_values->className->id }}" data-sectionid="{{ $get_values->sectionName->id }}">
                        <b><span>{{ strtoupper($get_values->className->class_name) }}<span>
                                    <span>(</span>{{ strtoupper($get_values->sectionName->section_name) }}<span>)</span>
                        </b></a>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card mt-4 p-3 student-list-card">
    <div class="main-title">
        <h3 class="mb-15 student-list-title"><b>@lang('communicate.students_list')</b></h3>
    </div>

    <div id="global-table-id">
        <table id="my-students-table" class="display student-table">
            <thead>
                <tr>
                    <th><b>@lang('communicate.serial_number')</b></th>
                    <th><b>@lang('communicate.admission_number')</b></th>
                    <th><b>@lang('communicate.student_name')</b></th>
                    <th><b>@lang('communicate.father_name')</b></th>
                    <th><b>@lang('communicate.date_of_birth')</b></th>
                    <th><b>@lang('communicate.class_section')</b></th>
                    <th><b>@lang('communicate.gender')</b></th>
                    <th><b>@lang('communicate.type')</b></th>
                    <th><b>@lang('communicate.mobile_number')</b></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <div id="no-data" class="no-data-message">
            No data available
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {

            $(".owl-carousel").owlCarousel({
                loop: false,
                margin: 2,
                autoplay: false,
                nav: false,
                dots: false,
                responsive: {
                    0: {
                        items: 2
                    },
                    400: {
                        items: 4
                    },
                    500: {
                        items: 6
                    },
                    1000: {
                        items: 8
                    }
                }
            });
        });

        $(document).ready(function() {
            document.querySelector(".table-reload-animation").style.display = "none";
        });

        $(document).ready(function() {
            $('#my-students-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/selected-class-wise-section-list",
                    type: 'GET',
                    beforeSend: function() {
                        document.querySelector(".table-reload-animation").style.display = "block";
                    },
                    complete: function() {
                        document.querySelector(".table-reload-animation").style.display = "none";
                    }
                },
                columns: [{
                        data: null,
                        name: 'index',
                        searchable: false,
                        orderable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
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
                        data: 'father_name',
                        name: 'father_name',
                        orderable: false,
                        searchable: false,
                       
                    },

                    {
                        data: 'dob',
                        name: 'dob',
                        orderable: false,
                        searchable: false,
                        
                    },
                    {
                        data: 'class_section',
                        name: 'class_section',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'gender',
                        name: 'gender',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'type',
                        name: 'type',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        orderable: false,
                        searchable: false
                    },

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
                bLengthChange: false,
                bDestroy: true,
                language: {
                    search: "<i class='ti-search'></i>",
                    searchPlaceholder: window.jsLang('quick_search'),
                    paginate: {
                        next: "<i class='ti-arrow-right'></i>",
                        previous: "<i class='ti-arrow-left'></i>",
                    },
                },
                dom: "Bfrtip",
                buttons: [{
                        extend: "copyHtml5",
                        text: '<i class="fa fa-files-o"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: window.jsLang('copy_table'),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "excelHtml5",
                        text: '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: window.jsLang('export_to_excel'),
                        title: $("#logo_title").val(),
                        margin: [10, 10, 10, 0],
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "csvHtml5",
                        text: '<i class="fa fa-file-text-o"></i>',
                        titleAttr: window.jsLang('export_to_csv'),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "pdfHtml5",
                        text: '<i class="fa fa-file-pdf-o"></i>',
                        title: $("#logo_title").val(),
                        titleAttr: window.jsLang('export_to_pdf'),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                        orientation: "landscape",
                        pageSize: "A4",
                        margin: [0, 0, 0, 12],
                        alignment: "center",
                        header: true,
                        customize: function(doc) {
                            doc.content[1].margin = [100, 0, 100, 0]; //left, top, right, bottom
                            doc.content.splice(1, 0, {
                                margin: [0, 0, 0, 12],
                                alignment: "center",
                                image: "data:image/png;base64," + $("#logo_img").val(),
                            });
                        },
                    },
                    {
                        extend: "print",
                        text: '<i class="fa fa-print"></i>',
                        titleAttr: window.jsLang('print'),
                        title: $("#logo_title").val(),
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },
                    },
                    {
                        extend: "colvis",
                        text: '<i class="fa fa-columns"></i>',
                        postfixButtons: ["colvisRestore"],
                    },
                ],
                columnDefs: [{
                    visible: false,
                }, ],
                info: true,
                pageLength: 10,
                // lengthChange: false,
                // autoWidth: false,
                ordering: false,
                // searching: false,
                responsive: true
            });
        });



        // Function to fetch class-based students

        $(document).ready(function() {
            var gettabclass = $('.classwisetable');
            gettabclass.first().addClass('active-tab');
        });

        $('.classwisetable').on('click', function() {
            $('.classwisetable').each(function() {
                $(this).removeClass('active-tab');
            });
        });

        $(document).ready(function() {
            
            var firstActiveTab = $('.classwisetable.active-tab').first();

            if (firstActiveTab.length) {
               
                var classid = firstActiveTab.data('classid');
                var sectionid = firstActiveTab.data('sectionid');

                ClassBasedStudents(classid,sectionid);
               
            } else {
                console.log('No active tabs found.');
            }
        });

        

        $(document).on('click', '.classwisetable', function(e) {
            document.getElementById('global-table-id').classList.add('table-hide-property');
            document.querySelector(".table-reload-animation").style.display = "block";
            var classid = $(this).data('classid');
            var sectionid = $(this).data('sectionid');
            $('.tabId_' + classid + '_' + sectionid).find('.classwisetable').addClass('active-tab');
           
            ClassBasedStudents(classid,sectionid);
          
        }); 

             
            function ClassBasedStudents(classId, sectionId) {
                
                const url = `/selected-class-wise-section-list?selected_class=${classId}&selected_section=${sectionId}`;
                console.log('url',url);
            
                     $.ajax({
                            url: url,
                            method: 'GET',
                            success: function(response) {
                                
                                if (response.status === 'success') {
                                    const filter_table = $('#my-students-table').DataTable();
                                    filter_table.ajax.url(url).load(function(){
                                        
                                        // setTimeout(() => {
                                            document.getElementById('global-table-id').classList.remove('table-hide-property');
                                            document.querySelector(".table-reload-animation").style.display = "none";
                                        // }, 2500);

                                    });

                                    
                                } else {
                                    console.error('Error fetching data:', response.message);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX Error:', error);
                                document.querySelector(".table-reload-animation").style.display = "none";
                            }
                        });

                 }
         
            // Function to fetch class-based students End
    </script>
@endpush
