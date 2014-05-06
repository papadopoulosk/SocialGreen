<?php

class Application_Form_RecoverAccount extends Zend_Form
{

    public function init()
    {
        // Set the method for the display form to POST
        $this->setMethod('post');
 		$this->setName("recoveryForm");
        // Add an email element
        $this->addElement('text', 'email', array(
            'label'      => 'Your email address:',
            'required'   => true,
            'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            )
        ));
 
     
        // Add a captcha
        $captcha = new Zend_Form_Element_Captcha("captcha",array(
            'label'      => 'Are you human?!:',
            'required'   => true,
            'captcha'    => array(
                'captcha' => 'Figlet',
                'wordLen' => 5,
                'timeout' => 300
            )
        ));
        //$captcha->addErrorMessage("Captcha word is not correct!");
        
        //$captcha->removeDecorator('label');
        //$captcha->removeDecorator('htmlTag');
        $this->addElement($captcha);
/*        $this->addElement('captcha', 'captcha', array(
            'label'      => 'Please enter the 5 letters displayed below:',
            'required'   => true,
            'captcha'    => array(
                'captcha' => 'Figlet',
                'wordLen' => 5,
                'timeout' => 300
            )
        ));
 */
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Recover now!',
        		'class'=>'btn btn-warning'
        ));
 
        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }


}

