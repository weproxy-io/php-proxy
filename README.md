# Use WeProxy with PHP

[![WeProxy — PHP proxy example](./assets/banner.png)](https://weproxy.io/?utm_source=github&utm_medium=referral&utm_campaign=php-proxy)

[![Website](https://img.shields.io/badge/Website-weproxy.io-111111?style=for-the-badge)](https://weproxy.io/?utm_source=github&utm_medium=referral&utm_campaign=php-proxy) [![Integrations](https://img.shields.io/badge/Docs-Integrations-2563eb?style=for-the-badge)](https://weproxy.io/en/integrations?utm_source=github&utm_medium=referral&utm_campaign=php-proxy)

Minimal PHP cURL example: request your exit IP through the [WeProxy](https://weproxy.io) HTTP proxy gateway.

## Requirements

- PHP 8.0+ with `curl` extension
- WeProxy credentials from [my.we1.town](https://my.we1.town)

## Setup

```bash
cp .env.example .env
```

Export variables (PHP does not load `.env` automatically in this minimal sample):

```bash
export WEPROXY_USER="your-user"
export WEPROXY_PASS="your-pass"
```

PowerShell:

```powershell
$env:WEPROXY_USER="your-user"
$env:WEPROXY_PASS="your-pass"
```

Gateway defaults:

```text
Host: gw.weproxy.com.tr
Port: 8989
```

## Run

```bash
php src/check-ip.php
```

## Code

```php
<?php
$ch = curl_init('https://api.ipify.org');
curl_setopt($ch, CURLOPT_PROXY, 'gw.weproxy.com.tr:8989');
curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'USER:PASSWORD');
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
echo curl_exec($ch);
```

Full script: [`src/check-ip.php`](./src/check-ip.php).

## Residential vs datacenter

Point the same gateway at the package credentials you bought — e.g. [rotating residential](https://weproxy.io/en/proxies/rotating-ipv4-residential) or [rotating datacenter](https://weproxy.io/en/proxies/rotating-ipv4-datacenter). Host and port do not change.

SOCKS5 is only for packages that enable it in the panel; this sample uses HTTP proxy mode.

## Links

- [WeProxy](https://weproxy.io)
- [Pricing](https://weproxy.io/en/pricing)
- [Integrations](https://weproxy.io/en/integrations)

## Suggested GitHub topics

`php` · `curl` · `proxy` · `http-proxy` · `residential-proxy` · `socks5`

## License

MIT — see [LICENSE](./LICENSE).
