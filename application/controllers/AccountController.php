<?php

class AccountController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    	$title = "Game";
    	$this->view->title = $title;
    	if ($this->_helper->FlashMessenger->hasMessages()) {
    		$this->view->messages = $this->_helper->FlashMessenger->getMessages();
    	}
    	//Retrieve All user accounts
    	$accounts = new Application_Model_DbTable_Accounts();
    	$query = $accounts->select();
    	$query->from(array('act' => 'activity'), array('SUM(act.quantity) as quantity','SUM(act.plastic) as plastic','SUM(act.glass) as glass','SUM(act.aluminium) as aluminium', '(SUM(act.glass)*1+SUM(act.plastic)*2+SUM(act.aluminium)*3) as leafs','userid','MAX(act.date) as date'));
    	$query->join(array('acc' => 'accounts'), 'act.userid = acc.id', array('fullname','username','avatar','description', 'url','fb','tw'));
    	$query->group(array("username"));
    	$query->order('leafs Desc');
    	
    	$query->setIntegrityCheck(false);
    	//echo (String)$query;
    	$this->view->accounts = $accounts->fetchAll($query);
    	$this->view->imgPrefix = "/images/avatars/";
    	
    	$activity = new Application_Model_DbTable_Activity();
    	
    	$query2 = $activity->select();
    	$query2->from($activity);
    	$this->view->allActivity = $activity->fetchAll($query);
    	
    	/*so i can call the functions imagesfb and thumbimagesfb from the view*/
    	$this->view->controller = $this;
    }

    public function indexAction()
    {
        // action body
        //$accounts = new Application_Model_DbTable_Accounts();
        //$order = $accounts->select()->order("points DESC");
        //$this->view->accounts = $accounts->fetchAll($order);
        
       
        $activity = new Application_Model_DbTable_Activity();
        //$this->view->results = $activity->fetchAll();
        
        $query = $activity->select();
        $query->from(array('acc' => 'accounts'), array('id', 'username','avatar', 'fullname'));
        $query->join(array('act' => 'activity'), 'act.userid = acc.id', array('quantity','date', 'aluminium','glass','plastic'));
        $query->order('act.date DESC');
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
        
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
        
    }

    public function registerAction()
    {
    	$title = "User Registration";
    	$this->view->title = $title;
    	
		$form = new Application_Model_FormRegister();
		
		$elements = $form->getElements();
		foreach($elements as $element) {
			$element->removeDecorator('Errors');
		}
       
        if ($this->getRequest()->isPost())
        { 	
			if ($form->isValid($this->_request->getPost()))
			{
				$account = new Application_Model_DbTable_Accounts();
				$salt = substr(md5(rand()), 0, 32);
				$hashedPass = sha1($form->getValue('pswd').$salt);
				
				$token = uniqid();
				$data = array(
                         'email'=>$form->getValue('email'),
                         //'description'=>$form->getValue('description'),
                         'username'=>$form->getValue('username'),
						'fullname'=>$form->getValue('username'),
                         'password'=>$form->getValue('pswd'),
                         'created'=>date('Y-m-d H:i:s'),
                         'updated'=>date('Y-m-d H:i:s'),
						 'recovery'=>$token,
  						 'password'=>$hashedPass,
						'typeid'=>$form->getValue('type'),
						 'salt'=> $salt
                         );
				
				TRY {
					$userid = $account->insert($data);
					//$this->_helper->flashMessenger->addMessage("You have successfully registered at Social Green Project!");
					//$this->_helper->redirector("index", 'index');
					//$this->_helper->redirector("index","index",array("register"));// _redirector->gotoUrl('/my-controller/my-action/param1/test/param2/test2');
					
					$smtpServer = 'mail.sociallgreen.com';
					$username = 'XXXXXXXXXX.com';
					$password = 'XXXXXXXXXX';
					 
					$config = array(
							'auth' => 'login',
							'username' => $username,
							'password' => $password);
					 
					$transport = new Zend_Mail_Transport_Smtp($smtpServer, $config);
					
					$htmlMail = "<!DOCTYPE html>
						<html>
						<head>
						<meta charset='UTF-8'>
						<title></title>
							<style>
							body
							{
							max-width:600px;
							}
							* {
								font-family:Georgia;
								color: #911762;
							}
							</style>	
						</head>
						<body>
						<img style='max-width:400px' src='http://sociallgreen.com/images/socialllogo600.png'>
						<h1>Welcome at Sociallgreen community!</h1>
						<p>This is a confirmation mail for registering at our community. <br>
							Click the following link to confirm your registration.</p>".
				"<a href='http://sociallgreen.com/account/confirm/token/".$token."/usr/".$form->getValue('username')."'>http://sociallgreen.com/account/confirm/token/".$token."/usr/".$form->getValue('username')."</a>".
				//"<a href=http://sociallgreen.com/account/confirm/token/".$token."'>http://sociallgreen.com/account/confirm/token/".$token."</a>
						"</body>
						</html>";
					
					$mail = new Zend_Mail();
					$mail->setBodyHtml($htmlMail)->setFrom('no-reply@sociallgreen.com', 'Sociallgreen Team')->addTo($form->getValue('email'))->setSubject('Confirmation Mail')->send($transport);
					
					/* vazoume sto kainourgio user mideniko activity gia na fenete stous pinakes */ 
					$data2 = array(
							'userid'=>$userid,
							'quantity'=>'0',
							'date'=>date('Y-m-d H:i:s'),
							'aluminium'=>'0',
							'glass'=>'0',
							'paper'=>'0',
							'plastic'=>'0'
					);
					
					$activity = new Application_Model_DbTable_Activity();
					$activity->insert($data2);
					
					
					//$this->_helper->_redirector("index", 'index', array("register","true"));
					$flashMessenger = $this->_helper->getHelper('FlashMessenger');
					$flashMessenger->addMessage("You have successfully registered to our community!<br>A confirmation mail was sent to the address provided!");
					//$this->_helper->flashMessenger("You have successfully registered to our community! A confirmation mail was sent to the address provided!");
					$this->_helper->redirector("index", 'index');
//					$this->_helper->_redirector('index','index',null,array('register'=>'true'));
                }
                catch (Zend_Db_Exception $e) {
					//echo $e->getMessage();	
					$this->view->errors = array( array("Your are already registered"));
                }
			}
            else
            {
				$this->view->errors = $form->getErrors();
            }
        }
        $this->view->title = "New registration";
        $this->view->form = $form;        
    }

    public function profileAction()
    {
    	
    	// action body
    	$user = $this->_getParam('user'); 
        
        $this->view->title = $user;//->append($user);
        //        $accounts = new Application_Model_DbTable_Accounts();
        //        $order = $accounts->select()->order("points DESC");
        //       $order->where("username = ?", $user);
        $this->view->activeAccount = $user;// $accounts->fetchAll($order);
        $this->view->badgesPrefix = "/images/badges/";
		
        
        /*Retrieve All user's badges*/
        $userbadges = new Application_Model_DbTable_Accounts();
        $query = $userbadges->select('bad.id','bad.title','bad.path','bad.class');
        $query->from(array('acc' => 'accounts'),array('id','username'));
        $query->from(array('usb' => 'user_badges'),array('badge_id','user_id'));
        $query->from(array('bad' => 'badges'),array('id','title','path', 'class'));
        $query->where('acc.id = usb.user_id AND acc.username = "'.$user.'" AND usb.badge_id = bad.id');
        //$query->join(array('usb' => 'user_badges'), 'acc.id = usb.user_id AND acc.username = "'.$user.'"', array('badge_id','user_id'));
        //$query->join(array('bad' => 'badges'), 'usb.badge_id = bad.id', array('id','title','path', 'class'));
        $query->group(array("bad.id"));
        
        $query->setIntegrityCheck(false);
        $this->view->userbadges = $userbadges->fetchAll($query);
        
        /*Retrieve All badges*/
        $badges = new Application_Model_DbTable_Badges();
        $query2 = $badges->select();
        $query2->from(array('bad' => 'badges'), array('id','title','description','path','class'));
        $query2->order('id');
        $query2->setIntegrityCheck(false);
         
        $this->view->badges = $badges->fetchAll($query2);
        
        
        /*Retrieve ALL user's Activity*/
        $useractivity = new Application_Model_DbTable_Accounts();
        $query3 = $useractivity->select();
        $query3->from(array('acc' => 'accounts'), array('id', 'username','avatar', 'fullname'));
        $query3->from(array('act' => 'activity'),array('quantity','date', 'aluminium','glass','plastic'));
        $query3->where('acc.username = "'.$user.'" AND act.userid = acc.id');
        
        $query3->order('act.date DESC');
        $query3->setIntegrityCheck(false);
        
        $result2 = $useractivity->fetchAll($query3);
        
        $page2 = $this->_getParam('page',1);
        $paginator2 = Zend_Paginator::factory($result2);
        $paginator2->setItemCountPerPage(5);
        $paginator2->setCurrentPageNumber($page2);
        
        //$this->view->paginator=$paginator;
        $this->view->results2 = $paginator2; 
        
        /*Retrieve LATEST user's Activity */
        $Ladder = new Application_Model_DailyLadder();
        $this->view->activity = $Ladder->getGraph();
        $this->view->usernames = $Ladder->getUsernames();
        $this->view->dates = $Ladder->getDates();
        
    }

    public function editAction()
    {
        // action body
    	$auth = Zend_Auth::getInstance();
    	if ($auth->hasIdentity())
    	{
    		$username = $auth->getIdentity()->username;
    		$userId = $auth->getStorage()->read()->id;
    		
    		
    		$accounts = new Application_Model_DbTable_Accounts();
    		$select = $accounts->select();
    		$select->from($accounts)->where('id = ?', $userId);
    		
    		$userAccount = $accounts->fetchAll($select);
    		
    		//$form = new Application_Form_UploadAvatar();
    		$form = new Application_Model_FormRegister("edit");
    		
    		$elements = $form->getElements();
    		foreach($elements as $element) {
    			$element->removeDecorator('Errors');
    		}
    		
    		$form->populate($userAccount->current()->toArray());
    		
    		$this->view->form = $form;
    		
    		
    		if ($this->getRequest()->isPost())
    		{
    			$formData = $this->_request->getPost();
    			if ($form->isValid($formData)) 
    			{
    				//FILE renamed to username
    				//$originalFilename = pathinfo($form->file->getFileName());
    				//Zend_Debug::dump($originalFilename);
    				//$newName = $username. $userId . "." . $originalFilename['extension'];
    				//$form->file->addFilter('Rename', $newName);
    				//$data = $form->getValues();
    				
    				// success - do something with the uploaded file
    				//$uploadedData = $form->getValues();
    				//$fullFilePath = $form->file->getFileName();
    				
    				//Zend_Debug::dump($uploadedData, '$uploadedData');
    				//Zend_Debug::dump($fullFilePath, '$fullFilePath');
    				
    				//Database update
    				$account = new Application_Model_DbTable_Accounts();
    				$salt = substr(md5(rand()), 0, 32);
    				$hashedPass = sha1($form->getValue('pswd').$salt);
    				$data2 = array(
    						'email'=>$form->getValue('email'),
    						'description'=>$form->getValue('description'),
    						'username'=>$form->getValue('username'),
    						'password'=>$hashedPass,
    						'salt'=> $salt,
    						//'created'=>date('Y-m-d H:i:s'),
    						'updated'=>date('Y-m-d H:i:s'),
    						'url'=> $form->getValue('url'),
    						'fb'=> $form->getValue('fb'),
    						'tw'=> $form->getValue('tw'),
    						//'avatar' => "/images/avatars/".$uploadedData['file']
    				);
    				
    				$where = array('id = ?' => $userId);
    				
    				TRY {
    					$account->update( $data2, $where);
    					$this->_helper->flashMessenger->addMessage("You have successfully updated your profile!");
    					$this->_helper->redirector("index", 'account');
    				} catch (Zend_Db_Exception $e) {
    					echo $e->getMessage();
    				}
    				
    			}
    			else
    			{
    				$this->view->errors = $form->getErrors();
    				//$form->populate($formData);
    			}
    		}
    		
    		
    		
    		
    		/* prin
    		$form = new Application_Model_FormRegister("edit");
    		
    		$elements = $form->getElements();
    		foreach($elements as $element) {
    			$element->removeDecorator('Errors');
    		}
    		
    		$form->populate($userAccount->current()->toArray());
    		
    		$this->view->form = $form;
    		
    		
    		if ($this->getRequest()->isPost()) {
    			
    			if ($form->isValid($this->_request->getPost()))
    			{
    				$account = new Application_Model_DbTable_Accounts();
    				$salt = substr(md5(rand()), 0, 32);  
    				$hashedPass = sha1($form->getValue('pswd').$salt);
    				$data2 = array(
    						'email'=>$form->getValue('email'),
    						'description'=>$form->getValue('description'),
    						'username'=>$form->getValue('username'),
    						'password'=>$hashedPass,
    						'salt'=> $salt,
    						'created'=>date('Y-m-d H:i:s'),
    						'updated'=>date('Y-m-d H:i:s')
    				);
    				
    				$where = array('id = ?' => $userId); 
    		
    				TRY {
    					$account->update( $data2, $where);
    					$this->_helper->flashMessenger->addMessage("You have successfully updated your profile!");
    					$this->_helper->redirector("index", 'account');
    				} catch (Zend_Db_Exception $e) {
    					echo $e->getMessage();
    				}
    			}else {
    				
    				$this->view->errors = $form->getErrors();
    			}
    		
    		}*/
    	}
    }

    public function deleteAction()
    {
        // action body
    	$auth = Zend_Auth::getInstance();
    	if ($auth->hasIdentity()) {
    		$username = $auth->getIdentity()->username;
    		$accounts = new Application_Model_DbTable_Accounts();
    		//$accounts->delete("username = ?", $username);
    		$where = $accounts->getAdapter()->quoteInto("username = ?", $username);
    		$accounts->delete($where);
    		$auth->clearIdentity();
    		$this->_redirect('/');
    	} else {
    		$this->_redirect('/');
    	}
    }

    public function confirmAction()
    {
        // action body
    	$token = $this->_getParam('token');
    	$user = $this->_getParam('usr');
    	
    	$userDB = new Application_Model_DbTable_Accounts();
    	$select = $userDB->select();
		$select->from($userDB)->where('recovery = ?', $token);//->where('username = ?', $user);
		$accountRowset = $userDB->fetchRow($select);
		if (count($accountRowset) > 0)
		{
			$this->view->user = $user;			
			$data = array(
					'recovery'=>'',
					'confirmed'=>1
			);
			$where = array('id = ?' => $accountRowset->id);
			$userDB->update( $data, $where);
		}
		else
		{
			$this->_helper->redirector("index","index");
		}
    }

    public function resetAction()
    {
        // action body
    	$token = $this->_getParam('token');
    	$now = date("Y-m-d H:i:s");
    	//$user = $this->_getParam('check');
    	$queue = new Application_Model_DbTable_RecoveryQueue();
    	$select = $queue->select();
    	$select->where("token = ?", $token)->where("validUntil > ?", $now);
    	$rowset = $queue->fetchRow($select);
    	if (count($rowset) > 0) {
    		echo "Token is valid.. We may or may not reset your password..!";
    		$where = $queue->getAdapter()->quoteInto('token = ?', $token);
 			$queue->delete($where);
    	}
    }

    public function badgesAction()
    {
    	$title = "Badges";
    	$this->view->title = $title;
        // action body
    	//Retrieve All badges
    	$badges = new Application_Model_DbTable_Badges();
    	$query2 = $badges->select();
    	$query2->from(array('bad' => 'badges'), array('id','title','description','path','class'));
    	$query2->order('id');
    	$query2->setIntegrityCheck(false);
    	
    	$this->view->badges = $badges->fetchAll($query2);
    	$this->view->badgesPrefix = "/images/badges/";
    	
    }
	
	public function imagesfb($avatar,$base)
	{
		$imgPrefix = "/images/avatars/";
		$fb = strpos($avatar, "facebook");
		 
		if($fb === false)
		{
			return $base.$imgPrefix.$avatar;
			
		}
		else
		{
			return $avatar."/picture?type=large";
		}
	}
	public function thumbimagesfb($avatar,$base)
	{
		$imgPrefix = "/images/avatars/";
		$fb = strpos($avatar, "facebook");
			
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















