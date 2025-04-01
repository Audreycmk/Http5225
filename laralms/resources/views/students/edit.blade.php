@extends('layout')
@section('content')
<h1>Edit Student</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('students.update', $student -> id) }}" method="PUT">
        {{ csrf_field() }}
    <label for="fname">First name</label>
    <input type="text" name="fname" placeholder="fname" value="{{ old('fname') ?? $student -> fname }}">
    <label for="lname">Last name</label>
    <input type="text" name="lname" placeholder="lname" value="{{ old('lname') ?? $student -> lname }}">
    <label for="email">Email</label>
    <input type="email" name="email" placeholder="email" value="{{ old('email') ?? $student -> email }}">
    <button type="submit" value="Create">Edit student</button>
@endsection