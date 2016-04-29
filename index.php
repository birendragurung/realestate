<?php 
	include_once "php/config.php";
	include_once "php/core/crud.php";
	include_once "php/helpers/html.php";
	$crud = new Crud();


// 	function parseProperty($dataResult){
// 		$output ="";
//             foreach ($dataResult as $key => $project) {

// $output  .= html_div(html_div($project['name']) . html_div($project['description']) . html_div($project['address']) . html_div($project['price']) , "class='data-property-div' style='background-image:url(" .UPLOADS_PATH. $project['img'].")'");

//         }
//         return $output;
// 	}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Real Estate</title>
    <link rel="stylesheet" href="<?php echo CSS_PATH . 'normalize.css'; ?>">
    <link rel="stylesheet" href="<?php echo CSS_PATH . 'style.css'; ?>">
</head>
<body>
<header>
    <div id="logo">Real Estate</div>
</header>
<div class="home-content">
    <div class="home-search">
        <div class="home-search-wrapper">
            <h3>Your home for real estate.</h3>
            <div class="search-container">
                <div id="search_type">
                    <select name="" id="">
                        <option value="buy">Buy</option>
                        <option value="rent">Rent</option>
                        <option value="sold">Recently Sold</option>
                    </select>
                </div>
                <div id="search_box">
               <form action="searchResult.php" method="get">
                    <input type="text" id="search_text" name="q">
                    <input type="submit" value="Search">
                </form>
                </div>
            </div>
        </div>
    </div>
    <div class="property-lists">
        <div class="property-list-wrapper">
            <h3>Recommended Properties</h3>
            <div class="property-list-wrapper" id="property_recommended_wrapper">
            <?php

            $projects = $crud->getPropertyBySql();
			echo parseProperty($projects);


            ?>
            </div>
        </div>
        <div class="property-list-wrapper">
            <h3>New Properties</h3>
            <div class="property-list" id="property_new">
                <?php

            $projects = $crud->getPropertyBySql("SELECT * FROM properties ORDER BY id LIMIT 5");
			echo parseProperty($projects);
                ?>
            </div>
        </div>
        <div class="property-list-wrapper">
            <h3>Properties For Sale</h3>
            <div class="property-list" id="property_sale">
            	
            	                <?php

            $projects = $crud->getPropertyBySql("SELECT * FROM properties ORDER BY id desc LIMIT 5");
			echo parseProperty($projects);
                ?>

            </div>
        </div>
        <!-- <div class="property-list-wrapper">
            <h3></h3>
            <div class="property-list" id="property_recommended"></div>
        </div>
        <div class="property-list-wrapper">
            <h3></h3>
            <div class="property-list" id="property_recommended"></div>
        </div> -->
    </div>

</div>
<footer>
	
</footer>
</body>
</html>