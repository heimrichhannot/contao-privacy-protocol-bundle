<?php

namespace HeimrichHannot\PrivacyProtocolBundle\DataContainer;

use Contao\DataContainer;
use Symfony\Component\Security\Core\Security;

class PrivacyProtocolArchiveContainer
{
    public function __construct(
        protected readonly Security $security,
    )
    {
    }

    public function onConfigLoadCallback(?DataContainer $dc = null): void
    {
        $this->checkPermissions();
    }

    protected function checkPermissions(): void
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return;
        }

        // Set root IDs
        if (!\is_array($user->privacy_protocols) || empty($user->privacy_protocols)) {
            $root = [0];
        } else {
            $root = $user->privacy_protocols;
        }

        $GLOBALS['TL_DCA']['tl_privacy_protocol_archive']['list']['sorting']['root'] = $root;

        // Check permissions to add archives
        if (!$user->hasAccess('create', 'privacy_protocolp')) {
            $GLOBALS['TL_DCA']['tl_privacy_protocol_archive']['config']['closed'] = true;
        }
    }
}