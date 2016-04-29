<?php
include_once "php/config.php";
if (isset($_POST['submit'])) {
    include_once ROOT . "php/core/crud.php";
//    var_dump($_FILES);
    $crud = new Crud();
    if ($crud->addProperties()) {
        echo "added property to database";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="<?php echo CSS_PATH; ?>style.css">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src='http://maps.google.com/maps/api/js?sensor=false&libraries=places'></script>
    <script src="<?php echo base_url(); ?>map/src/locationpicker.jquery.js"></script>
</head>
<body>
<div id="main">
    <div id="data-entry">
        <form id="entry_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <div class="map" id="google_map" style="width: 500px; height: 400px;">

            </div>
            <div id="maps_hidden_inputs">
                <input hidden type="text" name="map_location" id="us2-address" style="width: 200px"/>
                <input hidden type="text" name="map_radius" id="us2-radius"/>
                <input hidden type="text" name="map_latitude" id="us2-lat"/>
                <input hidden type="text" name="map_longitude" id="us2-lon"/>
            </div>
            <br><br>
            <div class="row">
                <label for="property_name">Property Name:</label>
                <input id="entry_name" type="text" name="property_name">
            </div>

            <div class="row">
                <label for="property_description">Description:</label>
                <textarea id="entry_description" name="property_description"></textarea>
            </div>

            <div class="row">
                <label for="property_address">Address:</label>
                <textarea id="entry_address" name="property_address"></textarea>
            </div>

            <div class="row">
                <label for="property_home_type">Home type:</label>
                <select name="property_home_type" id="entry_home_type">
                    <option value="Single family">Single family</option>
                    <option value="Condo">Condo</option>
                    <option value="Townhouse">Townhouse</option>
                    <option value="Multi family">Multi family</option>
                    <option value="Apartment">Apartment</option>
                    <option value="Mobile / Manufactured">Mobile / Manufactured</option>
                    <option value="Coop unit">Coop unit</option>
                    <option value="Vacant land">Vacant land</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <script>
                //                var sel = $("#entry_home_type").option.attr("value=" + "single");
            </script>
            <div class="row">
                <label for="property_price">Home price:</label>
                <input id="entry_price" type="text" name="property_price">
            </div>

            <div class="row">
                <label for="property_hoa_dues">HOA dues:</label>
                <input type="text" name="property_hoa_dues" id="entry_dues">
            </div>

            <div class="row">
                <label for="property_no_of_beds">No. of beds:</label>
                <select name="property_no_of_beds" id="entry_no_of_beds">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9+">9+</option>
                </select>

            </div>

            <div class="row">
                <label for="property_basement_area">Basement area:</label>
                <input type="text" name="property_basement_area" id="entry_basement_area">
            </div>

            <div class="row">
                <label for="property_garage_area">Garage area:</label>
                <input type="text" name="property_garage_area" id="entry_property_garage">
            </div>

            <div class="row">
                <label for="property_home_description">Home description:</label>
                <input type="text" name="property_home_description" id="entry_home_description">
            </div>

            <div class="row">
                <label for="property_finished_area">Finished square feet:</label>
                <input type="text" name="property_finished_square_feet" id="entry_finishded_square_area">
            </div>

            <div class="row">
                <label for="property_size">Lot size:</label>
                <input type="text" name="property_lot_size" id="entry_property_size">
            </div>

            <div class="row">
                <label for="property_year_built">Year built:</label>
                <select name="property_year_built" id="entry_year_built">
                    <?php
                    for ($i = 1900; $i <= date('Y'); $i++) {
                        echo "<option value = {$i} > {$i} </option>";
                    }
                    ?>
                </select>
            </div>

            <div class="row">
                <label for="property_image">Image for property:</label>
                <input type="file" name="image" id="file_thumb" accept="image/*">
            </div>

            <div class="row">
                <input type="submit" name="submit" id="entry-submit" value="Post">
            </div>
        </form>
    </div>
</div>
<script>
    $('#google_map').locationpicker({
        location: {latitude: 27.704145, longitude: 85.306464},
        radius: 300,
        inputBinding: {
            latitudeInput: $('#us2-lat'),
            longitudeInput: $('#us2-lon'),
            radiusInput: $('#us2-radius'),
            locationNameInput: $('#us2-address')
        }
    });
</script>
</body>
</html>