<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\RolePermission\Entities\AssignPermission;
use Modules\RolePermission\Entities\SmaModuleInfo;
use Modules\RolePermission\Entities\SmaModuleStudentParentInfo;
use Modules\RolePermission\Entities\SmaPermissionAssign;
use Modules\RolePermission\Entities\Permission;

class CreateSmaPermissionAssignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sma_permission_assigns', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('active_status')->default(1);
            $table->timestamps();
            $table->integer('module_id')->nullable()->comment(' module id, module link id, module link options id');
            $table->string('module_info')->nullable();
            $table->integer('role_id')->nullable()->unsigned();
            $table->foreign('role_id')->references('id')->on('sma_roles')->onDelete('cascade');
            $table->text('saas_schools')->nullable();
            $table->integer('created_by')->nullable()->default(1)->unsigned();
            $table->integer('updated_by')->nullable()->default(1)->unsigned();
            $table->integer('school_id')->nullable()->default(1)->unsigned();
            $table->foreign('school_id')->references('id')->on('sm_schools')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sma_permission_assigns');
    }
}
