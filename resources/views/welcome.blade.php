@extends('layouts.app')

@section('header')
@endsection

@section('content')
{{-- Start: Header Section
================================ --}}
<section class="header-section-1 image-bg-1 relative overflow" id="home-section">
    <div class="overlay-color">
        <div class="container" >
            <div class="row inner-wrapper section-separator-big">

                <div class="col-md-10 col-md-offset-1 text-center light-text">
                    <div class="header-box">
                        {{--  Start: Section Heading   --}}
                        <div class="section-header text-center">
                            
                            {{----  Header SubTitle Goes here --}}
                            <p class="sub-heading">Best experience ever</p>

                            {{---- End: Section Heading --}}
                            <h1 class="section-heading">ToDo Something New</h1>

                        </div> 
                        {{--  End: Section Heading   --}}

                        <div class="details">
                            <p>Analytics release series A financing launch party interaction design android angel investor. Vesting period social media sales conversion launch party rockstar incubator customer.</p>
                        </div>

                        {{--  Button Area  --}}
                        <div class="btn-form mr-top btn-scroll">  
                            <a href="{{ route('register') }}" class="btn btn-lg is-primary">Sign Up Now</a>
                        </div>
                    </div>
                </div> {{-- End:  --}}

                <div class="col-md-8 col-md-offset-2 text-center features-area">
                    <div class="row">
                        <div class="col-sm-4 features-item">
                            <img src="images/developers.png" alt="" class="img">
                            <h4 class="title">Developers</h4>
                        </div>
                        <div class="col-sm-4 features-item">
                            <img src="images/designers.png" alt="" class="img">
                            <h4 class="title">Designers</h4>
                        </div>
                        <div class="col-sm-4 features-item">
                            <img src="images/finance_experts.png" alt="" class="img">
                            <h4 class="title">Finance experts</h4>
                        </div>
                    </div>
                </div>

            </div> {{-- /.row --}}
        </div> {{-- /.container --}}
    </div> {{-- /.overflow-color --}}
</section>
<div id="app2">
    <table class="table">
        <thead>
            <tr>
                <td><strong>Title</strong></td>
                <td><strong>Description</strong></td>
                <td><strong>File</strong></td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <tr v-for="row in rows">
                <td><input type="text" v-model="row.title"></td>
                <td><input type="text" v-model="row.description"></td>
                <td><input type="file" @change="setFilename($event);"></td>
                <td><a v-on:click="removeElement(row);" style="cursor: pointer">Remove</a></td>
            </tr>
        </tbody>
    </table>
    <div>
        <button class="button btn-primary" @click="addRow">Add row</button>
    </div>
</div>
{{--  End: Header Section
================================  --}}
@endsection


@section('footer')
<script type="text/javascript">

    var app = new Vue({
        el: "#app2",
        data: {
            rows: [
                { title: "XEngine for Sale", description: "An application" },
                { title: "There is no place like 127.0.0.1", description: "Best tool for your security." }
            ]
        },
        methods: {
            addRow: function () {
                this.rows.push({ title: "", description: "" });
            },
            removeElement: function (row) {
                var index = this.rows.indexOf(row);
                this.rows.splice(index, 1);
            },
            setFilename: function (event) {
                this.filename = event.target.name;
            }
        }
    });

</script>
@endsection