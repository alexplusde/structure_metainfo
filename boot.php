<?php

namespace Alexplusde\StructureMetainfo;

use rex_extension;
use rex_extension_point;
use rex_yform_manager_dataset;
use rex_fragment;
use rex_path;
use rex_config;
use rex_be_controller;

// Listendarstellung von YRewrite Domains um eine Spalte ergänzen mit Link zu YRewrite Metainfos
rex_extension::register('PACKAGES_INCLUDED', function (rex_extension_point $ep) {
    rex_extension::register('STRUCTURE_CONTENT_SIDEBAR', function (rex_extension_point $ep) {
        if(rex_config::get('structure_metainfo', 'sidebar_or_tab') === "sidebar") {
            $params = $ep->getParams();
            $subject = $ep->getSubject();

            $panel = include rex_path::addon('structure_metainfo', 'pages/article_sidebar.php');

            $fragment = new rex_fragment();
            $fragment->setVar('title', '<i class="fa rex-icon-metainfo"></i> ' . $this->i18n('structure_metainfo_article'), false);
            $fragment->setVar('body', $panel, false);
            $content1 = $fragment->parse('core/page/section.php');

            $panel = include rex_path::addon('structure_metainfo', 'pages/category_sidebar.php');

            $fragment = new rex_fragment();
            $fragment->setVar('title', '<i class="fa rex-icon-metainfo"></i> ' . $this->i18n('structure_metainfo_category'), false);
            $fragment->setVar('body', $panel, false);
            $content2 = $fragment->parse('core/page/section.php');

            return $content1 . $content2 . $subject;
        }
    });
}, rex_extension::EARLY);

rex_extension::register('ART_ADDED', [Article::class, 'epArtAdded']);
rex_extension::register('ART_UPDATED', [Article::class, 'epArtUpdated']);
rex_extension::register('ART_DELETED', [Article::class, 'epArtDeleted']);

rex_extension::register('CAT_ADDED', [Category::class, 'epCatAdded']);
rex_extension::register('CAT_UPDATED', [Category::class, 'epCatUpdated']);
rex_extension::register('CAT_DELETED', [Category::class, 'epCatDeleted']);

rex_extension::register('CAT_TO_ART', [Category::class, 'epCatToArt']);
rex_extension::register('ART_TO_CAT', [Article::class, 'epArtToCat']);
rex_extension::register('ART_TO_STARTARTICLE', [Category::class, 'epArtToStartarticle']);

rex_extension::register('CLANG_ADDED', [Article::class, 'epClangAdded']);
rex_extension::register('CLANG_ADDED', [Category::class, 'epClangAdded']);
rex_extension::register('CLANG_DELETED', [Article::class, 'epClangDeleted']);
rex_extension::register('CLANG_DELETED', [Category::class, 'epClangDeleted']);


if (\rex_addon::get('yform')->isAvailable() && !\rex::isSafeMode()) {
    rex_yform_manager_dataset::setModelClass(
        'rex_structure_metainfo_article',
        Article::class
    );
    rex_yform_manager_dataset::setModelClass(
        'rex_structure_metainfo_category',
        Category::class
    );
}

if (\rex::isBackend()) {
    if(rex_be_controller::getCurrentPagePart() && rex_be_controller::getCurrentPagePart()[0] == "content") {
        if(rex_config::get('structure_metainfo', 'sidebar_or_tab') === 'tab') {
                Article::addContentTab();
                Category::addContentTab();
        }
    }
}

if (\rex::isBackend()) {
    rex_extension::register('YFORM_DATA_LIST', function ($ep) {

        if ($ep->getParam('table')->getTableName() == "rex_structure_metainfo_article") {
            $list = $ep->getSubject();
            $list->removeColumn('id');
        };
        if ($ep->getParam('table')->getTableName() == "rex_structure_metainfo_category") {
            $list = $ep->getSubject();
            $list->removeColumn('id');
        };
    });
}
