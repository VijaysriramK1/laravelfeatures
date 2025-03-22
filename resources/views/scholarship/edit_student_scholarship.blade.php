
<style>
        .select2-selectall-container {
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 1;
            cursor: pointer;
            padding: 5px;
            border-bottom: 1px solid #eee;
        }
        .select2-selectall-container label {
            cursor: pointer;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .select2-container {
            width: 100% !important;
        }
        button.close.icons {
            display: none ;
        }
        .text-danger {
            color: #e3342f !important;
            font-size: small;
        }
        .select2-container--default .select2-selection--multiple {
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }
        .select2-container .select2-search--inline .select2-search__field {
            color: #828bb2 !important;
            font-size: 13px !important;
            padding: 5px !important;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }
        select#edit_select_class {
            color: #828bb2 !important;
            font-size: 13px !important;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }
        select#edit_select_section {
            color: #828bb2 !important;
            font-size: 13px !important;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }
        select#edit_select_group {
            color: #828bb2 !important;
            font-size: 13px !important;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }
        select#edit_select_students {
            color: #828bb2 !important;
            font-size: 13px !important;
            border: 1px solid rgba(130, 139, 178, 0.3) !important;
        }
        .form-control {
            height: calc(2.6em + .75rem + 2px) !important;
        }
    </style>
   
{{ Form::open(['class' => 'form-horizontal', 'files' => true, 'route' => 'update-student-scholarship', 'method' => 'POST', 'enctype' => 'multipart/form-data']) }}
            <div class="modal-body">
                <div class="container-fluid">
               
                        <div class="row justify-content-center">
                            <input type="hidden" name="assigned_student_scholarship_id" value="{{$scholarshipStudents->id}} ">
                            <div class="col-lg-12">
                                <div class="row">

                                <div class="col-lg-4">
                                            <label class="primary_input_label" for="">
                                                {{ __('common.class') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <select
                                                class="primary_select form-control {{ $errors->has('class') ? ' is-invalid' : '' }}"
                                                id="edit_select_class" name="class_id" style="pointer-events: none; background-color: #e9ecef !important;" readonly>
                                                <option data-display="@lang('common.select_class') *" value="">
                                                    @lang('common.select_class') *
                                                </option>
                                              
                                                    <option value="{{ @$classes->id }}"selected>
                                                        {{ @$classes->class_name }}
                                                    </option>
                                               
                                            </select>
                                            @if ($errors->has('class'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('class') }}
                                                </span>
                                            @endif

                                        </div>
                               

                               

                                        <div class="col-lg-4" id="select_section_div">
                                            <label class="primary_input_label" for="">
                                                {{ __('common.section') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <select
                                                class="primary_select form-control{{ $errors->has('section') ? ' is-invalid' : '' }}"
                                                id="edit_select_section" name="section_id" style="pointer-events: none; background-color: #e9ecef !important;" readonly>
                                                <option data-display="@lang('common.select_section') *" value="" >
                                                    @lang('common.select_section') *
                                                </option>

                                                <option value="{{ @$sections->id }}"selected>
                                                        {{ @$sections->section_name }}
                                                    </option>

                                            </select>
                                            <div class="pull-right loader" id="select_section_loader"
                                                style="margin-top: -30px;padding-right: 21px;">
                                                <img src="{{ asset('Modules/Lesson/Resources/assets/images/pre-loader.gif') }}"
                                                    alt="" style="width: 28px;height:28px;">
                                            </div>
                                            @if ($errors->has('section'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('section') }}
                                                </span>
                                            @endif

                                        </div>


                                        <div class="col-lg-4" id="select_section_div">
                                            <label class="primary_input_label" for="">
                                                {{ __('common.group') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <select
                                                class="primary_select form-control{{ $errors->has('section') ? ' is-invalid' : '' }}"
                                                id="edit_select_group" name="group_id" style="pointer-events: none; background-color: #e9ecef !important;" readonly>
                                                <option data-display="@lang('common.select_group') *" value="" >
                                                    @lang('common.select_group') *
                                                </option>

                                                <option value="{{ @$groups->id }}"selected>
                                                        {{ @$groups->group }}
                                                    </option>

                                            </select>
                                            <div class="pull-right loader" id="select_section_loader"
                                                style="margin-top: -30px;padding-right: 21px;">
                                                <img src="{{ asset('Modules/Lesson/Resources/assets/images/pre-loader.gif') }}"
                                                    alt="" style="width: 28px;height:28px;">
                                            </div>
                                            @if ($errors->has('section'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('section') }}
                                                </span>
                                            @endif

                                        </div>



                            <div class="col-lg-4 mt-25" id="select_section_div">
                                            <label class="primary_input_label" for="">
                                                {{ __('communicate.student') }}
                                                <span class="text-danger"> *</span>
                                            </label>
                                            <select
                                                class="primary_select form-control{{ $errors->has('section') ? ' is-invalid' : '' }}"
                                                id="edit_select_students" name="student_id" style="pointer-events: none; background-color: #e9ecef !important;" readonly>
                                                <option data-display="@lang('communicate.student') *" value="" >
                                                    @lang('communicate.student') *
                                                </option>

                                                <option value="{{ @$students->id }}"selected>
                                                        {{ @$students->full_name }}
                                                    </option>
                                            </select>
                                            <div class="pull-right loader" id="select_section_loader"
                                                style="margin-top: -30px;padding-right: 21px;">
                                                <img src="{{ asset('Modules/Lesson/Resources/assets/images/pre-loader.gif') }}"
                                                    alt="" style="width: 28px;height:28px;">
                                            </div>
                                            @if ($errors->has('section'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('section') }}
                                                </span>
                                            @endif

                                        </div>


                        


                                    <div class="col-lg-4  mt-25">
                                            <label class="primary_input_label" for="">@lang('communicate.scholarships') <span class="text-danger"> *</span></label>
                                            <select class="primary_select" name="scholarship_id" id="scholarship">
                                                <option data-display="@lang('communicate.scholarships') *" value="">
                                                    @lang('communicate.scholarships') *
                                                </option>
                                                @foreach ($scholarships as $scholarship) 
                                                    <option value="{{ $scholarship->id }}" 
                                                        {{ $scholarshipStudents->scholarship_id == $scholarship->id ? 'selected' : '' }}>
                                                        {{ $scholarship->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('scholarship_id'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('scholarship_id') }}
                                                </span>
                                            @endif
                                            <span class="text-danger" id="scholarshipError"></span>
                                        </div>

                                        <div class="col-lg-4 mt-25">
                                            <label class="primary_input_label" for="">@lang('communicate.scholarship_fees_amount') <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field read-only-input form-control" type="number" name="scholarship_fees_amount" id="edit_scholarship_fees_amount" value="{{$scholarshipStudents->scholarship_fees_amount ?? ''}}">
                                            @if($errors->has('scholarship_fees_amount'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('scholarship_fees_amount') }}
                                                </span>
                                            @endif
                                            <span class="text-danger" id="edit_assignedError"></span>
                                        </div>         
                                       
                                </div>
                            </div>

                            <div class="col-lg-12 mt-25">
                                <div class="row">
                                <div class="col-lg-4 mt-25">
                                            <label class="primary_input_label" for="">@lang('communicate.amount') <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field read-only-input form-control" type="number" name="amount" id="edit_amount" value="{{$scholarshipStudents->amount ?? ''}}" >
                                            @if($errors->has('amount'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('amount') }}
                                                </span>
                                            @endif
                                            <span class="text-danger" id="edit_assignedError"></span>
                                        </div>                                                                                                  
                                       
                                <div class="col-lg-4 mt-25">
                                            <label class="primary_input_label" for="">@lang('communicate.stipend_amount') <span class="text-danger"> *</span></label>
                                            <input class="primary_input_field read-only-input form-control" type="number" name="stipend_amount" id="edit_stipend_amount" value="{{$scholarshipStudents->stipend_amount ?? ''}}">
                                            @if($errors->has('stipend_amount'))
                                                <span class="text-danger invalid-select" role="alert">
                                                    {{ $errors->first('stipend_amount') }}
                                                </span>
                                            @endif
                                            <span class="text-danger" id="edit_assignedError"></span>
                                        </div>
                                        
                                    <div class="col-lg-4 mt-25">
                                        <label class="primary_input_label" for="">@lang('communicate.date') </label>
                                        <div class="primary_datepicker_input">
                                            <div class="no-gutters input-right-icon">
                                                <div class="col">
                                                    <input class="primary_input_field date form-control" id="startDate" type="text" name="awarded_date" style="pointer-events: none; background-color: #e9ecef !important;" readonly="true" value="{{ isset($scholarshipStudents->awarded_date) ? \Carbon\Carbon::parse($scholarshipStudents->awarded_date)->format('m/d/Y') : date('m/d/Y') }}" required>
                                                </div>
                                                <button class="btn-date" data-id="#date_from" type="button">
                                                    <label class="m-0 p-0" for="startDate">
                                                        <i class="ti-calendar" id="start-date-icon"></i>
                                                    </label>
                                                </button>
                                            </div>
                                        </div>
                                        <span class="text-danger" id="dateError"></span>
                                    </div>


                                </div>
                            </div>


                            


                            <div class="col-lg-12 text-center mt-25">
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="primary-btn tr-bg" data-dismiss="modal">@lang('admin.cancel')</button>
                                    <button class="primary-btn fix-gr-bg submit" id="edit_save_button_query" type="submit">@lang('admin.save')</button>
                                </div>
                            </div>
                        </div>
          
                </div>
            </div>
            {{ Form::close() }}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    
    $(document).ready(function () {
        
        const EditScholarshipFeesAmount = document.getElementById('edit_scholarship_fees_amount');
        const EditAmount = document.getElementById('edit_amount');
        const EditStipendAmount = document.getElementById('edit_stipend_amount');
        const EditAssignedError = document.getElementById('edit_assignedError');
        const EditsaveButton = document.getElementById("edit_save_button_query");
       

        function EditValidateAmounts() {
            const EditScholarshipAmount = parseFloat(EditScholarshipFeesAmount.value) || 0;
            const EditAmt = parseFloat(EditAmount.value) || 0;
            const EditStipendAmt = parseFloat(EditStipendAmount.value) || 0;
           
            if (EditAmt + EditStipendAmt > EditScholarshipAmount) {
                EditAssignedError.textContent = 'The sum of Amount and Stipend Amount should not exceed Scholarship Fees Amount.';
                EditsaveButton.disabled = true;
                EditsaveButton.style.cursor = 'not-allowed';
                return false;
            } else {
                EditAssignedError.textContent = '';
                EditsaveButton.disabled = false;
                EditsaveButton.style.cursor = 'pointer'; 
                return true;
            }
        }

        EditScholarshipFeesAmount.addEventListener('input', EditValidateAmounts);
        EditAmount.addEventListener('input', EditValidateAmounts);
        EditStipendAmount.addEventListener('input', EditValidateAmounts);
    });

</script>



