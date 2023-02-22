<!DOCTYPE html>
<html>

<head>
    <title>Offeyicial</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="js/jquery.min.js"></script>
    <script src="country-states.js"></script>
    <link rel="icon" href="img\offeyicial.jpeg" type="image/jpeg" sizes="32x32" />


    <style>
        @media (max-width: 500px) {
            body {
                font-size: 12px;
            }
        }
        
        body {
            font-family: montserrat;
            font-size: 14px;
            background-image: url(img/bg.jpeg);
            background-size: cover;
        }
        
        .form_wrapper {
            background: transparent;
            width: 100%;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
        
        .form_container {
            /* border: 2px solid blue; */
            padding: 1cm;
            /* background-image: url(img/connecting_users.jpg); */
            background: transparent;
        }
        
        .title_container {
            margin-bottom: 20px;
        }
        
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .form-group label {
            width: 100px;
            font-weight: bold;
            margin-right: 10px;
            color: white;
        }
        
        .form-group input {
            flex-grow: 1;
            padding: 10px;
            border-radius: 5px;
            border: none;
            box-shadow: 2px 2px 2px #198754;
        }
        .form-group select {
            padding: 10px;
            border-radius: 10px;
            border: none;
            box-shadow: 2px 2px 2px #198754;
        }
        
        .form-group input[type="checkbox"] {
            margin-left: 10px;
            border: 2px
        }
        
        .form-inline {
            display: flex;
            flex-flow: row wrap;
            align-items: center;
        }
        
        .form-inline label {
            margin: 0 5px 0 0;
        }
        
        .form-inline input,
        .form-inline select {
            flex: 1;
            margin-bottom: 5px;
        }
        
        .form-inline .form-group {
            display: flex;
            align-items: center;
        }
        
        .form-inline .form-control {
            width: 100%;
        }
        
        .form_wrapper {
            width: 100%;
            margin: auto;
            /* border-top: linear-gradient(to bottom, #0066ff 0%, #ffff66 100%);
            border-bottom: linear-gradient(to bottom, #0066ff 0%, #ffff66 100%);
            border-left: linear-gradient(to bottom, #0066ff 0%, #ffff66 100%);
            border-right: linear-gradient(to bottom, #0066ff 0%, #ffff66 100%);
            border-style: groove;
            box-sizing: border-box; */
        }
        
        .Submit {
            background-color: blue;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            cursor: not-allowed;
            width: 100px;
            border: groove blue;
        }
        
        .form_wrapper input[type=reset] {
            background-color: green;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -ms-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
            border: groove #198754;
        }
        
        .form_wrapper input[type=submit]:hover {
            background: #01fa0e;
        }
        
        .form_wrapper input[type=submit]:focus {
            background: #01fa0e;
        }
        
        .form_wrapper input[type=reset]:hover {
            background: tomato;
        }
        
        .form_wrapper input[type=reset]:focus {
            background: #e1a70a;
        }
        
        .form-group input[type="password"] {
            position: relative;
        }
        
        .form-group input[type="checkbox"] {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        
        .show-password-btn {
            font-size: 12px;
            padding: 3px 6px;
        }
        
        button.container {
            font-size: 0.8em;
            /* make the font smaller */
            padding: 2px;
            /* reduce the size of the button */
            width: 50px;
        }
        
        h2 {
            color: white;
            /* sets text color to red */
            font-size: 50px;
            /* sets font size to 20px */
            text-align: center;
            /* centers the text */
            background: transparent;
        }
        /* Position the icon at the top left corner of the page */
        
        .icon {
            float: left;
            margin-top: 10px;
            margin-left: 10px;
            width: 50px;
            length: 50px;
        }
        
        .form_wrapper input[type=checkbox],
        .form_wrapper input[type=radio] {
            border: 0;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }
        
        .form_container .row .col_half.last {
            border-left: 1px solid #cccccc;
        }
        
        .checkbox_option label {
            margin-right: 1em;
            height: 40px;
            padding: 3px;
            position: relative;
        }
        
        .checkbox_option label:before {
            content: "";
            display: inline-block;
            width: 0.5em;
            height: 0.5em;
            margin-right: 0.5em;
            vertical-align: -2px;
            border: 2px solid #cccccc;
            padding: 0.12em;
            background-color: transparent;
            background-clip: content-box;
            transition: all 0.2s ease;
        }
        
        .checkbox_option label:after {
            border-right: 2px solid #000000;
            border-top: 2px solid #000000;
            content: "";
            height: 20px;
            left: 2px;
            position: absolute;
            top: 7px;
            transform: scaleX(-1) rotate(135deg);
            transform-origin: left top;
            width: 7px;
            display: none;
        }
        
        .checkbox_option input:hover+label:before {
            border-color: #000000;
        }
        
        .checkbox_option input:checked+label:before {
            border-color: #000000;
        }
        
        .checkbox_option input:checked+label:after {
            -moz-animation: check 0.8s ease 0s running;
            -webkit-animation: check 0.8s ease 0s running;
            animation: check 0.8s ease 0s running;
            display: block;
            width: 7px;
            height: 20px;
            border-color: #000000;
        }
        
        .radio_option label {
            margin-right: 1em;
        }
        
        .radio_option label:before {
            content: "";
            display: inline-block;
            width: 0.5em;
            height: 0.5em;
            margin-right: 0.5em;
            border-radius: 100%;
            vertical-align: -3px;
            border: 2px solid #cccccc;
            padding: 0.15em;
            background-color: transparent;
            background-clip: content-box;
            transition: all 0.2s ease;
        }
        
        .radio_option input:hover+label:before {
            border-color: #000000;
        }
        
        .radio_option input:checked+label:before {
            background-color: #000000;
            border-color: #000000;
        }
        
        .select_option {
            position: relative;
            width: 100%;
        }
        
        .select_option select {
            display: inline-block;
            width: 100%;
            height: 35px;
            padding: 0px 15px;
            cursor: pointer;
            color: #7b7b7b;
            border: 1px solid #cccccc;
            border-radius: 0;
            background: #fff;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            transition: all 0.2s ease;
        }
        
        .select_option select::-ms-expand {
            display: none;
        }
        
        .select_option select:hover,
        .select_option select:focus {
            color: #000000;
            background: #fafafa;
            border-color: #000000;
            outline: none;
        }
        
        .select_arrow {
            position: absolute;
            top: calc(50% - 4px);
            right: 15px;
            width: 0;
            height: 0;
            pointer-events: none;
            border-width: 8px 5px 0 5px;
            border-style: solid;
            border-color: #7b7b7b transparent transparent transparent;
        }
        
        .select_option select:hover+.select_arrow,
        .select_option select:focus+.select_arrow {
            border-top-color: #000000;
        }
        
        .credit {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 15px;
            color: #f5ba1a;
        }
        
        .credit a {
            color: #e1a70a;
        }
        
        @-webkit-keyframes check {
            0% {
                height: 0;
                width: 0;
            }
            25% {
                height: 0;
                width: 7px;
            }
            50% {
                height: 20px;
                width: 7px;
            }
        }
        
        @keyframes check {
            0% {
                height: 0;
                width: 0;
            }
            25% {
                height: 0;
                width: 7px;
            }
            50% {
                height: 20px;
                width: 7px;
            }
        }
        
        @-webkit-keyframes expand {
            0% {
                -webkit-transform: scale3d(1, 0, 1);
                opacity: 0;
            }
            25% {
                -webkit-transform: scale3d(1, 1.2, 1);
            }
            50% {
                -webkit-transform: scale3d(1, 0.85, 1);
            }
            75% {
                -webkit-transform: scale3d(1, 1.05, 1);
            }
            100% {
                -webkit-transform: scale3d(1, 1, 1);
                opacity: 1;
            }
        }
        
        @keyframes expand {
            0% {
                -webkit-transform: scale3d(1, 0, 1);
                transform: scale3d(1, 0, 1);
                opacity: 0;
            }
            25% {
                -webkit-transform: scale3d(1, 1.2, 1);
                transform: scale3d(1, 1.2, 1);
            }
            50% {
                -webkit-transform: scale3d(1, 0.85, 1);
                transform: scale3d(1, 0.85, 1);
            }
            75% {
                -webkit-transform: scale3d(1, 1.05, 1);
                transform: scale3d(1, 1.05, 1);
            }
            100% {
                -webkit-transform: scale3d(1, 1, 1);
                transform: scale3d(1, 1, 1);
                opacity: 1;
            }
        }
        
        @-webkit-keyframes bounce {
            0% {
                -webkit-transform: translate3d(0, -25px, 0);
                opacity: 0;
            }
            25% {
                -webkit-transform: translate3d(0, 10px, 0);
            }
            50% {
                -webkit-transform: translate3d(0, -6px, 0);
            }
            75% {
                -webkit-transform: translate3d(0, 2px, 0);
            }
            100% {
                -webkit-transform: translate3d(0, 0, 0);
                opacity: 1;
            }
        }
        
        @keyframes bounce {
            0% {
                -webkit-transform: translate3d(0, -25px, 0);
                transform: translate3d(0, -25px, 0);
                opacity: 0;
            }
            25% {
                -webkit-transform: translate3d(0, 10px, 0);
                transform: translate3d(0, 10px, 0);
            }
            50% {
                -webkit-transform: translate3d(0, -6px, 0);
                transform: translate3d(0, -6px, 0);
            }
            75% {
                -webkit-transform: translate3d(0, 2px, 0);
                transform: translate3d(0, 2px, 0);
            }
            100% {
                -webkit-transform: translate3d(0, 0, 0);
                transform: translate3d(0, 0, 0);
                opacity: 1;
            }
        }
        
        @media (max-width: 600px) {
            .form_wrapper .col_half {
                width: 100%;
                float: none;
            }
            .bottom_row .col_half {
                width: 50%;
                float: left;
            }
            .form_container .row .col_half.last {
                border-left: none;
            }
            .remember_me {
                padding-bottom: 20px;
            }
        }
        /*  */
        
        .input_field input {
            width: 100%;
            padding: 15px;
            font-size: 17px;
            padding-right: 50px;
            border: 1.4px solid #e6d9d9;
        }
        
        .input_field .showPass {
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            font-size: 15px;
            margin: 0;
            background: transparent;
            padding: 0;
            border: 0;
            line-height: 1;
            margin-right: 10px;
            cursor: pointer;
            color: dodgerblue;
        }
        
        .input_field .showPass:focus {
            outline: none;
        }
        /*  */
        
        a {
            text-decoration: none;
            color: dodgerblue;
        }
        
        .navbar-nav a {
            font-size: 15px;
            text-transform: uppercase;
            font-weight: 500;
        }
        
        .navbar-light .navbar-brand {
            color: #000;
            font-size: 25px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 2px;
        }
        
        .navbar-light .navbar-brand:focus,
        .navbar-light .navbar-brand:hover {
            color: #000;
        }
        
        .navbar-light .navbar-nav .navbar-link {
            color: #000;
        }
        .navbar-nav a {
            font-size: 15px;
            text-transform: uppercase;
            font-weight: 500;
        }
        
        .navbar-light .navbar-brand {
            color: #000;
            font-size: 25px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 2px;
        }
        
        .navbar-light .navbar-brand:focus,
        .navbar-light .navbar-brand:hover {
            color: #000;
        }
        
        .navbar-light .navbar-nav .navbar-link {
            color: #000;
        }
        option{
          box-shadow: 2px 2px 2px #198754;
        }
        .password-requirements{
            color:#198754
        }
        button{
            color:white;
            background-color: #198754;
            height: 2.5em;
            border: groove;
            border-radius: 10px;
        }
        fieldset{
            color: #198754;
        }
    </style>
</head>

<body>
    <div class="form_wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="home.php">Offeyicial<span class="text-success"> Chat Room </span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="home.php"><i class="bi bi-house-door"></i>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reg.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contactus.php"><i class="bi bi-telephone"></i>Contact us</a>
                </li>

        </div>
    </nav>
    <div class="form_container">
  <center>
    <table>
      <br><br>
      <div class="title_container">
        <h2>Registration Form</h2>
      </div>
  </center>

  <fieldset>
    <legend>Personal Information</legend>
    <div class="form-group">
      <label for="Surname">Surname:</label>
      <input type="text" class="form-control" id="Surname" placeholder="Surname" name="Surname">
    </div>
    <div class="form-group">
      <label for="First Name">First Name:</label>
      <input type="text" class="form-control" id="First_Name" placeholder="First Name" name="First_Name">
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Email" name="email">
    </div>
  </fieldset>

  <fieldset>
    <legend>Account Information</legend>
    <div class="form-group">
      <label for="psw">Password:</label>
      <input type="password" id="psw" placeholder="Password" name="psw" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
      <button class="container" type="button" id="show-password-button" onclick="showPassword()"> Show
    </div>
    <div class="form-group">
      <label for="psw">Confirm password:</label>
      <input type="password" id="Confirmpassword" class="Confirmpassword" placeholder="Re-type Password" />
      <button class="container" type="button" id="show-Confirmpassword-button" onclick="showConfirmpassword()">
        Show
    </div>
  </fieldset>

  <fieldset>
    <legend>Contact Information</legend>
    <div class="form-group">
      <label for="Phone">Phone:</label>
      <input type="text" class="form-control" id="phone" placeholder="Phone" name="phone">
    </div>
    <div class="form-inline">
      <div class="form-group">
        <label for="gender">Gender:</label>
        <select name="gender" id="gender" name="gender" class="form-control">
          <option value="">Select</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Others">I prefer not to say</option>
        </select>
      </div>
      <div class="form-group">
        <label for="dob">DOB:</label>
        <input type="date" class="form-control" id="dob" placeholder="dob" name="dob">
            </div>
        </div>
        </fieldset>

        <fieldset>
    <legend>Location Information</legend>
        <div class="form-group">
            <div class="form-inline">
                <div class="form-group">
                    <label for="Country">Country:</label>
                    <select name="country" class="countries form-control" id="countryId">
                        <option value="">Select Country</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="State">State:</label>
                    <select name="state" class="states form-control" id="stateId">
                        <option value="">Select State</option>
                    </select>
                </div>
            </div>
        </div>
        <div>
        <input type="submit" name="Submit" class="Submit" value="Register" />
        <input type="reset" id="reset" class="reset" value="Reset" onclick="window.location.reload()" />

    </div>
        </fieldset>
    </center>

    <!-- </form> -->

    </table>



    <div class="password-requirements" id="password-requirements">
        Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more
        characters
    </div>

    <p><button href="login.php">Back To login</button></p>

        </div>
</body>


<script src="js/jquery.min.js"></script>
<script>
    //Script to load
    // user country code for selected option
    let user_country_code = "NG";

    (function () {

        let country_list = country_and_states['country'];
        let states_list = country_and_states['states'];

        // creating country name drop-down
        let option = '';
        option += '<option>select country</option>';
        for (let country_code in country_list) {
            // set selected option user country
            let selected = (country_code == user_country_code) ? ' selected' : '';
            option += '<option value="' + country_code + '"' + selected + '>' + country_list[country_code] + '</option>';
        }
        document.getElementById('countryId').innerHTML = option;

        // creating states name drop-down
        let text_box = '<input type="text" class="input-text" id="state">';
        let state_code_id = document.getElementById("stateId");

        function create_states_dropdown() {
            // get selected country code
            let country_code = document.getElementById("countryId").value;
            let states = states_list[country_code];
            // invalid country code or no states add textbox
            if (!states) {
                state_code_id.innerHTML = text_box;
                return;
            }
            let option = '';
            if (states.length > 0) {
                option = '<select id="state">\n';
                for (let i = 0; i < states.length; i++) {
                    option += '<option value="' + states[i].code + '">' + states[i].name + '</option>';
                }
                option += '</select>';
            } else {
                // create input textbox if no states
                option = text_box
            }
            state_code_id.innerHTML = option;
        }

        // country select change event
        const country_select = document.getElementById("countryId");
        country_select.addEventListener('change', create_states_dropdown);

        create_states_dropdown();
    })();
// end of Country and State loading
</script>


<script>
    $('.Submit').click(function () {
        // e.preventDefault();
        let Surname = $('#Surname').val();
        let First_Name = $('#First_Name').val();
        let email = $('#email').val();
        let psw = $('#psw').val();
        let gender = $('#gender').val();
        let phone = $('#phone').val();
        let dob = $('#dob').val();
        let countryId = $('#countryId').val();
        let stateId = $('#stateId').val();








        if (Surname != "" && First_Name != "" && gender != "" && email != "" && psw != "" && phone != "" && dob != "" && countryId != "" && stateId != "") {

            $.ajax({
                url: "SubmitUserForm.php",
                type: "POST",
                async: false,
                data: {
                    "Submit": 1,
                    "Surname": Surname,
                    "First_Name": First_Name,
                    "gender": gender,
                    "email": email,
                    "psw": psw,
                    "phone": phone,
                    "dob": dob,
                    "countryId": countryId,
                    "stateId": stateId,
                },
                success: function (data) {
                    alert(data)
                    alert("Registration Successful");
                    if (data != '') {
                        window.location.href = "user_profile.php?UserId=" + data + "";
                    }

                }



            });


        } else {
            alert("Field Missing");

        }





    });





</script>
<script>
    $('.password,.Confirmpassword').keyup(function () {

        var msgx = "";
        let Confirmpassword = $('.Confirmpassword').val();
        //  alert(Confirmpassword);
        let password = $('.password').val();

        //  alert(password);

        if (Confirmpassword != "") {
            if (Confirmpassword == password) {

                msgx = "Password Matched";
                $("#messagex").css("color", "green");

            } else {

                msgx = "Password is not matching";
                $("#messagex").css("color", "red");
            }
            $("#messagex").html(msgx);
        }



    });
</script>




<!-- password verification -->
<script>
    var myInput = document.getElementById("psw");
    var letter = document.getElementById("letter");
    var capital = document.getElementById("capital");
    var number = document.getElementById("number");
    var length = document.getElementById("length");

    function showPassword() {
        var passwordInput = document.getElementById("psw");
        var showPasswordButton = document.getElementById("show-password-button");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            showPasswordButton.innerHTML = "Hide";
        } else {
            passwordInput.type = "password";
            showPasswordButton.innerHTML = "Show";
        }
    }
    function showConfirmpassword() {
        var passwordInput = document.getElementById("Confirmpassword");
        var showPasswordButton = document.getElementById("show-Confirmpassword-button");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            showPasswordButton.innerHTML = "Hide";
        } else {
            passwordInput.type = "password";
            showPasswordButton.innerHTML = "Show";
        }
    }
    showConfirmpassword

    // When the user starts to type something inside the password field
    myInput.onkeyup = function () {
        // Validate lowercase letters
        var lowerCaseLetters = /[a-z]/g;
        if (myInput.value.match(lowerCaseLetters)) {
            letter.classList.remove("invalid");
            letter.classList.add("valid");
        } else {
            letter.classList.remove("valid");
            letter.classList.add("invalid");
        }

        // Validate capital letters
        var upperCaseLetters = /[A-Z]/g;
        if (myInput.value.match(upperCaseLetters)) {
            capital.classList.remove("invalid");
            capital.classList.add("valid");
        } else {
            capital.classList.remove("valid");
            capital.classList.add("invalid");
        }

        // Validate numbers
        var numbers = /[0-9]/g;
        if (myInput.value.match(numbers)) {
            number.classList.remove("invalid");
            number.classList.add("valid");
        } else {
            number.classList.remove("valid");
            number.classList.add("invalid");
        }

        // Validate length
        if (myInput.value.length >= 8) {
            length.classList.remove("invalid");
            length.classList.add("valid");
        } else {
            length.classList.remove("valid");
            length.classList.add("invalid");
        }
    }
</script>

<script>
    function showPassword() {
        var passwordInput = document.getElementById("psw");
        var showPasswordButton = document.getElementById("show-password-button");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            showPasswordButton.innerHTML = "Hide";
        } else {
            passwordInput.type = "password";
            showPasswordButton.innerHTML = "Show";
        }
    }

</script>

</html>