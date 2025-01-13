<?php

use HeimrichHannot\PrivacyProtocolBundle\Security\Voter\PrivacyProtocolArchiveVoter;

$dca = &$GLOBALS['TL_DCA']['tl_user_group'];

/**
 * Palettes
 */
$dca['palettes']['default'] = str_replace('fop;', 'fop;{privacy_legend},privacy_protocols,privacy_protocolp;', $dca['palettes']['default']);

/**
 * Fields
 */
PrivacyProtocolArchiveVoter::addDcaFields($dca);