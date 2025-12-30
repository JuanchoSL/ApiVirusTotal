<?php declare(strict_types=1);

namespace JuanchoSL\ApiVirusTotal\Infrastructure\Contracts;

interface ScanneableInterface
{
    public function scan(string $resource): mixed;
}