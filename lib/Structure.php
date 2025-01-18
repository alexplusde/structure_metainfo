<?php

namespace Alexplusde\StructureMetainfo;

use rex_article;
use rex_yform_manager_dataset;

class Structure extends rex_yform_manager_dataset
{
    public static function getCurrent(): ?self
    {
        return self::query()->where('article_id', rex_article::getCurrent())->findOne();
    }

    /** @api */
    
    public static function getCurrentValue(string $key): mixed
    {
        $article = self::getCurrent();
        if ($article instanceof self) {
            return $article->getValue($key);
        }
        return null;
    }
    
    /**
     * Fügt einem Artikel die Möglichkeit hinzu, Metainfos zuzuordnen.
     *
     * Diese Methode registriert eine Erweiterung, die eine neue Backend-Seite hinzufügt, wenn die Seiten vorbereitet werden.
     */
    public static function addContentTab()
    {
        \rex_extension::register('PAGES_PREPARED', function () {
            $page = new \rex_be_page('structure_metainfo', \rex_i18n::msg('structure_metainfo.tab.title'));
            $page->setPjax(false);
            $page->setSubPath(\rex_addon::get('structure_metainfo')->getPath('pages/tab.php'));
            $page_controller = \rex_be_controller::getPageObject('content');
            $page->setItemAttr('class', "pull-left");
            $page_controller->addSubpage($page);
        });
    }
}

/**
 * 
* CLANG_ADDED
* : Daten: keine
* : Parameter: ['id' => $clang->getId(), 'name' => $clang->getName(), 'clang' => $clang]

* CLANG_DELETED
* : Daten: keine
* : Parameter: ['id' => $clang->getId(), 'name' => $clang->getName(), 'clang' => $clang]

 */
