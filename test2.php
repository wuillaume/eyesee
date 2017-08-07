<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Step by step register form</title>
  
  <style>

  .stages {
  font-size: 0;
  text-align: justify;
}

.stages:after {
  content: '';
  display: inline-block;
  font-size: 0;
  text-align: justify;
  width: 100%;
}

input[type="radio"] {
  display: none;
}

.stages label {
  background: #ffffff;
  border: solid 5px #c0c0c0;
  border-radius: 50%;
  cursor: pointer;
  display: inline-block;
  font-size: 0;
  font-weight: 700;
  height: 50px;
  line-height: 50px;
  position: relative;
  text-align: center;
  vertical-align: top;
  width: 50px;
  z-index: 1;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.stages label:after {
  content: '\2713';
  color: #0cc39f;
  display: inline-block;
  font-size: 16px;
}

#one:checked ~ .stages label[for="one"],
#two:checked ~ .stages label[for="two"],
#three:checked ~ .stages label[for="three"],
#four:checked ~ .stages label[for="four"],
#five:checked ~ .stages label[for="five"],
#six:checked ~ .stages label[for="six"] {
  border-color: #0cc39f;
}

.stages label.active{
  border-color: purple !important;
}

#one:checked ~ .stages label,
#two:checked ~ .stages label[for="one"] ~ label,
#three:checked ~ .stages label[for="two"] ~ label,
#four:checked ~ .stages label[for="three"] ~ label,
#five:checked ~ .stages label[for="four"] ~ label,
#six:checked ~ .stages label[for="five"] ~ label {
  font-size: 1rem;
}

#one:checked ~ .stages label:after,
#two:checked ~ .stages label[for="one"] ~ label:after,
#three:checked ~ .stages label[for="two"] ~ label:after,
#four:checked ~ .stages label[for="three"] ~ label:after,
#five:checked ~ .stages label[for="four"] ~ label:after,
#six:checked ~ .stages label[for="five"] ~ label:after {
  display: none;
}

.progress > span {
  background: #c0c0c0;
  display: inline-block;
  height: 5px;
  transform: translateY(-2.75em);
  transition: 0.3s;
  width: 0;
}

#two:checked ~ .progress span {
  width: calc(100% / 5 * 1);
}

#three:checked ~ .progress span {
  width: calc(100% / 5 * 2);
}

#four:checked ~ .progress span {
  width: calc(100% / 5 * 3);
}

#five:checked ~ .progress span {
  width: calc(100% / 5 * 4);
}

#six:checked ~ .progress span {
  width: calc(100% / 5 * 5);
}

.panels div {
  display: none;
}

#one:checked ~ .panels [data-panel="one"],
#two:checked ~ .panels [data-panel="two"],
#three:checked ~ .panels [data-panel="three"],
#four:checked ~ .panels [data-panel="four"],
#five:checked ~ .panels [data-panel="five"],
#six:checked ~ .panels [data-panel="six"] {
  display: block;
}
/* Custom code for the demo */

html,
button,
input,
select,
textarea {
  font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
}

body {
  background-color: #0cc39f;
  margin: 0;
  padding: 0 2em;
}

a {
  color: #0cc39f;
}

h2,
h4 {
  margin-top: 0;
}

.form {
  background: #ffffff;
  box-shadow: 0 5px 10px rgba(0, 0, 0, .4);
  margin: 4em;
  min-width: 480px;
  padding: 1em;
}

.panels div {
  border-top: solid 1px #c0c0c0;
  margin: 1em 0 0;
  padding: 1em 0 0;
}

input {
  box-sizing: border-box;
  display: block;
  padding: .4em;
  width: 100%;
}

button {
  background-color: #0cc39f;
  border: 0;
  color: #ffffff;
  cursor: pointer;
  font-weight: 700;
  margin: 1em 0 0 0;
  padding: 1em;
}

button:hover {
  opacity: 0.8;
}

  </style>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

  
</head>

<body>
 

 <div class="form">
  <h2>Multi Page Form (Pure CSS)</h2>
  <p>Divide long forms, enable users to flick back and forward.</p>
  <p>Use JS to validate form at the end of the stage and highlight tab(s) that contain(s) error.</p>

  <input id="one" type="radio" name="stage" checked="checked" />
  <input id="two" type="radio" name="stage" />
  <input id="three" type="radio" name="stage" />
  <input id="four" type="radio" name="stage" />
  <input id="five" type="radio" name="stage" />
  <input id="six" type="radio" name="stage" />

  <div class="stages">
    <label for="one">1</label>
    <label for="two">2</label>
    <label for="three">3</label>
    <label for="four">4</label>
    <label for="five">5</label>
    <label for="six">6</label>
  </div>

  <span class="progress"><span></span></span>

  <div class="panels">
    <div data-panel="one">
      <h4>Stage 1</h4>
      <input type="text" placeholder="First Name" />
    </div>
    <div data-panel="two">
      <h4>Stage 2</h4>
      <input type="text" placeholder="Last Name" />
    </div>
    <div data-panel="three">
      <h4>Stage 3</h4>
      <input type="text" placeholder="Address" />
    </div>
    <div data-panel="four">
      <h4>Stage 4</h4>
      <input type="text" placeholder="Email" />
    </div>
    <div data-panel="five">
      <h4>Stage 5</h4>
      <input type="text" placeholder="Phone Number" />
    </div>
    <div data-panel="six">
      <h4>Stage 6</h4>
      <input type="text" placeholder="Comment" />
    </div>
  </div>

  <button>Next</button>

</div>

</body>
</html>
