// onload functionalities
$(document).ready(function () {
    $('form').submit(false);
});

var template_id = "{{$template_id}}";

function signIn() {
    var userName = $('#userid').val();
    var pass = $('#passwordinput').val();
    
    if(userName === null || userName.length <= 0) {
        alert("Please enter user name");
        return;
    }
    if(pass === null || pass.length <= 0) {
        alert("Please enter password");
        return;
    }
    
    loginUser(userName, pass);
    /*var User = [userName, pass];
    var isSucceeded = false;

    if (userName != "" && pass != "") {
        var responseText = postDataSignIn(User);
        console.log(responseText.charAt(0));
        if (responseText == "\r\n\r\n            \r\n     \r\n1") {
            isSucceeded = true;
        }
        else {
            isSucceeded = false;
        }
    }

    if (isSucceeded) {
        $("#regformstatus").html('Successfully Logged In');
        $('#myModal').modal('hide')
        var redirectURL = "http://localhost/WebBuilder/index.php?username=" + userName + "&password=" + pass + "&isSuccess=" + isSucceeded;
        window.location.href = redirectURL;
    }
    else {
        $("#regformstatus").html('Error!Please try again');
        $('#myModal').modal('hide')
    }*/
}




function postDataSignIn(args, callback) {
    var http = new XMLHttpRequest();
    var url = "webbuilderservices/UserService.php";
    var params = "username=" + args[0] + "&password=" + args[1];
    http.open("POST", url, true);
    var res = null;
    //Send the proper header information along with the request
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.setRequestHeader("Content-length", params.length);
    http.setRequestHeader("Connection", "close");

    http.onreadystatechange = function () {//Call a function when the state changes.
        if (http.readyState == 4 && http.status == 200) {


            return http.responseText;


        }
    }
    http.send(params);
    res = http.onreadystatechange();
    return res;
}
/*
 * User Registraiton JS Secton
 */


function signUp() {
    var email = $('#Email').val();
    var name = $('#userid_reg').val();
    var pass = $('#password_reg').val();
    var retypepass = $('#reenterpassword').val();
    
    var user = [email, name, pass];

    if(!isValidEmailAddress(email)) {
        alert("Please enter a valid email address!!!");
        return;
    }
    if(name === null || name.length<=0){
        alert("Please enter your name properly!!!");
        return;
    }
    if(isValidUserName(name)) {
        alert("No space allowed in user name!!!");
        return;
    }
    if(pass === null || pass.length<=0){
        alert("Password cannot be empty!!!");
        return;
    }
    // if(email.contains())
    if (pass !== retypepass) {
        alert("Password doesn't match");
        return;
    }

    //postDataRegistration(user);
    registerUser(email, name, pass);
}

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
}

function isValidUserName(userName) {
    var pattern = new RegExp(/\s/g);
    return pattern.test(userName);
}

/*
 * Finds the base url of the current page
 * @returns {String}
 */
function getBaseUrl() {
    var getUrl = window.location;
    var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    return baseUrl;
}


function getUserServiceUrl() {
    return getBaseUrl()+'/manager/user_manager/user_service.php';
}

function loginUser(userNameEmail, pass) {
    var url = getUserServiceUrl();
    
    $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {emailorusername: userNameEmail, pass: pass, signin:true},
            success: function (obj, textstatus) {
                //hideSavingIcon();
                if (!('error' in obj)) {
                    //yourVariable = obj.result;
                    if(obj.success === '1') {
                        //alert('Sign in successfull!!!');
                        $('#myModal').modal('hide');
                        
                        var redirectURL = getBaseUrl();
                        window.location.href = redirectURL;
                    } else {
                        alert('Error occured during sign in!!!');
                    }
                }
                else {
                    //console.log(obj.error);
                    alert('Error: ' + obj.error);
                }
            },
            error: function(xhr, status, error) {
                var responseText =  xhr.responseText;
                var sts = status;
                var err = error.message;
                alert(sts+': '+err);
            }
        });
}

function registerUser(email, name, pass) {
    var url = getUserServiceUrl();
    $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {email: email, name: name, pass: pass, register:true},
            success: function (obj, textstatus) {
                //hideSavingIcon();
                if (!('error' in obj)) {
                    //yourVariable = obj.result;
                    if(obj.savedUserID === '1') {
                        alert('Registered Successfully!!!');
                        window.location.href = redirectURL;
                        $('#myModal').modal('hide');
                    } else {
                        alert('Error occured during registering!!!');
                    }
                }
                else {
                    //console.log(obj.error);
                    alert('Error: ' + obj.error);
                }
            },
            error: function(xhr, status, error) {
                var err =  xhr.responseText;
                alert(err);
            }
        });
}
function  postDataRegistration(arguments) {
    var http = new XMLHttpRequest();
    var url = "manager/user_manager/save_user_data.php";
    var params = "email=" + arguments[0] + "&name=" + arguments[1] + "&password=" + arguments[2];
    http.open("POST", url, true);


    //Send the proper header information along with the request
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.setRequestHeader("Content-length", params.length);
    http.setRequestHeader("Connection", "close");

    http.onreadystatechange = function () {//Call a function when the state changes.
        if (http.readyState == 4 && http.status == 200) {


            alert("Registration Complete. Check email to activate !");
            // ShowStatus("Registration Complete. Check email to activate !");

//                               /    document.getElementById("regformstatus").innerHTML=http.responseText;


        }
    }

    http.send(params);
}


function logout() {
    var url = getUserServiceUrl();
    
    $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {logout:true},
            success: function (obj, textstatus) {
                //hideSavingIcon();
                if (!('error' in obj)) {
                    //yourVariable = obj.result;
                    if(obj.success === '1') {
                        //alert('Successfully logged out!!!');
                        $('#myModal').modal('hide');
                        
                        var redirectURL = getBaseUrl();
                        window.location.href = redirectURL;
                    } else {
                        alert('Error occured during logout!!!');
                    }
                }
                else {
                    //console.log(obj.error);
                    alert('Error: ' + obj.error);
                }
            },
            error: function(xhr, status, error) {
                var err =  xhr.responseText;
                alert(err);
            }
        });
}

function onEnterKeyPress(e, type) {
    if(e.keyCode === 13){
        //alert("Enter was pressed was presses");
        switch(type) {
            case 'signin':
                signIn();
                break;
            case 'register':
                signUp();
                break;
            default:
                break;
        }
    }
    return false;
}