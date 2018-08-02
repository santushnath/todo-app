<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Task;
use App\User;
use App\TaskUser;
use Session;


class TaskUserController extends Controller
{

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index($id)
    {
    	
    	// return User::find( TaskUser::where( 'task_id', $id )->get(['user_id'])->toArray() );
    	return DB::table('task_users')
            ->join('users', 'users.id', '=', 'task_users.user_id')
            ->where( 'task_users.task_id', $id )
            ->get(['task_users.id', 'users.name', 'users.email'])
            ->toArray();

    }

    public function inviteCreate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->first();
        $task = Task::findOrFail( $request->id );
        if(!$user || !$task) return 'error';

        $userDubli = TaskUser::where('user_id', $user->id)
        					->where('task_id', $task->id)
        					->first();
        if($userDubli || ($user->id == Auth::id())) return 'error';

		$newInvite = new TaskUser;
        $newInvite->task_id = $task->id;
        $newInvite->user_id = $user->id;
        $newInvite->save();
        

        return $newInvite;
    }

    public function destroy($id)
    {
        $taskUser = TaskUser::findOrFail(1);
        $taskUser->delete();
    }


}
