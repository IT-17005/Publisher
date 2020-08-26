@extends('layouts.app')

@section('content')
<a href="/posts" class="btn btn-info"> Go Back</a>
<h1>{{$post->title}}</h1>

<div class="row">
    <div class="col-md-12">
        <img style="width: 100%" src="/storage/cover_images/{{$post->cover_image}}" alt="">
    </div>
</div>

<p>{{$post->body}}</p>
<small>Written on {{$post->created_at}}</small>
<hr>
@if(!Auth::guest())
@if(Auth::user()->id == $post->user_id)
<a href="/posts/{{$post->id}}/edit" class="btn btn-outline-primary">Edit</a>
{!!Form::open(['action'=> ['PostsController@destroy',$post->id], 'method'=>'POST', 'class' => 'pull-right'])!!}
{{Form::hidden('_method', 'delete')}}
<br>
{{Form::submit('Delete',['class' => 'btn btn-danger'])}}
{!!Form::close()!!}
@endif
@endif
@endsection
