<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\Milhas123;

class FlightsController extends Controller
{
    
    /**
     * @OA\Get(
     *      path="/api/flights",
     *      tags={"Flight"},
     *      summary="Returns a group of flight",
     *      description="Returns a group of flight",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function index()
    {

        $milhas123 = new Milhas123();

        return response()->json($milhas123->getFlights(), 200);
    }

}
