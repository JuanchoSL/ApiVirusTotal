<?php declare(strict_types=1);

namespace JuanchoSL\ApiVirusTotal\Infrastructure\Contracts;

interface ReportableInterface
{
    public function report(string $resource): mixed;
}