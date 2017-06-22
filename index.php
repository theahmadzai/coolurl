<?php

require '../app/app.php';

$app = new App();
$app->basePath('public/');
$app->viewsPath('app/views/');

$app->map('/', function ($params) use ($app) {
    $app->render('home');
});

$app->map('/contact', function ($params) use ($app) {
    $app->render('contact');
});

$app->map('/about', function ($params) use ($app) {
    $app->render('about');
});

$app->dispatch();