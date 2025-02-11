<?php

use HeimrichHannot\PrivacyProtocolBundle\Protocol\ProtocolCmsScope;
use HeimrichHannot\PrivacyProtocolBundle\Protocol\ProtocolType;

$lang = &$GLOBALS['TL_LANG']['tl_privacy_protocol_entry'];

/*
 * Fields
 */
$lang['tstamp'][0] = 'Data della modifica';
$lang['type'][0] = 'Tipo';
$lang['type'][1] = 'In questo campo va specificato il tipo.';
$lang['description'][0] = 'Descrizione';
$lang['description'][1] = 'In questo campo viene registrata una descrizione.';
$lang['dateAdded'][0] = 'Data aggiunta';
$lang['dateAdded'][1] = 'In questo campo va specificata la data in cui l\'interazione ha avuto luogo.';
$lang['person'][0] = 'Persona';
$lang['person'][1] = 'In questo campo vengono memorizzati i dati della persona che ha eseguito l\'azione.';
$lang['target'][0] = 'Obiettivo';
$lang['target'][1] = 'In questo campo viene memorizzato l\'obiettivo dell\'interazione.';

$lang['ip'][0] = 'Indirizzo IP';
$lang['ip'][1] = 'In questo campo verrà memorizzato l\'indirizzo IP del visitatore.';
$lang['url'][0] = 'URL';
$lang['url'][1] = 'In questo campo viene registra l\'URL attraverso la quale cui è avvenuta l\'interazione.';
$lang['cmsScope'][0] = 'Modalità CMS';
$lang['cmsScope'][1] = 'In questo campo viene registrato se l\'interazione è avvenuta tramite il frontend o il backend.';
$lang['bundle'][0] = 'Pacchetto';
$lang['bundle'][1] = 'Questo campo registra il pacchetto in cui è avvenuta l\'interazione.';
$lang['bundleVersion'][0] = 'Versione pacchetto';
$lang['bundleVersion'][1] = 'In questo campo viene registrata la versione del pacchetto.';
$lang['codeStacktrace'][0] = 'Stack trace';
$lang['codeStacktrace'][1] = 'In questo campo viene memorizzata la traccia dello stack della funzione chiamante.';

/*
 * Reference
 */
$lang['reference'] = [
    ProtocolType::FIRST_OPT_IN->value => 'Primo Opt-In',
    ProtocolType::SECOND_OPT_IN->value => 'Secondo Opt-In',
    ProtocolType::FIRST_OPT_OUT->value => 'Primo Opt-Out',
    ProtocolType::SECOND_OPT_OUT->value => 'Secondo Opt-Out',
    ProtocolType::OPT_IN->value => 'Opt-In',
    ProtocolType::OPT_OUT->value => 'Opt-Out',
    ProtocolType::CREATE->value => 'Record creato',
    ProtocolType::UPDATE->value => 'Record modificato',
    ProtocolType::DELETE->value => 'Recorn eliminato',
    ProtocolCmsScope::BACKEND->value => 'Backend',
    ProtocolCmsScope::FRONTEND->value => 'Frontend',
];

/*
 * Legends
 */
$lang['interaction_legend'] = 'Interazione';
$lang['context_legend'] = 'Contesto';
$lang['code_legend'] = 'Codice sorgente';

/*
 * Buttons
 */
$lang['new'] = ['Nuova voce di log', 'Creazione della voce di log'];
$lang['edit'] = ['Modifica di una voce di log', 'Modifica della voce di log con ID %s'];
$lang['copy'] = ['Duplicazione di una voce di log', 'Duplicazione della voce di log con ID %s'];
$lang['delete'] = ['Cancellazione di una voce di log', 'Cancellazione della voce di log con ID %s'];
$lang['show'] = ['Dettagli della voce di log', 'Mostra i dettagli della voce di log con ID %s'];
