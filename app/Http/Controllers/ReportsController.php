<?php

namespace App\Http\Controllers;

use App\Question;
use App\Responses\Responses;
use App\User;
use App\Youth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


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
        $first = [10, 14];
        $second = [15, 19];
        $third = [20, 24];
        $fourth = [25, 30];
        $fifth = [31, 100];

        $ages_1 = Youth::whereBetween('age', $first)->count();
        $ages_2 = Youth::whereBetween('age', $second)->count();
        $ages_3 = Youth::whereBetween('age', $third)->count();
        $ages_4 = Youth::whereBetween('age', $fourth)->count();
        $ages_5 = Youth::whereBetween('age', $fifth)->count();

        $data = [
            ['count' => $ages_1, 'key' => '10-14'],
            ['count' => $ages_2, 'key' => '15-19'],
            ['count' => $ages_3, 'key' => '20-24'],
            ['count' => $ages_4, 'key' => '25-30'],
            ['count' => $ages_5, 'key' => 'Above 30'],
        ];
        return $this->sendSuccessResponse($data);
    }

    public function capture(Request $request)
    {
        $data = file_get_contents('php://input');
        $date = date("Y_m_d");
        if (!$data) {
            Storage::append($date . "_api_logs.txt", "No Data received");
        } else {
            Storage::append($date . "_api_logs.txt", $data);
        }
    }


    public function out_of_school()
    {
        $out_of_school = Youth::where(["school" => "N/A"])->count();
        return $this->sendSuccessResponse($out_of_school);
    }

    public function youths_per_shujaa(Request $request)
    {
        $youths =  User::with('youths')->where('name', 'like', '%' . $request->name . '%')->first();
        return $this->sendSuccessResponse($youths);
    }

    public function youth_count_school($type)
    {
        $in_school = [1, 2];
        $out_school = [1, 3];
        if ($type == "in") {
            $filter = $in_school;
        } elseif ($type == "out") {
            $filter = $out_school;
        }

        $questions = Question::with('responses.youth')
            ->whereIn("type", $filter)
            ->where('answers', '!=', 0)
            ->get();
        $data = [];
        foreach ($questions as $question) {
            $yes_answers = 0;
            $no_answers = 0;
            $undecided = 0;
            $answers = $question->responses;
            foreach ($answers as $answer) {
                if ($answer->youth->school == "NA") {
                    switch ($answer->value) {
                        case 1:
                            $yes_answers++;
                            break;
                        case 2:
                            $no_answers++;
                            break;
                        default:
                            $undecided++;
                    }
                }
            }
            $data[] = ["answers" => $question->answers, "title" => $question->title, 'yes' => $yes_answers, 'no' => $no_answers, 'undecided' => $undecided, "type" => $question->type];
        }
        return $this->sendSuccessResponse($data);
    }

    public function getReportSingle()
    {
        $id = 9;
        $question = Question::with('responses')
            ->findOrFail($id);
        $data = [];
        $condoms = 0; //1ddd
        $injections = 0; //2ddd
        $pills = 0; //3ddd
        $implants = 0; //4ddd
        $Intrauterine = 0; //5dddd
        $emergency_pills = 0; //6dddd
        foreach ($question->responses as $response) {
            switch ($response->text_value) {
                case "1":
                    $condoms++;
                    break;
                case "2":
                    $injections++;
                    break;
                case "3":
                    $pills++;
                    break;
                case "4":
                    $implants++;
                    break;
                case "5":
                    $Intrauterine++;
                    break;
                case "6":
                    $emergency_pills++;
                    break;
            }
        }
        //1= Condoms, 2 = Injections, 3 = Pills, 4 = Implants, 5 = Intrauterine Devices (IUCD coil), 6 = Emergency contraceptive pills )

        $data = [
            ["item" => "Condoms", "count" => $condoms],
            ["item" => "Injections", "count" => $injections],
            ["item" => "Pills", "count" => $pills],
            ["item" => "Implants", "count" => $implants],
            ["item" => "Intrauterine Devices (IUCD coil)", "count" => $Intrauterine],
            ["item" => "Emergency contraceptive pill", "count" => $emergency_pills],
        ];

        return $this->sendSuccessResponse($data);
    }

    public  function courses_by_university()
    {
        $sql = "SELECT institution, course, gender, COUNT(id) AS HowMany FROM youths WHERE school='NA' OR school='N/A' GROUP BY institution, course, gender";
        $total = DB::select($sql);
        return $this->sendSuccessResponse($total);
    }
}
