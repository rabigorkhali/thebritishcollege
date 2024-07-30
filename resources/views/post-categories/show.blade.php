@extends('layouts.master')

@section('content')
    <table>
        <tr>
            <td><label for="name">Name: </label></td>
            <td><label for="name">{{ $postCategories->name }}</label></td>
        </tr>
        <tr>
            <td><label for="firstName">Created at: </label></td>
            <td><label for="firstName">{{ $postCategories?->created_at?->format('Y-m-d') ?? 'N/A' }}</label></td>
        </tr>
       
    </table>
@endsection
