<?php

return function ($page) {
    $now = time();
    $events = $page->events()->toStructure();

    $upcoming = $events->filter(function ($event) use ($now) {
        return $event->event_date()->toDate() >= $now;
    })->sortBy('event_date', 'asc');

    $past = $events->filter(function ($event) use ($now) {
        return $event->event_date()->toDate() < $now;
    })->sortBy('event_date', 'desc');

    return compact('upcoming', 'past');
};
