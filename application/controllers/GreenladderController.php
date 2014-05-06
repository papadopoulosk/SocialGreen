<?php

class GreenladderController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	$title = "Green Ladder";
    	$this->view->title = $title;    	
    	
    	$Ladder = new Application_Model_Ladder();
    	$this->view->graph = $Ladder->getGraph();
    	
    	$dailyLadder = new Application_Model_DailyLadder();
    	$this->view->dailyGraph = $dailyLadder->getGraph();
  
    }

    public function indexAction()
    {
        // action body
        
    }
    
    public function binupdateAction(){
    	
    	$form = new Application_Form_BinUpdateForm();
    	$activity = new Application_Model_DbTable_Activity();

    	
    	$request = $this->getRequest();
    	
    	
    	if ($this->getRequest()->isGet()) {
    		if ($form->isValid($request->getParams())) {
    			$newRow = $activity->createRow();
				 
				// Set column values as appropriate for your application
				$newRow->userid = $this->_request->getParam('userid');
				$newRow->quantity = $this->_request->getParam('quantity');
				$newRow->glass = $this->_request->getParam('glass');
				$newRow->aluminium = $this->_request->getParam('aluminium');
				$newRow->paper = $this->_request->getParam('paper');
				$newRow->plastic = $this->_request->getParam('plastic');
				$newRow->date = date('Y-m-d');
				 
				// INSERT the new row to the database
				$newRow->save();
				$activity->fetchAll();
				
    		}
    	}
    	
    	$this->view->form = $form;
    	
    	//$activity2 = new Application_Model_DbTable_Activity();
    	$query = $activity->select();
        $query->from(array('act' => 'activity'));
        $query->order('act.id DESC');
        $query->setIntegrityCheck(false);
        
    	$this->view->results = $activity->fetchAll($query);
    }
	

}?>
