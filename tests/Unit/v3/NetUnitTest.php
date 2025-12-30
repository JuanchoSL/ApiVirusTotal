<?php

namespace JuanchoSL\ApiVirusTotal\Tests\Unit\v3;

use JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V3\DomainsRequest;
use JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V3\IpsRequest;
use JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V3\UrlsRequest;
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
        $this->assertArrayHasKey("data", $result, "Result has the key 'data'");
        $result = $result['data'];
        $this->assertIsArray($result, "Result is an array");
        $this->assertArrayHasKey("id", $result, "Result has the key 'id'");
        $this->assertArrayHasKey("links", $result, "Result has the key 'links'");
        $this->assertIsArray($result['links'], "Links is an array");
        $this->assertArrayHasKey("self", $result['links'], "links has the key 'self'");
    }
    
    public function testUrlReport()
    {
        $this->api = UrlsRequest::getInstance(getenv('VIRUS_TOTAL_APIKEY'));
        $request = $this->api->report('https://www.tecnicosweb.com');
        
        $result = $this->requester->sendRequest($request);
        $result = json_decode((string) $result->getBody(), true);
        
        $this->assertIsArray($result, "Result is an array");
        $this->assertArrayHasKey("data", $result, "Result has the key 'data'");

        $result = $result['data'];
        $this->assertIsArray($result, "Result is an array");

        $this->assertArrayHasKey("id", $result, "Result has the key 'id'");

        $this->assertArrayHasKey("links", $result, "Result has the key 'links'");
        $this->assertIsArray($result['links'], "Links is an array");
        $this->assertArrayHasKey("self", $result['links'], "Links has the key 'self'");
        
        $this->assertArrayHasKey("attributes", $result, "Result has the key 'attributes'");
        $attributes = $result['attributes'];
        $this->assertArrayHasKey("url", $attributes, "Result has the key 'url'");
        $this->assertArrayHasKey("last_http_response_code", $attributes, "Result has the key 'last_http_response_code'");
        $this->assertIsInt($attributes['last_http_response_code'], "The response_code is a number");
        $this->assertArrayHasKey("last_analysis_date", $attributes, "Result has the key 'scan_date'");
    }
    
    public function testDomainReport()
    {
        $this->api = DomainsRequest::getInstance(getenv('VIRUS_TOTAL_APIKEY'));
        $request = $this->api->report('www.tecnicosweb.com');
        
        $result = $this->requester->sendRequest($request);
        $result = json_decode((string) $result->getBody(), true);
        
        $result = $result['data'];
        $this->assertIsArray($result, "Result is an array");

        $this->assertArrayHasKey("id", $result, "Result has the key 'id'");

        $this->assertArrayHasKey("links", $result, "Result has the key 'links'");
        $this->assertIsArray($result['links'], "Links is an array");
        $this->assertArrayHasKey("self", $result['links'], "Links has the key 'self'");
        
        $this->assertArrayHasKey("attributes", $result, "Result has the key 'attributes'");
        $attributes = $result['attributes'];
        
        $this->assertArrayHasKey("whois", $attributes, "Result has the key 'whois'");
        $this->assertArrayHasKey("last_analysis_date", $attributes, "Result has the key 'scan_date'");
        $this->assertArrayHasKey("last_analysis_results", $attributes, "Result has the key 'resolutions'");
        $this->assertIsArray($attributes['last_analysis_results'], "Resolutions is an array");
        foreach ($attributes['last_analysis_results'] as $resolution) {
            $this->assertIsArray($resolution, "Resolution Result is an array");
            $this->assertArrayHasKey("engine_name", $resolution, "Resolution Result has the key 'engine_name'");
            $this->assertArrayHasKey("result", $resolution, "Resolution Result has the key 'result'");
        }
    }

    public function testIPReport()
    {
        $this->api = IpsRequest::getInstance(getenv('VIRUS_TOTAL_APIKEY'));
        $request = $this->api->report('87.98.231.3');

        $result = $this->requester->sendRequest($request);
        $result = json_decode((string) $result->getBody(), true);
        
        $result = $result['data'];
        $this->assertIsArray($result, "Result is an array");
        
        $this->assertArrayHasKey("id", $result, "Result has the key 'id'");

        $this->assertArrayHasKey("links", $result, "Result has the key 'links'");
        $this->assertIsArray($result['links'], "Links is an array");
        $this->assertArrayHasKey("self", $result['links'], "Links has the key 'self'");

        $this->assertArrayHasKey("attributes", $result, "Result has the key 'attributes'");
        $attributes = $result['attributes'];

        $this->assertArrayHasKey("as_owner", $attributes, "Result has the key 'as_owner'");
        $this->assertArrayHasKey("asn", $attributes, "Result has the key 'asn'");
        $this->assertArrayHasKey("country", $attributes, "Result has the key 'country'");

        $this->assertArrayHasKey("last_analysis_results", $attributes, "Result has the key 'resolutions'");
        $this->assertArrayHasKey("last_analysis_date", $attributes, "Result has the key 'scan_date'");
        $this->assertIsArray($attributes['last_analysis_results'], "Resolutions is an array");
        foreach ($attributes['last_analysis_results'] as $resolution) {
            $this->assertIsArray($resolution, "Resolution Result is an array");
            $this->assertArrayHasKey("engine_name", $resolution, "Resolution Result has the key 'engine_name'");
            $this->assertArrayHasKey("result", $resolution, "Resolution Result has the key 'result'");
        }
    }
}