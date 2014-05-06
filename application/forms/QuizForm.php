<?php

class Application_Form_QuizForm extends Zend_Form
{

    public function init(){
    	
    }
    
    public function setQuestionaire ($qas){    	
    	/* Form Elements & Other Definitions Here ... */
    	$groupid = 1; //Question id to group answers
    	
    	$elementDecorators = array(
		    'ViewHelper',
		    'Errors',
		    array('Description', array('tag' => 'p', 'class' => 'description')),
		    array('HtmlTag',     array('class' => 'radio')),
		    array('Label',       array('tag'=>'h1', 'class' => 'form-label'))
		);
    	
    	
    	foreach ($qas as $qa){ //iterate through questions to create an element for each question
    		$tempElement = new Zend_Form_Element_Radio("q_".$qa[3]);
    		$tempElement->setLabel($qa[1]);
    		$tempElement->setMultiOptions($qa[2]);
    		$tempElement->setRequired(true);
    		//$tempElement->setAttrib("required", "true");
    		//echo $qa[1] ;
    		/*$answerid=1; //specific answers id for each question
    		 foreach ($qa[2] as $validAnswer){
    		$answerid++; ?>
    		<label class="radio">
    		<input type="radio" name="optionsRadios<?php echo $groupid; ?>" id="optionsRadios<?php echo $answerid; ?>" value="option<?php echo $answerid;?>">
    		<?php echo $validAnswer; ?>
    		</label><?php
    		}
    		$groupid++;*/
    		$tempElement->setAttrib("class", "radio");
    		//$tempElement->removeDecorator('Label');
    		//$tempElement->removeDecorator('HtmlTag');
    		//$tempElement->removeDecorator("DtDWrapper");
    		$tempElement->setDecorators($elementDecorators);
    		$this->addElement($tempElement);
    	}
    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel("Save your answers!");
    	$submit->removeDecorator('DtDdWrapper');
    	$submit->setAttrib ( 'class', "btn btn-success");
    	$submit->setAttrib('data-loading-text', "Loading...");
    	
    	$this->addElement($submit);
    	
    	
    	$this->setDecorators( array( array('ViewScript', array('viewScript' => '_form_quiz.phtml'))));
    }
}