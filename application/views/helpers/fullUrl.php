<?php
    class Zend_View_Helper_Fullurl extends Zend_View_Helper_Abstract {
        public function fullurl($url) {
            $request = Zend_Controller_Front::getInstance()->getRequest();
            $url = $request->getScheme() . '://' . $request->getHttpHost() . $url;
            return $url;
        }
    }
?>
