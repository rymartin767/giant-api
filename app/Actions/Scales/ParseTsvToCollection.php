<?php

namespace App\Actions\Scales;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

final class ParseTsvToCollection
{
    public function __construct(private string $pathToTsv) {}

    public function handle() : Collection
    {
        try {
            $collection = collect();

            $file = Storage::disk('public')->get($this->pathToTsv);
            
            $rows = explode("\r\n", $file);
            unset($rows[0]);
            
            foreach($rows as $row) { 
                $data = explode("\t", $row);
                $data = array_filter($data);
                $data = collect(array_values($data));
                $collection->push($data);
            }
    
            return $collection;
        } catch (Exception) {
            return collect();
        }
    }
}