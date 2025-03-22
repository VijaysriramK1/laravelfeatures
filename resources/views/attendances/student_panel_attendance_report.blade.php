@extends('backEnd.master')
@section('title')
    @lang('student.attendance')
@endsection
@push('css')
    <style>
        #table_part {
            border: 1px solid var(--border_color);

        }

        #table_part th {
            border: 1px solid var(--border_color);
            text-align: center;
        }

        #table_part td {
            border: 1px solid var(--border_color);
            text-align: center;
            flex-wrap: nowrap;
            white-space: nowrap;
            font-size: 11px;
            padding: 20px 10px 20px 10px !important;
        }

        .main-wrapper {
            display: block;
            width: auto;
            align-items: stretch;
        }

        #main-content {
            width: auto;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #828bb2;
            height: 5px;
            border-radius: 0;
        }

        .table-responsive::-webkit-scrollbar {
            width: 5px;
            height: 5px
        }

        .table-responsive::-webkit-scrollbar-track {
            height: 5px !important;
            background: #ddd;
            border-radius: 0;
            box-shadow: inset 0 0 5px grey
        }

        .disabled-cls {
            pointer-events: none;
            opacity: 0.5;
        }

        .display-hide-cls {
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
    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('student.attendance')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="{{ route('student_my_attendance') }}">@lang('student.attendance')</a>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-visitor-area">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row">
                            <div class="col-lg-4 col-md-6">
                                <div class="main-title">
                                    <h3 class="mb-15">@lang('common.select_criteria')</h3>
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-6 text-right">
                                <!-- empty -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mt-30-md">
                                <select class="primary_select form-control" id="select-month">
                                    <option value="" hidden>@lang('student.select_month') *</option>
                                    <option value="01">@lang('student.january')</option>
                                    <option value="02">@lang('student.february')</option>
                                    <option value="03">@lang('student.march')</option>
                                    <option value="04">@lang('student.april')</option>
                                    <option value="05">@lang('student.may')</option>
                                    <option value="06">@lang('student.june')</option>
                                    <option value="07">@lang('student.july')</option>
                                    <option value="08">@lang('student.august')</option>
                                    <option value="09">@lang('student.september')</option>
                                    <option value="10">@lang('student.october')</option>
                                    <option value="11">@lang('student.november')</option>
                                    <option value="12">@lang('student.december')</option>
                                </select>
                            </div>

                            <div class="col-lg-6 mt-30-md">
                                <select class="primary_select form-control" id="select-year">
                                    <option value="" hidden>@lang('student.select_year') *</option>
                                    @if (isset($get_years) && count($get_years) > 0)
                                        @foreach ($get_years as $values)
                                            <option value="{{ $values }}">{{ $values }}</option>
                                        @endforeach
                                    @else
                                        <!-- empty -->
                                    @endif

                                </select>
                            </div>
                            <div class="col-lg-12 mt-20 text-right">
                                <a id="search-btn-id" type="button"
                                    class="search-btn-cls primary-btn small fix-gr-bg disabled-cls">
                                    <span class="ti-search pr-2"></span>
                                    search
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="content-part" class="display-hide-cls">

    </div>

    <div id="reload-part" class="display-hide-cls">
        <section class="student-attendance">
            <div class="container-fluid p-0">
                <div class="row mt-40">
                    <div class="col-lg-12 student-details up_admin_visitor">
                        <div class="white-box">
                            <div class="tab-content mt-15">
                                <div class="d-flex justify-content-center mb-2">
                                    <div class="table-loader"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>




@endsection
@include('backEnd.partials.data_table_js')

@push('script')
    <script>
        $(document).ready(function() {
            var selected_month = $('#select-month').val();
            var selected_year = $('#select-year').val();

            if (selected_month != '' && selected_year != '') {
                document.getElementById('search-btn-id').classList.remove('disabled-cls');
            } else {
                document.getElementById('search-btn-id').classList.add('disabled-cls');
            }
        });

        $('#select-month, #select-year').change(function() {
            var selected_month = $('#select-month').val();
            var selected_year = $('#select-year').val();

            if (selected_month != '' && selected_year != '') {
                document.getElementById('search-btn-id').classList.remove('disabled-cls');
            } else {
                document.getElementById('search-btn-id').classList.add('disabled-cls');
            }
        });

        $(document).on('click', '.search-btn-cls', function() {
            document.getElementById('reload-part').classList.remove('display-hide-cls');
            document.getElementById('content-part').classList.add('display-hide-cls');
            $('#content-part').html('');
            var selected_month = $('#select-month').val();
            var selected_year = $('#select-year').val();
            $.ajax({
                url: '/my-attendance-search?month=' + selected_month + '&year=' + selected_year,
                method: 'GET',
                success: function(response) {
                    $('#content-part').html(response.content);
                },
                complete: function() {
                    document.getElementById('reload-part').classList.add('display-hide-cls');
                    document.getElementById('content-part').classList.remove('display-hide-cls');
                }
            });
        });
    </script>
@endpush
