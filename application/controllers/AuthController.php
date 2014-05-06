<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$title = "Login";
    	$this->view->title = $title;
    	
    }

    public function indexAction()
    {
    	// action body
    	if(Zend_Auth::getInstance()->hasIdentity())
    	{
    		$this->_helper->redirector('index', 'account');
    	}
        
    	$form = new Application_Model_FormLogin();
    	
    	$request = $this->getRequest();
    	
    	if ($request->isPost())
    	{
    		if ($form->isValid($request->getPost()))
    		{
    			// do 	something here to log in+
    			if ($this->_process($form->getValues()))
    			{
    				// We're authenticated! Redirect to the home page
    				//$rememberme = 60*15;
    				//Zend_Session::RememberMe($rememberme);
    				$this->_helper->redirector('index', 'account');
    			}
    			else
    			{
    				$this->view->errors = array( array("Wrong username and password combination dude!"));
    			}
    			
    		}
    		else
    		{
    			$this->view->errors = $form->getErrors();
    		}
    	}
    	$this->view->form = $form;
    }

    protected function _process($values)
    {    
    	// Get our authentication adapter and check credentials
    
    	$adapter = $this->_getAuthAdapter();
    
    	$adapter->setIdentity($values['username']);
    
    	$adapter->setCredential($values['password']);
    
    	$auth = Zend_Auth::getInstance();
    
    	$result = $auth->authenticate($adapter);
    
    	if ($result->isValid() && $this->isConfirmedAction($values['username']))
    	{
    		$adapter->setIdentity("1");
    		$user = $adapter->getResultRowObject();
    		    
    		$auth->getStorage()->write($user);
    		
    		return true;
    	}
    
    	return false;
    }

    protected function _getAuthAdapter()
    {
    	$dbAdapter = Zend_Db_Table::getDefaultAdapter();
    
    	$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

    	$authAdapter->setTableName('accounts')
    
    	->setIdentityColumn('username')
    
    	->setCredentialColumn('password')
    
    	->setCredentialTreatment('SHA1(CONCAT(?,salt))');
        
    	return $authAdapter;
    
    }

    public function logoutAction()
    {
        // action body
    	Zend_Auth::getInstance()->clearIdentity();
    	$this->_helper->redirector('index', 'index'); // back to login page
    }

    protected function isConfirmedAction($username)
    {
        // action body
    	$account = new Application_Model_DbTable_Accounts();
    	$select = $account->select();
    	$select->from($account)->where('username = ?', $username);
    	$row = $account->fetchRow($select);
    	if (count($row)>0)
    	{
    		if ($row->confirmed == 1)
    		{
    			return true;
    		}
    	}
    	return false;
    }

    public function recoverAction()
    {
        // action body
    	$form = new Application_Form_RecoverAccount();
    	$request = $this->getRequest();
    	 
    	if ($request->isPost()) {
    		 
    		if ($form->isValid($request->getPost())) {
    			 
    			//Create record to recover later the account
    			$queue = new Application_Model_DbTable_RecoveryQueue();
    			$token = uniqid();
    			$data = array(
    					'email'=>$form->getValue("email"),
    					'token'=>$token,
    					'validUntil'=>date("Y-m-d H:i:s",strtotime("+2 minutes"))
    			);
    			$queue->insert($data);
    			try {
    				
    				$smtpServer = 'mail.sociallgreen.com';
    				$username = 'XXXXXXXXXXXXXXXX.com';
    				$password = 'xxxxxxxxxxxxxxxxxxx';
    				 
    				$config = array(
    						'auth' => 'login',
    						'username' => $username,
    						'password' => $password);
    				 
    				$transport = new Zend_Mail_Transport_Smtp($smtpServer, $config);
    			
    			//Send recovery mail
    			
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
						<img style='max-width:400px' src='http://sociallgreen.com/images/social.png'>
						<h1>Sociallgreen</h1>
						<p>This is a recovery mail to get back your account. <br>
							Click the following link to reset your password.</p>
						<a href='http://sociallgreen.com/account/reset/token/".$token."/'>http://sociallgreen.com/account/reset/token/".$token."/</a>
						</body>
						</html>";
    				
    			$mail = new Zend_Mail();
    			$mail->setBodyHtml($htmlMail)
    			->setFrom('no-reply@sociallgreen.com', 'Sociallgreen Team')
    			->addTo($form->getValue('email'))
    			->setSubject('Confirmation Mail')
    			->send($transport);
    			
    			$this->_helper->_redirector('index','index');
    			} catch (Exception $e){
    			
    			}
    			 
    		} else {
    			$this->view->errors = $form->getErrors();
    		}
    		 
    	}
    	$this->view->form = $form;
    }

    public function facebookAction()
    {
        $token = $this->getRequest()->getParam('token',false);
		    if($token == false) {
		        return false; // redirect instead
		    }
		 
		    $auth = Zend_Auth::getInstance();
		    $adapter = new Application_Model_FacebookLogin($token);
		    $result = $auth->authenticate($adapter);
		    if($result->isValid()) {
		        $user = $adapter->getUser();
		        $auth->getStorage()->write($user);
		        $result = "Valid"; // redirect instead
		    } else {
		    $result = "Invalid login"; // redirect instead
		    }
		 $this->view->login = $result;
		 $this->view->mail = $adapter->getMail();
    }


}









