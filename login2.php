<?php
session_start();
$UserId = $_SESSION["UserId"];
$profileOwnerId = $_GET['UserId'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="css/all.min.css" />
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/font/bootstrap-icons.css">
    <link rel="icon" href="img/offeyicial.png" type="image/jpeg" sizes="32x32" />
    <link href="css/aos.css" rel="stylesheet">
    <link href="css/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="css/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="css/remixicon/remixicon.css" rel="stylesheet">
    <link href="css/swiper/swiper-bundle.min.css" rel="stylesheet">
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/sweetalert2@10.js"></script>
    <script src="country-states.js"></script>
    <link rel="stylesheet" href="profile.css">


</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="logo me-auto"><img src="img/offeyicial.png" alt="logo" class="img-fluid"><span class="text-success">
                Offeyicial </span></div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu" aria-controls="navmenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navmenu">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="home.php"><i class="bi bi-house-door"></i>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link custom-link" id="index"><i class="bi bi-newspaper"></i>NEWS-FEED</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link custom-link" id="upload"><i class="bi bi-plus-square"></i>Add a Post</a>
                </li>
                <li class="nav-item">
                    <div class="search-container">
                        <input class="searchtext" type="text" id="search" placeholder="Search for names.." title="Type in a name">
                        <div id="user_table">
                        </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="home.php#contact"><i class="bi bi-telephone"></i>Contact us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" id="logout"><i class="bi bi-box-arrow-right"></i>Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid profile-section">
        <div class="row">
            <div class="col-md-4 profile-pic">
                <img class="button img_profile" alt="Profile Picture">
                <P>Enhance your online persona</P>
                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="upload1" class="custom-file-upload">
                        <i class="fa fa-cloud-upload"></i> Choose Image
                    </label>
                    <input type="file" class="custom-file-input" name="Fileupload" id="upload1" required />
                    <button type="submit" name="button" id="button">
                        <i class="bi bi-cloud-arrow-up"></i>
                    </button>

                </form>

                <hr>
            </div>
            <div class="col-md-4 profile-info">

                <div class="wrapper">
                    <svg>
                        <text x="50%" y="50%" dy=".35em" text-anchor="middle">
                            <tspan class="surName" dy="0"></tspan>
                            <tspan class="firstName" x="50%" dy="1.5em"></tspan>
                        </text>
                    </svg>
                </div>
                <p class="p_email"></p>
                <p class="p_phone"></p>
                <p class="p_gender"></p>
                <p class="p_dob"></p>
                <p class="p_countryId"></p>
                <p class="p_getbio"></p>
                <div class="row var">

                </div>

            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6 fol">
                        <p class="isFollowing" style="margin-bottom: 0;"></p>
                        <p style="font-size: 0.8rem;">Following</p>
                    </div>
                    <div class="col-md-6 folw">
                        <p class="following" style="margin-bottom: 0;"></p>
                        <p style="font-size: 0.8rem;">Followers</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="text-center text-uppercase text-success">Posts</h3>
                    <div id="posts" class="posts">
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <button id="sidebar-toggle" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
                <i class="bi bi-chat"></i>
            </button>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="sidebarLabel">Chats</h5>
                    <button type="button" class="btn-close text-reset close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="list-unstyled">
                        <li>
                            <div class="passport">
                                <a data-bs-toggle="modal" data-bs-target="#profilepicturemodal">
                                    <img>
                                </a>
                            </div>
                            <div class="name">
                                <span>
                                    <a></a>
                                </span>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="theme-btn-container"></div>

</body>
<div class="modal fade" id="setBioModal" tabindex="-1" role="dialog" aria-labelledby="setBioModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="setBioModalLabel">Set Bio</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea class="form-control" id="bioTextArea" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveBio()">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editprofile" tabindex="-1" role="dialog" aria-labelledby="editprofileLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editprofileLabel">Edit Profile</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <fieldset>
                    <legend>Personal Information</legend>
                    <div class="form-group">
                        <label for="Surname">Surname:</label>
                        <textarea style="height: 30px;" type="text" class="form-control" id="Surname" placeholder="Surname" name="Surname"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="First Name">First Name:</label>
                        <textarea style="height: 30px;" type="text" class="form-control" id="First_Name" placeholder="First Name" name="First_Name"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <textarea style="height: 30px;" type="email" class="form-control" id="email" placeholder="Email" name="email"></textarea>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Contact Information</legend>
                    <div class="form-group">
                        <label for="Phone">Phone:</label>
                        <textarea style="height: 30px;" type="text" class="form-control" id="phone" placeholder="Phone" name="phone"></textarea>
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
                            <input style="height: 30px;" type="date" class="form-control" id="dob" placeholder="dob" name="dob">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="editpro()">Save changes</button>
                    </div>
            </div>
        </div>
    </div>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="./scripttologin.js"></script>
<script src="node_modules/socket.io-client/dist/socket.io.js"></script>

<script>
    var UserId = '<?php echo $UserId ?>';
    var profileOwnerId = "<?php echo $profileOwnerId ?>";
    var socketUrl = 'ws://localhost:8888';
    const socket = io(socketUrl, {
        query: {
            UserId
        }
    });

    let attempts = 0;

    socket.on('connect', () => {
        console.log('Socket.IO connection established');

        if (attempts === 0) {
            fetchUserProfileData(profileOwnerId);
            fetchPoeple(profileOwnerId);
            fetchFollowing(profileOwnerId);
            const formData = new FormData();
            formData.append('UserId', UserId);
            fetch('http://localhost:8888/fetchPostForEachUser', {
                    method: 'POST',
                    body: formData,
                })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Error finding post');
                    }
                    return response.json();
                })
                .then((result) => {
                    result.forEach((post) => {
                        loadNewsFeed(post);
                    });
                })
                .catch((error) => {
                    console.error(error);
                });
            attempts++;
        } else {
            console.log('Reconnected');
        }
    });





    var UserPic = document.querySelector('.img_profile');
    var UserEmail = document.querySelector('.p_email');
    var UserPhone = document.querySelector('.p_phone');
    var UserGender = document.querySelector('.p_gender');
    var UserDob = document.querySelector('.p_dob');
    var UserCountryId = document.querySelector('.p_countryId');
    var Userbio = document.querySelector('.p_getbio');
    var surName = document.querySelector('.surName');
    var firstName = document.querySelector('.firstName');
    async function fetchUserProfileData(profileOwnerId) {
        try {
            const response = await fetch(`http://localhost:8888/getUserProfile/${profileOwnerId}`);
            if (response.ok) {
                const userProfileData = await response.json();
                if (userProfileData.Passport != null) {
                    var passDef = 'UserPassport/' + userProfileData.Passport;
                } else {
                    passDef = 'UserPassport/DefaultImage.png'
                }
                UserPic.src = passDef;
                surName.textContent = userProfileData.Surname;
                firstName.textContent = userProfileData.First_Name;
                UserEmail.textContent = 'Email: ' + userProfileData.email;
                UserPhone.textContent = 'Phone: ' + userProfileData.phone;
                UserGender.textContent = 'Gender: ' + userProfileData.gender;
                UserDob.textContent = 'DOB: ' + userProfileData.dob;
                UserCountryId.textContent = 'CountryId: ' + userProfileData.countryId + userProfileData.stateId;
                var bio = ''
                if (userProfileData.bio) {
                    bio = userProfileData.bio;
                } else {
                    bio = 'No bio set yet';
                }
                Userbio.textContent = 'Bio: ' + bio;

            } else {
                throw new Error('Error fetching user profile data');
            }
        } catch (error) {
            console.error(error);
            return null;
        }
    }

    var passport = document.querySelector('.passport');
    var passportModal = passport.querySelector('a');
    var passportModalImg = passportModal.querySelector('img');

    var NameOfP = document.querySelector('.name');
    var NameOfPSpan = NameOfP.querySelector('span');
    var NameOfPSpanA = NameOfPSpan.querySelector('a');
    async function fetchPoeple(UserId) {
        try {
            const response = await fetch(`http://localhost:8888/getPeople/${UserId}`);
            if (response.ok) {
                const userData = await response.json();
                console.log('This are the users data', userData);
                if (userData) {
                    userData.forEach((result) => {
                        if (result.Passport != null) {
                            var passUser = 'UserPassport/' + result.Passport;
                        } else {
                            passUser = 'UserPassport/DefaultImage.png';
                        }

                        passportModalImg.src = passUser;
                        passportModalImg.alt = result.UserId;
                        NameOfPSpanA.textContent = `${result.Surname} ${result.FirstName}`;
                        NameOfPSpanA.href = 'chat.php?UserId=' + result.UserId;
                    });
                } else {
                    passUser = 'UserPassport/DefaultImage.png';
                    passportModalImg.src = passUser;
                    passportModalImg.alt = 'New User';
                    NameOfPSpanA.textContent = `Talk to new people`;
                }

            } else {
                throw new Error('Error fetching user data');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    const followBox = document.querySelector('.fol')
    const followerBox = document.querySelector('.folw')
    const followingDiv = document.querySelector('.isFollowing');
    const followerDiv = document.querySelector('.following');
    var variable = document.querySelector('.var');

    async function fetchFollowing(profileOwnerId) {
        try {
            const response = await fetch(`http://localhost:8888/fetchFollow/${UserId}`);
            if (response.ok) {
                const userFollow = await response.json();
                console.log('This are the users data', userFollow);
                const following = userFollow.following;
                const followers = userFollow.followers;
                const followingCount = following.length;
                const followersCount = followers.length;
                followingDiv.innerHTML = followingCount;
                followerDiv.innerHTML = followersCount;

                if (profileOwnerId != UserId) {
                    variable.innerHTML = '<div class="col-md-5"> <button id="followBtn" class="follow">Follow</button></div>' + '<div class="col-md-5"> <button class="message" onclick="location.href=chat.php?UserIdx=' + profileOwnerId + '"><i class="bi bi-chat-fill"></i></button></div>';
                } else {
                    variable.innerHTML = '<div class="col-md-4"> <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#setBioModal">Set Bio</button> </div> <div class="col-md-4"> <button type="button" style="background-color:red;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editprofile">Edit profile</button> </div>';
                }
                const isFollowing = followers.includes(UserId);

                const followButton = document.getElementById('followBtn');

                if (isFollowing) {
                    followButton.textContent = 'Unfollow';
                    followButton.classList.add('following');
                    followButton.classList.remove('unfollow');
                } else {
                    followButton.textContent = 'Follow';
                    followButton.classList.add('unfollow');
                    followButton.classList.remove('following');
                }

                var box = document.createElement('div');
                box.classList.add('followingBox');

                var overlay = document.createElement('div');
                overlay.classList.add('overlay');
                overlay.classList.add('hidden');
                window.onclick = function(event) {
                    console.log('Clicked on', event.target);
                    if (event.target === overlay) {
                        console.log('Clicked on the box');
                        box.style.display = "none";
                        overlay.style.display = "none";
                        box.innerHTML = '';
                    }
                }
                var profile = document.querySelector('.profile-section');
                profile.appendChild(box);
                profile.appendChild(overlay);
                followerBox.addEventListener('click', async function() {
                    box.innerHTML = '';
                    box.style.display = 'flex';
                    overlay.style.display = 'block';
                    var title = document.createElement('div');
                    title.classList.add('boxtitle');
                    title.textContent = 'Following';
                    var close = document.createElement('div');
                    close.classList.add('close');
                    close.innerHTML = '<img src="icons/close.png">';
                    box.appendChild(close);
                    close.addEventListener('click', function() {
                        box.style.display = 'none';
                    });
                    box.appendChild(title);
                    if (followersCount === 0) {
                        var nullx = document.createElement('div');
                        nullx.classList.add('nullx');
                        nullx.innerHTML = '<p>Not follwoing anyone<p><p>Try following people</p>';
                        box.appendChild(nullx);
                    } else {
                        followers.forEach(async (follow) => {
                            var User = follow.UserId;
                            try {
                                const response = await fetch(`http://localhost:8888/getUserProfile/${User}`);
                                if (response.ok) {
                                    const userProfileData = await response.json();
                                    if (userProfileData.Passport != null) {
                                        var passUser = 'UserPassport/' + userProfileData.Passport;
                                    } else {
                                        passUser = 'UserPassport/DefaultImage.png';
                                    }

                                    var userBox = document.createElement('div');
                                    userBox.classList.add('user-box');

                                    var boxUserImg = document.createElement('img');
                                    boxUserImg.src = passUser;
                                    boxUserImg.alt = userProfileData.UserId;

                                    var boxUserName = document.createElement('a');
                                    boxUserName.classList.add('nameUser');
                                    boxUserName.textContent = `${userProfileData.Surname} ${userProfileData.FirstName}`;
                                    boxUserName.href = 'user_profile.php?UserId=' + userProfileData.UserId;

                                    userBox.appendChild(boxUserImg);
                                    userBox.appendChild(boxUserName);
                                    box.appendChild(userBox);
                                } else {
                                    throw new Error('Error fetching user profile data');
                                }
                            } catch (error) {
                                console.error(error);
                                return null;
                            }
                        });
                    }
                });
                followBox.addEventListener('click', async function() {
                    box.innerHTML = '';
                    box.style.display = 'flex';
                    overlay.style.display = 'block';
                    var title = document.createElement('div');
                    title.classList.add('boxtitle');
                    title.textContent = 'Followers';
                    var close = document.createElement('div');
                    close.classList.add('close');
                    close.innerHTML = '<img src="icons/close.png">';
                    box.appendChild(close);
                    close.addEventListener('click', function() {
                        box.style.display = 'none';
                    });
                    box.appendChild(title);
                    if (followingCount === 0) {
                        var nullx = document.createElement('div');
                        nullx.classList.add('nullx');
                        nullx.innerHTML = '<p>No followers yet<p><p>Try following people</p>';
                        box.appendChild(nullx);
                    } else {
                        following.forEach(async (follow) => {
                            var User = follow.UserId;
                            try {
                                const response = await fetch(`http://localhost:8888/getUserProfile/${User}`);
                                if (response.ok) {
                                    const userProfileData = await response.json();
                                    if (userProfileData.Passport != null) {
                                        var passUser = 'UserPassport/' + userProfileData.Passport;
                                    } else {
                                        passUser = 'UserPassport/DefaultImage.png';
                                    }

                                    var userBox = document.createElement('div');
                                    userBox.classList.add('user-box');

                                    var boxUserImg = document.createElement('img');
                                    boxUserImg.src = passUser;
                                    boxUserImg.alt = userProfileData.UserId;

                                    var boxUserName = document.createElement('a');
                                    boxUserName.classList.add('nameUser');
                                    boxUserName.textContent = `${userProfileData.Surname} ${userProfileData.FirstName}`;
                                    boxUserName.href = 'user_profile.php?UserId=' + userProfileData.UserId;

                                    userBox.appendChild(boxUserImg);
                                    userBox.appendChild(boxUserName);
                                    box.appendChild(userBox);
                                } else {
                                    throw new Error('Error fetching user profile data');
                                }
                            } catch (error) {
                                console.error(error);
                                return null;
                            }
                        });
                    }
                });

            } else {
                throw new Error('Error fetching user followers / follwoing');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
    let user_country_code = "";

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

    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("////").pop();
        $(this).siblings(".custom-file-upload").html("<i class=\"bi bi-check-circle-fill\"></i> " + fileName);
    });

    function saveBio() {
        var bio = document.getElementById("bioTextArea").value;

        if (bio != "") {
            $.ajax({
                url: "SubmitUserForm.php",
                type: "POST",
                async: false,
                data: {
                    "addbio": 1,
                    "bio": bio,
                    "UserId": UserId,

                },
                success: function(data) {
                    alert(data)
                    $("#bioTextArea").val("");
                    $(".col-md-4.profile-info").load(location.href + " .col-md-4.profile-info>*", "");
                }
            });
        } else {
            alert("Field Missing");
        }
        console.log(bio);
        $("#setBioModal").modal("hide");
    }

    function editpro() {

        var Surname = $("#Surname").val();
        var First_Name = $("#First_Name").val();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var gender = $("#gender").val();
        var dob = $("#dob").val();
        var country = $("#countryId").val();
        var state = $("#stateId").val();

        if (Surname === "" || First_Name === "" || email === "" || phone === "" || gender === "" || dob === "" || country === "" || state === "") {
            alert("Please fill in all the required fields.");
            return false;
        }

        $.ajax({
            url: "SubmitUserForm.php",
            type: "POST",
            data: {
                edit: 1,
                UserId: UserId,
                Surname: Surname,
                First_Name: First_Name,
                email: email,
                phone: phone,
                gender: gender,
                dob: dob,
                country: country,
                state: state
            },
            success: function(data) {
                alert(data);
                location.reload();
            },
            error: function(xhr, status, error) {
                alert(data);
            }
        });
    }

    $(document).ready(function() {
        const searchBox = $("#search");
        const resultsDiv = $("#user_table");

        searchBox.on("input", function() {
            const searchTerm = this.value.trim();

            if (!searchTerm) {
                resultsDiv.html("");
                return;
            }

            $.ajax({
                url: "searchbackend.php",
                method: "POST",
                data: {
                    search_query: searchTerm
                },
                success: function(data) {
                    resultsDiv.html(data);
                }
            });
        });
    });




    function likepost(postId) {
        var post = document.getElementById(postId);
        var UserId = "<?php echo $_SESSION['UserId']; ?>";
        var likeBtn = post.querySelector('.like');
        var likeCountSpan = likeBtn.querySelector('.like-count');
        var likeCount = parseInt(likeCountSpan.textContent);
        const formData = new FormData();
        formData.append('UserId', UserId);
        formData.append('postId', postId);

        fetch('http://localhost:8888/likepost', {
                method: 'POST',
                body: formData,
            })
            .then((response) => {
                console.log(response);
                if (!response.ok) {
                    throw new Error('Error liking/unliking post');
                }
                return response.json();
            })
            .then((result) => {
                const likeStatus = result.likeStatus;
                if (likeStatus === 'like') {
                    likeBtn.classList.add('likeing');
                    likeBtn.classList.remove('unlike');
                    likeCount++;
                    likeBtn.innerHTML = '<span class="like-count">' + likeCount + '</span>' +
                        '<span class="emoji"><img src="icons/love.png"></span>';
                } else if (likeStatus === 'unlike') {
                    likeBtn.classList.add('unlike');
                    likeBtn.classList.remove('likeing');
                    likeCount--;
                    likeBtn.innerHTML = '<span class="like-count">' + likeCount + '</span>' +
                        '<span class="emoji"><img src="icons/unlove.png"></span>';
                }

                likeCountSpan.textContent = likeCount;
            })
            .catch((error) => {
                console.error(error);
            });
    }

    function checkIfItIsClicked(postId) {
        console.log('checking for post with', postId, 'and UserId', UserId);
        var post = document.getElementById(postId);
        var likeBtn = post.querySelector('.like');
        var likeCountSpan = likeBtn.querySelector('.like-count');
        var likeCount = parseInt(likeCountSpan.textContent);
        const formData = new FormData();
        formData.append('UserId', UserId);
        formData.append('postId', postId);
        fetch('http://localhost:8888/checkLikeforPost', {
                method: 'POST',
                body: formData,
            })
            .then((response) => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Error checking if the post has been liked');
                }
            })
            .then((result) => {
                const likeStatus = result.likeStatus;
                if (likeStatus === 'liked') {
                    likeBtn.classList.add('likeing');
                    likeBtn.classList.remove('unlike');
                    likeBtn.innerHTML = '<span class="like-count">' + likeCount + '</span>' +
                        '<span class="emoji"><img src="icons/love.png"></span>';
                } else if (likeStatus === 'notLiked') {
                    likeBtn.classList.add('unlike');
                    likeBtn.classList.remove('likeing');
                    likeBtn.innerHTML = '<span class="like-count">' + likeCount + '</span>' +
                        '<span class="emoji"><img src="icons/unlove.png"></span>';
                }
            })
            .catch((error) => {
                console.error(error);
            });
    }

    function loadNewsFeed(data) {
        var newsFeed = document.getElementById('posts');

        var postElement = document.createElement('section');
        var postDiv = document.createElement('div');
        postDiv.className = 'post';
        postDiv.id = data.postId;

        var newsFeedPostDiv = document.createElement('div');
        newsFeedPostDiv.className = 'news-feed-post';

        var postHeaderDiv = document.createElement('div');
        postHeaderDiv.className = 'post-header';

        var userPassportImg = document.createElement('img');
        userPassportImg.className = 'UserPassport';
        userPassportImg.src = data.passport;

        var authorLink = document.createElement('a');
        authorLink.href = 'user_profile.php?UserId=' + data.UserId;
        authorLink.style.textDecoration = 'none';

        var authorNameP = document.createElement('p');
        authorNameP.className = 'post-author';
        authorNameP.innerHTML = '<strong>' + data.surname + ' ' + data.firstName + '</strong>';

        var title = document.querySelector("title")
        title.innerHTML = 'Profile -- ' + data.surname + ' ' + data.firstName;

        authorLink.appendChild(authorNameP);
        postHeaderDiv.appendChild(userPassportImg);
        postHeaderDiv.appendChild(authorLink);

        var threeDotsDiv = document.createElement('div');
        threeDotsDiv.id = 'threedots';

        var dropdownButton = document.createElement('button');
        dropdownButton.type = 'button';
        dropdownButton.className = 'btn btn-link';
        dropdownButton.dataset.bsToggle = 'dropdown';
        dropdownButton.setAttribute('aria-haspopup', 'true');
        dropdownButton.setAttribute('aria-expanded', 'false');
        dropdownButton.innerHTML = '<i class="fas fa-ellipsis-h"></i>';

        var dropdownMenu = document.createElement('div');
        dropdownMenu.className = 'dropdown-menu dropdown-menu-right';

        var blockUserDiv = document.createElement('div');
        var blockUserButton = document.createElement('button');
        blockUserButton.type = 'button';
        blockUserButton.className = 'btn btn-primary blockUser';
        blockUserButton.id = 'blockUser-' + data.UserId;
        blockUserButton.dataset.recipientid = data.UserId;
        blockUserButton.dataset.bsToggle = 'modal';
        blockUserButton.dataset.bsTarget = '#blockUserModal-' + data.UserId;
        blockUserButton.innerHTML = 'Block User';

        var blockUserInput = document.createElement('input');
        blockUserInput.type = 'hidden';
        blockUserInput.id = 'bu' + data.UserId;
        blockUserInput.value = data.UserId;

        blockUserDiv.appendChild(blockUserButton);
        blockUserDiv.appendChild(blockUserInput);

        var blockButtonDiv = document.createElement('div');
        var blockButtonButton = document.createElement('button');
        blockButtonButton.type = 'button';
        blockButtonButton.className = 'btn btn-primary blockButton';
        blockButtonButton.id = 'blockButton-' + data.postId;
        blockButtonButton.dataset.postid = data.postId;
        blockButtonButton.dataset.bsToggle = 'modal';
        blockButtonButton.dataset.bsTarget = '#blockTypeofPostModal-' + data.postId;
        blockButtonButton.innerHTML = 'Block this type of post';

        var blockButtonInput = document.createElement('input');
        blockButtonInput.type = 'hidden';
        blockButtonInput.id = 'b' + data.postId;
        blockButtonInput.value = data.postId;

        blockButtonDiv.appendChild(blockButtonButton);
        blockButtonDiv.appendChild(blockButtonInput);

        dropdownMenu.appendChild(blockUserDiv);
        dropdownMenu.appendChild(blockButtonDiv);
        dropdownMenu.innerHTML += '<a class="dropdown-item" href="#">Report user</a>' +
            '<a class="dropdown-item" href="#">Repost post</a>';

        threeDotsDiv.appendChild(dropdownButton);
        threeDotsDiv.appendChild(dropdownMenu);

        var postMediaDiv = document.createElement('div');
        postMediaDiv.className = 'post-media';

        if (data.image !== null && data.image !== '') {
            var postItem = document.createElement('div');
            postItem.className = 'post-item';
            var image = document.createElement('img');
            image.className = 'post-image';
            image.src = data.image;
            postItem.appendChild(image);
            postMediaDiv.appendChild(postItem);
        }

        if (data.video !== null && data.video !== '') {
            var postItem = document.createElement('div');
            postItem.className = 'post-item';
            var videoContainer = document.createElement('div');
            videoContainer.className = 'post-video';
            var video = document.createElement('video');
            video.setAttribute('data-my-Video-id', data.postId);
            video.id = 'myVideo-' + data.postId;
            video.className = 'w-100';
            var source = document.createElement('source');
            source.src = data.video;
            source.type = 'video/mp4';
            video.appendChild(source);
            videoContainer.appendChild(video);
            // videoContainer.innerHTML += 'Your browser does not support the video tag.';
            var videoControls = document.createElement('div');
            videoControls.className = 'video-controls';
            var rewindButton = document.createElement('button');
            rewindButton.id = 'rewindButton-' + data.postId;
            rewindButton.onclick = function() {
                rewind(data.postId);
            };
            rewindButton.innerHTML = '<i class="bi bi-rewind"></i>';
            videoControls.appendChild(rewindButton);
            var playPauseButton = document.createElement('button');
            playPauseButton.onclick = function() {
                togglePlayPause(data.postId);
            };
            playPauseButton.innerHTML = '<span id="playPauseButton-' + data.postId + '"><i class="bi bi-play"></i></span>';
            videoControls.appendChild(playPauseButton);
            var fastForwardButton = document.createElement('button');
            fastForwardButton.id = 'fastForwardButton-' + data.postId;
            fastForwardButton.onclick = function() {
                fastForward(data.postId);
            };
            fastForwardButton.innerHTML = '<i class="bi bi-fast-forward"></i>';
            videoControls.appendChild(fastForwardButton);
            var volumeControl = document.createElement('div');
            volumeControl.className = 'volume-control';
            var volumeRange = document.createElement('input');
            volumeRange.type = 'range';
            volumeRange.id = 'volumeRange-' + data.postId;
            volumeRange.min = '0';
            volumeRange.max = '1';
            volumeRange.step = '0.01';
            volumeRange.value = '1';
            volumeRange.onchange = function() {
                setVolume(data.postId);
            };
            volumeControl.appendChild(volumeRange);
            videoControls.appendChild(volumeControl);
            var timeControl = document.createElement('div');
            timeControl.className = 'time-control';
            var timeRange = document.createElement('input');
            timeRange.type = 'range';
            timeRange.id = 'timeRange-' + data.postId;
            timeRange.min = '0';
            timeRange.step = '0.01';
            timeRange.value = '0';
            timeRange.onchange = function() {
                setCurrentTime(data.postId);
            };
            timeControl.appendChild(timeRange);
            var timeDisplay = document.createElement('div');
            timeDisplay.className = 'time-display';
            var currentTimeDisplay = document.createElement('div');
            currentTimeDisplay.className = 'currentTimeDisplay';
            currentTimeDisplay.id = 'currentTimeDisplay-' + data.postId;
            currentTimeDisplay.innerHTML = '0:00';
            timeDisplay.appendChild(currentTimeDisplay);
            timeDisplay.innerHTML += '<div class="slash">/</div>';
            var durationDisplay = document.createElement('div');
            durationDisplay.className = 'durationDisplay';
            durationDisplay.id = 'durationDisplay-' + data.postId;
            durationDisplay.innerHTML = '0:00';
            timeDisplay.appendChild(durationDisplay);
            timeControl.appendChild(timeDisplay);
            videoControls.appendChild(timeControl);
            videoContainer.appendChild(videoControls);
            postItem.appendChild(videoContainer);
            postMediaDiv.appendChild(postItem);

            var previousButton = document.createElement('button');
            previousButton.className = 'previous-button';
            previousButton.innerHTML = '<i class="bi bi-arrow-left"></i>';

            var nextButton = document.createElement('button');
            nextButton.className = 'next-button';
            nextButton.innerHTML = '<i class="bi bi-arrow-right"></i>';

            var button = document.createElement('div');
            button.className = 'button';

            button.appendChild(previousButton);
            button.appendChild(nextButton);
            postMediaDiv.appendChild(button);

            var postItems = postMediaDiv.getElementsByClassName('post-item');
            var currentIndex = 0;

            previousButton.addEventListener('click', function() {
                if (currentIndex > 0) {
                    postItems[currentIndex].style.display = 'none';
                    currentIndex--;
                    postItems[currentIndex].style.display = 'block';
                    postItems[currentIndex].scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });

            nextButton.addEventListener('click', function() {
                if (currentIndex < postItems.length - 1) {
                    postItems[currentIndex].style.display = 'none';
                    currentIndex++;
                    postItems[currentIndex].style.display = 'block';
                    postItems[currentIndex].scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        }

        var mediaItems = postMediaDiv.getElementsByClassName('post-item');
        console.log(mediaItems.length);
        for (var i = 1; i < mediaItems.length; i++) {
            mediaItems[i].style.display = 'none';
        }

        var postContentDiv = document.createElement('div');
        postContentDiv.className = 'post-content';
        postContentDiv.textContent = data.content;

        var postDateDiv = document.createElement('div');
        postDateDiv.className = 'post-date';
        postDateDiv.textContent = data.timeAgo;

        var footerDiv = document.createElement('div');
        footerDiv.className = 'footer';

        var likeButton = document.createElement('button');
        likeButton.type = 'button';
        likeButton.className = 'btn btn-primary like ' + (data.isLiking ? 'likeing' : 'unlike');
        likeButton.dataset.postid = data.postId;
        likeButton.innerHTML = '<span class="like-count">' + data.likes + '</span>' +
            (data.isLiking ? '<span class="emoji"><img src="icons/love.png"></span>' : '<span class="emoji"><img src="icons/unlove.png"></span>');
        likeButton.addEventListener('click', function() {
            likepost(data.postId);
        });

        var shareButton = document.createElement('button');
        shareButton.type = 'button';
        shareButton.className = 'btn btn-primary share-button';
        shareButton.dataset.postid = data.postId;
        shareButton.innerHTML = '<i class="bi bi-share"></i> Share';

        var commentButton = document.createElement('button');
        commentButton.type = 'button';
        commentButton.className = 'btn btn-primary comment-button';
        commentButton.dataset.postid = data.postId;
        commentButton.innerHTML = '<i class="bi bi-chat-dots"></i> Comment';

        footerDiv.appendChild(likeButton);
        footerDiv.appendChild(shareButton);
        footerDiv.appendChild(commentButton);

        postDiv.appendChild(newsFeedPostDiv);
        newsFeedPostDiv.appendChild(postHeaderDiv);
        postHeaderDiv.appendChild(threeDotsDiv);
        var postTitleDiv = document.createElement('div');
        postTitleDiv.className = 'post-title';

        var postTitleH2 = document.createElement('h2');
        postTitleH2.textContent = data.title;

        postTitleDiv.appendChild(postTitleH2);
        postDiv.appendChild(postTitleDiv);
        postDiv.appendChild(postMediaDiv);
        postDiv.appendChild(postContentDiv);
        postDiv.appendChild(postDateDiv);
        postDiv.appendChild(footerDiv);
        postElement.appendChild(postDiv);

        newsFeed.appendChild(postElement);
        checkIfItIsClicked(data.postId);

        let myVideo;

        function togglePlayPause(postId) {
            const playPauseButton = document.getElementById("playPauseButton-" + postId);
            const myVideo = document.getElementById("myVideo-" + postId);

            if (myVideo.paused) {
                myVideo.play();
                playPauseButton.innerHTML = "<i class='bi bi-pause-circle-fill'></i>";
            } else {
                myVideo.pause();
                playPauseButton.innerHTML = "<i class='bi bi-play'></i>";
            }
        }

        function rewind(postId) {
            const myVideo = document.getElementById("myVideo-" + postId);
            myVideo.currentTime -= 10;
        }

        function fastForward(postId) {
            const myVideo = document.getElementById("myVideo-" + postId);
            myVideo.currentTime += 10;
        }

        function setVolume(postId) {
            var video = document.getElementById('myVideo-' + postId);
            var volumeRange = document.getElementById('volumeRange-' + postId);

            video.volume = volumeRange.value;
        }

        window.addEventListener('DOMContentLoaded', function() {
            var videos = document.getElementsByTagName('video');

            for (var i = 0; i < videos.length; i++) {
                var video = videos[i];
                var postId = data.postId;
                var volumeRange = document.getElementById('volumeRange-' + postId);

                video.addEventListener('volumechange', function() {
                    volumeRange.value = video.volume;
                });

                volumeRange.oninput = function() {
                    setVolume(postId);
                };
            }
        });


        function setCurrentTime(postId) {
            var video = document.getElementById('myVideo-' + postId);
            var timeRange = document.getElementById('timeRange-' + postId);
            var currentTimeDisplay = document.getElementById('currentTimeDisplay-' + postId);

            var newTime = video.duration * (timeRange.value / 100);

            video.currentTime = newTime;

            currentTimeDisplay.innerHTML = formatTime(video.currentTime);
        }

        function formatTime(time) {
            var minutes = Math.floor(time / 60);
            var seconds = Math.floor(time % 60);

            minutes = String(minutes).padStart(2, '0');
            seconds = String(seconds).padStart(2, '0');

            return minutes + ':' + seconds;
        }


        function handleTimeUpdate(postId) {
            var video = document.getElementById('myVideo-' + postId);
            var timeRange = document.getElementById('timeRange-' + postId);
            var currentTimeDisplay = document.getElementById('currentTimeDisplay-' + postId);

            var currentTime = video.currentTime;
            var duration = video.duration;
            var progress = (currentTime / duration) * 100;

            timeRange.value = progress;

            currentTimeDisplay.innerHTML = formatTime(currentTime);
        }

        var videos = document.getElementsByTagName('video');

        for (var i = 0; i < videos.length; i++) {
            var video = videos[i];
            var postId = data.postId;
            var timeRange = document.getElementById('timeRange-' + postId);
            var durationDisplay = document.getElementById('durationDisplay-' + postId);
            var currentTimeDisplay = document.getElementById('currentTimeDisplay-' + postId);

            video.addEventListener('loadedmetadata', function() {
                durationDisplay.innerHTML = formatTime(video.duration);
            });

            video.addEventListener('timeupdate', function() {
                handleTimeUpdate(postId);
            });

            timeRange.oninput = function() {
                var newTime = video.duration * (timeRange.value / 100);
                video.currentTime = newTime;
                currentTimeDisplay.innerHTML = formatTime(newTime);
            };
        }
    }


    function updateLikeCount(postId, likeCount) {
        console.log('Updating Like count for', postId);
        var post = document.getElementById(postId);
        if (post) {
            console.log('post div found');
            var likeBtn = post.querySelector('.like');
            var likeCountSpan = likeBtn.querySelector('.like-count');
            if (likeCountSpan) {
                likeCountSpan.textContent = likeCount;
            } else {
                console.log('No buttonElement found');
            }
        } else {
            console.log('no post with postId found');
        }

    }

    $(document).ready(function() {
        var recipientId = "<?php echo $UserId ?>";
        var followBtn = $("#followBtn");

        $(".follow").click(function() {
            // alert("Button is working!");
            $.ajax({
                url: "follow.php",
                type: "POST",
                data: {
                    follow: 1,
                    unfollow: 1,
                    profileOwnerId: profileOwnerId,
                    recipientId: recipientId
                },
                success: function(response) {
                    alert(response);

                    if (response == "followed") {
                        followBtn.removeClass("btn-primary").addClass("btn-secondary").text("Unfollow");
                    } else if (response == "unfollowed") {
                        followBtn.removeClass("btn-secondary").addClass("btn-primary").text("Follow");
                    }

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });
        });
    });

    $(document).ready(function() {
        $("#search").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            if (value === "") {
                $("#user_table").html("");
            } else {
                $("#user_table tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            }
        });
    });
</script>