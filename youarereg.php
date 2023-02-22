<!DOCTYPE html>
<html>
<link rel="stylesheet" href="css/bootstrap.min.css">
<style>
    html, body {
  width: 100%;
  height: 100%;
}

body {
  background-color: #140032;
  overflow: hidden;
  margin: 0;
}
body * {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  border-radius: 50%;
}

.galaxy:nth-child(1) {
  transform: translateX(-120px) scale(-1, 1);
}

.galaxy:nth-child(2) {
  transform: translateX(120px) scale(1, -1);
}

.stars {
  width: 200px;
  height: 200px;
}
.stars .circle {
  animation: 5s galaxy ease-in-out infinite reverse;
}
.stars .dot {
  width: 10px;
  height: 10px;
  border: 5px dotted #fff;
}
.stars .dot:nth-child(0) {
  transform: rotate(0deg) translate(120px) scale(1);
  border-color: fuchsia;
}
.stars .dot:nth-child(1) {
  transform: rotate(12deg) translate(120px) scale(0.9666666667);
  border-color: #f500ff;
}
.stars .dot:nth-child(2) {
  transform: rotate(24deg) translate(120px) scale(0.9333333333);
  border-color: #eb00ff;
}
.stars .dot:nth-child(3) {
  transform: rotate(36deg) translate(120px) scale(0.9);
  border-color: #e100ff;
}
.stars .dot:nth-child(4) {
  transform: rotate(48deg) translate(120px) scale(0.8666666667);
  border-color: #d700ff;
}
.stars .dot:nth-child(5) {
  transform: rotate(60deg) translate(120px) scale(0.8333333333);
  border-color: #cd00ff;
}
.stars .dot:nth-child(6) {
  transform: rotate(72deg) translate(120px) scale(0.8);
  border-color: #c400ff;
}
.stars .dot:nth-child(7) {
  transform: rotate(84deg) translate(120px) scale(0.7666666667);
  border-color: #ba00ff;
}
.stars .dot:nth-child(8) {
  transform: rotate(96deg) translate(120px) scale(0.7333333333);
  border-color: #b000ff;
}
.stars .dot:nth-child(9) {
  transform: rotate(108deg) translate(120px) scale(0.7);
  border-color: #a600ff;
}
.stars .dot:nth-child(10) {
  transform: rotate(120deg) translate(120px) scale(0.6666666667);
  border-color: #9c00ff;
}
.stars .dot:nth-child(11) {
  transform: rotate(132deg) translate(120px) scale(0.6333333333);
  border-color: #9200ff;
}
.stars .dot:nth-child(12) {
  transform: rotate(144deg) translate(120px) scale(0.6);
  border-color: #8800ff;
}
.stars .dot:nth-child(13) {
  transform: rotate(156deg) translate(120px) scale(0.5666666667);
  border-color: #7e00ff;
}
.stars .dot:nth-child(14) {
  transform: rotate(168deg) translate(120px) scale(0.5333333333);
  border-color: #7400ff;
}
.stars .dot:nth-child(15) {
  transform: rotate(180deg) translate(120px) scale(0.5);
  border-color: #6a00ff;
}
.stars .dot:nth-child(16) {
  transform: rotate(192deg) translate(120px) scale(0.4666666667);
  border-color: #6000ff;
}
.stars .dot:nth-child(17) {
  transform: rotate(204deg) translate(120px) scale(0.4333333333);
  border-color: #5600ff;
}
.stars .dot:nth-child(18) {
  transform: rotate(216deg) translate(120px) scale(0.4);
  border-color: #4d00ff;
}
.stars .dot:nth-child(19) {
  transform: rotate(228deg) translate(120px) scale(0.3666666667);
  border-color: #4300ff;
}
.stars .dot:nth-child(20) {
  transform: rotate(240deg) translate(120px) scale(0.3333333333);
  border-color: #3900ff;
}
.stars .dot:nth-child(21) {
  transform: rotate(252deg) translate(120px) scale(0.3);
  border-color: #2f00ff;
}
.stars .dot:nth-child(22) {
  transform: rotate(264deg) translate(120px) scale(0.2666666667);
  border-color: #2500ff;
}
.stars .dot:nth-child(23) {
  transform: rotate(276deg) translate(120px) scale(0.2333333333);
  border-color: #1b00ff;
}
.stars .dot:nth-child(24) {
  transform: rotate(288deg) translate(120px) scale(0.2);
  border-color: #1100ff;
}
.stars .dot:nth-child(25) {
  transform: rotate(300deg) translate(120px) scale(0.1666666667);
  border-color: #0700ff;
}
.stars .dot:nth-child(26) {
  transform: rotate(312deg) translate(120px) scale(0.1333333333);
  border-color: #0003ff;
}
.stars .dot:nth-child(27) {
  transform: rotate(324deg) translate(120px) scale(0.1);
  border-color: #000dff;
}
.stars .dot:nth-child(28) {
  transform: rotate(336deg) translate(120px) scale(0.0666666667);
  border-color: #0017ff;
}
.stars .dot:nth-child(29) {
  transform: rotate(348deg) translate(120px) scale(0.0333333333);
  border-color: #0021ff;
}
.stars .dot:nth-child(30) {
  transform: rotate(360deg) translate(120px) scale(0);
  border-color: #002bff;
}
.stars .dot:nth-child(31) {
  transform: rotate(372deg) translate(120px) scale(-0.0333333333);
  border-color: #0034ff;
}
.stars .dot:nth-child(32) {
  transform: rotate(384deg) translate(120px) scale(-0.0666666667);
  border-color: #003eff;
}
.stars .dot:nth-child(33) {
  transform: rotate(396deg) translate(120px) scale(-0.1);
  border-color: #0048ff;
}
.stars .dot:nth-child(34) {
  transform: rotate(408deg) translate(120px) scale(-0.1333333333);
  border-color: #0052ff;
}
.stars .dot:nth-child(35) {
  transform: rotate(420deg) translate(120px) scale(-0.1666666667);
  border-color: #005cff;
}
.stars:nth-child(0) {
  transform: rotate(0deg) translate(80px);
}
.stars:nth-child(0) .circle {
  -webkit-animation-delay: 0s;
          animation-delay: 0s;
}
.stars:nth-child(1) {
  transform: rotate(18deg) translate(80px);
}
.stars:nth-child(1) .circle {
  -webkit-animation-delay: -0.25s;
          animation-delay: -0.25s;
}
.stars:nth-child(2) {
  transform: rotate(36deg) translate(80px);
}
.stars:nth-child(2) .circle {
  -webkit-animation-delay: -0.5s;
          animation-delay: -0.5s;
}
.stars:nth-child(3) {
  transform: rotate(54deg) translate(80px);
}
.stars:nth-child(3) .circle {
  -webkit-animation-delay: -0.75s;
          animation-delay: -0.75s;
}
.stars:nth-child(4) {
  transform: rotate(72deg) translate(80px);
}
.stars:nth-child(4) .circle {
  -webkit-animation-delay: -1s;
          animation-delay: -1s;
}
.stars:nth-child(5) {
  transform: rotate(90deg) translate(80px);
}
.stars:nth-child(5) .circle {
  -webkit-animation-delay: -1.25s;
          animation-delay: -1.25s;
}
.stars:nth-child(6) {
  transform: rotate(108deg) translate(80px);
}
.stars:nth-child(6) .circle {
  -webkit-animation-delay: -1.5s;
          animation-delay: -1.5s;
}
.stars:nth-child(7) {
  transform: rotate(126deg) translate(80px);
}
.stars:nth-child(7) .circle {
  -webkit-animation-delay: -1.75s;
          animation-delay: -1.75s;
}
.stars:nth-child(8) {
  transform: rotate(144deg) translate(80px);
}
.stars:nth-child(8) .circle {
  -webkit-animation-delay: -2s;
          animation-delay: -2s;
}
.stars:nth-child(9) {
  transform: rotate(162deg) translate(80px);
}
.stars:nth-child(9) .circle {
  -webkit-animation-delay: -2.25s;
          animation-delay: -2.25s;
}
.stars:nth-child(10) {
  transform: rotate(180deg) translate(80px);
}
.stars:nth-child(10) .circle {
  -webkit-animation-delay: -2.5s;
          animation-delay: -2.5s;
}
.stars:nth-child(11) {
  transform: rotate(198deg) translate(80px);
}
.stars:nth-child(11) .circle {
  -webkit-animation-delay: -2.75s;
          animation-delay: -2.75s;
}
.stars:nth-child(12) {
  transform: rotate(216deg) translate(80px);
}
.stars:nth-child(12) .circle {
  -webkit-animation-delay: -3s;
          animation-delay: -3s;
}
.stars:nth-child(13) {
  transform: rotate(234deg) translate(80px);
}
.stars:nth-child(13) .circle {
  -webkit-animation-delay: -3.25s;
          animation-delay: -3.25s;
}
.stars:nth-child(14) {
  transform: rotate(252deg) translate(80px);
}
.stars:nth-child(14) .circle {
  -webkit-animation-delay: -3.5s;
          animation-delay: -3.5s;
}
.stars:nth-child(15) {
  transform: rotate(270deg) translate(80px);
}
.stars:nth-child(15) .circle {
  -webkit-animation-delay: -3.75s;
          animation-delay: -3.75s;
}
.stars:nth-child(16) {
  transform: rotate(288deg) translate(80px);
}
.stars:nth-child(16) .circle {
  -webkit-animation-delay: -4s;
          animation-delay: -4s;
}
.stars:nth-child(17) {
  transform: rotate(306deg) translate(80px);
}
.stars:nth-child(17) .circle {
  -webkit-animation-delay: -4.25s;
          animation-delay: -4.25s;
}
.stars:nth-child(18) {
  transform: rotate(324deg) translate(80px);
}
.stars:nth-child(18) .circle {
  -webkit-animation-delay: -4.5s;
          animation-delay: -4.5s;
}
.stars:nth-child(19) {
  transform: rotate(342deg) translate(80px);
}
.stars:nth-child(19) .circle {
  -webkit-animation-delay: -4.75s;
          animation-delay: -4.75s;
}
.stars:nth-child(20) {
  transform: rotate(360deg) translate(80px);
}
.stars:nth-child(20) .circle {
  -webkit-animation-delay: -5s;
          animation-delay: -5s;
}

@-webkit-keyframes galaxy {
  100% {
    transform: rotate(360deg);
  }
}

@keyframes galaxy {
  100% {
    transform: rotate(360deg);
  }
}
</style>
<div class='galaxy'>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
</div>
<div class='galaxy'>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
  <div class='stars'>
    <div class='circle'>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
      <div class='dot'></div>
    </div>
  </div>
</div>



</html>