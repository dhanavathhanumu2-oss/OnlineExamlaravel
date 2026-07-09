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
