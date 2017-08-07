function show(id) {
  var allDivs = document.getElementsByClassName('content');
  for (var i = 0; i < allDivs.length; i++) {
    allDivs[i].classList.add('hidden');
  }
  document.getElementById('content' + id).classList.remove('hidden');
}



function play(){
       var audio = document.getElementById("audio");
       audio.play();
                 }