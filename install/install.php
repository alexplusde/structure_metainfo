<?php 

rex_sql_table::get(rex::getTable('structure_metainfo'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('article_id', 'int(10) unsigned'))
    ->ensureColumn(new rex_sql_column('clang_id', 'int(10) unsigned'))
    ->ensureColumn(new rex_sql_column('article_pid', 'int(10) unsigned'))
    ->ensureIndex(new rex_sql_index('article_pid', ['article_pid'], rex_sql_index::UNIQUE))
    ->ensureIndex(new rex_sql_index('article_id_clang_id', ['article_id', 'clang_id'], rex_sql_index::UNIQUE))
    ->ensure();

$query = 'INSERT INTO ' . rex::getTable('structure_metainfo') . ' (article_id, clang_id, article_pid) SELECT id, clang_id, pid FROM ' . rex::getTable('article') . ' ON DUPLICATE KEY UPDATE article_pid = pid';

rex_sql::factory()->setQuery($query);

rex_sql_table::get(rex::getTable('structure_metainfo_category'))
    ->ensurePrimaryIdColumn()
    ->ensureColumn(new rex_sql_column('category_id', 'int(10) unsigned'))
    ->ensureColumn(new rex_sql_column('clang_id', 'int(10) unsigned'))
    ->ensureColumn(new rex_sql_column('category_pid', 'int(10) unsigned'))
    ->ensureIndex(new rex_sql_index('category_pid', ['category_pid'], rex_sql_index::UNIQUE))
    ->ensureIndex(new rex_sql_index('category_id_clang_id', ['category_id', 'clang_id'], rex_sql_index::UNIQUE))
    ->ensure();

$query = 'INSERT INTO ' . rex::getTable('structure_metainfo_category') . ' (category_id, clang_id, category_pid) SELECT id, clang_id, pid FROM ' . rex::getTable('article') . ' WHERE startarticle = 1 ON DUPLICATE KEY UPDATE category_pid = pid';

rex_sql::factory()->setQuery($query);
