<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Requests\SiteRequest;
use App\Models\Site;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;


class SiteController extends BaseController
{

    #[OA\Get(
        path: "/api/sites",
        summary: "Get list of all sites",
        tags: ["Sites"],
        security: [["bearerAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "List of sites",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "boolean", example: true),
                        new OA\Property(
                            property: "data",
                            type: "array",
                            items: new OA\Items(
                                type: "object",
                                properties: [
                                    new OA\Property(property: "id", type: "integer", example: 1),
                                    new OA\Property(property: "name", type: "string", example: "Site A"),
                                    new OA\Property(property: "url", type: "string", example: "http://example.com"),
                                    new OA\Property(property: "size_in_mw", type: "number", format: "float", example: 100.5)
                                ]
                            )
                        )
                    ]
                )
            )
        ]
    )]
    public function index()
    {
        $sites = Site::with('inspections')->where('is_active',1)->get();
        return response()->json([
            'status' => true,
            'data' => $sites
        ]);
    }

    #[OA\Post(
        path: "/api/sites",
        summary: "Create a new site",
        tags: ["Sites"],
        security: [["bearerAuth" => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Site A"),
                    new OA\Property(property: "url", type: "string", example: "http://example.com"),
                    new OA\Property(property: "size_in_mw", type: "number", format: "float", example: 100.5)
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Site created successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "boolean", example: true),
                        new OA\Property(property: "data", type: "object")
                    ]
                )
            )
        ]
    )]
    public function store(SiteRequest $request)
    {
        $request->validated();
        $site = Site::create($request->all());

        return response()->json([
            'status' => true,
            'data' => $site
        ], 201);
    }

    #[OA\Get(
        path: "/api/sites/{site}",
        summary: "Get a single site by ID",
        tags: ["Sites"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "site",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Site details",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "boolean", example: true),
                        new OA\Property(property: "data", type: "object")
                    ]
                )
            )
        ]
    )]
    public function show(Site $site)
    {
        return response()->json([
            'status' => true,
            'data' => $site
        ]);
    }

    #[OA\Put(
        path: "/api/sites/{site}",
        summary: "Update a site by ID",
        tags: ["Sites"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "site",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Site A"),
                    new OA\Property(property: "url", type: "string", example: "http://example.com"),
                    new OA\Property(property: "size_in_mw", type: "number", format: "float", example: 100.5)
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Site updated successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "boolean", example: true),
                        new OA\Property(property: "data", type: "object")
                    ]
                )
            )
        ]
    )]
    public function update(SiteRequest $request, Site $site)
    {
        $site->update($request->validated());
        return response()->json([
            'status' => true,
            'data' => $site
        ]);
    }

    #[OA\Delete(
        path: "/api/sites/{site}",
        summary: "Delete a site by ID",
        tags: ["Sites"],
        security: [["bearerAuth" => []]],
        parameters: [
            new OA\Parameter(
                name: "site",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Site deleted successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "boolean", example: true),
                        new OA\Property(property: "message", type: "string", example: "Site deleted successfully")
                    ]
                )
            )
        ]
    )]
    public function destroy(Site $site)
    {
        $site->delete();
        return response()->json([
            'status' => true,
            'message' => 'Site deleted successfully'
        ]);
    }

}
