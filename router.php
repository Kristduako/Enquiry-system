
<?php
session_start();

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/Enquiry-system';

if (strpos($url, $basePath) === 0) {
    $url = substr($url, strlen($basePath));
}

$url = '/' . trim($url, '/');

$routes = [
    '/'       => 'login.php',
    '/login'  => 'login.php',
    '/index'  => 'index.php',
    '/stats'  => 'stats.php',
    '/course' => 'course.php',
];

if (isset($routes[$url])) {
    require __DIR__ . '/' . $routes[$url];
    exit;
}

http_response_code(404);
echo '404 - Page Not Found';
