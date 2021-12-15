<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\AnswerVote;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
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

    public function vote (Request $request){
        $extist_vote = AnswerVote::where('user_id', $request->user_id)->where('answer_id', $request->answer_id)->first();
        if($extist_vote) {
            if ($extist_vote->vote == $request->vote){
                $extist_vote->delete();
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Vote thành công',
                ]);
            }
        }
        AnswerVote::updateOrCreate(
            ['user_id' => $request->user_id, 'answer_id' => $request->answer_id],
            ['vote' => $request->vote]
        );
        return response()->json(['status_code' => 200]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $answer = new Answer();
        $answer->question_id = Question::where('slug', $request->slug)->first()->id;
        $answer->answer = $request->answer;
        $answer->user_id = $request->user_id;
        if ($answer->save()){
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
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Answer  $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
