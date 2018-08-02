<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaskRowData;

class TaskrowdataController extends Controller
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( $id )
    {
        return TaskRowData::where('task_id', $id)->get()->toArray();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $all_request = $request->all();

        foreach( $all_request['taskRowData']  as $row ) {
            if ( !$row['id'] ) {
                $taskRowData = new TaskRowData;
                
            }else {
                $taskRowData = TaskRowData::findOrFail( $row['id'] );
            }

            $taskRowData->status    = $row['status'];
            $taskRowData->body      = $row['body'];
            $taskRowData->task_id   = $row['task_id'];
            $taskRowData->save();
        }

        foreach( $all_request['deleteRows']  as $row ) {
            
            $taskRowData = TaskRowData::findOrFail( $row['id'] );
            $taskRowData->delete();
        }

        return $all_request;

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
