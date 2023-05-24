<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class LoginAnyUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:any-user-login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Randomly login to any user';

    /**
     * Execute the console command.
     */
    public function handle(Request $request)
    {

        $user= Auth::loginUsingId(1, true);

        session()->put('user_id', $user->id);
        session()->regenerate();    
       

       $this->info('Login Success with the user : ' . $user->name);
    
    }
}
