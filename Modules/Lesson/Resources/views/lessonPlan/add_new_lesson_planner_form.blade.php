<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <title>Popup Content</title>

    <style>

.disabled-cls {
            pointer-events: none;
            opacity: 0.5;
        }

.display-hide-cls {
            display: none;
        }
        .paddingTop86 {
            padding-top: 88px;
        }

        .mr-bottom {
            margin-bottom: -8px;
        }

        .dloader_img_style {
            width: 40px;
            height: 40px;
        }

        .dloader {
            display: none;
        }

        .pre_dloader {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" name="url" id="url" value="{{ URL::to('/') }}">
                <input type="hidden" name="day" id="day" value="{{ @$day }}">
                <input type="hidden" name="customize" id="customize" value="customize">
                <input type="hidden" name="class_id" id="class_id" value="{{ @$class_id }}">
                <input type="hidden" name="section_id" id="section_id" value="{{ @$section_id }}">
                <input type="hidden" name="subject_id" id="subject_id" value="{{ @$subject_id }}">
                <input type="hidden" name="lesson_date" id="lesson_date" value="{{ $lesson_date }}">
                <input type="hidden" name="routine_id" id="routine_id" value="{{ $routine_id }}">
                <input type="hidden" name="teacher_id" id="update_teacher_id"
                    value="{{ isset($teacher_id) ? $teacher_id : '' }}">

                @if (moduleStatusCheck('University'))
                    <input type="hidden" name="un_session_id" id="un_session_id"
                        value="{{ @$routine->un_session_id }}">
                    <input type="hidden" name="un_faculty_id" id="un_faculty_id"
                        value="{{ @$routine->un_faculty_id }}">
                    <input type="hidden" name="un_department_id" id="un_department_id"
                        value="{{ @$routine->un_department_id }}">
                    <input type="hidden" name="un_academic_id" id="un_academic_id"
                        value="{{ @$routine->un_academic_id }}">
                    <input type="hidden" name="un_semester_id" id="un_semester_id"
                        value="{{ @$routine->un_semester_id }}">
                    <input type="hidden" name="un_semester_label_id" id="un_semester_label_id"
                        value="{{ @$routine->un_semester_label_id }}">
                    <input type="hidden" name="un_subject_id" id="un_subject_id"
                        value="{{ @$routine->un_subject_id }}">
                @endif
                <div class="row mt-25 align-items-center">
                    <div class="col-lg-6">
                        <select
                            class="primary_select niceSelectModal form-control"
                            id="lessonTopic">
                            <option data-display="@lang('lesson::lesson.select_lesson')*" value="">
                                @lang('lesson::lesson.select_lesson') *</option>
                            @foreach ($lessons as $lesson)
                                <option value="{{ @$lesson->id }}">{{ @$lesson->lesson_title }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-lg-6 select_topic_div" id="select_topic_div">
                        <select
                            class="primary_select niceSelectModal form-control select_topic"
                            id="select_topic">
                            <option data-display="@lang('lesson::lesson.select_topic') *" value="">
                                @lang('lesson::lesson.select_topic') *</option>
                        </select>
                        <div class="pull-right loader" id="select_topic_loader"
                            style="margin-top: -30px;padding-right: 21px;">
                            <img src="{{ asset('Modules/Lesson/Resources/assets/images/pre-loader.gif') }}"
                                alt="" style="width: 28px;height:28px;">
                        </div>
                    </div>
                </div>

                <div class="row mt-25 align-items-center">
                   <div class="col-lg-12">
                    <label id="sub_topic_label" class="form-label display-hide-cls"><strong>Select Sub Topics</strong> <span>(Optional)</span></label>
                        <div id="select_sub_topic"></div>
                    </div>

                    <div class="col-lg-12 mt-25">
                        <div class="primary_input">
                            <textarea name="note" id="note" cols="100" rows="2" placeholder="@lang('common.note') (Optional)"
                                class="primary_input_field form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 text-center mt-40">
            <div class="mt-40 d-flex justify-content-between">
            </div>

            <div class="col-lg-12 text-center mt-40">
                <div class="mt-40 d-flex justify-content-center">
                    <button id="closeModalPopup" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="display: none;"></button>
                    <button id="submit-btn-id" class="primary-btn fix-gr-bg submit-cls disabled-cls" type="button">@lang('lesson::lesson.save_information')</button>
            </div>
        </div>
    </div>
    </div>

    <script>
        if ($(".niceSelectModal").length) {
            $(".niceSelectModal").niceSelect();
        }
        
        $('#addRowTopic').on('click', function() {
            var url = $("#url").val();
            var lesson_id = $('#lessonTopic').val();
            console.log(lesson_id);
            if (lesson_id == '') {
                setTimeout(function() {
                    toastr.error('Pleas Select Lesson First', "Error", {
                        timeOut: 5000,
                    });
                }, 500);
                return;
            }
            var formData = {
                class_id: $('#class_id').val(),
                section_id: $('#section_id').val(),
                subject_id: $('#subject_id').val(),
                lesson_id: lesson_id,
            };
            $('#select_lesson_topic_loader').removeClass('dloader').addClass('pre_dloader');
            // console.log(formData);
            $.ajax({
                type: "GET",
                data: formData,
                dataType: "html",
                url: url + '/lesson/' + 'ajaxGetTopicRow',

                success: function(data) {
                    $("#topicRow").append(data);
                    $('.niceSelect').niceSelect('destroy');
                    $(".niceSelect").niceSelect();
                    $('#select_lesson_topic_loader').removeClass('pre_dloader').addClass('dloader');
                },
                error: function(data) {
                    $('#select_lesson_topic_loader').removeClass('pre_dloader').addClass('dloader');
                },
            });


        });

        $('#lessonTopic, #select_topic').change(function() {

           var lesson_id = $('#lessonTopic').val();
           var topic_id = $('#select_topic').val();

            if (lesson_id != '' && topic_id != '') {
                document.getElementById('submit-btn-id').classList.remove('disabled-cls');
            } else {
                document.getElementById('submit-btn-id').classList.add('disabled-cls');
            }

        });

        $('#lessonTopic').on('change', function() {
            var url = $("#url").val();

            var formData = {
                class_id: $('#class_id').val(),
                section_id: $('#section_id').val(),
                subject_id: $('#subject_id').val(),
                lesson_id: $(this).val(),
            };
            // console.log(formData);
            $.ajax({
                type: "GET",
                data: formData,
                dataType: "json",
                url: url + '/lesson/' + 'ajaxSelectTopic',

                beforeSend: function() {
                    $('#select_topic_loader').addClass('pre_loader');
                    $('#select_topic_loader').removeClass('loader');
                },

                complete: function() {
                    $('#select_topic_loader').removeClass('pre_loader');
                    $('#select_topic_loader').addClass('loader');
                },


                success: function(data) {
                    // console.log(data);
                    if (data.length) {
                        $.each(data, function(i, item) {
                            if (item.length) {
                                $("#select_topic").find("option").not(":first").remove();
                                $("#select_topic_div ul").find("li").not(":first").remove();

                                $.each(item, function(i, topic) {
                                    $("#select_topic").append(
                                        $("<option>", {
                                            value: topic.id,
                                            text: topic.topic_title,
                                        })
                                    );

                                    $("#select_topic_div ul").append(
                                        "<li data-value='" +
                                        topic.id +
                                        "' class='option'>" +
                                        topic.topic_title +
                                        "</li>"
                                    );
                                });
                                $('#select_topic_loader').removeClass('pre_loader');
                                $('#select_topic_loader').addClass('loader');
                            } else {
                                $("#select_topic_div .current").html("SELECT topic *");
                                $("#select_topic").find("option").not(":first").remove();
                                $("#select_topic_div ul").find("li").not(":first").remove();
                            }
                        });
                    } else {
                        $("#select_topic_div .current").html("SELECT topic *");
                        $("#select_topic").find("option").not(":first").remove();
                        $("#select_topic_div ul").find("li").not(":first").remove();
                    }

                },
                error: function(data) {
                    // console.log("Error:", data);
                },
            });
        });

        $('#select_topic').on('change', function() {
            $('#select_sub_topic').find('option').not(':first').remove();
            $("#select_sub_topic").html('');
            var selected_topic = $('#select_topic').val();
            $.ajax({
                url: '/lesson-plan-get-sub-topics?topic_id=' + selected_topic,
                method: 'GET',
                success: function(response) {
                    document.getElementById('sub_topic_label').classList.remove('display-hide-cls');
                    response.forEach(function(item) {
                      var content = '<span style="margin-left: 10px !important;">'+ item.sub_topic_title +'</span>'
                      $("#select_sub_topic").append("<div>" + "<input type='checkbox' value='" + item.id + "'>" + content + "</div>");
                    });
                }
            });
        });

        $(document).on("click", '.removeTopiceRowBtn', function(e) {
            $(this).parent().parent().parent().remove();
        });
        var fileInput = document.getElementById("browseFile");
        if (fileInput) {
            fileInput.addEventListener("change", showFileName);

            function showFileName(event) {
                var fileInput = event.srcElement;
                var fileName = fileInput.files[0].name;
                document.getElementById("placeholderInput").placeholder = fileName;
            }
        }
        var fileInp = document.getElementById("browseFil");
        if (fileInp) {
            fileInp.addEventListener("change", showFileName);

            function showFileName(event) {
                var fileInp = event.srcElement;
                var fileName = fileInp.files[0].name;
                document.getElementById("placeholderIn").placeholder = fileName;
            }
        }

        $(document).on('click', '.submit-cls', function(e) { 
            let checkedValues = [];
            var subTopicPart = document.getElementById('select_sub_topic');
            var subTopicCheckBoxes = subTopicPart.querySelectorAll('input[type="checkbox"]');
            subTopicCheckBoxes.forEach(item => {
               if (item.checked) {
                checkedValues.push({
                    sub_topic_id: item.value
                });
                }
            });

           var collectedData = {
                class_id: $('#class_id').val(),
                section_id: $('#section_id').val(),
                subject_id: $('#subject_id').val(),
                lesson_id: $('#lessonTopic').val(),
                topic_id: $('#select_topic').val(),
                routine_id: $('#routine_id').val(),
                teacher_id: $('#update_teacher_id').val(), 
                note: $('#note').val(),
                collect_details: checkedValues
            };

            $.ajax({
                url: '/lesson-plan-adding',
                method: 'GET',
                data: collectedData,
                success: function(response) {
                    $('#closeModalPopup').click();
                    toastr.success(response.message);
                }
            });

         });

    </script>

</body>

</html>
