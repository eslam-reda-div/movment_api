<?php

namespace App\Observers;

use App\Models\Company;

class CompanyObserver
{
    public function updated(Company $company)
    {
        // Check if bus_limit was changed
        if ($company->wasChanged('bus_limit')) {
            $activeBusesCount = $company->buses()->where('is_active', true)->count();

            // If new bus_limit is less than current active buses
            if ($company->bus_limit < $activeBusesCount) {
                // Get the number of buses that need to be deactivated
                $busesToDeactivate = $activeBusesCount - $company->bus_limit;

                // First, try to deactivate buses without drivers
                $deactivatedCount = $company->buses()
                    ->where('is_active', true)
                    ->whereNull('driver_id')
                    ->latest()
                    ->limit($busesToDeactivate)
                    ->update(['is_active' => false]);

                // If we still need to deactivate more buses
                $remainingToDeactivate = $busesToDeactivate - $deactivatedCount;
                if ($remainingToDeactivate > 0) {
                    // Then deactivate buses with drivers
                    $company->buses()
                        ->where('is_active', true)
                        ->whereNotNull('driver_id')
                        ->latest()
                        ->limit($remainingToDeactivate)
                        ->update(['is_active' => false]);
                }
            }
        }
    }
}
