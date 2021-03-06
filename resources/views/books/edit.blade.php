@extends('layouts.app')


@section('content')
  <div class="row">
    <div class="col-lg-12 margin-tb">
      <div class="pull-left">
        <h2>Edit Book</h2>
      </div>
      <div class="pull-right">
        <a class="btn btn-primary" href="{{ route('books.index') }}"> Back</a>
      </div>
    </div>
  </div>


  @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Whoops!</strong> There were some problems with your input.<br><br>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif


  <form action="{{ route('books.update',$books->id) }}" method="POST">
    @csrf
    @method('PUT')


    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
          <strong>Name:</strong>
          <input type="text" name="title" value="{{ $books->title }}" class="form-control" placeholder="Name">
        </div>
      </div>
      @hasrole('Admin')
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
          <strong>Author:</strong>
          <select name="author_id" class="form-control">
            <option value="">-- Select Author --</option>
            @foreach($authors as $author)
              <option value="{{ $author->id }}" {{ $author->id == $books->author_id ? 'selected' : '' }}>{{
                $author->name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
      @endhasrole
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
          <strong>Detail:</strong>
          <textarea class="form-control" style="height:150px" name="description"
                    placeholder="Detail">{{ $books->description }}</textarea>
        </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>


  </form>

@endsection