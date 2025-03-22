@extends('backEnd.master')
@section('title')
    @lang('lesson::lesson.topic_overview')
@endsection

@push('css')
    <style>
        @media (max-width: 767px) {
            .dataTables_filter label {
                top: -25px !important;
                width: 50%;
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


    <section class="sms-breadcrumb mb-20">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h1>@lang('lesson::lesson.topic_overview')</h1>
                <div class="bc-pages">
                    <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                    <a href="#">@lang('lesson::lesson.lesson')</a>
                    <a href="#">@lang('lesson::lesson.topic_overview')</a>
                </div>
            </div>
        </div>
    </section>
    <section class="admin-visitor-area">
        <div class="container-fluid p-0">

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    {{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'search-topic-overview', 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'search_lesson_Plan']) }}
                    <div class="row">
                        <input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">
                        @include('backEnd.common.class_section_subject', [
                            'div' => 'col-lg-4',
                            'visiable' => ['class', 'section', 'subject'],
                        ])
                        <div class="col-lg-12 mt-20 text-right">
                            <button type="submit" class="primary-btn small fix-gr-bg">
                                <span class="ti-search pr-2"></span>
                                @lang('common.search')
                            </button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        @if (isset($topics_detail))
            <div class="row mt-40">
                <div class="col-lg-12">
                    <div class="white-box">
                        <div class="row mt-40">
                            <div class="col-lg-4 no-gutters">
                                <div class="main-title" style="padding-left: 15px;">

                                </div>
                            </div>
                        </div>
                        <div class="">
                            <x-table>
                                <table id="table_id" class="table school-table-style" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('lesson::lesson.lesson')</th>
                                            <th>@lang('lesson::lesson.topic')</th>
                                            <th>@lang('lesson::lesson.sub_topic')</th>
                                            <th>@lang('lesson::lesson.completed_date') </th>
                                            <th>@lang('lesson::lesson.teacher') </th>
                                            <th>@lang('common.status')</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($topics_detail as $data)
                                            <tr>
                                                <td>{{ $data->lesson_title != '' ? $data->lesson_title->lesson_title : '' }}
                                                </td>
                                                <td> {{ @$data->topic_title != '' ? @$data->topic_title : '' }}</td>
                                                <td>
                                                    @if ($data->lessonPlan && count($data->lessonPlan) > 0)
                                                        @foreach ($data->lessonPlan as $status)
                                                            {{ $status->sub_topic_title }}<br>
                                                        @endforeach
                                                    @else
                                                        {{ '--' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($data->lessonPlan && count($data->lessonPlan) > 0)
                                                        @foreach ($data->lessonPlan as $status)
                                                            @if ($status->competed_date != null && $status->completed_status == 1)
                                                                {{ $status->competed_date }}<br>
                                                            @else
                                                                {{ 'Not completed' }}<br>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        {{ $data->competed_date ?? 'Not completed' }}
                                                    @endif
                                                </td>

                                                <td>
                                                    @php
                                                        $teacherName = 'No teacher assigned';
                                                        $user = Auth::user();
                                                        if ($user && $user->role_id != 4) {
                                                            if (
                                                                $data->lesson_title &&
                                                                $data->lesson_title->subject &&
                                                                $data->lesson_title->subject->assignedSubject &&
                                                                $data->lesson_title->subject->assignedSubject->teacher
                                                            ) {
                                                                $teacherName =
                                                                    $data->lesson_title->subject->assignedSubject
                                                                        ->teacher->full_name;
                                                            }
                                                        } else {
                                                            $teacherName = $user->full_name ?? '';
                                                        }
                                                    @endphp
                                                    <p>{{ $teacherName }}</p>
                                                </td>

                                                <td>
                                                    @if ($data->lessonPlan && count($data->lessonPlan) > 0)
                                                        @foreach ($data->lessonPlan as $status)
                                                            @if ($status->competed_date != null && $status->completed_status == 1)
                                                                <strong class="gradient-color2">@lang('lesson::lesson.completed')</strong>
                                                                <br>
                                                            @else
                                                                <span class="gradient-color">@lang('lesson::lesson.incomplete')</span><br>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @if ($data->competed_date != null && $data->completed_status == 1)
                                                            <strong class="gradient-color2">@lang('lesson::lesson.completed')</strong> <br>
                                                        @else
                                                            <span class="gradient-color">@lang('lesson::lesson.incomplete')</span><br>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </x-table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        </div>
        </div>
    </section>

@endsection
@include('backEnd.partials.data_table_js')
