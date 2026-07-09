@extends('layouts.app')

@section('title', 'Result')

@section('content')
@if(isset($error))
    <div class="card">
        <h1>Error</h1>
        <p>{{ $error }}</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Go Home</a>
    </div>
@else
    <div class="card result-card">
        <h1>Exam Result</h1>
        <div class="result-grid">
            <div class="result-item">
                <span class="result-label">Total Questions</span>
                <span class="result-value">{{ $total }}</span>
            </div>
            <div class="result-item correct">
                <span class="result-label">Correct Answers</span>
                <span class="result-value">{{ $correct }}</span>
            </div>
            <div class="result-item wrong">
                <span class="result-label">Wrong Answers</span>
                <span class="result-value">{{ $wrong }}</span>
            </div>
            <div class="result-item unanswered-item">
                <span class="result-label">Unanswered</span>
                <span class="result-value">{{ $unanswered }}</span>
            </div>
            <div class="result-item score-item">
                <span class="result-label">Final Score</span>
                <span class="result-value">{{ $score }}</span>
            </div>
            <div class="result-item percentage-item">
                <span class="result-label">Percentage</span>
                <span class="result-value">{{ $percentage }}%</span>
            </div>
        </div>
        <a href="{{ route('home') }}" class="btn btn-primary">Take Test Again</a>
    </div>
@endif
@endsection
