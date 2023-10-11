@extends('layouts.apps')

@section('content')
<div class="body flex-grow-1 px-3">
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12 margin-tb">
                        <h2>Products</h2>
                    </div>
                    <div class="pull-right">
                        @can('product-create')
                        <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product </a>
                        @endcan



                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                        @endif

                        <table class="table table-bordered">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Details</th>
                                <th width="280px">Action</th>
                            </tr>
                            @foreach ($products as $product)
                            <tr>
                                <td>p</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->details }}</td>
                                <td>
                                    <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                                        <a class="btn btn-info" href="{{ route('products.show',$product->id) }}">Show</a>
                                        @can('product-edit')
                                        <a class="btn btn-primary" href="{{ route('products.edit',$product->id) }}">Edit</a>
                                        @endcan


                                        @csrf
                                        @method('DELETE')
                                        @can('product-delete')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                        @endcan
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </table>

                        {!! $products->links() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection