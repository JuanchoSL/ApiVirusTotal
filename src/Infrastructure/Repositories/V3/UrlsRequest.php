<?php declare(strict_types=1);

namespace JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V3;

use Fig\Http\Message\RequestMethodInterface;
use JuanchoSL\ApiVirusTotal\Infrastructure\Contracts\ReportableInterface;
use JuanchoSL\ApiVirusTotal\Infrastructure\Contracts\ReScanneableInterface;
use JuanchoSL\ApiVirusTotal\Infrastructure\Contracts\ScanneableInterface;
use JuanchoSL\DataManipulation\Manipulators\Strings\StringsManipulators;
use JuanchoSL\Validators\Types\Strings\StringValidation;
use Psr\Http\Message\RequestInterface;

class UrlsRequest extends AbstractVirusTotalV3 implements ReportableInterface, ReScanneableInterface, ScanneableInterface
{

    public function report(string $value): RequestInterface
    {
        $uri = $this->uri_factory->createUri($this->apiURL . sprintf("/urls/%s", $this->validateOrConvert($value)));
        return $this->requester->createRequest(RequestMethodInterface::METHOD_GET, $uri)
            ->withAddedHeader('x-apikey', $this->apiKey)
            ->withAddedHeader('Accept', 'application/json')
        ;
    }

    public function scan(string $value): RequestInterface
    {
        $uri = $this->uri_factory->createUri($this->apiURL . "/urls");
        $stream = $this->stream_factory->createStream(http_build_query(['url' => $value]));
        return $this->requester->createRequest(RequestMethodInterface::METHOD_POST, $uri)
            ->withAddedHeader("Content-Type", "application/x-www-form-urlencoded")
            ->withAddedHeader('x-apikey', $this->apiKey)
            ->withAddedHeader('Accept', 'application/json')
            ->withBody($stream)
        ;
    }

    public function rescan(string $value): RequestInterface
    {
        $uri = $this->uri_factory->createUri($this->apiURL . sprintf("/urls/%s/analyse", $this->validateOrConvert($value)));
        return $this->requester->createRequest(RequestMethodInterface::METHOD_POST, $uri)
            ->withAddedHeader('x-apikey', $this->apiKey)
            ->withAddedHeader('Accept', 'application/json')
        ;
    }

    protected function validateOrConvert(string $value): string
    {
        if (StringValidation::isUrl($value)) {
            $value = (new StringsManipulators($value))->base64Encode();//->preppend('u', '-');
        }
        return (string) $value;
    }
}