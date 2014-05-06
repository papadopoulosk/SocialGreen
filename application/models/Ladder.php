<?php

class Application_Model_Ladder
{
	
	private $graph;
	
	/**
	 * @return the $graph
	 */
	public function getGraph() {
		return $this->graph;
	}
	
	public function __construct(array $options = null){
	
		$ladder = new Application_Model_DbTable_Ladder();
		$users = new Application_Model_DbTable_Accounts();
		
		$usersSelect = $users->select();
		$usersSelect->from($users, array('username','id','points'))->order('ranking ASC');
		$users = $users->fetchAll($usersSelect);
		
		$graph = "[''";
		foreach ($users as $user){
			$graph.= ",'".$user->username."'";
		}
		$graph.="],[''";
		foreach ($users as $user){
			$graph.= ",".$user->points."";
		}
		$graph.="]";
		
		$this->graph = $this->getHtmlCode($graph);	
		
	}
	
	private function getHtmlCode($vars){
		
		$htmlCode="<script type='text/javascript'>
      google.load('visualization', '1', {packages:['corechart']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ".$vars."
        ]);

        var options = {
          title: 'Green Ladder Game',
          vAxis: {title: '',  titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.BarChart(document.getElementById('ladder'));
        chart.draw(data, options);
      }
    </script>
     <div id='ladder' style='width: 900px; height: 500px;'></div>";
		
		return $htmlCode;
	}

}

