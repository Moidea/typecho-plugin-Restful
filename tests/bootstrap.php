<?php
use MoeFront\RestfulTests\Util;
use SSX\Utility\Serve;

// Errors on full!
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

Util::downloadTypecho();

// Start build-in server
$server = new Serve([
    'address' => getenv('WEB_SERVER_HOST'),
    'port' => getenv('WEB_SERVER_PORT'),
    'document_root' => getenv('WEB_SERVER_DOCROOT'),
]);

$server->start();

// Set env
if (getenv('CI')) {
    putenv('MYSQL_PWD=');
}

Util::installTypecho();

// Kill the web server when the process ends
register_shutdown_function(function () use ($server) {
    $server->stop();
});
