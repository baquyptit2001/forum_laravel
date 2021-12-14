<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $return = QuestionResource::collection(Question::all());
        return response()->json($return);
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
