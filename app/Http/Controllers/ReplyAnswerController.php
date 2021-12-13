<?php

namespace App\Http\Controllers;

use App\Models\AnswerReply;
use Illuminate\Http\Request;

class ReplyAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (AnswerReply::create($request->all())) {
            return response()->json([
                'status_code' => 200,
                'message' => 'Answer created successfully',
            ]);
        } else {
            return response()->json([
                'status_code' => 500,
                'message' => 'Answer not created',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnswerReply  $answerReply
     * @return \Illuminate\Http\Response
     */
    public function show(AnswerReply $answerReply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnswerReply  $answerReply
     * @return \Illuminate\Http\Response
     */
    public function edit(AnswerReply $answerReply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AnswerReply  $answerReply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnswerReply $answerReply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AnswerReply  $answerReply
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnswerReply $answerReply)
    {
        //
    }
}
