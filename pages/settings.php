<?php

$addon = rex_addon::get('structure_metainfo');

$form = rex_config_form::factory($addon->getName());

$field = $form->addSelectField('sidebar_or_tab', $value = null, ['class'=>'form-control selectpicker']);
$field->setLabel("Darstellung");
$select = $field->getSelect();
$select->addOption('Sidebar des Editiermodus', 'sidebar');
$select->addOption('Tab neben Editiermodus (Standard)', 'tab');

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('structure_metainfo.settings'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
