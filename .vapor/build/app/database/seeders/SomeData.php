<?php

namespace Database\Seeders;

use App\Models\Domain;
use Illuminate\Database\Seeder;

class SomeData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test companies
        $abc = \App\Models\Company::factory()->create([
            'email' => 'abc@transport.com',
            'password' => bcrypt('password'),
            'bus_limit' => 5,
        ]);

        $city = \App\Models\Company::factory()->create([
            'email' => 'city@express.com',
            'password' => bcrypt('password'),
            'bus_limit' => 5,
        ]);

        $metro = \App\Models\Company::factory()->create([
            'email' => 'metro@lines.com',
            'password' => bcrypt('password'),
            'bus_limit' => 5,
        ]);

        // Create 3 buses for each company (initially without drivers)
        $abcBuses = \App\Models\Bus::factory()->count(3)->create(['company_id' => $abc->id]);
        $cityBuses = \App\Models\Bus::factory()->count(3)->create(['company_id' => $city->id]);
        $metroBuses = \App\Models\Bus::factory()->count(3)->create(['company_id' => $metro->id]);

        // Create drivers for companies and update buses with driver_id
        $driver = \App\Models\Driver::factory()->create([
            'company_id' => $abc->id,
        ]);
        $abcBuses[0]->update(['driver_id' => $driver->id]);

        $driver = \App\Models\Driver::factory()->create([
            'company_id' => $abc->id,
        ]);
        $abcBuses[1]->update(['driver_id' => $driver->id]);

        $driver = \App\Models\Driver::factory()->create([
            'company_id' => $city->id,
        ]);
        $cityBuses[0]->update(['driver_id' => $driver->id]);

        $driver = \App\Models\Driver::factory()->create([
            'company_id' => $city->id,
        ]);
        $cityBuses[1]->update(['driver_id' => $driver->id]);

        $driver = \App\Models\Driver::factory()->create([
            'company_id' => $metro->id,
        ]);
        $metroBuses[0]->update(['driver_id' => $driver->id]);

        $driver = \App\Models\Driver::factory()->create([
            'company_id' => $metro->id,
        ]);
        $metroBuses[1]->update(['driver_id' => $driver->id]);

        // Create additional drivers without bus assignments
        \App\Models\Driver::factory()->create([
            'company_id' => $abc->id,
        ]);

        \App\Models\Driver::factory()->create([
            'company_id' => $city->id,
        ]);

        \App\Models\Driver::factory()->create([
            'company_id' => $metro->id,
        ]);

        // Create 3 independent drivers (no company)
        \App\Models\Driver::factory()->count(3)->create([
            'company_id' => null,
        ]);

        // Create 3 standalone buses (no company or driver)
        \App\Models\Bus::factory()->count(3)->create([
            'company_id' => null,
            'driver_id' => null,
        ]);

        // Create 4 domains with 4 destinations each
        $domains = Domain::factory()->count(4)->create()->each(function ($domain) {
            \App\Models\Destination::factory()->count(4)->create([
                'domain_id' => $domain->id,
                'location' => [
                    'lat' => fake()->latitude(25, 35), // Adjust range as needed
                    'lng' => fake()->longitude(30, 45), // Adjust range as needed
                ],
            ]);
        });

        // Create 5 paths for each company
        foreach ([$abc, $city, $metro] as $company) {
            // Get random domain
            $domain = Domain::inRandomOrder()->first();
            $destinations = $domain->destinations;

            // Path 1 - No stops
            \App\Models\Path::factory()->create([
                'domain_id' => $domain->id,
                'company_id' => $company->id,
                'from' => $destinations->random()->id,
                'to' => $destinations->random()->id,
                'stops' => [],
            ]);

            // Path 2 - One stop
            \App\Models\Path::factory()->create([
                'domain_id' => $domain->id,
                'company_id' => $company->id,
                'from' => $destinations->random()->id,
                'to' => $destinations->random()->id,
                'stops' => [
                    ['destination_id' => $destinations->random()->id],
                ],
            ]);

            // Path 3 - Two stops
            \App\Models\Path::factory()->create([
                'domain_id' => $domain->id,
                'company_id' => $company->id,
                'from' => $destinations->random()->id,
                'to' => $destinations->random()->id,
                'stops' => [
                    ['destination_id' => $destinations->random()->id],
                    ['destination_id' => $destinations->random()->id],
                ],
            ]);

            // Path 4 - Three stops
            \App\Models\Path::factory()->create([
                'domain_id' => $domain->id,
                'company_id' => $company->id,
                'from' => $destinations->random()->id,
                'to' => $destinations->random()->id,
                'stops' => [
                    ['destination_id' => $destinations->random()->id],
                    ['destination_id' => $destinations->random()->id],
                    ['destination_id' => $destinations->random()->id],
                ],
            ]);

            // Path 5 - Four stops
            \App\Models\Path::factory()->create([
                'domain_id' => $domain->id,
                'company_id' => $company->id,
                'from' => $destinations->random()->id,
                'to' => $destinations->random()->id,
                'stops' => [
                    ['destination_id' => $destinations->random()->id],
                    ['destination_id' => $destinations->random()->id],
                    ['destination_id' => $destinations->random()->id],
                    ['destination_id' => $destinations->random()->id],
                ],
            ]);
        }

        // Create 2 trips for each company path
        foreach ([$abc, $city, $metro] as $company) {
            // Get all paths for this company
            $companyPaths = \App\Models\Path::where('company_id', $company->id)->get();

            // Get available drivers for this company that have buses assigned
            $availableDrivers = \App\Models\Driver::where('company_id', $company->id)
                ->whereHas('bus')
                ->get();

            foreach ($companyPaths as $path) {
                for ($i = 0; $i < 2; $i++) {
                    \App\Models\Trip::factory()->create([
                        'company_id' => $company->id,
                        'driver_id' => $availableDrivers->random()->id,
                        'path_id' => $path->id,
                        'start_at_day' => now()->addDays(rand(1, 30)),
                        'start_at_time' => now()->setTime(rand(6, 22), rand(0, 59), 0),
                        'notes' => 'Trip #'.($i + 1)." for path: {$path->name}",
                    ]);
                }
            }
        }
    }
}
