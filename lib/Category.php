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

}

/** TODO
 * 
 * CAT_TO_ART
 * : Daten: keine
 * : Parameter: ['id' => $art_id, 'clang' => $clang]
 */
