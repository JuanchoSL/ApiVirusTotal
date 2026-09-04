<?php declare(strict_types=1);

namespace JuanchoSL\ApiVirusTotal\Infrastructure\Factories;

use JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V3\DomainsRequest;
use JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V3\FilesRequest;
use JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V3\IpsRequest;
use JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V3\UrlsRequest;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

class VirusTotalV3Factory
{

    protected string $api_key;
    protected ClientInterface $client;

    public function __construct(string $api_key, ClientInterface $client_requester)
    {
        $this->api_key = $api_key;
        $this->client = $client_requester;
    }

    public function urlScan($url): ResponseInterface
    {
        $api = UrlsRequest::getInstance($this->api_key);
        $request = $api->scan($url);
        return $this->client->sendRequest($request);
    }

    public function urlReport($resource): ResponseInterface
    {
        $api = UrlsRequest::getInstance($this->api_key);
        $request = $api->report($resource);
        return $this->client->sendRequest($request);
    }

    public function urlRescan($resource): ResponseInterface
    {
        $api = UrlsRequest::getInstance($this->api_key);
        $request = $api->rescan($resource);
        return $this->client->sendRequest($request);
    }

    public function domainReport($domain): ResponseInterface
    {
        $api = DomainsRequest::getInstance($this->api_key);
        $request = $api->report($domain);
        return $this->client->sendRequest($request);
    }

    public function domainRescan($resource): ResponseInterface
    {
        $api = DomainsRequest::getInstance($this->api_key);
        $request = $api->rescan($resource);
        return $this->client->sendRequest($request);
    }

    public function ipReport($ip): ResponseInterface
    {
        $api = IpsRequest::getInstance($this->api_key);
        $request = $api->report($ip);
        return $this->client->sendRequest($request);
    }

    public function ipRescan($resource): ResponseInterface
    {
        $api = IpsRequest::getInstance($this->api_key);
        $request = $api->rescan($resource);
        return $this->client->sendRequest($request);
    }

    public function fileScan($pathFile)
    {
        $api = FilesRequest::getInstance($this->api_key);
        $request = $api->scan($pathFile);
        return $this->client->sendRequest($request);
    }

    protected function fileRescan($hash)
    {

    }

    public function fileReport($hash): ResponseInterface
    {
        $api = FilesRequest::getInstance($this->api_key);
        $request = $api->report($hash);
        return $this->client->sendRequest($request);
    }
}
