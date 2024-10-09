<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Http\Resources\LogResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Requests\SearchRequest;
use App\Services\Search\LogSearch;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param SearchRequest $request
     * @param  LogSearch  $search
     * @return AnonymousResourceCollection
     */
    public function index(SearchRequest $request, LogSearch $search): AnonymousResourceCollection
    {
        $logs = $search->getQuery(Log::query(), $request->validated());
        return LogResource::collection(
            $logs->latest()->paginate($request->per_page ?? 10)
        );
    }
}
