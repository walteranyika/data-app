<?php

namespace App\Http\Controllers;

use App\Responses\Responses;
use App\User;
use App\Youth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    use Responses;

    public function totalShujas()
    {
        $total = Youth::count();
        return $this->sendSuccessResponse($total);
    }

    public function totalShujasPerWard()
    {
        $total = DB::table('youths')
            ->select('ward', DB::raw('count(*) as total'))
            ->groupBy('ward')
            ->get();
        return $this->sendSuccessResponse($total);
    }

    public function totalShujasPerSchool()
    {
        $total = DB::table('youths')
            ->select('school', DB::raw('count(*) as total'))
            ->groupBy('school')
            ->get();
        return $this->sendSuccessResponse($total);
    }

    public function totalShujasPerSubCounty()
    {
        $total = DB::table('youths')
            ->select('sub_county', DB::raw('count(*) as total'))
            ->groupBy('sub_county')
            ->get();
        return $this->sendSuccessResponse($total);
    }

    public function totalShujasPerCounty()
    {
        $total = DB::table('youths')
            ->select('county', DB::raw('count(*) as total'))
            ->groupBy('county')
            ->get();
        return $this->sendSuccessResponse($total);
    }

    public function totalCollectionPerSeal()
    {
      $total = User::all();
      return $this->sendSuccessResponse($total->toArray());
    }


    public function totalsByAge()
    {
        $first =[10,14];
        $second =[15,19];
        $third =[20,24];
        $fourth =[25,30];
        $fifth =[31,100];

        $ages_1= Youth::whereBetween('age',$first)->count();
        $ages_2= Youth::whereBetween('age',$second)->count();
        $ages_3= Youth::whereBetween('age',$third)->count();
        $ages_4= Youth::whereBetween('age',$fourth)->count();
        $ages_5= Youth::whereBetween('age',$fifth)->count();

        $data=[
                ['count'=>$ages_1,'key'=>'10-14'],
                ['count'=>$ages_2,'key'=>'15-19'],
                ['count'=>$ages_3,'key'=>'20-24'],
                ['count'=>$ages_4,'key'=>'25-30'],
                ['count'=>$ages_5,'key'=>'Above 30'],
            ];
        return $this->sendSuccessResponse($data);
    }


}
