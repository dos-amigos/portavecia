<?php

return function ($site) {
    return [
        'phone'    => $site->phone()->value(),
        'whatsapp' => $site->whatsapp()->value(),
        'email'    => $site->email()->value(),
        'address'  => $site->address()->value(),
        'hours'    => $site->hours()->toStructure(),
        'social'   => $site->social()->toStructure(),
    ];
};
