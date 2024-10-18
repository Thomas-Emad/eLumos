<?php

namespace App\Services;

use App\Models\ExamQuestion;
use App\Models\ExamQuestionAnswer;


class ExamQuestionService
{
  /**
   * Create a new class instance.
   */
  public function __construct()
  {
    //
  }

  /**
   * Store a question in the database.
   *
   * @param int $examId The ID of the exam.
   * @param string $title The title of the question.
   * @param string $typeQuestion The type of the question.
   * @return int The ID of the stored question.
   */
  public function storeQuestion($examId, $title, $typeQuestion): int
  {
    $question = ExamQuestion::create([
      'exam_id' => $examId,
      'title' => $title,
      'type_question' => $typeQuestion,
    ]);

    return $question->id;
  }

  /**
   * Store answers of question.
   *
   * @param int $examId The id of exam.
   * @param int $questionId The id of question.
   * @param array $answers The list of answers.
   * @param array $statusAnswers The list of key of answers that is true.
   * @param string $typeQuestion The type of question.
   * @return void
   */
  public function storeAnswers($examId, $questionId, $answers, $statusAnswers, $typeQuestion): void
  {
    foreach ($answers as $key => $title) {
      $status = in_array($key, $statusAnswers);

      ExamQuestionAnswer::create([
        'exam_id' => $examId,
        'question_id' => $questionId,
        'type_question' => $typeQuestion,
        'answer' => $title,
        'is_true' => (bool) $status,
      ]);
    }
  }
}
