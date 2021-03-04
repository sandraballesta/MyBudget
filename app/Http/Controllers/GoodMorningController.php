<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoodMorningController extends Controller
{
    protected $goals;
    protected $months;
    public function __construct(GoalsController $goals, MonthsController $months){
        $this->goals = $goals;
        $this->months = $months;
    }

    public function goodMorning($id)
    {
        $month = $this->months->getUserMonths($id);

        $this->goals->update_goal($id, $month->dailyBudget);
        $this->months->update_month($id, $month->dailyBudget);

        $this->months->updateDailyBudget($id);

    }

}
