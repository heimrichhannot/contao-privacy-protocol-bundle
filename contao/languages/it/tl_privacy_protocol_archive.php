<?php

$lang = &$GLOBALS['TL_LANG']['tl_privacy_protocol_archive'];

/*
 * Fields
 */
$lang['tstamp'][0] = 'Data della modifica';
$lang['title'][0] = 'Titolo';
$lang['title'][1] = 'Inserire un titolo.';
$lang['titlePattern'][0] = 'Pattern dell\'intestazione';
$lang['titlePattern'][1] = 'Inserire un modello per il titolo delle voci di log nel formato "##type## ##field1## ##field2##". È possibile utilizzare <a href="https://docs.contao.org/manual/en/article-management/simple-tokens/" target="_blank">Simple Tokens</a>.';
$lang['skipIpAnonymization'][0] = 'Non anonimizzare l\'indirizzo IP';
$lang['skipIpAnonymization'][1] = 'Selezionare quest\'opzione se non volete anonimizzare l\'indirizzo IP.';
$lang['addCodeProtocol'][0] = 'Registra i dati relativi all\'origine';
$lang['addCodeProtocol'][1] = 'Seleziona questa opzione per acquisire i dati relativi all\'origine.';

/*
 * Legends
 */
$lang['general_legend'] = 'Titolo';
$lang['config_legend'] = 'Configurazione';

/*
 * Buttons
 */
$lang['new'] = ['Nuovo archivio di log', 'Crea archivio di log'];
$lang['edit'] = ['Modifica archivio di log', 'Modifica l\'archivio di log con ID %s'];
$lang['children'] = ['Mostra voci', 'Mostra le voci dell\'archivio di log con ID %s'];
$lang['delete'] = ['Cancella archivio di log', 'Cancella l\'archivio di log con ID %s'];
$lang['show'] = ['Dettagli archivio di log', 'Mostra i dettagli dell\'archivio di log con ID %s'];
