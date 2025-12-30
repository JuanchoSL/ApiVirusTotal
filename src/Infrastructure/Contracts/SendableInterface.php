<?php declare(strict_types=1);

namespace JuanchoSL\ApiVirusTotal\Infrastructure\Contracts;

interface SendableInterface
{
    public function send(string $resource, $data): mixed;
}