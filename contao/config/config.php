<?php

/**
 * Backend modules
 */

$GLOBALS['BE_MOD']['privacy']['protocols'] = [
    'tables' => ['tl_privacy_protocol_archive', 'tl_privacy_protocol_entry'],
];

//if (class_exists('\HeimrichHannot\ContaoExporterBundle\HeimrichHannotContaoExporterBundle')) {
//    $GLOBALS['BE_MOD']['privacy']['protocols']['export_csv'] = ['huh.exporter.action.backendexport', 'export'];
//    $GLOBALS['BE_MOD']['privacy']['protocols']['export_xls'] = ['huh.exporter.action.backendexport', 'export'];
//}

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_privacy_protocol_archive'] = 'HeimrichHannot\PrivacyBundle\Model\ProtocolArchiveModel';
$GLOBALS['TL_MODELS']['tl_privacy_protocol_entry']   = 'HeimrichHannot\PrivacyBundle\Model\ProtocolEntryModel';

/**
 * Permissions
 */
$GLOBALS['TL_PERMISSIONS'][] = 'privacy_protocols';
$GLOBALS['TL_PERMISSIONS'][] = 'privacy_protocolp';
