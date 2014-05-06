<?php

class Application_Form_UploadAvatar extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
    	$this->setName('upload');
    	$this->setMethod('post');
    	$this->setAttrib('enctype', 'multipart/form-data');
    	
    	$description = new Zend_Form_Element_Text('description');
    	$description->setLabel('Description');
    	$description->setRequired(true);
    	$description->addValidator('NotEmpty');
    	
    	$file = new Zend_Form_Element_File('file');
    	$file->setLabel('File');
    	$file->setDestination(BASE_PATH . '/public/images/avatars');
    	$file->setRequired(true);
    	$file->addFilter(new Skoch_Filter_File_Resize(array(
    			'width' => 300,
    			'height' => 300,
    			'keepRatio' => false,
    	)));
    	
    	// ensure only 1 file
    	$file->addValidator('Count', false, 1);
    	// limit to 100K
    	//$file->addValidator('Size', false, 202400);
    	// only JPEG, PNG, and GIFs
    	$file->addValidator('Extension', false, 'jpg,png,gif');
    	/*$file->addValidator('ImageSize', false,
                      array('minwidth' => 40,
                            'maxwidth' => 80,
                            'minheight' => 100,
                            'maxheight' => 200)
                      );*/
    	//$file->setValueDisabled(true);
    	
    	$submit = new Zend_Form_Element_Submit('submit');
    	$submit->setLabel('Upload');
    	$submit->setAttrib("class", "btn btn-large btn-inverse");
    	
    	$this->addElements(array($description, $file, $submit));
    }


}

