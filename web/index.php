<?php

use atoum\ExtensionsWebsite\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Serve static files
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']))) {
    return false;
}

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container();

$app = new \Slim\App(['settings' => ['addContentLengthHeader' => false]]);


$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response) use ($container) {
    $twig = $container->twig();
    $response->getBody()->write($twig->render('home.html.twig'));
    return $response;
});

$app->get('/extensions/{name}', function ($request, $response) use ($container) {
    $twig = $container->twig();
    $extension = $container->getExtensionsRepository()->findUrl($request->getAttribute('name'));

    $markdown = file_get_contents($extension['url']);

    $Parsedown = new \atoum\ExtensionsWebsite\Parser($extension);
    $html = $Parsedown->text($markdown);

    $twig->addGlobal('current_extension_label', $extension['label']);

    $response->getBody()->write($twig->render('extension.html.twig', [
        'html' => $html,
    ]));

    return $response;
});

$app->run();
