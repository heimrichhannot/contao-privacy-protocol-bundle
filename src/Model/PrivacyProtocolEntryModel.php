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
 * @property int $dateAdded
 * @property string $type
 * @property string $person
 * @property string $target
 * @property string $description
 * @property string $codeStacktrace
 * @property string $cmsScope
 * @property string $ip
 * @property string $url
 * @property string $bundle
 * @property string bundleVersion
 *
 */
class PrivacyProtocolEntryModel extends Model
{
    protected static $strTable = 'tl_privacy_protocol_entry';
}
