<?php

rex_sql_table::get(rex::getTable('structure_metainfo'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('article_id', 'int(10) unsigned'))
    ->ensureColumn(new rex_sql_column('clang', 'int(10) unsigned'))
    ->ensureColumn(new rex_sql_column('is_category', 'int(10) unsigned'))
    ->ensure();

$addon = rex_addon::get('structure_metainfo');

if (rex_addon::get('yform')->isAvailable() && !rex::isSafeMode()) {
//     rex_yform_manager_table_api::importTablesets(rex_file::get(__DIR__ . '/install/rex_structure_metainfo.tableset.json')); // @phpstan-ignore-line
    rex_yform_manager_table::deleteCache();
}
