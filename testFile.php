<?php 
    
    if($_FILES['file']['name']!='')
    {
        $fileName = $_FILES['file']['name'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $valid_extension = array("jpg",'jpeg');
        if(in_array($extension,$valid_extension))
        {
            $new_name = rand().".".$extension;
            $path = "user_uploads/".$new_name;

           if( move_uploaded_file($_FILES['file']['tmp_name'],$path)){
                
            }
        }
        
    }
    


?>