<?php
/**
*   Database installation for the Weather plugin.
*
*   @author     Lee Garner <lee@leegarner.com>
*   @copyright  Copyright (c) 2011 Lee Garner <lee@leegarner.com>
*   @package    weather
*   @version    0.1.0
*   @license    http://opensource.org/licenses/gpl-2.0.php 
*               GNU Public License v2 or later
*   @filesource
*/

$_SQL = array(
    // Create the cache table
    'weather_cache' => "CREATE TABLE {$_TABLES['weather_cache']} (
        `location` varchar(255) NOT NULL,
        `uid` int(11) NOT NULL DEFAULT '0',
        `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `data` text,
        PRIMARY KEY (`location`)
        )",
);
?>