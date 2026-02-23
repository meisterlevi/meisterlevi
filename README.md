# ShieldKids – Open-Source Plattform zum Schutz von Kindern vor digitaler Gewalt

ShieldKids ist eine **kostenfreie, Open-Source Plattform**, die Eltern und Erziehungsberechtigte dabei unterstützt, Risiken in den digitalen Unterhaltungen ihrer Kinder frühzeitig zu erkennen – z. B.:

- Cybergrooming
- Mobbing / Cyberbullying
- Belästigung und sexuelle Grenzüberschreitungen
- Erpressung / Manipulation

> Ziel: **Schutz statt Überwachung** – mit Privacy-by-Design, Transparenz und klaren Einwilligungsregeln.

---

## Vision

Kinder sollen digitale Räume sicher nutzen können. Eltern brauchen dafür ein Werkzeug, das:

1. Risiken automatisiert erkennt,
2. nachvollziehbare Warnungen liefert,
3. datensparsam arbeitet,
4. Open Source und kostenlos bleibt.

---

## Produktidee (MVP)

### 1) Eltern-App (Desktop/Mobile)
- Einrichtung eines Familienkontos
- Verwaltung von Kinder-Geräten
- Einsicht in Sicherheitsmeldungen
- Eskalationsstufen (Info, Warnung, kritisch)

### 2) Kinder-Geräte-Connector
- Lokale Analyse von Nachrichteninhalten (on-device, wenn möglich)
- Unterstützung für ausgewählte Plattformen über erlaubte Schnittstellen
- Kein permanentes Spiegeln aller Chats in die Cloud

### 3) Risiko-Engine
- Klassifikation typischer Gefahrenmuster:
  - Grooming-Signale (z. B. Geheimhaltung, Alters-/Machtgefälle, Druckaufbau)
  - Mobbing-Sprache (Herabwürdigung, Ausgrenzung, Drohungen)
  - sexuelle Belästigung / Nötigung
- Kontextbewertung statt nur Keyword-Matching
- Mehrsprachige Modelle (Start mit Deutsch/Englisch)

### 4) Eltern-Benachrichtigung
- Nur bei relevanten Risiken ein Alert
- Kompakte Erklärung: *Was wurde erkannt und warum?*
- Empfohlene nächste Schritte (Gespräch, Beratung, Notfallkontakt)

---

## Leitprinzipien

### Datenschutz & Ethik
- **Datensparsamkeit**: So wenig Daten wie möglich, so lokal wie möglich
- **Einwilligung & Transparenz**: klare Kommunikation gegenüber Eltern und Kindern
- **Erklärbare Ergebnisse**: keine Blackbox-Warnungen
- **Sichere Speicherung**: Ende-zu-Ende-Verschlüsselung, kurze Retention

### Rechtliche Anforderungen (DACH/EU)
- DSGVO-konformes Design
- besondere Sorgfalt bei Daten von Minderjährigen
- länderspezifische Prüfung zu Elternrechten, Jugendschutz und Fernmeldegeheimnis

> Wichtig: Das Projekt benötigt früh juristische Begleitung, um rechtskonform zu bleiben.

---

## Technischer Vorschlag

### Architektur (high-level)
- **Client-Agent** auf Kindergerät (plattformspezifisch)
- **Policy + Risk Service** (regelbasiert + ML)
- **Eltern-Dashboard**
- **Audit/Logging-Service** (privacy-konform)

### Möglicher Stack
- Backend: TypeScript (NestJS/Fastify) oder Go
- ML-Service: Python (Transformers + moderationsspezifische Klassifikatoren)
- App: Flutter oder React Native
- Speicherung: PostgreSQL + verschlüsselte Felder
- Messaging: eventbasiert (z. B. NATS/Kafka)

---

## Entwicklungs-Roadmap

### Phase 0 – Discovery (2–4 Wochen)
- Probleminterviews mit Eltern, Pädagog:innen, Beratungsstellen
- Threat-Modeling & Abuse-Case-Katalog
- Rechtliche Vorprüfung

### Phase 1 – MVP (6–10 Wochen)
- Elternkonto + Geräteanbindung
- Erste Risiko-Engine (Grooming/Bullying)
- Alerting mit nachvollziehbaren Begründungen
- Pilot mit Testdaten

### Phase 2 – Sicherheit & Qualität
- Red-Teaming gegen False Positives/Negatives
- Bias- und Fairness-Tests
- Security Audit

### Phase 3 – Community & Open Source
- Governance-Modell (Maintainer, RFC-Prozess)
- Contributor Guide
- Öffentliche Modell-Evaluationen

---

## Open-Source-Setup

- Lizenzvorschlag: **AGPLv3** (starker Copyleft-Schutz) oder **Apache-2.0** (breitere Unternehmensadoption)
- Public Roadmap & Issues
- Security Policy + Responsible Disclosure
- Klare Trennung zwischen:
  - Kernplattform (Open Source)
  - optionalen gehosteten Services (falls später nötig)

---

## Risiken & Gegenmaßnahmen

- **False Positives** → erklärbare Scores, menschliche Prüfung, Feedback-Loop
- **False Negatives** → laufendes Retraining, Kombination aus Regeln + ML
- **Missbrauch als Überwachungstool** → klare Policy, Schutzmechanismen, eingeschränkte Einsichtstiefe
- **Plattform-Limitierungen (Instagram etc.)** → nur legale/technisch stabile Integrationen

---

## Nächste konkrete Schritte

1. Ein kurzes Produkt-Manifest verfassen (Zielgruppe, Nicht-Ziele, Werte)
2. Juristische Machbarkeitsprüfung für DACH priorisieren
3. MVP-Scope auf 1–2 Plattformen begrenzen
4. Testdatenset + Evaluationsmetriken definieren
5. Repository-Struktur aufsetzen (`apps/`, `services/`, `docs/`)

---

## Hinweis

Dieses Projekt ist als Schutz- und Präventionswerkzeug gedacht und ersetzt keine professionelle Beratung oder akute Notfallhilfe. Bei konkreter Gefährdung sollten lokale Beratungsstellen oder Behörden eingeschaltet werden.
