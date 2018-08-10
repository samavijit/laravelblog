@extends('layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel 5.5 CRUD Operation</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('posts.create') }}"> <i class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Owner</th>
            <th>Category</th>
            <th>Image</th>

            <th>Title</th>
            <th>Body</th>
            <th width="300px">Action</th>
            <th width="300px"></th>
            <th width="300px"></th>
        </tr>
    @foreach ($posts as $post)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $post->user->name }}</td>
        <td>{{ $post->category->name }}</td>
        <td><img height="50px" src="{{ $post->photo ? $post->photo->file:''}}"></td>
        <td>{{ $post->title}}</td>
        <td>{{ substr($post->body, 0, 100)}}</td>
        
        <td>
            <a class="btn btn-info" href="{{ route('posts.show',$post->id) }}"><i class="fa fa-eye"></i></a>
            <a class="btn btn-primary" href="{{ route('posts.edit',$post->id) }}"><i class="fa fa-pencil"></i></a>
            {!! Form::open(['method' => 'DELETE','route' => ['posts.destroy', $post->id],'style'=>'display:inline']) !!}
            <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
            {!! Form::close() !!}
        </td>
        <td>
            <a href="{{ route('home.post',$post->slug) }}">View Post</a>
        </td>
         <td>
            <a href="{{ route('comments.show',$post->id) }}">View Comment</a>
        </td>
    </tr>
    @endforeach
    </table>
    {!! $posts->links() !!}
@endsection