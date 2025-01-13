<?php

namespace HeimrichHannot\PrivacyProtocolBundle\Security\Voter;

use Contao\Controller;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PrivacyProtocolArchiveVoter extends Voter
{

    protected function supports(string $attribute, $subject)
    {
        // TODO: Implement supports() method.
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        // TODO: Implement voteOnAttribute() method.
    }

    public static function addDcaFields(array &$dca): void
    {
        $dca['config']['ondelete_callback'][] = static function () {
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