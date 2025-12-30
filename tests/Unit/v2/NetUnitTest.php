<?php

namespace JuanchoSL\ApiVirusTotal\Tests\Unit\v2;

use JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V2\DomainsRequest;
use JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V2\IpsRequest;
use JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V2\UrlsRequest;
use JuanchoSL\CurlClient\Wrappers\PsrCurlClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

class NetUnitTest extends TestCase
{

    protected ClientInterface $requester;
    protected $api = null;
    public function setUp(): void
    {
        $this->requester = new PsrCurlClient();
    }

    public function testUrlScan()
    {
        $this->api = UrlsRequest::getInstance(getenv('VIRUS_TOTAL_APIKEY'));
        $request = $this->api->scan('https://www.tecnicosweb.com');
        $result = $this->requester->sendRequest($request);
        $result = json_decode((string) $result->getBody(), true);

        $this->assertIsArray($result, "Result is an array");
        $this->assertArrayHasKey("url", $result, "Result has the key 'url'");
        $this->assertArrayHasKey("resource", $result, "Result has the key 'resource'");
        $this->assertArrayHasKey("permalink", $result, "Result has the key 'permalink'");
        $this->assertArrayHasKey("scan_date", $result, "Result has the key 'scan_date'");
        $this->assertArrayHasKey("scan_id", $result, "Result has the key 'scan_id'");
        $this->assertArrayHasKey("verbose_msg", $result, "Result has the key 'verbose_msg'");
        $this->assertIsString($result['verbose_msg'], "The verbose_msg is a string");
        $this->assertArrayHasKey("response_code", $result, "Result has the key 'response_code'");
        $this->assertIsInt($result['response_code'], "The response_code is a number");
        $this->assertTrue(true);
    }

    public function testUrlReport()
    {
        $this->api = UrlsRequest::getInstance(getenv('VIRUS_TOTAL_APIKEY'));
        $request = $this->api->report('https://www.tecnicosweb.com');

        $result = $this->requester->sendRequest($request);
        $result = json_decode((string) $result->getBody(), true);

        $this->assertIsArray($result, "Result is an array");
        $this->assertArrayHasKey("url", $result, "Result has the key 'url'");
        $this->assertArrayHasKey("resource", $result, "Result has the key 'resource'");
        $this->assertArrayHasKey("permalink", $result, "Result has the key 'permalink'");
        $this->assertArrayHasKey("scan_date", $result, "Result has the key 'scan_date'");
        $this->assertArrayHasKey("scan_id", $result, "Result has the key 'scan_id'");
        $this->assertArrayHasKey("verbose_msg", $result, "Result has the key 'verbose_msg'");
        $this->assertIsString($result['verbose_msg'], "The verbose_msg is a string");
        $this->assertArrayHasKey("response_code", $result, "Result has the key 'response_code'");
        $this->assertIsInt($result['response_code'], "The response_code is a number");
        $this->assertArrayHasKey("scans", $result, "Result has the key 'scans'");
        $this->assertIsArray($result['scans'], "Scans is an array");
        foreach ($result['scans'] as $scanner_name => $scanner_result) {
            $this->assertIsArray($scanner_result, "Scanner Result is an array");
            $this->assertArrayHasKey("detected", $scanner_result, "Scanner Result has the key 'detected'");
            $this->assertArrayHasKey("result", $scanner_result, "Scanner Result has the key 'result'");
        }
        $this->assertTrue(true);
    }

    public function testDomainReport()
    {
        $this->api = DomainsRequest::getInstance(getenv('VIRUS_TOTAL_APIKEY'));
        $request = $this->api->report('www.tecnicosweb.com');

        $result = $this->requester->sendRequest($request);
        $result = json_decode((string) $result->getBody(), true);

        $this->assertIsArray($result, "Result is an array");
        $this->assertArrayHasKey("domain_siblings", $result, "Result has the key 'domain_siblings'");
        $this->assertArrayHasKey("response_code", $result, "Result has the key 'response_code'");
        $this->assertIsInt($result['response_code'], "The response_code is a number");
        $this->assertArrayHasKey("verbose_msg", $result, "Result has the key 'verbose_msg'");
        $this->assertIsString($result['verbose_msg'], "The verbose_msg is a string");
        $this->assertArrayHasKey("whois", $result, "Result has the key 'whois'");
        $this->assertArrayHasKey("resolutions", $result, "Result has the key 'resolutions'");
        $this->assertIsArray($result['resolutions'], "Resolutions is an array");
        foreach ($result['resolutions'] as $resolution) {
            $this->assertIsArray($resolution, "Resolution Result is an array");
            $this->assertArrayHasKey("ip_address", $resolution, "Resolution Result has the key 'ip_address'");
            $this->assertArrayHasKey("last_resolved", $resolution, "Resolution Result has the key 'last_resolved'");
        }
        $this->assertTrue(true);
    }

    public function testIPReport()
    {
        $this->api = IpsRequest::getInstance(getenv('VIRUS_TOTAL_APIKEY'));
        $request = $this->api->report('87.98.231.3');

        $result = $this->requester->sendRequest($request);
        $result = json_decode((string) $result->getBody(), true);

        $this->assertIsArray($result, "Result is an array");
        $this->assertArrayHasKey("response_code", $result, "Result has the key 'response_code'");
        $this->assertIsInt($result['response_code'], "The response_code is a number");
        $this->assertArrayHasKey("resolutions", $result, "Result has the key 'resolutions'");
        $this->assertIsArray($result['resolutions'], "Resolutions is an array");
        foreach ($result['resolutions'] as $resolution) {
            $this->assertIsArray($resolution, "Resolution Result is an array");
            $this->assertArrayHasKey("hostname", $resolution, "Resolution Result has the key 'hostname'");
            $this->assertArrayHasKey("last_resolved", $resolution, "Resolution Result has the key 'last_resolved'");
        }
        $this->assertArrayHasKey("as_owner", $result, "Result has the key 'as_owner'");
        $this->assertArrayHasKey("asn", $result, "Result has the key 'asn'");
        $this->assertArrayHasKey("country", $result, "Result has the key 'country'");
        $this->assertArrayHasKey("verbose_msg", $result, "Result has the key 'verbose_msg'");
        $this->assertIsString($result['verbose_msg'], "The verbose_msg is a string");
    }
}