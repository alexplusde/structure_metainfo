<?php

namespace Alexplusde\StructureMetainfo;

use rex;
use rex_sql;
use rex_article;
use rex_yform_manager_dataset;

class Article extends rex_yform_manager_dataset
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

    /*
    ART_UPDATED
: Daten: $message
: Parameter: ['id' => $article_id, 'article' => clone $EA, 'article_old' => clone $thisArt, 'status' => $thisArt->getValue('status'), 'name' => $data['name'], 'clang' => $clang, 'parent_id' => $data['category_id'], 'priority' => $data['priority'], 'path' => $data['path'], 'template_id' => $data['template_id'], 'data' => $data]
 */
    public static function epArtUpdated($ep) {
        
    }
    /*
    ART_ADDED
: Daten: $message
: Parameter: ['id' => $id, 'clang' => $key, 'status' => 0, 'name' => $data['name'], 'parent_id' => $data['category_id'], 'priority' => $data['priority'], 'path' => $path, 'template_id' => $data['template_id'], 'data' => $data]

    */
    public static function epArtAdded($ep) {
        $name = $ep->getName();
        $subject = $ep->getSubject();
        $params = $ep->getParams();
            
        $article = $ep->getParam('article');
        $article_pid = $article->pid;
        Article::create()
        ->setValue('article_id', $params['id'])
        ->setValue('clang_id', $params['clang'])
        ->setValue('article_pid', $article_pid)
        ->save();
        return $subject;
    }
    /*
    ART_DELETED
: Daten: $message
: Parameter: ['id' => $article_id, 'clang' => $clang, 'parent_id' => $parent_id, 'name' => $Art->getValue('name'), 'status' => $Art->getValue('status'), 'priority' => $Art->getValue('priority'), 'path' => $Art->getValue('path'), 'template_id' => $Art->getValue('template_id')]
*/
    public static function epArtDeleted($ep) {
        $name = $ep->getName();
        $subject = $ep->getSubject();
        $params = $ep->getParams();
            
        $article = $ep->getParam('article');
        $article_pid = $article->pid;

        Article::query()
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
        $query = 'INSERT INTO ' . rex::getTable('structure_metainfo_article') . ' (article_id, clang_id, article_pid) SELECT id, clang_id, pid FROM ' . rex::getTable('article') . ' WHERE clang_id = '. $clang_id .' ON DUPLICATE KEY UPDATE article_pid = pid';
        rex_sql::factory()->setQuery($query);

        return $subject;
    }

    public static function epClangDeleted($ep) {
        $name = $ep->getName();
        $subject = $ep->getSubject();
        $params = $ep->getParams();
            
        Article::query()
        ->where('clang_id', $params['clang'])
        ->find()->delete();

        return $subject;
    }

    /**
    * ART_TO_CAT
    *   : Daten: keine
    *   : Parameter: ['id' => $art_id, 'clang' => $clang]
    */

    public static function epArtToCat($ep) {
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

    /**
     * Fügt einem Artikel die Möglichkeit hinzu, Metainfos zuzuordnen.
     *
     * Diese Methode registriert eine Erweiterung, die eine neue Backend-Seite hinzufügt, wenn die Seiten vorbereitet werden.
     */
    public static function addContentTab()
    {
        \rex_extension::register('PAGES_PREPARED', function () {
            $page = new \rex_be_page('structure_metainfo', \rex_i18n::msg('structure_metainfo.article_tab.title'));
            $page->setPjax(false);
            $page->setSubPath(\rex_addon::get('structure_metainfo')->getPath('pages/article_tab.php'));
            $page_controller = \rex_be_controller::getPageObject('content');
            $page->setItemAttr('class', "pull-left");
            $page_controller->addSubpage($page);
        });
    }
}
