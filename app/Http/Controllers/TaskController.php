<?php 

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use App\Task;
use App\User;
use App\TaskUser;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
// use Purifier;

class TaskController extends Controller
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

    
    public function index()
    {
        return Task::where('publish', 1)
                    ->where('user_id', Auth::id())
                    ->orderBy('id', 'desc')->get();
    }
    public function show_one($id)
    {
        $task = Task::findOrFail($id);
        $userDetails = User::find( $task->user_id );
        return ['task' => $task, 'userDetails' => $userDetails];
    }
    public function published()
    {
        return Task::where('publish', 0)
                    ->where('user_id', Auth::id())
                    ->orderBy('id', 'desc')->get();
    }
    public function shared()
    {
        // return Task::where('publish', 0)
        //             ->where('user_id', Auth::id())
        //             ->orderBy('id', 'desc')->get();
        return DB::table('task_users')
                    ->join('tasks', 'tasks.id', '=', 'task_users.task_id')
                    ->where( 'task_users.user_id', Auth::id() )
                    ->get()
                    ->toArray();
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required|max:500',
            'body'      => 'required',
            'color'     => 'required',
        ]);
        // return Task::create(['body' => request('body')]);



        $post = new Task;
        $post->user_id  = Auth::id();
        $post->title    = $request->title;
        // $post->body = Purifier::clean($request->body);
        $post->body     = $request->body;
        $post->color    = $request->color;
        $post->publish  = true;
        $post->save();

        return $post;
    }
    public function edit(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
        $task = Task::findOrFail($request->id);
        $task->body = $request->body;
        $task->save();
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:500',
            'body' => 'required',
            'color' => 'required'
        ]);
        $task = Task::findOrFail($id);
        $task->title = $request->title;
        $task->body = $request->body;
        $task->color = $request->color;
        $task->save();
    }
    public function publish($id)
    {
        $task = Task::findOrFail($id);
        $task->publish = ! $task->publish;
        $task->save();
    }
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
    }


}
