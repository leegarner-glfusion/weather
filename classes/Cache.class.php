<?php
/**
*   Class to cache weather lookup results
*
*   @author     Lee Garner <lee@leegarner.com>
*   @copyright  Copyright (c) 2018 Lee Garner <lee@leegarner.com>
*   @package    weather
*   @version    1.1.4
*   @since      1.1.4
*   @license    http://opensource.org/licenses/gpl-2.0.php
*               GNU Public License v2 or later
*   @filesource
*/
namespace Weather;

/**
*   Class for Weatner Cache
*   @package weather
*/
class Cache
{
    const TAG = 'weather';
    const MIN_GVERSION = '2.0.0';

    /**
    *   Update the cache.
    *   Adds an array of tags including the plugin name
    *
    *   @param  string  $key    Item key
    *   @param  mixed   $data   Data, typically an array
    *   @param  mixed   $tag    Tag, or array of tags.
    *   @param  integer $cache_mins Cache minutes
    */
    public static function set($key, $data, $tag='', $cache_mins=0)
    {
        global $_CONF_WEATHER;

        // Debugging tool to skip cache usage
        if (isset($_CONF_WEATHER['nocache'])) return;

        // Set cache minutes if not provided, and make sure it's reasonable.
        if ($cache_mins == 0) {
            $cache_mins = (int)$_CONF_WEATHER['cache_minutes'];
        }
        if ($cache_mins < 10) $cache_mins = 30;
 
        if (version_compare(GVERSION, self::MIN_GVERSION, '<')) {
            global $_TABLES, $_USER;

           $data = DB_escapeString(serialize(API::_sanitize($data)));
            $db_loc = self::_makeCacheKey($loc);

            // Delete any stale entries and the current location to be replaced
            // cache_minutes is already sanitized as an intgeger
            DB_query("DELETE FROM {$_TABLES['weather_cache']}
                        WHERE ts < NOW() - INTERVAL $cache_mins MINUTE
                        OR location = '$db_loc'");

            // Insert the new record to be cached
            DB_query("INSERT INTO {$_TABLES['weather_cache']}
                            (location, uid, data)
                        VALUES
                            ('$db_loc', '{$_USER['uid']}', '$data')");
        } else {
            $ttl = (int)$cache_mins * 60;   // convert to seconds
            // Always make sure the base tag is included
            $tags = array(self::TAG);
            if (!empty($tag)) {
                if (!is_array($tag)) $tag = array($tag);
                $tags = array_merge($tags, $tag);
            }
            $key = self::makeKey($key);
            \glFusion\Cache::getInstance()->set($key, $data, $tags, $ttl);
        }
    }


    /**
    *   Delete a single item from the cache by key
    *
    *   @param  string  $key    Base key, e.g. item ID
    */
    public static function delete($key)
    {
        if (version_compare(GVERSION, self::MIN_GVERSION, '<')) {
            return;     // glFusion version doesn't support caching
        }
        $key = self::makeKey($key);
        \glFusion\Cache::getInstance()->delete($key);
    }


    /**
    *   Completely clear the cache.
    *   Called after upgrade.
    *
    *   @param  array   $tag    Optional array of tags, base tag used if undefined
    */
    public static function clear($tag = array())
    {
        if (version_compare(GVERSION, self::MIN_GVERSION, '<')) {
            global $_TABLES;

            DB_query("TRUNCATE {$_TABLES['weather_cache']}");
        } else {
            $tags = array(self::TAG);
            if (!empty($tag)) {
                if (!is_array($tag)) $tag = array($tag);
                $tags = array_merge($tags, $tag);
            }
            \glFusion\Cache::getInstance()->deleteItemsByTagsAll($tags);
        }
    }


    /**
    *   Create a unique cache key.
    *   Intended for internal use, but public in case it is needed.
    *
    *   @param  string  $key    Base key, e.g. Item ID
    *   @param  boolean $incl_sechash   True to include the security hash
    *   @return string          Encoded key string to use as a cache ID
    */
    public static function makeKey($key)
    {
        return strtolower(COM_sanitizeId($key, false));
    }


    /**
    *   Get an item from cache.
    *
    *   @param  string  $key    Key to retrieve
    *   @return mixed       Value of key, or NULL if not found
    */
    public static function get($key)
    {
        $retval = NULL;
        if (version_compare(GVERSION, self::MIN_GVERSION, '<')) {
            global $_TABLES, $_CONF_WEATHER;

            $cache_mins = (int)$_CONF_WEATHER['cache_minutes'];
            if ($cache_mins < 10) $cache_mins = 30;
            $retval = array();
            $db_loc = self::_makeCacheKey($loc);
            $sql = "SELECT * FROM {$_TABLES['weather_cache']}
                        WHERE location = '$db_loc'
                        AND ts > NOW() - INTERVAL $cache_mins MINUTE";
            $res = DB_query($sql);
            if ($res && DB_numRows($res) == 1) {
                $A = DB_fetchArray($res, false);
                $retval = @unserialize($A['data']);
            }
        } else {
            $key = self::makeKey($key);
            if (\glFusion\Cache::getInstance()->has($key)) {
                $retval = \glFusion\Cache::getInstance()->get($key);
            }
        }
        return $retval;
    }

}   // class Weather\Cache

?>