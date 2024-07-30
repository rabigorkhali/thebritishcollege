@extends('layouts.master')

@section('content')
    <form action="{{ URL::to($indexUrl.'/'.$item->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Name:*</label>
                <input type="hidden" name="id" value="{{$item->id}}">
                <input type="text" value="{{$item->name}}" class="form-control @if ($errors->first('name'))is-invalid @endif" id="name" name="name" >
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>

            </div>
           
        </div>
      
        <button type="submit" class="btn btn-primary">Update</button>
    @endsection
