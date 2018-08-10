@extends('layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Upload File</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('medias.index') }}"> <i class="fa fa-arrow-left"></i></a>
            </div>
        </div>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(array('route' => 'medias.store','method'=>'POST','class'=>'dropzone')) !!}
         @include('medias.form')
    {!! Form::close() !!}
@endsection