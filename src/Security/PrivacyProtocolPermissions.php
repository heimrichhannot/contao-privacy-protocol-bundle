<?php

namespace HeimrichHannot\PrivacyProtocolBundle\Security;

use Contao\Controller;

class PrivacyProtocolPermissions
{
    public const USER_CAN_EDIT_ARCHIVE = 'contao_user.privacy_protocols';
    public const USER_CAN_CREATE_ARCHIVES = 'contao_user.privacy_protocolp.create';
    public const USER_CAN_DELETE_ARCHIVES = 'contao_user.privacy_protocolp.delete';

    public static function addDcaFields(array &$dca): void
    {
        $dca['config']['onload_callback'][] = static function () {
            Controller::loadLanguageFile('tl_user');
        };

        $dca['fields']['privacy_protocols'] = [
            'label'      => &$GLOBALS['TL_LANG']['tl_user']['privacy_protocols'],
            'exclude'    => true,
            'inputType'  => 'checkbox',
            'foreignKey' => 'tl_privacy_protocol_archive.title',
            'eval'       => ['multiple' => true],
            'sql'        => "blob NULL"
        ];

        $dca['fields']['privacy_protocolp'] = [
            'label'     => &$GLOBALS['TL_LANG']['tl_user']['privacy_protocolp'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'options'   => ['create', 'delete'],
            'reference' => &$GLOBALS['TL_LANG']['MSC'],
            'eval'      => ['multiple' => true],
            'sql'       => "blob NULL"
        ];
    }
}