@extends('layouts.app')

@section('title', 'Exam')

@section('content')
@if($error)
    <div class="card">
        <h1>Error</h1>
        <p>{{ $error }}</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Go Home</a>
    </div>
@else
    <div class="timer-container">
        <span id="timer">30:00</span>
    </div>

    <form id="examForm" action="{{ route('submit') }}" method="POST">
        @csrf
        <div class="questions-wrapper">
            @foreach($questions as $index => $q)
                <div class="card question-card">
                    <h3>Question {{ $loop->iteration }}</h3>
                    <p class="question-text">{{ $q->question }}</p>
                    <div class="options">
                        <label class="option">
                            <input type="radio" name="q_{{ $q->id }}" value="A">
                            <span>A. {{ $q->option_a }}</span>
                        </label>
                        <label class="option">
                            <input type="radio" name="q_{{ $q->id }}" value="B">
                            <span>B. {{ $q->option_b }}</span>
                        </label>
                        <label class="option">
                            <input type="radio" name="q_{{ $q->id }}" value="C">
                            <span>C. {{ $q->option_c }}</span>
                        </label>
                        <label class="option">
                            <input type="radio" name="q_{{ $q->id }}" value="D">
                            <span>D. {{ $q->option_d }}</span>
                        </label>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="submit-container">
            <button type="submit" class="btn btn-primary">Submit Exam</button>
        </div>
    </form>
@endif
@endsection

@push('scripts')
<script>
    window.questionsCount = {{ count($questions) }};
</script>
<script>
(function() {
    const TIMER_DURATION_MINUTES = 30;
    let totalSeconds = TIMER_DURATION_MINUTES * 60;
    const timerElement = document.getElementById("timer");
    const examForm = document.getElementById("examForm");

    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return String(mins).padStart(2, "0") + ":" + String(secs).padStart(2, "0");
    }

    function updateTimerDisplay() {
        timerElement.textContent = formatTime(totalSeconds);
    }

    function autoSubmit() {
        if (examForm) {
            examForm.submit();
        }
    }

    function tick() {
        if (totalSeconds <= 0) {
            autoSubmit();
            return;
        }
        totalSeconds--;
        updateTimerDisplay();
    }

    updateTimerDisplay();
    setInterval(tick, 1000);

    window.addEventListener("beforeunload", function (e) {
        if (totalSeconds > 0) {
            e.preventDefault();
            e.returnValue = "Your exam is in progress. Are you sure you want to leave?";
        }
    });
})();
</script>
@endpush
