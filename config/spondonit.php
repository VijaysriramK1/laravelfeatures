<?php

return [
    'item_id' => '101101',
    'module_manager_model' => App\SmaModuleManager::class,
    'module_manager_table' => 'sma_module_managers',

    'settings_model' => App\SmGeneralSettings::class,
    'module_model' => Nwidart\Modules\Facades\Module::class,

    'user_model' => App\User::class,
    'settings_table' => 'sm_general_settings',
    'database_file' => 'sgaeduV6.sql',
];
