<?php

namespace App\Http\Controllers;

use App\Models\Months;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonthsController extends Controller
{
    public function get_months(Request $request){
        $month = \App\Models\Months::all();
        $response = [];
            $response[] = [
                "id" => $month->id,
                "userID" => $month->userID,
                "income" => $month->income,
                "fixed" => $month->fixed,
                "available" => $month->available,
                "total_expenses" => $month->total_expenses,
                "daily_budget" => $month->daily_budget

            ];
        return response()->json(["months"=>$response],200);

    }

    public function create_month($userID, $income, $fixed){
        Months::create([
            'userID' => $userID,
            'income' => $income,
            'fixed' => $fixed,
            'dailyBudget' => 0,
            'available' => $income - $fixed
        ]);
    }

    //SELECT months.id, months.userID, months.income, months.fixed, months.available, months.total_expenses
    //FROM months
    //INNER JOIN users ON users.id = months.userID
    public function getUserMonths($id)
    {
        return DB::table('months')
            //->select('months.id', 'months.userID', 'months.income', 'months.fixed', 'months.total_expenses', 'months.available' ,'months.dailyBudget')
            //->where ('months.userID', $id)
            ->find($id);
    }

    public function month_by_id(Request $request, $id){

        $month= $this->getUserMonths($id);

        $response = [];
            $response[] = [
                "id" => $month->id,
                "userID" => $month->userID,
                "income" => $month->income,
                "fixed" => $month->fixed,
                "available" => $month->available,
                "total_expenses" => $month->total_expenses,
                "dailyBudget" => $month->dailyBudget,
                "userwesent" => $id

            ];
        return response()->json(["months"=>$response],200);

    }
    //UPDATE months
    //SET total_expenses = x, available = x
    //WHERE users ON users.id = months.userID

    public function update_month($id, $dailyBudget){

        if ($dailyBudget > 0) {
            DB::table('months')
                ->where('months.userID', $id)
                ->update([
                    'available' => DB::raw("available - $dailyBudget")
                ]);
        }
    }

    public function add_expense(Request $request, $id, $exp){
        $userID = $id;
        $new_exp = $exp;
        //$get = \App\Models\Months::where('');

        DB::table('months')
            ->where ('months.userID', $userID)
            ->update ([
                'total_expenses' => DB::raw("total_expenses + '$new_exp'"),
                'available' => DB::raw("available - '$new_exp'"),
                'dailyBudget' => DB::raw("dailyBudget - '$new_exp'")
            ]);


        $month= $this->getUserMonths($id);

        $response = [];
            $response[] = [
                "available" => $month->available,
                "dailyBudget" => $month->dailyBudget,
                "total_expenses" => $month->total_expenses,

            ];
        return response()->json(["months"=>$response],200);
    }

    public function daysRemaining()
    {
        $timestamp = strtotime(date("Y-m-d"));
        return ((int)date('t', $timestamp) - (int)date('j', $timestamp));

    }

    public function updateDailyBudget($id){

        $month = $this->getUserMonths($id);

        $dailyBudget = $month->available / $this->daysRemaining();

        //$month->dailyBudget = $dailyBudget;

        //$month.save()

        DB::table('months')
            ->where('months.userID', $id)
            ->update([
                'dailyBudget' => $dailyBudget
            ]);
    }

}
