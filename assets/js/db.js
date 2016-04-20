/**
 * Created by Deepak on 12/30/2015.
 */

var db = {};
db.url = "classes/crud.php";


db.getProject = function (parameters) {
    parameters.function = "getProject";
    parameters.userId = estate.userId;
    this.sendRequest(parameters);
};

db.addProject = function (parameters) {
    parameters.function = "addProject";
    parameters.userId = estate.userId;
    this.sendRequest(parameters);
};

db.sendRequest = function (parameters) {
    parameters = parameters || {};
    $.ajax({
        type: "post",
        data: parameters,
        cache: false,
        url: this.url,
        dataType: "json",
        error: function (request, error) {
            console.log(error);
            if (parameters.onError !== undef)
                parameters.onError(error);
        },
        success: function (data) {
            if (parameters.onSuccess !== undef)
                parameters.onSuccess(data);
        }
    });

    /*    var dbXHR = $.get("assets/php/ajax.php", function () {
     console.log("success");
     })
     .done(function () {
     console.log("second success");
     })
     .fail(function () {
     console.log("error");
     })
     .always(function () {
     console.log("finished");
     });

     // Perform other work here ...

     // Set another completion function for the request above
     dbXHR.always(function () {
     console.log("second finished");
     });*/
};