<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Services\PdfParserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ExamController extends Controller
{
    public function home()
    {
        return view('exam.home');
    }

    public function start()
    {
        $questions = Question::all();

        if ($questions->isEmpty()) {
            return view('exam.exam', ['questions' => [], 'error' => 'No questions available.']);
        }

        return view('exam.exam', ['questions' => $questions, 'error' => null]);
    }

    public function submit(Request $request)
    {
        $questions = Question::all();

        if ($questions->isEmpty()) {
            return view('exam.exam', ['questions' => [], 'error' => 'No questions available.']);
        }

        $userAnswers = [];
        foreach ($questions as $q) {
            $answer = $request->input("q_{$q->id}");
            if ($answer) {
                $userAnswers[$q->id] = $answer;
            }
        }

        $result = $this->calculateScore($questions, $userAnswers);

        Session::put('result', $result);

        return view('exam.result', $result);
    }

    public function result()
    {
        $result = Session::get('result');

        if (!$result) {
            return view('exam.result', ['error' => 'No result found. Please take the test first.']);
        }

        return view('exam.result', $result);
    }

    public function reloadQuestions()
    {
        $pdfPath = storage_path('app/pdfs/questions.pdf');
        $parser = new PdfParserService();
        $questions = $parser->parse($pdfPath);

        if (empty($questions)) {
            return redirect()->back()->with('error', 'No questions found in PDF.');
        }

        Question::truncate();
        foreach ($questions as $q) {
            Question::create($q);
        }

        return redirect()->route('home')->with('success', count($questions) . ' questions loaded successfully.');
    }

    private function calculateScore($questions, array $userAnswers): array
    {
        $correct = 0;
        $wrong = 0;
        $unanswered = 0;

        foreach ($questions as $q) {
            if (isset($userAnswers[$q->id])) {
                if ($userAnswers[$q->id] === $q->correct_answer) {
                    $correct++;
                } else {
                    $wrong++;
                }
            } else {
                $unanswered++;
            }
        }

        $score = $correct - ($wrong * 0.5);
        $total = count($questions);
        $percentage = $total > 0 ? round(($score / $total) * 100, 1) : 0;

        return [
            'total' => $total,
            'correct' => $correct,
            'wrong' => $wrong,
            'unanswered' => $unanswered,
            'score' => $score,
            'percentage' => $percentage,
        ];
    }
}
