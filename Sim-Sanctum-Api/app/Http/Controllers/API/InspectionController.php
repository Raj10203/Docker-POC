<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Models\Inspection;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class InspectionController extends BaseController
{
    
    #[OA\Get(
        path: '/api/inspections',
        summary: 'Get all inspections',
        tags: ['Inspections'],
        responses: [
            new OA\Response(response: 200, description: 'List of inspections')
        ]
    )]
    public function index()
    {
        $inspections = Inspection::with('site', 'inspector', 'drones')
            ->get();

        return response()->json($inspections, 200);
    }

    #[OA\Post(
        path: '/api/inspections',
        summary: 'Create a new inspection',
        description: 'Store a newly created resource in storage.',
        tags: ['Inspections'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['site_id', 'inspection_date', 'inspector_id', 'status'],
                properties: [
                    new OA\Property(property: 'site_id', type: 'integer'),
                    new OA\Property(property: 'inspection_date', type: 'string', format: 'date'),
                    new OA\Property(property: 'inspector_id', type: 'integer'),
                    new OA\Property(property: 'status', type: 'integer'),
                    new OA\Property(property: 'drone_ids', type: 'array', items: new OA\Items(type: 'integer')),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Inspection created'),
            new OA\Response(response: 422, description: 'Validation error')
        ]
    )]
    public function store(Request $request)
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'inspection_date' => 'required|date',
            'inspector_id' => 'required|exists:users,id',
            'status' => 'required|integer',
            'drone_ids' => 'nullable|array',
            'drone_ids.*' => 'exists:drones,id',
        ]);
        $inspection = Inspection::create($validated);
        if (!empty($validated['drone_ids'])) {
            $inspection->drones()->sync($validated['drone_ids']);
        }
        return response()->json($inspection->load('drones'), 201);
    }

    #[OA\Get(
        path: '/api/inspections/{inspection}',
        summary: 'Get an inspection by ID',
        description: 'Display the specified resource.',
        tags: ['Inspections'],
        parameters: [
            new OA\Parameter(name: 'inspection', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Inspection data'),
            new OA\Response(response: 404, description: 'Not found')
        ]
    )]
    public function show(Inspection $inspection)
    {
        return response()->json($inspection->load('site', 'inspector', 'drones'), 200);
    }

    #[OA\Put(
        path: '/api/inspections/{inspection}',
        summary: 'Update an inspection',
        description: 'Update the specified resource in storage.',
        tags: ['Inspections'],
        parameters: [
            new OA\Parameter(name: 'inspection', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'site_id', type: 'integer'),
                    new OA\Property(property: 'inspection_date', type: 'string', format: 'date'),
                    new OA\Property(property: 'inspector_id', type: 'integer'),
                    new OA\Property(property: 'status', type: 'integer'),
                    new OA\Property(property: 'drone_ids', type: 'array', items: new OA\Items(type: 'integer')),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Inspection updated'),
            new OA\Response(response: 422, description: 'Validation error'),
            new OA\Response(response: 404, description: 'Not found')
        ]
    )]
    public function update(Request $request, Inspection $inspection)
    {
        $validated = $request->validate([
            'site_id' => 'sometimes|exists:sites,id',
            'inspection_date' => 'sometimes|date',
            'inspector_id' => 'sometimes|exists:users,id',
            'status' => 'sometimes|integer',
            'drone_ids' => 'nullable|array',
            'drone_ids.*' => 'exists:drones,id',
        ]);
        $inspection->update($validated);
        if (isset($validated['drone_ids'])) {
            $inspection->drones()->sync($validated['drone_ids']);
        }
        return response()->json($inspection->load('drones'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
  
    public function destroy(Inspection $inspection)
    {
        $inspection->delete();
        return response()->json(null, 204);
    }
}
