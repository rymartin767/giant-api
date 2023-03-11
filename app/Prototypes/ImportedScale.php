<?php

namespace App\Prototypes;

use Illuminate\Support\Collection;

final class ImportedScale
{
    public $year;

    public $fleet;

    public $ca_rate;

    public $fo_rate;

    public function __construct(public int $airline_id, private Collection $row) 
    {
        $this->year = intval($row[0]);
        $this->fleet = $row[1];
        $this->ca_rate = intval($row[2]);
        $this->fo_rate = intval($row[3]);
    }
}