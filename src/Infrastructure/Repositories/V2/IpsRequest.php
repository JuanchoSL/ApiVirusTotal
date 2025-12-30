<?php declare(strict_types=1);

namespace JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V2;

use Fig\Http\Message\RequestMethodInterface;
use JuanchoSL\ApiVirusTotal\Infrastructure\Contracts\ReportableInterface;
use Psr\Http\Message\RequestInterface;

class IpsRequest extends AbstractVirusTotalV2 implements ReportableInterface
{
    public function report(string $value): RequestInterface
    {
        $uri = $this->uri_factory
            ->createUri($this->apiURL . "/ip-address/report")
            ->withQuery(http_build_query(['apikey' => $this->apiKey, 'ip' => $value]));
        return $this->requester->createRequest(RequestMethodInterface::METHOD_GET, $uri);
    }

}