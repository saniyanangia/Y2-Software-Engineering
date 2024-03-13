<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="css/Registration.css">
  <title>Log in</title>
</head>
<body>
<div class="container">
  <section id="content">
    <form id="loginForm" onsubmit="return false;" novalidate>
      <h1>Log in</h1>
      <div>
        <input type="text" name="userID" placeholder="Enter User ID" required id="username" />
        <p id="userIDError" class="errmsgs"></p>
      </div>
      <div>
        <input type="password" name="password" placeholder="Enter Password" required id="password" />
        <p id="passwordError" class="errmsgs"></p>
      </div>
      <div>
        <tr>
          <td>Domain： </td>
          <td><input type="radio" name="role" value="Admin" /> Admin <input type="radio" name="role" value="Volunteer" /> Volunteer</td>
        </tr>
        <p id="roleError" class="errmsgs"></p>
      </div>
      <div>
        <input type="submit" onclick="login()" value="Login" />
        <a href="RegistrationUI.php" style="margin-top: 22px;">Register</a>
        <a href="Landing_page.php" style="margin-top: 5px; float: left; margin-left: 11%;">Back to Home</a>
      </div>
    </form><!-- form -->
  </section><!-- content -->
</div><!-- container -->
<script type="text/javascript">
      document.querySelectorAll('input').forEach(function(fields) {
        fields.addEventListener('input', function(e){
          if (fields.checkValidity()) {
            displayErrorMessage(fields.name,"");
          }
        });
      });

      document.querySelectorAll(".errmsgs").forEach(function(p){
        p.style.color = 'red';
        p.style.width = '80%';
        p.style.margin = '0 10%';
        if(p.id=="roleError")
          p.style.marginLeft = '20%';
        else
          p.style.marginTop = '-10px';
        p.style.marginBottom = '10px';
        p.style.display = 'none';
        p.style.textAlign = 'left';
      });

      function login(){
        const loginForm = document.getElementById("loginForm");
        let loginData = new FormData(loginForm);
        document.querySelectorAll(".errmsgs").forEach(function(p){
          p.style.display = 'none';
        });

        fetch("/2006/Control/VerifyLogin.php", { method: 'POST', body: loginData }).then(function (response) {
          return response.json();
        }).then(function (result) {
          console.log(result)
          if(result.message==="Success"){
            let role = document.querySelector('input[name="role"]:checked').value;
            if(role==="Admin")
              window.location.href = "Admin_main.php";
            else if(role==="Volunteer")
              window.location.href = "Volunteer_main.php";
            else
              throw new Error("Unknown role");
          }else if(result.message==="Empty Fields"||result.message==="Wrong Inputs"){
            delete result.message;
            Object.keys(result).forEach(function(key){
              displayErrorMessage(key,result[key]);
            });
          }else{
            throw new Error(result.message);
          }
        }).catch(function(error){
          alert(error);
        });
      }

      function displayErrorMessage(field,message){
        let errField = document.getElementById(field+"Error");
        if(message.length===0){
            errField.style.display = 'none';
        }else{
            errField.style.display = 'block';
        }
        errField.innerHTML = message;
      }
</script>
</body>
</html>