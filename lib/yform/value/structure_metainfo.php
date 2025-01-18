<?php

class rex_yform_value_structure_metainfo extends rex_yform_value_abstract
{

    public function enterObject()
    {
        $article = rex_article::getCurrent();
        if(!$article) {
            return;
        }
        $article_id = $article->getId();
        $clang_id = $article->getClangId();
        $article_pid = $article->getValue('pid');

        if($this->getName() === 'article_id') {
            $this->value = $article_id;
        }
        if($this->getName() === 'article_pid') {
            $this->value = $article_pid;
        }
        if($this->getName() === 'clang_id') {
            $this->value = $clang_id;
        }
        
        $this->params['value_pool']['email'][$this->getName()] = $this->value;
        $this->params['value_pool']['sql'][$this->getName()] = $this->value;
        return;
    }

    public function getDescription(): string
    {
        return 'structure_metainfo|fieldname[article_id,article_pid,clang_id]|value';
    }

    public function getDefinitions(): array
    {
        return [
            'type' => 'value',
            'name' => 'structure_metainfo',
            'values' => [
                'name' => ['type' => 'choice', 'label' => rex_i18n::msg('yform_values_structure_metainfo'), 'choices' => ['article_id' => 'article_id', 'article_pid' => 'article_pid', 'clang_id' => 'clang_id'], 'default' => 'article_id'],
            ],
            'description' => '🧩 Feldtyp für das Addon <code>structure_metainfo</code>',
            'db_type' => ['int(10) unsigned'],
        ];
    }
}
