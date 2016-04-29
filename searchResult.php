<?php
include_once "php/config.php";
include_once "php/core/crud.php";
//include_once ""



/**
 *
 *
 *
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Search Results</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/normalize.css">
    <script src="assets/js/libs/jquery.js"></script>
    <script src="assets/js/estate.js"></script>
    <script src="assets/js/libs/db.js"></script>
</head>
<body>
<header>
    <div id="logo">Real Estate</div>
</header>
<div class="main-body">
    <div class="home-search">
        <div id="search_box">
            <form action="searchResult.php" >
                <input type="text" id="search_text" name="q">
                <input type="submit">
                <!--                            <div class="search-button">Search</div>-->
            </form>

        </div>
        </div>
    </div>

    <div id="search_results" class=" property-lists">
        <div class="property-lists">
            <div class="property-list-wrapper">
                <h3>Search results</h3>
                <div class="property-list-wrapper" id="property_recommended_wrapper">
                    <?php
                    if (isset($_GET['q'])):
                        $output = '';
                        $search_text = $_GET['q'];
                        $crud = new Crud();
                        $sql = "SELECT * FROM properties WHERE name LIKE '%" . $search_text . "%' OR description LIKE '%" . $search_text . "%' OR address LIKE '%" . $search_text . "%'";
                        $projects = $crud->getPropertyBySql($sql);
                        echo parseProperty($projects);
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="property-lists" id="data-content">
        <div class="overlay"></div>
    </div>
</div>

<script>
    function table_td(value) {
        return "<td>" + value + "</td>";
    }

    function table_tr(value) {
        return "<tr>" + value + "</tr>";
    }

    function table_th(value) {
        return "<th>" + value + "</th>";
    }

    function html_div(value, divClass) {
        if (divClass) {
            return "<div class = " + divClass + " > " + value + "</div>";
        }
        return "<div>" + value + "</div>";
    }

    function splitArray(array) {

    }

    function projectToTable(data) {
        var projects = data; //JSON.parse(data);
        var div = $("<div id = 'data-content'>");
//        var tableHead = $("<thead>");
        for (var i = 0; i < projects.length; i++) {
            var project = projects[i];
            var output  = html_div(html_div(project['name']) + html_div(project['description']) + html_div(project['address']) + html_div(project['price']), "data-property-div");

            output = $(output);
            output.attr("title", project['name'] + " , " + project['description'] + " , " + project['address']);
            // var thumb = $('<img>');
            var anchorTag = $('<a>');
            anchorTag.attr("href", "www.facebook.com");
            // thumb.attr('src', 'http://localhost/realestate/uploads/' + project['image']);
//            var project_img = '';
            // output.append(thumb);
            div.append(output.css({
                backgroundImage: 'url(http://localhost/realestate/uploads/' + project['image'] + ')'
            }));
        }
        return div;
    }

    var curr_thumb = '';

    $(document).on('ready', function () {
        var parameters = {
            onSuccess: function (data) {
                if (data == undef) {
                    return;
                }
                // $('#data-content').remove();
                $('#data-content').html(projectToTable(data));
            }
            // onError: function(data){
            // 	alert('error');
            // }
        };
//        db.getProject(parameters);


        $('#search_submit').on('click', function () {
            var parameters = {
                'q'      : $('#search_text').val(),
                onSuccess: function (data) {
                    if (data == undef)
                        return;
                    $('#search_results').html(projectToTable(data));
                }
            };
            if (parameters['q'] == "")  alert("Enter a query string");
            else {
                console.log("dummy error");
                db.getSearchResults(parameters);
                $('#search_results').remove();
                $('#search_results').html(projectToTable(data));
            }

        })
        $('#entry-submit').on('click',
            function () {
                var parameters = {
                    'entry-name'       : $('#entry-name').val(),
                    'entry-description': $('#entry-description').val(),
                    'entry-address'    : $('#entry-address').val(),
                    'entry-path'       : 'uploads/image.jpg',
                    'reload-data'      : true,
                    'thumb'            : curr_thumb,
                    'price'            : $('#entry-price').val(),
                    onSuccess          : function (data) {/*  @parameter data is returned by server */
                        if (data == undef) {
                            return;
                        }
                        // $('#data-content').remove();
                        $('#data-content').html(projectToTable(data));
                    }
                };
                if (parameters['entry-name'] == "" || parameters['entry-description'] == "" || parameters['entry-address'] == "" || parameters['entry-path'] == "" || parameters['price'] == "") {
                    alert("Enter all input fields");
                }
                else {
                    db.addProject(parameters);
                }
            }
        );

        $('#file_thumb').on('change', (function (e) {
            e.preventDefault();
            var files = this.files;
            var file;
            if (files.length) {
                file        = files[0];
                file.upload = {
                    progress : 0,
                    total    : file.size,
                    bytesSent: 0
                };
                console.log(file.size, file.size);
                var fileReader;
                fileReader        = new FileReader;
                fileReader.onload = (function (file) {
                    //return _this.createThumbnailFromUrl(file, fileReader.result, callback);
                    return function () {
                        var img;

                        img        = document.createElement("img");
                        img.onload = (function () {
                            return function () {
                                var targetHeight = 100;
                                var targetWidth  = 100;
                                var ratio        = img.width / img.height;
                                if (ratio > 1) {
                                    targetWidth = ratio * 100;
                                } else {
                                    targetHeight = 100 / ratio;
                                }
                                var scale     = img.width / targetWidth;
                                var canvas, ctx;
                                canvas        = document.createElement("canvas");
                                ctx           = canvas.getContext("2d");
                                canvas.width  = 100;
                                canvas.height = 100;
                                ctx.drawImage(img, (targetWidth - 100) * scale / 2, (targetHeight - 100) * scale / 2, 100 * scale, 100 * scale, 0, 0, 100, 100);
                                curr_thumb = canvas.toDataURL("image/jpg", 5.95);
                                // $('body').css("background-image", "url(" + curr_thumb + ")");
                                // $('img').first().attr()
                                // appRegistry.container.find("i img")[0].src = thumbnail;
                                // appRegistry.container.find(".app-image").data("image", thumbnail);
                                // appRegistry.container.find(".app-image").css("background-image", "url(" + thumbnail + ")");
                                //console.log(targetWidth, targetHeight);
                                //console.log((targetWidth - 120) * scale / 2, (targetHeight - 120) * scale / 2, 120 * scale, 120 * scale, 0, 0, 120, 120);
                            };
                        })();
                        img.src    = fileReader.result;
                    };
                })(file);
                fileReader.readAsDataURL(file);
            }
        }));
    });
</script>
</body>
</html>