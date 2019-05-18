/* Admin Services Section */
$(".form-control").focus(function () {
    $(this).css('resize', 'both');
});

let servicesList =  $(".services-list");
let hiddenList = $(".hidden-list");
for (let i =0; i < servicesList.length; i ++) {
    $(servicesList[i]).click(function () {
        $(hiddenList[i]).slideToggle();
    })
}

var modal = $("#myModal");
var modalDesc = $("#modal-desc");
var btnClose = $("#btn-close");
function errorData(error) {
    $(modal).fadeIn();
    $(modalDesc).html(error);
    $(btnClose).click(function () {
        $(modal).fadeOut();
    })
}
function successData(success) {
    $(modal).fadeIn();
    $(modalDesc).html(success);
    $(btnClose).click(function () {
        window.location.href = 'services.php';
    })
}

$("#data-form").submit(function (event) {
    event.preventDefault();
    var err = "";
    var check = 1;
    if($("#customFile").val() === "") {
        err = "<h3 class='error__content'>" + "Выберите файл!" + "</h3>";
        check = 0;
        errorData(err)
    }
    else if ($("#insert-title").val() === "") {
        err = "<h3 class='error__content'>"+"Заполните заголовок!"+"</h3>";
        check = 0;
        errorData(err)
    }
    else if ($("#insert-content").val() === "") {
        err =  "<h3 class='error__content'>"+"Заполните контент!"+"</h3>";
        check = 0;
        errorData(err);
    }
    if (check !== 0) {
        let formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "services_insert.php",
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                if (data['error']) {
                    errorData(data['error'][0])
                }
                if (data['success']) {
                    successData(data['success']);
                }
            }
        })
    }
});


var form = $(".form-list");
var imageList = $(".hidden");
for (let i = 0; i < $(form).length; i ++) {
    $(form[i]).submit(function (event) {
        event.preventDefault();
        var err = "";
        if($(imageList[i]).val() === "") {
            err = "<h3 class='error__content'>" + "Выберите файл!" + "</h3>";
            errorData(err);
        }
        else {
            let formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "services_insert.php",
                dataType: "JSON",
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (data) {
                    if (data['error']) {
                        errorData(data['error'][0])
                    }
                    if (data['success']) {
                        successData(data['success']);
                    }
                }
            })
        }
    });

}

var btnUpdate = $(".update-btn");
var btnDelete = $(".delete-btn");
var formData = $(".form-list-2");
var updateTitle = $(".update-title");
var updateContent = $(".update-content");
for (let i = 0; i < $(btnUpdate).length; i ++) {
    $(btnUpdate[i]).click(function (event) {
        event.preventDefault();
        var err = "";
        var check = 1;
        if ($(updateTitle[i]).val() === "") {
            err = "<h3 class='error__content'>"+"Заполните заголовок!"+"</h3>";
            check = 0;
            errorData(err)
        }
        else if ($(updateContent[i]).val() === "") {
            err =  "<h3 class='error__content'>"+"Заполните контент!"+"</h3>";
            check = 0;
            errorData(err);
        }
        if (check !== 0) {
            $.ajax({
                type: "POST",
                url: "services_update.php",
                dataType: "JSON",
                data: $(formData[i]).serialize() + "&action=update",
                success: function (data) {
                    if (data['error']) {
                        errorData(data['error'][0])
                    }
                    if (data['success']) {
                        successData(data['success']);
                    }
                }
            })
        }
    });

    $(btnDelete[i]).click(function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "services_update.php",
            dataType: "JSON",
            data: $(formData[i]).serialize() + "&action=delete",
            success: function (data) {
                if(data['error']) {
                    errorData(data['error'][0])
                }
                if(data['success']) {
                    successData(data['success']);
                }
            }
        })
    });
}







