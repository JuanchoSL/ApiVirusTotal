<?php declare(strict_types=1);

namespace JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V2;

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

class FilesRequest extends AbstractVirusTotalV2 implements ReportableInterface, ScanneableInterface, ReScanneableInterface
{

    public function report(string $value): RequestInterface
    {
        $uri = $this->uri_factory
            ->createUri($this->apiURL . "/file/report")
            ->withQuery(http_build_query(['apikey' => $this->apiKey, 'resource' => $value]));
        return $this->requester->createRequest(RequestMethodInterface::METHOD_GET, $uri);
    }

    public function scan(string $value): RequestInterface
    {
        if (!file_exists($value)) {
            throw new Exception("El fichero no existe");
        }
        //$endPoint = "file/scan";
        //$memory = intval(ini_get('memory_limit'));
        //$fileSize = filesize($value);
        if (filesize($value) > intval((string) (new NumbersManipulators(32))->product(1024)->product(1024))) {
            throw new PreconditionFailedException("The max filesize is 32 Mb");
        }
        /*
        if ($fileSize > ($memory * 1048576)) {
            ini_set('memory_limit', $fileSize + $memory);
        }
*/
        $multipart = new MultipartCreator(md5(uniqid()));
        $multipart->appendData([
            'apikey' => $this->apiKey,
            'name' => pathinfo($value, PATHINFO_FILENAME),
            'file' => "@" . $value
        ]);
        $uri = $this->uri_factory->createUri($this->apiURL . "/file/scan");

        return $this->requester
            ->createRequest(RequestMethodInterface::METHOD_POST, $uri)
            ->withBody((new StreamFactory())->createStream((string) $multipart))
            ->withAddedHeader('Content-Type', 'multipart/form-data');
    }

    public function rescan(string $value): RequestInterface
    {
        $uri = $this->uri_factory->createUri($this->apiURL . "/file/rescan");
        $stream = $this->stream_factory->createStream(http_build_query(['apikey' => $this->apiKey, 'resource' => $value]));
        return $this->requester
            ->createRequest(RequestMethodInterface::METHOD_POST, $uri)
            ->withBody($stream)
            ->withAddedHeader('Content-Type', 'application/x-www-form-urlencoded');
    }
}