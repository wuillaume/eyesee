function __log(e, data) {
    log.innerHTML += "\n" + e + " " + (data || '');
  }

  var audio_context;
  var recorder;

  function startUserMedia(stream) {
    var input = audio_context.createMediaStreamSource(stream);
    __log('Media stream created.');

    // Uncomment if you want the audio to feedback directly
    //input.connect(audio_context.destination);
    //__log('Input connected to audio context destination.');
    
    recorder = new Recorder(input);
    __log('Recorder initialised.');
  }

  function startRecording(button) {
    recorder && recorder.record();
    button.disabled = true;
    button.nextElementSibling.disabled = false;
    __log('Recording...');
  }

  function stopRecording(button) {
    recorder && recorder.stop();
    button.disabled = true;
    button.previousElementSibling.disabled = false;
    __log('Stopped recording.');
    
    // create WAV download link using audio data blob
    createDownloadLink();
    
    recorder.clear();
  }

  function createDownloadLink() {
    recorder && recorder.exportWAV(function(blob) {
      var url = URL.createObjectURL(blob);
      var li = document.createElement('li');
      var au = document.createElement('audio');
      var hf = document.createElement('a');
      var bt = document.createElement('button');
      var bt_select = document.createElement('button');
      bt_select.disabled = true;
      au.controls = true;
      au.src = url;
      hf.href = url;
      hf.download = new Date().toISOString() + '.wav';
      hf.innerHTML = hf.download;
      li.appendChild(au);
      li.appendChild(hf);
      recordingslist.appendChild(li);
      bt.textContent = "Save on the server";

     
    var wavName = encodeURIComponent('audio_recording_' + new Date().getTime() + '.wav');

     bt.onclick =  function(){ uploadAudio(this,bt_select,blob,wavName); }
  

     //bt.disabled = true;
    // bt.previousElementSibling.disabled = false;


      
      li.appendChild(bt);


      bt_select.textContent = "Select this Recording for the step";
            bt_select.onclick =  function(){ selectRecording(this,wavName); }
        li.appendChild(bt_select);  
    
    });
  }

    function uploadAudio(button,bt_select,wavData,wavName){
      button.disabled = true;
      bt_select.disabled = false;
      button.previousElementSibling.disabled = false;
      //var urlBis = 'Recordmp3js-master/upload.php?wavname=' + wavname;
    var reader = new FileReader();
    reader.onload = function(event){
      var fd = new FormData();
      //var wavName = encodeURIComponent('audio_recording_' + new Date().getTime() + '.wav');
      console.log("wavname = " + wavName);
      fd.append('fname', wavName);
      fd.append('data', event.target.result);
      $.ajax({
        type: 'POST',
        url: "Recordmp3js-master/upload.php?wavname=" + wavName,
        data: fd,
        processData: false,
        contentType: false
      }).done(function(data) {
        //console.log(data);
        log.innerHTML += "\n" + data;
      });
    };
    reader.readAsDataURL(wavData);
    __log('Saved on server.');
    return wavName;
  }
    function deleteCookie(){
      document.cookie = ';';

    }

      function selectRecording(button,url){
        button.disabled = true;
        button.previousElementSibling.disabled = false;

         document.cookie = 'url='+url+';';
         __log('Recording selected.');
/*
    if (window.XMLHttpRequest){
        xmlhttp=new XMLHttpRequest();
      }

    else{
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }

    var PageToSendTo = "map_costumized2.php?";
    var VariablePlaceholder = "recordingURL=";
    var UrlToSend = PageToSendTo + VariablePlaceholder + url;

    xmlhttp.open("GET", UrlToSend, false);
    xmlhttp.send();*/
    }


/*
    function selectRecording2(button,url) {
      button.disabled = true;
      button.previousElementSibling.disabled = false;
      var changeRecording = url;
      $.ajax({
          type: "POST",
          data: {
              changeRecording: url
          },
          url: "map_costumized2.php",
          dataType: "json",
          async: true,
          beforeSend: function(){
              $(".ajaxTest").text("Trying to upgrade...");
          },
          success: function(data) {
              $(".ajaxTest").text(data.a);
              if (data.b == "true") {
                  location.reload();
              }
          }
      }); 
  }
  */
/*
*/
/*
  function saveOnServer(blob){
    recorder.stop();
  recorder.exportWAV(function(audio) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "savewav.php", true);
    xhr.setRequestHeader("content-type", "audio/wav");
    xhr.onload = function(e) {
        // Handle the response.
    }
    xhr.send(audio);
});
  }
  */
function saveOnServer(blob){
  var file2 = new FileReader();
  file2.onloadend = function(e){         
        $.ajax({
          url: "saveWav.php",
          type: "POST",
          data: file2.result,
          processData: false,
          contentType : "text/plain"
        });
      } ;
  file2.readAsDataURL( blob );
}

  window.onload = function init() {
    try {
      // webkit shim
      window.AudioContext = window.AudioContext || window.webkitAudioContext;
      navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia;
      window.URL = window.URL || window.webkitURL;
      
      audio_context = new AudioContext;
      __log('Audio context set up.');
      __log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
    } catch (e) {
      alert('No web audio support in this browser!');
    }
    
    navigator.getUserMedia({audio: true}, startUserMedia, function(e) {
      __log('No live audio input: ' + e);
    });
  };