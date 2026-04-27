<?php

use Kirby\Cms\Page;

class GalleryPage extends Page
{
    public function metadata(): array
    {
        $site = $this->site();

        return [
            'jsonld' => [
                'ImageGallery' => $this->buildImageGallerySchema($site),
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

    protected function buildImageGallerySchema($site): array
    {
        $schema = [
            '@type'       => 'ImageGallery',
            'name'        => $this->title()->value() . ' - ' . $site->title()->value(),
            'description' => $this->description()->isNotEmpty()
                ? $this->description()->value()
                : 'Galleria fotografica di Porta Vecia: locale, piatti, vini ed eventi',
            'url'         => $this->url(),
            'about'       => [
                '@type' => 'Restaurant',
                'name'  => $site->title()->value(),
                'url'   => $site->url(),
            ],
        ];

        // Add images from page files
        $images = $this->images()->sortBy('sort');
        if ($images->count() > 0) {
            $imageObjects = [];
            foreach ($images as $image) {
                $imageObj = [
                    '@type'      => 'ImageObject',
                    'contentUrl' => $image->url(),
                    'name'       => $image->alt()->or($image->caption())->or($image->filename())->value(),
                ];

                if ($image->caption()->isNotEmpty()) {
                    $imageObj['caption'] = $image->caption()->value();
                }

                $imageObjects[] = $imageObj;
            }
            $schema['image'] = $imageObjects;
        }

        return $schema;
    }
}
