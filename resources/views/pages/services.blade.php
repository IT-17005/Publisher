@extends('layouts.app')
      @section('content')
       <h1>This is my {{$title}} page.</h1>
       @if(count($services)>0)

       <ul>
       @foreach($services as $s)
       <li>{{$s}}</li>
       @endforeach
       </ul>

       @endif
 @endsection
