<?php

use HeimrichHannot\PrivacyProtocolBundle\Protocol\ProtocolCmsScope;
use HeimrichHannot\PrivacyProtocolBundle\Protocol\ProtocolType;

$lang = &$GLOBALS['TL_LANG']['tl_privacy_protocol_entry'];

/**
 * Fields
 */
$lang['tstamp'] = ['Revision date', ''];

$lang['type'][0] = 'Type';
$lang['type'][1] = 'In this field the type is stored.';
$lang['description'][0] = 'Description';
$lang['description'][1] = 'In this field a description is stored.';
$lang['person'][0] = 'Person';
$lang['person'][1] = 'In this field the data of the executing person is stored.';
$lang['target'][0] = 'Target';
$lang['target'][1] = 'In this field the target of the interaction is stored.';
$lang['ip'][0] = 'IP address';
$lang['ip'][1] = 'In this field the IP address of the visitor is stored.';
$lang['url'][0] = 'URL';
$lang['url'][1] = 'In this field the URL is stored under which the interaction took place.';
$lang['cmsScope'][0] = 'CMS mode';
$lang['cmsScope'][1] = 'In this field it is stored whether the interaction took place in the frontend or in the backend.';
$lang['bundle'][0] = 'Bundle';
$lang['bundle'][1] = 'In this field it is stored in which bundle the interaction took place.';
$lang['bundleVersion'][0] = 'Bundle version';
$lang['bundleVersion'][1] = 'In this field the version of the bundle is stored.';
$lang['codeStacktrace'][0] = 'Stacktrace';
$lang['codeStacktrace'][1] = 'In this field the stacktrace to the calling function is stored.';

/**
 * Reference
 */
$lang['reference'] = [
    ProtocolType::FIRST_OPT_IN->value => 'First Opt-In',
    ProtocolType::SECOND_OPT_IN->value => 'Second Opt-In',
    ProtocolType::FIRST_OPT_OUT->value => 'First Opt-Out',
    ProtocolType::SECOND_OPT_OUT->value => 'Second Opt-Out',
    ProtocolType::OPT_IN->value => 'Opt-In',
    ProtocolType::OPT_OUT->value => 'Opt-Out',
    ProtocolType::CREATE->value => 'Record created',
    ProtocolType::UPDATE->value => 'Record edited',
    ProtocolType::DELETE->value => 'Record deleted',
    ProtocolCmsScope::BACKEND->value => 'Backend',
    ProtocolCmsScope::FRONTEND->value => 'Frontend',
];

/**
 * Legends
 */
$lang['interaction_legend'] = 'Interaction';
$lang['context_legend'] = 'Context';
$lang['code_legend'] = 'Code';

/**
 * Buttons
 */
$lang['new'] = ['New Protokolleintrag', 'Protokolleintrag create'];
$lang['edit'] = ['Edit Protokolleintrag', 'Edit Protokolleintrag ID %s'];
$lang['copy'] = ['Duplicate Protokolleintrag', 'Duplicate Protokolleintrag ID %s'];
$lang['delete'] = ['Delete Protokolleintrag', 'Delete Protokolleintrag ID %s'];
$lang['show'] = ['Protokolleintrag details', 'Show the details of Protokolleintrag ID %s'];
