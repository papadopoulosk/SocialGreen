<?php

class Application_Model_FormLogin extends Zend_Form
{
	public function init()
    {
        $this->setName("login");
        
        $this->setMethod('post');
        $this->addElement('text', 'username', array(
        		 'class' => 'input-medium',
            'filters'    => array('StringTrim', 'StringToLower'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => 'Username:'
        ));
        $this->addElement('password', 'password', array(
        		'class' => 'input-medium',
            'filters'    => array('StringTrim'),
            'validators' => array(
                array('StringLength', false, array(0, 50)),
            ),
            'required'   => true,
            'label'      => 'Password:'
        ));
        $this->addElement('submit', 'login', array(
            'required' => false,
            'ignore'   => true,
            'label'    => 'Login',
        	'class'=> 'btn btn-glor2'
        ));
		
        // Add a captcha
        /*$this->addElement('captcha', 'captcha', array(
        		'label'      => 'Please enter the 5 letters displayed below:',
        		'required'   => true,
        		'captcha'    => array(
        				'captcha' => 'Figlet',
        				'wordLen' => 5,
        				'timeout' => 300
        		)
        ));*/
        
        
        $elements = $this->getElements();
        foreach($elements as $element) {
        	$element->removeDecorator('Errors');
        }
        
        $this->getElement('username')->addErrorMessage('Username is empty!');
        $this->getElement('password')->addErrorMessage('Give a password!');
        $this->setDecorators( array( array('ViewScript', array('viewScript' => '_form_login.phtml'))));
    }

}

