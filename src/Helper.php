<?php 
namespace AdinanCenci\SimpleRequest;

class Helper 
{
    // set url query string
    public static function urlSetQuery($url, $query) 
    {
        $parsed = parse_url($url);
        $parsed['query'] = is_string($query) ? ltrim($query, '?') : http_build_query($query);
        return self::rebuildUrl($parsed);
    }

    // add to url query string
    public static function urlAddToQuery($url, $query) 
    {
        $parsed = parse_url($url);
        $query  = self::parseQuery($query);
        $parsed['query'] = empty($parsed['query']) ? [] : self::parseQuery($parsed['query']);
        $parsed['query'] = array_merge_recursive($parsed['query'], $query);
        $parsed['query'] = http_build_query($parsed['query']);
        return self::rebuildUrl($parsed);
    }

    protected static function parseQuery($q) 
    {
        if (is_array($q)) {
            return $q;
        }

        parse_str($q, $result);
        return $result;
    }

    protected static function rebuildUrl($parsed) 
    {
        return 
        ( empty($parsed['scheme']) ? '' : $parsed['scheme'].'://' ).
        ( empty($parsed['user']) ? '' : $parsed['user'].':'.$parsed['pass'].'@' ).
        ( empty($parsed['host']) ? '' : $parsed['host'] ).
        ( empty($parsed['port']) ? '' : ':'.$parsed['port'] ).
        ( empty($parsed['path']) ? '' : $parsed['path'] ).
        ( empty($parsed['query']) ? '' : '?'.$parsed['query'] ).
        ( empty($parsed['fragment']) ? '' : '#'.$parsed['fragment'] );
    }
}
