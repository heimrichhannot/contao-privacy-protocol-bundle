<?php

namespace HeimrichHannot\PrivacyProtocolBundle\Protocol;

enum ProtocolCmsScope: string
{
    case BACKEND = 'BE';
    case FRONTEND = 'FE';
}
