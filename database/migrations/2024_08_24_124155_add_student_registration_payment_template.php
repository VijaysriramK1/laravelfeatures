<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\SmSchool;
use App\SmsTemplate;

class AddStudentRegistrationPaymentTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $student_registration_template = [
            'email',
            'student_registration_payments',
            'Welcome to SG Academy',
            '<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" class="nl-container" style="table-layout:fixed;vertical-align:top;min-width:320px;border-spacing:0;border-collapse:collapse;background-color:#FFFFFF;width:100%;" width="100%">
                <tbody>
                    <tr style="vertical-align:top;" valign="top">
                        <td style="vertical-align:top;" valign="top">
                            <div style="background-color:#415094;">
                                <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                                    <div style="border-collapse:collapse;width:100%;background-color:transparent;background-position:center top;background-repeat:no-repeat;">
                                        <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                            <div class="col_cont" style="width:100%;">
                                                <div align="center" class="img-container center fixedwidth" style="padding-right:30px;padding-left:30px;">
                                                    <a href="#">
                                                        <img border="0" class="center fixedwidth" src="" style="padding-top:30px;padding-bottom:30px;text-decoration:none;height:auto;border:0;max-width:150px;" width="150" alt="logo.png">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="background-color:#415094;">
                                <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;padding-top:25px;border-top-right-radius:30px;border-top-left-radius:30px;">
                                    <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                                        <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                            <div class="col_cont" style="width:100%;">
                                                <div align="center" class="img-container center autowidth" style="padding-right:20px;padding-left:20px;">
                                                    <img border="0" class="center autowidth" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU" style="text-decoration:none;height:auto;border:0;max-width:541px;" width="541" alt="images?q=tbn:ANd9GcRGF00Oi-zJNU_EvYGueBVz_sqXmFjk8pxNtg&amp;usqp=CAU">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="background-color:#7c32ff;">
                                <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:#ffffff;border-bottom-right-radius:30px;border-bottom-left-radius:30px;overflow:hidden;">
                                    <div style="border-collapse:collapse;width:100%;background-color:#ffffff;">
                                        <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                            <div class="col_cont" style="width:100%;">
                                                <h1 style="line-height:120%;text-align:center;margin-bottom:0px;">
                                                    <font color="#555555" face="Arial, Helvetica Neue, Helvetica, sans-serif">
                                                        <span style="font-size:36px;">Welcome to SG Academy!</span>
                                                    </font>
                                                </h1>
                                                <div style="line-height:1.8;padding:20px 15px;">
                                                    <div class="txtTinyMce-wrapper" style="line-height:1.8;">
                                                        <h1>Dear [student_name],</h1>
                                                        <p style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                            We\'re excited to welcome you aboard! Get ready to access your student portal.
                                                        </p>
                                                        <p style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                            <strong>Amount:</strong> <span>[amount]</span><br>
                                                            <strong>Fine:</strong> <span>[fine]</span><br>
                                                            <strong>Payment Status:</strong> <span>[status]</span>
                                                        </p>
                                                        <p style="margin:10px 0px 30px;line-height:1.929;font-size:16px;color:rgb(113,128,150);">
                                                            If you have any questions or need assistance, please don\'t hesitate to contact us at [school_email].
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
                                <div class="block-grid" style="min-width:320px;max-width:600px;margin:0 auto;background-color:transparent;">
                                    <div style="border-collapse:collapse;width:100%;background-color:transparent;">
                                        <div class="col num12" style="min-width:320px;max-width:600px;vertical-align:top;width:600px;">
                                            <div class="col_cont" style="width:100%;">
                                                <div style="color:#262b30;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:5px;padding-bottom:5px;padding-left:5px;">
                                                    <div class="txtTinyMce-wrapper" style="line-height:1.2;font-size:12px;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;color:#262b30;">
                                                        <p style="margin:0;font-size:12px;line-height:1.2;text-align:center;margin-top:0;margin-bottom:0;">
                                                            <span style="font-size:14px;color:rgb(255,255,255);font-family:Arial;">
                                                                © 2024 School Education software| 
                                                            </span>
                                                            <span style="background-color:transparent;text-align:left;">
                                                                <font color="#ffffff">
                                                                    Copyright &copy; 2020 All rights reserved | This application is made by Codethemes
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
            '',
            '[student_name], [amount], [fine], [status], [school_email], [school_name]'
        ];

        $s = new SmsTemplate();
        $s->type = $student_registration_template[0];
        $s->purpose = $student_registration_template[1];
        $s->subject = $student_registration_template[2];
        $s->body = $student_registration_template[3];
        $s->module = $student_registration_template[4];
        $s->variable = $student_registration_template[5];
        $s->status = 1;
        $s->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        SmsTemplate::where('purpose', 'student_registration_payments')->delete();
    }
}
