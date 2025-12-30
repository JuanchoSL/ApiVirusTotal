<?php declare(strict_types=1);

namespace JuanchoSL\ApiVirusTotal\Infrastructure\Contracts;

interface ReScanneableInterface
{
    public function rescan(string $resource): mixed;
}