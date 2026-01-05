<?php

namespace App\Http\Controllers\API;

use OpenApi\Attributes as OA;
use App\Http\Controllers\Controller;
use App\Models\Drone;
use Illuminate\Http\Request;

class DroneController extends Controller
{

    #[OA\Get(
        path: '/api/drones',
        summary: 'Get all drones',
        tags: ['Drones'],
        responses: [
            new OA\Response(response: 200, description: 'List of drones')
        ]
    )]
    public function index()
    {
        $drones = Drone::with('inspections')
            ->get();

        return response()->json($drones, 200);
        //
    }

    
    #[OA\Post(
        path: '/api/drones',
        summary: 'Create a new drone',
        tags: ['Drones'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['drone_name', 'serial_number'],
                properties: [
                    new OA\Property(property: 'drone_name', type: 'string'),
                    new OA\Property(property: 'serial_number', type: 'string'),
                    new OA\Property(property: 'battrey_capacity_mah', type: 'string'),
                    new OA\Property(property: 'max_flight_time_minutes', type: 'string'),
                    new OA\Property(property: 'camera_specs', type: 'object'),
                    new OA\Property(property: 'status', type: 'integer'),
                    new OA\Property(property: 'last_maintenance_date', type: 'string', format: 'date'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Drone created'),
            new OA\Response(response: 422, description: 'Validation error')
        ]
    )]
    public function store(Request $request)
    {
        $validated = $request->validate([
            'drone_name' => 'required|string',
            'serial_number' => 'required|string|unique:drones,serial_number',
            'battrey_capacity_mah' => 'nullable|string',
            'max_flight_time_minutes' => 'nullable|string',
            'camera_specs' => 'nullable|array',
            'status' => 'nullable|integer',
            'last_maintenance_date' => 'nullable|date',
        ]);
        $drone = Drone::create($validated);
        return response()->json($drone, 201);
    }

    #[OA\Get(
        path: '/api/drones/{drone}',
        summary: 'Get a drone by ID',
        tags: ['Drones'],
        parameters: [
            new OA\Parameter(name: 'drone', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Drone data'),
            new OA\Response(response: 404, description: 'Not found')
        ]
    )]
    public function show(Drone $drone)
    {
        return response()->json($drone, 200);
    }

   
    #[OA\Put(
        path: '/api/drones/{drone}',
        summary: 'Update a drone',
        tags: ['Drones'],
        parameters: [
            new OA\Parameter(name: 'drone', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'drone_name', type: 'string'),
                    new OA\Property(property: 'serial_number', type: 'string'),
                    new OA\Property(property: 'battrey_capacity_mah', type: 'string'),
                    new OA\Property(property: 'max_flight_time_minutes', type: 'string'),
                    new OA\Property(property: 'camera_specs', type: 'object'),
                    new OA\Property(property: 'status', type: 'integer'),
                    new OA\Property(property: 'last_maintenance_date', type: 'string', format: 'date'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Drone updated'),
            new OA\Response(response: 422, description: 'Validation error')
        ]
    )]
    public function update(Request $request, Drone $drone)
    {
        $validated = $request->validate([
            'drone_name' => 'sometimes|required|string',
            'serial_number' => 'sometimes|required|string|unique:drones,serial_number,' . $drone->id,
            'battrey_capacity_mah' => 'nullable|string',
            'max_flight_time_minutes' => 'nullable|string',
            'camera_specs' => 'nullable|array',
            'status' => 'nullable|integer',
            'last_maintenance_date' => 'nullable|date',
        ]);
        $drone->update($validated);
        return response()->json($drone, 200);
    }

  
    #[OA\Delete(
        path: '/api/drones/{drone}',
        summary: 'Delete a drone',
        tags: ['Drones'],
        parameters: [
            new OA\Parameter(name: 'drone', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 204, description: 'Drone deleted'),
            new OA\Response(response: 404, description: 'Not found')
        ]
    )]
    public function destroy(Drone $drone)
    {
        $drone->delete();
        return response()->json(null, 204);
    }
}
