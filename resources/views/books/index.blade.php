@extends('layouts.app')


@section('content')
  <div class="row">
    <div class="col-lg-12 margin-tb mb-5">
      <div class="pull-left">
        <h2>Books</h2>
      </div>
      <div class="pull-right">
        @can('book-create')
          <a class="btn btn-success" href="{{ route('books.create') }}"> Create New Book</a>
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
      <th>Author</th>
      <th>Description</th>
      <th width="280px">Action</th>
    </tr>
    @forelse ($data as $item)
      <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $item->title }}</td>
        <td>{{ $item->author_id ? $item->author->name : '' }}</td>
        <td>{{ $item->description }}</td>
        <td>
          <form action="{{ route('books.destroy',$item->id) }}" method="POST">
            <a class="btn btn-info" href="{{ route('books.show',$item->id) }}">Show</a>
            @can('book-edit')
              <a class="btn btn-primary" href="{{ route('books.edit',$item->id) }}">Edit</a>
            @endcan


            @csrf
            @method('DELETE')
            @can('book-delete')
              <button type="submit" class="btn btn-danger">Delete</button>
            @endcan
          </form>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="5">Data is empty</td>
      </tr>
    @endforelse
  </table>


  {!! $data->links() !!}
@endsection