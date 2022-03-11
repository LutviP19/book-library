@extends('layouts.app')


@section('content')
  <div class="row">
    <div class="col-lg-12 margin-tb mb-5">
      <div class="pull-left">
        <h2>Book Authors</h2>
      </div>
      <div class="pull-right">
        @can('book-author-create')
          <a class="btn btn-success" href="{{ route('book-authors.create') }}"> Create New Author</a>
        @endcan
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
      <th>No</th>
      <th>Name</th>
      <th width="280px">Action</th>
    </tr>
    @forelse ($data as $item)
      <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $item->name }}</td>
        <td>
          <form action="{{ route('book-authors.destroy',$item->id) }}" method="POST">
            <a class="btn btn-info" href="{{ route('book-authors.show',$item->id) }}">Show</a>
            @can('book-author-edit')
              <a class="btn btn-primary" href="{{ route('book-authors.edit',$item->id) }}">Edit</a>
            @endcan


            @csrf
            @method('DELETE')
            @can('book-author-delete')
              <button type="submit" class="btn btn-danger">Delete</button>
            @endcan
          </form>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="2">Data is empty</td>
      </tr>
    @endforelse
  </table>


  {!! $data->links() !!}
@endsection