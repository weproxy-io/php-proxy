<?php
/**
 * Minimal WeProxy example: fetch your exit IP through the HTTP proxy gateway.
 *
 * Set WEPROXY_USER and WEPROXY_PASS from the customer panel (https://my.we1.town),
 * or pass a full WEPROXY_URL.
 */

declare(strict_types=1);

$host = getenv('WEPROXY_HOST') ?: 'gw.weproxy.com.tr';
$port = getenv('WEPROXY_PORT') ?: '8989';
$user = getenv('WEPROXY_USER') ?: 'USER-package-residential';
$pass = getenv('WEPROXY_PASS') ?: 'PASSWORD';
$echoUrl = getenv('WEPROXY_ECHO_URL') ?: 'https://api.ipify.org';
$proxyUrl = getenv('WEPROXY_URL') ?: null;

if ($user === 'USER-package-residential' || $pass === 'PASSWORD') {
    fwrite(STDERR, "Using placeholder credentials. Set WEPROXY_USER / WEPROXY_PASS (or WEPROXY_URL) before production use.\n");
}

$ch = curl_init($echoUrl);
if ($ch === false) {
    fwrite(STDERR, "Failed to initialize cURL\n");
    exit(1);
}

if ($proxyUrl) {
    curl_setopt($ch, CURLOPT_PROXY, $proxyUrl);
} else {
    curl_setopt($ch, CURLOPT_PROXY, $host . ':' . $port);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $user . ':' . $pass);
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
}

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_CONNECTTIMEOUT => 20,
    CURLOPT_TIMEOUT => 30,
]);

$body = curl_exec($ch);
$error = curl_error($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($body === false) {
    fwrite(STDERR, 'Request failed: ' . $error . PHP_EOL);
    exit(1);
}

if ($status >= 400) {
    fwrite(STDERR, "Echo request failed: HTTP {$status}" . PHP_EOL);
    exit(1);
}

echo 'Exit IP: ' . trim((string) $body) . PHP_EOL;
