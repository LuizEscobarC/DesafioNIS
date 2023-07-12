<?php
ob_start('ob_gzhandler');
require __DIR__ . "/vendor/autoload.php";

/**
 * BOOTSTRAP
 */
use CoffeeCode\Router\Router;
use Source\Core\Session;

$session = new Session();
$route = new Router(url(), ":");
$route->namespace("Source\App");

/*
 * APP ROUTES
 */
$route->group(null);
$route->get("/", "App:home");
$route->get("/cidadao", "App:citizen");
$route->post("/cidadao", "App:createCitizen");
$route->post('/cidadao/search', "App:searchCitizen");

/*
 * ERROR ROUTES
 */
$route->group("/ops");
$route->get("/{errcode}", "App:error");

/**
 * ROUTE
 */
$route->dispatch();

/**
 * ERROR REDIRECT
 */
if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}

ob_end_flush();
