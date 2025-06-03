var cal_data_date = {
    validate: undefined
};

$(document).ready(function () {
    $(document).on("submit", "form", function (e) {
        formname = $(this).attr("name");
        var dataobj = document.getElementById(formname);
        skip = "true";
        skip = dataobj.getAttribute("data-skip");
        validate_method = "";
        v_status = true;
        validate_method = dataobj.getAttribute("data-validate_method");
        if (validate_method != null) {
            if (validate_method != "") {
                v_status = window[validate_method]();
            }
        }
        if (skip == 'true' || skip == null) {
            return;
        }
        e.preventDefault();
        fd = new FormData(this);
        page = $(this).attr('action');
        preventAjax = "1";
        if (v_status) {
            callAjax(fd, page);
        }
    });
});

function addLoader() {
    $('body').append('<div id="overlay">       <div id="loading">          <div id="RN_loader" class="uil-ellipsis-css" style="transform:scale(0.58);"><div class="ib"><div class="circle"><div></div></div><div class="circle"><div></div></div><div class="circle"><div></div></div><div class="circle"><div></div></div></div></div>       </div>        </div>');
}

function removeLoader() {
    $('#overlay').remove();
}


function createOption(data, firstOpt, value) {
    var setselected = "";
    var options = "";
    var options = options + "<option value='' " + setselected + ">" + firstOpt + "</option>";
    if (data.id == value) {
        setselected = "selected";
    }
    $.each(data, function (i, obj) {
        options += "<option value='" + obj.id + "' " + setselected + ">" + obj.name + "</option>";
    });
    return options;
}

function createOptionOnChange(data, firstOpt, selected_id) {
    var setselected = "";
    var options = "";
    var options = options + "<option value='' " + setselected + ">" + firstOpt + "</option>";
    $.each(data, function (i, obj) {
        if (obj.cmp_id == selected_id) {
            options += "<option value='" + obj.id + "' " + setselected + ">" + obj.name + "</option>";
        }
    });
    return options;
}

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
            addLoader();
        },
        success: function (json) {
            if (json.res_code == 1) {
                callfunction(json);
            }
        },
        complete: function (json) {
            removeLoader();
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

function empty(data) {
    if (typeof (data) == 'number' || typeof (data) == 'boolean') {
        return false;
    }
    if (typeof (data) == 'undefined' || data === null) {
        return true;
    }
    if (typeof (data.length) != 'undefined') {
        return data.length == 0;
    }
    var count = 0;
    for (var i in data) {
        if (data.hasOwnProperty(i)) {
            count++;
        }
    }
    return count == 0;
}

function validateYouTubeUrl(element) {
    var url = $(element).val();
    if (url != "") {
        if (url != undefined || url != '') {
            var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
            var match = url.match(regExp);
            if (match && match[2].length == 11) {
                $("#video_url").parent().removeClass("has-error").addClass("has-success");
                $("#video_url").siblings("label").addClass("show");
                document.getElementById('video_url_span').innerHTML = "";
                $("#video_url").val('https://www.youtube.com/embed/' + match[2] + '?autoplay=1&enablejsapi=1');
            } else {
                $("#video_url").parent().removeClass("has-success").addClass("has-error");
                $("#video_url").siblings("label").addClass("hide");
                $("#video_url_span").val('video_url_span');
                document.getElementById('video_url_span').innerHTML = "<b>Invalid <i class='fa fa-youtube'></i> Youtube link</b>";
            }
        }
    }
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
function RegSuccMsgNoReload(data) {
    swal("Information", data.message, "success").then(function () {
    });
}
function loginErrorMsg(data) {
    swal("Information", data.message, "error");
}
function redirect(data) {
    window.location = data.link;
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
function error_message_retun(data) {
    swal({
        title: data.title,
        html: data.message,
        type: data.type,
        allowOutsideClick: false
    });
    return data.validate;
}
function RegErrorMsg(data) {
    swal("Information", data.message, "error");
}
function RegErrorMsg_silent(data) {
    set_error_data(data.message);
}
function set_error_data(data) {
    $.each(data, function (key, value) {
        $('#error_' + key).html(value);
    });
}

function reload() {
    location.reload(true);
}

function getYears(monthCount) {
    function getPlural(number, word) {
        return number === 1 && word.one || word.other;
    }
    var months = {
        one: 'month',
        other: 'months'
    },
        years = {
            one: 'year',
            other: 'years'
        },
        m = monthCount % 12,
        y = Math.floor(monthCount / 12),
        result = [];
    y && result.push(y + ' ' + getPlural(y, years));
    m && result.push(m + ' ' + getPlural(m, months));
    return result.join(' and ');
}

function monthDiff(d1, d2) {
    var months;
    const monthDiff = d2.getMonth() - d1.getMonth();
    const yearDiff = d2.getYear() - d1.getYear();
    months = monthDiff + yearDiff * 12;

    return months <= 0 ? 0 : months;
}

function validate_due_form() {
    $('.styled').each(function () {
        $(this).rules("add", {
            required: true
        });
    });
    $('.remark').each(function () {
        $(this).rules("add", {
            required: true
        });
    });
}

function is_valid_date(d) {
    if (Object.prototype.toString.call(d) === "[object Date]") {
        if (isNaN(d.getTime())) {
            return false;
        } else {
            return true;
        }
    } else {
        return true;
    }
}

function format_date(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + (d.getDate()),
        year = d.getFullYear();
    return [year, month, day].join(',');
}

function emp_prefix(empcode, code) {
    var cnt = empcode.toString().length;
    switch (cnt) {
        case 1:
            var emp_code = code + "0" + empcode
            break;
        case 2:
            var emp_code = code + "" + empcode
            break;
        default:
            var emp_code = code + "" + empcode
            break;
    }
    return emp_code;
}

function get_company_code(value) {
    if (value == 1) {
        code = "XML";
    } else {
        code = "FAB";
    }
    return code;
}

function custSuccMsg(data) {
    swal({
        text: data.message,
        type: "success"
    }).then(function () {
        location.reload(true);
    });
}

function toast_redirect_with_msg(data) {
    $.jGrowl(data.message, {
        theme: 'bg-success',
        life: 2000,
        header: data.title,
        position: 'bottom-right',
        beforeOpen: function (e, m, o) {
            $("button").attr("disabled", "disabled")
        },
        close: function (e, m, o) {
            window.location = data.link;
        }
    });
}

function ToastRegSuccessMsg(data) {
    $.jGrowl(data.message, {
        header: data.title,
        position: 'bottom-right',
        theme: 'bg-success',
        close: function (e, m, o) {
            location.reload(true);
        }
    });
}

function ToastRegErrorMsg(data) {
    $.jGrowl(data.message, {
        header: data.title,
        position: 'bottom-right',
        theme: 'bg-danger'
    });
}

function ToastRegSuccNoReload(data) {
    $.jGrowl(data.message, {
        header: data.title,
        position: 'bottom-right',
        theme: 'bg-success'
    });
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function getMonday(d) {
    d = new Date(d);
    var day = d.getDay(),
        diff = d.getDate() - day + (day == 0 ? -6 : 1); // adjust when day is sunday
    return new Date(d.setDate(diff));
}

function timeSince(date) {
    var seconds = Math.floor((new Date() - date) / 1000);
    var interval = Math.floor(seconds / 31536000);
    if (interval > 1) {
        return interval + " years";
    }
    interval = Math.floor(seconds / 2592000);
    if (interval > 1) {
        return interval + " months";
    }
    interval = Math.floor(seconds / 86400);
    if (interval > 1) {
        return interval + " days";
    }
    interval = Math.floor(seconds / 3600);
    if (interval > 1) {
        return interval + " hours";
    }
    interval = Math.floor(seconds / 60);
    if (interval > 1) {
        return interval + " minutes";
    }
    return Math.floor(seconds) + " seconds";
}


function selectOption(data, dom) {
    $(dom).val(data).trigger('change');
}