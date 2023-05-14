<?php

namespace App\Actions\Pilots;

use Illuminate\Http\Request;

final readonly class GenerateStaffingRequest
{
    public function __construct(public array $data) {}

    public function handle() : Request
    {
        return new Request([
            'list_date' => $this->data['list_date'],
            'total_pilot_count' => $this->data['total_pilot_count'],
            'active_pilot_count' => $this->data['active_pilot_count'],
            'inactive_pilot_count' => $this->data['inactive_pilot_count'],
            'net_gain_loss' => $this->data['net_gain_loss'],
            'ytd_gain_loss' => $this->data['ytd_gain_loss'],
            'average_age' => $this->data['average_age']
        ]);
    }
}