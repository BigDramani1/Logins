$(document).ready(function() {

    $('#username').focus(function() {
        $('#label0').show(400);
    })
    $('#username').focusout(function() {
        $('#label0').hide(400);
    })


    $('#firstname').focus(function() {
        $('#label1').show(400);
    })
    $('#firstname').focusout(function() {
        $('#label1').hide(400);
    })


    $('#lastname').focus(function() {
        $('#label2').show(400);
    })
    $('#lastname').focusout(function() {
        $('#label2').hide(400);
    })


    $('#location').focus(function() {
        $('#label3').show(400);
    })
    $('#location').focusout(function() {
        $('#label3').hide(400);
    })


    $('#password').focus(function() {
        $('#label4').show(400);
    })
    $('#password').focusout(function() {
        $('#label4').hide(400);
    })


    $('#repeatpassword').focus(function() {
        $('#label5').show(400);
    })
    $('#repeatpassword').focusout(function() {
        $('#label5').hide(400);
    })


    $('button').mouseenter(function() {
        $(this).css('background-color', 'rgb(118, 118, 228)')
        $(this).css('cursor', 'pointer');
    })

    $('button').mouseleave(function() {
        $(this).css('background-color', 'rgb(147, 147, 228)')
        $(this).css('cursor', 'pointer');
    })


    $('button').click(function() {
        $(this).css('border', 'none');
        $(this).css('outline', 'none');
    })


    // Form validation with ajax

    $('#username').keyup(function() {
        var username = $('#username').val().trim();
        $.post('signupdatabase.php', {
            username_: username
        }, function(data) {
            if (data == true) {
                setErrorFor('#invalidinput0', '#username', 'Username not unique');

            } else if (data == 2) {
                setErrorFor('#invalidinput0', '#username', 'Username must not be empty');

            } else {
                setSuccessFor('#invalidinput0', '#username');

            }

        });
    });

    $('#password').keyup(function() {
        var password = $('#password').val().trim();
        $.post('signupdatabase.php', {
            password_: password
        }, function(data) {
            if (data == true) {
                setErrorFor('#invalidinput4', '#password', 'Password not unique');

            } else if (data == 3) {
                setErrorFor('#invalidinput4', '#password', 'Password must not be empty');

            } else {
                setSuccessFor('#invalidinput4', '#password');

            }
        });
    });

    $('#firstname').keyup(function() {
        var firstname = $('#firstname').val().trim();
        $.post('signupdatabase.php', {
            firstname_: firstname
        }, function(data) {
            if (data == true) {
                setErrorFor('#invalidinput1', '#firstname', 'Field must not be empty');

            } else {
                setSuccessFor('#invalidinput1', '#firstname');


            }
        });
    });

    $('#lastname').keyup(function() {
        var lastname = $('#lastname').val().trim();
        $.post('signupdatabase.php', {
            lastname_: lastname
        }, function(data) {
            if (data == true) {
                setErrorFor('#invalidinput2', '#lastname', 'Field must not be empty');

            } else {
                setSuccessFor('#invalidinput2', '#lastname');

            }
        });
    });

    $('#location').keyup(function() {
        var location = $('#location').val().trim();
        $.post('signupdatabase.php', {
            location_: location
        }, function(data) {
            if (data == true) {
                setErrorFor('#invalidinput3', '#location', 'Field must not be empty');

            } else {
                setSuccessFor('#invalidinput3', '#location');


            }
        });
    });


    $('#repeatpassword').keyup(function() {
        var repeatpassword = $('#repeatpassword').val().trim();
        var password = $('#password').val().trim();
        $.post('signupdatabase.php', {
            repeatpassword_: repeatpassword
        }, function(data) {
            if (data == true) {
                setErrorFor('#invalidinput5', '#repeatpassword', 'Field must not be empty');

            } else if (repeatpassword != password) { //if password and repeated password do not match
                setErrorFor('#invalidinput5', '#repeatpassword', 'Password does not match');

            } else {
                setSuccessFor('#invalidinput5', '#repeatpassword');


            }
        });
    });

    $('#submit').click(function(e) {
        e.preventDefault();
        // Retrieve all values
        var username = $('#username').val().trim();
        var firstname = $('#firstname').val().trim();
        var lastname = $('#lastname').val().trim();
        var location = $('#location').val().trim();
        var repeatpassword = $('#repeatpassword').val().trim();
        var password = $('#password').val().trim();
        var submit = $('#submit').val();
        //If any any field is empty
        if (username == '' ||
            firstname == '' ||
            lastname == '' ||
            location == '' ||
            password == '' ||
            repeatpassword == '') {
            setErrorFor('#invalidinput0', '#username', 'Username must not be empty and must be unique');
            setErrorFor('#invalidinput4', '#password', 'Password must not be empty');
            setErrorFor('#invalidinput1', '#firstname', 'Field must not be empty');
            setErrorFor('#invalidinput2', '#lastname', 'Field must not be empty');
            setErrorFor('#invalidinput3', '#location', 'Field must not be empty ');
            setErrorFor('#invalidinput5', '#repeatpassword', 'Field must not be empty and must match');
        } else {
            $.post('signupdatabase.php', {
                submit_: submit,
                username_: username,
                firstname_: firstname,
                lastname_: lastname,
                location_: location,
                password_: password,
                repeatpassword_: repeatpassword
            }, function(data) {
                if (data == true) {
                    setErrorFor('#invalidinput0', '#username', 'Username must not be empty and must be unique');
                    setErrorFor('#invalidinput4', '#password', 'Password must not be empty');
                    setErrorFor('#invalidinput1', '#firstname', 'Field must not be empty');
                    setErrorFor('#invalidinput2', '#lastname', 'Field must not be empty');
                    setErrorFor('#invalidinput3', '#location', 'Field must not be empty ');
                    setErrorFor('#invalidinput5', '#repeatpassword', 'Field must not be empty and must match');
                } else if (data == false) {
                    setSuccessFor('#invalidinput0', '#username');
                    setSuccessFor('#invalidinput4', '#password');
                    setSuccessFor('#invalidinput1', '#firstname');
                    setSuccessFor('#invalidinput2', '#lastname');
                    setSuccessFor('#invalidinput3', '#location');
                    setSuccessFor('#invalidinput5', '#repeatpassword');
                    window.location.href = 'index.php'; //Should be changed to where index page is situated
                }

            });
        }
    });
});

// Write error message in id, set element ID border to red for error validation
function setErrorFor(errorID, elementID, message) {
    $(errorID).html(message);
    $(document).ready(function() {
        $(elementID).css('border-bottom', '2px solid red');
    });
}
// Set element ID border to green for successful validation
function setSuccessFor(errorID, elementID) {
    $(errorID).html('');
    $(elementID).css('border-bottom', '2px solid green');
}