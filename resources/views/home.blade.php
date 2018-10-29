@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="text-center card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <button id="getPrize" class="btn btn-warning" >Click For Prize</button>

                    <div id="prizeContent" class="jumbotron mt-3">

                    </div>
                    <button id="refuseBtn" data-prize-id=""
                            class="btn btn-danger" style="display: none">Refuse</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
