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
            'user_id' => 'required|exists:users,id',
            "agent_no"=>"required|unique:youths,agent_no",
            "age"=>"required",
            "ward"=>"required",
            "sub_county"=>"required",
            "county"=>"required",
            "school"=>"required",
            "form"=>"required",
            "gender"=>"required",
            "religion"=>"required",
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $errors = $validator->messages();
        if ($validator->fails()) {
            return $this->sendFailureResponse($errors);
        }
        $imageName=null;
        if ($request->hasFile("image")){
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
        }

        $youth= Youth::create($request->only(["user_id","names", "agent_no", "age", "ward", "sub_county", "county", "school", "form", "gender", "religion"]));
        if ($imageName != null){
            $youth->image = $imageName;
            $youth->save();
        }
        if ($youth){
            return $this->sendSuccessResponse("Created Record Successfully");
        }else{
            return $this->sendFailureResponse("No Record Found");
        }
    }
    //    $users = User::withCount(['posts', 'comments'])->get();
}
