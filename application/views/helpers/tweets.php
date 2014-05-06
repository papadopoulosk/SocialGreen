<?php
class Zend_View_Helper_Tweets extends Zend_View_Helper_Abstract
{
	public function Tweets(){
		
		//$url = file_get_contents("https://api.twitter.com/1/statuses/user_timeline.json?include_entities=true&include_rts=true&screen_name=sociallgreen");
		$url = file_get_contents("https://search.twitter.com/search.json?q=%20%23recycle&rpp=5&include_entities=true&with_twitter_user_id=true&result_type=mixed");
		$arr = json_decode($url,true);
		$prettyString = Zend_Json::prettyPrint($url);
		//print_r($prettyString);
		echo '<button class="btn btn-info" data-toggle="button" id="moarTweets" type="button">More&nbsp;<i class="icon-circle-arrow-down icon-white"></i></button>';
		echo "<table class='table' id='twitter'>";
		$displayCounter = 1;
		$limit = 4;
		foreach ($arr['results'] as $item){
//			if ($displayCounter=='1') echo '<tr><td><button class="btn btn-info" data-toggle="button" id="moarTweets" type="button">More&nbsp;<i class="icon-circle-arrow-down icon-white"></i></button></td></tr>';
			echo "<tr";
			if ($displayCounter>=$limit) echo " class='hidden' ";
			echo ">";
			echo "<td class='text'>";
			//echo $item['text'];//linkEntitiesWithinText($arr);//$item['text'];
			echo $this->links($item['text']);
			echo "</td>";
			echo "<td class='time'>";
			echo date("j/n/y",strtotime($item['created_at']));;
			echo "</td>";
			echo "</tr>";
			$displayCounter++;
		}
		echo "</table>";
		?>
		<script>
		$("#moarTweets").click(function(){
			if ($(this).attr('class')=="btn btn-info"){
				$("table#twitter").find("tr:hidden").each(function(){
					$(this).toggleClass("hidden");//css('background-color', 'red');
				});
				$("#moarTweets").html('Less&nbsp;<i class="icon-circle-arrow-up icon-white"></i>');
			} else if ($(this).attr('class')=="btn btn-info active") {
				$("table#twitter").find("tr").slice(-<?php echo $displayCounter-$limit; ?>).each(function(){
					$(this).toggleClass("hidden");//css('background-color', 'red');
				});
				$("#moarTweets").html('More&nbsp;<i class="icon-circle-arrow-down icon-white"></i>');
			}
			
//			$("#moarTweets").html('Less&nbsp;<i class="icon-circle-arrow-up"></i>');
		});
		</script>
		<?php	
	}
	
	private function links($status_text) {
		// linkify URLs
		$status_text = preg_replace(
				'/(https?:\/\/\S+)/',
				'<a target="_blank" href="\1" class="preg-links">\1</a>',
				$status_text
		);
	
		// linkify twitter users
		$status_text = preg_replace(
				'/(^|\s)@(\w+)/',
				'\1@<a target="_blank" href="http://twitter.com/\2" class="preg-links">\2</a>',
				$status_text
		);
	
		// linkify tags
		$status_text = preg_replace(
				'/(^|\s)#(\w+)/',
				'\1#<a target="_blank" href="http://twitter.com/search?q=%23\2" class="preg-links">\2</a>',
				$status_text
		);
	
		return $status_text;
	}
	
}