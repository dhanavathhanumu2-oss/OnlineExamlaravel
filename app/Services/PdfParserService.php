<?php

namespace App\Services;

use Smalot\PdfParser\Parser;

class PdfParserService
{
    public function parse(string $pdfPath): array
    {
        if (!file_exists($pdfPath)) {
            return [];
        }

        $parser = new Parser();
        $pdf = $parser->parseFile($pdfPath);
        $text = $pdf->getText();

        return $this->extractQuestions($text);
    }

    private function extractQuestions(string $text): array
    {
        $questions = [];
        $blocks = preg_split("/\n(?=Q\d+[\.\s])/", $text);

        foreach ($blocks as $block) {
            $block = trim($block);
            if (empty($block)) {
                continue;
            }

            preg_match("/^Q\d+[\.\s]+(.+)/m", $block, $questionMatch);
            if (empty($questionMatch)) {
                continue;
            }

            preg_match("/^A[\.\s]+(.+)$/m", $block, $optionA);
            preg_match("/^B[\.\s]+(.+)$/m", $block, $optionB);
            preg_match("/^C[\.\s]+(.+)$/m", $block, $optionC);
            preg_match("/^D[\.\s]+(.+)$/m", $block, $optionD);
            preg_match("/Answer:\s*([A-D])/i", $block, $answerMatch);

            if ($optionA && $optionB && $optionC && $optionD && $answerMatch) {
                $questions[] = [
                    'question' => trim($questionMatch[1]),
                    'option_a' => trim($optionA[1]),
                    'option_b' => trim($optionB[1]),
                    'option_c' => trim($optionC[1]),
                    'option_d' => trim($optionD[1]),
                    'correct_answer' => strtoupper(trim($answerMatch[1])),
                ];
            }
        }

        return $questions;
    }
}
