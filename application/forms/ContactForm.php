<?php

class Application_Form_ContactForm extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setMethod('post');
    	//$this->setName("recoveryForm");
    	//$this->setAction($path);
    	
    	$name = new Zend_Form_Element_Text("name");
    	$name->setAttrib ('placeholder', "name");
    	$name->setAttrib ('class', "input-block-level");
    	$name->setAttrib('size',35);
    	$name->setRequired(true);
    	$name->setAttrib("required", true);
    	$name->addValidator('alnum');
    	$name->addErrorMessage("Are you sure about your name?");
    	$name->removeDecorator('label');
    	$name->removeDecorator('htmlTag');
    	
    	$email = new Zend_Form_Element_Text('email');
    	$email->setAttrib("placeholder", "e-mail");
    	$email->setAttrib ('class', "input-block-level");
    	$email->setAttrib('size',35);
    	$email->setRequired(true);
    	$email->setAttrib("required", true);
    	$email->addValidator('emailAddress');
    	$email->removeDecorator('label');
    	$email->removeDecorator('htmlTag');
    	$email->addErrorMessage('Something is wrong with your mail!');
    	
    	$category = new Zend_Form_Element_Select('category', array(
			       "label" => "Currency",
			       "required" => true,
			    ));
    	$category->addMultiOptions(array(
	        1 => "Organization",
	        2 => "Company",
    			3 => "Individual",
    			4 => "Other"
	    ));
		$category->removeDecorator("label");
    	$category->removeDecorator("htmlTag");
    	
    	// Add a captcha
    	$captcha = new Zend_Form_Element_Captcha("captcha",array(
    			/*'label'      => 'Are you human?!:',*/
    			'required'   => true,
    			'captcha'    => array(
    					'captcha' => 'Figlet',
    					'wordLen' => 5,
    					'timeout' => 300
    			),
    			'messages' => array(
    					'badCaptcha' => 'You have entered an invalid value for the captcha'
    			)
    	));
    	$captcha->setAttrib ( 'class', "input-block-level");
    	$captcha->removeDecorator('htmlTag');
    	
    	$description = new Zend_Form_Element_Textarea('description');
    	$description->setAttrib("placeholder", "subject");
    	$description->removeDecorator('label');
    	$description->removeDecorator('htmlTag');
    	$description->setAttrib ( 'class', "input-block-level");
    	$description->setAttrib('rows', '4');
    	$description->setAttrib('cols', '10');
    	$description->setAttrib("required", true);
    	$description->setRequired(true);
    	$description->addErrorMessage("Why don't you tell us what it is about?");
    	
    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel("Send!");
    	$submit->removeDecorator('DtDdWrapper');
    	$submit->setAttrib ( 'class', "btn btn-glor2");
    	//$submit->setAttrib("data-loading-text","Sending...");
    	
    	$this->setDecorators( array( array('ViewScript', array('viewScript' => '_form_contact.phtml'))));
    	//$this->addElements(array($name, $email, $captcha, $description, $submit));
    	$this->addElements(array($name, $email,$category, $description, $submit));
    }


}

