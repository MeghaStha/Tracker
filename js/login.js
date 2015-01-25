$(document).ready(function() {


    $("button#submit").click(function(event) {

        console.log("readhed here biplov yes");
        $.ajax({
            type: "POST",
            url: "./php/loginto.php",
            data: {
                username: $("#username").val(),
                password: $("#password").val()
            }
        });
    });

    $(document).mousemove(function(e) {
        TweenLite.to($('body'),
            .5, {
                css: {
                    backgroundPosition: "" + parseInt(event.pageX / 8) + "px " + parseInt(event.pageY / '12') + "px, " + parseInt(event.pageX / '15') + "px " + parseInt(event.pageY / '15') + "px, " + parseInt(event.pageX / '30') + "px " + parseInt(event.pageY / '30') + "px"
                }
            });
    });

});