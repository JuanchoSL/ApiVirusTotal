# VirusTotal API

[Virus Total](https://www.virustotal.com/gui/home/upload) is an online service that you can use to

> Analyse suspicious files, domains, IPs and URLs to detect malware and other breaches, automatically share them with the security community.

As developer, you can register for free in order to retrieve an API KEY, and use his public [API](https://docs.virustotal.com/docs/api-overview) with this library.

The request are using a [PSR-18](https://www.php-fig.org/psr/psr-18) compatible client, and all responses are returned as a [PSR-7](https://www.php-fig.org/psr/psr-7/#33-psrhttpmessageresponseinterface) Response Interface

Actually we have available the v2 and v3 of the public endpoints, the response signatures are distincts, be careful with the body responses structures. in order to retrieve info from:

## URLs

Sending an URL to scan, we can force to extract fresh info or read a previous report if exists

### Scan [V2](https://docs.virustotal.com/v2.0/reference/url-scan) [V3](https://docs.virustotal.com/reference/scan-url)

```php

$container = new VirusTotalV2Factory(getenv('APIKEY_VIRUS_TOTAL'), new PsrCurlClient());
$result = $container->urlScan($url);

{
 'response_code': 1,
 'verbose_msg': 'Scan request successfully queued, come back later for the report',
 'scan_id': '1db0ad7dbcec0676710ea0eaacd35d5e471d3e11944d53bcbd31f0cbd11bce31-1320752364',
 'scan_date': '2011-11-08 11:39:24',
 'url': 'http://www.virustotal.com/',
 'permalink': 'http://www.virustotal.com/url/1db0ad7dbcec0676710ea0eaacd35d5e471d3e11944d53bcbd31f0cbd11bce31/analysis/1320752364/'
}
```

### Report [V2](https://docs.virustotal.com/v2.0/reference/url-report) [V3](https://docs.virustotal.com/reference/url-info)

```php

$container = new VirusTotalV2Factory(getenv('APIKEY_VIRUS_TOTAL'), new PsrCurlClient());
$result = $container->urlReport($url);

{
  "response_code": 1,
  "verbose_msg": "Scan finished, scan information embedded in this object",
  "scan_id": " OGZmYjYxYjUxYWI0YTdhM2ViZWI5Zjc2MTE5ZTRiODE6MTY3ODM0ODYyNA==",
  "permalink": "https://www.virustotal.com/url/__urlsha256__/analysis/1390467782/",
  "url": "http://www.virustotal.com/",
  "scan_date": "2014-01-23 09:03:02",
  "filescan_id": null,
  "positives": 0,
  "total": 51,
  "scans": {
    "CLEAN MX": {
      "detected": false,
      "result": "clean site"
    },
    "MalwarePatrol": {
      "detected": false,
      "result": "clean site"
    }
  }
}
```

## Domains

For domains, we can no force a fresh scan from V2, we only can retrieve a report info

### Scan [V3](https://docs.virustotal.com/reference/domains-rescan)

```php
$container = new VirusTotalV3Factory(getenv('APIKEY_VIRUS_TOTAL'), new PsrCurlClient());
$result = $container->domainRescan($url);
```

### Report [V2](https://docs.virustotal.com/v2.0/reference/domain-report) [V3](https://docs.virustotal.com/reference/domain-info)

```php
$container = new VirusTotalV2Factory(getenv('APIKEY_VIRUS_TOTAL'), new PsrCurlClient());
$result = $container->domainReport($url);

{
  "undetected_referrer_samples": [{
    "date": "2018-03-04 16:38:06",
    "positives": 0,
    "total": 66,
    "sha256": "ce08cf22949b6b6fcd4e61854ce810a4f9ee04529340dd077fa354d759dc7a95"
  }, {
    "positives": 0,
    "total": 53,
    "sha256": "b8f5db667431d02291eeec61cf9f0c3d7af00798d0c2d676fde0efb0cedb7741"
  }],
  "whois_timestamp": 1520586501,
  "detected_downloaded_samples": [{
    "date": "2013-06-20 18:51:30",
    "positives": 2,
    "total": 46,
    "sha256": "cd8553d9b24574467f381d13c7e0e1eb1e58d677b9484bd05b9c690377813e54"
  }],
  "detected_referrer_samples": [],
  "undetected_downloaded_samples": [{
    "date": "2018-01-14 22:34:24",
    "positives": 0,
    "total": 70,
    "sha256": "e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855"
  }],
  "resolutions": [{
    "last_resolved": "2018-03-09 00:00:00",
    "ip_address": "185.53.177.31"
  }, {
    "last_resolved": "2013-06-20 00:00:00",
    "ip_address": "90.156.201.97"
  }],
  "subdomains": [
    "test.027.ru",
    "www.027.ru"
  ],
  "categories": [
    "parked",
    "uncategorized"
  ],
  "domain_siblings": [],
  "undetected_urls": [],
  "response_code": 1,
  "verbose_msg": "Domain found in dataset",
  "detected_urls": [{
    "url": "http://027.ru/",
    "positives": 2,
    "total": 67,
    "scan_date": "2018-04-01 15:51:22"
  }, {
    "url": "http://027.ru/adobe/flash_install_v10x1.php",
    "positives": 5,
    "total": 67,
    "scan_date": "2018-03-26 09:22:43"
  }, {
    "url": "http://027.ru/track.php",
    "positives": 4,
    "total": 66,
    "scan_date": "2018-01-14 22:39:41"
  }, {
    "url": "http://027.ru/track.php?domain=027.ru&caf=1&toggle=answercheck",
    "positives": 2,
    "total": 66,
    "scan_date": "2018-01-09 22:19:43"
  }, {
    "url": "https://027.ru/",
    "positives": 1,
    "total": 66,
    "scan_date": "2016-02-08 13:25:40"
  }],
}
```

## IPs

As domains, we only can retrieve a report info form V2

### Scan [V3](https://docs.virustotal.com/reference/rescan-ip)

```php
$container = new VirusTotalV3Factory(getenv('APIKEY_VIRUS_TOTAL'), new PsrCurlClient());
$result = $container->ipRescan($ip);
```

### Report [V2](https://docs.virustotal.com/v2.0/reference/ip-address-report) [V3](https://docs.virustotal.com/reference/ip-info)

```php
$container = new VirusTotalV2Factory(getenv('APIKEY_VIRUS_TOTAL'), new PsrCurlClient());
$result = $container->ipReport($ip);

{
  'response_code': 1,
  'verbose_msg': 'IP address found in dataset',
  'asn': '25532',
  'country': 'RU',
  'resolutions': [{
    'last_resolved': '2013-04-08 00:00:00',
    'hostname': '027.ru'
  }, {
    'last_resolved': '2013-04-08 00:00:00',
    'hostname': 'auto.rema-tiptop.ru'
  }, {
    'last_resolved': '2013-04-08 00:00:00',
    'hostname': 'catalog24de.ru'
  }, {
    'last_resolved': '2013-04-08 00:00:00',
    'hostname': 'club.velhod.ru'
  }, {
    'last_resolved': '2013-04-08 00:00:00',
    'hostname': 'danilova.pro'
  }],
  'detected_urls': [{
    'url': 'http://027.ru/',
    'positives': 2,
    'total': 37,
    'scan_date': '2013-04-07 07:18:09'
  }],
  'detected_downloaded_samples': [{
    'date': '2018-03-29 18:38:05',
    'positives': 2,
    'total': 59,
    'sha256': 'd9cacb75a3fd126762f348d00fb6e3809ede2c13b2ad251831e130bcb7ae7a84'
  }, {
    'date': '2018-03-29 08:52:38',
    'positives': 2,
    'total': 59,
    'sha256': '416751ebbd5d6c37bb20233a39ade80db584057f3d5c4bbf976ce9c332836707'
  }],
  'undetected_downloaded_samples': [{
    'date': '2018-03-28 06:36:55',
    'positives': 0,
    'total': 0,
    'sha256': '4a91398fd21f2d0b09fc7478d016d4a8fc9fe6f1c01e10b8e7c725542260cd9f'
  }, ],
  'undetected_urls': [
    [
      'http://zadiplomom.ru/',
      '3aafd5a54bb034882b8f5544bb647b6841bcb6ce938c40fb92be4cb84f2f0983',
      0,
      67,
      '2018-02-19 18:04:15'
    ],
  ]
}
```

## Files

### Scan [V2](https://docs.virustotal.com/v2.0/reference/file-scan)

```php
$container = new VirusTotalV2Factory(getenv('APIKEY_VIRUS_TOTAL'), new PsrCurlClient());
$result = $container->fileScan($filepath);

{
 'permalink': 'https://www.virustotal.com/file/d140c...244ef892e5/analysis/1359112395/',
 'resource': 'd140c244ef892e59c7f68bd0c6f74bb711032563e2a12fa9dda5b760daecd556',
 'response_code': 1,
 'scan_id': ' OGZmYjYxYjUxYWI0YTdhM2ViZWI5Zjc2MTE5ZTRiODE6MTY3ODM0ODYyNA==',
 'verbose_msg': 'Scan request successfully queued, come back later for the report',
 'sha256': 'd140c244ef892e59c7f68bd0c6f74bb711032563e2a12fa9dda5b760daecd556'
}
```

### ReScan [V2](https://docs.virustotal.com/v2.0/reference/file-rescan)

```php
$container = new VirusTotalV2Factory(getenv('APIKEY_VIRUS_TOTAL'), new PsrCurlClient());
$result = $container->fileRescan($file_hash);

{
  'response_code': 1,
  'scan_id': 'OGZmYjYxYjUxYWI0YTdhM2ViZWI5Zjc2MTE5ZTRiODE6MTY3ODM0ODYyNA==',
  'permalink': 'https://www.virustotal.com/file/__sha256hash__/analysis/1390472785/',
  'sha256': '54bc950d46a0d1aa72048a17c8275743209e6c17bdacfc4cb9601c9ce3ec9a71',
  'resource': '7657fcb7d772448a6d8504e4b20168b8'
}
```

### Report [V2](https://docs.virustotal.com/v2.0/reference/file-report)

```php
$container = new VirusTotalV2Factory(getenv('APIKEY_VIRUS_TOTAL'), new PsrCurlClient());
$result = $container->fileReport($file_hash);

{
 'response_code': 1,
 'verbose_msg': 'Scan finished, scan information embedded in this object',
 'resource': '99017f6eebbac24f351415dd410d522d',
 'scan_id': '52d3df0ed60c46f336c131bf2ca454f73bafdc4b04dfa2aea80746f5ba9e6d1c-1273894724',
 'md5': '99017f6eebbac24f351415dd410d522d',
 'sha1': '4d1740485713a2ab3a4f5822a01f645fe8387f92',
 'sha256': '52d3df0ed60c46f336c131bf2ca454f73bafdc4b04dfa2aea80746f5ba9e6d1c',
 'scan_date': '2010-05-15 03:38:44',
 'permalink': 'https://www.virustotal.com/file/52d3df0ed60c46f336c131bf2ca454f73bafdc4b04dfa2aea80746f5ba9e6d1c/analysis/1273894724/',
 'positives': 40,
 'total': 40,
 'scans': {
   'nProtect': {
     'detected': true,
     'version': '2010-05-14.01',
     'result': 'Trojan.Generic.3611249',
     'update': '20100514'
   },
   'CAT-QuickHeal': {
     'detected': true,
     'version': '10.00',
     'result': 'Trojan.VB.acgy',
     'update': '20100514'
   },
   'McAfee': {
     'detected': true,
     'version': '5.400.0.1158',
     'result': 'Generic.dx!rkx',
     'update': '20100515'
   },
   'TheHacker': {
     'detected': true,
     'version': '6.5.2.0.280',
     'result': 'Trojan/VB.gen',
     'update': '20100514'
   },
   'VirusBuster': {
    'detected': true,
     'version': '5.0.27.0',
     'result': 'Trojan.VB.JFDE',
     'update': '20100514'
   }
 }
}
```
