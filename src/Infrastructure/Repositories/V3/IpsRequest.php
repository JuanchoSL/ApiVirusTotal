<?php declare(strict_types=1);

namespace JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V3;

use Fig\Http\Message\RequestMethodInterface;
use JuanchoSL\ApiVirusTotal\Infrastructure\Contracts\ReportableInterface;
use JuanchoSL\ApiVirusTotal\Infrastructure\Contracts\ReScanneableInterface;
use JuanchoSL\DataManipulation\Manipulators\Strings\StringsManipulators;
use JuanchoSL\Validators\Types\Strings\StringValidations;
use Psr\Http\Message\RequestInterface;

class IpsRequest extends AbstractVirusTotalV3 implements ReportableInterface, ReScanneableInterface
{
    public function report(string $value): RequestInterface
    {
        $uri = $this->uri_factory->createUri($this->apiURL . sprintf("/ip_addresses/%s", $value));
        return $this->requester->createRequest(RequestMethodInterface::METHOD_GET, $uri)
            ->withAddedHeader('x-apikey', $this->apiKey)
            ->withAddedHeader('Accept', 'application/json')
        ;
    }

    public function rescan(string $value): RequestInterface
    {
        if ((new StringValidations())->isValueValidatingAny((new StringValidations())->isIpV4(), (new StringValidations())->isIpV6())->getResult($value)) {
            $value = (new StringsManipulators($value))->base64Encode();//->concatenation('i', '-')->__tostring();
        }
        $uri = $this->uri_factory->createUri($this->apiURL . sprintf("/ip_addresses/%s/analyse", (string) $value));
        return $this->requester->createRequest(RequestMethodInterface::METHOD_POST, $uri)
            ->withAddedHeader('x-apikey', $this->apiKey)
            ->withAddedHeader('Accept', 'application/json')
        ;
    }
}