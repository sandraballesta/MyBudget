<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TasksController extends Controller
{
    protected $passport;
    protected $goodMorning;
    public function __construct(PassportController $passport, GoodMorningController $goodMorning)
    {
        $this->passport= $passport;
        $this->goodMorning= $goodMorning;
    }

    public function goodMorning()
    {
        $users = $this->passport->getUsers();
        foreach ($users as $user) {
            $this->goodMorning->goodMorning($user->id);
        }
    }
}
