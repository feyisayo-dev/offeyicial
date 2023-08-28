<?php
session_start();
include 'db.php';
$UserId = $_SESSION['UserId'];
// $UserIdx = $_GET['UserIdx'];
// Get the name of the user you are talking to
$sql = "select Surname, First_Name, Passport FROM User_Profile WHERE UserId = '$UserId'";
$stmt = sqlsrv_prepare($conn, $sql);
if (sqlsrv_execute($stmt)) {
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $recipientSurname = $row['Surname'];
        $recipientFirstName = $row['First_Name'];
        $Passport = $row['Passport'];
        if (empty($Passport)) {
            $recipientPassport = "UserPassport/DefaultImage.png";
        } else {
            $recipientPassport = "UserPassport/" . $Passport;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>News feed</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/favicon.svg" type="image/x-icon" />
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
    <!-- Bootstrap core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <style>
        @font-face {
            font-family: 'Modern-Age';
            src: url('fonts/Modern-Age.ttf');
        }

        /* CSS Reset */
        *,
        *::after,
        *::before {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        *,
        button,
        input,
        select,
        textarea {
            font-family: 'Roboto', sans-serif;
        }

        /* Vars */
        :root {
            --primary: hsl(0, 0%, 100%);
            --secondary: hsl(0, 0%, 98%);
            --border: hsl(0, 0%, 86%);

            --story-border: hsl(0, 0%, 78%);
            --img-border: hsla(0, 0%, 0%, 0.1);

            --text-dark: hsl(0, 0%, 15%);
            --text-light: hsl(0, 0%, 60%);

            --like: hsl(355, 82%, 61%);
            --link: hsl(204, 100%, 48%);

            --header-height: 44px;
            --nav-height: 44px;
        }

        :root.darkTheme {
            --primary: hsl(0, 0%, 0%);
            --secondary: hsl(0, 0%, 2%);
            --border: hsl(0, 0%, 15%);

            --story-border: hsl(0, 0%, 44%);
            --img-border: hsla(0, 0%, 100%, 0.1);

            --text-dark: hsl(0, 0%, 98%);
            --text-light: hsl(0, 0%, 60%);
        }

        /* -------------------------------------------------- */

        /* General Styles */
        body {
            min-height: 100vh;

            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        svg {
            display: block;
        }

        img {
            max-width: 100%;
        }

        /* -------------------------------------------------- */

        /* Header Navbar */
        .header {
            width: 100%;
            height: var(--header-height);
            background-color: var(--primary);

            display: flex;
            justify-content: center;

            position: fixed;
            top: 0;
            left: 0;
            z-index: 2;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: 0;

            width: 100%;
            height: 1px;
            background-color: var(--border);
        }

        .header__content {
            width: 100%;
            max-width: 975px;

            padding: 0 14px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header__home {
            margin-top: 5px;
            text-decoration: none;
        }

        .header__home p {
            font-size: 24px;
            color: green;
            font-family: Modern-Age;
        }

        .header__theme-button {
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .header__theme-button-sun {
            display: none;
        }

        .header__theme-button-moon {
            display: unset;
        }

        :root.darkTheme .header__theme-button-sun {
            display: unset;
        }

        :root.darkTheme .header__theme-button-moon {
            display: none;
        }

        .header__search {
            width: 216px;
            height: 28px;

            display: none;
            align-items: center;
            position: relative;
        }

        .header__search svg {
            width: 12px;
            height: 12px;

            position: absolute;
            left: 8px;
        }

        .header__search input {
            width: 100%;
            height: 100%;
            background-color: var(--secondary);

            padding: 4px 10px 4px 28px;
            border: 1px solid var(--border);
            border-radius: 4px;
            outline: none;

            font-size: 12px;
            font-weight: 300;
            text-decoration: none;
            color: var(--text-light);

            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        .header__search input:focus {
            color: var(--text-dark);
        }

        .header__buttons {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* Bottom Navbar */
        .navbar {
            width: 100%;
            height: var(--nav-height);
            background-color: var(--primary);

            display: flex;
            position: fixed;
            bottom: 0;
            left: 0;
            z-index: 2;
        }

        .navbar::after {
            content: '';
            position: absolute;
            top: 0;

            width: 100%;
            height: 1px;
            background-color: var(--border);
        }

        .navbar__button {
            flex: 1 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .navbar__button.profile-button .profile-button__border {
            width: 28px;
            height: 28px;
            border-width: 2px;
        }

        /* Main Content */
        .main-container {
            background-color: var(--primary);

            margin-top: var(--header-height);
            margin-bottom: var(--nav-height);

            display: flex;
            flex: 1;
        }

        .content-container {
            width: 100%;
            max-width: 935px;

            padding: 0 0 8px;

            margin: 0 auto;
            display: flex;
        }

        .content {
            width: 100%;
            max-width: 614px;

            margin: 0 auto;
            display: flex;
            flex-direction: column;
        }

        .stories {
            width: 100%;
            background-color: var(--primary);
            padding: 16px 0;
            flex-shrink: 0;

            position: relative;
            overflow: hidden;
        }

        .stories::after {
            content: '';
            position: absolute;
            bottom: 0;

            width: 100%;
            height: 1px;
            background-color: var(--border);
        }

        .stories__content {
            display: flex;
            overflow-x: auto;
            overflow-y: hidden;
            gap: 16px;
            padding: 0 16px;
            position: relative;

            scroll-behavior: smooth;
            scrollbar-width: none;
        }

        .stories__content::-webkit-scrollbar {
            display: none;
        }

        .posts {
            display: flex;
            flex-direction: column;
            flex: 1;
            gap: 8px;
        }

        .stories__left-button,
        .post__left-button,
        .stories__right-button,
        .post__right-button {
            width: 24px;
            height: 24px;
            display: none;

            background-color: transparent;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            filter: drop-shadow(0px 0px 5px rgba(0, 0, 0, 0.5));

            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
        }

        .stories__left-button {
            left: 10px;
        }

        .stories__right-button {
            right: 10px;
        }

        .post__left-button {
            left: 16px;
            opacity: 0.7;
        }

        .post__right-button {
            right: 16px;
            opacity: 0.7;
        }

        /* Components */
        /* Story */
        .story {
            background-color: transparent;
            border: none;
            cursor: pointer;

            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .story__avatar {
            position: relative;
        }

        .story__border {
            width: 64px;
            height: 64px;

            fill: none;
            stroke: var(--story-border);
            stroke-width: 1.5;
        }

        .story--has-story .story__border {
            stroke: url(#--story-gradient);
            stroke-width: 2;
        }

        .story__picture {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);

            width: 56px;
            height: 56px;
            border-radius: 50%;
            overflow: hidden;
        }

        .story__picture::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;

            border: 1px solid var(--img-border);
            border-radius: 50%;
        }

        .story__user {
            font-size: 12px;
            font-weight: 400;
            color: var(--text-light);
            text-transform: lowercase;

            max-width: 72px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        .story--has-story .story__user {
            color: var(--text-dark);
        }

        /* Post */
        .post {
            width: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .post__header {
            background-color: var(--primary);
            border-bottom: 1px solid var(--border);

            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px;
        }

        .post__profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .post__avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
        }

        .post__avatar::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;

            border: 1px solid var(--img-border);
            border-radius: 50%;
        }

        .post__user {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-dark);
            text-decoration: none;
            text-transform: lowercase;
        }

        .post__user:hover {
            text-decoration: underline;
        }

        .post__more-options {
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .post__content {
            display: flex;
            position: relative;
        }

        .post__medias {
            display: flex;
            overflow-y: hidden;
            overflow-x: auto;

            width: 100%;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            scrollbar-width: none;
        }

        .post__medias::-webkit-scrollbar {
            display: none;
        }

        .post__media {
            width: 100%;
            flex: none;
            scroll-snap-align: start;
            scroll-snap-stop: always;
        }

        .post__footer {
            background-color: var(--primary);
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 0 4px;
        }

        .post__buttons {
            display: flex;
            position: relative;
        }

        .post__button {
            background-color: transparent;
            border: none;
            cursor: pointer;

            padding: 8px;
        }

        .post__button--align-right {
            margin-left: auto;
        }

        .post__indicators {
            display: flex;
            align-items: center;
            gap: 4px;

            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -100%);
        }

        .post__indicator {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: var(--text-light);
        }

        .post__indicator--active {
            background-color: var(--link);
        }

        .post__infos {
            display: flex;
            flex-direction: column;
            padding: 0 8px;
            gap: 10px;
        }

        .post__likes,
        .post__description {
            display: flex;
        }

        .post__likes {
            align-items: center;
            gap: 6px;
        }

        .post__likes-avatar {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
        }

        .post__likes-avatar::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;

            border: 1px solid var(--img-border);
            border-radius: 50%;
        }

        .post__likes span,
        .post__description span {
            font-size: 14px;
            font-weight: 400;
            color: var(--text-dark);
        }

        .post__likes a,
        .post__description a {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-dark);
            text-decoration: none;
        }

        .post__name--underline:hover {
            text-decoration: underline;
        }

        .post__date-time {
            font-size: 10px;
            font-weight: 400;
            color: var(--text-light);
            text-transform: uppercase;
        }

        /* Side Menu */
        .side-menu {
            max-width: 290px;
            position: fixed;
            left: 50%;
            top: 84px;
            transform: translateX(calc(-50% + 322px));

            display: none;
            flex-direction: column;
        }

        .side-menu__user-profile {
            display: flex;
            align-items: center;

            margin: 20px 0 22px;
        }

        .side-menu__user-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;

            margin-right: 12px;
            flex-shrink: 0;

            overflow: hidden;
            position: relative;
        }

        .side-menu__user-avatar::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;

            border: 1px solid var(--img-border);
            border-radius: 50%;
        }

        .side-menu__user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            flex: 1;
            gap: 4px;
        }

        .side-menu__user-info a {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-dark);
            text-decoration: none;
            text-transform: lowercase;

            max-width: 180px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        .side-menu__user-info span {
            font-size: 14px;
            font-weight: 400;
            color: var(--text-light);

            max-width: 180px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        .side-menu__user-button {
            background-color: transparent;
            border: none;
            cursor: pointer;

            font-size: 12px;
            font-weight: 500;
            color: var(--link);

            flex-shrink: 0;
        }

        .side-menu__suggestions-section {
            display: flex;
            flex-direction: column;
        }

        .side-menu__suggestions-header {
            display: flex;
            justify-content: space-between;
        }

        .side-menu__suggestions-header h2 {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-light);
        }

        .side-menu__suggestions-header button {
            background-color: transparent;
            border: none;
            cursor: pointer;

            font-size: 12px;
            font-weight: 500;
            color: var(--text-dark);
        }

        .side-menu__suggestions-content {
            display: flex;
            flex-direction: column;
            gap: 16px;

            margin: 16px 0 24px;
            padding-left: 4px;
        }

        .side-menu__suggestion {
            display: flex;
            align-items: center;
        }

        .side-menu__suggestion-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;

            margin-right: 12px;
            flex-shrink: 0;

            overflow: hidden;
            position: relative;
        }

        .side-menu__suggestion-avatar::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;

            border: 1px solid var(--img-border);
            border-radius: 50%;
        }

        .side-menu__suggestion-info {
            display: flex;
            align-items: flex-start;
            flex-direction: column;
            flex: 1;
            gap: 2px;
        }

        .side-menu__suggestion-info a {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-dark);
            text-decoration: none;
            text-transform: lowercase;

            max-width: 180px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        .side-menu__suggestion-info a:hover {
            text-decoration: underline;
        }

        .side-menu__suggestion-info span {
            font-size: 12px;
            font-weight: 400;
            color: var(--text-light);

            max-width: 180px;
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }

        .side-menu__suggestion-button {
            background-color: transparent;
            border: none;
            cursor: pointer;

            font-size: 12px;
            font-weight: 500;
            color: var(--link);

            flex-shrink: 0;
        }

        .side-menu__footer {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .side-menu__footer-links {
            display: flex;
        }

        .side-menu__footer-list {
            list-style: none;
        }

        .side-menu__footer-item {
            display: inline-block;
        }

        .side-menu__footer-item:not(:last-of-type)::after {
            content: '\00B7';
            margin: 0 0.5px;
        }

        .side-menu__footer-item,
        .side-menu__footer-link,
        .side-menu__footer-copyright {
            font-size: 11px;
            font-weight: 400;
            color: var(--text-light);
            text-decoration: none;
        }

        .side-menu__footer-copyright {
            text-transform: uppercase;
        }

        /* Profile Button */
        .profile-button {
            background-color: transparent;
            border: none;
            outline: none;
            cursor: pointer;
            position: relative;
        }

        .profile-button__border {
            display: none;

            width: 30px;
            height: 30px;
            border: 1px solid var(--text-dark);
            border-radius: 50%;

            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .profile-button:focus .profile-button__border {
            display: block;
        }

        .profile-button__picture {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            position: relative;
        }

        .profile-button__picture::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;

            border: 1px solid var(--img-border);
            border-radius: 50%;
        }

        /* Media Queries */
        @media (max-width: 767px) {
            .header__buttons--desktop {
                display: none;
            }

            /* Fix post medias indicators bugs on mobile */
            .post__medias {
                gap: 1px;
            }
        }

        @media (min-width: 620px) {
            .content-container {
                padding: 30px 0 24px;
            }

            .content {
                gap: 24px;
            }

            .stories {
                border: 1px solid var(--border);
                border-radius: 4px;
            }

            .stories::after {
                content: none;
            }

            .posts {
                gap: 24px;
            }

            .post {
                border: 1px solid var(--border);
                border-radius: 4px;
            }

            .post__footer {
                padding: 4px 8px 12px;
            }

            .post__date-time {
                margin-top: 6px;
            }
        }

        @media (min-width: 768px) {
            :root {
                --header-height: 54px;
                --nav-height: 0px;
            }

            .header__content {
                padding: 0 20px;
            }

            .header__search {
                display: flex;
            }

            .header__buttons--mobile {
                display: none;
            }

            .navbar {
                display: none;
            }
        }

        @media (min-width: 1024px) {
            .main-container {
                background-color: var(--secondary);
            }

            .content {
                margin: unset;
            }

            .side-menu {
                display: flex;
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <nav class="header__content">
            <div class="header__buttons">
                <a href="index.html" class="header__home">
                    <!-- <img src="img/offeyicial.png" class="brand-img" alt=""> -->
                    <p>Offeyicial</p>
                </a>

                <button class="header__theme-button" title="Toggle Theme">
                    <svg class="header__theme-button-moon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="var(--text-dark)" viewBox="0 0 16 16">
                        <path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278zM4.858 1.311A7.269 7.269 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.316 7.316 0 0 0 5.205-2.162c-.337.042-.68.063-1.029.063-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286z" />
                    </svg>
                    <svg class="header__theme-button-sun" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="var(--text-dark)" viewBox="0 0 16 16">
                        <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
                    </svg>
                </button>
            </div>

            <div class="header__search">
                <input type="text" placeholder="Search" />
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M21.669 21.6543C21.8625 21.4622 21.863 21.1494 21.6703 20.9566L17.3049 16.5913C18.7912 14.9327 19.7017 12.7525 19.7017 10.3508C19.7017 5.18819 15.5135 1 10.3508 1C5.18819 1 1 5.18819 1 10.3508C1 15.5135 5.18819 19.7017 10.3508 19.7017C12.7624 19.7017 14.9475 18.7813 16.606 17.2852L20.9739 21.653C21.1657 21.8449 21.4765 21.8454 21.669 21.6543ZM1.9843 10.3508C1.9843 5.7394 5.7394 1.9843 10.3508 1.9843C14.9623 1.9843 18.7174 5.7394 18.7174 10.3508C18.7174 14.9623 14.9623 18.7174 10.3508 18.7174C5.7394 18.7174 1.9843 14.9623 1.9843 10.3508Z" fill="#A5A5A5" stroke="#A5A5A5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>

            <div class="header__buttons header__buttons--mobile">
                <a href="#">
                    <img width="40" height="40" src="icons/add.png" class="icon" alt="">
                </a>
                <a href="#">
                    <img width="40" height="40" src="icons/notification.gif" class="icon" alt="">
                </a>
                <a href="#">
                    <img width="40" height="40" src="icons/messages.png" class="icon" alt="">
                </a>
            </div>

            <div class="header__buttons header__buttons--desktop">
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="40" viewBox="0 0 100 100">
                        <path fill="#c8ede6" d="M86.876,56.546c0.3-0.616,0.566-1.264,0.796-1.943c2.633-7.77-1.349-17.078-9.733-19.325c-0.906-11.384-8.906-19.193-17.941-20.526c-10.341-1.525-19.814,5.044-22.966,15.485c-3.799-1.346-7.501-1.182-10.99,0.857c-1.583,0.732-3.031,1.812-4.33,3.233c-1.907,2.086-3.147,4.719-3.652,7.495c-0.748,0.118-1.483,0.236-2.176,0.484c-4.04,1.449-6.589,4.431-7.288,8.923c-0.435,2.797,0.443,5.587,0.933,6.714c1.935,4.455,6.422,6.98,10.981,6.312c0.227-0.033,0.557,0.069,0.752,0.233c0.241,7.12,3.698,13.417,8.884,17.014c8.321,5.772,19.027,3.994,25.781-3.921c2.894,2.96,6.338,4.398,10.384,3.876c4.023-0.519,7.147-2.739,9.426-6.349c1.053,0.283,2.051,0.691,3.083,0.804c4.042,0.442,7.118-1.311,9.732-4.8c1.488-1.986,1.779-5.145,1.793-6.354C90.384,61.503,89.053,58.536,86.876,56.546z"></path>
                        <path fill="#fdfcef" d="M72.986,65.336c0,0,11.691,0,11.762,0c2.7,0,4.888-2.189,4.888-4.889c0-2.355-1.666-4.321-3.884-4.784c0.026-0.206,0.043-0.415,0.043-0.628c0-2.796-2.267-5.063-5.063-5.063c-1.651,0-3.113,0.794-4.037,2.017c-0.236-3.113-3.017-5.514-6.27-5.116c-2.379,0.291-4.346,2.13-4.784,4.486c-0.14,0.756-0.126,1.489,0.014,2.177c-0.638-0.687-1.546-1.119-2.557-1.119c-1.85,0-3.361,1.441-3.48,3.261c-0.84-0.186-1.754-0.174-2.717,0.188c-1.84,0.691-3.15,2.423-3.227,4.387c-0.109,2.789,2.12,5.085,4.885,5.085c0.21,0,0.948,0,1.118,0H69.83"></path>
                        <path fill="#472b29" d="M84.748,65.836H72.986c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h11.762c2.419,0,4.388-1.969,4.388-4.389c0-2.066-1.466-3.873-3.486-4.296c-0.254-0.053-0.425-0.292-0.394-0.551c0.023-0.186,0.039-0.373,0.039-0.566c0-2.516-2.047-4.562-4.563-4.562c-1.438,0-2.765,0.663-3.638,1.818c-0.125,0.166-0.338,0.237-0.54,0.178c-0.199-0.059-0.342-0.234-0.357-0.441c-0.104-1.378-0.779-2.672-1.851-3.55c-1.083-0.888-2.453-1.281-3.859-1.108c-2.167,0.266-3.956,1.943-4.353,4.08c-0.124,0.669-0.12,1.338,0.012,1.987c0.045,0.22-0.062,0.442-0.261,0.544c-0.2,0.105-0.443,0.06-0.595-0.104c-0.574-0.618-1.352-0.959-2.19-0.959c-1.569,0-2.878,1.227-2.981,2.793c-0.01,0.146-0.082,0.28-0.199,0.367c-0.117,0.088-0.268,0.119-0.408,0.089c-0.84-0.185-1.637-0.132-2.433,0.167c-1.669,0.627-2.836,2.209-2.903,3.938c-0.047,1.207,0.387,2.351,1.222,3.219c0.835,0.868,1.959,1.347,3.164,1.347H69.83c0.276,0,0.5,0.224,0.5,0.5s-0.224,0.5-0.5,0.5H58.561c-1.479,0-2.858-0.587-3.884-1.653c-1.025-1.066-1.558-2.47-1.5-3.951c0.083-2.126,1.51-4.069,3.551-4.835c0.8-0.3,1.628-0.399,2.468-0.299c0.376-1.822,1.997-3.182,3.905-3.182c0.685,0,1.354,0.18,1.944,0.51c0-0.386,0.035-0.772,0.107-1.159c0.476-2.562,2.62-4.573,5.215-4.891c1.682-0.208,3.319,0.266,4.615,1.327c1.004,0.823,1.717,1.951,2.039,3.194c1.012-0.916,2.319-1.426,3.714-1.426c3.067,0,5.563,2.495,5.563,5.562c0,0.084-0.002,0.166-0.007,0.248c2.254,0.674,3.848,2.778,3.848,5.165C90.137,63.419,87.72,65.836,84.748,65.836z"></path>
                        <path fill="#fdfcef" d="M70.153,54.567c-1.808-0.119-3.365,1.13-3.476,2.789c-0.014,0.206-0.005,0.409,0.025,0.606c-0.349-0.394-0.865-0.661-1.458-0.7c-1.085-0.071-2.022,0.645-2.158,1.62c-0.197-0.054-0.403-0.09-0.616-0.104c-1.582-0.104-2.944,0.989-3.042,2.441"></path>
                        <path fill="#472b29" d="M59.429,61.468c-0.006,0-0.012,0-0.017-0.001c-0.138-0.009-0.242-0.128-0.233-0.266c0.106-1.587,1.592-2.782,3.307-2.673c0.135,0.008,0.271,0.025,0.409,0.053c0.274-0.969,1.255-1.648,2.366-1.568c0.425,0.027,0.823,0.16,1.163,0.382c0.001-0.019,0.002-0.037,0.003-0.056c0.12-1.793,1.796-3.17,3.742-3.021c0.138,0.009,0.242,0.128,0.233,0.266s-0.14,0.253-0.266,0.232c-1.681-0.092-3.109,1.039-3.21,2.558c-0.013,0.184-0.005,0.369,0.023,0.551c0.017,0.109-0.041,0.217-0.141,0.265c-0.1,0.046-0.219,0.023-0.293-0.061c-0.318-0.359-0.788-0.584-1.288-0.617c-0.929-0.036-1.775,0.555-1.894,1.405c-0.01,0.071-0.05,0.135-0.11,0.175c-0.061,0.04-0.134,0.051-0.204,0.032c-0.191-0.052-0.381-0.084-0.567-0.097c-1.435-0.085-2.687,0.896-2.776,2.208C59.669,61.367,59.56,61.468,59.429,61.468z"></path>
                        <path fill="#fdfcef" d="M86.728,56.236c-1.699-0.801-3.664-0.234-4.389,1.267c-0.09,0.186-0.157,0.379-0.201,0.574"></path>
                        <path fill="#472b29" d="M82.138,58.326c-0.018,0-0.037-0.002-0.056-0.006c-0.135-0.031-0.219-0.165-0.188-0.3c0.049-0.216,0.123-0.427,0.219-0.626c0.782-1.621,2.9-2.242,4.721-1.385c0.125,0.06,0.179,0.208,0.12,0.333c-0.059,0.125-0.209,0.177-0.333,0.12c-1.574-0.743-3.394-0.227-4.058,1.148c-0.08,0.166-0.141,0.341-0.182,0.521C82.355,58.247,82.252,58.326,82.138,58.326z"></path>
                        <path fill="#fff" d="M16.541 48.582H6.511c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h10.031c.276 0 .5.224.5.5S16.818 48.582 16.541 48.582zM19.422 48.582h-1.446c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.446c.276 0 .5.224.5.5S19.699 48.582 19.422 48.582zM23.477 48.582h-2.546c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h2.546c.276 0 .5.224.5.5S23.753 48.582 23.477 48.582zM23.477 50.447h-9.616c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h9.616c.276 0 .5.224.5.5S23.753 50.447 23.477 50.447zM12.129 50.447h-.58c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h.58c.276 0 .5.224.5.5S12.406 50.447 12.129 50.447zM9.752 50.447H8.296c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.456c.276 0 .5.224.5.5S10.029 50.447 9.752 50.447zM18.888 46.717h-5.027c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h5.027c.276 0 .5.224.5.5S19.164 46.717 18.888 46.717zM18.888 44.852h-1.257c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.257c.276 0 .5.224.5.5S19.164 44.852 18.888 44.852zM15.62 52.312h-1.759c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.759c.276 0 .5.224.5.5S15.896 52.312 15.62 52.312zM69.719 22.305h-10.03c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h10.03c.276 0 .5.224.5.5S69.996 22.305 69.719 22.305zM72.601 22.305h-1.446c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.446c.276 0 .5.224.5.5S72.877 22.305 72.601 22.305zM76.655 22.305h-2.546c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h2.546c.276 0 .5.224.5.5S76.931 22.305 76.655 22.305zM74.629 18.576h-9.617c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h9.617c.276 0 .5.224.5.5S74.906 18.576 74.629 18.576zM63.281 18.576h-.58c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h.58c.276 0 .5.224.5.5S63.558 18.576 63.281 18.576zM60.904 18.576h-1.456c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.456c.276 0 .5.224.5.5S61.181 18.576 60.904 18.576zM72.066 20.44h-5.027c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h5.027c.276 0 .5.224.5.5S72.342 20.44 72.066 20.44z"></path>
                        <path fill="#fff" d="M72.066 18.576h-1.257c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.257c.276 0 .5.224.5.5S72.342 18.576 72.066 18.576zM65.583 20.44h-1.759c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.759c.276 0 .5.224.5.5S65.86 20.44 65.583 20.44z"></path>
                        <path fill="#fdfcee" d="M28.728 46.696H53.954V67.939H28.728z"></path>
                        <path fill="#472b29" d="M54.455,68.439H28.228V46.196h26.227V68.439z M29.228,67.439h24.227V47.196H29.228V67.439z"></path>
                        <path fill="#472b29" d="M52.627,68.639H28.728c-0.387,0-0.7-0.313-0.7-0.7V46.696c0-0.387,0.313-0.7,0.7-0.7s0.7,0.313,0.7,0.7v20.543h23.199c0.387,0,0.7,0.313,0.7,0.7S53.014,68.639,52.627,68.639z"></path>
                        <path fill="#fdfcee" d="M53.955 46.696H77.19V69.267H53.955z"></path>
                        <path fill="#472b29" d="M77.189,69.967H53.955c-0.387,0-0.7-0.313-0.7-0.7V46.696c0-0.387,0.313-0.7,0.7-0.7h23.235c0.387,0,0.7,0.313,0.7,0.7v22.571C77.89,69.654,77.576,69.967,77.189,69.967z M54.655,68.567h21.834V47.396H54.655V68.567z"></path>
                        <path fill="#cdcbbd" d="M54.618 47.36H76.525V49.352H54.618z"></path>
                        <path fill="#ee3e54" d="M28.748 46.696L26.687 46.696 31.531 34.083 34.422 34.083 43.128 34.083 75.862 34.083 79.6 46.696 78.7 46.696z"></path>
                        <path fill="#472b29" d="M79.6,47.396H26.687c-0.23,0-0.446-0.113-0.577-0.304c-0.13-0.19-0.159-0.433-0.076-0.647l4.844-12.613c0.104-0.271,0.364-0.449,0.653-0.449h44.332c0.31,0,0.583,0.204,0.671,0.501l3.738,12.613c0.062,0.212,0.021,0.441-0.11,0.618C80.029,47.291,79.821,47.396,79.6,47.396z M27.705,45.995h50.957L75.34,34.783H32.012L27.705,45.995z"></path>
                        <path fill="#c0e5e4" d="M70.219 55.658L70.219 64.288 60.925 64.288 60.925 53.666 68.891 53.666"></path>
                        <path fill="#472b29" d="M70.219,64.638h-9.294c-0.193,0-0.35-0.156-0.35-0.35V53.666c0-0.193,0.157-0.35,0.35-0.35h7.966c0.193,0,0.35,0.156,0.35,0.35s-0.157,0.35-0.35,0.35h-7.616v9.923h8.594v-8.281c0-0.193,0.157-0.35,0.35-0.35s0.35,0.156,0.35,0.35v8.631C70.569,64.482,70.413,64.638,70.219,64.638z"></path>
                        <path fill="#472b29" d="M65.572,64.638c-0.193,0-0.35-0.156-0.35-0.35V53.666c0-0.193,0.157-0.35,0.35-0.35s0.35,0.156,0.35,0.35v10.622C65.922,64.482,65.766,64.638,65.572,64.638z"></path>
                        <path fill="#b2b1c2" d="M43.01,67.607V57.369c0-2.402-2.091-4.367-4.647-4.367c-2.556,0-4.647,1.965-4.647,4.367v10.238H43.01z"></path>
                        <path fill="#472b29" d="M43.01,67.956h-9.294c-0.193,0-0.35-0.156-0.35-0.35V57.37c0-2.601,2.242-4.717,4.997-4.717s4.997,2.116,4.997,4.717v10.237C43.36,67.8,43.203,67.956,43.01,67.956z M34.066,67.257h8.594V57.37c0-2.215-1.928-4.018-4.297-4.018s-4.297,1.803-4.297,4.018V67.257z"></path>
                        <path fill="#c0e5e4" d="M41.018,59.641v-1.124c0-1.603-1.195-2.915-2.655-2.915s-2.655,1.312-2.655,2.915v1.124H41.018z"></path>
                        <path fill="#472b29" d="M41.018 59.891h-5.311c-.138 0-.25-.112-.25-.25v-1.123c0-1.745 1.303-3.165 2.905-3.165s2.905 1.42 2.905 3.165v1.123C41.268 59.779 41.156 59.891 41.018 59.891zM35.957 59.391h4.811v-.873c0-1.47-1.079-2.665-2.405-2.665s-2.405 1.195-2.405 2.665V59.391zM41.682 62.546h-.664c-.138 0-.25-.112-.25-.25s.112-.25.25-.25h.664c.138 0 .25.112.25.25S41.82 62.546 41.682 62.546z"></path>
                        <path fill="#cdcbbd" d="M29.392 47.36H53.291V48.688H29.392z"></path>
                        <path fill="#c0e5e4" d="M50.976 60.305L46.329 60.305 46.329 54.33 51.64 54.33 51.64 58.977"></path>
                        <path fill="#472b29" d="M50.976,60.655h-4.647c-0.193,0-0.35-0.156-0.35-0.35V54.33c0-0.193,0.157-0.35,0.35-0.35h5.311c0.193,0,0.35,0.156,0.35,0.35v4.646c0,0.193-0.157,0.35-0.35,0.35s-0.35-0.156-0.35-0.35V54.68h-4.61v5.275h4.297c0.193,0,0.35,0.156,0.35,0.35S51.169,60.655,50.976,60.655z"></path>
                        <path fill="#472b29" d="M48.984,60.655c-0.193,0-0.35-0.156-0.35-0.35V54.33c0-0.193,0.157-0.35,0.35-0.35s0.35,0.156,0.35,0.35v5.975C49.334,60.498,49.178,60.655,48.984,60.655z"></path>
                        <path fill="#fdd4b2" d="M68.891 31.759H73.53800000000001V41.053H68.891z"></path>
                        <path fill="#472b29" d="M73.539,41.303h-4.647c-0.138,0-0.25-0.112-0.25-0.25v-9.294c0-0.138,0.112-0.25,0.25-0.25h4.647c0.138,0,0.25,0.112,0.25,0.25v9.294C73.789,41.191,73.677,41.303,73.539,41.303z M69.142,40.803h4.147v-8.794h-4.147V40.803z"></path>
                        <path fill="#fbb97f" d="M74.202,32.423h-5.975c-0.365,0-0.664-0.299-0.664-0.664v0c0-0.365,0.299-0.664,0.664-0.664h5.975c0.365,0,0.664,0.299,0.664,0.664v0C74.866,32.124,74.567,32.423,74.202,32.423z"></path>
                        <path fill="#472b29" d="M74.202 32.673h-5.975c-.504 0-.914-.41-.914-.914 0-.504.41-.914.914-.914h5.975c.504 0 .914.41.914.914C75.116 32.263 74.706 32.673 74.202 32.673zM68.227 31.345c-.228 0-.414.186-.414.414s.186.414.414.414h5.975c.229 0 .414-.186.414-.414s-.186-.414-.414-.414H68.227zM51.631 49.319H49.64c-.166 0-.3-.134-.3-.3s.134-.3.3-.3h1.992c.166 0 .3.134.3.3S51.797 49.319 51.631 49.319zM47.648 49.319H29.06c-.166 0-.3-.134-.3-.3s.134-.3.3-.3h18.588c.166 0 .3.134.3.3S47.813 49.319 47.648 49.319zM77.521 49.983h-17.26c-.166 0-.3-.134-.3-.3s.134-.3.3-.3h17.26c.166 0 .3.134.3.3S77.687 49.983 77.521 49.983zM66.9 37.37H32.379c-.166 0-.3-.134-.3-.3s.134-.3.3-.3H66.9c.166 0 .3.134.3.3S67.065 37.37 66.9 37.37zM64.908 39.362H31.716c-.166 0-.3-.134-.3-.3s.134-.3.3-.3h33.192c.166 0 .3.134.3.3S65.074 39.362 64.908 39.362zM63.58 41.353H31.052c-.166 0-.3-.134-.3-.3s.134-.3.3-.3H63.58c.166 0 .3.134.3.3S63.746 41.353 63.58 41.353zM58.269 49.983h-1.328c-.166 0-.3-.134-.3-.3s.134-.3.3-.3h1.328c.166 0 .3.134.3.3S58.435 49.983 58.269 49.983z"></path>
                        <path fill="#fdfcef" d="M32.762,70.807c1.782,0,3.328,0,3.35,0c1.997,0,3.615-1.595,3.615-3.563c0-1.717-1.232-3.149-2.872-3.487c0.019-0.15,0.032-0.302,0.032-0.458c0-2.038-1.676-3.691-3.744-3.691c-1.221,0-2.302,0.579-2.986,1.47c-0.175-2.269-2.231-4.019-4.637-3.729c-1.759,0.212-3.214,1.552-3.538,3.27c-0.104,0.551-0.093,1.085,0.01,1.587c-0.472-0.501-1.143-0.816-1.891-0.816c-1.369,0-2.485,1.05-2.574,2.377c-0.621-0.135-1.297-0.127-2.009,0.137c-1.361,0.503-2.33,1.766-2.387,3.198c-0.081,2.033,1.568,3.706,3.612,3.706c0.155,0,0.701,0,0.827,0h7.507 M26.633,70.807h0.34"></path>
                        <path fill="#472b29" d="M36.112,71.307h-3.35c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h3.35c1.718,0,3.115-1.374,3.115-3.063c0-1.441-1.04-2.702-2.474-2.998c-0.256-0.052-0.428-0.293-0.395-0.552c0.017-0.13,0.028-0.261,0.028-0.395c0-1.759-1.455-3.19-3.244-3.19c-1.024,0-1.968,0.464-2.589,1.274c-0.126,0.164-0.341,0.233-0.539,0.175c-0.199-0.06-0.34-0.234-0.356-0.441c-0.075-0.97-0.536-1.849-1.298-2.474c-0.776-0.638-1.768-0.921-2.78-0.798c-1.546,0.187-2.824,1.365-3.107,2.866c-0.088,0.469-0.085,0.938,0.009,1.393c0.045,0.22-0.061,0.441-0.259,0.545s-0.44,0.063-0.595-0.101c-0.4-0.425-0.943-0.658-1.527-0.658c-1.092,0-2.003,0.839-2.075,1.91c-0.01,0.146-0.082,0.279-0.199,0.366c-0.116,0.089-0.264,0.12-0.407,0.089c-0.598-0.129-1.164-0.093-1.729,0.117c-1.185,0.438-2.013,1.542-2.061,2.748c-0.033,0.833,0.269,1.624,0.848,2.228c0.595,0.618,1.399,0.959,2.265,0.959h8.334c0.276,0,0.5,0.224,0.5,0.5s-0.224,0.5-0.5,0.5h-8.334c-1.14,0-2.2-0.45-2.985-1.267c-0.771-0.802-1.17-1.853-1.126-2.959c0.063-1.605,1.153-3.07,2.712-3.646c0.575-0.212,1.167-0.289,1.769-0.237c0.336-1.33,1.557-2.308,2.988-2.308c0.457,0,0.905,0.103,1.312,0.293c0.01-0.219,0.035-0.438,0.077-0.657c0.363-1.925,1.995-3.436,3.97-3.673c1.288-0.162,2.545,0.206,3.534,1.017c0.696,0.571,1.206,1.336,1.47,2.181c0.749-0.606,1.684-0.941,2.678-0.941c2.34,0,4.244,1.88,4.244,4.19c0,0.027,0,0.054-0.001,0.08c1.67,0.538,2.842,2.099,2.842,3.864C40.227,69.484,38.381,71.307,36.112,71.307z M26.973,71.307h-0.34c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h0.34c0.276,0,0.5,0.224,0.5,0.5S27.249,71.307,26.973,71.307z"></path>
                        <path fill="#472b29" d="M34.496 65.765c-.018 0-.037-.002-.055-.006-.135-.03-.22-.164-.189-.299.036-.157.09-.312.161-.457.576-1.174 2.163-1.607 3.541-.966.125.059.18.207.121.332-.059.124-.208.177-.332.121-1.134-.527-2.425-.199-2.88.732-.054.11-.095.228-.122.347C34.714 65.686 34.611 65.765 34.496 65.765zM29.615 71.307h-1.048c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.048c.276 0 .5.224.5.5S29.891 71.307 29.615 71.307z"></path>
                    </svg>
                </a>
                <a href="#">
                    <img width="40" height="40" src="icons/messages.png" class="icon" alt="">
                </a>
                <a href="#">
                    <img width="40" height="40" src="icons/notification.gif" class="icon" alt="">
                </a>
                <a href="#">
                    <img width="40" height="40" src="icons/reel.png" class="icon" alt="">
                </a>
                <a href="#">
                    <img width="40" height="40" src="icons/add.png" class="icon" alt="">
                </a>
                <button class="profile-button">
                    <div class="profile-button__border"></div>
                    <div class="profile-button__picture">
                        <img src="<?php echo $recipientPassport ?>" alt="User Picture" />
                    </div>
                </button>
            </div>
        </nav>
    </header>

    <main class="main-container">
        <section class="content-container">
            <div class="content">
                <div class="stories">
                    <button class="stories__left-button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="#fff" d="M256 504C119 504 8 393 8 256S119 8 256 8s248 111 248 248-111 248-248 248zM142.1 273l135.5 135.5c9.4 9.4 24.6 9.4 33.9 0l17-17c9.4-9.4 9.4-24.6 0-33.9L226.9 256l101.6-101.6c9.4-9.4 9.4-24.6 0-33.9l-17-17c-9.4-9.4-24.6-9.4-33.9 0L142.1 239c-9.4 9.4-9.4 24.6 0 34z">
                            </path>
                        </svg>
                    </button>
                    <div class="stories__content">
                        <button class="story story--has-story">
                            <div class="story__avatar">
                                <div class="story__border">
                                    <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                        <circle r="31" cy="32" cx="32" />
                                        <defs>
                                            <linearGradient y2="0" x2="1" y1="1" x1="0" id="--story-gradient">
                                                <stop offset="0" stop-color="#f09433" />
                                                <stop offset="0.25" stop-color="#e6683c" />
                                                <stop offset="0.5" stop-color="#dc2743" />
                                                <stop offset="0.75" stop-color="#cc2366" />
                                                <stop offset="1" stop-color="#bc1888" />
                                            </linearGradient>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="story__picture">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </div>
                            </div>
                            <span class="story__user">usernick1</span>
                        </button>
                        <button class="story story--has-story">
                            <div class="story__avatar">
                                <div class="story__border">
                                    <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                        <circle r="31" cy="32" cx="32" />
                                    </svg>
                                </div>
                                <div class="story__picture">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </div>
                            </div>
                            <span class="story__user">usernick2</span>
                        </button>
                        <button class="story story--has-story">
                            <div class="story__avatar">
                                <div class="story__border">
                                    <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                        <circle r="31" cy="32" cx="32" />
                                    </svg>
                                </div>
                                <div class="story__picture">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </div>
                            </div>
                            <span class="story__user">usernick3</span>
                        </button>
                        <button class="story">
                            <div class="story__avatar">
                                <div class="story__border">
                                    <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                        <circle r="31" cy="32" cx="32" />
                                    </svg>
                                </div>
                                <div class="story__picture">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </div>
                            </div>
                            <span class="story__user">usernick4</span>
                        </button>
                        <button class="story">
                            <div class="story__avatar">
                                <div class="story__border">
                                    <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                        <circle r="31" cy="32" cx="32" />
                                    </svg>
                                </div>
                                <div class="story__picture">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </div>
                            </div>
                            <span class="story__user">usernick5</span>
                        </button>
                        <button class="story">
                            <div class="story__avatar">
                                <div class="story__border">
                                    <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                        <circle r="31" cy="32" cx="32" />
                                    </svg>
                                </div>
                                <div class="story__picture">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </div>
                            </div>
                            <span class="story__user">usernick6</span>
                        </button>
                        <button class="story">
                            <div class="story__avatar">
                                <div class="story__border">
                                    <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                        <circle r="31" cy="32" cx="32" />
                                    </svg>
                                </div>
                                <div class="story__picture">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </div>
                            </div>
                            <span class="story__user">usernick7</span>
                        </button>
                        <button class="story">
                            <div class="story__avatar">
                                <div class="story__border">
                                    <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                        <circle r="31" cy="32" cx="32" />
                                    </svg>
                                </div>
                                <div class="story__picture">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </div>
                            </div>
                            <span class="story__user">usernick8</span>
                        </button>
                        <button class="story">
                            <div class="story__avatar">
                                <div class="story__border">
                                    <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                        <circle r="31" cy="32" cx="32" />
                                    </svg>
                                </div>
                                <div class="story__picture">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </div>
                            </div>
                            <span class="story__user">usernick9</span>
                        </button>
                        <button class="story">
                            <div class="story__avatar">
                                <div class="story__border">
                                    <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                        <circle r="31" cy="32" cx="32" />
                                    </svg>
                                </div>
                                <div class="story__picture">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </div>
                            </div>
                            <span class="story__user">usernick10</span>
                        </button>
                        <button class="story">
                            <div class="story__avatar">
                                <div class="story__border">
                                    <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                        <circle r="31" cy="32" cx="32" />
                                    </svg>
                                </div>
                                <div class="story__picture">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </div>
                            </div>
                            <span class="story__user">usernick11</span>
                        </button>
                        <button class="story">
                            <div class="story__avatar">
                                <div class="story__border">
                                    <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                        <circle r="31" cy="32" cx="32" />
                                    </svg>
                                </div>
                                <div class="story__picture">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </div>
                            </div>
                            <span class="story__user">usernick12</span>
                        </button>
                        <button class="story">
                            <div class="story__avatar">
                                <div class="story__border">
                                    <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                        <circle r="31" cy="32" cx="32" />
                                    </svg>
                                </div>
                                <div class="story__picture">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </div>
                            </div>
                            <span class="story__user">usernick13</span>
                        </button>
                        <button class="story">
                            <div class="story__avatar">
                                <div class="story__border">
                                    <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                        <circle r="31" cy="32" cx="32" />
                                    </svg>
                                </div>
                                <div class="story__picture">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </div>
                            </div>
                            <span class="story__user">usernick14</span>
                        </button>
                        <button class="story">
                            <div class="story__avatar">
                                <div class="story__border">
                                    <svg width="64" height="64" xmlns="http://www.w3.org/2000/svg">
                                        <circle r="31" cy="32" cx="32" />
                                    </svg>
                                </div>
                                <div class="story__picture">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </div>
                            </div>
                            <span class="story__user">usernick15</span>
                        </button>
                    </div>
                    <button class="stories__right-button">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                            <path fill="#fff" d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm113.9 231L234.4 103.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L285.1 256 183.5 357.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L369.9 273c9.4-9.4 9.4-24.6 0-34z">
                            </path>
                        </svg>
                    </button>
                </div>

                <div class="posts" id="newsFeed">
                    <article class="post">
                        <div class="post__header">
                            <div class="post__profile">
                                <a href="https://github.com/leocosta1" target="_blank" class="post__avatar">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </a>
                                <a href="https://github.com/leocosta1" target="_blank" class="post__user">leocosta1</a>
                            </div>

                            <button class="post__more-options">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="6.5" cy="11.5" r="1.5" fill="var(--text-dark)" />
                                    <circle cx="12" cy="11.5" r="1.5" fill="var(--text-dark)" />
                                    <circle cx="17.5" cy="11.5" r="1.5" fill="var(--text-dark)" />
                                </svg>
                            </button>
                        </div>

                        <div class="post__content">
                            <div class="post__medias">
                                <img class="post__media" src="images/animal.jpg" alt="Post Content" />
                            </div>
                        </div>

                        <div class="post__footer">
                            <div class="post__buttons">
                                <button class="post__button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.4995 21.2609C11.1062 21.2609 10.7307 21.1362 10.4133 20.9001C8.2588 19.3012 3.10938 15.3239 1.81755 12.9143C0.127895 9.76543 1.14258 5.72131 4.07489 3.89968C5.02253 3.31177 6.09533 3 7.18601 3C8.81755 3 10.3508 3.66808 11.4995 4.85726C12.6483 3.66808 14.1815 3 15.8131 3C16.9038 3 17.9766 3.31177 18.9242 3.89968C21.8565 5.72131 22.8712 9.76543 21.186 12.9143C19.8942 15.3239 14.7448 19.3012 12.5902 20.9001C12.2684 21.1362 11.8929 21.2609 11.4995 21.2609ZM7.18601 4.33616C6.34565 4.33616 5.5187 4.57667 4.78562 5.03096C2.43888 6.49183 1.63428 9.74316 2.99763 12.2819C4.19558 14.5177 9.58639 18.6242 11.209 19.8267C11.3789 19.9514 11.6158 19.9514 11.7856 19.8267C13.4082 18.6197 18.799 14.5133 19.997 12.2819C21.3603 9.74316 20.5557 6.48738 18.209 5.03096C17.4804 4.57667 16.6534 4.33616 15.8131 4.33616C14.3425 4.33616 12.9657 5.04878 12.0359 6.28696L11.4995 7.00848L10.9631 6.28696C10.0334 5.04878 8.6611 4.33616 7.18601 4.33616Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.6" />
                                    </svg>
                                </button>
                                <button class="post__button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M21.2959 20.8165L20.2351 16.8602C20.1743 16.6385 20.2047 16.3994 20.309 16.1907C21.2351 14.3342 21.5438 12.117 20.9742 9.80402C20.2003 6.67374 17.757 4.16081 14.6354 3.33042C13.7833 3.10869 12.9442 3 12.1312 3C6.29665 3 1.74035 8.47365 3.31418 14.5647C4.04458 17.3819 7.05314 20.2992 9.88344 20.9861C10.6486 21.173 11.4008 21.26 12.1312 21.26C13.7006 21.26 15.1701 20.8557 16.4614 20.1601C16.6049 20.0818 16.7657 20.0383 16.9222 20.0383C17.0005 20.0383 17.0787 20.047 17.157 20.0688L21.009 21.0991C21.0307 21.1035 21.0525 21.1078 21.0699 21.1078C21.2177 21.1078 21.3351 20.9687 21.2959 20.8165ZM19.0178 17.1863L19.6178 19.4253L17.4831 18.8558C17.3005 18.8079 17.1135 18.7819 16.9222 18.7819C16.557 18.7819 16.1875 18.8775 15.8571 19.0558C14.6963 19.6818 13.4441 19.9992 12.1312 19.9992C11.4834 19.9992 10.8269 19.9166 10.1791 19.7601C7.78354 19.1775 5.14453 16.6037 4.53586 14.2473C3.90111 11.7865 4.40109 9.26057 5.90536 7.31719C7.40964 5.3738 9.6791 4.26081 12.1312 4.26081C12.8529 4.26081 13.5876 4.35646 14.3137 4.5521C16.9961 5.26511 19.0786 7.39544 19.7525 10.1084C20.2264 12.0213 20.0308 13.9299 19.183 15.6298C18.9395 16.1168 18.8787 16.6689 19.0178 17.1863Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.7" />
                                    </svg>
                                </button>
                                <button class="post__button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.8555 3.44542C22.6978 3.16703 22.3962 3 22.0714 3L2.91369 3.01392C2.52859 3.01392 2.19453 3.25055 2.05997 3.60781C1.96254 3.86764 1.98574 4.14603 2.11565 4.37338C2.16669 4.45689 2.23165 4.53577 2.31052 4.60537L9.69243 10.9712L11.4927 20.5338C11.5623 20.9096 11.8499 21.188 12.2304 21.2483C12.6062 21.3086 12.9774 21.1323 13.1723 20.8029L22.8509 4.35018C23.0179 4.06715 23.0179 3.72381 22.8555 3.44542ZM4.21748 4.39194H19.8164L10.4255 9.75089L4.21748 4.39194ZM12.6248 18.9841L11.1122 10.948L20.5171 5.58436L12.6248 18.9841Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.3" />
                                    </svg>
                                </button>

                                <div class="post__indicators"></div>

                                <button class="post__button post__button--align-right">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.875 2H4.125C3.50625 2 3 2.44939 3 3.00481V22.4648C3 23.0202 3.36563 23.1616 3.82125 22.7728L11.5444 16.1986C11.7244 16.0471 12.0225 16.0471 12.2025 16.1936L20.1731 22.7879C20.6287 23.1666 21 23.0202 21 22.4648V3.00481C21 2.44939 20.4994 2 19.875 2ZM19.3125 20.0209L13.3444 15.0827C12.9281 14.7394 12.405 14.5677 11.8763 14.5677C11.3363 14.5677 10.8019 14.7444 10.3856 15.0979L4.6875 19.9502V3.51479H19.3125V20.0209Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.7" />
                                    </svg>
                                </button>
                            </div>

                            <div class="post__infos">
                                <div class="post__likes">
                                    <a href="#" class="post__likes-avatar">
                                        <img src="assets/default-user.png" alt="User Picture" />
                                    </a>

                                    <span>Liked by
                                        <a class="post__name--underline" href="#">user123</a> and
                                        <a href="#">73 others</a></span>
                                </div>

                                <div class="post__description">
                                    <span>
                                        <a class="post__name--underline" href="https://github.com/leocosta1" target="_blank">leocosta1</a>
                                        Responsive clone of Instagram UI. Made with ❤ for study
                                        purposes.
                                    </span>
                                </div>

                                <span class="post__date-time">30 minutes ago</span>
                            </div>
                        </div>
                    </article>
                    <article class="post">
                        <div class="post__header">
                            <div class="post__profile">
                                <a href="#" class="post__avatar">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </a>
                                <a href="#" class="post__user">usernick1</a>
                            </div>

                            <button class="post__more-options">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="6.5" cy="11.5" r="1.5" fill="var(--text-dark)" />
                                    <circle cx="12" cy="11.5" r="1.5" fill="var(--text-dark)" />
                                    <circle cx="17.5" cy="11.5" r="1.5" fill="var(--text-dark)" />
                                </svg>
                            </button>
                        </div>

                        <div class="post__content">
                            <div class="post__medias">
                                <img class="post__media" src="assets/insta-clone.png" alt="Post Content" />
                                <img class="post__media" src="assets/insta-clone.png" alt="Post Content" />
                                <img class="post__media" src="assets/insta-clone.png" alt="Post Content" />
                            </div>
                        </div>

                        <div class="post__footer">
                            <div class="post__buttons">
                                <button class="post__button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.4995 21.2609C11.1062 21.2609 10.7307 21.1362 10.4133 20.9001C8.2588 19.3012 3.10938 15.3239 1.81755 12.9143C0.127895 9.76543 1.14258 5.72131 4.07489 3.89968C5.02253 3.31177 6.09533 3 7.18601 3C8.81755 3 10.3508 3.66808 11.4995 4.85726C12.6483 3.66808 14.1815 3 15.8131 3C16.9038 3 17.9766 3.31177 18.9242 3.89968C21.8565 5.72131 22.8712 9.76543 21.186 12.9143C19.8942 15.3239 14.7448 19.3012 12.5902 20.9001C12.2684 21.1362 11.8929 21.2609 11.4995 21.2609ZM7.18601 4.33616C6.34565 4.33616 5.5187 4.57667 4.78562 5.03096C2.43888 6.49183 1.63428 9.74316 2.99763 12.2819C4.19558 14.5177 9.58639 18.6242 11.209 19.8267C11.3789 19.9514 11.6158 19.9514 11.7856 19.8267C13.4082 18.6197 18.799 14.5133 19.997 12.2819C21.3603 9.74316 20.5557 6.48738 18.209 5.03096C17.4804 4.57667 16.6534 4.33616 15.8131 4.33616C14.3425 4.33616 12.9657 5.04878 12.0359 6.28696L11.4995 7.00848L10.9631 6.28696C10.0334 5.04878 8.6611 4.33616 7.18601 4.33616Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.6" />
                                    </svg>
                                </button>
                                <button class="post__button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M21.2959 20.8165L20.2351 16.8602C20.1743 16.6385 20.2047 16.3994 20.309 16.1907C21.2351 14.3342 21.5438 12.117 20.9742 9.80402C20.2003 6.67374 17.757 4.16081 14.6354 3.33042C13.7833 3.10869 12.9442 3 12.1312 3C6.29665 3 1.74035 8.47365 3.31418 14.5647C4.04458 17.3819 7.05314 20.2992 9.88344 20.9861C10.6486 21.173 11.4008 21.26 12.1312 21.26C13.7006 21.26 15.1701 20.8557 16.4614 20.1601C16.6049 20.0818 16.7657 20.0383 16.9222 20.0383C17.0005 20.0383 17.0787 20.047 17.157 20.0688L21.009 21.0991C21.0307 21.1035 21.0525 21.1078 21.0699 21.1078C21.2177 21.1078 21.3351 20.9687 21.2959 20.8165ZM19.0178 17.1863L19.6178 19.4253L17.4831 18.8558C17.3005 18.8079 17.1135 18.7819 16.9222 18.7819C16.557 18.7819 16.1875 18.8775 15.8571 19.0558C14.6963 19.6818 13.4441 19.9992 12.1312 19.9992C11.4834 19.9992 10.8269 19.9166 10.1791 19.7601C7.78354 19.1775 5.14453 16.6037 4.53586 14.2473C3.90111 11.7865 4.40109 9.26057 5.90536 7.31719C7.40964 5.3738 9.6791 4.26081 12.1312 4.26081C12.8529 4.26081 13.5876 4.35646 14.3137 4.5521C16.9961 5.26511 19.0786 7.39544 19.7525 10.1084C20.2264 12.0213 20.0308 13.9299 19.183 15.6298C18.9395 16.1168 18.8787 16.6689 19.0178 17.1863Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.7" />
                                    </svg>
                                </button>
                                <button class="post__button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.8555 3.44542C22.6978 3.16703 22.3962 3 22.0714 3L2.91369 3.01392C2.52859 3.01392 2.19453 3.25055 2.05997 3.60781C1.96254 3.86764 1.98574 4.14603 2.11565 4.37338C2.16669 4.45689 2.23165 4.53577 2.31052 4.60537L9.69243 10.9712L11.4927 20.5338C11.5623 20.9096 11.8499 21.188 12.2304 21.2483C12.6062 21.3086 12.9774 21.1323 13.1723 20.8029L22.8509 4.35018C23.0179 4.06715 23.0179 3.72381 22.8555 3.44542ZM4.21748 4.39194H19.8164L10.4255 9.75089L4.21748 4.39194ZM12.6248 18.9841L11.1122 10.948L20.5171 5.58436L12.6248 18.9841Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.3" />
                                    </svg>
                                </button>

                                <div class="post__indicators"></div>

                                <button class="post__button post__button--align-right">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.875 2H4.125C3.50625 2 3 2.44939 3 3.00481V22.4648C3 23.0202 3.36563 23.1616 3.82125 22.7728L11.5444 16.1986C11.7244 16.0471 12.0225 16.0471 12.2025 16.1936L20.1731 22.7879C20.6287 23.1666 21 23.0202 21 22.4648V3.00481C21 2.44939 20.4994 2 19.875 2ZM19.3125 20.0209L13.3444 15.0827C12.9281 14.7394 12.405 14.5677 11.8763 14.5677C11.3363 14.5677 10.8019 14.7444 10.3856 15.0979L4.6875 19.9502V3.51479H19.3125V20.0209Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.7" />
                                    </svg>
                                </button>
                            </div>

                            <div class="post__infos">
                                <div class="post__likes">
                                    <a href="#" class="post__likes-avatar">
                                        <img src="assets/default-user.png" alt="User Picture" />
                                    </a>

                                    <span>Liked by
                                        <a class="post__name--underline" href="#">user123</a> and
                                        <a href="#">73 others</a></span>
                                </div>

                                <div class="post__description">
                                    <span>
                                        <a class="post__name--underline" href="#">usernick1</a>
                                        Multiple media post example. This post has three images!
                                    </span>
                                </div>

                                <span class="post__date-time">1 hour ago</span>
                            </div>
                        </div>
                    </article>
                    <article class="post">
                        <div class="post__header">
                            <div class="post__profile">
                                <a href="#" class="post__avatar">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </a>
                                <a href="#" class="post__user">usernick2</a>
                            </div>

                            <button class="post__more-options">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="6.5" cy="11.5" r="1.5" fill="var(--text-dark)" />
                                    <circle cx="12" cy="11.5" r="1.5" fill="var(--text-dark)" />
                                    <circle cx="17.5" cy="11.5" r="1.5" fill="var(--text-dark)" />
                                </svg>
                            </button>
                        </div>

                        <div class="post__content">
                            <div class="post__medias">
                                <img class="post__media" src="assets/insta-clone.png" alt="Post Content" />
                            </div>
                        </div>

                        <div class="post__footer">
                            <div class="post__buttons">
                                <button class="post__button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.4995 21.2609C11.1062 21.2609 10.7307 21.1362 10.4133 20.9001C8.2588 19.3012 3.10938 15.3239 1.81755 12.9143C0.127895 9.76543 1.14258 5.72131 4.07489 3.89968C5.02253 3.31177 6.09533 3 7.18601 3C8.81755 3 10.3508 3.66808 11.4995 4.85726C12.6483 3.66808 14.1815 3 15.8131 3C16.9038 3 17.9766 3.31177 18.9242 3.89968C21.8565 5.72131 22.8712 9.76543 21.186 12.9143C19.8942 15.3239 14.7448 19.3012 12.5902 20.9001C12.2684 21.1362 11.8929 21.2609 11.4995 21.2609ZM7.18601 4.33616C6.34565 4.33616 5.5187 4.57667 4.78562 5.03096C2.43888 6.49183 1.63428 9.74316 2.99763 12.2819C4.19558 14.5177 9.58639 18.6242 11.209 19.8267C11.3789 19.9514 11.6158 19.9514 11.7856 19.8267C13.4082 18.6197 18.799 14.5133 19.997 12.2819C21.3603 9.74316 20.5557 6.48738 18.209 5.03096C17.4804 4.57667 16.6534 4.33616 15.8131 4.33616C14.3425 4.33616 12.9657 5.04878 12.0359 6.28696L11.4995 7.00848L10.9631 6.28696C10.0334 5.04878 8.6611 4.33616 7.18601 4.33616Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.6" />
                                    </svg>
                                </button>
                                <button class="post__button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M21.2959 20.8165L20.2351 16.8602C20.1743 16.6385 20.2047 16.3994 20.309 16.1907C21.2351 14.3342 21.5438 12.117 20.9742 9.80402C20.2003 6.67374 17.757 4.16081 14.6354 3.33042C13.7833 3.10869 12.9442 3 12.1312 3C6.29665 3 1.74035 8.47365 3.31418 14.5647C4.04458 17.3819 7.05314 20.2992 9.88344 20.9861C10.6486 21.173 11.4008 21.26 12.1312 21.26C13.7006 21.26 15.1701 20.8557 16.4614 20.1601C16.6049 20.0818 16.7657 20.0383 16.9222 20.0383C17.0005 20.0383 17.0787 20.047 17.157 20.0688L21.009 21.0991C21.0307 21.1035 21.0525 21.1078 21.0699 21.1078C21.2177 21.1078 21.3351 20.9687 21.2959 20.8165ZM19.0178 17.1863L19.6178 19.4253L17.4831 18.8558C17.3005 18.8079 17.1135 18.7819 16.9222 18.7819C16.557 18.7819 16.1875 18.8775 15.8571 19.0558C14.6963 19.6818 13.4441 19.9992 12.1312 19.9992C11.4834 19.9992 10.8269 19.9166 10.1791 19.7601C7.78354 19.1775 5.14453 16.6037 4.53586 14.2473C3.90111 11.7865 4.40109 9.26057 5.90536 7.31719C7.40964 5.3738 9.6791 4.26081 12.1312 4.26081C12.8529 4.26081 13.5876 4.35646 14.3137 4.5521C16.9961 5.26511 19.0786 7.39544 19.7525 10.1084C20.2264 12.0213 20.0308 13.9299 19.183 15.6298C18.9395 16.1168 18.8787 16.6689 19.0178 17.1863Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.7" />
                                    </svg>
                                </button>
                                <button class="post__button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.8555 3.44542C22.6978 3.16703 22.3962 3 22.0714 3L2.91369 3.01392C2.52859 3.01392 2.19453 3.25055 2.05997 3.60781C1.96254 3.86764 1.98574 4.14603 2.11565 4.37338C2.16669 4.45689 2.23165 4.53577 2.31052 4.60537L9.69243 10.9712L11.4927 20.5338C11.5623 20.9096 11.8499 21.188 12.2304 21.2483C12.6062 21.3086 12.9774 21.1323 13.1723 20.8029L22.8509 4.35018C23.0179 4.06715 23.0179 3.72381 22.8555 3.44542ZM4.21748 4.39194H19.8164L10.4255 9.75089L4.21748 4.39194ZM12.6248 18.9841L11.1122 10.948L20.5171 5.58436L12.6248 18.9841Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.3" />
                                    </svg>
                                </button>

                                <div class="post__indicators"></div>

                                <button class="post__button post__button--align-right">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.875 2H4.125C3.50625 2 3 2.44939 3 3.00481V22.4648C3 23.0202 3.36563 23.1616 3.82125 22.7728L11.5444 16.1986C11.7244 16.0471 12.0225 16.0471 12.2025 16.1936L20.1731 22.7879C20.6287 23.1666 21 23.0202 21 22.4648V3.00481C21 2.44939 20.4994 2 19.875 2ZM19.3125 20.0209L13.3444 15.0827C12.9281 14.7394 12.405 14.5677 11.8763 14.5677C11.3363 14.5677 10.8019 14.7444 10.3856 15.0979L4.6875 19.9502V3.51479H19.3125V20.0209Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.7" />
                                    </svg>
                                </button>
                            </div>

                            <div class="post__infos">
                                <div class="post__likes">
                                    <a href="#" class="post__likes-avatar">
                                        <img src="assets/default-user.png" alt="User Picture" />
                                    </a>

                                    <span>Liked by
                                        <a class="post__name--underline" href="#">user123</a> and
                                        <a href="#">73 others</a></span>
                                </div>

                                <div class="post__description">
                                    <span>
                                        <a class="post__name--underline" href="#">usernick2</a>
                                        Single media post example.
                                    </span>
                                </div>

                                <span class="post__date-time">3 hours ago</span>
                            </div>
                        </div>
                    </article>
                    <article class="post">
                        <div class="post__header">
                            <div class="post__profile">
                                <a href="#" class="post__avatar">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </a>
                                <a href="#" class="post__user">usernick3</a>
                            </div>

                            <button class="post__more-options">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="6.5" cy="11.5" r="1.5" fill="var(--text-dark)" />
                                    <circle cx="12" cy="11.5" r="1.5" fill="var(--text-dark)" />
                                    <circle cx="17.5" cy="11.5" r="1.5" fill="var(--text-dark)" />
                                </svg>
                            </button>
                        </div>

                        <div class="post__content">
                            <div class="post__medias">
                                <img class="post__media" src="assets/insta-clone.png" alt="Post Content" />
                                <img class="post__media" src="assets/insta-clone.png" alt="Post Content" />
                                <img class="post__media" src="assets/insta-clone.png" alt="Post Content" />
                                <img class="post__media" src="assets/insta-clone.png" alt="Post Content" />
                            </div>
                        </div>

                        <div class="post__footer">
                            <div class="post__buttons">
                                <button class="post__button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.4995 21.2609C11.1062 21.2609 10.7307 21.1362 10.4133 20.9001C8.2588 19.3012 3.10938 15.3239 1.81755 12.9143C0.127895 9.76543 1.14258 5.72131 4.07489 3.89968C5.02253 3.31177 6.09533 3 7.18601 3C8.81755 3 10.3508 3.66808 11.4995 4.85726C12.6483 3.66808 14.1815 3 15.8131 3C16.9038 3 17.9766 3.31177 18.9242 3.89968C21.8565 5.72131 22.8712 9.76543 21.186 12.9143C19.8942 15.3239 14.7448 19.3012 12.5902 20.9001C12.2684 21.1362 11.8929 21.2609 11.4995 21.2609ZM7.18601 4.33616C6.34565 4.33616 5.5187 4.57667 4.78562 5.03096C2.43888 6.49183 1.63428 9.74316 2.99763 12.2819C4.19558 14.5177 9.58639 18.6242 11.209 19.8267C11.3789 19.9514 11.6158 19.9514 11.7856 19.8267C13.4082 18.6197 18.799 14.5133 19.997 12.2819C21.3603 9.74316 20.5557 6.48738 18.209 5.03096C17.4804 4.57667 16.6534 4.33616 15.8131 4.33616C14.3425 4.33616 12.9657 5.04878 12.0359 6.28696L11.4995 7.00848L10.9631 6.28696C10.0334 5.04878 8.6611 4.33616 7.18601 4.33616Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.6" />
                                    </svg>
                                </button>
                                <button class="post__button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M21.2959 20.8165L20.2351 16.8602C20.1743 16.6385 20.2047 16.3994 20.309 16.1907C21.2351 14.3342 21.5438 12.117 20.9742 9.80402C20.2003 6.67374 17.757 4.16081 14.6354 3.33042C13.7833 3.10869 12.9442 3 12.1312 3C6.29665 3 1.74035 8.47365 3.31418 14.5647C4.04458 17.3819 7.05314 20.2992 9.88344 20.9861C10.6486 21.173 11.4008 21.26 12.1312 21.26C13.7006 21.26 15.1701 20.8557 16.4614 20.1601C16.6049 20.0818 16.7657 20.0383 16.9222 20.0383C17.0005 20.0383 17.0787 20.047 17.157 20.0688L21.009 21.0991C21.0307 21.1035 21.0525 21.1078 21.0699 21.1078C21.2177 21.1078 21.3351 20.9687 21.2959 20.8165ZM19.0178 17.1863L19.6178 19.4253L17.4831 18.8558C17.3005 18.8079 17.1135 18.7819 16.9222 18.7819C16.557 18.7819 16.1875 18.8775 15.8571 19.0558C14.6963 19.6818 13.4441 19.9992 12.1312 19.9992C11.4834 19.9992 10.8269 19.9166 10.1791 19.7601C7.78354 19.1775 5.14453 16.6037 4.53586 14.2473C3.90111 11.7865 4.40109 9.26057 5.90536 7.31719C7.40964 5.3738 9.6791 4.26081 12.1312 4.26081C12.8529 4.26081 13.5876 4.35646 14.3137 4.5521C16.9961 5.26511 19.0786 7.39544 19.7525 10.1084C20.2264 12.0213 20.0308 13.9299 19.183 15.6298C18.9395 16.1168 18.8787 16.6689 19.0178 17.1863Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.7" />
                                    </svg>
                                </button>
                                <button class="post__button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.8555 3.44542C22.6978 3.16703 22.3962 3 22.0714 3L2.91369 3.01392C2.52859 3.01392 2.19453 3.25055 2.05997 3.60781C1.96254 3.86764 1.98574 4.14603 2.11565 4.37338C2.16669 4.45689 2.23165 4.53577 2.31052 4.60537L9.69243 10.9712L11.4927 20.5338C11.5623 20.9096 11.8499 21.188 12.2304 21.2483C12.6062 21.3086 12.9774 21.1323 13.1723 20.8029L22.8509 4.35018C23.0179 4.06715 23.0179 3.72381 22.8555 3.44542ZM4.21748 4.39194H19.8164L10.4255 9.75089L4.21748 4.39194ZM12.6248 18.9841L11.1122 10.948L20.5171 5.58436L12.6248 18.9841Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.3" />
                                    </svg>
                                </button>

                                <div class="post__indicators"></div>

                                <button class="post__button post__button--align-right">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.875 2H4.125C3.50625 2 3 2.44939 3 3.00481V22.4648C3 23.0202 3.36563 23.1616 3.82125 22.7728L11.5444 16.1986C11.7244 16.0471 12.0225 16.0471 12.2025 16.1936L20.1731 22.7879C20.6287 23.1666 21 23.0202 21 22.4648V3.00481C21 2.44939 20.4994 2 19.875 2ZM19.3125 20.0209L13.3444 15.0827C12.9281 14.7394 12.405 14.5677 11.8763 14.5677C11.3363 14.5677 10.8019 14.7444 10.3856 15.0979L4.6875 19.9502V3.51479H19.3125V20.0209Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.7" />
                                    </svg>
                                </button>
                            </div>

                            <div class="post__infos">
                                <div class="post__likes">
                                    <a href="#" class="post__likes-avatar">
                                        <img src="assets/default-user.png" alt="User Picture" />
                                    </a>

                                    <span>Liked by
                                        <a class="post__name--underline" href="#">user123</a> and
                                        <a href="#">73 others</a></span>
                                </div>

                                <div class="post__description">
                                    <span>
                                        <a class="post__name--underline" href="#">usernick3</a>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                        Similique laudantium consequuntur vitae impedit eaque?
                                        Accusantium rerum vel ducimus perspiciatis nesciunt a
                                        minus minima earum delectus. Doloremque consequuntur
                                        ducimus illum placeat!
                                    </span>
                                </div>

                                <span class="post__date-time">1 day ago</span>
                            </div>
                        </div>
                    </article>
                    <article class="post">
                        <div class="post__header">
                            <div class="post__profile">
                                <a href="#" class="post__avatar">
                                    <img src="assets/default-user.png" alt="User Picture" />
                                </a>
                                <a href="#" class="post__user">usernick4</a>
                            </div>

                            <button class="post__more-options">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="6.5" cy="11.5" r="1.5" fill="var(--text-dark)" />
                                    <circle cx="12" cy="11.5" r="1.5" fill="var(--text-dark)" />
                                    <circle cx="17.5" cy="11.5" r="1.5" fill="var(--text-dark)" />
                                </svg>
                            </button>
                        </div>

                        <div class="post__content">
                            <div class="post__medias">
                                <img class="post__media" src="assets/insta-clone.png" alt="Post Content" />
                                <img class="post__media" src="assets/insta-clone.png" alt="Post Content" />
                            </div>
                        </div>

                        <div class="post__footer">
                            <div class="post__buttons">
                                <button class="post__button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.4995 21.2609C11.1062 21.2609 10.7307 21.1362 10.4133 20.9001C8.2588 19.3012 3.10938 15.3239 1.81755 12.9143C0.127895 9.76543 1.14258 5.72131 4.07489 3.89968C5.02253 3.31177 6.09533 3 7.18601 3C8.81755 3 10.3508 3.66808 11.4995 4.85726C12.6483 3.66808 14.1815 3 15.8131 3C16.9038 3 17.9766 3.31177 18.9242 3.89968C21.8565 5.72131 22.8712 9.76543 21.186 12.9143C19.8942 15.3239 14.7448 19.3012 12.5902 20.9001C12.2684 21.1362 11.8929 21.2609 11.4995 21.2609ZM7.18601 4.33616C6.34565 4.33616 5.5187 4.57667 4.78562 5.03096C2.43888 6.49183 1.63428 9.74316 2.99763 12.2819C4.19558 14.5177 9.58639 18.6242 11.209 19.8267C11.3789 19.9514 11.6158 19.9514 11.7856 19.8267C13.4082 18.6197 18.799 14.5133 19.997 12.2819C21.3603 9.74316 20.5557 6.48738 18.209 5.03096C17.4804 4.57667 16.6534 4.33616 15.8131 4.33616C14.3425 4.33616 12.9657 5.04878 12.0359 6.28696L11.4995 7.00848L10.9631 6.28696C10.0334 5.04878 8.6611 4.33616 7.18601 4.33616Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.6" />
                                    </svg>
                                </button>
                                <button class="post__button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M21.2959 20.8165L20.2351 16.8602C20.1743 16.6385 20.2047 16.3994 20.309 16.1907C21.2351 14.3342 21.5438 12.117 20.9742 9.80402C20.2003 6.67374 17.757 4.16081 14.6354 3.33042C13.7833 3.10869 12.9442 3 12.1312 3C6.29665 3 1.74035 8.47365 3.31418 14.5647C4.04458 17.3819 7.05314 20.2992 9.88344 20.9861C10.6486 21.173 11.4008 21.26 12.1312 21.26C13.7006 21.26 15.1701 20.8557 16.4614 20.1601C16.6049 20.0818 16.7657 20.0383 16.9222 20.0383C17.0005 20.0383 17.0787 20.047 17.157 20.0688L21.009 21.0991C21.0307 21.1035 21.0525 21.1078 21.0699 21.1078C21.2177 21.1078 21.3351 20.9687 21.2959 20.8165ZM19.0178 17.1863L19.6178 19.4253L17.4831 18.8558C17.3005 18.8079 17.1135 18.7819 16.9222 18.7819C16.557 18.7819 16.1875 18.8775 15.8571 19.0558C14.6963 19.6818 13.4441 19.9992 12.1312 19.9992C11.4834 19.9992 10.8269 19.9166 10.1791 19.7601C7.78354 19.1775 5.14453 16.6037 4.53586 14.2473C3.90111 11.7865 4.40109 9.26057 5.90536 7.31719C7.40964 5.3738 9.6791 4.26081 12.1312 4.26081C12.8529 4.26081 13.5876 4.35646 14.3137 4.5521C16.9961 5.26511 19.0786 7.39544 19.7525 10.1084C20.2264 12.0213 20.0308 13.9299 19.183 15.6298C18.9395 16.1168 18.8787 16.6689 19.0178 17.1863Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.7" />
                                    </svg>
                                </button>
                                <button class="post__button">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.8555 3.44542C22.6978 3.16703 22.3962 3 22.0714 3L2.91369 3.01392C2.52859 3.01392 2.19453 3.25055 2.05997 3.60781C1.96254 3.86764 1.98574 4.14603 2.11565 4.37338C2.16669 4.45689 2.23165 4.53577 2.31052 4.60537L9.69243 10.9712L11.4927 20.5338C11.5623 20.9096 11.8499 21.188 12.2304 21.2483C12.6062 21.3086 12.9774 21.1323 13.1723 20.8029L22.8509 4.35018C23.0179 4.06715 23.0179 3.72381 22.8555 3.44542ZM4.21748 4.39194H19.8164L10.4255 9.75089L4.21748 4.39194ZM12.6248 18.9841L11.1122 10.948L20.5171 5.58436L12.6248 18.9841Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.3" />
                                    </svg>
                                </button>

                                <div class="post__indicators"></div>

                                <button class="post__button post__button--align-right">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.875 2H4.125C3.50625 2 3 2.44939 3 3.00481V22.4648C3 23.0202 3.36563 23.1616 3.82125 22.7728L11.5444 16.1986C11.7244 16.0471 12.0225 16.0471 12.2025 16.1936L20.1731 22.7879C20.6287 23.1666 21 23.0202 21 22.4648V3.00481C21 2.44939 20.4994 2 19.875 2ZM19.3125 20.0209L13.3444 15.0827C12.9281 14.7394 12.405 14.5677 11.8763 14.5677C11.3363 14.5677 10.8019 14.7444 10.3856 15.0979L4.6875 19.9502V3.51479H19.3125V20.0209Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-width="0.7" />
                                    </svg>
                                </button>
                            </div>

                            <div class="post__infos">
                                <div class="post__likes">
                                    <a href="#" class="post__likes-avatar">
                                        <img src="assets/default-user.png" alt="User Picture" />
                                    </a>

                                    <span>Liked by
                                        <a class="post__name--underline" href="#">user123</a> and
                                        <a href="#">73 others</a></span>
                                </div>

                                <div class="post__description">
                                    <span>
                                        <a class="post__name--underline" href="#">usernick4</a>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                        Ducimus voluptates expedita ab vel dolore voluptatem rerum
                                        repudiandae unde temporibus sed quos quis illo, dolores
                                        facere officiis autem. Error, non quidem.
                                    </span>
                                </div>

                                <span class="post__date-time">3 days ago</span>
                            </div>
                        </div>
                    </article>
                </div>
            </div>

            <section class="side-menu">
                <div class="side-menu__user-profile">
                    <a href="user_profile.php" target="_blank" class="side-menu__user-avatar">
                        <img src="<?php echo $recipientPassport ?>" alt="User Picture" />
                    </a>
                    <div class="side-menu__user-info">
                        <a href="user_profile.php" target="_blank"></a>
                        <span><?php echo $recipientSurname . ' ' . $recipientFirstName; ?></span>
                    </div>
                    <button class="side-menu__user-button">Switch</button>
                </div>

                <div class="side-menu__suggestions-section">
                    <div class="side-menu__suggestions-header">
                        <h2>Suggestions for You</h2>
                        <button>See All</button>
                    </div>
                    <div class="side-menu__suggestions-content">
                        <div class="side-menu__suggestion">
                            <a href="#" class="side-menu__suggestion-avatar">
                                <img src="assets/default-user.png" alt="User Picture" />
                            </a>
                            <div class="side-menu__suggestion-info">
                                <a href="#">usernick16</a>
                                <span>Followed by user1, user2 and 9 others</span>
                            </div>
                            <button class="side-menu__suggestion-button">Follow</button>
                        </div>
                        <div class="side-menu__suggestion">
                            <a href="#" class="side-menu__suggestion-avatar">
                                <img src="assets/default-user.png" alt="User Picture" />
                            </a>
                            <div class="side-menu__suggestion-info">
                                <a href="#">usernick17</a>
                                <span>Followed by user1, user2 and 3 others</span>
                            </div>
                            <button class="side-menu__suggestion-button">Follow</button>
                        </div>
                        <div class="side-menu__suggestion">
                            <a href="#" class="side-menu__suggestion-avatar">
                                <img src="assets/default-user.png" alt="User Picture" />
                            </a>
                            <div class="side-menu__suggestion-info">
                                <a href="#">usernick18</a>
                                <span>Followed by user1 and 9 others</span>
                            </div>
                            <button class="side-menu__suggestion-button">Follow</button>
                        </div>
                        <div class="side-menu__suggestion">
                            <a href="#" class="side-menu__suggestion-avatar">
                                <img src="assets/default-user.png" alt="User Picture" />
                            </a>
                            <div class="side-menu__suggestion-info">
                                <a href="#">usernick19</a>
                                <span>Followed by user1 and 3 others</span>
                            </div>
                            <button class="side-menu__suggestion-button">Follow</button>
                        </div>
                        <div class="side-menu__suggestion">
                            <a href="#" class="side-menu__suggestion-avatar">
                                <img src="assets/default-user.png" alt="User Picture" />
                            </a>
                            <div class="side-menu__suggestion-info">
                                <a href="#">usernick20</a>
                                <span>Followed by user1 and 6 others</span>
                            </div>
                            <button class="side-menu__suggestion-button">Follow</button>
                        </div>
                    </div>
                </div>

                <div class="side-menu__footer">
                    <div class="side-menu__footer-links">
                        <ul class="side-menu__footer-list">
                            <li class="side-menu__footer-item">
                                <a class="side-menu__footer-link" href="#">About</a>
                            </li>
                            <li class="side-menu__footer-item">
                                <a class="side-menu__footer-link" href="#">Help</a>
                            </li>
                            <li class="side-menu__footer-item">
                                <a class="side-menu__footer-link" href="#">Press</a>
                            </li>
                            <li class="side-menu__footer-item">
                                <a class="side-menu__footer-link" href="#">API</a>
                            </li>
                            <li class="side-menu__footer-item">
                                <a class="side-menu__footer-link" href="#">Jobs</a>
                            </li>
                            <li class="side-menu__footer-item">
                                <a class="side-menu__footer-link" href="#">Privacy</a>
                            </li>
                            <li class="side-menu__footer-item">
                                <a class="side-menu__footer-link" href="#">Terms</a>
                            </li>
                            <li class="side-menu__footer-item">
                                <a class="side-menu__footer-link" href="#">Locations</a>
                            </li>
                            <li class="side-menu__footer-item">
                                <a class="side-menu__footer-link" href="#">Top Accounts</a>
                            </li>
                            <li class="side-menu__footer-item">
                                <a class="side-menu__footer-link" href="#">Hashtag</a>
                            </li>
                            <li class="side-menu__footer-item">
                                <a class="side-menu__footer-link" href="#">Language</a>
                            </li>
                        </ul>
                    </div>

                    <span class="side-menu__footer-copyright">&copy; Offeyicial by Offeyicial</span>
                </div>
            </section>
        </section>
    </main>

    <nav class="navbar">
        <a href="#" class="navbar__button">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="40" viewBox="0 0 100 100">
                <path fill="#c8ede6" d="M86.876,56.546c0.3-0.616,0.566-1.264,0.796-1.943c2.633-7.77-1.349-17.078-9.733-19.325c-0.906-11.384-8.906-19.193-17.941-20.526c-10.341-1.525-19.814,5.044-22.966,15.485c-3.799-1.346-7.501-1.182-10.99,0.857c-1.583,0.732-3.031,1.812-4.33,3.233c-1.907,2.086-3.147,4.719-3.652,7.495c-0.748,0.118-1.483,0.236-2.176,0.484c-4.04,1.449-6.589,4.431-7.288,8.923c-0.435,2.797,0.443,5.587,0.933,6.714c1.935,4.455,6.422,6.98,10.981,6.312c0.227-0.033,0.557,0.069,0.752,0.233c0.241,7.12,3.698,13.417,8.884,17.014c8.321,5.772,19.027,3.994,25.781-3.921c2.894,2.96,6.338,4.398,10.384,3.876c4.023-0.519,7.147-2.739,9.426-6.349c1.053,0.283,2.051,0.691,3.083,0.804c4.042,0.442,7.118-1.311,9.732-4.8c1.488-1.986,1.779-5.145,1.793-6.354C90.384,61.503,89.053,58.536,86.876,56.546z"></path>
                <path fill="#fdfcef" d="M72.986,65.336c0,0,11.691,0,11.762,0c2.7,0,4.888-2.189,4.888-4.889c0-2.355-1.666-4.321-3.884-4.784c0.026-0.206,0.043-0.415,0.043-0.628c0-2.796-2.267-5.063-5.063-5.063c-1.651,0-3.113,0.794-4.037,2.017c-0.236-3.113-3.017-5.514-6.27-5.116c-2.379,0.291-4.346,2.13-4.784,4.486c-0.14,0.756-0.126,1.489,0.014,2.177c-0.638-0.687-1.546-1.119-2.557-1.119c-1.85,0-3.361,1.441-3.48,3.261c-0.84-0.186-1.754-0.174-2.717,0.188c-1.84,0.691-3.15,2.423-3.227,4.387c-0.109,2.789,2.12,5.085,4.885,5.085c0.21,0,0.948,0,1.118,0H69.83"></path>
                <path fill="#472b29" d="M84.748,65.836H72.986c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h11.762c2.419,0,4.388-1.969,4.388-4.389c0-2.066-1.466-3.873-3.486-4.296c-0.254-0.053-0.425-0.292-0.394-0.551c0.023-0.186,0.039-0.373,0.039-0.566c0-2.516-2.047-4.562-4.563-4.562c-1.438,0-2.765,0.663-3.638,1.818c-0.125,0.166-0.338,0.237-0.54,0.178c-0.199-0.059-0.342-0.234-0.357-0.441c-0.104-1.378-0.779-2.672-1.851-3.55c-1.083-0.888-2.453-1.281-3.859-1.108c-2.167,0.266-3.956,1.943-4.353,4.08c-0.124,0.669-0.12,1.338,0.012,1.987c0.045,0.22-0.062,0.442-0.261,0.544c-0.2,0.105-0.443,0.06-0.595-0.104c-0.574-0.618-1.352-0.959-2.19-0.959c-1.569,0-2.878,1.227-2.981,2.793c-0.01,0.146-0.082,0.28-0.199,0.367c-0.117,0.088-0.268,0.119-0.408,0.089c-0.84-0.185-1.637-0.132-2.433,0.167c-1.669,0.627-2.836,2.209-2.903,3.938c-0.047,1.207,0.387,2.351,1.222,3.219c0.835,0.868,1.959,1.347,3.164,1.347H69.83c0.276,0,0.5,0.224,0.5,0.5s-0.224,0.5-0.5,0.5H58.561c-1.479,0-2.858-0.587-3.884-1.653c-1.025-1.066-1.558-2.47-1.5-3.951c0.083-2.126,1.51-4.069,3.551-4.835c0.8-0.3,1.628-0.399,2.468-0.299c0.376-1.822,1.997-3.182,3.905-3.182c0.685,0,1.354,0.18,1.944,0.51c0-0.386,0.035-0.772,0.107-1.159c0.476-2.562,2.62-4.573,5.215-4.891c1.682-0.208,3.319,0.266,4.615,1.327c1.004,0.823,1.717,1.951,2.039,3.194c1.012-0.916,2.319-1.426,3.714-1.426c3.067,0,5.563,2.495,5.563,5.562c0,0.084-0.002,0.166-0.007,0.248c2.254,0.674,3.848,2.778,3.848,5.165C90.137,63.419,87.72,65.836,84.748,65.836z"></path>
                <path fill="#fdfcef" d="M70.153,54.567c-1.808-0.119-3.365,1.13-3.476,2.789c-0.014,0.206-0.005,0.409,0.025,0.606c-0.349-0.394-0.865-0.661-1.458-0.7c-1.085-0.071-2.022,0.645-2.158,1.62c-0.197-0.054-0.403-0.09-0.616-0.104c-1.582-0.104-2.944,0.989-3.042,2.441"></path>
                <path fill="#472b29" d="M59.429,61.468c-0.006,0-0.012,0-0.017-0.001c-0.138-0.009-0.242-0.128-0.233-0.266c0.106-1.587,1.592-2.782,3.307-2.673c0.135,0.008,0.271,0.025,0.409,0.053c0.274-0.969,1.255-1.648,2.366-1.568c0.425,0.027,0.823,0.16,1.163,0.382c0.001-0.019,0.002-0.037,0.003-0.056c0.12-1.793,1.796-3.17,3.742-3.021c0.138,0.009,0.242,0.128,0.233,0.266s-0.14,0.253-0.266,0.232c-1.681-0.092-3.109,1.039-3.21,2.558c-0.013,0.184-0.005,0.369,0.023,0.551c0.017,0.109-0.041,0.217-0.141,0.265c-0.1,0.046-0.219,0.023-0.293-0.061c-0.318-0.359-0.788-0.584-1.288-0.617c-0.929-0.036-1.775,0.555-1.894,1.405c-0.01,0.071-0.05,0.135-0.11,0.175c-0.061,0.04-0.134,0.051-0.204,0.032c-0.191-0.052-0.381-0.084-0.567-0.097c-1.435-0.085-2.687,0.896-2.776,2.208C59.669,61.367,59.56,61.468,59.429,61.468z"></path>
                <path fill="#fdfcef" d="M86.728,56.236c-1.699-0.801-3.664-0.234-4.389,1.267c-0.09,0.186-0.157,0.379-0.201,0.574"></path>
                <path fill="#472b29" d="M82.138,58.326c-0.018,0-0.037-0.002-0.056-0.006c-0.135-0.031-0.219-0.165-0.188-0.3c0.049-0.216,0.123-0.427,0.219-0.626c0.782-1.621,2.9-2.242,4.721-1.385c0.125,0.06,0.179,0.208,0.12,0.333c-0.059,0.125-0.209,0.177-0.333,0.12c-1.574-0.743-3.394-0.227-4.058,1.148c-0.08,0.166-0.141,0.341-0.182,0.521C82.355,58.247,82.252,58.326,82.138,58.326z"></path>
                <path fill="#fff" d="M16.541 48.582H6.511c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h10.031c.276 0 .5.224.5.5S16.818 48.582 16.541 48.582zM19.422 48.582h-1.446c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.446c.276 0 .5.224.5.5S19.699 48.582 19.422 48.582zM23.477 48.582h-2.546c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h2.546c.276 0 .5.224.5.5S23.753 48.582 23.477 48.582zM23.477 50.447h-9.616c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h9.616c.276 0 .5.224.5.5S23.753 50.447 23.477 50.447zM12.129 50.447h-.58c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h.58c.276 0 .5.224.5.5S12.406 50.447 12.129 50.447zM9.752 50.447H8.296c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.456c.276 0 .5.224.5.5S10.029 50.447 9.752 50.447zM18.888 46.717h-5.027c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h5.027c.276 0 .5.224.5.5S19.164 46.717 18.888 46.717zM18.888 44.852h-1.257c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.257c.276 0 .5.224.5.5S19.164 44.852 18.888 44.852zM15.62 52.312h-1.759c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.759c.276 0 .5.224.5.5S15.896 52.312 15.62 52.312zM69.719 22.305h-10.03c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h10.03c.276 0 .5.224.5.5S69.996 22.305 69.719 22.305zM72.601 22.305h-1.446c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.446c.276 0 .5.224.5.5S72.877 22.305 72.601 22.305zM76.655 22.305h-2.546c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h2.546c.276 0 .5.224.5.5S76.931 22.305 76.655 22.305zM74.629 18.576h-9.617c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h9.617c.276 0 .5.224.5.5S74.906 18.576 74.629 18.576zM63.281 18.576h-.58c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h.58c.276 0 .5.224.5.5S63.558 18.576 63.281 18.576zM60.904 18.576h-1.456c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.456c.276 0 .5.224.5.5S61.181 18.576 60.904 18.576zM72.066 20.44h-5.027c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h5.027c.276 0 .5.224.5.5S72.342 20.44 72.066 20.44z"></path>
                <path fill="#fff" d="M72.066 18.576h-1.257c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.257c.276 0 .5.224.5.5S72.342 18.576 72.066 18.576zM65.583 20.44h-1.759c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.759c.276 0 .5.224.5.5S65.86 20.44 65.583 20.44z"></path>
                <path fill="#fdfcee" d="M28.728 46.696H53.954V67.939H28.728z"></path>
                <path fill="#472b29" d="M54.455,68.439H28.228V46.196h26.227V68.439z M29.228,67.439h24.227V47.196H29.228V67.439z"></path>
                <path fill="#472b29" d="M52.627,68.639H28.728c-0.387,0-0.7-0.313-0.7-0.7V46.696c0-0.387,0.313-0.7,0.7-0.7s0.7,0.313,0.7,0.7v20.543h23.199c0.387,0,0.7,0.313,0.7,0.7S53.014,68.639,52.627,68.639z"></path>
                <path fill="#fdfcee" d="M53.955 46.696H77.19V69.267H53.955z"></path>
                <path fill="#472b29" d="M77.189,69.967H53.955c-0.387,0-0.7-0.313-0.7-0.7V46.696c0-0.387,0.313-0.7,0.7-0.7h23.235c0.387,0,0.7,0.313,0.7,0.7v22.571C77.89,69.654,77.576,69.967,77.189,69.967z M54.655,68.567h21.834V47.396H54.655V68.567z"></path>
                <path fill="#cdcbbd" d="M54.618 47.36H76.525V49.352H54.618z"></path>
                <path fill="#ee3e54" d="M28.748 46.696L26.687 46.696 31.531 34.083 34.422 34.083 43.128 34.083 75.862 34.083 79.6 46.696 78.7 46.696z"></path>
                <path fill="#472b29" d="M79.6,47.396H26.687c-0.23,0-0.446-0.113-0.577-0.304c-0.13-0.19-0.159-0.433-0.076-0.647l4.844-12.613c0.104-0.271,0.364-0.449,0.653-0.449h44.332c0.31,0,0.583,0.204,0.671,0.501l3.738,12.613c0.062,0.212,0.021,0.441-0.11,0.618C80.029,47.291,79.821,47.396,79.6,47.396z M27.705,45.995h50.957L75.34,34.783H32.012L27.705,45.995z"></path>
                <path fill="#c0e5e4" d="M70.219 55.658L70.219 64.288 60.925 64.288 60.925 53.666 68.891 53.666"></path>
                <path fill="#472b29" d="M70.219,64.638h-9.294c-0.193,0-0.35-0.156-0.35-0.35V53.666c0-0.193,0.157-0.35,0.35-0.35h7.966c0.193,0,0.35,0.156,0.35,0.35s-0.157,0.35-0.35,0.35h-7.616v9.923h8.594v-8.281c0-0.193,0.157-0.35,0.35-0.35s0.35,0.156,0.35,0.35v8.631C70.569,64.482,70.413,64.638,70.219,64.638z"></path>
                <path fill="#472b29" d="M65.572,64.638c-0.193,0-0.35-0.156-0.35-0.35V53.666c0-0.193,0.157-0.35,0.35-0.35s0.35,0.156,0.35,0.35v10.622C65.922,64.482,65.766,64.638,65.572,64.638z"></path>
                <path fill="#b2b1c2" d="M43.01,67.607V57.369c0-2.402-2.091-4.367-4.647-4.367c-2.556,0-4.647,1.965-4.647,4.367v10.238H43.01z"></path>
                <path fill="#472b29" d="M43.01,67.956h-9.294c-0.193,0-0.35-0.156-0.35-0.35V57.37c0-2.601,2.242-4.717,4.997-4.717s4.997,2.116,4.997,4.717v10.237C43.36,67.8,43.203,67.956,43.01,67.956z M34.066,67.257h8.594V57.37c0-2.215-1.928-4.018-4.297-4.018s-4.297,1.803-4.297,4.018V67.257z"></path>
                <path fill="#c0e5e4" d="M41.018,59.641v-1.124c0-1.603-1.195-2.915-2.655-2.915s-2.655,1.312-2.655,2.915v1.124H41.018z"></path>
                <path fill="#472b29" d="M41.018 59.891h-5.311c-.138 0-.25-.112-.25-.25v-1.123c0-1.745 1.303-3.165 2.905-3.165s2.905 1.42 2.905 3.165v1.123C41.268 59.779 41.156 59.891 41.018 59.891zM35.957 59.391h4.811v-.873c0-1.47-1.079-2.665-2.405-2.665s-2.405 1.195-2.405 2.665V59.391zM41.682 62.546h-.664c-.138 0-.25-.112-.25-.25s.112-.25.25-.25h.664c.138 0 .25.112.25.25S41.82 62.546 41.682 62.546z"></path>
                <path fill="#cdcbbd" d="M29.392 47.36H53.291V48.688H29.392z"></path>
                <path fill="#c0e5e4" d="M50.976 60.305L46.329 60.305 46.329 54.33 51.64 54.33 51.64 58.977"></path>
                <path fill="#472b29" d="M50.976,60.655h-4.647c-0.193,0-0.35-0.156-0.35-0.35V54.33c0-0.193,0.157-0.35,0.35-0.35h5.311c0.193,0,0.35,0.156,0.35,0.35v4.646c0,0.193-0.157,0.35-0.35,0.35s-0.35-0.156-0.35-0.35V54.68h-4.61v5.275h4.297c0.193,0,0.35,0.156,0.35,0.35S51.169,60.655,50.976,60.655z"></path>
                <path fill="#472b29" d="M48.984,60.655c-0.193,0-0.35-0.156-0.35-0.35V54.33c0-0.193,0.157-0.35,0.35-0.35s0.35,0.156,0.35,0.35v5.975C49.334,60.498,49.178,60.655,48.984,60.655z"></path>
                <path fill="#fdd4b2" d="M68.891 31.759H73.53800000000001V41.053H68.891z"></path>
                <path fill="#472b29" d="M73.539,41.303h-4.647c-0.138,0-0.25-0.112-0.25-0.25v-9.294c0-0.138,0.112-0.25,0.25-0.25h4.647c0.138,0,0.25,0.112,0.25,0.25v9.294C73.789,41.191,73.677,41.303,73.539,41.303z M69.142,40.803h4.147v-8.794h-4.147V40.803z"></path>
                <path fill="#fbb97f" d="M74.202,32.423h-5.975c-0.365,0-0.664-0.299-0.664-0.664v0c0-0.365,0.299-0.664,0.664-0.664h5.975c0.365,0,0.664,0.299,0.664,0.664v0C74.866,32.124,74.567,32.423,74.202,32.423z"></path>
                <path fill="#472b29" d="M74.202 32.673h-5.975c-.504 0-.914-.41-.914-.914 0-.504.41-.914.914-.914h5.975c.504 0 .914.41.914.914C75.116 32.263 74.706 32.673 74.202 32.673zM68.227 31.345c-.228 0-.414.186-.414.414s.186.414.414.414h5.975c.229 0 .414-.186.414-.414s-.186-.414-.414-.414H68.227zM51.631 49.319H49.64c-.166 0-.3-.134-.3-.3s.134-.3.3-.3h1.992c.166 0 .3.134.3.3S51.797 49.319 51.631 49.319zM47.648 49.319H29.06c-.166 0-.3-.134-.3-.3s.134-.3.3-.3h18.588c.166 0 .3.134.3.3S47.813 49.319 47.648 49.319zM77.521 49.983h-17.26c-.166 0-.3-.134-.3-.3s.134-.3.3-.3h17.26c.166 0 .3.134.3.3S77.687 49.983 77.521 49.983zM66.9 37.37H32.379c-.166 0-.3-.134-.3-.3s.134-.3.3-.3H66.9c.166 0 .3.134.3.3S67.065 37.37 66.9 37.37zM64.908 39.362H31.716c-.166 0-.3-.134-.3-.3s.134-.3.3-.3h33.192c.166 0 .3.134.3.3S65.074 39.362 64.908 39.362zM63.58 41.353H31.052c-.166 0-.3-.134-.3-.3s.134-.3.3-.3H63.58c.166 0 .3.134.3.3S63.746 41.353 63.58 41.353zM58.269 49.983h-1.328c-.166 0-.3-.134-.3-.3s.134-.3.3-.3h1.328c.166 0 .3.134.3.3S58.435 49.983 58.269 49.983z"></path>
                <path fill="#fdfcef" d="M32.762,70.807c1.782,0,3.328,0,3.35,0c1.997,0,3.615-1.595,3.615-3.563c0-1.717-1.232-3.149-2.872-3.487c0.019-0.15,0.032-0.302,0.032-0.458c0-2.038-1.676-3.691-3.744-3.691c-1.221,0-2.302,0.579-2.986,1.47c-0.175-2.269-2.231-4.019-4.637-3.729c-1.759,0.212-3.214,1.552-3.538,3.27c-0.104,0.551-0.093,1.085,0.01,1.587c-0.472-0.501-1.143-0.816-1.891-0.816c-1.369,0-2.485,1.05-2.574,2.377c-0.621-0.135-1.297-0.127-2.009,0.137c-1.361,0.503-2.33,1.766-2.387,3.198c-0.081,2.033,1.568,3.706,3.612,3.706c0.155,0,0.701,0,0.827,0h7.507 M26.633,70.807h0.34"></path>
                <path fill="#472b29" d="M36.112,71.307h-3.35c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h3.35c1.718,0,3.115-1.374,3.115-3.063c0-1.441-1.04-2.702-2.474-2.998c-0.256-0.052-0.428-0.293-0.395-0.552c0.017-0.13,0.028-0.261,0.028-0.395c0-1.759-1.455-3.19-3.244-3.19c-1.024,0-1.968,0.464-2.589,1.274c-0.126,0.164-0.341,0.233-0.539,0.175c-0.199-0.06-0.34-0.234-0.356-0.441c-0.075-0.97-0.536-1.849-1.298-2.474c-0.776-0.638-1.768-0.921-2.78-0.798c-1.546,0.187-2.824,1.365-3.107,2.866c-0.088,0.469-0.085,0.938,0.009,1.393c0.045,0.22-0.061,0.441-0.259,0.545s-0.44,0.063-0.595-0.101c-0.4-0.425-0.943-0.658-1.527-0.658c-1.092,0-2.003,0.839-2.075,1.91c-0.01,0.146-0.082,0.279-0.199,0.366c-0.116,0.089-0.264,0.12-0.407,0.089c-0.598-0.129-1.164-0.093-1.729,0.117c-1.185,0.438-2.013,1.542-2.061,2.748c-0.033,0.833,0.269,1.624,0.848,2.228c0.595,0.618,1.399,0.959,2.265,0.959h8.334c0.276,0,0.5,0.224,0.5,0.5s-0.224,0.5-0.5,0.5h-8.334c-1.14,0-2.2-0.45-2.985-1.267c-0.771-0.802-1.17-1.853-1.126-2.959c0.063-1.605,1.153-3.07,2.712-3.646c0.575-0.212,1.167-0.289,1.769-0.237c0.336-1.33,1.557-2.308,2.988-2.308c0.457,0,0.905,0.103,1.312,0.293c0.01-0.219,0.035-0.438,0.077-0.657c0.363-1.925,1.995-3.436,3.97-3.673c1.288-0.162,2.545,0.206,3.534,1.017c0.696,0.571,1.206,1.336,1.47,2.181c0.749-0.606,1.684-0.941,2.678-0.941c2.34,0,4.244,1.88,4.244,4.19c0,0.027,0,0.054-0.001,0.08c1.67,0.538,2.842,2.099,2.842,3.864C40.227,69.484,38.381,71.307,36.112,71.307z M26.973,71.307h-0.34c-0.276,0-0.5-0.224-0.5-0.5s0.224-0.5,0.5-0.5h0.34c0.276,0,0.5,0.224,0.5,0.5S27.249,71.307,26.973,71.307z"></path>
                <path fill="#472b29" d="M34.496 65.765c-.018 0-.037-.002-.055-.006-.135-.03-.22-.164-.189-.299.036-.157.09-.312.161-.457.576-1.174 2.163-1.607 3.541-.966.125.059.18.207.121.332-.059.124-.208.177-.332.121-1.134-.527-2.425-.199-2.88.732-.054.11-.095.228-.122.347C34.714 65.686 34.611 65.765 34.496 65.765zM29.615 71.307h-1.048c-.276 0-.5-.224-.5-.5s.224-.5.5-.5h1.048c.276 0 .5.224.5.5S29.891 71.307 29.615 71.307z"></path>
            </svg>
        </a>
        <a href="#" class="navbar__button">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M21.669 21.6543C21.8625 21.4622 21.863 21.1494 21.6703 20.9566L17.3049 16.5913C18.7912 14.9327 19.7017 12.7525 19.7017 10.3508C19.7017 5.18819 15.5135 1 10.3508 1C5.18819 1 1 5.18819 1 10.3508C1 15.5135 5.18819 19.7017 10.3508 19.7017C12.7624 19.7017 14.9475 18.7813 16.606 17.2852L20.9739 21.653C21.1657 21.8449 21.4765 21.8454 21.669 21.6543ZM1.9843 10.3508C1.9843 5.7394 5.7394 1.9843 10.3508 1.9843C14.9623 1.9843 18.7174 5.7394 18.7174 10.3508C18.7174 14.9623 14.9623 18.7174 10.3508 18.7174C5.7394 18.7174 1.9843 14.9623 1.9843 10.3508Z" fill="var(--text-dark)" stroke="var(--text-dark)" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </a>
        <a href="#" class="navbar__button">
            <img width="40" height="40" src="icons/reel.png" class="icon" alt="">
        </a>
        <a href="#" class="navbar__button">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.6007 7.94185H6.47927C5.84559 7.94185 5.32113 8.43455 5.2816 9.06699L4.80842 16.638C4.6573 19.0559 6.57759 21.0999 9.00024 21.0999H15.0797C17.5023 21.0999 19.4226 19.0559 19.2715 16.638L18.7983 9.06699C18.7588 8.43455 18.2343 7.94185 17.6007 7.94185ZM6.47927 6.14185C4.89508 6.14185 3.58393 7.37361 3.48511 8.95471L3.01192 16.5257C2.79604 19.9799 5.53931 22.9 9.00024 22.9H15.0797C18.5406 22.9 21.2839 19.9799 21.068 16.5257L20.5948 8.95471C20.496 7.37361 19.1849 6.14185 17.6007 6.14185H6.47927Z" fill="var(--text-dark)" />
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2761 2.8C11.0812 2.8 10.1125 3.76867 10.1125 4.96359V6.1419H8.3125V4.96359C8.3125 2.77456 10.0871 1 12.2761 1C14.4651 1 16.2397 2.77456 16.2397 4.96359V6.1419H14.4397V4.96359C14.4397 3.76867 13.471 2.8 12.2761 2.8Z" fill="var(--text-dark)" />
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.2757 12.3118C13.4706 12.3118 14.4393 11.3431 14.4393 10.1482L14.4393 9.91256C14.4393 9.41551 14.8422 9.01256 15.3393 9.01256C15.8363 9.01256 16.2393 9.41551 16.2393 9.91256L16.2393 10.1482C16.2393 12.3373 14.4647 14.1118 12.2757 14.1118C10.0866 14.1118 8.31208 12.3373 8.31208 10.1482L8.31208 9.91257C8.31208 9.41551 8.71502 9.01257 9.21208 9.01257C9.70913 9.01257 10.1121 9.41551 10.1121 9.91257L10.1121 10.1482C10.1121 11.3431 11.0807 12.3118 12.2757 12.3118Z" fill="var(--text-dark)" />
            </svg>
        </a>
        <button class="navbar__button profile-button">
            <div class="profile-button__border"></div>
            <div class="profile-button__picture">
                <img src="<?php echo $recipientPassport ?>" alt="User Picture" />
            </div>
        </button>
    </nav>
</body>
<!-- <script>
    function loadNewsFeed() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    console.log('Response:', xhr.responseText);
                    var newsFeed = document.getElementById('newsFeed');
                    newsFeed.innerHTML = '';

                    response.posts.forEach(function(post) {
                        var postElement = document.createElement('article');
                        postElement.className = 'post';

                        var postHeaderDiv = document.createElement('div');
                        postHeaderDiv.className = 'post__header';

                        var postProfile = document.createElement('div');
                        postProfile.className = 'post__profile';

                        var authorLink = document.createElement('a');
                        authorLink.href = 'user_profile.php?UserId=' + post.UserId;
                        authorLink.style.textDecoration = 'none';
                        authorLink.className = 'post__avatar';

                        var userPassportImg = document.createElement('img');
                        userPassportImg.src = post.passport;


                        var authorNameP = document.createElement('a');
                        authorLink.href = 'user_profile.php?UserId=' + post.UserId;
                        authorNameP.className = 'post__user';
                        authorNameP.innerHTML = '<strong>' + post.surname + ' ' + post.firstName + '</strong>';

                        authorLink.appendChild(userPassportImg);
                        postProfile.appendChild(authorLink);
                        postProfile.appendChild(authorNameP);
                        postHeaderDiv.appendChild(postProfile);

                        var threeDotsDiv = document.createElement('button');
                        threeDotsDiv.className = 'post__more-options';

                        var svgMoreoptions = document.createElement('svg');
                        svgMoreoptions.width = '24';
                        svgMoreoptions.height = '24';
                        svgMoreoptions.viewBox = '0 0 24 24';
                        svgMoreoptions.fill = 'none';
                        svgMoreoptions.xmlns = 'http://www.w3.org/2000/svg';

                        var circleSvg1 = document.createElement('circle');
                        circleSvg1.cx = '6.5';
                        circleSvg1.cy = '11.5';
                        circleSvg1.r = '1.5';
                        circleSvg1.fill = 'var(--text-dark)';

                        var circleSvg2 = document.createElement('circle');
                        circleSvg2.cx = '12';
                        circleSvg2.cy = '11.5';
                        circleSvg2.r = '1.5';
                        circleSvg2.fill = 'var(--text-dark)';

                        var circleSvg3 = document.createElement('circle');
                        circleSvg3.cx = '17.5';
                        circleSvg3.cy = '11.5';
                        circleSvg3.r = '1.5';
                        circleSvg3.fill = 'var(--text-dark)';

                        // circle in more options 
                        svgMoreoptions.appendChild(circleSvg1);
                        svgMoreoptions.appendChild(circleSvg2);
                        svgMoreoptions.appendChild(circleSvg3);

                        // more options in dots 
                        threeDotsDiv.appendChild(svgMoreoptions);

                        // dots and profile 
                        postHeaderDiv.appendChild(threeDotsDiv);
                        postHeaderDiv.appendChild(postProfile);

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
                        blockUserButton.id = 'blockUser-' + post.UserId;
                        blockUserButton.dataset.recipientid = post.UserId;
                        blockUserButton.dataset.bsToggle = 'modal';
                        blockUserButton.dataset.bsTarget = '#blockUserModal-' + post.UserId;
                        blockUserButton.innerHTML = 'Block User';

                        var blockUserInput = document.createElement('input');
                        blockUserInput.type = 'hidden';
                        blockUserInput.id = 'bu' + post.UserId;
                        blockUserInput.value = post.UserId;

                        blockUserDiv.appendChild(blockUserButton);
                        blockUserDiv.appendChild(blockUserInput);

                        var blockButtonDiv = document.createElement('div');
                        var blockButtonButton = document.createElement('button');
                        blockButtonButton.type = 'button';
                        blockButtonButton.className = 'btn btn-primary blockButton';
                        blockButtonButton.id = 'blockButton-' + post.postId;
                        blockButtonButton.dataset.postid = post.postId;
                        blockButtonButton.dataset.bsToggle = 'modal';
                        blockButtonButton.dataset.bsTarget = '#blockTypeofPostModal-' + post.postId;
                        blockButtonButton.innerHTML = 'Block this type of post';

                        var blockButtonInput = document.createElement('input');
                        blockButtonInput.type = 'hidden';
                        blockButtonInput.id = 'b' + post.postId;
                        blockButtonInput.value = post.postId;

                        blockButtonDiv.appendChild(blockButtonButton);
                        blockButtonDiv.appendChild(blockButtonInput);

                        dropdownMenu.appendChild(blockUserDiv);
                        dropdownMenu.appendChild(blockButtonDiv);
                        dropdownMenu.innerHTML += '<a class="dropdown-item" href="#">Report user</a>' +
                            '<a class="dropdown-item" href="#">Repost post</a>';

                        threeDotsDiv.appendChild(dropdownButton);
                        threeDotsDiv.appendChild(dropdownMenu);

                        var postContent = document.createElement('div');
                        postContent.className = 'post__content';
                        // Create a div for the post media
                        var postMediaDiv = document.createElement('div');
                        postMediaDiv.className = 'post__medias';

                        // Check if the post has an image
                        if (post.image !== null && post.image !== '') {
                            var image = document.createElement('img');
                            image.className = 'post__media';
                            image.src = post.image;
                            image.alt = 'Image by' + +post.surname + ' ' + post.firstName;
                        }

                        // Check if the post has a video
                        if (post.video !== null && post.video !== '') {
                            // var postItem = document.createElement('div');
                            // postItem.className = 'post-item';
                            var videoContainer = document.createElement('div');
                            videoContainer.className = 'post__media';
                            var video = document.createElement('video');
                            video.setAttribute('data-my-Video-id', post.postId);
                            video.id = 'myVideo-' + post.postId;
                            video.className = 'w-100';
                            var source = document.createElement('source');
                            source.src = post.video;
                            source.type = 'video/mp4';
                            video.appendChild(source);
                            videoContainer.appendChild(video);
                            // videoContainer.innerHTML += 'Your browser does not support the video tag.';
                            var videoControls = document.createElement('div');
                            videoControls.className = 'video-controls';
                            var rewindButton = document.createElement('button');
                            rewindButton.id = 'rewindButton-' + post.postId;
                            rewindButton.onclick = function() {
                                rewind(post.postId);
                            };
                            rewindButton.innerHTML = '<i class="bi bi-rewind"></i>';
                            videoControls.appendChild(rewindButton);
                            var playPauseButton = document.createElement('button');
                            playPauseButton.onclick = function() {
                                togglePlayPause(post.postId);
                            };
                            playPauseButton.innerHTML = '<span id="playPauseButton-' + post.postId + '"><i class="bi bi-play"></i></span>';
                            videoControls.appendChild(playPauseButton);
                            var fastForwardButton = document.createElement('button');
                            fastForwardButton.id = 'fastForwardButton-' + post.postId;
                            fastForwardButton.onclick = function() {
                                fastForward(post.postId);
                            };
                            fastForwardButton.innerHTML = '<i class="bi bi-fast-forward"></i>';
                            videoControls.appendChild(fastForwardButton);
                            var volumeControl = document.createElement('div');
                            volumeControl.className = 'volume-control';
                            var volumeRange = document.createElement('input');
                            volumeRange.type = 'range';
                            volumeRange.id = 'volumeRange-' + post.postId;
                            volumeRange.min = '0';
                            volumeRange.max = '1';
                            volumeRange.step = '0.01';
                            volumeRange.value = '1';
                            volumeRange.onchange = function() {
                                setVolume(post.postId);
                            };
                            volumeControl.appendChild(volumeRange);
                            videoControls.appendChild(volumeControl);
                            var timeControl = document.createElement('div');
                            timeControl.className = 'time-control';
                            var timeRange = document.createElement('input');
                            timeRange.type = 'range';
                            timeRange.id = 'timeRange-' + post.postId;
                            timeRange.min = '0';
                            timeRange.step = '0.01';
                            timeRange.value = '0';
                            timeRange.onchange = function() {
                                setCurrentTime(post.postId);
                            };
                            timeControl.appendChild(timeRange);
                            var timeDisplay = document.createElement('div');
                            timeDisplay.className = 'time-display';
                            var currentTimeDisplay = document.createElement('div');
                            currentTimeDisplay.className = 'currentTimeDisplay';
                            currentTimeDisplay.id = 'currentTimeDisplay-' + post.postId;
                            currentTimeDisplay.innerHTML = '0:00';
                            timeDisplay.appendChild(currentTimeDisplay);
                            timeDisplay.innerHTML += '<div class="slash">/</div>';
                            var durationDisplay = document.createElement('div');
                            durationDisplay.className = 'durationDisplay';
                            durationDisplay.id = 'durationDisplay-' + post.postId;
                            durationDisplay.innerHTML = '0:00';
                            timeDisplay.appendChild(durationDisplay);
                            timeControl.appendChild(timeDisplay);
                            videoControls.appendChild(timeControl);
                            videoContainer.appendChild(videoControls);


                            postMediaDiv.appendChild(videoContainer);
                            postMediaDiv.appendChild(image);

                            var postFooter = document.createElement('div');
                            postFooter.className = 'post__footer';

                            var postButtons = document.createElement('div');
                            postButtons.className = 'post__buttons';

                            var postButton = document.createElement('button');
                            postButton.className = 'post__button';

                            var svgpostButton = document.createElement('svg');
                            svgpostButton.width = '24';
                            svgpostButton.height = '24';
                            svgpostButton.viewBox = '0 0 24 24';
                            svgpostButton.fill = 'none';
                            svgpostButton.xmlns = 'http://www.w3.org/2000/svg';

                            var svgpostButtonpath = document.createElement('path');
                            svgpostButtonpath.d = 'M11.4995 21.2609C11.1062 21.2609 10.7307 21.1362 10.4133 20.9001C8.2588 19.3012 3.10938 15.3239 1.81755 12.9143C0.127895 9.76543 1.14258 5.72131 4.07489 3.89968C5.02253 3.31177 6.09533 3 7.18601 3C8.81755 3 10.3508 3.66808 11.4995 4.85726C12.6483 3.66808 14.1815 3 15.8131 3C16.9038 3 17.9766 3.31177 18.9242 3.89968C21.8565 5.72131 22.8712 9.76543 21.186 12.9143C19.8942 15.3239 14.7448 19.3012 12.5902 20.9001C12.2684 21.1362 11.8929 21.2609 11.4995 21.2609ZM7.18601 4.33616C6.34565 4.33616 5.5187 4.57667 4.78562 5.03096C2.43888 6.49183 1.63428 9.74316 2.99763 12.2819C4.19558 14.5177 9.58639 18.6242 11.209 19.8267C11.3789 19.9514 11.6158 19.9514 11.7856 19.8267C13.4082 18.6197 18.799 14.5133 19.997 12.2819C21.3603 9.74316 20.5557 6.48738 18.209 5.03096C17.4804 4.57667 16.6534 4.33616 15.8131 4.33616C14.3425 4.33616 12.9657 5.04878 12.0359 6.28696L11.4995 7.00848L10.9631 6.28696C10.0334 5.04878 8.6611 4.33616 7.18601 4.33616Z';
                            svgpostButtonpath.fill = 'var(--text-dark)';
                            svgpostButtonpath.stroke= 'var(--text-dark)';
                            svgpostButtonpath.strokeWidth = '0.6';

                            svgpostButton.appendChild(svgpostButtonpath);
                            postButtons.appendChild(svgpostButton);
                            postFooter.appendChild(postButtons);
                            postButtons.appendChild(postButton);

                            // Create the Previous and Next buttons
                            var previousButton = document.createElement('button');
                            previousButton.className = 'previous-button';
                            previousButton.innerHTML = '<i class="bi bi-arrow-left"></i>';

                            var nextButton = document.createElement('button');
                            nextButton.className = 'next-button';
                            nextButton.innerHTML = '<i class="bi bi-arrow-right"></i>';

                            var button = document.createElement('div');
                            button.className = 'button';

                            // Append the Previous and Next buttons to the postMediaDiv
                            button.appendChild(previousButton);
                            button.appendChild(nextButton);
                            postMediaDiv.appendChild(button);

                            // Get all the post items
                            var postItems = postMediaDiv.getElementsByClassName('post-item');
                            var currentIndex = 0; // Track the current index of the post item

                            // Add click event listeners to scroll to the previous and next post items
                            previousButton.addEventListener('click', function() {
                                if (currentIndex > 0) {
                                    postItems[currentIndex].style.display = 'none'; // Hide the current post item
                                    currentIndex--; // Decrement the current index
                                    postItems[currentIndex].style.display = 'block'; // Show the previous post item
                                    postItems[currentIndex].scrollIntoView({
                                        behavior: 'smooth'
                                    }); // Scroll to the previous post item
                                }
                            });

                            nextButton.addEventListener('click', function() {
                                if (currentIndex < postItems.length - 1) {
                                    postItems[currentIndex].style.display = 'none'; // Hide the current post item
                                    currentIndex++; // Increment the current index
                                    postItems[currentIndex].style.display = 'block'; // Show the next post item
                                    postItems[currentIndex].scrollIntoView({
                                        behavior: 'smooth'
                                    }); // Scroll to the next post item
                                }
                            });
                        }

                        // Hide all media elements except the first one
                        var mediaItems = postMediaDiv.getElementsByClassName('post-item');
                        console.log(mediaItems.length);
                        for (var i = 1; i < mediaItems.length; i++) {
                            mediaItems[i].style.display = 'none';
                        }

                        // Append the post media div before the post content
                        // newsFeedPostDiv.insertBefore(postMediaDiv, postContentDiv);

                        var postContentDiv = document.createElement('div');
                        postContentDiv.className = 'post-content';
                        postContentDiv.textContent = post.content;

                        var postDateDiv = document.createElement('div');
                        postDateDiv.className = 'post-date';
                        postDateDiv.textContent = post.timeAgo;

                        var footerDiv = document.createElement('div');
                        footerDiv.className = 'footer';

                        var likeButton = document.createElement('button');
                        likeButton.type = 'button';
                        likeButton.className = 'btn btn-primary like ' + (post.isLiking ? 'likeing' : 'unlike');
                        likeButton.dataset.postid = post.postId;
                        likeButton.innerHTML = '<span class="like-count">' + post.likes + '</span>' +
                            '<span class="emoji">&#x2764;</span>' +
                            (post.isLiking ? 'Unlike' : 'Like');

                        var shareButton = document.createElement('button');
                        shareButton.type = 'button';
                        shareButton.className = 'btn btn-primary share-button';
                        shareButton.dataset.postid = post.postId;
                        shareButton.innerHTML = '<i class="bi bi-share"></i> Share';

                        var commentButton = document.createElement('button');
                        commentButton.type = 'button';
                        commentButton.className = 'btn btn-primary comment-button';
                        commentButton.dataset.postid = post.postId;
                        commentButton.innerHTML = '<i class="bi bi-chat-dots"></i> Comment';

                        footerDiv.appendChild(likeButton);
                        footerDiv.appendChild(shareButton);
                        footerDiv.appendChild(commentButton);

                        var postTitleDiv = document.createElement('div');
                        postTitleDiv.className = 'post-title';

                        var postTitleH2 = document.createElement('h2');
                        postTitleH2.textContent = post.title;

                        postTitleDiv.appendChild(postTitleH2);
                        postElement.appendChild(postTitleDiv);
                        // Append the post media div to the post div
                        postElement.appendChild(postMediaDiv);
                        postElement.appendChild(postContentDiv);
                        postElement.appendChild(postDateDiv);
                        postElement.appendChild(footerDiv);
                        postElement.appendChild(postHeaderDiv);

                        newsFeed.appendChild(postElement);
                    });
                    $('.owl-carousel').owlCarousel({
                        items: 1,
                        loop: true,
                        nav: true,
                        dots: false,
                        navText: ['<i class="bi bi-chevron-left"></i>', '<i class="bi bi-chevron-right"></i>']
                    })
                } else {
                    console.log('Error: ' + xhr.status);
                }
            }
        };

        xhr.open('GET', 'get_posts.php', true);
        xhr.send();
    }

    // Load initial news feed
    loadNewsFeed();
</script> -->

<script>
    // Elements
    const toggleThemeBtn = document.querySelector('.header__theme-button');
    const storiesContent = document.querySelector('.stories__content');
    const storiesLeftButton = document.querySelector('.stories__left-button');
    const storiesRightButton = document.querySelector('.stories__right-button');
    const posts = document.querySelectorAll('.post');
    const postsContent = document.querySelectorAll('.post__content');

    // ===================================
    // DARK/LIGHT THEME
    // Set initial theme from LocalStorage
    document.onload = setInitialTheme(localStorage.getItem('theme'));

    function setInitialTheme(themeKey) {
        if (themeKey === 'dark') {
            document.documentElement.classList.add('darkTheme');
        } else {
            document.documentElement.classList.remove('darkTheme');
        }
    }

    // Toggle theme button
    toggleThemeBtn.addEventListener('click', () => {
        // Toggle root class
        document.documentElement.classList.toggle('darkTheme');

        // Saving current theme on LocalStorage
        if (document.documentElement.classList.contains('darkTheme')) {
            localStorage.setItem('theme', 'dark');
        } else {
            localStorage.setItem('theme', 'light');
        }
    });

    // ===================================
    // STORIES SCROLL BUTTONS
    // Scrolling stories content
    storiesLeftButton.addEventListener('click', () => {
        storiesContent.scrollLeft -= 320;
    });
    storiesRightButton.addEventListener('click', () => {
        storiesContent.scrollLeft += 320;
    });

    // Checking if screen has minimun size of 1024px
    if (window.matchMedia('(min-width: 1024px)').matches) {
        // Observer to hide buttons when necessary
        const storiesObserver = new IntersectionObserver(
            function(entries) {
                entries.forEach((entry) => {
                    if (entry.target === document.querySelector('.story:first-child')) {
                        storiesLeftButton.style.display = entry.isIntersecting ?
                            'none' :
                            'unset';
                    } else if (
                        entry.target === document.querySelector('.story:last-child')
                    ) {
                        storiesRightButton.style.display = entry.isIntersecting ?
                            'none' :
                            'unset';
                    }
                });
            }, {
                root: storiesContent,
                threshold: 1
            }
        );

        // Calling the observer with the first and last stories
        storiesObserver.observe(document.querySelector('.story:first-child'));
        storiesObserver.observe(document.querySelector('.story:last-child'));
    }

    // ===================================
    // POST MULTIPLE MEDIAS
    // Creating scroll buttons and indicators when post has more than one media
    posts.forEach((post) => {
        if (post.querySelectorAll('.post__media').length > 1) {
            const leftButtonElement = document.createElement('button');
            leftButtonElement.classList.add('post__left-button');
            leftButtonElement.innerHTML = `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path fill="#fff" d="M256 504C119 504 8 393 8 256S119 8 256 8s248 111 248 248-111 248-248 248zM142.1 273l135.5 135.5c9.4 9.4 24.6 9.4 33.9 0l17-17c9.4-9.4 9.4-24.6 0-33.9L226.9 256l101.6-101.6c9.4-9.4 9.4-24.6 0-33.9l-17-17c-9.4-9.4-24.6-9.4-33.9 0L142.1 239c-9.4 9.4-9.4 24.6 0 34z"></path>
      </svg>
    `;

            const rightButtonElement = document.createElement('button');
            rightButtonElement.classList.add('post__right-button');
            rightButtonElement.innerHTML = `
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path fill="#fff" d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm113.9 231L234.4 103.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L285.1 256 183.5 357.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L369.9 273c9.4-9.4 9.4-24.6 0-34z"></path>
      </svg>
    `;

            post.querySelector('.post__content').appendChild(leftButtonElement);
            post.querySelector('.post__content').appendChild(rightButtonElement);

            post.querySelectorAll('.post__media').forEach(function() {
                const postMediaIndicatorElement = document.createElement('div');
                postMediaIndicatorElement.classList.add('post__indicator');

                post
                    .querySelector('.post__indicators')
                    .appendChild(postMediaIndicatorElement);
            });

            // Observer to change the actual media indicator
            const postMediasContainer = post.querySelector('.post__medias');
            const postMediaIndicators = post.querySelectorAll('.post__indicator');
            const postIndicatorObserver = new IntersectionObserver(
                function(entries) {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            // Removing all the indicators
                            postMediaIndicators.forEach((indicator) =>
                                indicator.classList.remove('post__indicator--active')
                            );
                            // Adding the indicator that matches the current post media
                            postMediaIndicators[
                                Array.from(postMedias).indexOf(entry.target)
                            ].classList.add('post__indicator--active');
                        }
                    });
                }, {
                    root: postMediasContainer,
                    threshold: 0.5
                }
            );

            // Calling the observer for every post media
            const postMedias = post.querySelectorAll('.post__media');
            postMedias.forEach((media) => {
                postIndicatorObserver.observe(media);
            });
        }
    });

    // Adding buttons features on every post with multiple medias
    postsContent.forEach((post) => {
        if (post.querySelectorAll('.post__media').length > 1) {
            const leftButton = post.querySelector('.post__left-button');
            const rightButton = post.querySelector('.post__right-button');
            const postMediasContainer = post.querySelector('.post__medias');

            // Functions for left and right buttons
            leftButton.addEventListener('click', () => {
                postMediasContainer.scrollLeft -= 400;
            });
            rightButton.addEventListener('click', () => {
                postMediasContainer.scrollLeft += 400;
            });

            // Observer to hide button if necessary
            const postButtonObserver = new IntersectionObserver(
                function(entries) {
                    entries.forEach((entry) => {
                        if (entry.target === post.querySelector('.post__media:first-child')) {
                            leftButton.style.display = entry.isIntersecting ? 'none' : 'unset';
                        } else if (
                            entry.target === post.querySelector('.post__media:last-child')
                        ) {
                            rightButton.style.display = entry.isIntersecting ? 'none' : 'unset';
                        }
                    });
                }, {
                    root: postMediasContainer,
                    threshold: 0.5
                }
            );

            if (window.matchMedia('(min-width: 1024px)').matches) {
                postButtonObserver.observe(
                    post.querySelector('.post__media:first-child')
                );
                postButtonObserver.observe(post.querySelector('.post__media:last-child'));
            }
        }
    });
</script>

</html>