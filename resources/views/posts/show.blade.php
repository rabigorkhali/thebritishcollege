@extends('layouts.master')

@section('content')
<table>
    <tr>
        <td><label for="name">{{__('Title')}}: </label></td>
        <td><label for="name">{{ $posts->title }}</label></td>
    </tr>
    <tr>
        <td><label for="name">{{__('Category')}}: </label></td>
        <td>
            <label for="name">
                @php $categories=''; @endphp
                @foreach ($posts->categories as $datumCategory)
                    @php
                        $categories.=$datumCategory->name.', '
                    @endphp
                @endforeach
                {{ rtrim(trim($categories),',')??'N/A' }}
            </label>
        </td>
    </tr>
    <tr>
        <td><label for="name">{{__('Body')}}: </label></td>
        <td><label for="name">{{ $posts->body }}</label></td>
    </tr>
    <tr>
        <td><label for="firstName">Created at: </label></td>
        <td><label for="firstName">{{ $posts?->created_at?->format('Y-m-d') ?? 'N/A' }}</label></td>
    </tr>
    <tr>
        <td><label>{{__('Image')}}:</label></td>
        <td>
            @if($posts->image)
                <img class="thumbnail img" height="100" src="{{asset('/uploads/posts/' . $posts->image)}}">
            @endif
        </td>
    </tr>
    

</table>
@endsection