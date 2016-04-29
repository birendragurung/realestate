<?php
/**
 * CRUD class for handling database queries and operations
 */

//include_once ROOT . "php/config.php";
// include_once ROOT . "classes/dbconnect.php";
if (!defined('ROOT')) {
    include_once "../config.php";
}
include_once ROOT . "php/libs/database.php";
include_once ROOT . "php/helpers/html.php";

// require 'core/class/SqlManager.php';
/**
 * serve search request from ajax get request
 */
if (isset($_POST['q'])) {
//    $function = $_GET['function'];
    $crud = new Crud();
    $search_text = $_POST['q'];
    $sql = "SELECT * FROM properties WHERE name LIKE '%" . $search_text . "%' OR description LIKE '%" . $search_text . "%' OR address LIKE '%" . $search_text . "%'";
    echo json_encode($crud->getPropertyBySql($sql));
}
if (isset($_POST['function'])) {
    $function = $_POST['function'];
    $crud = new Crud();
    if (method_exists($crud, $function)) {
        if ($function == 'getImage') {
            echo $crud->$function();
        } else {
            echo json_encode($crud->$function());
        }
    }
    //else echo json_encode("function doesn't exists");
}
if (isset($_GET['function'])) {
    $crud = new Crud();
    $function = $_GET['function'];
    if (method_exists($crud, $function)) {
        if ($function == 'getImage') {
            echo $crud->$function();
        }
    }
}

//if(isset($_GET['q']))

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
            $pro_name = $_POST['entry-name'];
            $desc = $_POST['entry-description'];
            $address = $_POST['entry-address'];
            $reload_data = $_POST['reload-data'];
            $price = $_POST['price'];
            $thumb = $_POST['thumb'];
            $filename = "";
            if (substr($thumb, 0, 4) == 'data') {
                $filteredData = substr($thumb, strpos($thumb, ",") + 1);

                //Decode the string
                $unencodedData = base64_decode($filteredData);
                $date = new DateTime();
                $filename = $date->getTimestamp() . '.jpeg';
                //Save the image
                file_put_contents(ROOT . 'uploads/' . $filename, $unencodedData);

                // $image_data = saveImage($thumb, $file);
            }
            $values = array(
                'name' => $pro_name,
                'description' => $desc,
                'address' => $address,
                // 'post_status'	=> 'published',
                'price' => $price,
                // 'created_at'	=> date('Y/ d/ M H:i'),
                // 'updated_at'	=> date('y d m h i s'),
                'img' => $filename
            );
            $msg = $this->db->insert('properties', $values);
            if ($reload_data == true) {
                $msg = $this->getProject();
            };
            return $msg;
        }
    }


    public function addProperties()
    {
        $name = $_POST['property_name'];
        $description = $_POST['property_description'];
        $address = $_POST['property_address'];
        $price = $_POST['property_price'];
        $home_type = $_POST['property_home_type'];
        $hoa_dues = $_POST['property_hoa_dues'];
        $no_of_beds = $_POST['property_no_of_beds'];
        $basement_area = $_POST['property_basement_area'];
        $garage_area = $_POST['property_garage_area'];
        $home_description = $_POST['property_home_description'];
        $finished_square_feet = $_POST['property_finished_square_feet'];
        $lot_size = $_POST['property_lot_size'];
        $year_built = $_POST['property_year_built'];
        $map_location = $_POST['map_location'];
        $map_radius = $_POST['map_radius'];
        $map_latitude = $_POST['map_latitude'];
        $map_longitude = $_POST['map_longitude'];


        $target_dir = ROOT . '/uploads/';    //folder where the file is to be stored
//        $info 		= pathinfo($_FILES['property_image']['name']);	//filename of uploaded file
//        $ext 		= '.' . $info['extension']; // get the extension of the file
        $date = new DateTime();
        $filename = $date->getTimestamp() . ".jpg";
        $full_location = $target_dir . $filename;

        //defining parameter array for database insert operation
        $params = array(
            'name' => $name,
            'description' => $description,
            'address' => $address,
            'price' => $price,
            'home_type' => $home_type,
            'hoa_dues' => $hoa_dues,
            'no_of_beds' => $no_of_beds,
            'basement_area' => $basement_area,
            'garage_area' => $garage_area,
            'home_description' => $home_description,
            'finished_square_feet' => $finished_square_feet,
            'lot_size' => $lot_size,
            'year_built' => $year_built,
            'img' => $filename,
            'map_radius' => $map_radius,
            'map_location' => $map_location,
            'map_latitude' => $map_latitude,
            'map_longitude' => $map_longitude,
        );
        if (move_uploaded_file($_FILES['image']['tmp_name'], $full_location) && $this->db->insert("properties", $params)) {
            return true;
        }
        return false;
    }

    public function addProject($id = null)
    {
        return $this->create();
    }

    public function fetch_all()
    {
        return $this->db->select('properties', '*');
    }

    public function getProject()
    {
        $projects = [];
        $output = "";
        if ($this->fetch_all()):
            $data = $this->db->getResult();
        endif;

        // $output .= "<table id = 'data-table'><thead>";

        foreach ($data[0] as $key => $value) :

            // $output .=  ($key == 'id')? '' : table_th($key);/**/
        endforeach;

        // $output .= "</thead>";


        foreach ($data as $key => $value) {
            $project = array(
                "id" => $value["id"],
                "name" => $value["name"],
                "description" => $value['description'],
                "address" => $value['address'],
                // "post_status"   => $value['post_status'],
                // "updated_at"    => $value['updated_at'],
                // "author"        => $value['author'],
                "image" => $value['img'],
                "price" => $value['price']
            );
            array_push($projects, $project);
            // $output .=  table_tr( table_td($value['name']) . table_td($value['description']) . table_td($value['address']) . table_td($value['post_status']) . table_td($value['created_at']) . table_td($value['updated_at']) . table_td($value['author']) );

        }
        // $output .= " </table>";
        // return $output;
        return $projects;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        header('Content-type: image/jpeg');
        $id = $_GET['id'];
        $result = $this->db->query_obj('SELECT img FROM properties WHERE id = ' . $id);
        $thumb = "";

        foreach ($result as $key => $value) {
            $thumb = $value['img'];
        }
        // return $thumb;
        return $thumb;
    }

    public function getPropertyBySql($sql = "Select * from properties")
    {

        $data = $this->db->query_array($sql);
        return $data;
    }

    public function get_properties($sql = null)
    {
        $sql = "SELECT * FROM properties";
        $output = "";
        $value = $this->db->query_array($sql);
        foreach ($value as $item) {
            $output .= html_div(html_div($item['name'], "class = 'single-property'") . html_div($item['description'], "class = 'single-property'") . html_div($item['address'], "class = 'single-property'"), "id = 'recommended_properties'");
        }
        return $output;
    }
}
