<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Lib\Router;
use App\Controller\Home;

session_start();
$uri = getenv('MONGODB_URI');

Router::get('/', function () {
    (new Home())->indexAction();
});

Router::get('/profile', function () {
    (new Home())->profile();
});

Router::get('/posts', function () {
    (new Home())->post();
});

Router::post('/posts', function () {
    (new Home())->postSearch();
});

Router::get('/login', function () {
    (new Home())->loginAction();
});

Router::get('/signup', function () {
    (new Home())->signupAction();
});

Router::get('/logout', function () {
    (new Home())->logoutAction();
});

Router::post('/register', function () {
    (new Home())->registerAction();
});

Router::post('/signin', function () {
    (new Home())->signinAction();
});

Router::get('/{any}', function () {
    (new Home())->notFound();
});
