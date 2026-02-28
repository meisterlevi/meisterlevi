# LH ADHS/Autismus Planer

WordPress-Plugin für `lh-ergotherapie.de`.

## Installation
1. Ordner `lh-adhs-autismus-planer` nach `/wp-content/plugins/` kopieren.
2. Plugin **LH ADHS/Autismus Planer** im WordPress-Backend aktivieren.
3. Shortcode `[lh_planer]` auf einer Seite einfügen.

## Verwendung
- Der Shortcode rendert ein Multi-Step Formular (5 Schritte).
- Nach dem Submit wird die Druckansicht unterhalb des Formulars erzeugt.
- Über den Button **Drucken / als PDF speichern** wird `window.print()` ausgelöst.

## Datenschutz
- Es erfolgt **keine Speicherung** von Eingaben in Datenbank, Optionen oder Logs.
- Keine externen APIs, keine Tracker.
- Eingaben bleiben im aktuellen Request und werden nur für die Ausgabe der Druckansicht verwendet.

## Sicherheit
- Formular ist mit WordPress Nonce geschützt.
- Eingaben werden mit `sanitize_text_field` / `sanitize_key` bereinigt.
- Ausgabe erfolgt escaped (`esc_html`, `esc_attr`) bzw. bei markupsicherem Kontext via `wp_kses_post`.
