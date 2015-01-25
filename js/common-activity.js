$(document).ready(function(){

    $('.form-group').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            var value = $("#query").val();
            var php_var = "<?php echo $_SESSION['username']; ?>"
            if (value == php_var) {
                location.reload(true);
            } else {
                $.ajax({
                    type: 'GET',
                    data: {
                        value: value
                    },
                    url: './php/searchUsername.php',
                    dataType: "json",
                    success: function(data) {
                        //console.log("data="+data);
                        for (a in data) {
                            b = data[a];
                            //console.log(b[0]);
                            if (!b[0]) {
                                alert("Username doesnot Exist");
                                return;
                            } else {
                                window.location.href = "select_profile.php?value=" + value;
                            }
                        }
                    }
                });

            }
        }
    });

    $('#query').autocomplete({
        source: './php/searchAutoComplete.php',
        minLength: 0,
        select: function(event, ui) {
            var value = ui.item.value;
            //console.log("va="+value);
            $("#button").click(function(event) {
                //console.log(id+value);
                var php_var = "<?php echo $_SESSION['username']; ?>"
                if (value == php_var) {
                    location.reload(true);
                } else {
                    window.location.href = "select_profile.php?value=" + value;
                }
            });
        }
    });

    $("#button").click(function(event) {
        //console.log(id+value);
        var value = $("#query").val();
        //console.log("value="+value);
        var php_var = "<?php echo $_SESSION['username']; ?>"
        if (value == php_var) {
            location.reload(true);
        } else {
            $.ajax({
                type: 'GET',
                data: {
                    value: value
                },
                url: './php/searchUsername.php',
                dataType: "json",
                success: function(data) {
                    //console.log("data="+data);
                    for (a in data) {
                        b = data[a];
                        //console.log(b[0]);
                        if (!b[0]) {
                            alert("Username doesnot Exist");
                            return;
                        } else {
                            window.location.href = "select_profile.php?value=" + value;
                        }
                    }
                }
            });

        }
    });

    $("button#signout").click(function(e) {
        location.href = "./logout.php";
    });

});