<?php

namespace App\Http\Controllers;

use App\Question;
use App\Responses\Responses;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    use Responses;
    public function getQuestions()
    {
      $questions = Question::all();
      return $this->sendSuccessResponse($questions);
    }
}
