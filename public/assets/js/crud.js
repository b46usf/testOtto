$(".btn-save").click(function (event) {
    event.preventDefault();
    if ($(this).text() == "Edit") {
        $("form").find("input, select, textarea").prop("disabled", false);
        $(this).text("Save");
    } else {
        var form = $("form");
        if (form[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            event.preventDefault();
            save(form.attr("id"));
        }
        form.addClass("was-validated");
    }
});

function save(idform) {
    var getUrl = window.location;
    var urLoc = getUrl.pathname.split("/")[3];
    var dataParam = new FormData($("#" + idform)[0]);
    if (urLoc == "edit") {
        var action = "/pegawai/" + getUrl.pathname.split("/")[2];
        dataParam.append("_method", "PATCH");
    } else {
        var action = "/pegawai";
        dataParam.append("_method", "POST");
    }
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: action,
        data: dataParam,
        type: "post",
        dataType: "json",
        processData: false,
        contentType: false,
        success: function (response) {
            if (confirm(response.success + " " + response.message)) {
                location.href = response.location;
            }
        },
        error: function (xhr, status, error) {
            console.log(error);
            console.log(status);
            console.log(xhr);
        },
    });
}

$(document).on("click", ".btn-delete", function (event) {
    event.preventDefault();
    var dataParam = $(this).data("id");
    var url = "/Pegawai/" + dataParam;
    var action = url;
    deldata(dataParam, action);
});

function deldata(dataParam, action) {
    if (confirm("Data Pegawai " + dataParam + " Akan Dihapus")) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: action,
            data: { dataID: dataParam, _method: "DELETE" },
            type: "post",
            dataType: "json",
            success: function (response) {
                location.href = response.location;
            },
            error: function (xhr, status, error) {
                console.log(error);
                console.log(status);
                console.log(xhr);
            },
        });
    }
}

function trashed(dataParam, action, text) {
    if (confirm("Data Pegawai " + dataParam + " Will Be " + text)) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: action,
            data: { dataID: dataParam },
            method: "post",
            dataType: "json",
            success: function (response) {
                location.href = response.location;
            },
            error: function (xhr, status, error) {
                console.log(error);
                console.log(status);
                console.log(xhr);
            },
        });
    }
}

$(document).ready(function () {
    if (window.location.pathname.split("/")[3] == "edit") {
        $("form input").prop("disabled", true);
        $(".btn-save").addClass("btn-edit");
        $(".btn-save").text("Edit");
    }
    $("#" + window.location.pathname.split("/")[2]).addClass("active");
    if (window.location.pathname.split("/")[2] == "total") {
        $("#param1").html("Total Cuti");
        $("#param2").html("Total Hari");
    }
    if (window.location.pathname.split("/")[2] == "sisa") {
        $("#param1").html("Total Cuti/Hari");
        $("#param2").html("Sisa Cuti/Hari");
    }
});

$("a").click(function (event) {
    event.preventDefault();
    if ($(this).text() == "Edit") {
        if ($(this).data("type") == "editPegawai") {
            location.href = $(this).data("id") + "/" + $(this).data("action");
        }
    } else if ($(this).text() == "Delete") {
        if ($(this).data("type") == "deletePegawai") {
            deldata($(this).data("id"), $(this).data("action"));
        }
    } else {
        if (
            $(this).text() == "Restore" ||
            $(this).text() == "Permanent Delete"
        ) {
            trashed($(this).data("id"), $(this).data("action"), $(this).text());
        } else {
            location.href = $(this).data("action");
        }
    }
});
