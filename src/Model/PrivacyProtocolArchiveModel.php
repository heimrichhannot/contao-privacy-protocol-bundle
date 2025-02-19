<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\PrivacyProtocolBundle\Model;

use Contao\Model;

/**
 * @property int         $id
 * @property int         $tstamp
 * @property string      $title
 * @property string      $titlePattern
 * @property bool|string $addCodeProtocol
 * @property bool|string $skipIpAnonymization
 */
class PrivacyProtocolArchiveModel extends Model
{
    protected static $strTable = 'tl_privacy_protocol_archive';
}
