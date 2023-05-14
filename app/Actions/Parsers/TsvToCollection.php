<?php

namespace App\Actions\Parsers;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class TsvToCollection
{
    public function __construct(public string $pathToFile, public $limit = null) {}

    public function handle() : Collection
    {
        try {
            $parsed = collect();

            $file = Storage::disk('s3')->get($this->pathToFile);
            
            $rows = explode("\r\n", $file);
            unset($rows[0]);

            foreach($rows as $row) { 
                $data = explode("\t", $row);
                $data = array_filter($data);
                $data = array_values($data);
                $parsed->push($data);
            }
    
            if ($this->limit) {
                return $parsed->take($this->limit);
            }

            return $parsed;

        } catch (Exception) {
            return collect();
        }
    }
}