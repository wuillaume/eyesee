function show(id) {
  var allDivs = document.getElementsByClassName('content');
  for (var i = 0; i < allDivs.length; i++) {
    allDivs[i].classList.add('hidden');
  }
  document.getElementById('content' + id).classList.remove('hidden');
}

function show_left(id) {
  var allDivs = document.getElementsByClassName('content_left_menu');
  // for (var i = 0; i < allDivs.length; i++) {
  //   allDivs[i].classList.add('hidden');
  // }
  document.getElementById('content_left_menu' + id).classList.remove('hidden');
}



function play(){
       var audio = document.getElementById("audio");
       audio.play();
                 }