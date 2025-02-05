<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

use HeimrichHannot\PrivacyBundle\DataContainer\ProtocolEntryContainer;
use HeimrichHannot\PrivacyProtocolBundle\Protocol\ProtocolCmsScope;
use HeimrichHannot\PrivacyProtocolBundle\Protocol\ProtocolType;

$lang = &$GLOBALS['TL_LANG']['tl_privacy_protocol_entry'];

/*
 * Fields
 */
$lang['tstamp'][0] = 'Änderungsdatum';

// type & date
$lang['type'][0] = 'Typ';
$lang['type'][1] = 'In diesem Feld wird der Typ gespeichert.';
$lang['description'][0] = 'Beschreibung';
$lang['description'][1] = 'In diesem Feld wird eine Beschreibung gespeichert.';

// data
$lang['data'][0] = 'Daten';
$lang['data'][1] = 'In diesem Feld werden die Benutzerdaten gespeichert.';

// user
$lang['ip'][0] = 'IP-Adresse';
$lang['ip'][1] = 'In diesem Feld wird die IP-Adresse des Besuchers gespeichert.';
$lang['email'][0] = 'E-Mail-Adresse';
$lang['email'][1] = 'In diesem Feld wird die E-Mail-Adresse des Besuchers gespeichert.';
$lang['member'][0] = 'Mitglied';
$lang['member'][1] = 'In diesem Feld wird die ID des Mitglieds gespeichert.';
$lang['user'][0] = 'Benutzer';
$lang['user'][1] = 'In diesem Feld wird die ID des Benutzers gespeichert.';

// interaction
$lang['url'][0] = 'URL';
$lang['url'][1] = 'In diesem Feld wird die URL gespeichert, unter der die Interaktion stattgefunden hat.';
$lang['cmsScope'][0] = 'CMS-Modus';
$lang['cmsScope'][1] = 'In diesem Feld wird gespeichert, ob die Interaktion im Frontend oder im Backend stattgefunden hat.';
$lang['bundle'][0] = 'Bundle';
$lang['bundle'][1] = 'In diesem Feld wird gespeichert, in welchem Bundle die Interaktion stattgefunden hat.';
$lang['bundleVersion'][0] = 'Bundle-Version';
$lang['bundleVersion'][1] = 'In diesem Feld wird die Version des Bundles gespeichert.';
$lang['dataContainer'][0] = 'Tabelle';
$lang['dataContainer'][1] = 'In diesem Feld wird die Tabelle gespeichert, in der sich der Nutzer befand.';

$lang['additionalData'][0] = 'Zusätzliche Daten';
$lang['additionalData'][1] = 'In diesem Feld werden kontextabhängige zusätzliche Daten gespeichert.';
$lang['module'][0] = 'Modul';
$lang['module'][1] = 'In diesem Feld wird die ID des Moduls gespeichert.';
$lang['element'][0] = 'Inhaltselement';
$lang['element'][1] = 'In diesem Feld wird die ID des Inhaltselements gespeichert.';

// code
$lang['codeStacktrace'][0] = 'Stacktrace';
$lang['codeStacktrace'][1] = 'In diesem Feld wird der Stacktrace zur aufrufenden Funktion gespeichert.';

/*
 * Reference
 */
$lang['reference'] = [
    ProtocolType::FIRST_OPT_IN->value => 'Erstes Opt-In',
    ProtocolType::SECOND_OPT_IN->value => 'Zweites Opt-In',
    ProtocolType::FIRST_OPT_OUT->value => 'Erstes Opt-Out',
    ProtocolType::SECOND_OPT_OUT->value => 'Zweites Opt-Out',
    ProtocolType::OPT_IN->value => 'Opt-In',
    ProtocolType::OPT_OUT->value => 'Opt-Out',
    ProtocolType::CREATE->value => 'Datensatz erstellt',
    ProtocolType::UPDATE->value => 'Datensatz bearbeitet',
    ProtocolType::DELETE->value => 'Datensatz gelöscht',
    ProtocolCmsScope::BACKEND->value => 'Backend',
    ProtocolCmsScope::FRONTEND->value => 'Frontend',
];

/*
 * Legends
 */
$lang['type_date_legend'] = 'Typ und Zeitpunkt';
$lang['data_legend'] = 'Quelltext';
$lang['user_legend'] = 'Nutzer';
$lang['interaction_legend'] = 'Interaktion';
$lang['code_legend'] = 'Quelltext';

/*
 * Buttons
 */
$lang['new'] = ['Neuer Protokolleintrag', 'Protokolleintrag erstellen'];
$lang['edit'] = ['Protokolleintrag bearbeiten', 'Protokolleintrag ID %s bearbeiten'];
$lang['copy'] = ['Protokolleintrag duplizieren', 'Protokolleintrag ID %s duplizieren'];
$lang['delete'] = ['Protokolleintrag löschen', 'Protokolleintrag ID %s löschen'];
$lang['show'] = ['Protokolleintrag Details', 'Protokolleintrag-Details ID %s anzeigen'];
