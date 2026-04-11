<?php

use Kirby\Cms\Page;

class EventsPage extends Page
{
    public function metadata(): array
    {
        $site = $this->site();

        return [
            'jsonld' => $this->buildEventsSchema($site),
        ];
    }

    protected function buildEventsSchema($site): array
    {
        $schemas = [];
        $now = time();

        // Build location object (reused for all events)
        $location = [
            '@type'   => 'Place',
            'name'    => $site->title()->value(),
            'address' => [
                '@type'            => 'PostalAddress',
                'streetAddress'    => $site->street_address()->value(),
                'addressLocality'  => $site->city()->or('Este')->value(),
                'addressRegion'    => 'PD',
                'postalCode'       => $site->postal_code()->or('35042')->value(),
                'addressCountry'   => 'IT',
            ],
        ];

        // Add geo if available
        if ($site->latitude()->isNotEmpty() && $site->longitude()->isNotEmpty()) {
            $location['geo'] = [
                '@type'     => 'GeoCoordinates',
                'latitude'  => $site->latitude()->value(),
                'longitude' => $site->longitude()->value(),
            ];
        }

        // Build organizer object
        $organizer = [
            '@type' => 'Organization',
            'name'  => $site->title()->value(),
            'url'   => $site->url(),
        ];

        // Get upcoming events only
        $events = $this->events()->toStructure()->filter(function ($event) use ($now) {
            return $event->event_date()->toDate() >= $now;
        })->sortBy('event_date', 'asc');

        foreach ($events as $index => $event) {
            $schema = [
                '@type'    => 'Event',
                'name'     => $event->title()->value(),
                'location' => $location,
                'organizer' => $organizer,
            ];

            // Build startDate in ISO 8601 format
            $dateTimestamp = $event->event_date()->toDate();
            if ($event->event_time()->isNotEmpty()) {
                $timeValue = $event->event_time()->value();
                $schema['startDate'] = date('Y-m-d', $dateTimestamp) . 'T' . $timeValue . ':00';
            } else {
                $schema['startDate'] = date('Y-m-d', $dateTimestamp);
            }

            // Description
            if ($event->description()->isNotEmpty()) {
                $schema['description'] = $event->description()->value();
            }

            // Image
            if ($event->photo()->isNotEmpty()) {
                $photo = $event->photo()->toFile();
                if ($photo) {
                    $schema['image'] = $photo->url();
                }
            }

            // Event status and attendance mode
            $schema['eventStatus']     = 'https://schema.org/EventScheduled';
            $schema['eventAttendanceMode'] = 'https://schema.org/OfflineEventAttendanceMode';

            $schemas['Event_' . $index] = $schema;
        }

        return $schemas;
    }
}
