<?php

use App\SmaModuleManager;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarcadoPagoToModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $s = new SmaModuleManager();
        $s->name = 'MercadoPago';
        $s->email = 'support@example.com';
        $s->notes = "This is MercadoPago Payment Module For Online Payment. Thanks For Using.";
        $s->version = "1.0";
        $s->update_url = "https://example.com/contact";
        $s->is_default = 0;
        $s->addon_url = "https://example.com/contact";
        $s->installed_domain = url('/');
        $s->activated_date = date('Y-m-d');
        $s->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modules', function (Blueprint $table) {
            //
        });
    }
}
