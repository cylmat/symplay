<?php

use App\Kernel;

ini_set('display_errors', 'on');
error_reporting(-1);

$_SERVER['APP_RUNTIME_OPTIONS']['project_dir'] = dirname(__DIR__, 1);

require_once dirname(__DIR__).'/lib/vendor/autoload.php';
require_once dirname(__DIR__).'/vendor/autoload_runtime.php';
// @todo lib-dev composer

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
