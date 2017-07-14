<?php

namespace mermshaus\TinyTinyRiver;

$pathToRoot = __DIR__ . '/..';

require $pathToRoot . '/src/functions.php';
require $pathToRoot . '/src/TinyTinyRssApi.php';

date_default_timezone_set('UTC');

$config = require $pathToRoot . '/config.php';

$action = (isset($_GET['action']) && is_string($_GET['action'])) ? $_GET['action'] : 'index';

$actionList = array('index', 'feedIcon');

$closure = null;

if (in_array($action, $actionList, true)) {
    $closure = require $pathToRoot . sprintf('/action/%sAction.php', $action);
}

if ($closure === null) {
    throw new Exception('Unknown action');
}

$closure($config);
