<?php

use App\SmaModuleManager;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\Log;

class CreateSmaModuleManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sma_module_managers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 200)->nullable();
            $table->string('email', 200)->nullable();
            $table->string('notes', 255)->nullable();
            $table->string('version', 200)->nullable();
            $table->string('update_url', 200)->nullable();
            $table->string('purchase_code', 200)->nullable();
            $table->string('checksum', 200)->nullable();
            $table->string('installed_domain', 200)->nullable();
            $table->boolean('is_default')->default(0);
            $table->string('addon_url')->nullable();
            $table->date('activated_date')->nullable();
            $table->integer('lang_type')->nullable();
            $table->timestamps();
        });

        try {
            // RolePermission
            $dataPath = 'Modules/RolePermission/RolePermission.json';
            $name = 'RolePermission';
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);

            $version = $array[$name]['versions'][0];
            $url = $array[$name]['url'][0];
            $notes = $array[$name]['notes'][0];

            $s = new SmaModuleManager();
            $s->name = $name;
            $s->email = 'support@example.com';
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->is_default = 1;
            $s->purchase_code = time();
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            //MenuManage

            $dataPath = 'Modules/MenuManage/MenuManage.json';
            $name = 'MenuManage';
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);

            $version = $array[$name]['versions'][0];
            $url = $array[$name]['url'][0];
            $notes = $array[$name]['notes'][0];

            $s = new SmaModuleManager();
            $s->name = $name;
            $s->is_default = 1;
            $s->email = 'support@example.com';
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->purchase_code = time();
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();


            //BulkPrint

            $dataPath = 'Modules/BulkPrint/BulkPrint.json';
            $name = 'BulkPrint';
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);

            $version = $array[$name]['versions'][0];
            $url = $array[$name]['url'][0];
            $notes = $array[$name]['notes'][0];

            $s = new SmaModuleManager();
            $s->name = $name;
            $s->is_default = 1;
            $s->email = 'support@example.com';
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->purchase_code = time();
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();


            // Lesson Planner
            $dataPath = 'Modules/Lesson/Lesson.json';
            $name = 'Lesson';
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);

            $version = $array[$name]['versions'][0];
            $url = $array[$name]['url'][0];
            $notes = $array[$name]['notes'][0];

            $s = new SmaModuleManager();
            $s->name = $name;
            $s->email = 'support@example.com';
            $s->notes = $notes;
            $s->is_default = 1;
            $s->version = $version;
            $s->update_url = $url;
            $s->purchase_code = time();
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();


            // Chat
            $dataPath = 'Modules/Chat/Chat.json';
            $name = 'Chat';
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);

            $version = $array[$name]['versions'][0];
            $url = $array[$name]['url'][0];
            $notes = $array[$name]['notes'][0];

            $s = new SmaModuleManager();
            $s->name = $name;
            $s->email = 'support@example.com';
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->is_default = 1;
            $s->purchase_code = time();
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();


            // TemplateSettings
            $dataPath = 'Modules/TemplateSettings/TemplateSettings.json';
            $name = 'TemplateSettings';
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);

            $version = $array[$name]['versions'][0];
            $url = $array[$name]['url'][0];
            $notes = $array[$name]['notes'][0];

            $s = new SmaModuleManager();
            $s->name = $name;
            $s->email = 'support@example.com';
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->is_default = 1;
            $s->purchase_code = time();
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            // StudentAbsentNotification
            $dataPath = 'Modules/StudentAbsentNotification/StudentAbsentNotification.json';
            $name = 'StudentAbsentNotification';
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);

            $version = $array[$name]['versions'][0];
            $url = $array[$name]['url'][0];
            $notes = $array[$name]['notes'][0];

            $s = new SmaModuleManager();
            $s->name = $name;
            $s->email = 'support@example.com';
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->is_default = 1;
            $s->purchase_code = time();
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();


            // Zoom
            $name = 'Zoom';
            $s = new SmaModuleManager();
            $s->name = $name;
            $s->email = 'support@example.com';
            $s->notes = "This is Zoom module for live virtual class and meeting in this system at a time. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->addon_url = "https://example.com/sga-zoom-live-class/27623128?s_rank=12";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            // OnlineExam
            $name = 'OnlineExam';
            $s = new SmaModuleManager();
            $s->name = $name;
            $s->email = 'support@example.com';
            $s->notes = "This is OnlineExam module for take online exam Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->addon_url = "mailto:support@example.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            // ParentRegistration
            $name = 'ParentRegistration';
            $s = new SmaModuleManager();
            $s->name = $name;
            $s->email = 'support@example.com';
            $s->notes = "This is Parent Registration module for Registration. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->addon_url = '#';
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            // RazorPay
            $dataPath = 'Modules/RazorPay/RazorPay.json';
            $name = 'RazorPay';

            $s = new SmaModuleManager();
            $s->name = 'RazorPay';
            $s->email = 'support@example.com';
            $s->notes = "This is Razor Pay module for Online payemnt. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->addon_url = "https://sgupdate.test/27721206?";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            // BigBlueButton
            $name = 'BBB';
            $s = new SmaModuleManager();
            $s->name = 'BBB';
            $s->email = 'support@example.com';
            $s->notes = "This is BigBlueButton module for live virtual class and meeting in this system at a time. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->addon_url = "mailto:support@example.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            // Jitsi

            $name = 'Jitsi';
            $s = new SmaModuleManager();
            $s->name = 'Jitsi';
            $s->email = 'support@example.com';
            $s->notes = "This is Jitsi module for live virtual class and meeting in this system at a time. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->addon_url = "mailto:support@example.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            // Saas

            $name = 'Saas';
            $s = new SmaModuleManager();
            $s->name = 'Saas';
            $s->email = 'support@example.com';
            $s->notes = "This is Saas module for manage multiple school or institutes.Every school managed by individual admin. Thanks for using.";
            $s->version = "1.1";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->addon_url = "mailto:support@example.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();


            // BulkPrint
            $bulk_print = 'BulkPrint';
            $bulk_print = new SmaModuleManager();
            $bulk_print->name = 'BulkPrint';
            $bulk_print->email = 'support@example.com';
            $bulk_print->notes = "This is Bulkprint module for print invoice ,certificate and id card. Thanks for using.";
            $bulk_print->version = "1.0";
            $bulk_print->update_url = "https://example.com/contact";
            $bulk_print->is_default = 1;
            $bulk_print->addon_url = "https://example.com/sga-zoom-live-class/27623128?s_rank=12";
            $bulk_print->installed_domain = url('/');
            $bulk_print->activated_date = date('Y-m-d');
            $bulk_print->save();

            // HimalayaSms
            $HimalayaSms = 'HimalayaSms';
            $HimalayaSms = new SmaModuleManager();
            $HimalayaSms->name = "HimalayaSms";
            $HimalayaSms->email = 'support@example.com';
            $HimalayaSms->notes = "This is sms gateway module for sending sms via api. Thanks for using.";
            $HimalayaSms->version = "1.0";
            $HimalayaSms->update_url = "https://example.com/contact";
            $HimalayaSms->is_default = 1;
            $HimalayaSms->addon_url = "mailto:support@example.com";
            $HimalayaSms->installed_domain = url('/');
            $HimalayaSms->activated_date = date('Y-m-d');
            $HimalayaSms->save();

            // XenditPayment
            $XenditPayment = 'XenditPayment';
            $XenditPayment = new SmaModuleManager();
            $XenditPayment->name = 'XenditPayment';
            $XenditPayment->email = 'support@example.com';
            $XenditPayment->notes = "This is online payment gateway module for specially indonesian currency. Thanks for using.";
            $XenditPayment->version = "1.0";
            $XenditPayment->update_url = "https://example.com/contact";
            $XenditPayment->is_default = 1;
            $XenditPayment->addon_url = "mailto:support@example.com";
            $XenditPayment->installed_domain = url('/');
            $XenditPayment->activated_date = date('Y-m-d');
            $XenditPayment->save();

            // AppSlider
            $XenditPayment = 'AppSlider';
            $XenditPayment = new SmaModuleManager();
            $XenditPayment->name = 'AppSlider';
            $XenditPayment->email = 'support@example.com';
            $XenditPayment->notes = "This is for school affiliate banner for mobile app. Thanks for using.";
            $XenditPayment->version = "1.0";
            $XenditPayment->update_url = "https://example.com/contact";
            $XenditPayment->is_default = 0;
            $XenditPayment->addon_url = "mailto:support@example.com";
            $XenditPayment->installed_domain = url('/');
            $XenditPayment->activated_date = date('Y-m-d');
            $XenditPayment->save();

            //KhaltiPayment
            $s = new SmaModuleManager();
            $s->name = "KhaltiPayment";
            $s->email = 'support@example.com';
            $s->notes = "Khalti Is A Online Payment Gatway Module For Collect Fees Online";
            $s->version = 1.0;
            $s->update_url = "support@example.com";
            $s->is_default = 0;
            $s->purchase_code = null;
            $s->installed_domain = null;
            $s->activated_date = null;
            $s->save();

            //Raudhahpay
            $s = new SmaModuleManager();
            $s->name = 'Raudhahpay';
            $s->email = 'support@example.com';
            $s->notes = "This is Saas module for Online Payment. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->addon_url = "mailto:support@example.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            // Wallet
            $dataPath = 'Modules/Wallet/Wallet.json';
            $name = 'Wallet';
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);

            $version = $array[$name]['versions'][0];
            $url = $array[$name]['url'][0];
            $notes = $array[$name]['notes'][0];

            $s = new SmaModuleManager();
            $s->name = $name;
            $s->email = 'support@example.com';
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->is_default = 1;
            $s->purchase_code = time();
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            // Fees
            $dataPath = 'Modules/Fees/Fees.json';
            $name = 'Fees';
            $strJsonFileContents = file_get_contents($dataPath);
            $array = json_decode($strJsonFileContents, true);

            $version = $array[$name]['versions'][0];
            $url = $array[$name]['url'][0];
            $notes = $array[$name]['notes'][0];

            $s = new SmaModuleManager();
            $s->name = $name;
            $s->email = 'support@example.com';
            $s->notes = $notes;
            $s->version = $version;
            $s->update_url = $url;
            $s->is_default = 1;
            $s->purchase_code = time();
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();


            $s = new SmaModuleManager();
            $s->name = 'ExamPlan';
            $s->email = 'support@example.com';
            $s->notes = "Exam Plan and Seat Plan Module";
            $s->version = 1.0;
            $s->update_url = url('/');;
            $s->is_default = 1;
            $s->purchase_code = time();
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            //InfixBiometrics 
            $s = new SmaModuleManager();
            $s->name = "InfixBiometrics";
            $s->email = 'support@example.com';
            $s->notes = "This is InfixBiometrics module for live virtual class and meeting in this system at a time. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->addon_url = "https://example.com/sga-zoom-live-class/27623128?s_rank=12";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            //Gmeet 
            $s = new SmaModuleManager();
            $s->name = "Gmeet";
            $s->email = 'support@example.com';
            $s->notes = "This is Gmeet module for live virtual class and meeting in this system at a time. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->addon_url = "https://sgupdate.test/42463761";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();


            //Phonepay 
            $s = new SmaModuleManager();
            $s->name = "PhonePay";
            $s->email = 'support@example.com';
            $s->notes = "This is PhonePay module for manage Phonepe  online payment gateway . Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->addon_url = "https://example.com/contact";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            //BehaviourRecords 
            $s = new SmaModuleManager();
            $s->name = "BehaviourRecords";
            $s->email = 'support@example.com';
            $s->notes = "This is Behaviour Records Module for manage student behaviour records & Activity. Thanks for using .";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 1;
            $s->purchase_code = time();
            $s->addon_url = "https://sgupdate.test/42463761";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            //DownloadCenter 
            $s = new SmaModuleManager();
            $s->name = "DownloadCenter";
            $s->email = 'support@example.com';
            $s->notes = "This Module is named Download Center for managing study materials more efficiently. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 1;
            $s->purchase_code = time();
            $s->addon_url = "https://sgupdate.test/42463761";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            //DownloadCenter 
            $s = new SmaModuleManager();
            $s->name = "DownloadCenter";
            $s->email = 'support@example.com';
            $s->notes = "This Module is named Download Center for managing study materials more efficiently. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->purchase_code = time();
            $s->addon_url = "https://sgupdate.test/42463761";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();


            //TwoFactorAuth 
            $s = new SmaModuleManager();
            $s->name = "TwoFactorAuth";
            $s->email = 'support@example.com';
            $s->notes = "This is TwoFactorAuth module for verfication two factor authentication code using email or text sms. Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 1;
            $s->purchase_code = time();
            $s->addon_url = "https://sgupdate.test/42463761";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();


            //Lms
            $name = 'Lms';
            $s = new SmaModuleManager();
            $s->name = 'Lms';
            $s->email = 'support@example.com';
            $s->notes = "This is Lms module for learning management. Teacher & Admin Can create course and student & parent can enroll using online & offline payment gateway . Thanks for using.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->addon_url = "mailto:support@example.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            //CcAveune 
            $s = new SmaModuleManager();
            $s->name = "CcAveune";
            $s->email = 'support@example.com';
            $s->notes = "This CcAveune Module For SgEdu . Manage online payment for fees & wallet.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->addon_url = "maito:support@example.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            //AiContent 
            $s = new SmaModuleManager();
            $s->name = "AiContent";
            $s->email = 'support@example.com';
            $s->notes = "This is AI Content Generator module. Generate content via AI.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->addon_url = "maito:support@example.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();

            //WhatsappSupport 
            $s = new SmaModuleManager();
            $s->name = "WhatsappSupport";
            $s->email = 'support@example.com';
            $s->notes = "This is WhatsApp Support module. Send message via WhatsApp.";
            $s->version = "1.0";
            $s->update_url = "https://example.com/contact";
            $s->is_default = 0;
            $s->addon_url = "maito:support@example.com";
            $s->installed_domain = url('/');
            $s->activated_date = date('Y-m-d');
            $s->save();


            // Certificate
            $s = new SmaModuleManager();
            $s->name = 'Certificate';
            $s->email = 'support@example.com';
            $s->notes = "This is the module to generate Certificate's for students and employees.";
            $s->is_default = 0;
            $s->version = '1.0';
            $s->update_url = "maito:support@example.com";
            $s->purchase_code = null;
            $s->installed_domain = null;
            $s->activated_date = null;
            $s->save();
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sma_module_managers');
    }
}
