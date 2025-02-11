<?php

/*
 * Copyright (c) 2023 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

use Contao\DC_Table;

$GLOBALS['TL_DCA']['tl_privacy_protocol_archive'] = [
    'config' => [
        'dataContainer' => DC_Table::class,
        'ctable' => ['tl_privacy_protocol_entry'],
        'switchToEdit' => true,
        'enableVersioning' => true,
        'sql' => [
            'keys' => [
                'id' => 'primary',
            ],
        ],
    ],
    'list' => [
        'label' => [
            'fields' => ['title'],
            'format' => '%s',
        ],
        'sorting' => [
            'mode' => 1,
            'fields' => ['title'],
            'headerFields' => ['title'],
            'panelLayout' => 'filter;search,limit',
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
                'href' => 'act=edit',
                'icon' => 'edit.svg',
            ],
            'children' => [
                'href' => 'table=tl_privacy_protocol_entry',
                'icon' => 'bundles/heimrichhannotprivacyprotocol/img/children.svg',
            ],
            'delete' => [
                'href' => 'act=delete',
                'icon' => 'delete.svg',
                'attributes' => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null)
                    . '\'))return false;Backend.getScrollOffset()"',
            ],
            'show' => [
                'href' => 'act=show',
                'icon' => 'show.svg',
            ],
        ],
    ],
    'palettes' => [
        'default' => '{general_legend},title;{config_legend},titlePattern,addCodeProtocol,skipIpAnonymization;',
    ],
    'fields' => [
        'id' => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],
        'tstamp' => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'title' => [
            'exclude' => true,
            'search' => true,
            'sorting' => true,
            'flag' => 1,
            'inputType' => 'text',
            'eval' => [
                'mandatory' => true,
                'tl_class' => 'w50',
            ],
            'sql' => "varchar(255) NOT NULL default ''",
        ],
        'titlePattern' => [
            'exclude' => true,
            'inputType' => 'text',
            'default' => '##type## - ##email## {if description != ""}(##description##){endif}',
            'eval' => [
                'maxlength' => 128,
                'tl_class' => 'w100',
                'mandatory' => true,
                'decodeEntities' => true,
            ],
            'sql' => "varchar(128) NOT NULL default ''",
        ],
        'skipIpAnonymization' => [
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'tl_class' => 'w50',
            ],
            'sql' => "char(1) NOT NULL default ''",
        ],
        'addCodeProtocol' => [
            'exclude' => true,
            'inputType' => 'checkbox',
            'eval' => [
                'tl_class' => 'w50 clr',
            ],
            'sql' => "char(1) NOT NULL default ''",
        ],
    ],
];
