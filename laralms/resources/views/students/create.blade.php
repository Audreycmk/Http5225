@extends('layout')
@section('content')
<h1>Add student</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </ul>
        </div>
    @endif
<form action="{{ route('students.store') }}" method="POST">
    {{ csrf_field() }}
    <label for="fname">First name</label>
    <input type="text" name="fname" placeholder="fname" value="{{ old('fname') }}">
    <label for="lname">Last name</label>
    <input type="text" name="lname" placeholder="lname" value="{{ old('lname') }}">
    <label for="email">Email</label>
    <input type="email" name="email" placeholder="email" value="{{ old('email') }}">
    <button type="submit" value="Create">Add student</button>
@endsection