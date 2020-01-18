<?php

namespace Veloxia\Markup\Generators;

use Veloxia\Markup\MarkupGenerator;
use Veloxia\Markup\Schema\Classes\FAQPage;
use Veloxia\Markup\Schema\Classes\Question;
use Veloxia\Markup\Schema\Classes\Answer;

class FAQ extends MarkupGenerator
{

    /**
     * Create a new FAQ section. An array of question => answer pairs may be passed as input.
     * 
     * @param array $questions
     */
    public function __construct(array $questions = [])
    {

        $this->model = new FAQPage;

        foreach ($questions as $question => $answer) {
            $this->question($question, $answer);
        }
    }

    /**
     * Adds a question to the FAQ.
     * 
     * @param string $questionText
     * @param string $answerText
     * @return self|void
     */
    public function question($questionText, string $answerText = null)
    {
        // create question
        $question = new Question;
        $question->name($questionText);

        // create an empty answer and mark it as accepted
        $answer  = new Answer;

        $question->acceptedAnswer($answer);
        $this->model->mainEntity($question);

        // if no answer has been set, prepare chaining
        if (is_null($answerText)) {
            $this->setDanglingItem("answer", $answer);
            return $this;
        }

        // otherwise set it
        else {
            $answer->text($answerText);
        }
    }

    /**
     * Adds an answer to the preceeding question.
     * 
     * @param string $questionText
     * @param string $answerText
     */
    public function answer(string $answerText)
    {
        $this->getDanglingItem("answer")->text($answerText);
    }
}
