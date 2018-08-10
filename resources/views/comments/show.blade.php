@extends('layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Comments</h2>
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
            <th>Author </th>
            <th>Email</th>
            <th>Body</th>
            <th width="300px"></th>
            
        </tr>
    @foreach ($comments as $comment)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $comment->author }}</td>
        <td>{{ $comment->email }}</td>
        <td>{{ $comment->body }}</td>
        <td>
            <a href="{{ route('home.post',$comment->post->id) }}">View Post</a>
        </td>
        
    </tr>
    @endforeach
    </table>
   
@endsection