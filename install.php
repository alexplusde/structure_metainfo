<?php

$addon = rex_addon::get('structure_metainfo');

include(__DIR__ . '/install/install.php');

if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
    rex_yform_manager_table_api::importTablesets(rex_file::get(__DIR__ . '/install/rex_structure_metainfo.tableset.json'));
    rex_yform_manager_table_api::importTablesets(rex_file::get(__DIR__ . '/install/rex_structure_metainfo_category.tableset.json'));
    rex_yform_manager_table::deleteCache();
}
