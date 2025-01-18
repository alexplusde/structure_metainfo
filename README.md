# Meta-Infos in REDAXO 5 für Artikel und Kategorien auf YForm-Basis

Ergänzt das Structure-Addon um die Möglichkeit, Metainformationen an Artikel und Kategorien zu verwalten. Mit vorgefertigten, einfachen aber sinnvollen Konfigurationsfeldern, passender YOrm-Dataset-Methoden und Backend-Seiten für die Eingabe.

## Installation und Ersteinrichtung

### Installation

Voraussetzungen: YForm ^4.

1. Installiere das Addon über den REDAXO-Installer
2. Ändere ggf. in der rex_config-Tabelle die Einstellung `sidebar_or_tab` auf `sidebar` (Standard ist `tab`).

Anschließend können die passenden Meta-Informationen am Artikel eingegeben werden.

> **Hinweis:**
>
## Features

### Gemeinsamkeiten und Unterschiede zum klassischen Metainfo-Addon (Core)

| Funktionen                 | Metainfo (Core)       | Structure Metainfo (dieses Addon) |
|----------------------------|-----------------------|-----------------------------------|
| Mindestanforderung         | REDAXO ^5.0           | REDAXO ^5.18 und YForm ^4         |
| Aktive Entwicklung         | ❌ Nein               | ✅ Ja                            |
| Mehrsprachigkeit           | ✅ Ja                 | ✅ Ja                            |
| Backend-Sprachen           | ✅ Alle               | Bald                             |
| Eigene Feldtypen           | ❌ Nein               | ✅ Ja                            |
| HTML5-Feldtypen            | ❌ Nein               | ✅ Ja                            |
| YOrm-Dataset-Methoden      | ❌ Nein               | ✅ Ja                            |
| Darstellung                | ⚠️ In Sidebar         | ✅ Sidebar oder Tab              |
| Berücksichtigung aller EPs | ✅ Ja                 | ⚠️ In Arbeit                     |

### Was unterscheidet dieses Addon vom Core-Addon?

- Die Klasse `Article` und `Category` sind YOrm-Datasets. Du hast in deinem Code alle Features von YOrm zur Verfügung und kannst direkt loslegen.

### Die Einstellungsseite (in Arbeit)

1. Wähle zwischen der Darstellung der Metainfos in der Sidebar oder im Tab.
2. Wähle den Modus, ob Metainfos sprachunabhängig oder in allen Sprachen gepflegt werden können.

### Die Klasse `Article` - Meta-Infos für deine Artikel

### Die Klasse `Category` - Meta-Infos für deine Kategorien

## Weiterentwicklung unterstützen

Du möchtest dieses Addon weiterentwickeln oder hast Vorschläge für Verbesserungen? Autor*innen und die Community bedanken sich für deine Unterstützung!

Du hast folgende Möglichkeiten:

1. 🙏🏻 [Issues](https://github.com/alexplusde/structure_metainfo/issues) lösen und Pull Requests erstellen.
2. 💶 Projekt finanziell sponsoren: [GitHub Sponsors](https://github.com/alxndr-w) oder [Ko-fi](https://ko-fi.com/alxndr-w)

Damit wird auch die zukünftige Entwicklung dieses Addons gesichert.

## Lizenz

MIT Lizenz, siehe [LICENSE.md](https://github.com/alexplusde/dummy/blob/master/LICENSE.md)  

## Autoren

Friends of REDAXO

**Projekt-Lead**  
[Alexander Walther](https://github.com/alxndr-w)

- <https://www.alexplus.de>  
- <https://github.com/alexplusde>

## Credits
