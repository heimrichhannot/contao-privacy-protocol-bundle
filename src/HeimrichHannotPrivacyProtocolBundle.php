<?php

namespace HeimrichHannot\PrivacyProtocolBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HeimrichHannotPrivacyProtocolBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
