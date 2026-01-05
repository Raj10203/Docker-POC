<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;


#[OA\Info(
    title: "Learning Laravel API",
    version: "1.0.0",
    description: "API Documentation for Learning Laravel",
    contact: new OA\Contact(
        email: "support@learninglaravel.com",
        name: "API Support"
    )
)]
#[OA\Server(
    url: "/",
    description: "API Server"
)]
#[OA\SecurityScheme(
    securityScheme: "bearerAuth",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
class BaseController extends Controller
{
    //
}
