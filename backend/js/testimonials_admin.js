function delete_data(id) {
    $.ajax({
        url: "testimonials_data.php",
        type: "POST",
        data: "id=" + id + "&action=delete",
        dataType: "JSON",
        success: function (data) {
            if(data.response === "success"){
                var success = ("<div class='alert alert-success' role='alert'>"+data.content+"</div>");
                $("#msg"+ id).append(success);
                location.reload();
            }else {
                var error = ("<div class='alert alert-danger' role='alert'>"+data.content+"</div>");
                $("#msg"+ id).append(error);
                $('#delete' + id).attr('disabled',true);
            }
        }
    })
}
function give_id(id) {
    var content = $("#content" + id).val();
    var authors = $("#authors" + id).val();
    if(content !== "" && authors !== "" && content == $("#content" + id).val().replace(/\s/g, "") &&content.length >2||content.length <15 && authors == $("#authors" + id).val().replace(/\s/g, "") &&authors.length >2||authors.length <150 ){
        $.ajax({
            url: "testimonials_data.php",
            type: "POST",
            data: "id=" + id + "&content=" + content + "&authors=" + authors + "&action=update",
            dataType: "JSON",
            success: function (response) {
                if(response.response === "success"){
                    var success = ("<div class='alert alert-success' role='alert'>"+response.content+"</div>");
                    $("#msg"+ id).append(success);
                    location.reload();
                }else{
                    var error = ("<div class='alert alert-danger' role='alert'>"+response.content+"</div>");
                    $("#msg"+ id).append(error);
                    $('#update_content' + id).attr('disabled',true);
                }
            }
        })
    }else{
        var error = ("<div class='alert alert-danger' role='alert'>error</div>");
        $("#msg"+ id).append(error);
        $('#update_content' + id).attr('disabled',true);
    }

}
$(document).ready(function (e) {
    $("#form").on('submit',(function(e) {
        e.preventDefault();
        $('#btn_image').attr('disabled',true);
        var content = $("#insert-content").val();
        var authors =  $("#actors").val();
        if (content == "" && authors == ""){
            $('#btn_image').attr('disabled',true);
        }else {
            $.ajax({
                url: "testimonials_data.php",
                type: "POST",
                data:  new FormData(this),
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData:false,
                success: function(data)
                {
                    $("#testimonials_div").append(data);
                    if(data.response === "Success"){
                        var success = ("<div class='alert alert-success' role='alert'>"+data.msg+"</div>");
                        $("#testimonials_div").append(success);
                        location.reload();
                    } else {
                        var error = ("<div class='alert alert-danger' role='alert'>"+data.msg+"</div>");
                        $("#testimonials_div").append(error);
                        $('#btn_testimonials').attr('disabled',true);
                    }
                }
            });
        }
    }));
});
$('#btn_image').prop("disabled", true);
var a=0;
$('#customFile').bind('change', function() {
    if ($('#btn_image').attr('disabled',false)){
        $('#btn_image').attr('disabled',true);
    }
    var ext = $('#customFile').val().split('.').pop().toLowerCase();
    if ($.inArray(ext, ['png','jpg','jpeg']) == -1){
        $('#error1').slideDown("slow");
        $('#error2').slideUp("slow");
        a=0;
    }else{
        var picsize = (this.files[0].size);
        if (picsize > 1000000){
            $('#error2').slideDown("slow");
            a=0;
        }else{
            a=1;
            $('#error2').slideUp("slow");
        }
        $('#error1').slideUp("slow");
        if (a==1){
            $('#btn_image').attr('disabled',false);
        }
    }
});
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#img_response')
                .attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function isset_id(id) {
    $("#id"+ id ).val(id);
    var id2 =  $("#id"+ id ).val();
    $(document).ready(function (e) {
        $("#form" + id2).on('submit',(function(e) {
            e.preventDefault();
            $.ajax({
                url: "testimonials_data.php",
                type: "POST",
                data: "id=" + id2 + "&action=id_data",
                dataType: "JSON",
                success: function(data)
                {}
            });
            $('#btn_update' + id2).attr('disabled',true);
            $.ajax({
                url: "testimonials_data.php",
                type: "POST",
                data:  new FormData(this),
                dataType: "JSON",
                contentType: false,
                cache: false,
                processData:false,
                success: function(responses)
                {
                    if(responses.response === "Success"){
                        var success = ("<div class='alert alert-success' role='alert'>"+responses.msg+"</div>");
                        $("#msg" + id2).append(success);
                        location.reload();
                    }else if(responses === "" || responses === null){
                        var errors = ("<div class='alert alert-danger' role='alert'>error</div>");
                        $("#msg" + id2).append(errors);
                        $('#btn_update' + id2).attr('disabled',true);
                    }
                    else{
                        var error = ("<div class='alert alert-danger' role='alert'>error</div>");
                        $("#msg" + id2).append(error);
                        $('#btn_update' + id2).attr('disabled',true);
                    }
                }
            });
        }));
    });
}
$(".update_content").click(function (e) {
    e.preventDefault();
});
$(".delete").click(function (e) {
    e.preventDefault();
});