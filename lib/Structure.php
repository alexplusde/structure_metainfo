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
