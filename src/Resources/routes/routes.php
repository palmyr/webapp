<?php declare(strict_types=1);

$config = [];

$config['routes']['/'] = \Palmyr\WebApp\Controller\BaseController::class;
$config['routes']['/admin/log/{{type}}/{{message}}/'] = \Palmyr\WebApp\Controller\LogController::class;

return $config;
