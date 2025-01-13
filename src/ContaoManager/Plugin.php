<?php

namespace HeimrichHannot\PrivacyProtocolBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use HeimrichHannot\PrivacyProtocolBundle\HeimrichHannotPrivacyProtocolBundle;

class Plugin implements BundlePluginInterface
{

    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(HeimrichHannotPrivacyProtocolBundle::class)
            ->setLoadAfter([
                ContaoCoreBundle::class,
            ])
        ];
    }
}