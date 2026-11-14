<?php
declare(strict_types=1);

// Static site generator. Renders every page from src/ to plain HTML in dist/,
// so the web server only has to serve files (no PHP needed in production).
//
//   php build.php                      production settings from src/includes/config.php
//   php build.php --origin=https://example.github.io --base=/repo-name --noindex
//   php build.php --out=some/folder

// Any notice or warning aborts the build instead of ending up in the HTML.
error_reporting(E_ALL);
set_error_handler(function (int $severity, string $message, string $file, int $line): bool {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

$options = getopt('', ['origin:', 'base:', 'noindex', 'out:']);

if (isset($options['origin'])) {
    define('SITE_ORIGIN', rtrim((string) $options['origin'], '/'));
}
if (isset($options['base'])) {
    $base = rtrim((string) $options['base'], '/');

    // Git Bash on Windows rewrites "/name" to a Windows path; set MSYS_NO_PATHCONV=1 there.
    if ($base !== '' && !preg_match('#^(/[a-z0-9._-]+)+$#i', $base)) {
        fwrite(STDERR, "Invalid --base \"{$base}\": expected something like /repo-name" . PHP_EOL);
        exit(1);
    }

    define('BASE_PATH', $base);
}
if (isset($options['noindex'])) {
    define('SITE_NOINDEX', true);
}

require __DIR__ . '/src/includes/bootstrap.php';

$out = rtrim(str_replace('\\', '/', (string) ($options['out'] ?? __DIR__ . '/dist')), '/');
$started = microtime(true);

remove_directory($out);
mkdir($out, 0777, true);

$routes = site_routes();
$paths = array_column($routes, 'path');
$duplicates = array_diff_assoc($paths, array_unique($paths));

if ($duplicates !== []) {
    fwrite(STDERR, 'Duplicate routes: ' . implode(', ', $duplicates) . PHP_EOL);
    exit(1);
}

foreach ($routes as $route) {
    write_file($out . '/' . $route['path'] . 'index.html', render_template($route['template'], $route['params']));
}

write_file($out . '/404.html', render_template('not-found'));
write_file($out . '/sitemap.xml', render_template('sitemap', ['routes' => $routes]));
write_file($out . '/robots.txt', render_template('robots'));
write_file($out . '/llms.txt', render_template('llms'));

copy_directory(APP_ROOT . '/assets', $out . '/assets');
copy_directory(APP_ROOT . '/public', $out);
bundle_css($out . '/assets/css');
version_js_imports($out . '/assets/js', date('YmdHis'));

printf("Built %d pages into %s for %s%s in %.2fs%s\n", count($routes) + 1, $out, SITE_ORIGIN, BASE_PATH, microtime(true) - $started, SITE_NOINDEX ? ' (noindex)' : '');

function write_file(string $file, string $contents): void
{
    if (!is_dir(dirname($file))) {
        mkdir(dirname($file), 0777, true);
    }

    file_put_contents($file, $contents);
}

function copy_directory(string $source, string $target): void
{
    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($items as $item) {
        $destination = $target . '/' . substr(str_replace('\\', '/', $item->getPathname()), strlen(str_replace('\\', '/', $source)) + 1);

        if ($item->isDir()) {
            is_dir($destination) || mkdir($destination, 0777, true);
        } else {
            write_file($destination, (string) file_get_contents($item->getPathname()));
        }
    }
}

function remove_directory(string $directory): void
{
    if (!is_dir($directory)) {
        return;
    }

    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($items as $item) {
        $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
    }

    rmdir($directory);
}

// Inlines the @import list of main.css into one file, keeping each file in its
// cascade layer. One request instead of thirty, and no stale cached partials.
function bundle_css(string $cssDirectory): void
{
    $main = (string) file_get_contents($cssDirectory . '/main.css');

    $bundle = preg_replace_callback('/@import url\("([^"]+)"\) layer\(([a-z-]+)\);/', function (array $match) use ($cssDirectory): string {
        $css = (string) file_get_contents($cssDirectory . '/' . $match[1]);
        $css = preg_replace('#url\("\.\./\.\./#', 'url("../', $css);

        return "@layer {$match[2]} {
{$css}
}";
    }, $main);

    file_put_contents($cssDirectory . '/main.css', $bundle);

    foreach (['tokens.css', 'base.css', 'layout.css', 'utilities.css'] as $file) {
        unlink($cssDirectory . '/' . $file);
    }
    remove_directory($cssDirectory . '/components');
}

// Adds the build version to relative module imports, so browsers never mix
// a new main.js with cached old modules.
function version_js_imports(string $jsDirectory, string $version): void
{
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($jsDirectory, FilesystemIterator::SKIP_DOTS));

    foreach ($files as $file) {
        $code = (string) file_get_contents($file->getPathname());
        $code = preg_replace("/from '(\.{1,2}\/[^']+\.js)'/", "from '$1?v={$version}'", $code);
        file_put_contents($file->getPathname(), $code);
    }
}
