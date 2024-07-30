@extends('layouts.master')

@section('content')
    <form action="{{ URL::to($indexUrl) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Name/Title:*</label>
                <input required type="text" value="{{old('name')}}" class="form-control @if ($errors->first('name'))is-invalid @endif" id="name" name="name" >
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            </div>
            
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    @endsection
