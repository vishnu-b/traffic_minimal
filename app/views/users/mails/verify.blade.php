@extends('layouts.mail_template')

@section('content')
    <h1>Hello {{ $name }}</h1>
    <p>
        Please verfiy your email to access various Technowell Traffic features. {{ URL::to('api/users/verify/' . $code) }}
    </p>
@stop
