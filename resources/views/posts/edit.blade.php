@extends('layouts.master')

@section('content')
    <form action="{{ URL::to($indexUrl.'/'.$item->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-row">

            <div class="form-group col-md-6">
                <label for="name">Title:*</label>
                <input type="hidden" name="id" value="{{$item->id}}">
                <input required type="text" value="{{$item->title}}" class="form-control @if ($errors->first('title'))is-invalid @endif" id="title" name="title" >
                <div class="invalid-feedback">{{ $errors->first('title') }}</div>
            </div>
            <div class="form-group col-md-6">
                <label for="categories">Categories:</label>
                <select id="categories" multiple name="categories[]" class="form-control @if ($errors->first('categories'))is-invalid @endif">
                    @foreach($postCategories as $postCategoryKey => $postCategoryDatum)
                        <option @if($item->categories && in_array($postCategoryDatum->id, $item->categories->pluck('id')->toArray())) selected @endif   value="{{$postCategoryDatum->id}}">{{$postCategoryDatum->name}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">{{ $errors->first('categories') }}</div>
            </div> 
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="name">Body:*</label>
                <textarea required rows="7" name="body" class="form-control  @if ($errors->first('body'))is-invalid @endif">{{$item->body}}</textarea>
                <div class="invalid-feedback">{{ $errors->first('body') }}</div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="name">Image:</label>
                @if($item->image)
                    <img class="thumbnail img d-flex" height="100" src="{{asset('/uploads/posts/' . $item->image)}}">
                @endif
                <input type="file" name="image" class="form-control @if ($errors->first('image'))is-invalid @endif">
                <div class="invalid-feedback">{{ $errors->first('image') }}</div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    @endsection
