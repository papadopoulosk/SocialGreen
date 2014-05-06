<?php

class AboutController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function binAction()
    {
        // action body
    }

    public function ourteamAction()
    {
        // action body
    	$title = "The Team";
    	$this->view->title = $title;
    	
        $ntempos = array(
        		"Dimitrios Ntempos", 
        		"CEO,<br> Co-founder", 
        		"ntempos.jpg", 
        		'Dimitrios has studied economy and the computer science at Aristotle university of thessaloniki. His working experience contains positions at public and the private sector. he strongly believes that starting up is the absolute next step after education.',
        		"http://gr.linkedin.com/pub/dimitrios-ntempos/33/407/4b1/",
        		"aboutme",
        		"http://about.me/di.ntempos");
        
        $kuze = array(
        		"Evangelos Almpanidis",
        		"Electronic Engineer,<br> Co-Founder",
        		"vaggel.jpg", 
        		"Born in Thessaloniki, vangelis deals with the hardware component of Social-Green. He has worked as an embeded system developer as well as academic assistante in A.T.E.I (digital labs I&II) lab. He is a paok fc fun and former graffiti artist.",
        		'http://gr.linkedin.com/pub/almpanidis-evangelos/5a/43b/194/',
        		"aboutme",
        		'http://about.me/evangelos.almpanidis');
        
        $konos = array(
        		"Konstantinos Papadopoulos",
        		"CTO,<br> Co-founder",
        		"esu.jpg",
        		"Konstantinos works as a jr. IT Auditor while the same time leads the technical part of Social-Green. At his free time he enjoys Web & iOS and studing about Information Security. He Holds an MSc degree in ICT Systems.",
        		'http://www.linkedin.com/in/papadopoulosk',
        		'aboutme',
        		'http://about.me/papadopoulospk');
        
        $laps = array(
        		"George Lapatas",
        		"Web <br>Developer",
        		"giwrgos.jpg",
        		"Born in thessaloniki, george is about to graduate from the dept computer science and technology, university of Peloponnese. At social-green he delivers cut-edge code and clear cut user interfaces . He loves travelling and swimming.",
        		'http://gr.linkedin.com/pub/giorgos-lapatas/3b/621/324/',
        		'aboutme',
        		'http://about.me/glapatas');
		
		$antonis = array(
				"Antonis Karanaftis",
				"Designer <br> & Artist",
				"antw.jpg",
				"He is the Art Director of Social Green where he handles every design related issue. His working experience contains printing and graphic design positions. In his free time, Antonis enjoys photo shooting and animation.",
				'http://gr.linkedin.com/pub/antonis-karanaftis/65/3a1/19b',
				'aboutme',
				'http://about.me/antonis.k');
		
		$andreas = array(
				"Andreas Monastiriotis",
				"Automation <br>Engineer",
				"adre.jpg",
				"",
				'http://gr.linkedin.com/pub/andreas-monastiriotis/6b/354/390',
				'aboutme',
				'http://about.me/andreas.monastiriotis');
		
		$eva = array(
				"Eva Kavaliotou",
				"Community<br> Manager",
				"eva.jpg",
				'Eva Kavaliotou Community Manager at Social Green. Her academic background is on Business Administration and Information Systems. Currently she is studying Management Science and Technology at Athens University of Economics and Business and emphasizes her studies on e-Commerce and how Digital marketing and Conversion Rate Optimization can boost online businesses. Gamification is also on her interests. Given the fact that she is still an undergraduate student, her only working experience is as a Conversion Rate Optimization Trainee at her University’s Research Center(ELTRUN) and as an e-Business Intern at "Be eBusiness".',
				"http://gr.linkedin.com/pub/eva-kavaliotou/53/646/81a",
				"aboutme",
				"http://about.me/eva_kavaliotou");
		
		$vivian = array(
				"Vivian Paraschou",
				"Marketing <br>Intern",
				"vivi.jpg",
				'',
				"http://gr.linkedin.com/pub/vivian-paraschou/58/730/4a",
				"aboutme",
				"http://about.me/vi.paraschou");
        
        $team = array($ntempos,$kuze,$laps,$vivian,$antonis,$andreas);
        //var_dump($team);
        $this->view->team = $team;
    }

    public function contactAction()
    {
    	/*
        //Function to submit form and send mail
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper("layout")->disableLayout();
    	
        $f = new Application_Form_ContactForm();
        $flag = $f->isValid($this->_getAllParams());
        $json = $f->getMessages();
        if ($flag)
        {
        	//echo '<div class="alert alert-success">Your message has been sent! We will get back to you!</div>';
        	
        	$smtpServer = 'mail.sociallgreen.com';
        	$username = XXXXXXXXXXXX.com';
        	$password = 'XXXXXXXXXXXXXX';
        	
        	$config = array(
        			'auth' => 'login',
        			'username' => $username,
        			'password' => $password);
        	
        	$transport = new Zend_Mail_Transport_Smtp($smtpServer, $config);
        	
        	$htmlMail = $f->getValue('description');
        
        	$mail = new Zend_Mail();
        	$mail->setBodyText($htmlMail)
        	->setFrom($f->getValue('email'), $f->getValue('name'))
        	->addTo("info@sociallgreen.com") 
        	->setSubject('User Mail sent on '.date("F j, Y, g:i a").'!')
        	->send($transport);
        	
        	$flashMessenger = $this->_helper->getHelper('FlashMessenger');
        	$flashMessenger->addMessage("Thank you for your message!<br>We will get back to you soon!");
        	$this->_helper->redirector("index", 'index');
        	
        }
        else
        {
        	//echo '<div class="alert alert-error">'.Zend_Json::encode($json).'</div>'; 
        $arrMessages = $json;
        //$output = Zend_Json::encode($json);
		$output="<ol>";
		foreach($json as $field => $arrErrors) {
		    $output.= "<li>".$json[$field][0]."</li>";
		}
		$output.="</ol>";
        	echo '<div class="alert alert-error">'.$output.'</div>';
        }
        
        */
    	$form = new Application_Form_ContactForm();
    	
    	 
    	if ($this->getRequest()->isPost())
    	{
    		if ($form->isValid($this->_request->getPost()))
    		{
    			$smtpServer = 'mail.sociallgreen.com';
    			$username = 'XXXXXXXXXXXXXX.com';
    			$password = 'XXXXXXXXXXXXXXXX';
    			 
    			$config = array(
    					'auth' => 'login',
    					'username' => $username,
    					'password' => $password);
    			 
    			$transport = new Zend_Mail_Transport_Smtp($smtpServer, $config);
    			 
    			$htmlMail = 'type :'.$this->type($form->getValue('category')).'\n'.$form->getValue('description');
    			
    			$mail = new Zend_Mail();
    			$mail->setBodyText($htmlMail)
    			->setFrom($form->getValue('email'), $form->getValue('name'))
    			->addTo("info@sociallgreen.com")
    			->setSubject('User Mail sent on '.date("F j, Y, g:i a").'!')
    			->send($transport);
    			 
    			$flashMessenger = $this->_helper->getHelper('FlashMessenger');
    			$flashMessenger->addMessage("Thank you for your message!<br>We will get back to you soon!");
    			$this->_helper->redirector("index", 'index');
    		
    		}
    		else
    		{
    			$this->view->errors = $form->getErrors();
    		}
    	}
    }
    
    public function type($type)
    {	
    	if($type == 1)
    	{
    		return 'Organization';
    	}
    	if(type == 2 )
    	{
    		return 'Company';
    	}
    	if(type == 3 )
    	{
    		return 'Individual';
    	}
    	if(type == 4 )
    	{
    		return 'Other';
    	}
    }

    public function teamAction()
    {
        // action body
    }

    public function howItWorksAction()
    {
    	$title = "How it works?";
    	$this->view->title = $title;
        // action body
        $information = array(
        		array("id"=>"firstStep", "id2"=>"firstStep", "linktitle"=>"1st Collect", "image"=>"pickup.png", "text"=>"Search your place for cans, glass and plastic bottles..."),
        		array("id"=>"secondStep", "id2"=>"secondStep", "linktitle"=>"2nd Dispose", "image"=>"throw.png", "text"=>"Go to the nearest bin, wake him up and throw. He will count for you..."),
        		array("id"=>"thirdStep", "id2"=>"thirdStep", "linktitle"=>"3rd Scan", "image"=>"qrscan.png", "text"=>"Use the social green app to scan the QR code which contains your score..."),
        		array("id"=>"fourthStep", "id2"=>"fourthStep", "linktitle"=>"4th Play", "image"=>"sync.png", "text"=>"Go to sociallgreen.com find your friends, form teams, see the leaderboards."),
        		array("id"=>"fifthStep", "id2"=>"fifthStep", "linktitle"=>"5th Win", "image"=>"yioupi.png", "text"=>"Be local or global recycling leader and get the physical presents.")
        		);
        
        $this->view->information = $information;
    }

    public function getInvolvedAction()
    {
        // action body
    	$title = "Get Involved";
    	$this->view->title = $title;
    }

    public function quizAction()
    {
        // action body
        $this->view->title = "Quiz";
        
        $quizModel = new Application_Model_Quiz();
        $questions = $quizModel->getQuestions();
        $validAnswers = $quizModel->getValidAnswers();
        
        //$this->view->questions = $questions;
        //$this->view->validAnswers = $validAnswers;
        
        //$this->view->qa = $quizModel->getQsAs();
        $this->view->quizForm = $quizModel->getQuizForm();
    }

    public function submitQuizAction()
    {
        // action body
    	$this->_helper->viewRenderer->setNoRender();
    	$this->_helper->layout->disableLayout();
    	$form = new Application_Form_QuizForm();
    	
    	$form->isValid($this->_getAllParams());
    	
    	if ($form==true){
    		//$json = $form->processAjax($this->getRequest()->getPost());
    		//header('Content-type: application/json');
    		$Quiz = new Application_Model_Quiz();
    		$answers = $this->_getAllParams();
    		try {
    			$Quiz->saveAnswers($answers);
    			echo 1;
    		} catch (Exception $e) {
    			echo 0;
    		}
    		
    	}

    }

    public function termsAction()
    {
        // action body
        $tabTerms = array(
        		"tabtitle"=>"Terms of Use",
        		'id'=>"tab1",
        		"title"=>"Social Green Terms of Use",
        		"subTitle1"=>"Basic Terms",
        		"subTitle2"=>"General Conditions",
        		"text1"=>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
        		"text2"=>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
			);
        $tabPrivacy = array(
        		"tabtitle"=>"Privacy Policy",
        		'id'=>"tab2",
        		"title"=>"Social Green Privacy Policy",
        		"subTitle1"=>"Mpla mpla 1",
        		"subTitle2"=>"Mpla mpla 2",
        		"text1"=>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.",
        		"text2"=>"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
			);
        $content = array ("terms"=>$tabTerms, "privacy"=>$tabPrivacy);
        $this->view->content = $content;
    }


}



















