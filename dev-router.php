<?php
// Router for PHP's built-in server, emulating handball/.htaccess locally:
//   php -S localhost:8000 dev-router.php
// then open http://localhost:8000/handball/
// Not used in production.

$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$root = __DIR__;

if (preg_match('#^/handball/(includes|data)(/|$)#', $path)) {
    http_response_code(403);
    exit('Forbidden');
}

$routes = [
    '#^/handball/neuigkeiten/([a-z0-9-]+)/?$#' => '/handball/neuigkeiten/article.php',
    '#^/handball/mannschaften/([a-z0-9-]+)/?$#' => '/handball/mannschaften/team.php',
];

foreach ($routes as $pattern => $script) {
    if (preg_match($pattern, $path, $matches)) {
        $_GET['slug'] = $matches[1];
        chdir(dirname($root . $script));
        require $root . $script;
        return true;
    }
}

if ($path === '/handball/sitemap.xml') {
    require $root . '/handball/sitemap.php';
    return true;
}

$file = $root . $path;

if (is_dir($file)) {
    if (substr($path, -1) !== '/') {
        header('Location: ' . $path . '/', true, 301);
        return true;
    }
    $file .= 'index.php';
}

if (is_file($file)) {
    if (substr($file, -4) === '.php') {
        chdir(dirname($file));
        require $file;
        return true;
    }

    return false;
}

require $root . '/handball/404.php';
return true;
