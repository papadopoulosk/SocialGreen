<?php
class Application_Model_FormRegister extends Zend_Form
{
    public function __construct($options=NULL) 
    {
        parent::__construct($options);
        $path = "";
        
        if ($options=="edit")
        {
        	$path="/account/edit/";
        	$label="Save";
        	
        	$this->setName('register');
        	$this->setMethod('post');
        	$this->setAction($path);
        	$this->setAttrib('enctype', 'multipart/form-data');
        	//$this->setAction($this->url(array('controller'=>'account','action'=>'register'), null, true));
        	
        	$username = new Zend_Form_Element_Text('username');
        	$username->setLabel('*Username :');
        	$username->setAttrib('size',35);
        	$username->setAttrib('autofocus',"");
        	$username->setRequired(true);
        	$username->addValidator('alnum');
        	/*$username->addValidator('Db_NoRecordExists', false, array(
        	 'table'     => 'accounts',
        			'field'     => 'username',
        			'exclude'   => array(
        					'field' => 'id')
        	) );*/
        	$username->addErrorMessage("Please use only alphanumeric characters!");
        	//$username->removeDecorator('label');
        	//$username->removeDecorator('htmlTag');
        	
        	
        	$email = new Zend_Form_Element_Text('email');
        	$email->setLabel('*Email :');
        	$email->setAttrib('size',35);
        	$email->setAttrib('type',"email");
        	$email->setRequired(true);
        	$email->addValidator('emailAddress');
        	//$email->addValidator('Db_NoRecordExists');
        	//$email->removeDecorator('label');
        	//$email->removeDecorator('htmlTag');
        	$email->addErrorMessage('Wrong e-mail format');
        	
        	$pswd = new Zend_Form_Element_Password('pswd');
        	$pswd->setLabel('*Password :');
        	$pswd->setAttrib('size',35);
        	$pswd->setRequired(true);
        	//$pswd->removeDecorator('label');
        	//$pswd->removeDecorator('htmlTag');
        	$pswd->addErrorMessage("Password is required");
        	
        	//Retype password
        	$pswd2 = new Zend_Form_Element_Password('pswd2');
        	$pswd2->setLabel('*Re-type password :');
        	$pswd2->setAttrib('size',35);
        	$pswd2->setRequired(true);
        	//$pswd2->removeDecorator('label');
        	//$pswd2->removeDecorator('htmlTag');
        	$pswd2->addErrorMessage("Password re-type is not correct");
        	$pswd2->addValidator('Identical', false, array('token' => 'pswd'));
        	
        	//TYPE OF USER
        	$type = new Zend_Form_Element_Select("type");
        	$type->setLabel("Type of user :");
        	$type->setMultiOptions(array('1'=>'User' ,'2'=>'Organization'));
        	//$type->setAttrib('size',1);
        	
        	//website
        	$website = new Zend_Form_Element_Text('url');
        	$website->setLabel('Website link :');
        	$website->setAttrib('size',100);
        	$website->setRequired(false);
        	//$website->addValidator('hostname');
        	$website->addErrorMessage("Please give a correct hostname!");
        	
        	//facebook
        	$facebook = new Zend_Form_Element_Text('fb');
        	$facebook->setLabel('Facebook link :');
        	$facebook->setAttrib('size',100);
        	$facebook->setRequired(false);
        	//$facebook->addValidator('hostname');
        	$facebook->addErrorMessage("Please give a correct hostname!");
        	
        	//twitter
        	$twitter = new Zend_Form_Element_Text('tw');
        	$twitter->setLabel('Twitter link :');
        	$twitter->setAttrib('size',100);
        	$twitter->setRequired(false);
        	//$twitter->addValidator('hostname');
        	$twitter->addErrorMessage("Please give a correct hostname!");
        	
        	
        	// Add a captcha
        	/*$captcha = new Zend_Form_Element_Captcha("captcha",array(
        			'label'      => 'Are you human?! :',
        			'required'   => false,
        			'captcha'    => array(
        					'captcha' => 'Figlet',
        					'wordLen' => 5,
        					'timeout' => 300
        			),
        			'messages' => array(
        					'badCaptcha' => 'You have entered an invalid value for the captcha'
        			)
        	));*/
        	
        	///$file = new Zend_Form_Element_File('file');
        	//$file->setLabel('File');
        	//$file->setDestination(BASE_PATH . '/public/images/avatars');
        	//$file->setRequired(true);
        	// ensure only 1 file
        	//$file->addValidator('Count', false, 1);
        	// limit to 100K
        	//$file->addValidator('Size', false, 102400);
        	// only JPEG, PNG, and GIFs
        	//$file->addValidator('Extension', false, 'jpg,png,gif');
        	//$file->setValueDisabled(true);
        	
        	$description = new Zend_Form_Element_Textarea('description');
        	$description->setLabel("Bio :");
        	$description->setAttrib('rows',5);
        	$description->setAttrib('cols',20);
        	$description->removeDecorator('label');
        	$description->removeDecorator('htmlTag');
        	
        	$submit = new Zend_Form_Element_Submit('submit');
        	$submit->setLabel($label);
        	$submit->removeDecorator('DtDdWrapper');
        	$submit->setAttrib ( 'class', "btn btn-glor2");
        	
        	$this->setDecorators( array( array('ViewScript', array('viewScript' => '_form_register.phtml'))));
        	
        	$this->addElements(array($username, $email, $pswd, $pswd2, $type,$description, $website, $facebook, $twitter, $submit));
        	//$this->addElements(array($email,$captcha, $submit));
        	
        	$this->setDefaults(array(
        			'type' => 1
        	));
        		
        }
        else
        {
        	$path="/account/register/";
        	$label="Sign up!";
        	
        	$this->setName('register');
        	$this->setMethod('post');
        	$this->setAction($path);
        	$this->setAttrib('enctype', 'multipart/form-data');
        	//$this->setAction($this->url(array('controller'=>'account','action'=>'register'), null, true));
        	
        	$username = new Zend_Form_Element_Text('username');
        	$username->setLabel('*Username :');
        	$username->setAttrib('size',35);
        	$username->setAttrib('autofocus',"");
        	$username->setRequired(true);
        	$username->addValidator('alnum');
        	/*$username->addValidator('Db_NoRecordExists', false, array(
        	 'table'     => 'accounts',
        			'field'     => 'username',
        			'exclude'   => array(
        					'field' => 'id')
        	) );*/
        	$username->addErrorMessage("Please use only alphanumeric characters!");
        	//$username->removeDecorator('label');
        	//$username->removeDecorator('htmlTag');
        	
        	
        	$email = new Zend_Form_Element_Text('email');
        	$email->setLabel('*Email :');
        	$email->setAttrib('size',35);
        	$email->setAttrib('type',"email");
        	$email->setRequired(true);
        	$email->addValidator('emailAddress');
        	//$email->addValidator('Db_NoRecordExists');
        	//$email->removeDecorator('label');
        	//$email->removeDecorator('htmlTag');
        	$email->addErrorMessage('Wrong e-mail format');
        	
        	$pswd = new Zend_Form_Element_Password('pswd');
        	$pswd->setLabel('*Password :');
        	$pswd->setAttrib('size',35);
        	$pswd->setRequired(true);
        	//$pswd->removeDecorator('label');
        	//$pswd->removeDecorator('htmlTag');
        	$pswd->addErrorMessage("Password is required");
        	
        	//Retype password
        	$pswd2 = new Zend_Form_Element_Password('pswd2');
        	$pswd2->setLabel('*Re-type password :');
        	$pswd2->setAttrib('size',35);
        	$pswd2->setRequired(true);
        	//$pswd2->removeDecorator('label');
        	//$pswd2->removeDecorator('htmlTag');
        	$pswd2->addErrorMessage("Password re-type is not correct");
        	$pswd2->addValidator('Identical', false, array('token' => 'pswd'));
        	
        	//TYPE OF USER
        	$type = new Zend_Form_Element_Select("type");
        	$type->setLabel("Type of user :");
        	$type->setMultiOptions(array('1'=>'User' ,'2'=>'Organization'));
        	//$type->setAttrib('size',1);
        	
        	
        	// Add a captcha
        	$captcha = new Zend_Form_Element_Captcha("captcha",array(
        			'label'      => 'Are you human?! :',
        			'required'   => false,
        			'captcha'    => array(
        					'captcha' => 'Figlet',
        					'wordLen' => 5,
        					'timeout' => 300
        			),
        			'messages' => array(
        					'badCaptcha' => 'You have entered an invalid value for the captcha'
        			)
        	));
        	
        	///$file = new Zend_Form_Element_File('file');
        	//$file->setLabel('File');
        	//$file->setDestination(BASE_PATH . '/public/images/avatars');
        	//$file->setRequired(true);
        	// ensure only 1 file
        	//$file->addValidator('Count', false, 1);
        	// limit to 100K
        	//$file->addValidator('Size', false, 102400);
        	// only JPEG, PNG, and GIFs
        	//$file->addValidator('Extension', false, 'jpg,png,gif');
        	//$file->setValueDisabled(true);
        	
        	//$description = new Zend_Form_Element_Textarea('description');
        	//$description->setLabel("Bio :");
        	//$description->setAttrib('rows',5);
        	//$description->setAttrib('cols',20);
        	//$description->removeDecorator('label');
        	//$description->removeDecorator('htmlTag');
        	
        	$submit = new Zend_Form_Element_Submit('submit');
        	$submit->setLabel($label);
        	$submit->removeDecorator('DtDdWrapper');
        	$submit->setAttrib ( 'class', "btn btn-glor2");
        	
        	$this->setDecorators( array( array('ViewScript', array('viewScript' => '_form_register.phtml'))));
        	
        	$this->addElements(array($username, $email, $pswd, $pswd2, $type, $captcha, $submit));
        	//$this->addElements(array($email,$captcha, $submit));
        	
        	$this->setDefaults(array(
        			'type' => 1
        	));
	
        }
        
        
        /* edw
        $this->setName('register');
        $this->setMethod('post');
        $this->setAction($path);
        $this->setAttrib('enctype', 'multipart/form-data');
        //$this->setAction($this->url(array('controller'=>'account','action'=>'register'), null, true));
        
        $username = new Zend_Form_Element_Text('username');
        $username->setLabel('*Username :');
        $username->setAttrib('size',35);
        $username->setRequired(true);
        $username->addValidator('alnum');
        /*$username->addValidator('Db_NoRecordExists', false, array(
        'table'     => 'accounts',
        'field'     => 'username',
        'exclude'   => array(
            'field' => 'id')
        ) );*/
        /*edw
        $username->addErrorMessage("Please use only alphanumeric characters!");
        //$username->removeDecorator('label');
        //$username->removeDecorator('htmlTag');
        
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('*Email :');
        $email->setAttrib('size',35);
        $email->setAttrib('type',"email");
        $email->setRequired(true);
        $email->addValidator('emailAddress');
        //$email->addValidator('Db_NoRecordExists');
        //$email->removeDecorator('label');
        //$email->removeDecorator('htmlTag');
        $email->addErrorMessage('Wrong e-mail format');
        
        $pswd = new Zend_Form_Element_Password('pswd');
        $pswd->setLabel('*Password :');
        $pswd->setAttrib('size',35);
        $pswd->setRequired(true);
        //$pswd->removeDecorator('label');
        //$pswd->removeDecorator('htmlTag');
        $pswd->addErrorMessage("Password is required");
        
        //Retype password
        $pswd2 = new Zend_Form_Element_Password('pswd2');
        $pswd2->setLabel('*Re-type password :');
        $pswd2->setAttrib('size',35);
        $pswd2->setRequired(true);
        //$pswd2->removeDecorator('label');
        //$pswd2->removeDecorator('htmlTag');
        $pswd2->addErrorMessage("Password re-type is not correct");
        $pswd2->addValidator('Identical', false, array('token' => 'pswd'));
        
        //TYPE OF USER
        $type = new Zend_Form_Element_Select("type");
        $type->setLabel("Type of user :");
        $type->setMultiOptions(array('1'=>'User' ,'2'=>'Organization'));
        //$type->setAttrib('size',1);
        
        
        // Add a captcha
        $captcha = new Zend_Form_Element_Captcha("captcha",array(
        		'label'      => 'Are you human?! :',
        		'required'   => false,
        		'captcha'    => array(
        				'captcha' => 'Figlet',
        				'wordLen' => 5,
        				'timeout' => 300
        		),
        		'messages' => array(
        			'badCaptcha' => 'You have entered an invalid value for the captcha'
      			)
        ));
        
       	///$file = new Zend_Form_Element_File('file');
    	//$file->setLabel('File');
    	//$file->setDestination(BASE_PATH . '/public/images/avatars');
    	//$file->setRequired(true);
    	// ensure only 1 file
    	//$file->addValidator('Count', false, 1);
    	// limit to 100K
    	//$file->addValidator('Size', false, 102400);
    	// only JPEG, PNG, and GIFs
    	//$file->addValidator('Extension', false, 'jpg,png,gif');
    	//$file->setValueDisabled(true);
        
        //$description = new Zend_Form_Element_Textarea('description');
        //$description->setLabel("Bio :");
        //$description->setAttrib('rows',5);
        //$description->setAttrib('cols',20);
        //$description->removeDecorator('label');
        //$description->removeDecorator('htmlTag');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel($label);
        $submit->removeDecorator('DtDdWrapper');
        $submit->setAttrib ( 'class', "btn btn-glor2");
        
        $this->setDecorators( array( array('ViewScript', array('viewScript' => '_form_register.phtml'))));
        
        $this->addElements(array($username, $email, $pswd, $pswd2, $type, $captcha, $submit));
        //$this->addElements(array($email,$captcha, $submit));
        
        $this->setDefaults(array(
        		'type' => 1
        ));
        edw */
        
    }
}

