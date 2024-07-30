@extends('layouts.master')

@section('content')
    <form action="{{ URL::to($indexUrl) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="firstname">First Name:*</label>
                <input type="text" value="{{old('firstname')}}" class="form-control @if ($errors->first('firstname'))is-invalid @endif" id="firstname" name="firstname" >
                <div class="invalid-feedback">{{ $errors->first('firstname') }}</div>

            </div>
            <div class="form-group col-md-6">
            <label for="email">Email:*</label>
                <input type="email" value="{{old('email')}}" class="form-control @if ($errors->first('email')) is-invalid @endif" id="email" name="email" >
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="username">Password:*</label>
                <input type="password" class="form-control @if ($errors->first('password')) is-invalid @endif" id="password" name="password" >
                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
            </div>
            <div class="form-group col-md-6">
                <label for="confirm_password">Confirm Password:*</label>
                <input type="password" class="form-control @if ($errors->first('confirm_password')) is-invalid @endif" id="confirm_password" name="confirm_password" >
                <div class="invalid-feedback">{{ $errors->first('confirm_password') }}</div>
            </div>
        </div>

        
        <button type="submit" class="btn btn-primary">Create</button>
    @endsection
