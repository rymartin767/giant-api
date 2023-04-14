// Model Response 
'v1/airlines?icao=GTI'

'data' => [
    [
        'id' => $data->id,
        'sector' => $data->sector,
        'name' => $data->name,
        'icao' => $data->icao,
        'iata' => $data->iata,
        'union' => $data->union,
        'pilot_count' => $data->pilot_count,
        'is_hiring' => $data->is_hiring,
        'web_url' => $data->web_url,
    ]
]

// Collection Response without Pay Scales 
'v1/airlines'

'data' => [
    [
        'id' => $data->id,
        'sector' => $data->sector,
        'name' => $data->name,
        'icao' => $data->icao,
        'iata' => $data->iata,
        'union' => $data->union,
        'pilot_count' => $data->pilot_count,
        'is_hiring' => $data->is_hiring,
        'web_url' => $data->web_url,
    ],
    [
        'id' => $data->id,
        'sector' => $data->sector,
        'name' => $data->name,
        'icao' => $data->icao,
        'iata' => $data->iata,
        'union' => $data->union,
        'pilot_count' => $data->pilot_count,
        'is_hiring' => $data->is_hiring,
        'web_url' => $data->web_url,
    ],
]

// Collection Response wit Pay Scales 
'v1/airlines?scales=true'

'data' => [
    [
        'id' => $data->id,
        'sector' => $data->sector,
        'name' => $data->name,
        'icao' => $data->icao,
        'iata' => $data->iata,
        'union' => $data->union,
        'pilot_count' => $data->pilot_count,
        'is_hiring' => $data->is_hiring,
        'web_url' => $data->web_url,
        'scales' => []
    ],
    [
        'id' => $data->id,
        'sector' => $data->sector,
        'name' => $data->name,
        'icao' => $data->icao,
        'iata' => $data->iata,
        'union' => $data->union,
        'pilot_count' => $data->pilot_count,
        'is_hiring' => $data->is_hiring,
        'web_url' => $data->web_url,
        'scales' => [
            [
                'airline_id' => 2,
                'year' => 1,
                'fleet' => '737',
                'ca_rate' => 100.10,
                'fo_rate' => 50.20
            ],
        ]
    ],
]