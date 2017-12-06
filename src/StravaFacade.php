<?php

namespace KjellKnapen\Strava;
use Illuminate\Support\Facades\Facade;

class StravaFacade extends Facade{
    protected static function getFacadeAccessor() {
        return 'Strava';
    }
}