<?php
declare(strict_types=1);

$repoRoot = dirname(__DIR__);
$themeRoot = $repoRoot . '/src/theme';
$atsRoot = $themeRoot . '/recruit/ats';
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';

function mime_type_for(string $file): string {
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    $map = [
        'css' => 'text/css; charset=utf-8',
        'js' => 'application/javascript; charset=utf-8',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'webp' => 'image/webp',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'ico' => 'image/x-icon',
    ];
    return $map[$ext] ?? 'application/octet-stream';
}

function send_file_safe(string $file): void {
    if (!is_file($file)) {
        http_response_code(404);
        echo "Not found";
        return;
    }
    header('Content-Type: ' . mime_type_for($file));
    readfile($file);
}

function render_php_page(string $file): void {
    $oldCwd = getcwd();
    ob_start();
    chdir(dirname($file));
    include basename($file);
    chdir($oldCwd ?: dirname(__DIR__));
    $html = ob_get_clean();
    header('Content-Type: text/html; charset=utf-8');
    echo $html;
}

if (str_starts_with($path, '/__theme/')) {
    send_file_safe($themeRoot . '/' . substr($path, strlen('/__theme/')));
    return;
}

if (preg_match('#^/aimats/(?:feature|function|case|price|faq)/(css|js|images)/(.*)$#', $path, $m)) {
    send_file_safe($themeRoot . '/recruit/' . $m[1] . '/' . $m[2]);
    return;
}

if (preg_match('#^/aimats/(css|js|images)/(.*)$#', $path, $m)) {
    send_file_safe($themeRoot . '/recruit/' . $m[1] . '/' . $m[2]);
    return;
}

$routes = [
    '/aimats' => $atsRoot . '/page-1.php',
    '/aimats/' => $atsRoot . '/page-1.php',
    '/aimats/feature' => $atsRoot . '/page-2.php',
    '/aimats/function' => $atsRoot . '/page-3.php',
    '/aimats/case' => $atsRoot . '/page-4.php',
    '/aimats/case/' => $atsRoot . '/page-4.php',
    '/aimats/price' => $atsRoot . '/page-5.php',
    '/aimats/faq' => $atsRoot . '/page-6.php',
    '/lp/aimats' => $themeRoot . '/landpage/ats/LP.php',
    '/lp/aimats/' => $themeRoot . '/landpage/ats/LP.php',
];

if (isset($routes[$path])) {
    render_php_page($routes[$path]);
    return;
}

http_response_code(404);
header('Content-Type: text/plain; charset=utf-8');
echo "AIMATS preview route not found: " . $path;
