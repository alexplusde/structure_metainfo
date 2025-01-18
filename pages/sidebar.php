<?php

use alexplusde\StructureMetainfo\Structure;

$content = '';
$addon = rex_addon::get('structure_metainfo');


/* Wird für die Zusammenstellung der Backend-URL und Ermittlung der pid in rex_article benötigt */
$article = rex_article::getCurrent();
$article_id = $article->getId();
$clang_id = $article->getClangId();
$ctype_id = $params['ctype'];
$article_pid = $article->getValue('pid');

$entry = Structure::query()->where('article_pid', $article_pid)->findOne();

if($entry === null) {
    $entry = Structure::create();
}

$yform = $entry->getForm();
$yform->setObjectparams('form_action', rex_url::backendController(['page' => 'content/edit', 'article_id' => $article_id, 'clang' => $clang_id, 'ctype' => $ctype_id], false));
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

$form = '';
$rexUser = rex::getUser();

if ($rexUser) {
    $permission_info = '';
    if (!$rexUser->hasPerm('structure_metainfo[article]')) {
        $yform->setObjectparams('submit_btn_show', false);

        $nonce = '';
        if (method_exists('rex_response', 'getNonce')) {
            $nonce = ' nonce="' . rex_response::getNonce() . '"';
        }

        $permission_info .= '<script' . $nonce . '>$( document ).ready(function() { $("#rex-page-sidebar-structure_metainfo :input").attr("disabled", true); }); </script>';
        $permission_info .= '<div><p class="alert alert-danger">' . $addon->i18n('no_permission_to_edit') . '</p></div>';
    } else {
        $yform->setObjectparams('submit_btn_label', $addon->i18n('structure_metainfo.update'));
    }

    $form = $yform->getForm();

    if ($yform->objparams['actions_executed'] && $rexUser->hasPerm('structure_metainfo[article]')) {
        // TODO: trigger ARTICLE_UPDATE
        $form = rex_view::success($addon->i18n('structure_metainfo.updated')) . $form;
        rex_article_cache::delete($article_id, $clang);
    }

    $form = '<section id="rex-page-sidebar-structure_metainfo" data-pjax-container="#rex-page-sidebar-structure_metainfo" data-pjax="false" data-pjax-no-history="1">' . $permission_info . $form . '</section>';
}

return $form;
