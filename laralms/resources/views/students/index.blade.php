@extends('layout')
@section('content')
<h1>All students</h1>
<ul>
    @foreach ($students as $student)
        <li>
            {{ $student -> fname }} {{ $student -> lname }} -
            <a href="{{ route('students.edit', $student -> id )}}">Edit</a>
           <form action="{{ route('students.destroy', $student -> id) }}" method="POST">
                {{ csrf_field() }}
                @method('DELETE')
                <input type="submit" value="Delete">
           </form>
        </li>
    @endforeach
</ul>

@endsection



{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    All students
    @foreach ( $students as $student)
            {{$student -> fname}} <br>
    @endforeach
</body>
</html> --}}
