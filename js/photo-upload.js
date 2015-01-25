$(document).ready(function(){

    //function to check file size before uploading.
    function beforeSubmit() {
        //check whether browser fully supports all File API
        if (window.File && window.FileReader && window.FileList && window.Blob) {

            if (!$('#imageInput').val()) //check empty input filed
            {
                $("#output").html("Input Field is empty. Please upload Image");
                return false
            }

            var fsize = $('#imageInput')[0].files[0].size; //get file size
            var ftype = $('#imageInput')[0].files[0].type; // get file type

            //console.log(ftype);


            //allow only valid image file types 
            switch (ftype) {
                case 'image/png':
                case 'image/gif':
                case 'image/jpeg':
                case 'image/pjpeg':
                case 'image/jpg':
                    break;
                default:
                    $("#output").html("<b>" + ftype + " is unsupported image type!</b>");
                    return false
            }

            //Allowed file size is less than 1 MB (1000000)
            if (fsize > 1000000) {
                $("#output").html("<b>" + fsize + "</b> Too big Image file! <br />Please reduce the size of your photo using an image editor.");
                return false
            }

            $('button#submit').hide(); //hide submit button
            $('#loading-img').show(); //show loading
            $("#output").html("");
        } else {
            //Output error to older browsers that do not support HTML5 File API
            $("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
            return false;
        }
    }

    function afterSubmit() {
        $('#loading-img').hide();
        $("#fileupload").html("File Successfully Uploaded");
        window.location.reload(true);
    }

    //options for ajax sumbit

    var options = {
        target: '#output', // target element(s) to be updated with server response 
        beforeSubmit: beforeSubmit, // pre-submit callback
        success: afterSubmit,
        resetForm: true // reset the form after successful submit 
    };

    //actual ajax submit
    $('#fileupload').submit(function() {
        $(this).ajaxSubmit(options);
        // return false to prevent standard browser submit and page navigation 
        return false;
    });

});