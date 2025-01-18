# Die Klasse `Structure`

Kind-Klasse von `rex_yform_manager_dataset`, damit stehen alle Methoden von YOrm-Datasets zur Verfügung. Greift auf die Tabelle `rex_structure_metainfo` zu.

> Es werden nachfolgend die durch dieses Addon ergänzte Methoden beschrieben. Lerne mehr über YOrm und den Methoden für Querys, Datasets und Collections in der [YOrm Doku](https://github.com/yakamara/yform/blob/master/docs/04_yorm.md)

## Infos zur aktuellen Structure erhalten

```php
$metainfo = Structure::getCurrent(); // Aktuelle Domain
$metainfo->getValue('mein_feld') // Eigene Felder auslesen
```

## Methoden und Beispiele
