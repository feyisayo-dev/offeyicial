<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Offeyicial</title>

    <link rel="stylesheet" href="css/all.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font/bootstrap-icons.css">
    <link rel="icon" href="img/offeyicial.png" type="image/jpeg" sizes="32x32" />
    <link href="css/aos.css" rel="stylesheet">
    <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="css/remixicon/remixicon.css" rel="stylesheet">
    <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="css/reg.css" rel="stylesheet">
    <link href="css/intlTelInput.css" rel="stylesheet">
</head>

<body>
    <div class="form_wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <a class="navbar-brand" href="home.php"><span class="text-success"> Offeyicial </span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navmenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php"><i class="bi bi-house-door"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php"><i class="bi bi-person-fill"></i>Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="donate.php">Donate</a>
                    </li>
                    <li>
                        <a class="nav-link scrollto" href="#contact"><i class="bi bi-telephone"></i>Contact</a>
                    </li>
                </ul>
            </div>
        </nav>
        <section class="container">
            <div class="login-container">
                <center>
                    <table>
                        <div class="title_container">
                            <h2>Registration Form</h2>
                        </div>
                    </table>
                </center>
                <ul class="form-stepper form-stepper-horizontal text-center mx-auto pl-0">
                    <li class="form-stepper-active text-center form-stepper-list" step="1">
                        <a class="mx-2">
                            <span class="form-stepper-circle">
                                <span>1</span>
                            </span>
                            <div class="label">Personal Information</div>
                        </a>
                    </li>
                    <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
                        <a class="mx-2">
                            <span class="form-stepper-circle text-muted">
                                <span>2</span>
                            </span>
                            <div class="label text-muted">Account Information</div>
                        </a>
                    </li>
                    <li class="form-stepper-unfinished text-center form-stepper-list" step="3">
                        <a class="mx-2">
                            <span class="form-stepper-circle text-muted">
                                <span>3</span>
                            </span>
                            <div class="label text-muted">Contact Information</div>
                        </a>
                    </li>
                    <li class="form-stepper-unfinished text-center form-stepper-list" step="4">
                        <a class="mx-2">
                            <span class="form-stepper-circle text-muted">
                                <span>4</span>
                            </span>
                            <div class="label text-muted">Location Information</div>
                        </a>
                    </li>
                </ul>
                <div class="form-container">
                    <div class="circle circle-one"></div>
                    <fieldset id="step-1" class="form-step">
                        <legend>Personal Information</legend>
                        <div class="form-group">
                            <input type="text" class="form-control" id="Surname" placeholder="Surname" name="Surname">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="First_Name" placeholder="First Name" name="First_Name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                        </div>
                        <div class="mt-3">
                            <button class="button btn-navigate-form-step" type="button" step_number="2">Next</button>
                        </div>
                    </fieldset>

                    <fieldset id="step-2" class="form-step d-none">
                        <legend>Account Information</legend>
                        <form>
                            <div class="form-group passwordFlex">
                                <input type="password" id="psw" placeholder="Password" autocomplete="off" name="password" class="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                                <i id="show-password-button" onclick="showPassword()" class="showpass bi bi-eye"></i>
                                <div class="inappropriate-password" id="inappropriate-password" style="display:none; color:red">
                                    Password must contain at least one number, one uppercase letter, one lowercase letter, and be at least 8 characters long.
                                </div>
                            </div>
                            <div class="form-group passwordFlex">
                                <input type="password" id="Confirmpassword" autocomplete="off" class="Confirmpassword" placeholder="Re-type Password" />
                                <i id="show-Confirmpassword-button" onclick="showConfirmpassword()" class="showpass bi bi-eye"></i>
                                <div id="confirm-password-error" style="display:none; color:red">
                                    Passwords do not match.
                                </div>
                            </div>
                        </form>
                        <div class="mt-3">
                            <button class="button btn-navigate-form-step" type="button" step_number="1">Prev</button>
                            <button class="button btn-navigate-form-step" type="button" step_number="3">Next</button>
                        </div>
                    </fieldset>

                    <fieldset id="step-3" class="form-step d-none">
                        <legend>Contact Information</legend>
                        <div class="form-group">
                            <input type="text" class="form-control" id="phone" placeholder="Phone" name="phone">
                        </div>
                        <div class="form-inline">
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <select name="gender" id="gender" name="gender" class="form-control">
                                    <option class="blue" value="">Select</option>
                                    <option class="red" value="Male">Male</option>
                                    <option class="blue" value="Female">Female</option>
                                    <option class="red" value="Others">I prefer not to say</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="dob">DOB:</label>
                                <input type="date" class="form-control" id="dob" placeholder="dob" name="dob">
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="button btn-navigate-form-step" type="button" step_number="2">Prev</button>
                            <button class="button btn-navigate-form-step" type="button" step_number="4">Next</button>
                        </div>
                    </fieldset>

                    <fieldset id="step-4" class="form-step d-none">
                        <legend>Location Information</legend>
                        <div class="form-group">
                            <div class="form-inline">
                                <div class="form-group">
                                    <label for="Country">Country:</label>
                                    <select name="country" class="countries form-control" title="country" id="countryId">
                                        <option value="">Select Country</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="State">State:</label>
                                    <select name="state" class="states form-control" title="state" id="stateId">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button class="button btn-navigate-form-step" type="button" step_number="3">Prev</button>
                            </div>
                        </div>
                        <div>
                            <button type="submit" id="submit" class="Submit opacity" value="Register">SUBMIT</button>
                            <button type="reset" id="reset" class="reset opacity" value="Reset">RESET</button>
                        </div>
                    </fieldset>
                    <div class="circle circle-two"></div>
                </div>
                <div class="password-requirements" id="password-requirements">
                    <center>
                        <strong style="color:white; font-size: 20px;">Password requirements</strong>:
                    </center>
                    Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more
                    characters
                </div>

                <button class="login" onclick="location.href='login.php'">Back To login</button>
            </div>
            <div class="theme-btn-container"></div>
        </section>

</body>


<script src="js/jquery.min.js"></script>
<script src="country-states.js"></script>
<script src="./scripttologin.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/intlTelInput-jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    let user_country_code = "NG";

    (function() {

        let country_list = country_and_states['country'];
        let states_list = country_and_states['states'];

        let option = '';
        option += '<option>select country</option>';
        for (let country_code in country_list) {
            let selected = (country_code == user_country_code) ? ' selected' : '';
            option += '<option value="' + country_code + '"' + selected + '>' + country_list[country_code] + '</option>';
        }
        document.getElementById('countryId').innerHTML = option;

        let text_box = '<input type="text" class="input-text" id="state">';
        let state_code_id = document.getElementById("stateId");

        function create_states_dropdown() {
            let country_code = document.getElementById("countryId").value;
            let states = states_list[country_code];
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
                option = text_box
            }
            state_code_id.innerHTML = option;
        }

        const country_select = document.getElementById("countryId");
        country_select.addEventListener('change', create_states_dropdown);

        create_states_dropdown();
    })();
</script>

<script>
    const passwordInput = document.getElementById('psw');
    const confirmPasswordInput = document.getElementById('Confirmpassword');
    const confirmPasswordError = document.getElementById('confirm-password-error');
    const inappropriatePasswordError = document.getElementById('inappropriate-password');
    const submitregpage = document.getElementById('submit');


    function showPassword() {
        var passwordInput = document.getElementById("psw");
        var showPasswordButton = document.getElementById("show-password-button");

        if (passwordInput && passwordInput.type === "password") {
            passwordInput.type = "text";
            // showPasswordButton.innerHTML = "Hide";
        } else if (passwordInput) {
            passwordInput.type = "password";
            // showPasswordButton.innerHTML = "Show";
        }
    }

    function showConfirmpassword() {
        var passwordInput = document.getElementById("Confirmpassword");
        var showPasswordButton = document.getElementById("show-Confirmpassword-button");

        if (passwordInput && passwordInput.type === "password") {
            passwordInput.type = "text";
            showPasswordButton.innerHTML = "Hide";
        } else if (passwordInput) {
            passwordInput.type = "password";
            showPasswordButton.innerHTML = "Show";
        }
    }


    function checkPasswordValidity() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (
            !password.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/) ||
            password !== confirmPassword
        ) {
            submitregpage.style.display = 'none';
        } else {
            submitregpage.style.display = 'inline-block';
        }
    }

    function checkIfPasswordMatch() {
        if (passwordInput.value === confirmPasswordInput.value) {
            confirmPasswordInput.classList.add('valid');
            confirmPasswordInput.classList.remove('invalid');
            confirmPasswordError.style.display = 'none';
        } else {
            confirmPasswordInput.classList.add('invalid');
            confirmPasswordInput.classList.remove('valid');
            confirmPasswordError.style.display = 'block';
        }
    }
    passwordInput.addEventListener('keyup', () => {
        if (!passwordInput.value) {
            passwordInput.classList.remove('invalid');
            inappropriatePasswordError.style.display = 'none';
        } else if (passwordInput.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/)) {
            passwordInput.classList.add('valid');
            passwordInput.classList.remove('invalid');
            inappropriatePasswordError.style.display = 'none';
        } else {
            passwordInput.classList.add('invalid');
            passwordInput.classList.remove('valid');
            inappropriatePasswordError.style.display = 'block';
        }
        checkIfPasswordMatch();
        checkPasswordValidity()
    });

    confirmPasswordInput.addEventListener('keyup', () => {
        checkIfPasswordMatch();
        checkPasswordValidity();
    });
</script>

<script>
    $('#phone').on('keyup', function() {
        // $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });
    $("#phone").intlTelInput({
        initialCountry: "in",
        separateDialCode: true,
        utilsScript: "js/utils.js"
    });
</script>
<script>
    var Surname = document.getElementById('Surname').value;
    var First_Name = document.getElementById('First_Name').value;
    var email = document.getElementById('email').value;
    var psw = document.getElementById('psw').value;
    var confirmPassword = document.getElementById('Confirmpassword').value;
    var gender = document.getElementById('gender').value;
    var phone = document.getElementById('phone').value;
    var dob = document.getElementById('dob').value;
    var countryId = document.getElementById('countryId').value;
    var stateId = document.getElementById('stateId').value;
    var SubmitBTN = document.querySelector('.Submit');
    var ResetBTN = document.querySelector('.reset');
    ResetBTN.addEventListener('click', function() {
        console.log('clicked')
        $('#Surname').val('');
        $('#First_Name').val('');
        $('#email').val('');
        $('#psw').val('');
        $('#gender').val('');
        $('#dob').val('');
        $('#countryId').val('');
        $('#stateId').val('');
        $('#Confirmpassword').val('');
    })
    if (Surname != "" && First_Name != "" && gender != "" && email != "" && psw != "" && phone != "" && dob != "" && countryId != "" && stateId != "") {
        SubmitBTN.style.display = 'block';
        // SubmitBTN.style.opacity = '1';
    } else {
        SubmitBTN.style.display = 'none';
        // SubmitBTN.style.opacity = '0.1';
    };
    SubmitBTN.addEventListener('click', function() {
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
                success: function(data) {
                    var response = JSON.parse(data);
                    if (response.UserId) {
                        alert("Registration Successful");
                        alert("Your UserId is, please keep it properly: " + response.UserId);
                        window.location.href = "user_profile.php?UserId=" + response.UserId;
                    } else {
                        alert("Issue while creating account");
                        alert(response);
                    }
                }
            });
        } else {
            alert("Field Missing");
        }
    });

    const navigateToFormStep = (stepNumber) => {
        document.querySelectorAll(".form-step").forEach((formStepElement) => {
            formStepElement.classList.add("d-none");
        });
        document.querySelectorAll(".form-stepper-list").forEach((formStepHeader) => {
            formStepHeader.classList.add("form-stepper-unfinished");
            formStepHeader.classList.remove("form-stepper-active", "form-stepper-completed");
        });
        document.querySelector("#step-" + stepNumber).classList.remove("d-none");
        const formStepCircle = document.querySelector('li[step="' + stepNumber + '"]');
        formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-completed");
        formStepCircle.classList.add("form-stepper-active");
        for (let index = 0; index < stepNumber; index++) {
            const formStepCircle = document.querySelector('li[step="' + index + '"]');
            if (formStepCircle) {
                formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-active");
                formStepCircle.classList.add("form-stepper-completed");
            }
        }
    };
    document.querySelectorAll(".btn-navigate-form-step").forEach((formNavigationBtn) => {
        formNavigationBtn.addEventListener("click", () => {
            const stepNumber = parseInt(formNavigationBtn.getAttribute("step_number"));

            navigateToFormStep(stepNumber);
        });
    });
</script>



</html>