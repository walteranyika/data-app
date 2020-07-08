<?php

namespace App\Http\Controllers;

use App\Question;
use App\Responses\Responses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionsController extends Controller
{
    use Responses;

    public function getQuestions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|integer'
        ]);
        $errors = $validator->messages();
        if ($validator->fails()) {
            return $this->sendFailureResponse($errors);
        }
        if ($request->type == 2) {
            $questions = Question::school()->get();
        } else if ($request->type == 3){
            $questions = Question::out()->get();
        }
        return $this->sendSuccessResponse($questions);
    }
}
