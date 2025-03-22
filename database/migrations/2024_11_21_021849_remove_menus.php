<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $moduleIds = DB::table('sm_modules')->whereIn('name', ['Library', 'Transport', 'Dormitory','Inventory'])->pluck('id');

        $moduleLinkIds = DB::table('sm_module_links')->whereIn('module_id', $moduleIds)->pluck('id');

        $permissionIds =  DB::table('permissions')->whereIn('sidebar_menu', ['library', 'transport', 'dormitory','inventory'])->pluck('id');

        DB::table('sm_role_permissions')->whereIn('module_link_id', $moduleLinkIds)->delete();
        DB::table('sm_module_links')->whereIn('module_id', $moduleIds)->delete();
        DB::table('sma_module_student_parent_infos')->whereIn('module_id', $moduleIds)->delete();
        DB::table('permissions')->whereIn('name', ['Student Transport Report', 'Student Dormitory Report','Item Category','Item List','Item Store','Supplier','Item Receive','Item Receive List','Item Sell','Item Issue'])->delete();
        DB::table('permissions')->whereIn('sidebar_menu', ['library', 'transport', 'dormitory','inventory'])->delete();
        DB::table('assign_permissions')->whereIn('permission_id', $permissionIds)->delete();
        DB::table('sm_modules')->whereIn('name', ['Library', 'Transport', 'Dormitory','Inventory'])->delete();
        DB::table('sma_roles')->whereIn('name',['Driver','Librarian'])->delete();


        try {
            $response = Http::get(route('reset-with-section'));

            if ($response->successful()) {
                Log::info('Route reset-with-section called successfully during migration.');
            } else {
                Log::warning('Route reset-with-section failed during migration.');
            }
        } catch (\Exception $e) {
            Log::error('Error calling reset-with-section route during migration: ' . $e->getMessage());
        }
        
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('permissions')->insert([
            [
                'sidebar_menu' => 'library'
            ],
            [
                'name' => 'Student Transport Report',
            ],
            [
                'name' => 'Student Dormitory Report',
            ],
            
        ]);

        $modules = [
            ['name' => 'Library'],
            ['name' => 'Transport'],
            ['name' => 'Dormitory'],
        ];
        
        foreach ($modules as $module) {
            $moduleId = DB::table('sm_modules')->insertGetId($module);

            DB::table('sm_module_links')->insert([
                [
                    'module_id' => $moduleId,
                ],
            ]);
        }
       
    }
};
