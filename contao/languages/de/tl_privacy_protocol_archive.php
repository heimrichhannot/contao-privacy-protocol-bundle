<?php

$lang = &$GLOBALS['TL_LANG']['tl_privacy_protocol_archive'];

/**
 * Fields
 */
$lang['tstamp'][0] = 'Änderungsdatum';
$lang['title'][0] = 'Titel';
$lang['title'][1] = 'Geben Sie hier bitte den Titel ein.';
$lang['titlePattern'][0] = 'Titelmuster';
$lang['titlePattern'][1] = 'Geben Sie hier ein Muster für die Titel der Protokolleinträge in der Form "##type## ##field1## ##field2##" ein. Es können <a href="https://docs.contao.org/manual/de/artikelverwaltung/simple-tokens/" target="_blank">Simple Tokens</a> verwendet werden.';
$lang['skipIpAnonymization'][0] = 'IP-Adressen NICHT anonymisieren';
$lang['skipIpAnonymization'][1] = 'Wählen Sie diese Option, wenn IP-Adressen NICHT anonymisiert werden sollen.';
$lang['addCodeProtocol'][0] = 'Quelltextbezogene Daten erfassen';
$lang['addCodeProtocol'][1] = 'Wählen Sie diese Option, um quelltextbezogene Daten zu erfassen.';

/**
 * Legends
 */
$lang['general_legend'] = 'Titel';
$lang['config_legend'] = 'Konfiguration';

/**
 * Buttons
 */
$lang['new'] = ['Neues Protokollarchiv', 'Protokollarchiv erstellen'];
$lang['edit'] = ['Protokollarchiv bearbeiten', 'Protokollarchiv ID %s bearbeiten'];
$lang['children'] = ['Einträge ansehen', 'Einträge von Protokollarchiv ID %s ansehen'];
$lang['delete'] = ['Protokollarchiv löschen', 'Protokollarchiv ID %s löschen'];
$lang['show'] = ['Protokollarchiv Details', 'Protokollarchiv-Details ID %s anzeigen'];