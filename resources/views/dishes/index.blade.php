@extends('dishes.layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('dishes.create') }}"> Create New Dish</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    {{-- {{ var_dump($dishes)}} --}}
    <table class="table table-bordered">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Image</th>
            <th>Descpription</th>
            <th>Price</th>
            <th width="280px">Action</th>
        </tr>
        <?php $i=0;?>
        {{-- {{$i=0}} --}}
        @foreach ($dishes as $dish)
        <tr>     
            <td>{{ ++$i }}</td>
            <td style="background-image:url({{ asset('images/' . $dish->image) }});
            height: 63px;
            background-position: center;
            background-size:cover;
            background-repeat:no-repeat;
            "></td>
            <td>{{ $dish->name }}</td>
            <td>{{ $dish->description }}</td>
            <td>{{ $dish->price}}</td>
            <td>
                <form action="{{ route('dishes.destroy',$dish->id) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ route('dishes.show',$dish->id) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('dishes.edit',$dish->id) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
  
    {{-- {!! $dishes->links() !!} --}}
      
@endsection
