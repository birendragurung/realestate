<?php
	// //display form
	// include_once "config.php";
	// include_once ROOT . "helpers/html.php";
	// include_once ROOT . "classes/crud.php";
	// $crud = new Crud();
	// if (isset($_POST['submit'])){
		// 	if ($crud->create()){
		// 	echo 'data successfully inserted';
		// 	}
		// 	else{
			// 		echo 'failed to insert data';
		// 	}
	// }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>CRUD form</title>
		<link rel="stylesheet" href="assets/css/style.css">
		<script src="assets/js/libs/jquery.js"></script>
		<script src="assets/js/estate.js"></script>
		<script src="assets/js/db.js"></script>
	</head>
	<body>
		<div class="main-body">
			<div class="col-left">
				<div id = "main">
					<div id="data-entry">
					<!-- <form id="imageUploadForm" action="classes/crud.php" method="post"> -->
						<label for="property_name">Property Name:</label><input id= "entry-name"	type="text" name="property_name" ><br><br>
						<label for="description">Description:</label><input id= "entry-description" type="text" name="description"><br><br>
						<label for="address">Address:</label><input id="entry-address" type="text" name="address"><br><br>
						<label for="price">Price:</label><input id="entry-price" type="text" name="price"><br><br>
						<label for="entry-image">Image for property</label><input type="file" name="property-image"  id = "file_thumb" accept="image/*"><br><br>
						<input type="submit" name="submit" id="entry-submit" value="Post">
					<!-- </form> -->
					</div>
				</div>
			</div>
			<div class="col-right" id="data-content">

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

			function projectToTable(data) {
			    var projects = data; //JSON.parse(data);
			    var table = $("<div id = 'data-content'>");
			    var tableHead = $("<thead>");
			    for (var i = 0; i < projects.length; i++) {
			        var project = projects[i];
			        var output = html_div(html_div(project['name']) + html_div(project['description']) + html_div(project['address']) + html_div(project['price']) + html_div(project['created_at']) + html_div(project['updated_at']) + html_div(project['author']), "data-property-div");

			        output = $(output);

			        var thumb = $('<img>');

			        thumb.attr('src', 'http://localhost/realestate/uploads/' + project['image']);
			        output.append(thumb);
			        table.append(output.css({
			            backgroundImage: "url('http://localhost/realestate/classes/crud.php?function=getImage&&id=" + project['id'] + "')"
			        }));
			    }
			    return table;
			}

			var curr_thumb = '';
			$(document).on('ready', function() {
			    var parameters = {
			        onSuccess: function(data) {
			                if (data == undef) {
			                    return;
			                }
			                $('#data-table').remove();
			                $('#data-content').append(projectToTable(data));
			            },
			            // onError: function(data){
			            // 	alert('error');
			            // }
			    };
			    db.getProject(parameters);
			    $('#entry-submit').on('click', function() {
			        var parameters = {
			            'entry-name': $('#entry-name').val(),
			            'entry-description': $('#entry-description').val(),
			            'entry-address': $('#entry-address').val(),
			            'entry-path': 'uploads/image.jpg',
			            'reload-data': true,
			            'thumb': curr_thumb,
			            'price': $('#entry-price'),
			            onSuccess: function(data) {
			                if (data == undef) {
			                    return;
			                }
			                $('#data-table').remove();
			                $('#data-content').append(projectToTable(data));
			            }
			        };
			        db.addProject(parameters);
			    });



			    $('#file_thumb').on('change', (function(e) {
			        e.preventDefault();
			        var files = this.files;
			        var file;
			        if (files.length) {
			            file = files[0];
			            file.upload = {
			                progress: 0,
			                total: file.size,
			                bytesSent: 0
			            };
			            console.log(file.size, file.size);
			            var fileReader;
			            fileReader = new FileReader;
			            fileReader.onload = (function(file) {
			                //return _this.createThumbnailFromUrl(file, fileReader.result, callback);
			                return function() {
			                    var img;

			                    img = document.createElement("img");
			                    img.onload = (function() {
			                        return function() {
			                            var targetHeight = 48;
			                            var targetWidth = 64;
			                            var ratio = img.width / img.height;
			                            if (ratio > 1) {
			                                targetWidth = ratio * 64;
			                            } else {
			                                targetHeight = 48 / ratio;
			                            }
			                            var scale = img.width / targetWidth;
			                            var canvas, ctx, thumbnail;
			                            canvas = document.createElement("canvas");
			                            ctx = canvas.getContext("2d");
			                            canvas.width = 64;
			                            canvas.height = 48;
			                            ctx.drawImage(img, (targetWidth - 64) * scale / 2, (targetHeight - 48) * scale / 2, 64 * scale, 48 * scale, 0, 0, 64, 48);
			                            curr_thumb = canvas.toDataURL("image/jpg", 0.95);
			                            // $('body').css("background-image", "url(" + curr_thumb + ")");
			                            // $('img').first().attr()
			                            // appRegistry.container.find("i img")[0].src = thumbnail;
			                            // appRegistry.container.find(".app-image").data("image", thumbnail);
			                            // appRegistry.container.find(".app-image").css("background-image", "url(" + thumbnail + ")");
			                            //console.log(targetWidth, targetHeight);
			                            //console.log((targetWidth - 120) * scale / 2, (targetHeight - 120) * scale / 2, 120 * scale, 120 * scale, 0, 0, 120, 120);
			                        };
			                    })();
			                    img.src = fileReader.result;
			                };
			            })(file);
			            fileReader.readAsDataURL(file);
			        }
			    }));

			}); 
		</script>
	</body>
</html>