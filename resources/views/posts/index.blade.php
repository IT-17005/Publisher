@extends('layouts.app')

@section('content')
<h1>Posts</h1>

@if(count($posts)>0)

<div class="card">
{{-- <ul class="list-group list-group-flush"> --}}
<ul class="list-unstyled">
@foreach($posts as $post)

{{-- <div class="row">
    <div class="col-md-4">
    <img style="width: 100%" src="/storage/cover_images/{{$post->cover_image}}" alt="">
    </div>
<div class="col-md-8">
<h3><a href="/posts/{{$post->id}}">{{$post->title}}</a></h3>
<small>Writren on {{$post->created_at}}</small>
</div>
</div> --}}

    <li class="media">
        <img class="mw-100" src="/storage/cover_images/{{$post->cover_image}}" alt="">
      {{-- <img class="mr-3" src="/storage/cover_images/{{$post->cover_image}}" alt="Generic placeholder image"> --}}
      <div class="media-body">
        <h5 class="mt-0 mb-1"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h5>
        <small>Writren on {{$post->created_at}}</small>
      </div>
    </li>

@endforeach

</ul>
</div>

@else

@endif
@endsection
