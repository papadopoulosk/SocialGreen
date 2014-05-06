<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$title = "Welcome";
    	$this->view->title = $title;
    	
    	//Retrieve All user accounts
    	$accounts = new Application_Model_DbTable_Accounts();
    	$query = $accounts->select();
    	$query->from(array('act' => 'activity'), array('SUM(act.quantity) as quantity','SUM(act.plastic) as plastic','SUM(act.glass) as glass','SUM(act.aluminium) as aluminium', '(SUM(act.glass)*1+SUM(act.plastic)*2+SUM(act.aluminium)*3) as leafs','userid','MAX(act.date) as date'));
    	//$query->from(array('acc' => 'accounts'), array('acc.id','acc.fullname','acc.username','acc.avatar','acc.description', 'acc.url','acc.typeid'));
    	$query->join(array('acc' => 'accounts'), 'act.userid = acc.id', array('acc.fullname','acc.username','acc.avatar','acc.description', 'acc.url','acc.typeId'));
    	//$query->where("(acc.typeid = 1 OR acc.typeid = 3)");
    	$query->group("acc.username");
    	$query->order('leafs DESC');
    	
    	$query->limit(3,0);
    	$query->setIntegrityCheck(false);
    	//echo (String)$query;
    	$this->view->accounts = $accounts->fetchAll($query);
    	$this->view->imgPrefix = "/images/avatars/";
    	
    	/*so i can call the functions imagesfb and thumbimagesfb from the view*/
    	$this->view->controller = $this;
    	
    }

    public function indexAction()
    {
        // action body
    	$form = new Application_Model_FormLogin();
    	$this->view->loginform = $form;

    	//$form2 = new Application_Model_FormRegister();
    	//$this->view->registerForm = $form2;
    	
    	$activity = new Application_Model_DbTable_Activity();
    	//$this->view->results = $activity->fetchAll();
    	
    	$query = $activity->select();
    	$query->from(array('acc' => 'accounts'), array('id', 'username','avatar', 'fullname'));
    	$query->join(array('act' => 'activity'), 'act.userid = acc.id', array('quantity','date', 'aluminium','glass','plastic'));
    	$query->order('act.date DESC');
    	$query->limit(3,0);
    	$query->setIntegrityCheck(false);
    	
    	$result = $activity->fetchAll($query);
    	$page = $this->_getParam('page',1);
    	$paginator = Zend_Paginator::factory($result);
    	$paginator->setItemCountPerPage(10);
    	$paginator->setCurrentPageNumber($page);
    	
    	//$this->view->paginator=$paginator;
    	$this->view->results = $paginator;
    	
    	$Ladder = new Application_Model_DailyLadder();
    	$this->view->activity = $Ladder->getGraph();
    	$this->view->usernames = $Ladder->getUsernames();
    	$this->view->dates = $Ladder->getDates();
    	
    	$query = $activity->select();
    	$query->from($activity);
    	$this->view->allActivity = $activity->fetchAll($query);
    	
    	/*Tweets*/
    	/*$tweetDB = new Application_Model_DbTable_Tweets();
    	$select = $tweetDB->select();
    	$select->from($tweetDB);
	 	$tweetsResults = $tweetDB->fetchAll($select);
	 	$tempTweets = array();
	 	foreach ($tweetsResults as $tweet){
	 		$tempTweets[] = $tweet['tweet'];
	 	}
	 	shuffle($tempTweets);
	 	$this->view->tweet = $tempTweets[0];*/
    	
	 	$this->view->messages = $this->_helper->flashMessenger->getMessages();
	 	$form = new Application_Form_ContactForm();
	 	$this->view->contactForm = $form;
	 	
	 	
	 			
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
	 	        
	 	        $this->view->team = $team;
	 	
	 	
	 	
	 	
	 	
    }

    public function submitContactFormAction()
    {
        $this->_helper->viewRenderer->setNoRender();
	    $this->_helper->layout->disableLayout();
	    $form = new Application_Form_QuizForm();
	    	
	    $form->isValidPartial($this->_getAllParams());
	    $json = $form->processAjax($this->getRequest()->getPost());
	    //header('Content-type: application/json');
	    echo var_dump($this->_getAllParams());
    }

    public function submitContactAction()
    {
        //Action that just displays the Contact form.. this is used to display form in each page..
    	$contactForm = new Application_Form_ContactForm();
    	$this->view->contactForm = $contactForm;
    }
    
    public function imagesfb($avatar,$base)
    {
    	$imgPrefix = "/images/avatars/";
    	$fb = strpos($avatar, "face");
    		
    	if($fb === false)
    	{
    		return $base.$imgPrefix.$avatar;
    			
    	}
    	else
    	{
    		return $avatar;
    	}
    }
    public function thumbimagesfb($avatar,$base)
    {
    	$imgPrefix = "/images/avatars/";
    	$fb = strpos($avatar, "face");
    		
    	if($fb === false)
    	{
    		return $base.$imgPrefix."thumb-".$avatar;
    
    	}
    	else
    	{
    		return $avatar;
    	}
    }
    
}







