@extends('layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Laravel 5.5 CRUD Operation</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('medias.create') }}"> <i class="fa fa-plus"></i></a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <form action="/delete/media" method="post" class="form-inline">
        
        <div class="form-group">
            
            <select name="checkboxArray" class="form-control">
                
                <option value="delete">Delete</option>
            
            </select>    

        </div>

        <div class="form-group">
            
            <input type="submit" name="Submit" class="btn btn-general">

        </div>
        <br>
   
    <table class="table table-bordered">
        <tr>
            <th><input type="checkbox" name="" id="options"></th>
            <th></th>
         
            <th>Image</th>
            <th>Created AT</th>
            <th>Updated AT</th>
            <th width="300px">Action</th>
        </tr>
    @foreach ($photos as $photo)
    <tr>
        <td><input type="checkbox" name="checkboxArray[]" class="checkBoxes" value="{{ $photo->id }}"></td>
        <td>{{ $loop->iteration }}</td>
        <td><img height="50px" src="{{ $photo->file ? $photo->file:''}}"></td>
        <td>{{ $photo->created_at}}</td>
        <td>{{ $photo->updated_at}}</td>
        <td>
            {!! Form::open(['method' => 'DELETE','route' => ['medias.destroy', $photo->id],'style'=>'display:inline']) !!}
            <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
            {!! Form::close() !!}
        </td>
    </tr>
    @endforeach
    </table>
    </form>
    {!! $photos->links() !!}

@endsection

@section('scripts')
<script language="JavaScript" type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
    
    $(document).ready(function(){

        $('#options').click(function(){

            if(this.checked)
            {
                $( ".checkBoxes" ).each(function() {
                
                    this.checked = true;

                });
            }
            else
            {
                $( ".checkBoxes" ).each(function() {

                    this.checked = false;

                });
            }

        });

    });

</script>

@endsection



