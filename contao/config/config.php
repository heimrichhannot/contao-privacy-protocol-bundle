<?php

/**
 * Backend modules.
 */

use HeimrichHannot\PrivacyProtocolBundle\Model\PrivacyProtocolArchiveModel;
use HeimrichHannot\PrivacyProtocolBundle\Model\PrivacyProtocolEntryModel;
use HeimrichHannot\UtilsBundle\StaticUtil\SUtils;

$beModules = &$GLOBALS['BE_MOD'];
SUtils::array()::insertBeforeKey(
    $beModules,
    'system',
    'privacy',
    [
    ]);

$GLOBALS['BE_MOD']['privacy']['protocols'] = [
    'tables' => ['tl_privacy_protocol_archive', 'tl_privacy_protocol_entry'],
];

// if (class_exists('\HeimrichHannot\ContaoExporterBundle\HeimrichHannotContaoExporterBundle')) {
//    $GLOBALS['BE_MOD']['privacy']['protocols']['export_csv'] = ['huh.exporter.action.backendexport', 'export'];
//    $GLOBALS['BE_MOD']['privacy']['protocols']['export_xls'] = ['huh.exporter.action.backendexport', 'export'];
// }

/*
 * Models
 */
$GLOBALS['TL_MODELS']['tl_privacy_protocol_archive'] = PrivacyProtocolArchiveModel::class;
$GLOBALS['TL_MODELS']['tl_privacy_protocol_entry'] = PrivacyProtocolEntryModel::class;

/*
 * Permissions
 */
$GLOBALS['TL_PERMISSIONS'][] = 'privacy_protocols';
$GLOBALS['TL_PERMISSIONS'][] = 'privacy_protocolp';
