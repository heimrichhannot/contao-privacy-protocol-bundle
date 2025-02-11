<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use HeimrichHannot\PrivacyProtocolBundle\Security\PrivacyProtocolPermissions;

$dca = &$GLOBALS['TL_DCA']['tl_user_group'];

/*
 * Palettes
 */
PaletteManipulator::create()
    ->addLegend('privacy_legend', 'amg_legend')
    ->addField(['privacy_protocols', 'privacy_legend'], 'privacy_legend', PaletteManipulator::POSITION_APPEND)
    ->addField(['privacy_protocolp', 'privacy_legend'], 'privacy_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', 'tl_user_group');

/*
 * Fields
 */
PrivacyProtocolPermissions::addDcaFields($dca);
