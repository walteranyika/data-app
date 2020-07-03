<?php

namespace App\Http\Controllers;

use App\Responses\Responses;
use App\Youth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class YouthController extends Controller
{
    use Responses;
    public function getYouth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'agent_no' => 'required',
        ]);
        $errors = $validator->messages();
        if ($validator->fails()) {
            return $this->sendFailureResponse($errors);
        }
        $youth= Youth::where(['agent_no'=>$request->agent_no])->first();
        if ($youth){
            return $this->sendSuccessResponse($youth);
        }else{
           return $this->sendFailureResponse("No Record Found");
        }
    }

    public function saveYouth(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "names"=>"required",
            "agent_no"=>"required",
            "age"=>"required",
            "ward"=>"required",
            "sub_county"=>"required",
            "county"=>"required",
            "school"=>"required",
            "form"=>"required",
            "gender"=>"required",
            "religion"=>"required"
        ]);
        $errors = $validator->messages();
        if ($validator->fails()) {
            return $this->sendFailureResponse($errors);
        }
        $youth= Youth::create($request->all());
        if ($youth){
            return $this->sendSuccessResponse("Created Record Successfully");
        }else{
            return $this->sendFailureResponse("No Record Found");
        }
    }
}
