<?php

namespace HeimrichHannot\PrivacyProtocolBundle\EventListener\Hooks;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use HeimrichHannot\UtilsBundle\Util\Utils;

#[AsHook('initializeSystem')]
class InitializeSystemListener
{
    public function __construct(
        private readonly Utils $utils,
    ) {
    }

    public function __invoke(): void
    {
        if ($this->utils->container()->isBackend()) {
            $GLOBALS['TL_CSS']['contao-privacy-protocol-bundle'] = 'bundles/heimrichhannotprivacyprotocol/css/backend.css';
        }
    }
}
