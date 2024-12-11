<?php

namespace App\Http\Controllers\Driver;

use App\Enums\TripStatus;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

/**
 * @OA\Response(
 *     response="UnauthorizedResponse",
 *     description="Unauthenticated",
 *
 *     @OA\JsonContent(
 *
 *         @OA\Property(property="message", type="string", example="Unauthenticated")
 *     )
 * )
 */
class DriverController extends Controller
{
    use ApiResponseTrait;

    /**
     * @OA\Get(
     *     path="/api/app/driver/get-bus",
     *     summary="Get driver's assigned bus",
     *     tags={"Driver app"},
     *     security={{ "sanctum": {} }},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Bus data retrieved successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Bus data retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/UnauthorizedResponse"
     *     )
     * )
     */
    public function getBus(Request $request)
    {
        $bus = $request?->user()?->bus?->load([
            'company',
        ]);

        if (! $bus) {
            return $this->sendError('You do not have a bus assigned to you', [], 404);
        }

        if (! $bus?->is_active) {
            return $this->sendError('Your bus is not active', [], 404);
        }

        return $this->sendResponse('Bus data retrieved successfully', $bus);
    }

    /**
     * @OA\Get(
     *     path="/api/app/driver/get-all-trips",
     *     summary="Get all trips assigned to driver",
     *     tags={"Driver app"},
     *     security={{ "sanctum": {} }},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Trips data retrieved successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Trips data retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/UnauthorizedResponse"
     *     )
     * )
     */
    public function getAllTrips(Request $request)
    {
        $trips = $request?->user()?->trips?->load([
            'path',
            'path.fromDestination',
            'path.toDestination',
            'path.domain',
        ]);

        if ($trips->isEmpty()) {
            return $this->sendError('You do not have any trips assigned to you', [], 404);
        }

        return $this->sendResponse('Trips data retrieved successfully', $trips);
    }

    /**
     * @OA\Get(
     *     path="/api/app/driver/get-today-trips",
     *     summary="Get driver's trips for today",
     *     tags={"Driver app"},
     *     security={{ "sanctum": {} }},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Trips data retrieved successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Trips data retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/UnauthorizedResponse"
     *     )
     * )
     */
    public function getTodayTrips(Request $request)
    {
        $trips = $request?->user()?->trips()->with([
            'path',
            'path.fromDestination',
            'path.toDestination',
            'path.domain',
        ])?->where('start_at_day', today())->get();

        if ($trips->isEmpty()) {
            return $this->sendError('You do not have any trips assigned to you for today', [], 404);
        }

        return $this->sendResponse('Trips data retrieved successfully', $trips);
    }

    /**
     * @OA\Get(
     *     path="/api/app/driver/get-upcoming-trips",
     *     summary="Get driver's upcoming trips",
     *     tags={"Driver app"},
     *     security={{ "sanctum": {} }},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Trips data retrieved successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Trips data retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/UnauthorizedResponse"
     *     )
     * )
     */
    public function getUpcomingTrips(Request $request)
    {
        $trips = $request?->user()?->trips()
            ->with([
                'path',
                'path.fromDestination',
                'path.toDestination',
                'path.domain',
            ])
            ->where(function ($query) {
                $query->where('start_at_day', '>', today())
                    ->orWhere(function ($query) {
                        $query->where('start_at_day', today())
                            ->where('start_at_time', '>', now());
                    });
            })
            ->get();

        if ($trips->isEmpty()) {
            return $this->sendError('You do not have any upcoming trips assigned to you', [], 404);
        }

        return $this->sendResponse('Trips data retrieved successfully', $trips);
    }

    /**
     * @OA\Get(
     *     path="/api/app/driver/get-upcoming-today-trips",
     *     summary="Get driver's upcoming trips for today",
     *     tags={"Driver app"},
     *     security={{ "sanctum": {} }},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Trips data retrieved successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Trips data retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/UnauthorizedResponse"
     *     )
     * )
     */
    public function getUpcomingTodayTrips(Request $request)
    {
        $trips = $request?->user()?->trips()
            ->with([
                'path',
                'path.fromDestination',
                'path.toDestination',
                'path.domain',
            ])
            ->where('start_at_day', today())
            ->where('start_at_time', '>', now())
            ->get();

        if ($trips->isEmpty()) {
            return $this->sendError('You do not have any upcoming trips assigned to you for today', [], 404);
        }

        return $this->sendResponse('Trips data retrieved successfully', $trips);
    }

    /**
     * @OA\Post(
     *     path="/api/app/driver/start-trip",
     *     summary="Start trip",
     *     tags={"Driver app"},
     *     security={{ "sanctum": {} }},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="trip_id", type="integer", example=1),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Trip started successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Trip started successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/UnauthorizedResponse"
     *     )
     * )
     */
    public function startTrip(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|integer|exists:trips,id',
        ]);

        $trip = $request?->user()?->trips()?->find($request->trip_id);

        if (! $trip) {
            return $this->sendError('Trip not found', [], 404);
        }

        if ($trip->status === TripStatus::IN_PROGRESS->value) {
            return $this->sendError('Trip has already been started', [], 400);
        }

        $trip->update([
            'status' => TripStatus::IN_PROGRESS->value,
        ]);

        return $this->sendResponse('Trip started successfully', $trip);
    }

    /**
     * @OA\Post(
     *     path="/api/app/driver/end-trip",
     *     summary="End trip",
     *     tags={"Driver app"},
     *     security={{ "sanctum": {} }},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="trip_id", type="integer", example=1),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Trip ended successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Trip ended successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/UnauthorizedResponse"
     *     )
     * )
     */
    public function endTrip(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|integer|exists:trips,id',
        ]);

        $trip = $request?->user()?->trips()?->find($request->trip_id);

        if (! $trip) {
            return $this->sendError('Trip not found', [], 404);
        }

        if ($trip->status === TripStatus::COMPLETED->value) {
            return $this->sendError('Trip has already been ended', [], 400);
        }

        $trip->update([
            'status' => TripStatus::COMPLETED->value,
        ]);

        return $this->sendResponse('Trip ended successfully', $trip);
    }

    /**
     * @OA\Post(
     *     path="/api/app/driver/update-bus-location",
     *     summary="Update driver's bus location",
     *     tags={"Driver app"},
     *     security={{ "sanctum": {} }},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="latitude", type="string", example="12.345678"),
     *             @OA\Property(property="longitude", type="string", example="12.345678"),
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Location updated successfully",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Location updated successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         ref="#/components/responses/UnauthorizedResponse"
     *     )
     * )
     */
    public function updateBusLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);

        $driver = $request?->user();

        $driver?->bus?->update([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return $this->sendResponse('Location updated successfully', $driver->bus);
    }
}
