@extends('layouts.app')

@section('content')
<div class="card">
    <h1>Online Examination System</h1>
    <p class="description">
        Welcome to the Online Examination System. Click the button below to start your test.
        You will have 30 minutes to complete the exam.
    </p>
    <a href="{{ route('start') }}" class="btn btn-primary">Start Test</a>
</div>

@if(session('success'))
    <div class="card" style="border-color: #28a745;">
        <p style="color: #28a745; font-weight: bold;">{{ session('success') }}</p>
    </div>
@endif
@if(session('error'))
    <div class="card" style="border-color: #dc3545;">
        <p style="color: #dc3545; font-weight: bold;">{{ session('error') }}</p>
    </div>
@endif
@endsection
