<?php declare(strict_types=1);

namespace JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V2;

use Fig\Http\Message\RequestMethodInterface;
use JuanchoSL\ApiVirusTotal\Infrastructure\Contracts\ReportableInterface;
use JuanchoSL\ApiVirusTotal\Infrastructure\Contracts\ScanneableInterface;
use Psr\Http\Message\RequestInterface;

class UrlsRequest extends AbstractVirusTotalV2 implements ReportableInterface, ScanneableInterface
{

    public function report(string $value): RequestInterface
    {
        $uri = $this->uri_factory
            ->createUri($this->apiURL . "/url/report")
            ->withQuery(http_build_query(['apikey' => $this->apiKey, 'resource' => $value, 'scan' => '0']));
        return $this->requester->createRequest(RequestMethodInterface::METHOD_GET, $uri);
    }

    public function scan(string $value): RequestInterface
    {
        $uri = $this->uri_factory
            ->createUri($this->apiURL . "/url/scan");
        $stream = $this->stream_factory->createStream(http_build_query(['apikey' => $this->apiKey, 'url' => $value]));
        
        return $this->requester
            ->createRequest(RequestMethodInterface::METHOD_POST, $uri)
            ->withBody($stream)
            ->withAddedHeader("Content-Type", "application/x-www-form-urlencoded");
    }

}