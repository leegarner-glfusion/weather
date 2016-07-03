<?php
/**
*   Default Dutch language file for the Weather plugin
*
*   @author     Eric Starkenburg <zilverballs@home.nl>
*   @copyright  Copyright (c) 2011 Lee Garner <lee@leegarner.com>
*   @package    weather
*   @version    0.1.0
*   @license    http://opensource.org/licenses/gpl-2.0.php 
*               GNU Public License v2 or later
*   @filesource
*/

$LANG_WEATHER = array(
'pi_title'      => 'Weerbericht',
'curr_cond_for' => 'Actuele weersomstandigheden',
'search_instr'  => 'Zoeken op Postcode geeft het beste resultaat.',
'rem_this_item' => 'Verwijder dit Item',
);

$PLG_weather_MESSAGE1 = 'De gevraagde locatie is niet gevonden.';

$LANG_configsubgroups['weather'] = array(
    'sg_main'               => 'Hoofd Instellingen',
);

$LANG_fs['weather'] = array(
    'fs_main'               => 'Algemene Instellingen',
);

$LANG_configsections['weather'] = array(
    'label'                 => 'Weerbericht',
    'title'                 => 'Weerbericht Instellingen'
);

$LANG_confignames['weather'] = array(
    'anon_access'       => 'Anonieme Bezoekers',
    'displayblocks'     => 'Toon glFusion Blokken',
    'cache_minutes'     => 'Aantal minuten om weerbericht gegevens te cachen',
    'default_loc'       => 'Standaard Locatie',
    'blk_show_loc'      => 'Toon Locatie in PHP blok',
    'usermenu_option'   => 'Toon de Plugin in het "Plugins" menu?',
);

$LANG_configselects['weather'] = array(
    0   => array(   'Ja' => 1, 'Nee' => 0),
    1   => array(   'Ja' => 1, 'Nee' => 0),
    2   => array(   'Geen' => 0,
                    'Bekijken'  => 1,
                    'Bekijken & Zoeken' => 2,
            ),
    3   => array(   'Alleen de standaard Locatie' => 1,
                    'Alleen persoonlijk, indien beschikbaar' => 2,
                    'Persoonlijk, terugvallen op standaard' => 3,
            ),
    13  => array(   'Linker Blokken' => 1, 
                    'Rechter Blokken' => 2, 
                    'Linker & Rechter Blokken' => 3, 
                    'Geen' => 0,
            ),
);

?>