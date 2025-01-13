<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use HeimrichHannot\PrivacyProtocolBundle\Security\Voter\PrivacyProtocolArchiveVoter;

$dca = &$GLOBALS['TL_DCA']['tl_user'];

/**
 * Palettes
 */

PaletteManipulator::create()
    ->addLegend('privacy_legend', 'amg_legend', PaletteManipulator::POSITION_AFTER, true)
    ->addField('privacy_protocols', 'privacy_legend', PaletteManipulator::POSITION_APPEND)
    ->addField('privacy_protocolp', 'privacy_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('extend', 'tl_user')
    ->applyToPalette('custom', 'tl_user');

/**
 * Fields
 */

PrivacyProtocolArchiveVoter::addDcaFields($dca);
