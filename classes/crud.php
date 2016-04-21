<?php 
/**
 * CRUD class for handling database queries and operations
 */
include_once "../config.php";
include_once ROOT . "classes/dbconnect.php";
include_once ROOT . "db/database.php";
include_once ROOT . "helpers/html.php";

// require 'core/class/SqlManager.php';

if (isset($_POST['function'])) {
    $function =  $_POST['function'];
    $crud = new Crud();
    if (method_exists($crud,$function )) 
        {
            if ($function == 'getImage') {
                echo $crud->$function();    
            }
            else{
                echo json_encode($crud->$function() );
            }
        }
    //else echo json_encode("function doesn't exists");
}
if (isset($_GET['function'])) {
    $crud = new Crud();
    $function =  $_GET['function'];
    if (method_exists($crud,$function )) 
    {
        if ($function == 'getImage') {
            echo $crud->$function();    
        }
    }    
}


class Crud
{
    /**
     * CRUD controller
     */
    public $db;//database object 

    /**
     * constructor
     */
    public function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }

    public function create()
    {
    	if (isset($_POST['entry-name'])) {
    		$pro_name 	= $_POST['entry-name'];
    		$desc 		= $_POST['entry-description'];
    		$address 	= $_POST['entry-address'];
            $reload_data= $_POST['reload-data'] ;
            $price      = $_POST['entry-price'];
            $thumb      = $_POST['property-image'] ;
            if (substr($thumb, 0, 4) == 'data') {
                $filteredData=substr($thumb, strpos($thumb, ",")+1);
 
            //Decode the string
            $unencodedData=base64_decode($filteredData);
             $date = new DateTime();
            $filename =   $date->getTimestamp().'.jpeg';
            //Save the image
            file_put_contents(ROOT . 'uploads/'.$filename, $unencodedData);

            // $image_data = saveImage($thumb, $file);
    }
    		$values 	= array(
    							'name' 			=> $pro_name,
    							'description'	=> $desc,
    							'address'		=> $address,
    							// 'post_status'	=> 'published',
                                'price'         => $price,
    							// 'created_at'	=> date('Y/ d/ M H:i'),
    							// 'updated_at'	=> date('y d m h i s'),
                                'img'           =>  $filename
    			);
    		$msg = $this->db->insert( 'properties' , $values);
    		if ($reload_data == true) {
                $msg = $this->getProject();
            };
            return $msg;
    	}
    }

    public function addProject($id = null)
    {
        return $this->create();
    }

    public function  fetch_all()
    {
    	return $this->db->select('properties', '*');
    }

    public function getProject()
    {
        $projects =[];
        $output = "";
        if ( $this->fetch_all() ):
            $data = $this->db->getResult(); 
        endif;

        // $output .= "<table id = 'data-table'><thead>";

        foreach ($data[0] as $key => $value) :

                     // $output .=  ($key == 'id')? '' : table_th($key);/**/
        endforeach;

        // $output .= "</thead>";


        foreach ($data as $key => $value) {
            $project = array(
                "id"            => $value["id"],
                "name"          => $value["name"],
                "description"   => $value['description'],
                "address"       => $value['address'],
                // "post_status"   => $value['post_status'],
                // "updated_at"    => $value['updated_at'],
                // "author"        => $value['author'],
                "image"         => $value['img'],
                "price"         => $value['price']
            );
            array_push($projects, $project);
        // $output .=  table_tr( table_td($value['name']) . table_td($value['description']) . table_td($value['address']) . table_td($value['post_status']) . table_td($value['created_at']) . table_td($value['updated_at']) . table_td($value['author']) );
         
        }
        // $output .= " </table>";
        // return $output;
        return $projects;
    }   

    public function getImage()
    {
        header('Content-type: image/jpeg');
        $id   = $_GET['id'];
        $result = $this->db->query_obj('SELECT img FROM properties WHERE id = ' . $id);
        $thumb = "";

        foreach ($result as $key => $value) {
            $thumb = $value['img'];
        }
        // return $thumb;
        return mysql_result($result, 0);
    }
}
