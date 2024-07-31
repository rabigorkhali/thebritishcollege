@extends('layouts.master')

@section('content')
    <form action="{{ URL::to($indexUrl) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="name">Title:*</label>
                <input required type="text" value="{{old('title')}}" class="form-control @if ($errors->first('name'))is-invalid @endif" id="title" name="title" >
                <div class="invalid-feedback">{{ $errors->first('title') }}</div>
            </div>
            <div class="form-group col-md-6">
                <label for="categories">Categories:*</label>
                
                <select id="categories" multiple name="categories[]" class="form-control @if ($errors->first('categories'))is-invalid @endif">
                        <option>Select</option>
                    @foreach($postCategories as $postCategoryKey => $postCategoryDatum)
                        <option @if(old('categories') && in_array($postCategoryDatum->id, old('categories'))) selected @endif   value="{{$postCategoryDatum->id}}">{{$postCategoryDatum->name}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">{{ $errors->first('categories') }}</div>
            </div>
            
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="name">Body:*</label>
                <textarea required rows="7" name="body" class="form-control  @if ($errors->first('body'))is-invalid @endif">{{old('body')}}</textarea>
                <div class="invalid-feedback">{{ $errors->first('body') }}</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="name">Image:</label>
                <input type="file" name="image" class="form-control @if ($errors->first('image'))is-invalid @endif">
                <div class="invalid-feedback">{{ $errors->first('image') }}</div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    @endsection
