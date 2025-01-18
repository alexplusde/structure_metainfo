<?php

use alexplusde\StructureMetainfo\Article;

$articleId = rex_request('article_id', 'int');
$categoryId = rex_request('category_id', 'int');
$clang_id = rex_request('clang', 'int');
$ctype_id = rex_request('ctype', 'int');

$article = rex_article::getCurrent();
$article_id = $article->getId();
$clang_id = $article->getClangId();
$article_pid = $article->getValue('pid');


$context = new rex_context([
    'page' => rex_be_controller::getCurrentPage(),
    'article_id' => $articleId,
    'category_id' => $categoryId,
    'clang' => $clang_id,
    'ctype' => $ctype_id,
]);

$entry = Article::query()->where('article_pid', $article_pid)->findOne();

if($entry === null) {
    $entry = Article::create();
}

$yform = $entry->getForm();
$yform->setObjectparams('form_action', rex_url::backendController(['page' => 'content/structure_metainfo', 'article_id' => $article_id, 'clang' => $clang_id, 'ctype' => $ctype_id], false));
$yform->setObjectparams('form_id', 'structure_metainfo');
$yform->setObjectparams('form_name', 'structure_metainfo');
$yform->setObjectparams('real_field_names', true);

$yform->setObjectparams('form_showformafterupdate', 1);

if($entry->exists() === true) {
    $yform->setObjectparams('main_table', $entry->getTablename());
    $yform->setObjectparams('main_id', $entry->getId());
    $yform->setObjectparams('main_where', 'article_pid = ' . $article_pid);
    $yform->setObjectparams('getdata', true);
    $yform->setActionField('db', [$entry->getTableName(), 'article_pid = ' . $article_pid]);
} else {
    $yform->setActionField('db', [$entry->getTableName()]);
}

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', rex_i18n::msg('structure_metainfo.article_tab.title'), false);
$fragment->setVar('body', $yform->getForm(), false);

return $fragment->parse('core/page/section.php');
