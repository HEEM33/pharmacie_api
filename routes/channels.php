<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('ventes', function () { 
    return true; 
});