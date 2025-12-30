<?php declare(strict_types=1);

namespace JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\V2;

use JuanchoSL\ApiVirusTotal\Infrastructure\Repositories\AbstractVirusTotal;


class AbstractVirusTotalV2 extends AbstractVirusTotal
{

    protected $apiURL = 'https://www.virustotal.com/vtapi/v2';

}
