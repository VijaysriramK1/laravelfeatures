@extends('frontEnd.home.front_master')
@section('main_content')
@push('css')
<style>

    .primary_input {
        position: relative;
    }
    .success-color{
        color: #79838b;
    }
    .danger-color{
        color: #ff0000;
    }
    .ft {
        font-size: 11px;
        position: absolute;
        bottom: -10px;
        left: 0;
    }
    
        .primary_input_label {
            font-weight: 500;
        }
        /* .primary_input_field {
            margin-bottom: 35px;
        } */
        .mt-25 {
            margin-top: 25px;
        }
        .fix-gr-bg {
            background-color: #28a745;
            color: #fff;
        }
        .tr-bg {
            background-color: #6c757d;
            color: #fff;
        }

        body {
            background-color: #f8f9fa;
        }
        .card {
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top:10%;
        }
        .card-title {
            color: #343a40;
        }
        .form-control, .form-select {
            border-radius: 5px;
            box-shadow: none;
            border-color: #ced4da;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.1rem #7C32FF;
            border-color: #7C32FF;
        }
        #save_button_query {
            /* position:sticky;
            width: 15%; */
            border-radius: 5px;
            background-color: #7C32FF;
            border-color: #7C32FF;
            font-weight: bold;
            margin-left: 2%;
        }
        #cancel_button {
            /* position:sticky;
            width: 15%; */
            border-radius: 5px;
            font-weight: bold;
        }
        .logo {
            top: 15px;
            left: 25px;
            margin-left:44%;
        }
     form{
        margin-top:10%;
     }
     select.form-control {
            appearance: auto; 
            -webkit-appearance: auto;  
        
        }

</style>
@endpush
    <!--================ Home Banner Area =================-->
    <section class="container box-1420">
        <div class="banner-area" style="background: linear-gradient(0deg, rgba(124, 50, 255, 0.6), rgba(199, 56, 216, 0.6)), url({{$contact_info->image != ""? $contact_info->image : '../img/client/common-banner1.jpg'}}) no-repeat center;">

            <div class="banner-inner">
                <div class="banner-content">
                    <h2>{{$contact_info->title}}</h2>
                    <p>{{$contact_info->description}}</p>

                    <a class="primary-btn fix-gr-bg semi-large" href="{{url($contact_info->button_url)}}">{{$contact_info->button_text}}</a>

                </div>
            </div>
        </div>
    </section>
    <!--================ End Home Banner Area =================-->

   <!--================Contact Area =================-->
   @php
    $isContactFormEnabled = App\SmGeneralSettings::pluck('is_contact_form_enabled')->first();
  @endphp

   @if($isContactFormEnabled == 0)
   <section class="contact_area section-gap-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="map mapBox"></div>
                </div>
                <div class="offset-lg-1 col-lg-5">
                    <div class="contact_info">
                        <div class="info_item">
                            <i class="ti-home"></i>
                            <h6>{{$contact_info->address}}</h6>
                            <p>{{$contact_info->address_text}}</p>
                        </div>
                        <div class="info_item">
                            <i class="ti-headphone-alt"></i>
                            <h6><a href="#">{{$contact_info->phone}}</a></h6>
                            <p>{{$contact_info->phone_text}}</p>
                        </div>
                        <div class="info_item">
                            <i class="ti-envelope"></i>
                            <h6>
                                <a href="#">{{$contact_info->email}}</a>
                            </h6>
                            <p>{{$contact_info->email_text}}</p>
                        </div>
                    </div>
                    <section class="container box-1420 mt-30">
                        </section>
                        <div class="col-lg-12">
                            <div class="primary_input">
                                <label class="primary_input_label" for="">@lang('front_settings.Enter_your_name') <span class="text-danger"> *</span></label>
                                <input class="primary_input_field form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    type="text" name="name" id="name" autocomplete="off" value="{{old('name')}}">
                                
                                <span id="nameError" class="text-danger ft"></span>
                            </div>
                            <div class="primary_input mt-30">
                                <label class="primary_input_label" for="">@lang('front_settings.Enter_your_email') <span class="text-danger"> *</span></label>
                                <input oninput="emailCheck(this)" class="primary_input_field form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" autocomplete="off" type="text" id="email" name="email" value="{{old('email')}}">
                                
                                <span id="emailError" class="text-danger ft"></span>
                            </div>
                            <div class="primary_input mt-30">
                                <label class="primary_input_label" for="">@lang('front_settings.enter_subject') <span class="text-danger"> *</span></label>
                                <input class="primary_input_field form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}" autocomplete="off" type="text" id="subject" name="subject" value="{{old('subject')}}">
                                
                                <span id="subjectError" class="text-danger ft"></span>
                            </div>
                            <div class="primary_input mt-30 mb-10">
                                <label class="primary_input_label" for="">@lang('front_settings.enter_message') <span class="text-danger"> *</span></label>
                                <textarea class="primary_input_field form-control" autocomplete="off" name="message" id="message" cols="0" rows="4">{{old('email')}}</textarea>
                                
                                <span id="messageError" class="text-danger ft"></span>
                            </div>
                                <p class=" mt-3 text-success"></p>
                                <p class=" mt-3 text-danger"></p>
                        </div>
                        <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                        <div class="col-md-12 ">
                            <button type="submit" value="submit" id="click_btn" class=" mt-30 primary-btn fix-gr-bg submit">
                               @lang('front_settings.send_message')
                            </button>
                        </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </section>

    @elseif($isContactFormEnabled == 1)


    <section class="contact_area section-gap-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="map mapBox"></div>
                </div>
                <div class="offset-lg-1 col-lg-5">
                <div class="contact_info">
                        <div class="info_item">
                            <i class="ti-home"></i>
                            <h6>{{$contact_info->address}}</h6>
                            <p>{{$contact_info->address_text}}</p>
                        </div>
                        <div class="info_item">
                            <i class="ti-headphone-alt"></i>
                            <h6><a href="#">{{$contact_info->phone}}</a></h6>
                            <p>{{$contact_info->phone_text}}</p>
                        </div>
                        <div class="info_item">
                            <i class="ti-envelope"></i>
                            <h6>
                                <a href="#">{{$contact_info->email}}</a>
                            </h6>
                            <p>{{$contact_info->email_text}}</p>
                        </div>
                    </div>
                   
                <form id="lead-integration-form" method="POST" action="{{route('lead_form.store')}}">
                        @csrf
                       
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="first_name">First Name<span class="text-danger"> *</span></label>
                                    <input class="primary_input_field form-control" type="text" name="first_name" id="first_name" required>
                                    @error('first_name')
                                             <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 mt-25">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="last_name">Last Name<span class="text-danger"> *</span></label>
                                    <input class="primary_input_field form-control" type="text" name="last_name" id="last_name" required>
                                    @error('last_name')
                                     <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 mt-25">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="email">Email<span class="text-danger"> *</span></label>
                                    <input oninput="emailCheck(this)" class="primary_input_field form-control" type="email" name="email" id="email" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 mt-25">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="mobile">Mobile Number<span class="text-danger"> *</span></label>
                                    <input oninput="phoneCheck(this)" class="primary_input_field form-control" type="text" name="mobile" id="mobile" required>
                                    @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                           
                            <div class="col-lg-12 mt-15">
                                <div class="primary_input">
                                    <label class="primary_input_label" for="class">Class<span class="text-danger"> *</span></label>
                                    <select name="class" class="primary_input_field form-control" required>
                                        <option data-display="Class " value="">Class </option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('class')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12 text-center mt-25">
                                <div class="d-flex justify-content-center gap-6 mt-3">
                                    <button type="button" class="btn btn-danger" id="cancel_button" onclick="window.location='{{ url()->previous() }}'">Cancel</button>
                                    <button class="btn btn-primary" id="save_button_query" type="submit">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @else


    <section class="contact_area section-gap-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="map mapBox"></div>
                </div>
                <div class="offset-lg-1 col-lg-5">
                    <div class="contact_info">
                        <div class="info_item">
                            <i class="ti-home"></i>
                            <h6>{{$contact_info->address}}</h6>
                            <p>{{$contact_info->address_text}}</p>
                        </div>
                        <div class="info_item">
                            <i class="ti-headphone-alt"></i>
                            <h6><a href="#">{{$contact_info->phone}}</a></h6>
                            <p>{{$contact_info->phone_text}}</p>
                        </div>
                        <div class="info_item">
                            <i class="ti-envelope"></i>
                            <h6>
                                <a href="#">{{$contact_info->email}}</a>
                            </h6>
                            <p>{{$contact_info->email_text}}</p>
                        </div>
                    </div>
                    <section class="container box-1420 mt-30">
                        </section>
                        <div class="col-lg-12">
                            <div class="primary_input">
                                <input class="primary_input_field form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                    type="text" name="name" id="name" autocomplete="off" value="{{old('name')}}">
                                <label class="primary_input_label" for="">@lang('front_settings.Enter_your_name') <span class="text-danger"> *</span></label>
                                
                                <span id="nameError" class="text-danger ft"></span>
                            </div>
                            <div class="primary_input mt-30">
                                <input oninput="emailCheck(this)" class="primary_input_field form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" autocomplete="off" type="text" id="email" name="email" value="{{old('email')}}">
                                <label class="primary_input_label" for="">@lang('front_settings.Enter_your_email') <span class="text-danger"> *</span></label>
                                
                                <span id="emailError" class="text-danger ft"></span>
                            </div>
                            <div class="primary_input mt-30">
                                <input class="primary_input_field form-control{{ $errors->has('subject') ? ' is-invalid' : '' }}" autocomplete="off" type="text" id="subject" name="subject" value="{{old('subject')}}">
                                <label class="primary_input_label" for="">@lang('front_settings.enter_subject') <span class="text-danger"> *</span></label>
                                
                                <span id="subjectError" class="text-danger ft"></span>
                            </div>
                            <div class="primary_input mt-30 mb-10">
                                <textarea class="primary_input_field form-control" autocomplete="off" name="message" id="message" cols="0" rows="4">{{old('email')}}</textarea>
                                <label class="primary_input_label" for="">@lang('front_settings.enter_message') <span class="text-danger"> *</span></label>
                                
                                <span id="messageError" class="text-danger ft"></span>
                            </div>
                                <p class=" mt-3 text-success"></p>
                                <p class=" mt-3 text-danger"></p>
                        </div>
                        <input type="hidden" name="url" id="url" value="{{URL::to('/')}}">
                        <div class="col-md-12 ">
                            <button type="submit" value="submit" id="click_btn" class=" mt-30 primary-btn fix-gr-bg submit">
                               @lang('front_settings.send_message')
                            </button>
                        </div>
                    {{-- </form> --}}
                </div>
            </div>
        </div>
    </section>



@endif
    <!--================Contact Area =================-->
@endsection
@section('script')
<script src="{{asset('public/backEnd/')}}/vendors/js/gmap3.min.js"></script>
<script>
    $('.map')
      .gmap3({
        center:[<?php echo $contact_info->latitude;?>, <?php echo $contact_info->longitude;?>],
        zoom:<?php echo $contact_info->zoom_level;?>
      })
      .marker([
        {position:[<?php echo $contact_info->latitude;?>, <?php echo $contact_info->longitude;?>]},
        {address:"<?php echo $contact_info->google_map_address;?>"},
        {address:"<?php echo $contact_info->google_map_address;?>", icon: "https://maps.google.com/mapfiles/marker_grey.png"}
      ])
      .on('click', function (marker) {
        marker.setIcon('https://maps.google.com/mapfiles/marker_green.png');
      });

</script>

<script>
        $(document).ready(function(){
            $("#click_btn").click(function(){
                let url = $('#url').val();
                let name = $('#name').val();
                let email = $('#email').val();
                let subject= $('#subject').val();
                let message = $('#message').val();

                $.ajax({
                    url: url + '/' + 'send-message',
                    method : "POST",
                    data : {
                        name : name,
                        email : email,
                        subject : subject,
                        message : message,
                    },
                    success : function (result){
                        if(result.success){
                            $('#name').val('');
                            $('#email').val('');
                            $('#subject').val('');
                            $('#message').val('');
                            $('.primary_input_field').removeClass('has-content');
                            $('.text-success').html('Email Sent Successfully');
                            $('#nameError').html();
                            $('#emailError').html();
                            $('#subjectError').html();
                            $('#messageError').html();
                        }else{
                            $('#name').val('');
                            $('#email').val('');
                            $('#subject').val('');
                            $('#message').val('');
                            $('#nameError').html();
                            $('#emailError').html();
                            $('#subjectError').html();
                            $('#messageError').html();
                            $('.primary_input_field').removeClass('has-content');
                            $('.text-danger').html('Something Went Wrong');
                            $('#nameError').html();
                            $('#emailError').html();
                            $('#subjectError').html();
                            $('#messageError').html();
                        }
                    },
                    error:function (xhr){
                        $('#nameError').html(xhr.responseJSON.errors.name);
                        $('#emailError').html(xhr.responseJSON.errors.email);
                        $('#subjectError').html(xhr.responseJSON.errors.subject);
                        $('#messageError').html(xhr.responseJSON.errors.message);
                    }
                })
            });
        });
</script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.10/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function () {
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>

@endsection
