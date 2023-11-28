<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Card::latest()->get();

        return apiResponse()
            ->data($messages)
            ->send();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => ['required', 'string'],
        ]);

        $card = Card::updateOrCreate(
            [
                'user_id' => $request->user()->id,
            ],
            [
                'content' => $request->get('content'),
            ]
        );

        return apiResponse()
            ->data($card)
            ->send();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return apiResponse()
            ->data($request->user()->card)
            ->send();
    }
}
