<?php

namespace App\Http\Controllers;

use App\Models\Goals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoalsController extends Controller
{
    public function create_goal($userID, $wanted){
        Goals::create([
           'userID' => $userID,
            'total' => 0,
            'wanted'=> $wanted,

        ]);
    }


    public function update_goal($id, $dailyBudget){

        if ($dailyBudget > 0) {
            $userGoal = DB::table('goals')
                ->find($id);
            if($userGoal->total != $userGoal->wanted) {

                $newTotal = $userGoal->total + $dailyBudget;

                if ($newTotal >= $userGoal->wanted) {
                    $newTotal = $userGoal->wanted;
                }

                DB::table('goals')
                    ->where([
                        'userID' => $id
                    ])
                    ->update([
                        'total' => $newTotal
                    ]);
            }
        }
    }

    public function new_goal(Request $request, $id){

        DB::table('goals')
            ->where([
                'userID' => $id
            ])
            ->update([
                'total' => 0,
                'wanted' => $request ->goal
            ]);
        $goal = DB::table('goals')
            ->find($id);
        $response= [
            "id" => $goal->id,
            "userID" => $goal->userID,
            "total" => $goal->total,
            "wanted" => $goal->wanted,

        ];

        return response()->json(["goals"=>$response],200);
    }



    public function get_goals(Request $request, $id){
        $userID = $id;

        $goals = DB::table('goals')
            ->select('goals.id', 'goals.userID', 'goals.total', 'goals.wanted')
            ->join('users', 'users.id', 'goals.userID')
            ->where ('goals.userID', $userID)
            ->get();

        $response = [];
        foreach($goals as $goal){
            $response[] = [
                "id" => $goal->id,
                "userID" => $goal->userID,
                "total" => $goal->total,
                "wanted" => $goal->wanted,

            ];
        }
        return response()->json(["goals"=>$response],200);

    }
}
