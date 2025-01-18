<?php

namespace Alexplusde\StructureMetainfo;

use rex_category;
use rex_yform_manager_dataset;

class Category extends Structure
{
 /*
 CAT_ADDED
: Daten: $message
: Parameter: ['category' => clone $AART, 'id' => $id, 'parent_id' => $category_id, 'clang' => $key, 'name' => $data['catname'], 'priority' => $data['catpriority'], 'path' => $path, 'status' => $data['status'], 'article' => clone $AART, 'data' => $data]
*/   
    public static function epCatUpdated($ep) {
        $name = $ep->getName();
        $subject = $ep->getSubject();
        $params = $ep->getParams();

        return $subject;    

    }
    public static function epCatAdded($ep) {
        $name = $ep->getName();
        $subject = $ep->getSubject();
        $params = $ep->getParams();
            
        $article = $ep->getParam('article');
        $article_pid = $article->pid;
        Category::create()
        ->setValue('article_id', $params['id'])
        ->setValue('clang_id', $params['clang'])
        ->setValue('article_pid', $article_pid)
        ->save();
        return $subject;

    }
    public static function epCatDeleted($ep) {
        $name = $ep->getName();
        $subject = $ep->getSubject();
        $params = $ep->getParams();
            
        $article = $ep->getParam('article');
        $article_pid = $article->pid;

        Category::query()
        ->where('article_id', $params['id'])
        ->where('clang_id', $params['clang'])
        ->where('article_pid', $article_pid)
        ->findOne()->delete();

        return $subject;
    }
    
    /**
     * Fügt einem Artikel die Möglichkeit hinzu, Metainfos zuzuordnen.
     *
     * Diese Methode registriert eine Erweiterung, die eine neue Backend-Seite hinzufügt, wenn die Seiten vorbereitet werden.
     */
    public static function addContentTab()
    {
        \rex_extension::register('PAGES_PREPARED', function () {
            if(\rex_article::getCurrent()->isStartArticle() === false) {
                return;
            }
            $page = new \rex_be_page('structure_metainfo_category', \rex_i18n::msg('structure_metainfo.category_tab.title'));
            $page->setPjax(false);
            $page->setSubPath(\rex_addon::get('structure_metainfo')->getPath('pages/category_tab.php'));
            $page_controller = \rex_be_controller::getPageObject('content');
            $page->setItemAttr('class', "pull-left");
            $page_controller->addSubpage($page);
        });
    }

}

/** TODO
 * 
 * CAT_TO_ART
 * : Daten: keine
 * : Parameter: ['id' => $art_id, 'clang' => $clang]
 */
