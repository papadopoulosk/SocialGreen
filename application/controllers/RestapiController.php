<?php

class RestapiController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$this->_helper->layout()->disableLayout();
    	
    }

    public function indexAction()
    {
        // action body
    	//$this->_helper->redirector('index', 'account');
    }

    public function userinfoAction()
    {
    	$request = $this->getRequest();
    	$user = $request->getPost('user');
    	
    	$this->view->badgesPrefix = "/images/badges/";
    	$this->view->imgPrefix = "/images/avatars/";
    	$this->view->title = $user;
    	
    	
    	if ($request->isPost())
    	{
    		 
    		if ($this->userExist($user))
    		{
    			/*Retrieve All user's badges
    			$userbadges = new Application_Model_DbTable_Accounts();
    			$query = $userbadges->select('bad.id','bad.title','bad.path','bad.class');
    			$query->from(array('acc' => 'accounts'),array('id','username'));
    			$query->from(array('usb' => 'user_badges'),array('badge_id','user_id'));
    			$query->from(array('bad' => 'badges'),array('id','title','path', 'class'));
    			$query->where('acc.id = usb.user_id AND acc.username = "'.$user.'" AND usb.badge_id = bad.id');
    			$query->group(array("bad.id"));
    			
    			$query->setIntegrityCheck(false);
    			$this->view->userbadges = $userbadges->fetchAll($query);*/
    			
    			/*Retrieve ALL user's Activity
    			$useractivity = new Application_Model_DbTable_Accounts();
    			$query3 = $useractivity->select();
    			$query3->from(array('acc' => 'accounts'), array('id', 'username','avatar', 'fullname'));
    			$query3->from(array('act' => 'activity'),array('quantity','date', 'aluminium','glass','plastic'));
    			$query3->where('acc.username = "'.$user.'" AND act.userid = acc.id');
    			
    			$query3->order('act.date DESC');
    			$query3->setIntegrityCheck(false);
    			
    			$result2 = $useractivity->fetchAll($query3);*/
    			
    			/*$accounts = new Application_Model_DbTable_Accounts();
    			$query = $accounts->select();
    			$query->from(array('act' => 'activity'), array('SUM(act.quantity) as quantity','SUM(act.plastic) as plastic','SUM(act.glass) as glass','SUM(act.aluminium) as aluminium', '(SUM(act.glass)*1+SUM(act.plastic)*2+SUM(act.aluminium)*3) as leafs','userid','MAX(act.date) as date'));
    			$query->join(array('acc' => 'accounts'), 'act.userid = acc.id', array('fullname','username','avatar','description', 'url'));
    			$query->order('leafs Desc');
    			$query->group(array("username"));
    			$query->setIntegrityCheck(false);
    			//echo (String)$query;
    			$this->view->accounts = $accounts->fetchAll($query);*/
    			
    			/*Retrieve user's info*/
		    	$userinfo = new Application_Model_DbTable_Accounts();
		    	$query3 = $userinfo->select();
		    	$query3->from(array('acc' => 'accounts'), array('username','email','avatar', 'fullname','points','description', 'url'));
		    	$query3->from(array('act' => 'activity'), array('SUM(act.aluminium) as aluminium','SUM(act.glass) as glass','SUM(act.plastic) as plastic','MAX(act.date) as date'));
		    	$query3->where('acc.username = "'.$user.'" AND acc.id = act.userid');
		    	$query3->group("acc.username");
		    	$query3->setIntegrityCheck(false);
		    	$this->view->userinfo = $userinfo->fetchRow($query3);
		    	
		    	$this->view->errors = NULL;
    			 
    		}
    		else
    		{
    			//$this->view->errors = array( array("Wrong username and password combination dude!"));
    			//$this->_response->clearBody();
				//$this->_response->clearHeaders();
				//$this->_response->setHttpResponseCode(404);
    			$this->view->errors = "User don't exist".$user;
    		}
    		 
    	}
    	else
    	{
    		//$this->_response->clearBody();
			//$this->_response->clearHeaders();
			//$this->_response->setHttpResponseCode(404);
    		$this->view->errors = "No post data";
    	}
    	
    	/*
    	
    	$user = $this->_getParam('user');
    	$this->view->title = $user;
    	$this->view->user = $user;
    	
    	$userinfo = new Application_Model_DbTable_Accounts();
    	$query3 = $userinfo->select();
    	$query3->from(array('acc' => 'accounts'), array('username','email','avatar', 'fullname','points','description', 'url'));
    	$query3->from(array('act' => 'activity'), array('SUM(act.aluminium) as aluminium','SUM(act.glass) as glass','SUM(act.plastic) as plastic','MAX(act.date) as date'));
    	$query3->where('acc.username = "'.$user.'" AND acc.id = act.userid');
    	$query3->group("acc.username");
    	$query3->setIntegrityCheck(false);
    	
    	$this->view->userinfo = $userinfo->fetchRow($query3);*/
    	
    	
    }

    protected function userExist($user)
    {
    	if($user != NULL)
    	{
    		$usr = new Application_Model_DbTable_Accounts();
    		$query = $usr->select();
    		$query->from(array('acc' => 'accounts'), array('username'));
    		$query->where('acc.username = "'.$user.'"');
    		$query->setIntegrityCheck(false);
    		$username = $usr->fetchRow($query);
    		 
    		if($username->username != NULL )
    		{
    			return true;
    		}
    		else
    		{
    			return false;
    		}
    	}
    	else
    	{
    		return false;
    	}
    	
    }

    public function userloginAction()
    {
    	$request = $this->getRequest();
    	$user = $request->getPost('username');
    	$password = $request->getPost('password');
    	
    	$this->view->badgesPrefix = "/images/badges/";
    	$this->view->imgPrefix = "/images/avatars/";
    	
    	if ($request->isPost())
    	{
    		 
    		if ($this->userExist($user))
    		{
    			    			
    			/*Retrieve ALL user's Activity*/
		    	$userinfo = new Application_Model_DbTable_Accounts();
		    	$query3 = $userinfo->select();
		    	$query3->from(array('acc' => 'accounts'), array('username','email','avatar', 'fullname','points','description', 'url'));
		    	$query3->from(array('act' => 'activity'), array('SUM(act.aluminium) as aluminium','SUM(act.glass) as glass','SUM(act.plastic) as plastic','MAX(act.date) as date'));
		    	$query3->where('acc.username = "'.$user.'" AND acc.id = act.userid');
		    	$query3->group("acc.username");
		    	$query3->setIntegrityCheck(false);
		    	$this->view->userinfo = $userinfo->fetchRow($query3);
		    	
		    	$this->view->errors = NULL;
    			 
    		}
    		else
    		{
    			//$this->view->errors = array( array("Wrong username and password combination dude!"));
    			//$this->_response->clearBody();
				//$this->_response->clearHeaders();
				//$this->_response->setHttpResponseCode(404);
    			$this->view->errors = "User don't exist";
    		}
    		 
    	}
    	else
    	{
    		//$this->_response->clearBody();
			//$this->_response->clearHeaders();
			//$this->_response->setHttpResponseCode(404);
    		$this->view->errors = "No post data";
    	}
    }

    protected function fbuserExist($user)
    {
    	if($user != NULL)
    	{
    		$usr = new Application_Model_DbTable_Accounts();
    		$query = $usr->select();
    		$query->from(array('acc' => 'accounts'), array('username'));
    		$query->where('acc.username = "'.$user.'" AND typeId = 3');
    		$query->setIntegrityCheck(false);
    		$username = $usr->fetchRow($query);
    		 
    		if($username->username != NULL )
    		{
    			return true;
    		}
    		else
    		{
    			return false;
    		}
    	}
    	else
    	{
    		return false;
    	}
    	 
    }

    public function fbloginAction()
    {
        // action body
    	$request = $this->getRequest();
    	$fbid = $request->getPost('fbid');
    	$user = $request->getPost('username');
    	$email = $request->getPost('email');
    	$avatar = $request->getPost('avatar');
    	 
    	//$this->view->title = $user;
    	 
    	 
    	if ($request->isPost())
    	{
    		if ($this->fbuserExist($user))
    		{
    			/*already facebook user retrieve users info*/
    			$userinfo = new Application_Model_DbTable_Accounts();
    			$query3 = $userinfo->select();
    			$query3->from(array('acc' => 'accounts'), array('username','email','avatar', 'fullname','points','description', 'url','fbid'));
    			$query3->from(array('act' => 'activity'), array('SUM(act.aluminium) as aluminium','SUM(act.glass) as glass','SUM(act.plastic) as plastic','MAX(act.date) as date'));
    			$query3->where('acc.username = "'.$user.'" AND acc.id = act.userid');
    			$query3->group("acc.username");
    			$query3->setIntegrityCheck(false);
    			$temp = $userinfo->fetchRow($query3);
    			
    			/*if user exist but doesn't have activity*/
    			if($temp->username == "")
    			{
    				$userinfo2 = new Application_Model_DbTable_Accounts();
	    			$query = $userinfo2->select();
	    			$query->from(array('acc' => 'accounts'), array('username','email','avatar', 'fullname','points','updated AS date','fbid'));
	    			//$query3->from(array('act' => 'activity'), array('SUM(act.aluminium) as aluminium','SUM(act.glass) as glass','SUM(act.plastic) as plastic','MAX(act.date) as date'));
	    			$query->where('acc.username = "'.$user.'"');
	    			//$query3->group("acc.username");
	    			$query->setIntegrityCheck(false);
	    			$temp2 = $userinfo2->fetchRow($query);
    				$this->view->userinfo2 = $temp2;
    				$this->view->userinfo = NULL;
    			}
    			else
    			{
    				$this->view->userinfo = $temp;
    				$this->view->userinfo2 = NULL;
    			}
    			
    			$this->view->newuserinfo = NULL;
    			$this->view->errors = NULL;
    	
    		}
    		else
    		{
    			/*New facebook user Insert into Accounts table*/
    			$account = new Application_Model_DbTable_Accounts();
    			
    			$data = array(
    					'email'=>$email,
    					//'description'=>$form->getValue('description'),
    					'username'=>$user,
    					'fullname'=>$user,
    					'avatar'=>$avatar,
    					'confirmed'=>'1',
    					//'password'=>$form->getValue('pswd'),
    					'created'=>date('Y-m-d H:i:s'),
    					'updated'=>date('Y-m-d H:i:s'),
    					'typeid'=>'3',
    					'fbid'=> $fbid,
    					'fb'=>'https://www.facebook.com/'.$user
    			);
    			TRY
    			{
    				$account->insert($data);
    				$tmp = array('fbid'=>$fbid,
    							'email'=>$email,
    							'username'=>$user,
    							'avatar'=>$avatar,
    							'date'=>date('Y-m-d H:i:s'),
    							'points'=>'0',
    				 			'glass'=>'0',
    							'plastic'=>'0',
    							'aluminium'=>'0',);
    				 
    				$this->view->newuserinfo = $tmp;
    				$this->view->userinfo = NULL;
    				$this->view->errors = NULL;
    			}
    			catch (Zend_Db_Exception $e) 
    			{
    				//echo $e->getMessage();
    				$this->view->errors = "Database error";
    			}
    		}		 
    	}
    	else
    	{
    		$this->view->errors = "No post data";
    	}
    }

    public function qrscanAction()
    {
    	// action body
    	$request = $this->getRequest();
    	$user = $request->getPost('username');
    	//$tranid = $request->getPost('tranid');
    	$alum = $request->getPost('alum');
    	$plastic = $request->getPost('plastic');
    	$glass = $request->getPost('glass');
    	
    	//$this->view->badgesPrefix = "/images/badges/";
    	//$this->view->imgPrefix = "/images/avatars/";
    	
    	if ($request->isPost())
    	{
    		/*if ($this->validTranid($tranid,$alum,$plastic,$glass))
    		{*/
    			$userid = $this->fbvalidUserid($user);
    			if ($userid)
    			{
    				TRY 
    				{
	    				$activity = new Application_Model_DbTable_Activity();
	    				$newRow = $activity->createRow();
	    					
	    				// Set column values as appropriate for your application
	    				$newRow->userid = $userid;
	    				$newRow->quantity = ($alum+$plastic+$glass);
	    				$newRow->glass = $glass;
	    				$newRow->aluminium = $alum;
	    				$newRow->plastic = $plastic;
	    				$newRow->paper = "0";
	    				$newRow->date = date('Y-m-d');
	    					
	    				// INSERT the new row to the database
	    				$newRow->save();
	    				$activity->fetchAll();
	    				
	    				/*updated userinfo*/
	    				$userinfo = new Application_Model_DbTable_Accounts();
	    				$query3 = $userinfo->select();
	    				$query3->from(array('acc' => 'accounts'), array('username','email','avatar', 'fullname','points','description', 'url','fbid'));
	    				$query3->from(array('act' => 'activity'), array('SUM(act.aluminium) as aluminium','SUM(act.glass) as glass','SUM(act.plastic) as plastic','MAX(act.date) as date'));
	    				$query3->where('acc.username = "'.$user.'" AND acc.id = act.userid');
	    				$query3->group("acc.username");
	    				$query3->setIntegrityCheck(false);
	    				$this->view->userinfo = $userinfo->fetchRow($query3);
						
	    				/*delete transactions
	    				$transaction = new Application_Model_DbTable_Transaction();
	    				$where = $transaction->getAdapter()->quoteInto('tranid = ?', ($tranid.$alum.$plastic.$glass));
	    				$transaction->delete($where); */
	    				
	    				$this->view->errors = NULL;
    				}
    				catch (Zend_Db_Exception $e)
    				{
						$this->view->errors = "Database error";
                	}
    			}
    			else
    			{
    				$this->view->errors = "User not valid";
    			}
    		/*}
    		else
    		{
    			$this->view->errors = "Transaction id not valid";
    		}*/		 
    	}
    	else
    	{
    		$this->view->errors = "No post data";
    	}
    }

    protected function validTranid($tranid, $alum, $plastic, $glass)
    {
    	if($tranid != NULL)
    	{
    		$transaction = new Application_Model_DbTable_Transaction();
    		$query = $transaction->select();
    		$query->from(array('tra' => 'transaction'), array('tranid'));
    		$query->where('tra.tranid = "'.$tranid.$alum.$plastic.$glass.'"');
    		$query->setIntegrityCheck(false);
    		$result = $transaction->fetchRow($query);
    		 
    		if($result->tranid != NULL)
    		{
    			return true;
    		}
    		else
    		{
    			return false;
    		}
    	}
    	else
    	{
    		return false;
    	}
    	 
    }

    protected function fbvalidUserid($user)
    {
    	if($user != NULL)
    	{
    		$usr = new Application_Model_DbTable_Accounts();
    		$query = $usr->select();
    		$query->from(array('acc' => 'accounts'), array('id'));
    		$query->where('acc.username = "'.$user.'" AND typeid = 3');
    		$query->setIntegrityCheck(false);
    		$username = $usr->fetchRow($query);
    		 
    		if($username->id != NULL)
    		{
    			return $username->id;
    		}
    		else
    		{
    			return false;
    		}
    	}
    	else
    	{
    		return false;
    	}
    	 
    }

    public function binupdateAction()
    {
    	// action body
    	$request = $this->getRequest();
    	$binid = $request->getPost('binid');
    	$tranid = $request->getPost('tranid');
    	$alum = $request->getPost('alum');
    	$plastic = $request->getPost('plastic');
    	$glass = $request->getPost('glass');
    	$paper = $request->getPost('paper');
    	 
    	//$this->view->badgesPrefix = "/images/badges/";
    	//$this->view->imgPrefix = "/images/avatars/";
    	 
    	if ($request->isPost())
    	{
    		
    				TRY
    				{
    					/*add bin activity */
    					$binactivity = new Application_Model_DbTable_Binactivity();
    					$newRow = $binactivity->createRow();
    					$newRow->binid = $binid;
    					$newRow->quantity = ($alum+$plastic+$glass);
    					$newRow->date = date('Y-m-d');
    					$newRow->aluminium = $alum;
    					$newRow->glass = $glass;
    					$newRow->paper = $paper;
    					$newRow->plastic = $plastic;
    					$newRow->save();
    					$binactivity->fetchAll();

    					/*add transaction id */
    					$transaction = new Application_Model_DbTable_Transaction();
    					$newRow2 = $transaction->createRow();
    					$newRow2->tranid = $tranid.$alum.$plastic.$glass;
    						
    					$newRow2->save();
    					$transaction->fetchAll();
    		    
    					$this->view->errors = NULL;
    				}
    				catch (Zend_Db_Exception $e)
    				{
    					$this->view->errors = "Database error";
    				}
    		
    	}
    	else
    	{
    		$this->view->errors = "No post data";
    	}
    }


}











