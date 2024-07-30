@extends('layouts.master')

@section('content')
    <table>
        <tr>
            <td><label for="name">Name:</label></td>
            <td><label for="name">{{ $user->name }}</label></td>
        </tr>
        <tr>
            <td><label for="firstName">Email:</label></td>
            <td><label for="firstName">{{ $user->email }}</label></td>
        </tr>
        <tr>
            <td><label for="firstName">Email verified at:</label></td>
            <td><label for="firstName">{{ $user?->email_verified_at?->format('Y-m-d') ?? 'N/A' }}</label></td>
        </tr>
       
    </table>
@endsection
