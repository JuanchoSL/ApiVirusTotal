<?php declare(strict_types=1);

namespace JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V3;

use JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\AbstractVirusTotal;


class AbstractVirusTotalV3 extends AbstractVirusTotal
{

    protected $apiURL = 'https://www.virustotal.com/api/v3';

}
