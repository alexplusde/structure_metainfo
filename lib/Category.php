<?php

namespace Alexplusde\StructureMetainfo;

use rex;
use rex_sql;
use rex_category;
use rex_yform_manager_dataset;

class Category extends rex_yform_manager_dataset
{
    public static function getCurrent(): ?self
    {
        return self::query()->where('article_id', rex_category::getCurrent())->findOne();
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

    public static function epClangAdded($ep) {
        $name = $ep->getName();
        $subject = $ep->getSubject();
        $params = $ep->getParams();
            
        $clang_id = $params['clang'];

        // per rex_sql alle Einträge duplizieren mit neuer clang_id
        $query = 'INSERT INTO ' . rex::getTable('structure_metainfo_category') . ' (article_id, clang_id, article_pid) SELECT id, clang_id, pid FROM ' . rex::getTable('article') . ' WHERE clang_id = '. $clang_id .' ON DUPLICATE KEY UPDATE article_pid = pid';
        rex_sql::factory()->setQuery($query);

        return $subject;
    }

    public static function epClangDeleted($ep) {
        $name = $ep->getName();
        $subject = $ep->getSubject();
        $params = $ep->getParams();
            
        Category::query()
        ->where('clang_id', $params['clang'])
        ->find()->delete();

        return $subject;
    }

    public static function epCatToArt($ep) {
        $name = $ep->getName();
        $subject = $ep->getSubject();
        $params = $ep->getParams();
            
        Category::query()->where('category_id', $params['id'])->find()->delete();

        return $subject;
    }

    
    /**
     *   ART_TO_STARTARTICLE
     *   : Daten: keine
     *   : Parameter: ['id' => $neu_id, 'id_old' => $alt_id, 'clang' => $clang]
     */

     public static function epArtToStartarticle($ep) {
        $name = $ep->getName();
        $subject = $ep->getSubject();
        $params = $ep->getParams();
        
        $category = rex_category::get($params['id']);
        $category_pid = $category->pid;

        $dataset = Category::query()->where('category_id', $params['id_old'])->where('clang_id', $params['clang'])->where('category_pid', $category_pid)->findOne();
        $dataset->setValue('category_id', $params['id'])
        ->setValue('category_pid', $category_pid)
        ->save();

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
