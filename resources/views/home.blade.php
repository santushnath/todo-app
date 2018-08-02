@extends('layouts.app')

{{-- @section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@section('title')
 | Deshboard
@endsection

@section('header')
{{--  <script src='https://unpkg.com/vue-select@latest'></script>  --}}
{{--  <script src="https://unpkg.com/vue-color/dist/vue-color.min.js"></script>  --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.3.4/tinymce.min.js"></script> --}}
@endsection

@section('content')
<div class="container">
    <div class="row">
        
        <div id='app' class="clearfix">
            {{-- <task-list></task-list> --}}
            <router-view name="taskIndex"></router-view>
            <router-view></router-view>
        </div>

    </div>
</div>
@endsection

@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.min.js"></script>
{{--  <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>  --}}
<script>
    
</script>
@endsection
