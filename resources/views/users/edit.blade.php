@extends('layouts.master')

@section('content')
    <form action="{{ URL::to($indexUrl.'/'.$users->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Name:*</label>
                <input type="text" value="{{$users->name}}" class="form-control @if ($errors->first('name'))is-invalid @endif" id="name" name="name" >
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>

            </div>
            <div class="form-group col-md-6">
            <label for="email">Email:*</label>
                <input type="email" value="{{$users->email}}" class="form-control @if ($errors->first('email')) is-invalid @endif" id="email" name="email" >
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="username">Password:</label>
                <input type="password" class="form-control @if ($errors->first('password')) is-invalid @endif" id="password" name="password" >
                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                <span>Note: Leave empty if you dont want to change password.</span>
            </div>
            <div class="form-group col-md-6">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control @if ($errors->first('confirm_password')) is-invalid @endif" id="confirm_password" name="confirm_password" >
                <div class="invalid-feedback">{{ $errors->first('confirm_password') }}</div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    @endsection
