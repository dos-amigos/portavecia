<?php

use Kirby\Cms\Page;

class ContactPage extends Page
{
    public function metadata(): array
    {
        $site = $this->site();

        return [
            'jsonld' => [
                'Restaurant' => [
                    '@type'          => 'Restaurant',
                    'name'           => $site->title()->value(),
                    'description'    => $this->description()->isNotEmpty()
                        ? $this->description()->value()
                        : 'Enoteca con cucina cinese autentica fatta in casa nel centro storico di Este',
                    'url'            => $site->url(),
                    'telephone'      => $site->phone()->value(),
                    'servesCuisine'  => ['Italian Wine Bar', 'Chinese Cuisine'],
                    'priceRange'     => '$$',
                    'address'        => [
                        '@type'            => 'PostalAddress',
                        'streetAddress'    => $site->street_address()->value(),
                        'addressLocality'  => $site->city()->or('Este')->value(),
                        'addressRegion'    => 'PD',
                        'postalCode'       => $site->postal_code()->or('35042')->value(),
                        'addressCountry'   => 'IT',
                    ],
                    'geo' => [
                        '@type'     => 'GeoCoordinates',
                        'latitude'  => $site->latitude()->value(),
                        'longitude' => $site->longitude()->value(),
                    ],
                    'openingHoursSpecification' => $this->buildOpeningHours($site),
                    'image' => $this->thumbnail()->isNotEmpty()
                        ? $this->thumbnail()->toFile()?->url()
                        : null,
                ],
            ],
        ];
    }

    protected function buildOpeningHours($site): array
    {
        $dayMap = [
            'lunedi' => 'Monday', 'lunedì' => 'Monday',
            'martedi' => 'Tuesday', 'martedì' => 'Tuesday',
            'mercoledi' => 'Wednesday', 'mercoledì' => 'Wednesday',
            'giovedi' => 'Thursday', 'giovedì' => 'Thursday',
            'venerdi' => 'Friday', 'venerdì' => 'Friday',
            'sabato' => 'Saturday',
            'domenica' => 'Sunday',
        ];

        $specs = [];
        if ($site->hours()->isNotEmpty()) {
            foreach ($site->hours()->toStructure() as $entry) {
                $dayText = mb_strtolower(trim($entry->day()->value()));
                $timeText = trim($entry->time()->value());
                $englishDay = $dayMap[$dayText] ?? null;
                if (!$englishDay) continue;

                if (preg_match('/(\d{1,2}[.:]\d{2})\s*[-\x{2013}]\s*(\d{1,2}[.:]\d{2})/u', $timeText, $m)) {
                    $opens  = str_replace('.', ':', $m[1]);
                    $closes = str_replace('.', ':', $m[2]);
                    $specs[] = [
                        '@type'     => 'OpeningHoursSpecification',
                        'dayOfWeek' => $englishDay,
                        'opens'     => $opens,
                        'closes'    => $closes,
                    ];
                }
            }
        }

        return $specs;
    }
}
