$(document).ready(function () {
    $(document).on("submit", "form", function (e) {
        e.preventDefault();
        formname = $(this).attr("name");
        if (formname) {
            var dataobj = document.getElementById(formname);
            validate_method = "";
            v_status = true;
            validate_method = dataobj.getAttribute("data-validate_method");
            if (validate_method != null) {
                if (validate_method != "") {
                    v_status = window[ validate_method ]();
                    console.log(v_status);
                    
                }
            }
            fd = new FormData(this);
            page = $(this).attr('action');
            if (v_status) {
                callAjax(fd, page);
            }
        }
    });
});

function callAjax(fd, pg) {
    $.ajax({
        url: pg,
        type: "POST",
        dataType: "json",
        data: fd,
        contentType: false,
        processData: false,
        beforeSend: function () {
            $("button[type='submit']").attr('disabled', 'disabled');
            $("input[type='submit']").attr('disabled', 'disabled');
        },
        success: function (json) {
            if (json.res_code == 1) {
                callfunction(json);
            }
        },
        complete: function (json) {
            $("button[type='submit']").removeAttr('disabled');
            $("input[type='submit']").removeAttr('disabled');
        }
    });
}

function customAjax(pg, fd, res = false) {
    if (fd != "") {
        fd = JSON.parse(fd);
    }
    var ajaxreturn = $.ajax({
        url: pg,
        type: "POST",
        dataType: "json",
        data: fd,
        success: function (json) {
            if (json.res_code == 1) {
                if (!res) {
                    callfunction(json);
                }
                window.cal_data_date = {
                    validate: undefined
                };
            }
        },
        error: function (request, status, error) {
            window.cal_data_date = {
                validate: 1
            };
        }
    });
    if (res) {
        return ajaxreturn;
    }
}

function callfunction(data) {
    window[data.method](data);
}

function RegSuccMsg(data) {
    swal({
        title: "Information",
        text: data.message,
        type: "success",
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then(function () {
        location.reload(true);
    })
}

function redirect_with_msg(data) {
    swal({
        title: data.title,
        text: data.message,
        type: data.type,
        allowOutsideClick: false
    }).then(function () {
        window.location = data.link;
    })
}

function error_message(data) {
    swal({
        title: data.title,
        html: data.message,
        type: data.type,
        allowOutsideClick: false
    });
}