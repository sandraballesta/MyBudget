<?php

namespace App\Http\Controllers;

use App\Models\User;
//use App\User;
use Illuminate\Http\Request;

class PassportController extends Controller
{
    protected $goals;
    protected $months;
    protected $goodMorning;
    public function __construct(GoalsController $goals, MonthsController $months, GoodMorningController $goodMorning){
        $this->goals = $goals;
        $this->months = $months;
        $this->goodMorning = $goodMorning;
    }

    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */



    public function getUsers(){

        return User::all();

    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'fixed' => 'required',
            'income' => 'required',
            'wanted' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $this->goals->create_goal($user->id, $request->wanted);
        $this->months->create_month($user->id, $request->income, $request->fixed);
        $this->goodMorning->goodMorning($user->id);

        $token = $user->createToken('TutsForWeb')->accessToken;

        return response()->json(['token' => $token, 'userID' => $user->id], 200);
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('TutsForWeb')->accessToken;
            //return response()->json(['token' => $token], 200);
            return response()->json(['token' => $token, 'user' => auth()->user()], 200);
        } else {
            return response()->json(['error' => 'UnAuthorised'], 401);
        }
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }
}
