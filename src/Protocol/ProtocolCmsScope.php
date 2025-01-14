<?php

namespace HeimrichHannot\PrivacyProtocolBundle\Protocol;

enum ProtocolCmsScope: string
{
    case BACKEND = 'BE';
    case FRONTEND = 'FE';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
