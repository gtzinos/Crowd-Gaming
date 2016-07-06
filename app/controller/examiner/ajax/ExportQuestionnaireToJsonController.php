<?php

    include_once "../app/model/mappers/actions/ParticipationMapper.php";
    include_once "../app/model/mappers/questionnaire/QuestionnaireMapper.php";
    include_once "../app/model/mappers/questionnaire/QuestionMapper.php";
    include_once "../app/model/mappers/questionnaire/QuestionGroupMapper.php";
    include_once "../app/model/mappers/questionnaire/AnswerMapper.php";

    class ExportQuestionnaireToJsonController extends Controller
    {
        public function init()
        {
            $this->setView( new JsonView);
        }

        public function run()
        {

            if( !isset($this->params[1]) )
            {
                $this->setOutput("code" , '1');
                $this->setOutput("message" , "No questionnaire id was provided");

                return;
            }
            
            $participationMapper = new ParticipationMapper;

            
            if( !($participationMapper->participates($_SESSION["USER_ID"] , $this->params[1] , 2) || $_SESSION["USER_LEVEL"]!=3))
            {
                $this->setOutput("code" , '2');
                $this->setOutput("message" , "You dont have access to this questionnaire");
                
                return;
            }

            $questionnaireMapper = new QuestionnaireMapper;
            $questionGroupMapper = new QuestionGroupMapper;
            $questionMapper = new QuestionMapper;
            $answerMapper = new AnswerMapper;

            $questionnaire = $questionnaireMapper->findById($this->params[1]);

            $this->setOutput("questionnaire-name" , $questionnaire->getName());
            $this->setOutput("description" , $questionnaire->getDescription());
            $this->setOutput("message-required" , $questionnaire->getMessageRequired());
            $this->setOutput("allow-multiple-groups" ,$questionnaire->getAllowMultipleGroups());
            $this->setOutput("score-rights" , $questionnaire->getScoreRights());
            

            $groupOutput = array();


            $groups = $questionGroupMapper->findByQuestionnaire($questionnaire->getId());

            foreach ($groups as $group) 
            {
                $groupItem["group-name"] = $group->getName();
                $groupItem["latitude"] = $group->getLatitude();
                $groupItem["longitude"] = $group->getLongitude();
                $groupItem["radius"] = $group->getRadius();
                $groupItem["allowed-repeats"] = $group->getAllowedRepeats();
                $groupItem["time-to-complete"] = $group->getTimeToComplete();
                $groupItem["get-priority"] = $group->getPriority();

                $questions = $questionMapper->findByQuestionGroup($group->getId());

                $questionsOutput = array();

                foreach ($questions as $question ) 
                {
                    $questionItem["question-text"] = $question->getQuestionText();
                    $questionItem["time-to-answer"] = $question->getTimeToAnswer();
                    $questionItem["multiplier"] = $question->getMultiplier();

                    $answers = $answerMapper->findByQuestion($question->getId());

                    $answersOutput = array();

                    foreach ($answers as $answer) 
                    {
                        $answerItem["answer-text"] = $answer->getAnswerText();
                        $answerItem["is-correct"] = $answer->isCorrect();

                        $answersOutput[] = $answerItem;
                    }

                    $questionItem["answers"] = $answersOutput;

                    $questionsOutput[] = $questionItem;
                }

                $groupItem["questions"] = $questionsOutput;

                $groupOutput[] = $groupItem;
            }

            $this->setOutput("question-groups" , $groupOutput);
        }
    }