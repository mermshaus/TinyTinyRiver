<?php

namespace mermshaus\TinyTinyRiver;

return function ($config) {
    $feedId = (isset($_GET['feedId']) && is_string($_GET['feedId'])) ? (int)$_GET['feedId'] : 1;

    $url = $config['ttrss_apiurl'] . '../feed-icons/' . $feedId . '.ico';

    $statusCode = getHttpStatusCode($url);

    header('Content-Type: image/vnd.microsoft.icon');
    header('Cache-Control: public, max-age=86400'); // 1 day

    if ($statusCode === 200) {
        echo file_get_contents($url);
        return;
    }

    readfile(__DIR__ . '/../public/assets/favicon-blank.ico');
};
