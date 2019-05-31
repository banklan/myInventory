@extends('layouts.app_user')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <router-view></router-view>
        </div>
    </div>
</div>
@endsection
