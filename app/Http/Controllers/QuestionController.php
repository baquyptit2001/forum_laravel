<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Models\Question;
use App\Models\QuestionVote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index($size, $page): JsonResponse
    {
        $return = QuestionResource::collection(Question::all()->skip(($page - 1) * $size)->take($size));
        return response()->json([
            $return, Question::count(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $question = new Question();
            $question->question = $request->question;
            $question->title = $request->title;
            $question->user_id = $request->user_id;
            $question->save();
            return response()->json([
                'status_code' => 200,
                'message' => 'Thêm câu hỏi thành công',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Không thành công, vui lòng thử lại sau',
                'status_code' => 500
            ]);
        }
    }

    public function vote(Request $request)
    {
        $extist_vote = QuestionVote::where('user_id', $request->user_id)->where('question_id', $request->question_id)->first();
        if($extist_vote) {
            if ($extist_vote->vote == $request->vote){
                $extist_vote->delete();
                return response()->json([
                    'status_code' => 200,
                    'message' => 'Vote thành công',
                ]);
            }
        }
        $vote = array(
            'question_id' => $request->question_id,
            'user_id' => $request->user_id,
            'vote' => $request->vote
        );
        QuestionVote::updateOrCreate(
            ['question_id' => $request->question_id, 'user_id' => $request->user_id],
            $vote
        );
        return response()->json([
            'status_code' => 200,
            'message' => 'Vote thành công',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $slug
     * @return JsonResponse
     */
    public function show($slug): JsonResponse
    {
        $question = Question::where('slug', $slug)->first();
        if ($question) {
            $question->increment('views');
            $return = new QuestionResource($question);
            return response()->json($return);
        } else {
            return response()->json([
                'message' => 'Không tìm thấy câu hỏi',
                'status_code' => 404
            ]);
        }
    }

    public function best_answer(Request $request) {
        $question = Question::where('id', $request->question_id)->first();
        if ($question->best_answer_id == $request->answer_id) {
            $question->best_answer_id = null;
        } else {
            $question->best_answer_id = $request->answer_id;
        }
        return $question->save();
    }
}
