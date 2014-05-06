<?php

class Application_Model_Quiz
{
	private $questions;
	private $validAnswers;
	
	public function __construct(){
		//$answers = new Application_Model_DbTable_Answers();
		$questions = new Application_Model_DbTable_Questions();
		$valid_answers = new Application_Model_DbTable_AnswersTemplate();
		$this->validAnswers = $valid_answers->fetchAll();
		$select = $questions->select();
		$this->questions = $questions->fetchAll(null, "id ASC");
	}
	
	public function getQuestions (){
		return $this->questions;
	}
	
	public function getValidAnswers(){
		return $this->validAnswers;
	}
	
	public function getQsAs(){
		$questionaire = array();
		$answers = array();
		
		
		$i=0;
		foreach($this->questions as $q){
			$curAnswer = array();
			$nextQ = array();
			foreach ($this->validAnswers as $a){
				//$answers[$a->question_id] = array($a->valid_answer);
				if ($a->question_id==$q->id){
					$curAnswer[$a->id]= $a->valid_answer;
					$nextQ [$a->id]= $a->next_question; 
				}
				$questionaire[$i] = array($q->title,$q->question, $curAnswer, $q->id, $nextQ);
			}
			$i++;
		}
		
		return $questionaire;
	}
	
	public function getQuizForm(){
		$form = new Application_Form_QuizForm();
		$form->setQuestionaire($this->getQsAs());
		return $form;
	}
	
	public function saveAnswers($data){
		$answers = new Application_Model_DbTable_Answers();
		
		//var_dump($data);
		$data = array(
				'id' => '',
				'q1' => $data["q_1"],
				'q2' => $data["q_2"],
				'q3' => $data["q_3"],
				'q4' => $data["q_4"],
				'q5' => $data["q_5"]
		);	
		$answers->insert($data);
	}
}

