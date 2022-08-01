
function ajaxFailHandler(jqXHR, textStatus, errorThrown) {

    var problem = "";
    var err = eval("(" + jqXHR.responseText + ")");
    var problemDetail = "-";

    if (err.message != "") {
        problemDetail = err.message;
    }

    if (jqXHR.status === 0) {
        problem = "Not connect. Verify etwork.";
    } else if (jqXHR.status == 401) {
        toastr.error('Session Expired','Error');
        return false;
    } else if (jqXHR.status == 404) {
        problem = "Resource not found.";
    } else if (jqXHR.status == 409) {
        problem = "Conflict.";
    } else if (jqXHR.status == 419) {
        toastr.error('Session Expired','Error');
        return false;
    } else if (jqXHR.status === 422 ) {
        var errors = JSON.parse(jqXHR.responseText);
        var error_lists = '';
        $.each(errors, function (key, value) {
            if ($.isPlainObject(value)) {
                $.each(value, function (key, value) {
                    error_lists += '<li>' + value + '</li>'; 
                });
            }
        });
        toastr.error(error_lists,'Error');
        return false;
    } else if (jqXHR.status == 500) {
        problem = "Internal Server Error.";
    } else {
        problem = errorThrown;
    }

    toastr.error(`${jqXHR.status} - ${problem} - ${problemDetail}`,'Error');
}