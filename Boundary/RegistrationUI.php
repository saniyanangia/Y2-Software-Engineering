<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
<!--    personnel-->
    <link rel="stylesheet" type="text/css" href="css/Registration.css">
</head>
<body>
<div class="container" id="select_role">
    <section id="content">
            <h1>Registration</h1>
            <button type="button" class="btn btn-primary btn-lg btn-block" onclick="displayForm('Admin')">Admin</button>
            <button type="button" class="btn btn-primary btn-lg btn-block" onclick="displayForm('Volunteer')">Volunteer</button>
            <button type="button" class="btn btn-default btn-lg" style="width: 49%; margin: 5px 0 10px 0;" onclick="location.href='Landing_page.php'">Home</button>
            <button type="button" class="btn btn-default btn-lg" style="width: 49%; margin: 5px 0 10px 0;" onclick="location.href='LoginUI.php'">Log In</button>
    </section><!-- content -->
</div><!-- container -->
<div class="container" style="display: none;" id="show_form">
    <section id="content">
        <form onsubmit="return false;" id="registerForm" novalidate>
            <h1 id="form_title"></h1>
            <div>
                <input type="text" placeholder="Enter Email" required id="mail" name="email"/>
                <p id="emailError" class="errmsgs">hi</p>
            </div>
            <div>
                <input type="text" placeholder="" required id="username" name="userID" pattern="^[a-zA-Z0-9]*$" />
                <p id="userIDError" class="errmsgs"></p>
            </div>
            <div>
                <input type="password" placeholder="Enter Password" required id="password" name="password" pattern="(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*].{7,40}" minlength="8" maxlength="40" />
                <p id="passwordError" class="errmsgs"></p>
            </div>
            <div>
                <input type="submit" value="Register" onclick="register()" />
                <a href="Forget_Password.php">Lost your password?</a>
                <a href="javascript:;" onclick="displayForm('')"><p>Back</p></a>
            </div>
        </form><!-- form -->
    </section><!-- content -->
</div><!-- container -->
</body>

<script type="text/javascript">
    let role = "";

    document.querySelectorAll('input').forEach(function(fields) {
        fields.addEventListener('input', function(e){
            if(fields.name==="userID"&&role==="Admin"){
                fields.value = fields.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
            }
            if((fields.validity.patternMismatch||fields.validity.tooShort)&&fields.name==="password"){
                displayErrorMessage(fields.name,"Invalid Password");
            }else if (fields.name==="userID"&&role==="Volunteer"&&fields.value.length<8) {
                displayErrorMessage(fields.name,"Use 8 to 40 alphanumeric characters for your username");
            }else if (fields.checkValidity()) {
                displayErrorMessage(fields.name,"");
            }
        });
    });

    document.querySelectorAll(".errmsgs").forEach(function(p){
        p.style.color = 'red';
        p.style.width = '80%';
        p.style.margin = '0 10%';
        p.style.marginTop = '-10px';
        p.style.marginBottom = '10px';
        p.style.display = 'none';
        p.style.textAlign = 'left';
    });

    const registerForm = document.getElementById("registerForm");
    let inputUserID = document.getElementById("username");
    let inputUserPassword = document.getElementById("password");

    function displayForm(r){
        role = r;
        document.getElementById("show_form").style.display = 'block';
        document.getElementById("select_role").style.display = 'none';
        document.getElementById("form_title").innerHTML = role +" Registration";
        registerForm.reset();
        
        document.querySelectorAll(".errmsgs").forEach(function(p){
          p.style.display = 'none';
        });
        if(role=="Admin"){
            inputUserID.placeholder = "Enter Garden ID";
            inputUserID.removeAttribute('maxLength');
        }else if(role=="Volunteer"){
            inputUserID.placeholder = "Enter Username";
            inputUserID.maxLength = "40";
        }else{
            document.getElementById("show_form").style.display = 'none';
            document.getElementById("select_role").style.display = 'block';
        }
    }

    function register(){
        let registerData = new FormData(registerForm);
        registerData.append("role", role);
        document.querySelectorAll(".errmsgs").forEach(function(p){
            p.style.display = 'none';
        });
        fetch("/2006/Control/VerifyRegistration.php", { method: 'POST', body: registerData }).then(function (response) {
            return response.json();
        }).then(function (result) {
            console.log(result);
            if(result.message==="Success"){
                if(role==="Admin")
                    window.location.href = "Admin_main.php";
                else if(role==="Volunteer")
                    window.location.href = "Volunteer_main.php";
                else
                    throw new Error("Unknown role");
            }else if(result.message==="Invalid Inputs"||result.message==="Duplicate Value"){
                delete result.message;
                Object.keys(result).forEach(function(key){
                    if(key==="role"){
                        throw new Error(result(key));
                        location.reload();
                    }else if(key==="password"){
                        displayErrorMessage(key,"Invalid Password");
                    }else{
                        displayErrorMessage(key,result[key]);
                    }
                });
            }else{
                throw new Error(result.message);
            }
        }).catch(function(error){
            alert(error.message);
        });
    }           

    function displayErrorMessage(field,message){
        let errField = document.getElementById(field+"Error");
        if(message.length===0){
            errField.style.display = 'none';
        }else{
            errField.style.display = 'block';
            errField.autofocus = true;
        }
        if(message==="Invalid Password"){
            message = "Password must contain the following:<br>";
            message = message + "<p style='margin: 0; color: "+((/^(?=.*[a-z]).*$/.test(inputUserPassword.value))&&(/^(?=.*[A-Z]).*$/.test(inputUserPassword.value))?'rgb(254 193 81)':'red')+"'>At least one uppercase and lowercase"
            message = message + "<p style='margin: 0; color: "+((/^(?=.*[0-9]).*$/.test(inputUserPassword.value))?'rgb(254 193 81)':'red')+"'>At least one number</p>"
            message = message + "<p style='margin: 0; color: "+((/^(?=.*[!@#$%^&*]).*$/.test(inputUserPassword.value))?'rgb(254 193 81)':'red')+"'>At least one special character</p>"
            message = message + "<p style='margin: 0; color: "+((inputUserPassword.value.length<8)?'red':'rgb(254 193 81)')+"'>Minimum 8 characters</p>";
        }
        errField.innerHTML = message;
    }

</script>
</html>