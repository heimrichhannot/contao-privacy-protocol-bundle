<?php

/*
 * Copyright (c) 2021 Heimrich & Hannot GmbH
 *
 * @license LGPL-3.0-or-later
 */

namespace HeimrichHannot\PrivacyProtocolBundle\Model;

use Contao\Model;

/**
 * @property int $id
 * @property int $tstamp
 * @property int $pid
 * @property string $type
 * @property int $dateAdded
 */
class PrivacyProtocolEntryModel extends Model
{
    protected static $strTable = 'tl_privacy_protocol_entry';
}
