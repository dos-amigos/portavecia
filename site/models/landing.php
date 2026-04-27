<?php

use Kirby\Cms\Page;

class LandingPage extends Page
{
    public function metadata(): array
    {
        $site = $this->site();

        $schemas = [];

        // 1. LocalBusiness JSON-LD with areaServed
        $schemas['LocalBusiness'] = $this->buildLocalBusinessSchema($site);

        // 2. FAQPage JSON-LD from structure field
        $faqSchema = $this->buildFaqSchema();
        if ($faqSchema) {
            $schemas['FAQPage'] = $faqSchema;
        }

        // 3. BreadcrumbList JSON-LD
        $schemas['BreadcrumbList'] = $this->buildBreadcrumbSchema($site);

        return [
            'jsonld' => $schemas,
        ];
    }

    protected function buildLocalBusinessSchema($site): array
    {
        $schema = [
            '@type'          => 'Restaurant',
            'name'           => $site->title()->value(),
            'description'    => $this->description()->isNotEmpty()
                ? $this->description()->value()
                : 'Enoteca con cucina cinese autentica fatta in casa nel centro storico di Este',
            'url'            => $site->url(),
            'telephone'      => $site->phone()->value(),
            'servesCuisine'  => ['Italian Wine Bar', 'Authentic Chinese Cuisine', 'Wenzhou Cuisine'],
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
        ];

        // areaServed based on page slug
        $slug = $this->slug();
        $areas = [];

        if (str_contains($slug, 'colli-euganei')) {
            $areas = ['Este', 'Colli Euganei', 'Monselice', 'Montagnana', 'Abano Terme', 'Padova'];
        } elseif (str_contains($slug, 'monselice') || str_contains($slug, 'montagnana')) {
            $areas = ['Monselice', 'Montagnana', 'Este', 'Conselve', 'Solesino'];
        } else {
            $areas = ['Este', 'Padova', 'Colli Euganei'];
        }

        $schema['areaServed'] = array_map(function ($area) {
            return [
                '@type' => 'City',
                'name'  => $area,
            ];
        }, $areas);

        // Image
        if ($this->thumbnail()->isNotEmpty()) {
            $thumb = $this->thumbnail()->toFile();
            if ($thumb) {
                $schema['image'] = $thumb->url();
            }
        }

        return $schema;
    }

    protected function buildFaqSchema(): ?array
    {
        $faq = $this->faq()->toStructure();

        if ($faq->count() === 0) {
            return null;
        }

        $mainEntity = [];
        foreach ($faq as $item) {
            $mainEntity[] = [
                '@type' => 'Question',
                'name'  => $item->question()->value(),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => $item->answer()->value(),
                ],
            ];
        }

        return [
            '@type'      => 'FAQPage',
            'mainEntity' => $mainEntity,
        ];
    }

    protected function buildBreadcrumbSchema($site): array
    {
        return [
            '@type'           => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type'    => 'ListItem',
                    'position' => 1,
                    'name'     => 'Home',
                    'item'     => $site->url(),
                ],
                [
                    '@type'    => 'ListItem',
                    'position' => 2,
                    'name'     => $this->title()->value(),
                    'item'     => $this->url(),
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
