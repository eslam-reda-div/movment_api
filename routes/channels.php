<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('company.{companyId}', function ($user, $companyId) {
    return $user->id == $companyId;
});

Broadcast::channel('bus-location.{busUuid}', function ($user, $busUuid) {
    $bus = \App\Models\Bus::where('uuid', $busUuid)->first();

    return $user->id === $bus?->company_id;
});
