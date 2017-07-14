<?php

namespace mermshaus\TinyTinyRiver;

use Exception;

/**
 * @param $s
 * @return string
 */
function e($s)
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

/**
 * @param $action
 * @param array $params
 * @return string
 * @throws Exception
 */
function url($action, array $params = array())
{
    if (array_key_exists('action', $params)) {
        throw new Exception('Param key "action" is reserved');
    }

    $url = './';

    $tmp = array();

    if ($action !== 'index') {
        $tmp['action'] = $action;
    }

    $tmp = array_merge($tmp, $params);

    if (count($tmp) > 0) {
        $url .= '?' . http_build_query($tmp);
    }

    return $url;
}

/**
 * @param $__templateFile
 * @param array $tpl
 */
function render($__templateFile, array $tpl = array())
{
    require __DIR__ . '/../view/' . $__templateFile . '.phtml';
}

/**
 * @param $s
 * @return string
 */
function cleanString($s)
{
    $s = strip_tags($s);
    $s = html_entity_decode($s, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $s = preg_replace('/\s{2,}/', ' ', $s);
    $s = trim($s);

    return $s;
}

/**
 * @param $s
 * @param $maxLength
 * @param string $ellipsisSymbol
 * @return string
 */
function shortenString($s, $maxLength, $ellipsisSymbol = '…')
{
    $ret = trim($s);

    if (mb_strlen($ret, 'UTF-8') > $maxLength) {
        $ret = mb_substr($ret, 0, $maxLength, 'UTF-8');
        $ret = rtrim($ret);
        $ret .= $ellipsisSymbol;
    }

    return $ret;
}

/**
 * @param string $url
 * @return int
 */
function getHttpStatusCode($url)
{
    $curlHandle = curl_init();
    curl_setopt($curlHandle, CURLOPT_URL, $url);
    curl_setopt($curlHandle, CURLOPT_HEADER, true);
    curl_setopt($curlHandle, CURLOPT_NOBODY, true);
    curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
    curl_exec($curlHandle);
    $response = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
    curl_close($curlHandle); // Don't forget to close the connection

    return (int) $response;
}
