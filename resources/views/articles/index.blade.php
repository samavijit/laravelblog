@extends('layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel 5.5 CRUD Operation</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('articles.create') }}"> <i class="fa fa-plus"></i></a>
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
            <th>Title</th>
            <th>Body</th>
            <th width="300px">Action</th>
        </tr>
    @foreach ($articles as $article)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $article->title}}</td>
        <td>{{ $article->body}}</td>
        <td>
            <a class="btn btn-info" href="{{ route('articles.show',$article->id) }}"><i class="fa fa-eye"></i></a>
            <a class="btn btn-primary" href="{{ route('articles.edit',$article->id) }}"><i class="fa fa-pencil"></i></a>
            {!! Form::open(['method' => 'DELETE','route' => ['articles.destroy', $article->id],'style'=>'display:inline']) !!}
            <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
    </table>
    {!! $articles->links() !!}
@endsection