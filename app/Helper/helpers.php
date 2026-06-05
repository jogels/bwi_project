<?php

function FormatRupiah($angka) {
  $number = "Rp " . number_format($angka,2,',','.');

  return $number;
}

function FormatRupiahFront($angka) {
  $number = "Rp. " . number_format($angka,0,',','.');

  return $number;
}


function getsingkatan($s) {
  if(preg_match_all('/\b(\w)/',strtoupper($s),$m)) {
      $v = implode('',$m[1]); // $v is now SOQTU
  }

  return $v;
  // die();
}

function stringlimit($string, $limit, $end) {
  return str_limit($string, $limit, $end);
}

function compressImage($type,$source, $destination, $quality) {

   $info = getimagesize($source);

   if ($type == 'image/jpeg')
     $image = imagecreatefromjpeg($source);

   elseif ($type == 'image/gif')
     $image = imagecreatefromgif($source);

   elseif ($type == 'image/png')
     $image = imagecreatefrompng($source);

   elseif ($type == 'image/jpg')
     $image = imagecreatefromjpeg($source);

   elseif ($type == 'gif')
     $image = imagecreatefromgif($source);

   elseif ($type == 'png')
     $image = imagecreatefrompng($source);

   elseif ($type == 'jpg')
     $image = imagecreatefromjpeg($source);

   elseif ($type == 'jpeg')
     $image = imagecreatefromjpeg($source);

   imagejpeg($image, $destination, $quality);

 }

function parseWakafCoordinate($value): ?float
{
    if ($value === null || $value === '') {
        return null;
    }

    if (is_numeric($value)) {
        return (float) $value;
    }

    $normalized = str_replace(',', '.', trim((string) $value));

    return is_numeric($normalized) ? (float) $normalized : null;
}

function normalizeWakafCoordinates(?float $lat, ?float $lng): array
{
    if ($lat === null || $lng === null) {
        return [null, null];
    }

    if ($lng > 1000) {
        $lngDigits = preg_replace('/\D/', '', (string) $lng);
        if (strlen($lngDigits) >= 4) {
            $lng = (float) (substr($lngDigits, 0, 3) . '.' . substr($lngDigits, 3));
        }
    }

    if ($lat < 0 && $lat > -7 && $lng > 0 && $lng < 10) {
        $lng = $lng * 100;
    }

    if ($lat > 90 && abs($lng) <= 90) {
        [$lat, $lng] = [$lng, $lat];
    }

    if (abs($lat) > 90 || abs($lng) > 180) {
        return [null, null];
    }

    return [$lat, $lng];
}

function isValidJakartaCoordinate(?float $lat, ?float $lng): bool
{
    if ($lat === null || $lng === null) {
        return false;
    }

    if ($lat == 0.0 && $lng == 0.0) {
        return false;
    }

    return $lat < -5.8 && $lat > -6.5 && $lng > 106.5 && $lng < 107.2;
}

function geocodeWakafAddress(string $query): ?array
{
    $url = 'https://nominatim.openstreetmap.org/search?' . http_build_query([
        'q' => $query,
        'format' => 'json',
        'limit' => 1,
        'countrycodes' => 'id',
    ]);

    $context = stream_context_create([
        'http' => [
            'header' => "User-Agent: BWI-DKI-Jakarta/1.0\r\n",
            'timeout' => 10,
        ],
    ]);

    $response = @file_get_contents($url, false, $context);
    if ($response === false) {
        return null;
    }

    $results = json_decode($response, true);
    if (empty($results[0]['lat']) || empty($results[0]['lon'])) {
        return null;
    }

    return [
        'latitude' => (float) $results[0]['lat'],
        'longitude' => (float) $results[0]['lon'],
    ];
}

function buildWakafGeocodeQueries($wakafLand): array
{
    $address = $wakafLand->address;
    $village = optional($wakafLand->village)->name;
    $subdistrict = optional($wakafLand->subdistrict)->name;
    $city = optional($wakafLand->city)->name;

    return array_values(array_unique(array_filter([
        implode(', ', array_filter([$address, $village, $subdistrict, $city, 'DKI Jakarta', 'Indonesia'])),
        implode(', ', array_filter([$village, $subdistrict, $city, 'DKI Jakarta', 'Indonesia'])),
        implode(', ', array_filter([$subdistrict, $city, 'DKI Jakarta', 'Indonesia'])),
    ])));
}

function resolveWakafLocation($wakafLand): array
{
    $lat = parseWakafCoordinate($wakafLand->latitude);
    $lng = parseWakafCoordinate($wakafLand->longitude);
    [$lat, $lng] = normalizeWakafCoordinates($lat, $lng);
    $geocodeQueries = buildWakafGeocodeQueries($wakafLand);

    if (isValidJakartaCoordinate($lat, $lng)) {
        return [
            'latitude' => $lat,
            'longitude' => $lng,
            'zoom' => 16,
            'geocoded' => false,
            'geocode_queries' => $geocodeQueries,
        ];
    }

    foreach ($geocodeQueries as $query) {
        $geocoded = geocodeWakafAddress($query);
        if ($geocoded && isValidJakartaCoordinate($geocoded['latitude'], $geocoded['longitude'])) {
            return [
                'latitude' => $geocoded['latitude'],
                'longitude' => $geocoded['longitude'],
                'zoom' => 16,
                'geocoded' => true,
                'geocode_queries' => $geocodeQueries,
            ];
        }
    }

    return [
        'latitude' => null,
        'longitude' => null,
        'zoom' => 15,
        'geocoded' => false,
        'geocode_queries' => $geocodeQueries,
    ];
}
