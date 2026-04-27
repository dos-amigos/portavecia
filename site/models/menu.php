<?php

use Kirby\Cms\Page;

class MenuPage extends Page
{
    public function metadata(): array
    {
        $site = $this->site();
        $whatsappNumber = str_replace(['+', ' '], '', $site->whatsapp()->value());

        return [
            'jsonld' => [
                'Restaurant' => $this->buildRestaurantSchema($site, $whatsappNumber),
                'Menu' => $this->buildMenuSchema(),
                'BreadcrumbList' => [
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
                ],
            ],
        ];
    }

    protected function buildMenuSchema(): array
    {
        $categories = [
            'antipasti' => 'Antipasti',
            'primi'     => 'Primi Piatti',
            'secondi'   => 'Secondi Piatti',
            'zuppe'     => 'Zuppe',
            'dolci'     => 'Dolci',
        ];

        $menuSections = [];

        foreach ($categories as $field => $label) {
            $dishes = $this->$field()->toStructure();
            if ($dishes->count() === 0) continue;

            $menuItems = [];
            foreach ($dishes as $dish) {
                $item = [
                    '@type' => 'MenuItem',
                    'name'  => $dish->dish_name()->value(),
                ];

                if ($dish->description()->isNotEmpty()) {
                    $item['description'] = $dish->description()->value();
                }

                if ($dish->price()->isNotEmpty()) {
                    $item['offers'] = [
                        '@type'         => 'Offer',
                        'price'         => $dish->price()->value(),
                        'priceCurrency' => 'EUR',
                    ];
                }

                $menuItems[] = $item;
            }

            $menuSections[] = [
                '@type'        => 'MenuSection',
                'name'         => $label,
                'hasMenuItem'  => $menuItems,
            ];
        }

        return [
            '@type'          => 'Menu',
            'name'           => 'Menu Porta Vecia',
            'description'    => 'Cucina cinese autentica di Wenzhou fatta in casa',
            'hasMenuSection' => $menuSections,
        ];
    }

    protected function buildRestaurantSchema($site, string $whatsappNumber): array
    {
        return [
            '@type'              => ['Restaurant', 'WineBar', 'LocalBusiness'],
            'name'               => $site->title()->value(),
            'description'        => $this->description()->isNotEmpty()
                ? $this->description()->value()
                : 'Enoteca con cucina cinese autentica fatta in casa nel centro storico di Este',
            'url'                => $site->url(),
            'telephone'          => $site->phone()->value(),
            'email'              => $site->email()->value(),
            'servesCuisine'      => ['Cucina Cinese Autentica', 'Cucina di Wenzhou', 'Wine Bar', 'Aperitivo'],
            'priceRange'         => '€€',
            'acceptsReservations' => true,
            'hasMenu'            => $this->url(),
            'paymentAccepted'    => 'Cash, Credit Card',
            'currenciesAccepted' => 'EUR',
            'address'            => [
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
            'areaServed' => [
                ['@type' => 'City', 'name' => 'Este'],
                ['@type' => 'City', 'name' => 'Monselice'],
                ['@type' => 'City', 'name' => 'Montagnana'],
                ['@type' => 'City', 'name' => 'Abano Terme'],
                ['@type' => 'City', 'name' => 'Padova'],
                ['@type' => 'Place', 'name' => 'Colli Euganei'],
            ],
            'founder' => [
                '@type'       => 'Person',
                'name'        => 'Angela',
                'birthPlace'  => [
                    '@type' => 'City',
                    'name'  => 'Wenzhou',
                    'containedInPlace' => [
                        '@type' => 'Country',
                        'name'  => 'China',
                    ],
                ],
            ],
            'sameAs' => [
                'https://www.instagram.com/portaveciaeste/',
            ],
            'keywords' => 'enoteca este, cucina cinese este, wine bar este, aperitivo este, ravioli cinesi este, cucina di wenzhou, ristorante cinese padova, enoteca colli euganei, vini este, porta vecia',
            'image' => $this->thumbnail()->isNotEmpty()
                ? $this->thumbnail()->toFile()?->url()
                : null,
            'potentialAction' => [
                '@type'  => 'ReserveAction',
                'target' => [
                    '@type'       => 'EntryPoint',
                    'urlTemplate' => 'https://wa.me/' . $whatsappNumber,
                    'actionPlatform' => [
                        'https://schema.org/DesktopWebPlatform',
                        'https://schema.org/MobileWebPlatform',
                    ],
                ],
                'result' => [
                    '@type'          => 'Reservation',
                    'name'           => 'Prenota un tavolo a Porta Vecia',
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
