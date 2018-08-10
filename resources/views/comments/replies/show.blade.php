@extends('layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Replies</h2>
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
            <th width="300px"></th>
            <th width="300px"></th>
            
        </tr>
    @foreach ($replies as $reply)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $reply->author }}</td>
        <td>{{ $reply->email }}</td>
        <td>{{ $reply->body }}</td>
        <td>
            <a href="{{ route('home.post',$reply->comment->post->id) }}">View Post</a>
        </td>
        <td>
        	@if($reply->is_active == 1)

				{!! Form::open(array('route' => ['replies.update',$reply->id],'method'=>'PATCH')) !!}

					<input type="hidden" name="is_active" value="0">

					<div class="form-group">
					<button type="submit" class="btn btn-primary">Un-approve</button>
					</div>

				{!! Form::close() !!}

        	@else

        		{!! Form::open(array('route' => ['replies.update',$reply->id],'method'=>'PATCH')) !!}

					<input type="hidden" name="is_active" value="1">
					
					<div class="form-group">
					<button type="submit" class="btn btn-primary">Approve</button>
					</div>

				{!! Form::close() !!}


        	@endif

        </td>

        <td>
        	
			{!! Form::open(array('route' => ['replies.destroy',$reply->id],'method'=>'DELETE')) !!}

				
				<div class="form-group">
				<button type="submit" class="btn btn-primary">Delete</button>
				</div>

			{!! Form::close() !!}

        </td>
        
    </tr>
    @endforeach
    </table>
   
@endsection