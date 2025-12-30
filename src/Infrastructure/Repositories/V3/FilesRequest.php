<?php declare(strict_types=1);

namespace JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V3;

use Exception;
use Fig\Http\Message\RequestMethodInterface;
use JuanchoSL\ApiVirusTotal\Infrastructure\Contracts\ReportableInterface;
use JuanchoSL\ApiVirusTotal\Infrastructure\Contracts\ReScanneableInterface;
use JuanchoSL\ApiVirusTotal\Infrastructure\Contracts\ScanneableInterface;
use JuanchoSL\DataManipulation\Manipulators\Numbers\NumbersManipulators;
use JuanchoSL\Exceptions\PreconditionFailedException;
use JuanchoSL\HttpData\Bodies\Creators\MultipartCreator;
use JuanchoSL\HttpData\Factories\StreamFactory;
use Psr\Http\Message\RequestInterface;

class FilesRequest extends AbstractVirusTotalV3 implements ReportableInterface, ScanneableInterface, ReScanneableInterface
{

    public function scan(string $value): RequestInterface
    {
        if (!file_exists($value)) {
            throw new Exception("El fichero no existe");
        }
        if (filesize($value) > intval((string) (new NumbersManipulators(32))->product(1024)->product(1024))) {
            throw new PreconditionFailedException("The max filesize is 32 Mb");
        }
        $multipart = new MultipartCreator(md5(uniqid()));
        $multipart->appendData([
            'file' => "@" . $value
        ]);
        $uri = $this->uri_factory->createUri($this->apiURL . "/files");

        return $this->requester->createRequest(RequestMethodInterface::METHOD_POST, $uri)
            ->withAddedHeader('x-apikey', $this->apiKey)
            ->withAddedHeader('Accept', 'application/json')
            ->withBody((new StreamFactory())->createStream((string) $multipart))
            ->withAddedHeader('Content-Type', 'multipart/form-data');
    }

    public function rescan(string $value): RequestInterface
    {
        $uri = $this->uri_factory->createUri($this->apiURL . sprintf("/files/%s/analyse", $value));
        return $this->requester->createRequest(RequestMethodInterface::METHOD_POST, $uri)
            ->withAddedHeader('x-apikey', $this->apiKey)
            ->withAddedHeader('Accept', 'application/json');
    }

    public function report(string $value): RequestInterface
    {
        $uri = $this->uri_factory->createUri($this->apiURL . sprintf("/files/%s", $value));
        return $this->requester->createRequest(RequestMethodInterface::METHOD_GET, $uri)
            ->withAddedHeader('x-apikey', $this->apiKey)
            ->withAddedHeader('Accept', 'application/json');
    }
}