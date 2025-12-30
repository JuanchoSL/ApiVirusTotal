<?php declare(strict_types=1);

namespace JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V2;

use Fig\Http\Message\RequestMethodInterface;
use JuanchoSL\ApiVirusTotal\Infrastructure\Contracts\ReportableInterface;
use JuanchoSL\ApiVirusTotal\Infrastructure\Contracts\SendableInterface;
use Psr\Http\Message\RequestInterface;

class CommentsRequest extends AbstractVirusTotalV2 implements SendableInterface, ReportableInterface
{

    public function send(string $value, $comment): RequestInterface
    {
        $uri = $this->uri_factory->createUri($this->apiURL . "/comments/put");
        $stream = $this->stream_factory->createStream(http_build_query(['apikey' => $this->apiKey, 'resource' => $value, 'comment' => $comment]));
        return $this->requester
            ->createRequest(RequestMethodInterface::METHOD_POST, $uri)
            ->withBody($stream)
            ->withAddedHeader("Content-Type", "application/x-www-form-urlencoded");
    }

    public function report(string $value): RequestInterface
    {
        $uri = $this->uri_factory
            ->createUri($this->apiURL . "/comments/get")
            ->withQuery(http_build_query(['apikey' => $this->apiKey, 'domain' => $value]));
        return $this->requester->createRequest(RequestMethodInterface::METHOD_GET, $uri);
    }
}