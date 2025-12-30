<?php declare(strict_types=1);

namespace JuanchoSL\ApiVirusTotal\Infrastructure\Repositories;

use JuanchoSL\HttpData\Factories\RequestFactory;
use JuanchoSL\HttpData\Factories\StreamFactory;
use JuanchoSL\HttpData\Factories\UriFactory;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

abstract class AbstractVirusTotal
{

    protected string $apiKey;
    protected RequestFactoryInterface $requester;
    protected UriFactoryInterface $uri_factory;
    protected StreamFactoryInterface $stream_factory;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->requester = new RequestFactory;
        $this->uri_factory = new UriFactory;
        $this->stream_factory = new StreamFactory;
    }

    public static function getInstance(string $api_key): static
    {
        $class = get_called_class();
        return new $class($api_key);
    }
}
