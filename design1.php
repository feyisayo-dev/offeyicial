<!DOCTYPE html>
<html>
    <style>
        article,
aside,
details,
figcaption,
figure,
footer,
header,
hgroup,
main,
nav,
section,
summary {
    display: block;
}

audio,
canvas,
video {
    display: inline-block;
}

audio:not([controls]) {
    display: none;
    height: 0;
}

[hidden] {
    display: none;
}

html {
    font-family: sans-serif;
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
}

body {
    margin: 0;
}

a:focus {
    outline: thin dotted;
}

a:active,
a:hover {
    outline: 0;
}

h1 {
    font-size: 2em;
    margin: 0.67em 0;
}

abbr[title] {
    border-bottom: 1px dotted;
}

b,
strong {
    font-weight: bold;
}

dfn {
    font-style: italic;
}

hr {
    -moz-box-sizing: content-box;
    box-sizing: content-box;
    height: 0;
}

mark {
    background: #ff0;
    color: #000;
}

code,
kbd,
pre,
samp {
    font-family: monospace, serif;
    font-size: 1em;
}

pre {
    white-space: pre-wrap;
}

q {
    quotes: "\201C" "\201D" "\2018" "\2019";
}

small {
    font-size: 80%;
}

sub,
sup {
    font-size: 75%;
    line-height: 0;
    position: relative;
    vertical-align: baseline;
}

sup {
    top: -0.5em;
}

sub {
    bottom: -0.25em;
}

img {
    border: 0;
}

svg:not(:root) {
    overflow: hidden;
}

figure {
    margin: 0;
}

fieldset {
    border: 1px solid #c0c0c0;
    margin: 0 2px;
    padding: 0.35em 0.625em 0.75em;
}

legend {
    border: 0;
    padding: 0;
}

button,
input,
select,
textarea {
    font-family: inherit;
    font-size: 100%;
    margin: 0;
}

button,
input {
    line-height: normal;
}

button,
select {
    text-transform: none;
}

button,
html input[type="button"],
input[type="reset"],
input[type="submit"] {
    -webkit-appearance: button;
    cursor: pointer;
}

button[disabled],
html input[disabled] {
    cursor: default;
}

input[type="checkbox"],
input[type="radio"] {
    box-sizing: border-box;
    padding: 0;
}

input[type="search"] {
    -webkit-appearance: textfield;
    -moz-box-sizing: content-box;
    -webkit-box-sizing: content-box;
    box-sizing: content-box;
}

input[type="search"]::-webkit-search-cancel-button,
input[type="search"]::-webkit-search-decoration {
    -webkit-appearance: none;
}

button::-moz-focus-inner,
input::-moz-focus-inner {
    border: 0;
    padding: 0;
}

textarea {
    overflow: auto;
    vertical-align: top;
}

table {
    border-collapse: collapse;
    border-spacing: 0;
}

*,
*::after,
*::before {
    box-sizing: border-box;
}

:root {
    font-size: 14px;
}

body {
    --color-text: #ff00c4;
    --color-bg: #1c1423;
    --color-link: #59545e;
    --color-link-hover: #fff;
    --color-slide-text: #fff;
    --color-nav: #fff;
    --font-trail-weight: 900;
    --font-trail-size: 17vh;
    --font-trail-lheight: 0.75;
    --font-trail-family: Kanit, sans-serif;
    color: var(--color-text);
    background-color: var(--color-bg);
    font-family: Kanit, sans-serif;
    font-weight: 500;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

.demo-2 {
    --color-text: #173b4e;
    --color-bg: #00161f;
    --color-link: #f53f73;
    --color-link-hover: #f6fcff;
    --color-slide-text: #f6fcff;
    --color-nav: #fff;
    --font-trail-weight: 700;
    --font-trail-size: 15vh;
    --font-trail-lheight: 0.85;
    --font-trail-family: "Syncopate", sans-serif;
}

.demo-3 {
    --color-text: #d4115d;
    --color-bg: #000000;
    --color-link: #43b8d1;
    --color-link-hover: #fff;
    --color-slide-text: #43b8d1;
    --color-nav: #fff;
    --font-trail-weight: 400;
    --font-trail-size: 15vh;
    --font-trail-lheight: 0.85;
    --font-trail-family: "Goblin One", sans-serif;
}

.demo-4 {
    --color-slide-text: #6b12e2;
    --color-text: #2e00ff;
    --color-bg: #15131b;
    --color-link: #ff2cff;
    --color-nav: #fff;
    --font-trail-weight: 700;
    --font-trail-size: 15vh;
    --font-trail-lheight: 0.85;
    --font-trail-family: "Source Code Pro", sans-serif;
}

.demo-5 {
    --color-slide-text: #d7e7f1;
    --color-link: #d61e68;
    --color-text: #00baff;
    --color-nav: #fff;
    --font-trail-weight: 700;
    --font-trail-size: 18vh;
    --font-trail-lheight: 0.85;
    --font-trail-family: "Syncopate", sans-serif;
}

/* Page Loader */
.js .loading::before {
    content: '';
    position: fixed;
    z-index: 100000;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--color-bg);
}

.js .loading::after {
    content: '';
    position: fixed;
    z-index: 100000;
    top: 50%;
    left: 50%;
    width: 60px;
    height: 60px;
    margin: -30px 0 0 -30px;
    pointer-events: none;
    border-radius: 50%;
    opacity: 0.4;
    background: var(--color-link);
    animation: loaderAnim 0.7s linear infinite alternate forwards;
}

@keyframes loaderAnim {
    to {
        opacity: 1;
        transform: scale3d(0.5, 0.5, 1);
    }
}

a {
    text-decoration: none;
    color: var(--color-link);
    outline: none;
}

a:hover,
a:focus {
    color: var(--color-link-hover);
    outline: none;
}

.frame {
    padding: 3rem 5vw 0;
    text-align: center;
    position: relative;
    z-index: 1000;
}

.frame__title {
    font-size: 1rem;
    margin: 0 0 1rem;
    font-weight: normal;
}

.frame__links {
    display: inline;
}

.frame__links a:not(:last-child),
.frame__demos a:not(:last-child) {
    margin-right: 1rem;
}

.frame__demos {
    margin: 1rem 0;
}

.frame__demo--current,
.frame__demo--current:hover {
    color: var(--color-text);
}

.content {
    display: grid;
    grid-template-rows: 100%;
    grid-template-columns: 100%;
    grid-template-areas: 'main';
    height: calc(100vh - 19rem);
    width: 100%;
    margin: 0 auto;
    position: relative;
}

.content__slide {
    grid-area: main;
    width: 100%;
    height: 100%;
    overflow: hidden;
    display: grid;
    grid-template-rows: 100%;
    grid-template-columns: 100%;
    grid-template-areas: 'inner';
    align-items: center;
    opacity: 0;
    pointer-events: none;
}

.content__slide--current {
    opacity: 1;
}

.content__img,
.content__text-wrap {
    grid-area: inner;
    width: 100%;
}

.content__img {
    height: calc(100vh - 25rem);
    width: 90%;
    max-width: calc(1000px - 11rem);
    max-height: 600px;
    justify-self: center;
    overflow: hidden;
    z-index: -1;
    position: relative;
}

.content__img--full::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    background: rgba(0, 0, 0, 0.3);
    width: 100%;
    height: 100%;
}

.content__img-inner {
    width: 100%;
    height: 100%;
    background-position: 50% 50%;
    background-size: cover;
}

.content__text-wrap {
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.demo-4 .content__text-wrap {
    mix-blend-mode: color-dodge;
}

.demo-5 .content__text-wrap {
    mix-blend-mode: luminosity;
}

.content__text {
    overflow: hidden;
    flex: 1;
    opacity: 0;
    pointer-events: none;
}

.content__text:nth-child(6) {
    opacity: 1;
}

.content__text--full {
    flex: none;
}

.content__text-inner {
    display: block;
    color: var(--color-slide-text);
    text-transform: uppercase;
    font-size: 3.5rem;
    font-weight: var(--font-trail-weight);
    line-height: var(--font-trail-lheight);
    font-family: var(--font-trail-family);
}

.content__text-inner--bottom {
    transform: translate3d(0, -40%, 0);
}

.content__text-inner--stroke {
    -webkit-text-stroke: 2px var(--color-slide-text);
    text-stroke: 2px var(--color-slide-text);
    -webkit-text-fill-color: transparent;
    text-fill-color: transparent;
    color: transparent;
}

.content__nav {
    grid-area: main;
    justify-self: center;
    align-self: end;
    width: 80%;
    max-width: 900px;
    height: auto;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    font-size: 1.25rem;
    position: relative;
}

.content__nav-button {
    border: 0;
    cursor: pointer;
    background: none;
    margin: 0.25rem 0;
    padding: 0;
    text-transform: lowercase;
    color: var(--color-nav);
    font-weight: 900;
    line-height: 1;
}

.content__nav-button:focus {
    outline: none;
}

.content__nav-button--next {
    transform: translateX(1rem);
}

@media screen and (min-width: 53em) {
    :root {
        font-size: 16px;
    }

    .frame {
        position: fixed;
        text-align: left;
        z-index: 10000;
        top: 0;
        left: 0;
        display: grid;
        align-content: space-between;
        width: 100%;
        max-width: none;
        height: 100vh;
        padding: 3rem;
        pointer-events: none;
        grid-template-columns: 50% 50%;
        grid-template-rows: auto auto auto;
        grid-template-areas: 'title tagline'
            '... ...'
            'links demos';
    }

    .frame__title-wrap {
        grid-area: title;
        display: flex;
    }

    .frame__title {
        margin: 0;
    }

    .frame__tagline {
        grid-area: tagline;
        justify-self: end;
        margin: 0;
        text-align: right;
    }

    .frame__demos {
        margin: 0;
        grid-area: demos;
        justify-self: end;
    }

    .frame__links {
        grid-area: links;
        padding: 0;
        justify-self: start;
    }

    .frame a {
        pointer-events: auto;
    }

    .content {
        height: 100vh;
    }

    .content__img {
        width: calc(90% - 11rem);
        height: 60vh;
    }

    .content__img--full {
        height: calc(100vh + 20px);
        width: calc(100vw + 20px);
        max-width: none;
        max-height: none;
    }

    .content__text-inner {
        font-size: var(--font-trail-size);
    }

    .content__nav {
        align-self: center;
        flex-direction: column;
        justify-content: flex-start;
        margin-top: 30vh;
        font-size: 1.75rem;
    }

    .demo-5 .content__text-inner--stroke {
        -webkit-text-stroke: 3px var(--color-slide-text);
        text-stroke: 3px var(--color-slide-text);
    }
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background-color: rgba(0, 0, 0, 0.55);
    overflow: hidden;
    padding: 0.8rem;
}

.modal .modal-container {
    background-color: #fff;
    max-width: 400px;
    margin: 3vh auto;
    padding: 1rem 2rem 2.5rem;
    border-radius: 10px;
    transition: 0.5s ease all;
    animation: animate 0.6s ease;
}

.modal .modal-container .form h3 {
    text-align: center;
    color: #111;
}

.modal .modal-container .form .form-control {
    margin-bottom: 0.5rem;
}

.modal .modal-container .form .form-control label {
    display: block;
    margin-bottom: 0.25rem;
}

.modal .modal-container .form .form-control input,
.modal .modal-container .form .form-control select,
.modal .modal-container .form .form-control textarea {
    padding: 0.5rem 0.7rem;
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.95rem;
}

.modal .modal-container .form button {
    background-color: #111;
    color: #fff;
    padding: 0.6rem 1rem;
    width: 100%;
    border-radius: 4px;
    border: 1px solid #111;
    margin-top: 1rem;
    font-size: 0.95rem;

}

.modal .modal-container .form button:hover {
    opacity: 0.85;
    cursor: pointer;
}

@keyframes animate {
    from {
        transform: translateY(-20px);
    }

    to {
        transform: translateY(0);
    }
}

@media (max-width: 550px) {
    .container {
        max-width: 550px;
    }

    .container .container-top .left p {
        margin-right: 2rem;
    }

    .container .container-top .right button {
        font-size: 0.8rem;
        color: #fff;
        width: 6rem;
        padding: 1rem 0.2rem;
    }

    .modal .modal-container {
        max-width: 300px;
    }
}

@media (max-width: 350px) {
    .container {
        max-width: 350px;
    }

    .container .container-top {
        flex-direction: column;
    }

    .container .container-top .left {
        text-align: center;
    }

    .container .container-top .left p {
        margin-right: 0rem;
    }

    .container .container-top .right button {
        width: 8rem;
    }
}
    </style>
    <body class="demo-4 loading">
	<main>
		<div class="frame">
		</div>
		<div class="content">
			<div class="content__slide">
				<div class="content__img">
					<div class="content__img-inner" style="background-image: url(img/4.jpeg);"></div>
				</div>
				<div class="content__text-wrap">
					<span class="content__text">
						<span class="content__text-inner content__text-inner--stroke">WELCOME</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner">WELCOME</span>
					</span>
					<span class="content__text content__text--full">
						<span class="content__text-inner content__text-inner--stroke">WELCOME</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner content__text-inner--stroke">WELCOME</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner">WELCOME</span>
					</span>
					<span class="content__text content__text--full">
						<span class="content__text-inner">WELCOME</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner content__text-inner--bottom">WELCOME</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner">WELCOME</span>
					</span>
					<span class="content__text content__text--full">
						<span class="content__text-inner content__text-inner--stroke">WELCOME</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner content__text-inner--stroke content__text-inner--bottom">WELCOME</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner">WELCOME</span>
					</span>
				</div>
			</div>
			<div class="content__slide">
				<div class="content__img">
					<div class="content__img-inner" style="background-image: url(img/5.jpeg);"></div>
				</div>
				<div class="content__text-wrap">
					<span class="content__text">
						<span class="content__text-inner content__text-inner--stroke">TO</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner">TO</span>
					</span>
					<span class="content__text content__text--full">
						<span class="content__text-inner content__text-inner--stroke">TO</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner content__text-inner--stroke">TO</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner">TO</span>
					</span>
					<span class="content__text content__text--full">
						<span class="content__text-inner">TO</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner content__text-inner--bottom">TO</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner">TO</span>
					</span>
					<span class="content__text content__text--full">
						<span class="content__text-inner content__text-inner--stroke">TO</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner content__text-inner--stroke content__text-inner--bottom">TO</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner">TO</span>
					</span>
				</div>
			</div>
			<div class="content__slide">
				<div class="content__img">
					<div class="content__img-inner" style="background-image: url(img/6.jpeg);"></div>
				</div>
				<div class="content__text-wrap">
					<span class="content__text">
						<span class="content__text-inner content__text-inner--stroke">OFFEYICIAL</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner">OFFEYICIAL</span>
					</span>
					<span class="content__text content__text--full">
						<span class="content__text-inner content__text-inner--stroke">OFFEYICIAL</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner content__text-inner--stroke">OFFEYICIAL</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner">OFFEYICIAL</span>
					</span>
					<span class="content__text content__text--full ">
						<span class="content__text-inner">OFFEYICIAL</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner content__text-inner--bottom">OFFEYICIAL</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner">OFFEYICIAL</span>
					</span>
					<span class="content__text content__text--full">
						<span class="content__text-inner content__text-inner--stroke">OFFEYICIAL</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner content__text-inner--stroke content__text-inner--bottom">OFFEYICIAL</span>
					</span>
					<span class="content__text">
						<span class="content__text-inner">OFFEYICIAL</span>
					</span>
				</div>
			</div>
			<nav class="content__nav">
				<button class="content__nav-button content__nav-button--prev">Prev</button>
				<button class="content__nav-button content__nav-button--next">Next</button>
				<a href="user_profile.php">Sign In</a>
			</nav>
		</div>
        <div class="modal" id="modal">
            <div class="modal-container">
                <div id="form" class="form">
                <button href="user_profile.php" type="signin" id="signin" class='signin'>sign in</button>
                </div>

            </div>

        </div>
	</main>
	<script src="js/imagesloaded.pkgd.min.js"></script>
	<script src="js/TweenMax.min.js"></script>
	<script src="js/demo4.js"></script>
    <script>
          $(document).ready(function(){ 
    $('.signin').click(function() {
		window.location.href = "user_profile.php";
        
    })
});
    </script>
</body>
</html>