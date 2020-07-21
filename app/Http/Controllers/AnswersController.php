<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Responses\Responses;
use App\Youth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnswersController extends Controller
{
    use Responses;
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'data' => 'required',
            'user_id' => 'required|exists:users,id',
            'youth_id' => 'required|exists:youths,id',
        ]);
        $errors = $validator->messages();
        if ($validator->fails()) {
            return $this->sendFailureResponse($errors);
        }
        $answers = json_decode($request->data);
        foreach ($answers as $answer) {
            $data = ["user_id" => $request->user_id,
                     "youth_id" => $request->youth_id,
                     "question_id" => $answer->question_id,
                     "value" => $answer->value,
                     "text_value" => $answer->inputVal,
                    ];
            Answer::create($data);
        }
        return $this->sendSuccessResponse("Questionnaire Saved");
    }

    public function getAnswers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agent_no' => 'required',
        ]);
        $errors = $validator->messages();
        if ($validator->fails()) {
            return $this->sendFailureResponse($errors);
        }
        $youth= Youth::where(['agent_no'=>$request->agent_no])->first();
        $youth->load('answers.question');
        return $this->sendSuccessResponse($youth);
    }
}
