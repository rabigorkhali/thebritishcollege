@extends('layouts.master')

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Categories</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @if ($posts->count())
            @foreach ($posts as $keyPostDatum => $datumPost)
                <tr>

                    <td>{{ $i = 1 + $keyPostDatum }}</td>
                    <td>{{ $datumPost->title ?? '' }}</td>
                    <td>
                        @php        $categories = ''; @endphp
                        @foreach ($datumPost->categories as $datumCategory)
                                @php
                                    $categories .= $datumCategory->name . ', '
                                @endphp
                        @endforeach
                        {{ rtrim(trim($categories), ',') ?? 'N/A' }}
                    </td>
                    <td>
                        @if($datumPost->image)
                            <img class="thumbnail img" height="20" src="{{asset('/uploads/posts/' . $datumPost->image)}}">
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-sm btn-dark" href="{{ URL::to($indexUrl) . '/' . $datumPost->id }}">View</a>
                        <a class="btn btn-sm btn-primary"
                            href="{{ URL::to($indexUrl) . '/' . $datumPost->id . '/edit' }}">Edit</a>
                        <button class="btn btn-danger btn-sm delete-button" data-toggle="modal" data-target="#confirmationModal"
                            data-actionurl="{{ URL::to($indexUrl) . '/' . $datumPost->id }}">Delete</button>
                    </td>

                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="7">Data not found.</td>
            </tr>
        @endif


    </tbody>

</table>
<div class="row">
    <ul class="pagination">
        {{ $posts->links() }}
    </ul>
</div>

@include('layouts.delete-modal')
@endsection