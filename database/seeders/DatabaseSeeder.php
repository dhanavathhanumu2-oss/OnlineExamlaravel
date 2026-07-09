<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Services\PdfParserService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $pdfPath = storage_path('app/pdfs/questions.pdf');
        $parser = new PdfParserService();
        $questions = $parser->parse($pdfPath);

        if (!empty($questions)) {
            foreach ($questions as $q) {
                Question::create($q);
            }
            $this->command->info('Loaded ' . count($questions) . ' questions from PDF.');
        } else {
            $this->command->warn('No questions found in PDF. Place questions.pdf in storage/app/pdfs/');
        }
    }
}
