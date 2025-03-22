@extends('backEnd.master')

@section('title')
    @lang('Lead Integration')
@endsection

@section('mainContent')

<section class="sms-breadcrumb mb-20 up_breadcrumb">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('Lead Integration')</h1>
            <div class="bc-pages">
                <a href="{{ route('dashboard') }}">@lang('common.dashboard')</a>
                <a href="#">@lang('admin.admin_section')</a>
                <a href="#">@lang('Lead Integration')</a>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-title">
                <!-- <h3>@lang('Lead Integration')</h3> -->
            </div>
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                   <a href="{{route('lead_integration')}}"> <button class="nav-link" id="nav-general-tab" data-bs-toggle="tab" data-bs-target="#nav-general" type="button" role="tab" aria-controls="nav-general" aria-selected="true"><b>General</b></button></a>
                   <a href="{{route('lead_integration_code-index')}}"> <button class="nav-link active" id="nav-integration-code-tab" data-bs-toggle="tab" data-bs-target="#nav-integration-code" type="button" role="tab" aria-controls="nav-integration-code" aria-selected="false"><b>Integration Code</b></button></a>
                   <a href="{{route('source-index')}}"><button class="nav-link" id="nav-Sources-tab" data-bs-toggle="tab" data-bs-target="#nav-Sources" type="button" role="tab" aria-controls="nav-Sources" aria-selected="false"><b>Sources</b></button></a>
                   <a href="{{route('status-index')}}">  <button class="nav-link" id="nav-Status-tab" data-bs-toggle="tab" data-bs-target="#nav-Status" type="button" role="tab" aria-controls="nav-Status" aria-selected="false"><b>Status</b></button></a>
                </div>
            </nav><br>
          
            <!-- Integration Code Tab Content -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row justify-content-center">
                                            @php
                                                $isContactFormEnabled = App\SmGeneralSettings::pluck('is_contact_form_enabled')->first();
                                            @endphp

                                            <div class="col-lg-8">
                                                    <div class="form-group">
                                                        <label for="toggleSwitch" class="primary_input_label">
                                                            <b>Enable/Disable Form Display On Contact Page</b>
                                                        </label>
                                                        <label class="switch">
                                                            <input type="checkbox" id="toggleSwitch" onchange="toggleForm(this)"
                                                                {{ $isContactFormEnabled === 1 ? 'checked' : '' }}>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-8">
                                                    <div class="primary_input">
                                                        <label class="primary_input_label" for="iframe_preview"><b>Copy & Paste the code anywhere in your site to show the form also you can adjust the width and height to fit your website.</b></label>
                                                        <textarea class="primary_input_field read-only-input form-control" id="iframe_preview" style="color: currentColor;" readonly><iframe id="iframe" src="{{ get_lead_integration_url() }}" style="width: 100%; height: 400px; border: 1px solid #ddd;"></iframe></textarea>
                                                        <button type="button" class="primary-btn fix-gr-bg mt-2 float-right" onclick="copyIframeToClipboard()">Copy Link</button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8 mt-25">
                                                    <div class="primary_input">
                                                        <label class="primary_input_label" for="share_link"><b>Share Link With Anyone</b></label>
                                                        <input class="primary_input_field read-only-input form-control" type="text" id="share_link" style="color: currentColor;" value="{{ get_lead_integration_url() }}" readonly>
                                                        <button type="button" class="primary-btn fix-gr-bg mt-2 float-right" onclick="copylinkToClipboard()">Copy Link</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
           </div>
       </div>
@endsection

@include('backEnd.partials.date_picker_css_js')
@include('backEnd.partials.data_table_js')
@include('backEnd.partials.server_side_datatable')
@section('script')
<script>
    function toggleForm(element) {
       
        var get_status = element.checked;
        $.ajax({
            url: '/lead-form-button',  
            type: 'GET',
            data: {
               
                status : get_status,
            },
            
            success: function(response) {
              
                if (get_status) {
                toastr.success(
                    "Form Enabled Successfully",
                    {
                        iconClass: "customer-info",
                    },
                    {
                        timeOut: 1500,
                    }
                );
            } else {
                toastr.success(
                    "Form Disabled Successfully",
                    {
                        iconClass: "customer-info",
                    },
                    {
                        timeOut: 1500,
                    }
                );
            }

            console.log('Toggle status updated:', response);
        },
            error: function(xhr) {
            
                toastr.error(
                    "Error updating toggle status",
                    {
                        iconClass: "customer-error",
                    }, {
                        timeOut: 1500,
                    }
                );
            }
        });
    }
</script>
   
<script>

function copylinkToClipboard() {
var copyLink = document.getElementById("share_link");
var copyIframe = document.getElementById("iframe_preview");
copyLink.select();
copyLink.setSelectionRange(0, 99999);
document.execCommand("copy");

toastr.success(
    "Link Copied ", 
    {
      iconClass: "customer-info",
    }, {
        timeOut: 1500,
        }
);

}
function copyIframeToClipboard() {

var copyIframe = document.getElementById("iframe_preview");
copyIframe.select();
copyIframe.setSelectionRange(0, 99999);
document.execCommand("copy");


toastr.success(
    "IFrame Copied ",
    {
      iconClass: "customer-info",
    }, {
        timeOut: 1500,
        }
);
}

</script>



<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    .switch::after {
        display:none;
    }
    input:checked + .slider {
        background-color: #7c32ff;
    }

    input:checked + .slider:before {
        transform: translateX(26px);
    }

    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
 

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

@endsection





