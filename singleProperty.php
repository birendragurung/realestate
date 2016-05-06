<?php
if (!defined("ROOT")) {
    include_once "php/config.php";
}
include_once HELPERS . "html.php";
$message = "";
if (isset($_GET) && isset($_GET['property-id'])) :
    $property_id = $_GET['property-id'];
    include_once "php/config.php";
    include_once "php/core/crud.php";
    $crud = new Crud();
    $sql = "SELECT * FROM properties WHERE id = {$property_id}";
    $propertyDetails = $crud->getPropertyBySql($sql);
    if ($propertyDetails == false) {
        $message = "Property not found";
    } else {
        $singleProperty = (object)$propertyDetails[0];
    }
    ?>
    <!DOCTYPE html >
    <html>
    <head>
        <meta charset="utf-8">
        <meta http - equiv="X-UA-Compatible" content="IE=edge">
        <title> Real Estate </title>
        <link rel="dns-prefetch" href="http://fonts.googleapis.com">
        <link rel="stylesheet" href="<?php echo CSS_PATH . 'normalize.css'; ?>">
        <link rel="stylesheet" href="<?php echo CSS_PATH . 'style.css'; ?>">
    </head>
    <body id="single_property">
        <?php getTemplate("header"); ?>
        <div id="single_property_wrapper">
            <?php
            if ($propertyDetails):
            ?>
            <div class="property-top-info-wrapper">
                <div class="box basic-info-box">
                    <div class="photo-map-container">
                        <div class="img-container"
                             style="background-image: url('.<?php echo "/uploads/" . $singleProperty->img; ?>' );">
                            <img src="<?php echo "./uploads/" . $singleProperty->img; ?>" style="visibility: hidden;"
                                 alt="Property image">
                        </div>
                        <div class="map-wrapper">

                        </div>
                    </div>
                </div>

                <div class="property-info-box">
                    <div class="top-property-info">
                        <span class="green upper-case">for sale</span>
                        <div class="row property-info-name">
                            <span><?php echo $singleProperty->name; ?></span>
                        </div>
                        <div class="row property-info-address">-
                            <span><?php echo $singleProperty->address; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <ul class="property-info-highlight-list">
                            <li>
                                <?php echo $singleProperty->price; ?>
                            </li>
                            <li>
                                <?php echo $singleProperty->home_type; ?>
                            </li>
                            <li>
                                Built in <?php echo $singleProperty->year_built; ?>
                            </li>
                            <li>
                                <?php echo $singleProperty->created_at; ?>
                            </li>
                            <li>
                                180+ days on Real Estate
                            </li>
                            <li>
                                $2,520/sqft
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="property-detail-wrapper">
                <h2>
                    Home Details for <span><?php echo $singleProperty->name; ?></span>
                </h2>
                <div class="property-detail-info">
                    <div class="row">
                        <div class="days-count">180+ Days on Trulia</div>
                        <div class="property-views-count">27,626 views</div>
                    </div>
                    <div class="property-full-description row">
                        <?php echo $singleProperty->home_description; ?>
                    </div>
                </div>
                <div class="property-listing-info">
                    <h3>Listing Info for <span><?php echo $singleProperty->name; ?></span></h3>
                    <div class="row">
                    <span class="last-updated">
                        Information last updated on <?php echo $singleProperty->updated_at; ?>
                    </span>
                        <ul>
                            <li>Price: <?php echo $singleProperty->price; ?></li>
                            <li><?php echo $singleProperty->home_type; ?></li>
                            <li>Status: For sale</li>
                            <li>Built in <?php echo $singleProperty->year_built; ?></li>
                            <li>No. of beds: <?php echo $singleProperty->no_of_beds; ?></li>
                            <li>Basement area: <?php echo $singleProperty->basement_area; ?></li>
                            <li>Finished square feet: <?php echo $singleProperty->finished_square_feet; ?></li>
                            <li>Lot size: <?php echo $singleProperty->lot_size; ?></li>
                            <li>Zip: 32907</li>
                            <li>neighbourhood: Butwal</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row property-request-info">
                <button>Request for more info</button>
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
        <?php getTemplate("footer"); ?>
    </body>
    </html>
    <?php
else:
    header("location:index.php");
endif;
