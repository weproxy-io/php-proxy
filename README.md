# Use WeProxy with PHP

[![WeProxy — PHP proxy example](./assets/banner.png)](https://weproxy.io/?utm_source=github&utm_medium=referral&utm_campaign=php-proxy)

[![Website](https://img.shields.io/badge/Website-weproxy.io-111111?style=for-the-badge)](https://weproxy.io/?utm_source=github&utm_medium=referral&utm_campaign=php-proxy)
[![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![Integrations](https://img.shields.io/badge/Docs-Integrations-2563eb?style=for-the-badge)](https://weproxy.io/en/integrations?utm_source=github&utm_medium=referral&utm_campaign=php-proxy)

Route outbound HTTP(S) through [WeProxy](https://weproxy.io) using **PHP cURL** — the same stack most PHP scrapers, WordPress jobs, and CLI workers already ship with.

---

## What this demo does

1. Reads gateway settings from the environment  
2. Configures `CURLOPT_PROXY` + `CURLOPT_PROXYUSERPWD`  
3. Requests `https://api.ipify.org`  
4. Prints the exit IP (or a clear error)

No Composer packages required — only the `curl` extension.

## Requirements

- PHP **8.0+** with `curl` enabled (`php -m | findstr curl`)  
- WeProxy user/password from [my.we1.town](https://my.we1.town)  

## Setup

```bash
cp .env.example .env
```

This minimal sample does **not** auto-load `.env`. Export variables in your shell:

```bash
export WEPROXY_USER="your-user"
export WEPROXY_PASS="your-pass"
# optional overrides:
# export WEPROXY_HOST=gw.weproxy.com.tr
# export WEPROXY_PORT=8989
```

PowerShell:

```powershell
$env:WEPROXY_USER="your-user"
$env:WEPROXY_PASS="your-pass"
```

## Run

```bash
php src/check-ip.php
```

## Core snippet

```php
<?php
$ch = curl_init('https://api.ipify.org');
curl_setopt($ch, CURLOPT_PROXY, 'gw.weproxy.com.tr:8989');
curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'USER:PASSWORD');
curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
echo curl_exec($ch);
```

Production-ready version with timeouts and exit codes: [`src/check-ip.php`](./src/check-ip.php).

### Useful cURL options for proxies

| Option | Purpose |
| --- | --- |
| `CURLOPT_PROXY` | `host:port` |
| `CURLOPT_PROXYUSERPWD` | `user:pass` |
| `CURLOPT_PROXYTYPE` | `CURLPROXY_HTTP` (default here) |
| `CURLOPT_CONNECTTIMEOUT` | Fail fast on dead gateways |
| `CURLOPT_TIMEOUT` | Cap total wait |

For SOCKS5 packages, switch `CURLOPT_PROXYTYPE` to the matching `CURLPROXY_SOCKS5` constant **only if** the panel enables SOCKS for your line.

## Drop into frameworks

- **Plain PHP / CLI cron** — call the script or copy the options into your existing `curl_init` flow  
- **Laravel HTTP client** — configure a Guzzle handler stack with proxy URL `http://USER:PASS@gw.weproxy.com.tr:8989`  
- **Guzzle directly** — `'proxy' => 'http://USER:PASS@gw.weproxy.com.tr:8989'`  

Product choice (residential vs datacenter) is entirely in the **credentials**, not in PHP code. See [Pricing](https://weproxy.io/en/pricing) and [Rotating residential](https://weproxy.io/en/proxies/rotating-ipv4-residential).

## Troubleshooting

| Issue | Fix |
| --- | --- |
| `curl` class missing | Install `php-curl` / enable extension |
| Empty body + error string | Print `curl_error($ch)`; check auth |
| SSL complaints to target | Usually unrelated to proxy; verify CA bundle |
| Works in browser tools only | Confirm CLI uses the same env user/pass |

Baseline without PHP:

```bash
curl -x http://USER:PASSWORD@gw.weproxy.com.tr:8989 https://api.ipify.org
```

## Project layout

```text
php-proxy/
├── assets/banner.png
├── src/check-ip.php
├── .env.example
└── README.md
```

## Related

- [nodejs-proxy](https://github.com/weproxy-io/nodejs-proxy) · [python-proxy](https://github.com/weproxy-io/python-proxy)  
- [paid-proxy-servers](https://github.com/weproxy-io/paid-proxy-servers)  
- [weproxy.io/integrations](https://weproxy.io/en/integrations)  

## License

MIT — see [LICENSE](./LICENSE).
