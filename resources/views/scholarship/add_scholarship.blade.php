@extends('backEnd.master')
@section('title')
@lang('communicate.Add Scholarship')
@endsection
@push('css')
<style>
    .pagination {
        display: flex;
        justify-content: center;
        margin: 20px 0;
    }

    .pagination a,
    .pagination span {
        display: inline-block;
        padding: 8px 16px;
        margin: 0 4px;
        text-decoration: none;
        color: #007bff;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .pagination a:hover,
    .pagination a:focus {
        background-color: #e9ecef;
        border-color: #ddd;
    }

    .pagination .active {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
        pointer-events: none;
    }

    .pagination .disabled {
        color: #6c757d;
        border-color: #ddd;
        pointer-events: none;
        cursor: not-allowed;
    }

    input::placeholder {
        color: #FAFAFA;
        /* Set your preferred color */
    }

    .invalid-feedback {
        display: none;
        /* Hide by default */
        color: red;
        font-size: 0.875em;
    }
</style>
@endpush
@section('mainContent')
<section class="sms-breadcrumb mb-20">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>
                @if(isset($item))
                @lang('communicate.Edit Scholarship')
                @else
                @lang('communicate.Add Scholarship')
                @endif
            </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('communicate.scholarships') </a>
                <a href="#">@if(isset($item))
                    @lang('communicate.Edit Scholarship')
                    @else
                    @lang('communicate.Add Scholarship')
                    @endif</a>
            </div>
        </div>
    </div>
</section>
<section class="admin-visitor-area up_st_admin_visitor">
    <div class="container-fluid p-0">
        @if(isset($item))
        {{ Form::open(['class' => 'form-horizontal needs-validation', 'method' => 'POST', 'route' => ['update-scholarships', $item->id], 'novalidate' => 'true']) }}
        @else
        {{ Form::open(['class' => 'form-horizontal needs-validation', 'method' => 'POST', 'route' => 'adding-scholarships', 'novalidate' => 'true']) }}
        @endif

        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <div class="main-title">
                                <h3 class="mb-15">
                                    @if(isset($item))
                                    @lang('communicate.Edit Scholarship')
                                    @else
                                    @lang('communicate.Add Scholarship')
                                    @endif
                                </h3>
                            </div>
                            <div class="add-visitor">
                                <div class="row">
                                    <div class="col-lg-12 d-flex">
                                        <!-- <div>Add Amount- &nbsp;</div> -->
                                        <div class="d-flex" id="showValue"></div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 mt-15" id="select_un_student_div">
                                        <label class="primary_input_label" for="name">
                                            @lang('communicate.name')
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control @error('name') is-invalid @enderror"
                                            name="name"
                                            id="name"
                                            value="{{isset($item) ? $item->name : old('name')}}"
                                            style="height: 45px;border-color: #dcd6d6"
                                            required>
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-lg-12 mt-15" id="select_un_student_div">
                                        <label class="primary_input_label" for="">@lang('common.description') <span></span> </label>
                                        <textarea class="primary_input_field form-control" cols="0" rows="3" name="description" id="description" style="border-color: #dcd6d6">{{ isset($item) ? $item->description : old('description') }}</textarea>
                                    </div>
                                    <div class="col-lg-12 mt-15" id="select_un_student_div">
                                        <label class="primary_input_label" for="title">
                                            @lang('communicate.Eligibility Criteria')
                                            <span class="text-danger"></span>
                                        </label>
                                        <input type="text" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" name="eligibility_criteria" id="eligibility_criteria" value="{{isset($item) ? $item->eligibility_criteria : old('eligibility_criteria')}}" style="height: 45px;border-color: #dcd6d6">
                                    </div>

                                    <div class="col-lg-12 mt-15" id="select_un_student_div">
                                        <label class="primary_input_label" for="title">
                                            @lang('communicate.Coverage Type')
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="primary_select form-control @error('coverage_type') is-invalid @enderror" name="coverage_type" id="paymentMethodAddFees">
                                            <option data-display="@lang('communicate.Coverage Type')" value="">
                                                @lang('communicate.Coverage Type')
                                            </option>
                                            <option value="Full" {{ isset($item) && $item->coverage_type == 'full' ? 'selected' : '' }}>Full</option>
                                            <option value="Percentage" {{ isset($item) && $item->coverage_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                            <option value="Fixed" {{ isset($item) && $item->coverage_type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                        </select>
                                        @error('coverage_type')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12 mt-15" id="select_un_student_div">
                                        <label class="primary_input_label" for="title">
                                            @lang('communicate.Coverage Value')
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            class="form-control @error('coverage_amount') is-invalid @enderror"
                                            name="coverage_amount"
                                            id="coverage_amount"
                                            style="height: 45px;border-color: #dcd6d6"
                                            value="{{isset($item) ? $item->coverage_amount : old('coverage_amount')}}"
                                            required>
                                        @error('coverage_amount')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-lg-12 mt-15" id="select_un_student_div">
                                        <label class="primary_input_label" for="title">
                                            @lang('communicate.Fees Type')
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select multiple="multiple"
                                            class="multypol_check_select active position-relative form-control @error('applicable_fee_ids') is-invalid @enderror" name="applicable_fee_ids[]" id="applicable_fee_ids" style="border-color: #dcd6d6" required>

                                            @foreach($feestypes as $feestype)
                                            <option value="{{ $feestype->id }}"
                                                @if(isset($item) && in_array($feestype->id, (array) json_decode($item->applicable_fee_ids)))
                                                selected
                                                @endif>
                                                {{ $feestype->name }}
                                            </option>
                                            @endforeach

                                        </select>
                                        @error('applicable_fee_ids')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                @php
                                $tooltip = "";
                                @endphp
                                <input type="hidden" value="{{@$invoiceInfo->id}}" id="newFeesEditId">
                                <div class="row mt-15">
                                    <div class="col-lg-12 text-center">
                                        <button class="primary-btn fix-gr-bg">
                                            <span class="ti-check"></span>
                                            @if (isset($item))
                                            @lang('common.update')
                                            @else
                                            @lang('common.save')

                                            @endif
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="white-box">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="main-title">
                                <h3 class="mb-30">
                                    @if(isset($item))
                                    @lang('communicate.Edit Scholarship')
                                    @else
                                    @lang('communicate.Add Scholarship')
                                    @endif
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-15">
                        <div class="col-lg-12">
                            <div class="pb-0 fees_invoice_type_div">
                                <div class="row">
                                    <div class="col-lg-12">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="weaverType" value="amount">
                            <div class="big-table">
                                <table class="table school-table-style fees_invoice_type_table" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>@lang('communicate.#ID')</th>
                                            <th>@lang('communicate.name')</th>
                                            <th>Description</th>
                                            <th>@lang('communicate.Eligibility Criteria')</th>
                                            <th>@lang('communicate.Coverage Type')</th>
                                            <th>@lang('communicate.Coverage Value')</th>
                                            <th> @lang('communicate.Fees Type')</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($scholarships as $key => $item)
                                        <tr>
                                            <td>{{$key + 1}}</td>
                                            <td>{{$item->name}}</td>
                                            <td>
                                                @php
                                                echo wordwrap($item->description, 10, "\n", true);
                                                @endphp
                                            </td>
                                            <td>{{$item->eligibility_criteria}}</td>
                                            <td>{{$item->coverage_type}}</td>
                                            <td>{{$item->coverage_amount}}</td>
                                          
                                            <td>
                                                @if ($item->applicable_fee_ids)
                                                @php
                                                // Decode the applicable_fee_ids to get an array of IDs
                                                $feeIds = is_array(json_decode($item->applicable_fee_ids))
                                                ? json_decode($item->applicable_fee_ids)
                                                : [];
                                                @endphp
                                                {{-- Join applicable fees with a comma separator --}}
                                                {{ implode(', ', array_map(function($feeId) use ($applicable_fee_ids) {
                                                    return $applicable_fee_ids[$feeId] ?? '';
                                                }, $feeIds)) }}
                                                @else
                                                <span>No applicable fees</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('edit-scholarships', ['id' => $item->id]) }}"> <i class="fas fa-edit fa-xs" style="font-size: 12px;"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#deleteFeesPayment" data-id="{{ $item->id }}" style="background-color: transparent;"><i class="fas fa-trash fa-xs" style="font-size: 12px;color:blue"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination">
                                    {{ $scholarships->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        @include('backEnd.partials.data_table_js')
        {{ Form::close() }}
    </div>
    <!-- Delete maodel start -->
    <div class="modal fade admin-query" id="deleteFeesPayment">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Admission Fees</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="text-center">
                        <h4>@lang('common.are_you_sure_to_delete')</h4>
                    </div>
                    <div class="mt-40 d-flex justify-content-between">
                        <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('common.cancel')</button>
                        @if(isset($item))
                        <a href="{{ route('delete-scholarships', ['id' => $item->id]) }}"> <button class="primary-btn fix-gr-bg" type="submit">
                                @lang('common.delete')</button></a>
                        @else
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delete model end -->

</section>

@endsection
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')
@push('script')
<script type="text/javascript" src="{{ asset('public/backEnd/multiselect/js/jquery.multiselect.js') }}"></script>
<script>
    document.getElementById('coverage_amount').addEventListener('input', function(e) {
        const input = e.target;
        const currentValue = input.value;
        if (/[^0-9.]/.test(currentValue)) {
            input.value = currentValue.replace(/[^0-9.]/g, '');
            toastr.error('Only numbers are allowed in the Amount field');
        }
    });
</script>
<script>
    $(function() {
        $("select[multiple].active.multypol_check_select").multiselect({
            columns: 1,
            placeholder: "Select Fees Types",
            search: true,
            searchOptions: {
                default: "Select"
            },
            selectAll: true,
        });
    });


    $(document).ready(function() {
        $('#paymentMethodAddFees').on('change', function() {
            var coverageType = $(this).val();

            if (coverageType === 'Full') {
                $('#coverage_amount').val('').prop('disabled', true);
            } else {
                $('#coverage_amount').prop('disabled', false);
            }
        }).trigger('change');
    });
</script>

@endpush