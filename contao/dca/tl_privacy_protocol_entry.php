<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

use Contao\DC_Table;
use HeimrichHannot\PrivacyProtocolBundle\Protocol\ProtocolCmsScope;
use HeimrichHannot\PrivacyProtocolBundle\Protocol\ProtocolType;
use HeimrichHannot\UtilsBundle\Dca\AuthorField;
use HeimrichHannot\UtilsBundle\Dca\DateAddedField;

DateAddedField::register('tl_privacy_protocol_entry')
    ->setFlag(8)
    ->setSorting(true);
AuthorField::register('tl_privacy_protocol_entry')
    ->setEvalValue('mandatory', false)
;

$GLOBALS['TL_DCA']['tl_privacy_protocol_entry'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'ptable' => 'tl_privacy_protocol_archive',
        'notCopyable' => true,
        'doNotCopyRecords' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
            ],
        ],
    ],
    'list' => [
        'label' => [
            'fields' => ['id'],
            'format' => '%s',
        ],
        'sorting' => [
            'mode' => 4,
            'fields' => ['dateAdded DESC'],
            'headerFields' => ['title', 'addCodeProtocol'],
            'panelLayout' => 'filter;sort,search,limit',
        ],
        'global_operations' => [
            'all' => [
                'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href' => 'act=select',
                'class' => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();"',
            ],
        ],
        'operations' => [
            'edit' => [
                'label' => &$GLOBALS['TL_LANG']['tl_privacy_protocol_entry']['edit'],
                'href' => 'act=edit',
                'icon' => 'edit.svg',
            ],
            'show' => [
                'label' => &$GLOBALS['TL_LANG']['tl_privacy_protocol_entry']['show'],
                'href' => 'act=show',
                'icon' => 'show.svg',
            ],
        ],
    ],
    'palettes' => [
        '__selector__' => [],
        'default' =>
            '{interaction_legend},type,person,target,dateAdded,description;'.
            '{context_legend},author,url,cmsScope,bundle,bundleVersion,ip,module,element;'.
            '{user_legend},member,user;'.
            '{code_legend},codeStacktrace;',

//        'default' => '{type_date_legend},type,dateAdded,author;'
//            .'{data_legend},data,ip,email;'
//            .'{user_legend},member,user;'
//            .'{interaction_legend},url,cmsScope,bundle,bundleVersion,dataContainer,description,module,moduleName,moduleType,element,elementType;'.'{code_legend},codeFile,codeLine,codeFunction,codeStacktrace;',
    ],
    'fields' => [
        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],
        'pid' => [
            'foreignKey' => 'tl_privacy_protocol_archive.title',
            'sql' => "int(10) unsigned NOT NULL default '0'",
            'relation' => ['type' => 'belongsTo', 'load' => 'eager'],
        ],
        'tstamp' => [
            'label' => &$GLOBALS['TL_LANG']['tl_privacy_protocol_entry']['tstamp'],
            'eval' => ['rgxp' => 'datim'],
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'person' => [
            'inputType' => 'textarea',
            'eval' => [
                'readonly' => true,
                'decodeEntities' => true,
                'tl_class' => 'clr',
            ],
            'sql' => ['type' => 'blob', 'notnull' => false],
        ],
        'target' => [
            'inputType' => 'textarea',
            'eval' => [
                'readonly' => true,
                'decodeEntities' => true,
                'tl_class' => 'clr',
            ],
            'sql' => ['type' => 'blob', 'notnull' => false],
        ],






        'ip' => [
            'label' => &$GLOBALS['TL_LANG']['tl_privacy_protocol_entry']['ip'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['maxlength' => 64, 'tl_class' => 'w50', 'personalField' => true],
            'sql' => "varchar(64) NOT NULL default ''",
        ],
        'member' => [
            'exclude' => true,
            'inputType' => 'picker',
            'relation' => [
                'type' => 'hasOne',
                'load' => 'lazy',
                'table' => 'tl_member',
            ],
            'eval' => ['tl_class' => 'w50',],
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'user' => [
            'exclude' => true,
            'inputType' => 'picker',
            'relation' => [
                'type' => 'hasOne',
                'load' => 'lazy',
                'table' => 'tl_user',
            ],
            'eval' => ['tl_class' => 'w50',],
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        // interaction
        'url' => [
            'label' => &$GLOBALS['TL_LANG']['tl_privacy_protocol_entry']['url'],
            'exclude' => true,
            'search' => true,
            'inputType' => 'text',
            'eval' => ['tl_class' => 'w50'],
            'sql' => 'text NULL',
        ],
        'cmsScope' => [
            'exclude' => true,
            'filter' => true,
            'inputType' => 'select',
            'options_callback' => static function () {
                return ProtocolCmsScope::values();
            },
            'reference' => &$GLOBALS['TL_LANG']['tl_privacy_protocol_entry']['reference'],
            'eval' => ['tl_class' => 'w50', 'mandatory' => true, 'submitOnChange' => true, 'includeBlankOption' => true],
            'sql' => "varchar(16) NOT NULL default ''",
        ],
        'bundle' => [
            'label' => &$GLOBALS['TL_LANG']['tl_privacy_protocol_entry']['bundle'],
            'exclude' => true,
            'filter' => true,
            'inputType' => 'text',
            'eval' => ['maxlength' => 64, 'tl_class' => 'w50'],
            'sql' => "varchar(64) NOT NULL default ''",
        ],
        'bundleVersion' => [
            'label' => &$GLOBALS['TL_LANG']['tl_privacy_protocol_entry']['bundleVersion'],
            'exclude' => true,
            'inputType' => 'text',
            'eval' => ['maxlength' => 64, 'tl_class' => 'w50'],
            'sql' => "varchar(64) NOT NULL default ''",
        ],
        'type' => [
            'exclude' => true,
            'filter' => true,
            'inputType' => 'select',
            'options_callback' => static function () {
                return ProtocolType::values();
            },
            'reference' => &$GLOBALS['TL_LANG']['tl_privacy_protocol_entry']['reference'],
            'eval' => ['tl_class' => 'w50', 'mandatory' => true, 'includeBlankOption' => true, 'chosen' => true],
            'sql' => "varchar(32) NOT NULL default ''",
        ],
        'description' => [
            'exclude' => true,
            'search' => true,
            'inputType' => 'textarea',
            'eval' => ['tl_class' => 'long clr'],
            'sql' => 'text NULL',
        ],
        'module' => [
            'exclude' => true,
            'inputType' => 'picker',
            'relation'   => [
                'type' => 'belongsTo',
                'load' => 'lazy',
                'table' => 'tl_content',
            ],
            'eval' => ['tl_class' => 'w50', 'includeBlankOption' => true, 'submitOnChange' => true],
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'element' => [
            'exclude' => true,
            'inputType' => 'picker',
            'relation'   => [
                'type' => 'belongsTo',
                'load' => 'lazy',
                'table' => 'tl_content',
            ],
            'eval' => ['tl_class' => 'w50', 'includeBlankOption' => true, 'submitOnChange' => true],
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'codeStacktrace' => [
            'exclude' => true,
            'inputType' => 'textarea',
            'eval' => ['class' => 'monospace', 'tl_class' => 'clr', 'rte' => 'ace', 'codeField' => true],
            'sql' => 'text NULL',
        ],
    ],
];

//\HeimrichHannot\Haste\Dca\General::addAuthorFieldAndCallback('tl_privacy_protocol_entry');
//
//if (class_exists('\HeimrichHannot\ContaoExporterBundle\HeimrichHannotContaoExporterBundle')) {
//    $backendExportAction = System::getContainer()->get('huh.exporter.action.backendexport');
//
//    $GLOBALS['TL_DCA']['tl_privacy_protocol_entry']['list']['global_operations']['export_csv'] = $backendExportAction->getGlobalOperation(
//        'export_csv',
//        $GLOBALS['TL_LANG']['MSC']['export_csv']
//    );
//    $GLOBALS['TL_DCA']['tl_privacy_protocol_entry']['list']['global_operations']['export_xls'] = $backendExportAction->getGlobalOperation(
//        'export_xls',
//        $GLOBALS['TL_LANG']['MSC']['export_xls']
//    );
//}
