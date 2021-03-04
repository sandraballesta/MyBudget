<?php

namespace App\Console\Commands;


use App\Http\Controllers\GoodMorningController;
use App\Http\Controllers\PassportController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class GoodMorning extends Command
{
    protected $passport;
    protected $goodMorning;
    public function __construct(PassportController $passport, GoodMorningController $goodMorning)
    {
        $this->passport= $passport;
        $this->goodMorning= $goodMorning;
        parent::__construct();
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'good-morning';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will this work?';

    public function handle()
    {
       $users = $this->passport->getUsers();
        foreach ($users as $user) {
            $this->goodMorning->goodMorning($user->id);
        }

        return 1;
    }
}
