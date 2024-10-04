<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Http\Resources\LogResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return LogResource::collection(Log::latest()->paginate($request->per_page ?? 10));
    }
}
