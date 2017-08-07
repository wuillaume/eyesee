<?php
$cookie_name = 'url';
if(!isset($_COOKIE[$cookie_name])) {
    echo "Cookie named '" . $cookie_name . "' is not set!";

} else {
    echo "Cookie '" . $cookie_name . "' is set!<br>";
    echo "Value is: " . $_COOKIE[$cookie_name];
}
?>


<?php

/*Connect to the DB */
$host = "localhost";
$username = "root";
$password = "";
$database = "eyesee_map";

$dsn = "mysql:host=$host;dbname=$database";

TRY {
$conn = new PDO( $dsn, $username, $password );
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/*echo "Connected successfully";*/

if (isset($_POST['changeRecording'])) {

	$changeRecording = $_POST['changeRecording'];
	echo $changeRecording;
}
	if (isset($_POST['submit'])) {
		$form_id = $_POST['form'];
		$step_id = $_POST['step'];
		$form_name = $_POST['form_name'];
	    $title = $_POST['title'];
	    $text = $_POST['text'];
	    $recording = $_POST['recording'];
	    $step_order = $_POST['step_order'];

	    if(!isset($_COOKIE[$cookie_name])) {
		    echo "Cookie named '" . $cookie_name . "' is not set!";

		} else {
		    echo "Cookie '" . $cookie_name . "' is set!<br>";
		    echo "Value is: " . $_COOKIE[$cookie_name];
		    $changeRecording = $_COOKIE[$cookie_name];
		   	echo "RECORDING IS ";
			echo $changeRecording;
			echo "END";
		}

	    


	    if ($form_id !=0) {
	        //update mode, modifying existing form
	       
	       if ($step_id !=0) {
	       	    //update mode, modifying existing step


	        $sql = "UPDATE step SET "
	            . "title=".$conn->quote($title)
	            . ",text=".$conn->quote($text)
	            . ",recording=".$conn->quote($changeRecording)
	            . " WHERE step_id = ".$conn->quote($step_id);
	            echo $sql;
	        $userdata = $conn->query($sql);

	        $sql = "UPDATE form SET "
	            . "step_order=".$conn->quote($step_order)
	            . " WHERE step_id = ".$conn->quote($step_id);
	            echo $sql;
	        $userdata = $conn->query($sql);
		    } 
		    else {
		        // insert mode, there is a form id, but it is to create a new step
		        $sql = "INSERT INTO step("
		            . "title, text, recording"
		            . " ) VALUES ("
		            . $conn->quote($title).","
		            . $conn->quote($text).","
		            . $conn->quote($changeRecording).")";
		        $userdata = $conn->query($sql);

		        $stepIdData = $conn->query("SELECT LAST_INSERT_ID();");
		       	$step_idArray = $stepIdData->fetch();
		        $step_id = $step_idArray[0];
		        echo $step_id;

		        /* Link form step */
		        $sql = "INSERT INTO form("
		           . "form_id,step_id,step_order"
		            . " ) VALUES ("
		            . $conn->quote($form_id).","
		            . $conn->quote($step_id).","
		            . $conn->quote($step_order).")";
		        $userdata = $conn->query($sql);
		    }
		} 
		else{
		    	 // insert mode, new form, new step

		    	$sql = "INSERT INTO step("
		            . "title, text, recording"
		            . " ) VALUES ("
		            . $conn->quote($title).","
		            . $conn->quote($text).","
		            . $conn->quote($changeRecording).")";
		        $userdata = $conn->query($sql);

				$stepIdData = $conn->query("SELECT LAST_INSERT_ID();");
		       	$step_idArray = $stepIdData->fetch();
		        $step_id = $step_idArray[0];
		        echo $step_id;
		        /* NEED TO CREATE THE FORM WITH FORM NAME */
		       


		        $sql = "INSERT INTO form_id("
		           . "form_name"
		            . " ) VALUES ("
		            . $conn->quote($form_name).")";
		        $userdata = $conn->query($sql);
				echo $form_name;
				
				$formIdData = $conn->query("SELECT LAST_INSERT_ID();");
		       	$form_idArray = $formIdData->fetch();
		        $form_id = $form_idArray[0];
		        echo $form_id;

		       /* Link form step */
		        $sql = "INSERT INTO form("
		           . "form_id,step_id,step_order"
		            . " ) VALUES ("
		            . $conn->quote($form_id).","
		            . $conn->quote($step_id).","
		            . $conn->quote($step_order).")";
		        $userdata = $conn->query($sql);
		}
	} 
	else {
	}
   

} catch (PDOException $e) {
    exit("Connection failed: " . $e->getMessage());
}
?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>The HTML5 Herald</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="Wuil" content="SitePoint">

<style>
	.cascade {
    display: none;
}

</style>

<style>
section {
    height: 0;
    display: none;
    overflow: hidden;
    -o-transition: all 2s linear;
    -webkit-transition: all 2s linear;
    -ms-transition: all 2s linear;
    -moz-transition: all 2s linear;
    transition: all 2s linear;
}
section:target {
    display: block;
    height: 20em;
    -o-transition: all 2s linear;
    -webkit-transition: all 2s linear;
    -ms-transition: all 2s linear;
    -moz-transition: all 2s linear;
    transition: all 2s linear;
}
</style>


 <style type='text/css'>
    ul { list-style: none; }
    #recordingslist audio { display: block; margin-bottom: 10px; }
  </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>


<script>
	$(document).ready(function(){
	    var $cat = $('select[name=form]'),
	        $items = $('select[name=step]');

	    $cat.change(function(){
	        var $this = $(this).find(':selected'),
	            rel = $this.attr('rel'),
	            $set = $items.find('option.' + rel);
	        
	        if ($set.size() < 0) {
	            $items.hide();
	            return;
	        }
	        
	        $items.show().find('option').hide();
	        
	        $set.show().first().prop('selected', true);
	    });
	});
</script>



   <!--
SCRIPTs needed for the voice recording plugin
   -->

<script>
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
      bt.textContent = "Send post";

     
    var wavName = encodeURIComponent('audio_recording_' + new Date().getTime() + '.wav');

     bt.onclick =  function(){ uploadAudio(this,bt_select,blob,wavName); }
 	

     //bt.disabled = true;
    // bt.previousElementSibling.disabled = false;
    __log('Saved on server.');

      
      li.appendChild(bt);


      bt_select.textContent = "Select Recording";
      			bt_select.onclick =  function(){ selectRecording(this,wavName); }
				li.appendChild(bt_select);	
    
    });
  }

  	function uploadAudio(button,bt_select,wavData,wavName){
  		button.disabled = true;
  		bt_select.disabled = false;
    	button.previousElementSibling.disabled = false;
		var reader = new FileReader();
		reader.onload = function(event){
			var fd = new FormData();
			//var wavName = encodeURIComponent('audio_recording_' + new Date().getTime() + '.wav');
			console.log("wavname = " + wavName);
			fd.append('fname', wavName);
			fd.append('data', event.target.result);
			$.ajax({
				type: 'POST',
				url: 'Recordmp3js-master/upload.php',
				data: fd,
				processData: false,
				contentType: false
			}).done(function(data) {
				//console.log(data);
				log.innerHTML += "\n" + data;
			});
		};
		reader.readAsDataURL(wavData);
		return wavName;
	}

	    function selectRecording(button,url){
	    	button.disabled = true;
    		button.previousElementSibling.disabled = false;

   		   document.cookie = 'url='+url+';';
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
  </script>

  <script src="voice/dist/recorder.js"></script>

   <script src="voice/upload.js"></script>


   <!-- SCRIPT HIDE SHOW RECORDING
   -->


</head>

<body>

<?php
$resultquery = $conn->query('SELECT distinct(form_id) FROM form');
?>
Form number to modify : 
<select name="form">
    <option value="" disabled="disabled" selected="selected">Please select a form to modify</option>
    <option value="0" rel="newform">New Form</option>
<?php 
/* We get each form one by one */
while ($list_form = $resultquery->fetch())
{
	?>

    <option value="<?php echo $list_form['form_id']; ?>" rel="<?php echo $list_form['form_id']; ?>"><?php echo $list_form['form_id']; ?></option>
    <?php 
}
	?>
</select>

<br>
Step number to modify :

<?php
$resultquery2 = $conn->query('SELECT * FROM form');
?>
<select name="step" >
    <option value="" disabled="disabled" selected="selected">Please select a step to modify</option>
    <option value="0" class="newform">New step</option>


<?php 
$current_form_id = null;
/* We get each form one by one */
while ($list_form2 = $resultquery2->fetch())
{
	?>
	<?php 
	if ($current_form_id == $list_form2['form_id']){}
	else{
		?>
	<option value="0" class="<?php echo $list_form2['form_id']; ?>">New step</option>
	<?php 
	$current_form_id = $list_form2['form_id'];
	}
	?>
	
    <option value="<?php echo $list_form2['step_id']; ?>" class="<?php echo $list_form2['form_id']; ?>"><?php echo $list_form2['step_id']; ?></option>
    <?php 
}
	?>
</select>




<table border="1" cellpadding="10">

    <td>
        <h1> Add a step </h1>
        <form action="map_costumized2.php" method = "post">

			        <?php
			$resultquery = $conn->query('SELECT distinct(form_id) FROM form');
			?>
			Form number to modify : 
			<select name="form">
			    <option value="" disabled="disabled" selected="selected">Please select a form to modify</option>
			    <option value="0" rel="newform">New Form</option>
			<?php 
			/* We get each form one by one */
			while ($list_form = $resultquery->fetch())
			{
				?>

			    <option value="<?php echo $list_form['form_id']; ?>" rel="<?php echo $list_form['form_id']; ?>"><?php echo $list_form['form_id']; ?></option>
			    <?php 
			}
				?>
			</select>

			<br>
			Step number to modify :

			<?php
			$resultquery2 = $conn->query('SELECT * FROM form ORDER BY form_id');
			?>
			<select name="step" class="cascade">
			    <option value="" disabled="disabled" selected="selected">Please select a step to modify</option>
			    <option value="0" class="newform">New step</option>


			<?php 
			$current_form_id = null;
			/* We get each form one by one */
			while ($list_form2 = $resultquery2->fetch())
			{	
				?>
				<?php 
				if ($current_form_id == $list_form2['form_id']){}
				else{
					?>
				<option value="0" class="<?php echo $list_form2['form_id']; ?>">New step</option>
				<?php 
				$current_form_id = $list_form2['form_id'];
				}
				?>
				
			    <option value="<?php echo $list_form2['step_id']; ?>" class="<?php echo $list_form2['form_id']; ?>"><?php echo $list_form2['step_id']; ?></option>
			    <?php 
			}
				?>
			</select>
 <br />

 Form name: <br /> <input type="text" name="form_name" value="" /><br />
            <br />

            Step number: <br /> <input type="text" name="step_order" value="" /><br />
            <br />
            Step title: <br /> <input type="text" name="title" value="" /><br />
            <br />

            Step Text: <br /> <input type="text" name="text" value="" /> <br />
            <br />

            
		  
		    Recording address: <br /> <input type="text" name="recording" value="" /> <br />
		    <button href="#two">Change?</button>
			 <a href="#changeRecord">Change?1</a>


			        <section id="changeRecord">
			            <!-- THIS SECTION IS FOR RECORDING-->

			<h1>Make a recording
			</h1>

			  <p>Make sure you are using a recent version of Google Chrome.</p>
			  <p>Also before you enable microphone input either plug in headphones or turn the volume down if you want to avoid ear splitting feedback!</p>

			  <button onclick="startRecording(this);">record</button>
			  <button onclick="stopRecording(this);" disabled>stop</button>
			  
			  <h2>Recordings</h2>
			  <ul id="recordingslist"></ul>
			  
			  <h2>Log</h2>
			  <pre id="log"></pre>

		   <!-- THIS SECTION IS FOR RECORDING-->	
			        </section>


		
		
		    
            <br />
            <input type="submit" name="submit"/>
        </form>


    </td>
</table>

 

</body>
</html>