<?php

namespace App\Http\Controllers;

use App\Http\Requests\CardStoreRequest;
use App\Http\Requests\CardUpdateRequest;
use App\Http\Resources\CardResource;
use App\Models\Card;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return CardResource::collection(Card::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CardStoreRequest $request
     * @return CardResource
     */
    public function store(CardStoreRequest $request): CardResource
    {
        $validatedFields = $request->validated();
        $cards = Card::create($validatedFields);
        return new CardResource($cards);
    }

    /**
     * Display the specified resource.
     *
     * @param Card $card
     * @return CardResource
     */
    public function show(Card $card): CardResource
    {
        return new CardResource($card);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CardUpdateRequest $request
     * @param Card $card
     * @return JsonResponse
     */
    public function update(CardUpdateRequest $request, Card $card): JsonResponse
    {
        $validatedFields = $request->validated();
        $card->update($validatedFields);
        return (new CardResource($card))
            ->response()->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Card $card
     * @return bool | null
     */
    public function destroy(Card $card): bool | null
    {
        return $card->delete();
    }
}
