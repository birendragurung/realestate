<?php
	include_once "php/config.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>CRUD form</title>
		<link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="assets/css/normalize.css">
		<script src="assets/js/libs/jquery.js"></script>
		<script src="assets/js/estate.js"></script>
		<script src="assets/js/libs/db.js"></script>
	</head>
	<body>
		<div class="main-body">
			<div class="home-search">
				<div id = "main">
					<div id="data-entry">
					<!-- <form id="imageUploadForm" action="classes/crud.php" method="post"> -->
						<div class="row">
							<label for="property_name">Property Name:</label>
							<input id= "entry-name"	type="text" name="property_name" >
						</div>

						<div class="row">
							<label for="description">Description:</label>
							<input id= "entry-description" type="text" name="description">
						</div>

						<div class="row">
							<label for="address">Address:</label>
							<input id="entry-address" type="text" name="address">
						</div>
						
						<div class="row">
							<label for="price">Price:</label>
							<input id="entry-price" type="text" name="price">
						</div>

						<div class="row">
							<label for="entry-image">Image for property:</label>
							<input type="file" name="property-image"  id = "file_thumb" accept="image/*">
						</div>

						<div class="row">
							<input type="submit" name="submit" id="entry-submit" value="Post">
						</div>
					<!-- </form> -->

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
			    var table = $("<div id = 'data-content'>");
//			    var tableHead = $("<thead>");
			    for (var i = 0; i < projects.length; i++) {
			        var project = projects[i];
			        var output = html_div(html_div(project['name']) + html_div(project['description']) + html_div(project['address']) + html_div(project['price']) , "data-property-div");

			        output = $(output);
			        output.attr("title" , project['name'] + " , " + project['description'] + " , " + project['address'] );
			        // var thumb = $('<img>');
			        var anchorTag = $('<a>');
			        anchorTag.attr("href" , "www.facebook.com");
			        // thumb.attr('src', 'http://localhost/realestate/uploads/' + project['image']);
//			        var project_img = '';
			        // output.append(thumb);
			        table.append(output.css({
			            backgroundImage: 'url(http://localhost/realestate/uploads/' + project['image'] + ')'
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
			                // $('#data-content').remove();
			                $('#data-content').html(projectToTable(data));
			            },
			            // onError: function(data){
			            // 	alert('error');
			            // }
			    };
			    db.getProject(parameters);
			    $('#entry-submit').on('click',
			    	function() {
				        var parameters = {
				            'entry-name'		: $('#entry-name').val(),
				            'entry-description'	: $('#entry-description').val(),
				            'entry-address'		: $('#entry-address').val(),
				            'entry-path'		: 'uploads/image.jpg',
				            'reload-data'		: true,
				            'thumb'				: curr_thumb,
				            'price'				: $('#entry-price').val(),
				            onSuccess			: function(data) {/*  @parameter data is returned by server */
				                if (data == undef) {
				                    return;
				                }
				                // $('#data-content').remove();
				                $('#data-content').html(projectToTable(data));
				            }
				        };
				        if (parameters['entry-name'] == "" || parameters['entry-description'] == "" || parameters['entry-address'] == "" || parameters['entry-path'] == "" || parameters['price'] == "" ) { alert("Enter all input fields");  }
				        else{
					        db.addProject(parameters);
					    }
				    }
				);

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
			                            var targetHeight = 100;
			                            var targetWidth = 100;
			                            var ratio = img.width / img.height;
			                            if (ratio > 1) {
			                                targetWidth = ratio * 100;
			                            } else {
			                                targetHeight = 100 / ratio;
			                            }
			                            var scale = img.width / targetWidth;
			                            var canvas, ctx, thumbnail;
			                            canvas = document.createElement("canvas");
			                            ctx = canvas.getContext("2d");
			                            canvas.width = 100;
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