<?php

namespace App\Services;

use App\Http\Traits\UploadAttachmentTrait;

class StudentExamService
{
  use UploadAttachmentTrait;

  protected float $resultDegree = 0;
  protected bool $needManuallyCorrect = false;

  /**
   * Iterate over the questions in the session and compare the student's answers to the correct ones.
   * 
   * @param StudentCourseExam $session The session object representing the student's exam session.
   * @param array $userQuestionRequested The list of questions that the student submitted answers for.
   * @return void
   */
  public function questionsEngine($session, $userQuestionRequested)
  {
    foreach ($session->exam->questions as $question) {
      $keyQuestionsAnswersStudent = array_keys($userQuestionRequested);
      if (in_array($question->id, $keyQuestionsAnswersStudent)) {

        // Check From Answer This Question
        $questionStudent = $userQuestionRequested[$question->id];
        $rightAnswersQuestion = $question->answers->where('is_true', true)->pluck('id')->toArray();

        foreach ($questionStudent['answers'] as $answer) {
          $this->answerEngine(
            $session,
            $question->id,
            $question->type_question,
            $answer,
            $rightAnswersQuestion
          );
        }
      }
    }
  }

  /**
   * Engine for processing each answer of the student.
   *
   * @param StudentCourseExam $session The session object representing the student's exam session.
   * @param int $questionID The ID of the question being answered.
   * @param string $typeQuestion The type of the question.
   * @param mixed $answerStudent The student's answer content.
   * @param array $rightAnswersQuestion The list of right answers for the question.
   * @return void
   */
  protected function answerEngine($session, int $questionID, string $typeQuestion, mixed $answerStudent, array $rightAnswersQuestion)
  {
    $content = $this->handleAnswerContent($typeQuestion, $answerStudent);

    $isTrue = $this->evaluateAnswer($typeQuestion, $answerStudent, $rightAnswersQuestion);

    // If the question needs manual correction
    if ($isTrue === null) {
      $this->needManuallyCorrect = true;
    }

    // Choose Defult answer if his type Text|Attachment
    if (in_array($typeQuestion, ['text', 'attachment'])) {
      $answerStudent = $rightAnswersQuestion[0];
    }

    $this->saveStudentAnswer($session, $questionID, $answerStudent, $content, $isTrue);
  }

  /**
   * Handle and process the content of the student's answer based on the question type.
   *
   * @param string $typeQuestion The type of the question ('attachment', 'text', etc.).
   * @param mixed $answerStudent The student's answer content.
   * @return string|null The processed content or null if the type is unsupported.
   * @throws \Exception If there is a failure in uploading the attachment.
   */
  protected function handleAnswerContent(string $typeQuestion, mixed $answerStudent): ?string
  {
    switch ($typeQuestion) {
      case 'attachment':
        try {
          return static::uploadAttachment($answerStudent, 'exams', 'auto');
        } catch (\Exception $e) {
          throw new \Exception('Failed To Upload attachment: ' . $e->getMessage());
        }

      case 'text':
        return $answerStudent;

      default:
        return null;
    }
  }

  /**
   * Evaluate the student's answer to a question.
   * 
   * @param string $typeQuestion The type of the question.
   * @param mixed $answerStudent The student's answer to the question.
   * @param array $rightAnswersQuestion The correct answers to the question.
   * @return bool|null True if the student's answer is correct, false if it is incorrect,
   * or null if manual correction is needed.
   */
  protected function evaluateAnswer(string $typeQuestion, $answerStudent, array $rightAnswersQuestion): bool|null
  {
    // For text and attachment questions, manual correction is needed
    if (in_array($typeQuestion, ['text', 'attachment'])) {
      // Assign the first correct answer, but manual correction needed
      $answerStudent = $rightAnswersQuestion[0];
      return null;
    }

    $isTrue = in_array($answerStudent, $rightAnswersQuestion);
    $this->calcDegreeAnswer($typeQuestion, $rightAnswersQuestion, $isTrue);

    return $isTrue;
  }

  /**
   * Calculate the degree of the right answer, if the question is a checkbox type.
   *
   * @param string $typeQuestion The type of the question.
   * @param array $rightAnswersQuestion The list of right answers for the question.
   * @param bool $isTrue Whether the answer is correct or not.
   * @return void
   */
  protected function calcDegreeAnswer(string $typeQuestion, array $rightAnswersQuestion, bool $isTrue)
  {
    // get Diffrent Answers For Calc right Result Degree, if This Question is Checkbox Type.
    if (count($rightAnswersQuestion) === 0) {
      return null;
    }
    if ($typeQuestion === 'checkbox' && !$isTrue) {
      $this->resultDegree -=  (1 / count($rightAnswersQuestion));
    } else {
      $this->resultDegree += $isTrue === true ? (1 / count($rightAnswersQuestion)) : 0;
    }
  }


  /**
   * Save the student's answer to the database.
   * 
   * @param mixed $session The session object representing the student's exam session.
   * @param int $questionID The ID of the question being answered.
   * @param int $answerStudentId The ID of the student's selected answer.
   * @param mixed $content The content of the answer, applicable for text or attachment questions.
   * @param bool|null $isTrue Indicates if the answer is correct (null if manual correction is required).
   * @return void
   */
  protected function saveStudentAnswer($session, int $questionID, int $answerStudentId, mixed $content, ?bool $isTrue): void
  {
    $session->answerStudent()->create([
      'question_id' => $questionID,
      'answer_id' => $answerStudentId,
      'content' => $content,
      'is_true' => $isTrue
    ]);
  }

  /**
   * Get the status of the exam, based on the results of the exam questions.
   * If the exam has questions that need manual correction, the status is 'waiting',
   * otherwise, the status is 'sucess' if the overall result is 50% or higher, or 'failed' otherwise.
   * @param int $questionCount The number of questions in the exam.
   * @return string One of 'waiting', 'sucess', or 'failed'.
   */
  public function getStatusExam(int $questionCount): string
  {
    return match ($this->isManuallyCorrect()) {
      true => 'waiting',
      false => (($this->resultDegree / $questionCount) * 100) >= 50 ? 'sucess' : 'failed',
    };
  }

  /**
   * Get the degree of the exam.
   *
   * @return float The degree of the exam.
   */
  public function getDegree(): float
  {
    return $this->resultDegree;
  }

  /**
   * Check if the exam requires manual correction.
   *
   * @return bool True if manual correction is needed, false otherwise.
   */
  public function isManuallyCorrect(): Bool
  {
    return $this->needManuallyCorrect;
  }
}
