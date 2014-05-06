<?php
class Zend_View_Helper_Errors extends Zend_View_Helper_Abstract
{
    public function Errors ($errors){
        if (count($errors)>0){
        	//echo '<div class="">';
            echo '<div  class="alert fade in"><button type="button" class="close" data-dismiss="alert">×</button>';
           	//echo "<p>Warning! Something went wrong during your registration!</p>";
            //echo "<ul>";
            //echo "<li>Check your mail and verify that it is correct.</li>";
            //echo "<li>Did you type the captcha word correctly?!</li>";
            //echo "<li>Maybe your are registered already!</li>";
           // var_dump($errors);
            foreach ($errors as $error) {
                if ($error[0]!=""){
                    printf("<li>%s</li>", $error[0]);
                }
            }
            echo "</ul>";
            echo "</div>";
            echo '<script>$( document ).ready(function() {
    					$("div.alert").delay(30000).slideUp("slow");
					});</script>';
        }
    }
} 
?>