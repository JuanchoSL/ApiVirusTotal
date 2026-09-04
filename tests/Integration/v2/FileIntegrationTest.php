<?php

namespace JuanchoSL\ApiVirusTotal\Tests\Integration\v2;

use JuanchoSL\ApiVirusTotal\Infrastructure\Factories\VirusTotalV2Factory;
use JuanchoSL\CurlClient\Wrappers\PsrCurlClient;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;

class FileIntegrationTest extends TestCase
{

    protected $api = null;
    protected ClientInterface $requester;
    public function setUp(): void
    {
        $this->api = new VirusTotalV2Factory(getenv('VIRUS_TOTAL_APIKEY'), new PsrCurlClient());
    }
    /*
        public function testFileScan()
        {
            $hash = "af5b780562464a3fcd7c5f284f79467e7efa709b2c1106bf214b6e68d8768e97";
            $result = $this->api->fileScan($hash);
        }
        public function testFileReScan()
        {
            $hash = "af5b780562464a3fcd7c5f284f79467e7efa709b2c1106bf214b6e68d8768e97";
            $result = $this->api->fileReScan($hash);
            }
    */
    public function testFileReport()
    {
        $hash = "af5b780562464a3fcd7c5f284f79467e7efa709b2c1106bf214b6e68d8768e97";
        $result = $this->api->fileReport($hash);
        $result = json_decode((string) $result->getBody(), true);

        $this->assertIsArray($result, "Result is an array");
        $this->assertArrayHasKey("permalink", $result, "Result has the key 'permalink'");
        $this->assertArrayHasKey("positives", $result, "Result has the key 'positives'");
        $this->assertIsInt($result['positives'], "The positives is a number");
        $this->assertArrayHasKey("resource", $result, "Result has the key 'resource'");
        $this->assertArrayHasKey("response_code", $result, "Result has the key 'response_code'");
        $this->assertIsInt($result['response_code'], "The response_code is a number");
        $this->assertArrayHasKey("scan_date", $result, "Result has the key 'scan_date'");
        $this->assertArrayHasKey("scan_id", $result, "Result has the key 'scan_id'");
        $this->assertArrayHasKey("verbose_msg", $result, "Result has the key 'verbose_msg'");
        $this->assertIsString($result['verbose_msg'], "The verbose_msg is a string");
        $this->assertArrayHasKey("scans", $result, "Result has the key 'scans'");
        $this->assertIsArray($result['scans'], "Scans is an array");
        foreach ($result['scans'] as $scanner_name => $scanner_result) {
            $this->assertIsArray($scanner_result, "Scanner Result is an array");
            $this->assertArrayHasKey("detected", $scanner_result, "Scanner Result has the key 'detected'");
            $this->assertArrayHasKey("result", $scanner_result, "Scanner Result has the key 'result'");
        }
        $this->assertArrayHasKey("md5", $result, "Result has the key 'md5'");
        $this->assertArrayHasKey("sha1", $result, "Result has the key 'sha1'");
        $this->assertArrayHasKey("sha256", $result, "Result has the key 'sha256'");

    }
}