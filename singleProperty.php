<?php
if (!defined("ROOT")) {
    include_once "php/config.php";
}
if (isset($_GET) && isset($_GET['property-id'])) :
    $property_id = $_GET['property-id'];
    include_once "php/config.php";
    include_once "php/core/crud.php";
    $crud = new Crud();
    $sql = "SELECT * FROM properties WHERE id = {$property_id}";
    $propertyDetails = $crud->getPropertyBySql($sql);
    $singleProperty = (object)$propertyDetails[0];
?>



<!DOCTYPE html >
<html >
    <head >
        <meta charset = "utf-8" >
        <meta http - equiv = "X-UA-Compatible" content = "IE=edge" >
        <title > Real Estate </title >
        <link rel = "stylesheet" href = "<?php echo CSS_PATH . 'normalize.css'; ?>" >
        <link rel = "stylesheet" href = "<?php echo CSS_PATH . 'style.css'; ?>" >
    </head >
    <body >
        <header >
            <div id = "logo" > Real Estate </div >
        </header >
        <div class="home-content" >
            <?php
                if ($propertyDetails):
                    echo true;
            ?>
                    <div class="property-single-wrapper">
                        <div class="row">
                            <img src="<?php echo UPLOADS_PATH . $singleProperty->img; ?>" alt="">
                        </div>
                        <div class="row">
                            <span>Name : </span>
                            <?php
                            echo $singleProperty->name;
                            ?>
                        </div>
                        <div class="row">
                            <?php
                            echo $singleProperty->description;
                            ?>
                        </div>
                        <div class="row">
                            <span>Address : </span>
                            <?php
                            echo $singleProperty->address;
                            ?>
                        </div>
                        <div class="row"><span>Price : </span>
                            <?php
                            echo $singleProperty->price;
                            ?>
                        </div>
                        <div class="row"><span>Home type : </span>
                            <?php
                            echo $singleProperty->home_type;
                            ?>
                        </div>
                        <div class="row"><span>HOA dues : </span>
                            <?php
                            echo $singleProperty->hoa_dues;
                            ?>
                        </div>
                        <div class="row"><span>No. of beds : </span>
                            <?php
                            echo $singleProperty->no_of_beds;
                            ?>
                        </div>
                        <div class="row"><span>Basement area : </span>
                            <?php
                            echo $singleProperty->basement_area;
                            ?>
                        </div>
                        <div class="row"><span>Garage area : </span>
                            <?php
                            echo $singleProperty->garage_area;
                            ?>
                        </div>
                        <div class="row"><span>Description : </span>
                            <?php
                            echo $singleProperty->home_description;
                            ?>
                        </div>
                        <div class="row"><span>Finished square feet : </span>
                            <?php
                            echo $singleProperty->finished_square_feet;
                            ?>
                        </div>
                        <div class="row"><span>Lot size : </span>
                            <?php
                            echo $singleProperty->lot_size;
                            ?>
                        </div>
                        <div class="row"><span>Year built : </span>
                            <?php
                            echo $singleProperty->year_built;
                            ?>
                        </div>
                    </div>

            <?php
                else:
            ?>
            <span>No property found</span>

            <?php
                endif;
            ?>
        </div>
    </body>
</html>
<?php
else:
    header("location:index.php");
endif;
