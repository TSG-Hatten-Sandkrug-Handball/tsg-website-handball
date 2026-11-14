<?php
declare(strict_types=1);

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function url(string $path = ''): string
{
    return BASE_PATH . '/' . ltrim($path, '/');
}

function absolute_url(string $path = ''): string
{
    return SITE_ORIGIN . url($path);
}

// Appends the file's modification time so browsers fetch changed assets immediately.
function asset(string $path): string
{
    $path = ltrim($path, '/');
    $file = APP_ROOT . '/assets/' . $path;
    $version = is_file($file) ? '?v=' . filemtime($file) : '';

    return url('assets/' . $path) . $version;
}

function data(string $name): array
{
    static $cache = [];

    if (!isset($cache[$name])) {
        $cache[$name] = require DATA_DIR . '/' . $name . '.php';
    }

    return $cache[$name];
}

function partial(string $name, array $vars = []): void
{
    extract($vars, EXTR_SKIP);
    require INCLUDES_DIR . '/partials/' . $name . '.php';
}

function link_url(string $key): string
{
    return data('links')[$key];
}

function icon(string $name, string $class = ''): string
{
    return '<span class="icon icon--' . e($name) . ($class !== '' ? ' ' . e($class) : '') . '" aria-hidden="true"></span>';
}

function external_attributes(): string
{
    return 'target="_blank" rel="noopener"';
}

// Entity-encodes every character so simple address harvesters cannot read it,
// while browsers still show and use the address normally.
function obfuscate(string $text): string
{
    $encoded = '';
    $length = strlen($text);

    for ($i = 0; $i < $length; $i++) {
        $encoded .= '&#' . ord($text[$i]) . ';';
    }

    return $encoded;
}

function mailto(string $email, ?string $subject = null): string
{
    $href = 'mailto:' . $email;

    if ($subject !== null) {
        $href .= '?subject=' . rawurlencode($subject);
    }

    return $href;
}

// Encodes a URL for an href attribute; mail links are obfuscated (Lastenheft KO-03).
function href(string $url): string
{
    return strpos($url, 'mailto:') === 0 ? obfuscate($url) : e($url);
}

function email_link(string $email, ?string $label = null, string $class = 'link', ?string $subject = null): string
{
    $text = $label === null ? obfuscate($email) : e($label);

    return '<a class="' . e($class) . '" href="' . href(mailto($email, $subject)) . '">' . $text . '</a>';
}

function trial_training_mailto(?string $teamName = null): string
{
    $subject = $teamName === null ? 'Probetraining' : 'Probetraining ' . $teamName;

    return mailto(DEPARTMENT_EMAIL, $subject);
}

// $variant: primary | secondary | light | outline-light | text
function button(string $label, string $url, string $variant = 'primary', array $options = []): string
{
    $attributes = !empty($options['external']) ? ' ' . external_attributes() : '';
    $iconName = $options['icon'] ?? null;
    $iconHtml = $iconName !== null ? icon($iconName, 'button__icon') : '';
    $hiddenHint = !empty($options['external']) ? '<span class="visually-hidden"> (öffnet in neuem Tab)</span>' : '';

    return '<a class="button button--' . e($variant) . '" href="' . href($url) . '"' . $attributes . '>'
        . e($label) . $hiddenHint . $iconHtml . '</a>';
}

function placeholder(string $kind): array
{
    $placeholders = [
        'landscape' => ['file' => 'placeholder-photo-landscape.svg', 'width' => 300, 'height' => 200],
        'wide' => ['file' => 'placeholder-photo-wide.svg', 'width' => 320, 'height' => 180],
        'wide-dark' => ['file' => 'placeholder-photo-wide-dark.svg', 'width' => 320, 'height' => 180],
        'square' => ['file' => 'placeholder-photo-square.svg', 'width' => 200, 'height' => 200],
        'avatar' => ['file' => 'placeholder-avatar.svg', 'width' => 200, 'height' => 200],
        'team-crest' => ['file' => 'placeholder-team-crest.svg', 'width' => 200, 'height' => 200],
        'logo' => ['file' => 'placeholder-logo.svg', 'width' => 300, 'height' => 200],
    ];

    return $placeholders[$kind];
}

// Renders an image in a fixed-ratio frame. Without a photo the matching
// placeholder is used, so swapping in the real file never changes the layout
// (PH-08 / PH-09). $alt describes the intended photo; placeholders get a prefix (PH-07).
function media(?string $photo, string $kind, string $alt, array $options = []): string
{
    $placeholder = placeholder($kind);
    $src = $photo !== null ? url($photo) : asset('placeholders/' . $placeholder['file']);
    $alt = $photo !== null ? $alt : 'Platzhalter: ' . $alt;
    $loading = $options['loading'] ?? 'lazy';
    $class = 'media media--' . $kind . (isset($options['class']) ? ' ' . $options['class'] : '');

    return '<div class="' . e($class) . '"><img class="media__image" src="' . e($src) . '" alt="' . e($alt) . '"'
        . ' width="' . $placeholder['width'] . '" height="' . $placeholder['height'] . '"'
        . ' loading="' . e($loading) . '" decoding="async"></div>';
}

function format_file_size(int $bytes): string
{
    if ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 1, ',', '.') . ' MB';
    }

    return max(1, (int) round($bytes / 1024)) . ' KB';
}

function format_euro(int $amount): string
{
    return $amount . ' €';
}

function sort_key(string $name): string
{
    $parts = explode(' ', $name);
    $last = end($parts);

    return strtr(mb_strtolower($last . ' ' . $name), ['ä' => 'a', 'ö' => 'o', 'ü' => 'u', 'ß' => 'ss']);
}

function json_ld(array $data): string
{
    $json = json_encode(['@context' => 'https://schema.org'] + $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG);

    return '<script type="application/ld+json">' . $json . '</script>';
}
