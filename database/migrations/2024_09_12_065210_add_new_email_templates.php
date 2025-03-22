<?php

use App\SmsTemplate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        $set_template_1 = [
            'type' => 'email',
            'purpose' => 'subject_unlock_request',
            'subject' => 'Subject Unlock Request',
            'body' => '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container"
    style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;"
    width="100%">
    <tbody>
        <tr style="vertical-align:top;" valign="top">
            <td style="vertical-align:top;" valign="top">
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div
                            style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">

                                <div align="center" class="img-container center fixedwidth"
                                        style="padding-right:30px;padding-left:30px;">
                                        <a href="#">
                                            <img border="0" class="center fixedwidth" src=""
                                                style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;"
                                                width="150" alt="logo.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center autowidth"
                                        style="padding-right:20px;padding-left:20px;">
                                        <img border="0" class="center autowidth"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU"
                                            style="text-decoration:none;height:auto;border:0;max-width:541px;"
                                            width="541"
                                            alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                        <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div style="line-height:1.8;padding:20px 15px;">
                                        <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                            <h1>Dear Admin,</h1>
                                            <p
                                                style="margin:10px 0px 10px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                I hope this message finds you well.</p>

                                            <p
                                                style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                I am writing to request the unlock of a specific competency unit in the
                                                system. Below are the details of the request:</p>


                                            <p
                                                style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                <strong>Subject:</strong> <span>[competency_unit]</span><br>
                                                <strong>Request Sender:</strong> <span>[staff_name]</span>
                                            </p></br>

                                            Best regards,<br>
                                            <span style="color:rgb(113,128,150);">[staff_name]</span><br>
                                            <span style="color:rgb(113,128,150);">[staff_position]</span><br>
                                            <span style="color:rgb(113,128,150);">[staff_contact_no]</span><br>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div
                                        style="color:#262b30;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                        <div class="txtTinyMce-wrapper"
                                            style="line-height:1.2;font-size:12px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;color:#262b30;">
                                            <p
                                                style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;">
                                                <span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">
                                                    © 2024 School Education software|
                                                </span>
                                                <span style="background-color:transparent;text-align:left;">
                                                    <font color="#ffffff">
                                                        Copyright &copy; 2020 All rights reserved | This application is
                                                        made by Codethemes
                                                    </font>
                                                </span>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>',
            'module' => '',
            'variable' => '[competency_unit], [staff_name], [staff_position], [staff_contact_no]',
            'status' => 1
        ];

        $set_template_2 = [
            'type' => 'email',
            'purpose' => 'subject_lock_request',
            'subject' => 'Subject Lock Request',
            'body' => '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container"
    style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;"
    width="100%">
    <tbody>
        <tr style="vertical-align:top;" valign="top">
            <td style="vertical-align:top;" valign="top">
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div
                            style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">

                                    <div align="center" class="img-container center fixedwidth"
                                        style="padding-right:30px;padding-left:30px;">
                                        <a href="#">
                                            <img border="0" class="center fixedwidth" src=""
                                                style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;"
                                                width="150" alt="logo.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center autowidth"
                                        style="padding-right:20px;padding-left:20px;">
                                        <img border="0" class="center autowidth"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU"
                                            style="text-decoration:none;height:auto;border:0;max-width:541px;"
                                            width="541"
                                            alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                        <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div style="line-height:1.8;padding:20px 15px;">
                                        <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                            <h1>Dear Admin,</h1>
                                            <p
                                                style="margin:10px 0px 10px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                I hope this message finds you well.</p>

                                            <p
                                                style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                I am writing to request the locking of the Competency Unit as detailed
                                                below:</p>


                                            <p
                                                style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                <strong>Subject:</strong> <span>[competency_unit]</span><br>
                                                <strong>Request Sender:</strong> <span>[staff_name]</span>
                                            </p>

                                            Best regards,<br>
                                            <span style="color:rgb(113,128,150);">[staff_name]</span><br>
                                            <span style="color:rgb(113,128,150);">[staff_position]</span><br>
                                            <span style="color:rgb(113,128,150);">[staff_contact_no]</span><br>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div
                                        style="color:#262b30;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                        <div class="txtTinyMce-wrapper"
                                            style="line-height:1.2;font-size:12px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;color:#262b30;">
                                            <p
                                                style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;">
                                                <span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">
                                                    © 2024 School Education software|
                                                </span>
                                                <span style="background-color:transparent;text-align:left;">
                                                    <font color="#ffffff">
                                                        Copyright &copy; 2020 All rights reserved | This application is
                                                        made by Codethemes
                                                    </font>
                                                </span>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>',
            'module' => '',
            'variable' => '[competency_unit], [staff_name], [staff_position], [staff_contact_no]',
            'status' => 1
        ];

        $set_template_3 = [
            'type' => 'email',
            'purpose' => 'subject_unlock_request_rejected',
            'subject' => 'Subject Unlock Request Rejected',
            'body' => '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container"
    style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;"
    width="100%">
    <tbody>
        <tr style="vertical-align:top;" valign="top">
            <td style="vertical-align:top;" valign="top">
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div
                            style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center fixedwidth"
                                        style="padding-right:30px;padding-left:30px;">
                                        <a href="#">
                                            <img border="0" class="center fixedwidth" src=""
                                                style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;"
                                                width="150" alt="logo.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center autowidth"
                                        style="padding-right:20px;padding-left:20px;">
                                        <img border="0" class="center autowidth"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU"
                                            style="text-decoration:none;height:auto;border:0;max-width:541px;"
                                            width="541"
                                            alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                        <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div style="line-height:1.8;padding:20px 15px;">
                                        <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                            <h1>Dear [staff_name],</h1>
                                            <p
                                                style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                I hope this message finds you well.
                                            </p>
                                            <p
                                                style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                I am writing to inform you that request to subject unlock
                                                [competency_unit] has been rejected by the admin.
                                            </p>
                                            <p style="line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                If you have any questions or need further assistance, please do not hesitate to reach out.
                                            </p>
                                            <p style="text-align:left;margin:0px;line-height:1.8;">
                                                <br>
                                            </p>
                                            </br>
                                            Best regards,<br>[school_name]
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div
                                        style="color:#262b30;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                        <div class="txtTinyMce-wrapper"
                                            style="line-height:1.2;font-size:12px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;color:#262b30;">
                                            <p
                                                style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;">
                                                <span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">
                                                    © 2024 School Education software|
                                                </span>
                                                <span style="background-color:transparent;text-align:left;">
                                                    <font color="#ffffff">
                                                        Copyright &copy; 2020 All rights reserved | This application is
                                                        made by Codethemes
                                                    </font>
                                                </span>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>',
            'module' => '',
            'variable' => '[staff_name], [competency_unit], [school_name]',
            'status' => 1
        ];


        $set_template_4 = [
            'type' => 'email',
            'purpose' => 'subject_lock_request_rejected',
            'subject' => 'Subject Lock Request Rejected',
            'body' => '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container"
    style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;"
    width="100%">
    <tbody>
        <tr style="vertical-align:top;" valign="top">
            <td style="vertical-align:top;" valign="top">
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div
                            style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center fixedwidth"
                                        style="padding-right:30px;padding-left:30px;">
                                        <a href="#">
                                            <img border="0" class="center fixedwidth" src=""
                                                style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;"
                                                width="150" alt="logo.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center autowidth"
                                        style="padding-right:20px;padding-left:20px;">
                                        <img border="0" class="center autowidth"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU"
                                            style="text-decoration:none;height:auto;border:0;max-width:541px;"
                                            width="541"
                                            alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                        <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div style="line-height:1.8;padding:20px 15px;">
                                        <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                            <h1>Dear [staff_name],</h1>
                                            <p
                                                style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                I hope this message finds you well.
                                            </p>
                                            <p
                                                style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                I am writing to inform you that request to subject lock
                                                [competency_unit] has been rejected by the admin.
                                            </p>
                                            <p style="line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                If you have any questions or need further assistance, please do not hesitate to reach out.
                                            </p>
                                            <p style="text-align:left;margin:0px;line-height:1.8;">
                                                <br>
                                            </p>
                                            </br>
                                            Best regards,<br>[school_name]
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div
                                        style="color:#262b30;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                        <div class="txtTinyMce-wrapper"
                                            style="line-height:1.2;font-size:12px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;color:#262b30;">
                                            <p
                                                style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;">
                                                <span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">
                                                    © 2024 School Education software|
                                                </span>
                                                <span style="background-color:transparent;text-align:left;">
                                                    <font color="#ffffff">
                                                        Copyright &copy; 2020 All rights reserved | This application is
                                                        made by Codethemes
                                                    </font>
                                                </span>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>',
            'module' => '',
            'variable' => '[staff_name], [competency_unit], [school_name]',
            'status' => 1
        ];


        $set_template_5 = [
            'type' => 'email',
            'purpose' => 'subject_unlocked',
            'subject' => 'Subject Unlocked',
            'body' => '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container"
    style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;"
    width="100%">
    <tbody>
        <tr style="vertical-align:top;" valign="top">
            <td style="vertical-align:top;" valign="top">
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div
                            style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">

                                    <div align="center" class="img-container center fixedwidth"
                                        style="padding-right:30px;padding-left:30px;">
                                        <a href="#">
                                            <img border="0" class="center fixedwidth" src=""
                                                style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;"
                                                width="150" alt="logo.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center autowidth"
                                        style="padding-right:20px;padding-left:20px;">
                                        <img border="0" class="center autowidth"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU"
                                            style="text-decoration:none;height:auto;border:0;max-width:541px;"
                                            width="541"
                                            alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                        <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div style="line-height:1.8;padding:20px 15px;">
                                        <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                            <h1>Dear [staff_name],</h1>
                                            <p
                                                style="margin:10px 0px 10px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                I hope this message finds you well.</p>

                                            <p style="color:rgb(113,128,150);">
                                                We wanted to inform you that the status of the subject has been updated
                                                by the admin. Below are the details of the change:</p>


                                            <p style="color:rgb(113,128,150);">
                                                <strong>Subject:</strong> <span>[competency_unit]</span><br>
                                                <strong>Status:</strong> <span>[subject_status]</span>
                                            </p>

                                            <p style="color:rgb(113,128,150);">If you have any questions or need further
                                                assistance, please do not
                                                hesitate to reach out.</p><br>

                                            Best regards,<br>[school_name]

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div
                                        style="color:#262b30;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                        <div class="txtTinyMce-wrapper"
                                            style="line-height:1.2;font-size:12px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;color:#262b30;">
                                            <p
                                                style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;">
                                                <span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">
                                                    © 2024 School Education software|
                                                </span>
                                                <span style="background-color:transparent;text-align:left;">
                                                    <font color="#ffffff">
                                                        Copyright &copy; 2020 All rights reserved | This application is
                                                        made by Codethemes
                                                    </font>
                                                </span>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>',
            'module' => '',
            'variable' => '[staff_name], [competency_unit], [subject_status], [school_name]',
            'status' => 1
        ];


        $set_template_6 = [
            'type' => 'email',
            'purpose' => 'subject_lock',
            'subject' => 'Subject Lock',
            'body' => '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container"
    style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;"
    width="100%">
    <tbody>
        <tr style="vertical-align:top;" valign="top">
            <td style="vertical-align:top;" valign="top">
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div
                            style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">

                                    <div align="center" class="img-container center fixedwidth"
                                        style="padding-right:30px;padding-left:30px;">
                                        <a href="#">
                                            <img border="0" class="center fixedwidth" src=""
                                                style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;"
                                                width="150" alt="logo.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center autowidth"
                                        style="padding-right:20px;padding-left:20px;">
                                        <img border="0" class="center autowidth"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU"
                                            style="text-decoration:none;height:auto;border:0;max-width:541px;"
                                            width="541"
                                            alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                        <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div style="line-height:1.8;padding:20px 15px;">
                                        <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                            <h1>Dear [staff_name],</h1>
                                            <p
                                                style="margin:10px 0px 10px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                I hope this message finds you well.</p>

                                            <p style="color:rgb(113,128,150);">
                                                We wanted to inform you that the status of the subject has been updated
                                                by the admin. Below are the details of the change:</p>


                                            <p style="color:rgb(113,128,150);">
                                                <strong>Subject:</strong> <span>[competency_unit]</span><br>
                                                <strong>Status:</strong> <span>[subject_status]</span>
                                            </p>

                                            <p style="color:rgb(113,128,150);">If you have any questions or need further
                                                assistance, please do not
                                                hesitate to reach out.</p><br>

                                            Best regards,<br>[school_name]

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div
                                        style="color:#262b30;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                        <div class="txtTinyMce-wrapper"
                                            style="line-height:1.2;font-size:12px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;color:#262b30;">
                                            <p
                                                style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;">
                                                <span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">
                                                    © 2024 School Education software|
                                                </span>
                                                <span style="background-color:transparent;text-align:left;">
                                                    <font color="#ffffff">
                                                        Copyright &copy; 2020 All rights reserved | This application is
                                                        made by Codethemes
                                                    </font>
                                                </span>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>',
            'module' => '',
            'variable' => '[staff_name], [competency_unit], [subject_status], [school_name]',
            'status' => 1
        ];

        $set_template_7 = [
            'type' => 'email',
            'purpose' => 'mark_unlock_request',
            'subject' => 'Mark Unlock Request',
            'body' => '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container"
    style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;"
    width="100%">
    <tbody>
        <tr style="vertical-align:top;" valign="top">
            <td style="vertical-align:top;" valign="top">
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div
                            style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center fixedwidth"
                                        style="padding-right:30px;padding-left:30px;">
                                        <a href="#">
                                            <img border="0" class="center fixedwidth" src=""
                                                style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;"
                                                width="150" alt="logo.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center autowidth"
                                        style="padding-right:20px;padding-left:20px;">
                                        <img border="0" class="center autowidth"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU"
                                            style="text-decoration:none;height:auto;border:0;max-width:541px;"
                                            width="541"
                                            alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                        <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div style="line-height:1.8;padding:20px 15px;">
                                        <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                            <h1>Dear Admin,</h1>
                                            <p style="color:rgb(113,128,150);">
                                                I hope this message finds you well.
                                            </p>
                                            <p style="color:rgb(113,128,150);">
                                                I am writing to request the unlocking of a specific competency unit
                                                mark. Here are the details for your reference:
                                            </p>

                                            <p
                                                style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                <strong>Subject:</strong> <span>[competency_unit]</span><br>
                                                <strong>Request Sender:</strong> <span>[staff_name]</span><br>
                                                <strong>Request Note:</strong> <span>[request_note]</span>
                                            </p>
                                            <p style="line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                Thank you for your assistance.
                                            </p><br>

                                            Best regards,<br>

                                            <span style="color:rgb(113,128,150);">[staff_name]</span><br>
                                            <span style="color:rgb(113,128,150);">[staff_position]</span><br>
                                            <span style="color:rgb(113,128,150);">[staff_contact_no]</span><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div
                                        style="color:#262b30;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                        <div class="txtTinyMce-wrapper"
                                            style="line-height:1.2;font-size:12px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;color:#262b30;">
                                            <p
                                                style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;">
                                                <span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">
                                                    © 2024 School Education software|
                                                </span>
                                                <span style="background-color:transparent;text-align:left;">
                                                    <font color="#ffffff">
                                                        Copyright &copy; 2020 All rights reserved | This application is
                                                        made by Codethemes
                                                    </font>
                                                </span>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>',
            'module' => '',
            'variable' => '[competency_unit], [staff_name], [request_note], [staff_position], [staff_contact_no]',
            'status' => 1
        ];

        $set_template_8 = [
            'type' => 'email',
            'purpose' => 'mark_lock_request',
            'subject' => 'Mark Lock Request',
            'body' => '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container"
    style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;"
    width="100%">
    <tbody>
        <tr style="vertical-align:top;" valign="top">
            <td style="vertical-align:top;" valign="top">
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div
                            style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center fixedwidth"
                                        style="padding-right:30px;padding-left:30px;">
                                        <a href="#">
                                            <img border="0" class="center fixedwidth" src=""
                                                style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;"
                                                width="150" alt="logo.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center autowidth"
                                        style="padding-right:20px;padding-left:20px;">
                                        <img border="0" class="center autowidth"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU"
                                            style="text-decoration:none;height:auto;border:0;max-width:541px;"
                                            width="541"
                                            alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                        <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div style="line-height:1.8;padding:20px 15px;">
                                        <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                            <h1>Dear Admin,</h1>
                                            <p style="color:rgb(113,128,150);">
                                                I hope this message finds you well.
                                            </p>
                                            <p style="color:rgb(113,128,150);">
                                                I am writing to request the locking of the competency unit mark as
                                                detailed below:
                                            </p>

                                            <p
                                                style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                <strong>Subject:</strong> <span>[competency_unit]</span><br>
                                                <strong>Request Sender:</strong> <span>[staff_name]</span><br>
                                                <strong>Request Note:</strong> <span>[request_note]</span>
                                            </p>


                                            Best regards,<br>
                                            <span style="color:rgb(113,128,150);">[staff_name]</span><br>
                                            <span style="color:rgb(113,128,150);">[staff_position]</span><br>
                                            <span style="color:rgb(113,128,150);">[staff_contact_no]</span><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div
                                        style="color:#262b30;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                        <div class="txtTinyMce-wrapper"
                                            style="line-height:1.2;font-size:12px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;color:#262b30;">
                                            <p
                                                style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;">
                                                <span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">
                                                    © 2024 School Education software|
                                                </span>
                                                <span style="background-color:transparent;text-align:left;">
                                                    <font color="#ffffff">
                                                        Copyright &copy; 2020 All rights reserved | This application is
                                                        made by Codethemes
                                                    </font>
                                                </span>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>',
            'module' => '',
            'variable' => '[competency_unit], [staff_name], [request_note], [staff_position], [staff_contact_no]',
            'status' => 1
        ];

        $set_template_9 = [
            'type' => 'email',
            'purpose' => 'mark_rejected_notification',
            'subject' => 'Mark Rejected Notification',
            'body' => '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container"
    style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;"
    width="100%">
    <tbody>
        <tr style="vertical-align:top;" valign="top">
            <td style="vertical-align:top;" valign="top">
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div
                            style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center fixedwidth"
                                        style="padding-right:30px;padding-left:30px;">
                                        <a href="#">
                                            <img border="0" class="center fixedwidth" src=""
                                                style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;"
                                                width="150" alt="logo.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center autowidth"
                                        style="padding-right:20px;padding-left:20px;">
                                        <img border="0" class="center autowidth"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU"
                                            style="text-decoration:none;height:auto;border:0;max-width:541px;"
                                            width="541"
                                            alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                        <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div style="line-height:1.8;padding:20px 15px;">
                                        <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                            <h1>Dear [staff_name],</h1>
                                            <p
                                                style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                I hope this message finds you well.
                                            </p>
                                            <p
                                                style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                I am writing to inform you that request to the subject mark
                                                [competency_unit] has been rejected by the admin.
                                            </p>
                                            <p style="line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                If you have any questions or need further assistance, please do not
                                                hesitate to reach out.
                                            </p>
                                            <p style="text-align:left;margin:0px;line-height:1.8;">
                                                <br>
                                            </p>
                                            </br>
                                            Best regards,<br>[school_name]
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div
                                        style="color:#262b30;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                        <div class="txtTinyMce-wrapper"
                                            style="line-height:1.2;font-size:12px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;color:#262b30;">
                                            <p
                                                style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;">
                                                <span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">
                                                    © 2024 School Education software|
                                                </span>
                                                <span style="background-color:transparent;text-align:left;">
                                                    <font color="#ffffff">
                                                        Copyright &copy; 2020 All rights reserved | This application is
                                                        made by Codethemes
                                                    </font>
                                                </span>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>',
            'module' => '',
            'variable' => '[staff_name], [competency_unit], [school_name]',
            'status' => 1
        ];


        $set_template_10 = [
            'type' => 'email',
            'purpose' => 'mark_unlocked',
            'subject' => 'Mark Unlocked',
            'body' => '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container"
    style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;"
    width="100%">
    <tbody>
        <tr style="vertical-align:top;" valign="top">
            <td style="vertical-align:top;" valign="top">
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div
                            style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">

                                    <div align="center" class="img-container center fixedwidth"
                                        style="padding-right:30px;padding-left:30px;">
                                        <a href="#">
                                            <img border="0" class="center fixedwidth" src=""
                                                style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;"
                                                width="150" alt="logo.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center autowidth"
                                        style="padding-right:20px;padding-left:20px;">
                                        <img border="0" class="center autowidth"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU"
                                            style="text-decoration:none;height:auto;border:0;max-width:541px;"
                                            width="541"
                                            alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                        <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div style="line-height:1.8;padding:20px 15px;">
                                        <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                            <h1>Dear [staff_name],</h1>
                                            <p
                                                style="margin:10px 0px 10px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                I hope this message finds you well.</p>

                                            <p style="color:rgb(113,128,150);">
                                                We wanted to inform you that the status of the subject mark has been
                                                updated
                                                by the admin. Below are the details of the change:</p>


                                            <p style="color:rgb(113,128,150);">
                                                <strong>Subject:</strong> <span>[competency_unit]</span><br>
                                                <strong>Status:</strong> <span>[subject_mark_status]</span>
                                            </p>

                                            <p style="color:rgb(113,128,150);">If you have any questions or need further
                                                assistance, please do not
                                                hesitate to reach out.</p><br>

                                            Best regards,<br>[school_name]

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div
                                        style="color:#262b30;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                        <div class="txtTinyMce-wrapper"
                                            style="line-height:1.2;font-size:12px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;color:#262b30;">
                                            <p
                                                style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;">
                                                <span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">
                                                    © 2024 School Education software|
                                                </span>
                                                <span style="background-color:transparent;text-align:left;">
                                                    <font color="#ffffff">
                                                        Copyright &copy; 2020 All rights reserved | This application is
                                                        made by Codethemes
                                                    </font>
                                                </span>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>',
            'module' => '',
            'variable' => '[staff_name], [competency_unit], [subject_mark_status], [school_name]',
            'status' => 1
        ];


        $set_template_11 = [
            'type' => 'email',
            'purpose' => 'mark_lock',
            'subject' => 'Mark Lock',
            'body' => '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container"
    style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;"
    width="100%">
    <tbody>
        <tr style="vertical-align:top;" valign="top">
            <td style="vertical-align:top;" valign="top">
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div
                            style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">

                                    <div align="center" class="img-container center fixedwidth"
                                        style="padding-right:30px;padding-left:30px;">
                                        <a href="#">
                                            <img border="0" class="center fixedwidth" src=""
                                                style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;"
                                                width="150" alt="logo.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center autowidth"
                                        style="padding-right:20px;padding-left:20px;">
                                        <img border="0" class="center autowidth"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU"
                                            style="text-decoration:none;height:auto;border:0;max-width:541px;"
                                            width="541"
                                            alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                        <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div style="line-height:1.8;padding:20px 15px;">
                                        <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                            <h1>Dear [staff_name],</h1>
                                            <p
                                                style="margin:10px 0px 10px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                I hope this message finds you well.</p>

                                            <p style="color:rgb(113,128,150);">
                                                We wanted to inform you that the status of the subject mark has been
                                                updated by the admin. Below are the details of the change:</p>


                                            <p style="color:rgb(113,128,150);">
                                                <strong>Subject:</strong> <span>[competency_unit]</span><br>
                                                <strong>Status:</strong> <span>[subject_mark_status]</span>
                                            </p>

                                            <p style="color:rgb(113,128,150);">If you have any questions or need further
                                                assistance, please do not
                                                hesitate to reach out.</p><br>

                                            Best regards,<br>[school_name]

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div
                                        style="color:#262b30;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                        <div class="txtTinyMce-wrapper"
                                            style="line-height:1.2;font-size:12px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;color:#262b30;">
                                            <p
                                                style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;">
                                                <span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">
                                                    © 2024 School Education software|
                                                </span>
                                                <span style="background-color:transparent;text-align:left;">
                                                    <font color="#ffffff">
                                                        Copyright &copy; 2020 All rights reserved | This application is
                                                        made by Codethemes
                                                    </font>
                                                </span>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>',
            'module' => '',
            'variable' => '[staff_name], [competency_unit], [subject_mark_status], [school_name]',
            'status' => 1
        ];

        $set_template_12 = [
            'type' => 'email',
            'purpose' => 'student_assigned_scholarship',
            'subject' => 'Student Assigned Scholarship',
            'body' => '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container"
    style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;"
    width="100%">
    <tbody>
        <tr style="vertical-align:top;" valign="top">
            <td style="vertical-align:top;" valign="top">
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div
                            style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">

                                    <div align="center" class="img-container center fixedwidth"
                                        style="padding-right:30px;padding-left:30px;">
                                        <a href="#">
                                            <img border="0" class="center fixedwidth" src=""
                                                style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;"
                                                width="150" alt="logo.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center autowidth"
                                        style="padding-right:20px;padding-left:20px;">
                                        <img border="0" class="center autowidth"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU"
                                            style="text-decoration:none;height:auto;border:0;max-width:541px;"
                                            width="541"
                                            alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                        <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div style="line-height:1.8;padding:20px 15px;">
                                        <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                            <h1>Dear Admin,</h1>
                                            <p
                                                style="margin:10px 0px 10px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                New student assigned scholarship.</p>
                                                
                                            <p style="color:rgb(113,128,150);">
                                                <strong>Student Name:</strong> <span>[student_name]</span><br>
                                                <strong>Assigned Scholarship:</strong> <span>[assigned_scholarship]</span>
                                            </p><br>

                                            Best regards,<br>[school_name]

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div
                                        style="color:#262b30;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                        <div class="txtTinyMce-wrapper"
                                            style="line-height:1.2;font-size:12px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;color:#262b30;">
                                            <p
                                                style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;">
                                                <span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">
                                                    © 2024 School Education software|
                                                </span>
                                                <span style="background-color:transparent;text-align:left;">
                                                    <font color="#ffffff">
                                                        Copyright &copy; 2020 All rights reserved | This application is
                                                        made by Codethemes
                                                    </font>
                                                </span>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>',
            'module' => '',
            'variable' => '[student_name], [assigned_scholarship], [school_name]',
            'status' => 1
        ];



        $set_template_13 = [
            'type' => 'email',
            'purpose' => 'stipend_credited_your_account',
            'subject' => 'Stipend Credited Your Account',
            'body' => '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container"
    style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;"
    width="100%">
    <tbody>
        <tr style="vertical-align:top;" valign="top">
            <td style="vertical-align:top;" valign="top">
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div
                            style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">

                                    <div align="center" class="img-container center fixedwidth"
                                        style="padding-right:30px;padding-left:30px;">
                                        <a href="#">
                                            <img border="0" class="center fixedwidth" src=""
                                                style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;"
                                                width="150" alt="logo.png">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#415094;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div align="center" class="img-container center autowidth"
                                        style="padding-right:20px;padding-left:20px;">
                                        <img border="0" class="center autowidth"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU"
                                            style="text-decoration:none;height:auto;border:0;max-width:541px;"
                                            width="541"
                                            alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                        <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div style="line-height:1.8;padding:20px 15px;">
                                        <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                            <h1>Dear [student_name],</h1>
                                            <p
                                                style="margin:10px 0px 10px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                I hope this message finds you well.</p>

                                            <p style="color:rgb(113,128,150);">
                                            We are pleased to inform you that your stipend has been successfully credited to your account. Please check your account balance to confirm the transaction.
                                            </p>


                                            <p style="color:rgb(113,128,150);">
                                                <strong>Stipend Amount:</strong> <span>[stipend_amount]</span>
                                            </p>

                                            <p style="color:rgb(113,128,150);">If you have any questions or need further
                                                assistance, please do not
                                                hesitate to reach out.</p><br>

                                            Best regards,<br>[school_name]

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="background-color:#7c32ff;">
                    <div class="block-grid"
                        style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                        <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                            <div class="col num12"
                                style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                <div class="col_cont" style="width:100%;">
                                    <div
                                        style="color:#262b30;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                        <div class="txtTinyMce-wrapper"
                                            style="line-height:1.2;font-size:12px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;color:#262b30;">
                                            <p
                                                style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;">
                                                <span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">
                                                    © 2024 School Education software|
                                                </span>
                                                <span style="background-color:transparent;text-align:left;">
                                                    <font color="#ffffff">
                                                        Copyright &copy; 2020 All rights reserved | This application is
                                                        made by Codethemes
                                                    </font>
                                                </span>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>',
            'module' => '',
            'variable' => '[student_name], [stipend_amount], [school_name]',
            'status' => 1
        ];

        $get_all_templates = [$set_template_1, $set_template_2, $set_template_3, $set_template_4, $set_template_5, $set_template_6, $set_template_7, $set_template_8, $set_template_9, $set_template_10, $set_template_11, $set_template_12, $set_template_13];

        foreach ($get_all_templates as $val) {

            $add_templates = new SmsTemplate();

            $add_templates->type = $val['type'];
            $add_templates->purpose = $val['purpose'];
            $add_templates->subject = $val['subject'];
            $add_templates->body = $val['body'];
            $add_templates->module = $val['module'];
            $add_templates->variable = $val['variable'];
            $add_templates->status = $val['status'];
            $add_templates->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        SmsTemplate::whereIn('purpose', ['subject_unlock_request', 'subject_lock_request', 'subject_unlock_request_rejected', 'subject_lock_request_rejected', 'subject_unlocked', 'subject_lock', 'mark_unlock_request', 'mark_lock_request', 'mark_rejected_notification', 'mark_unlocked', 'mark_lock'])->delete();
    }
};
