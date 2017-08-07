$('#upload').on('click', function(e) {
  $('#message').fadeOut();
  e.preventDefault();
  if ($('#file')[0].files.length == 0) {
    alert('Choose a file!');
  } else {
    var file_data = $('#file').prop('files')[0]; //file object details  
    var form_data = new FormData($('#form')[0]);
    form_data.append('file', file_data);
    var unique_identifier = $('#unique_identifier').val();
    $.ajax({
      url: 'upload.php',
      dataType: 'text', // what to expect back from the PHP script, if anything
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      type: 'post',
      success: function(php_script_response) {
        $('#message').html(php_script_response).fadeIn();
        //alert(php_script_response); // display response from the PHP script, if any
      }
    });
  }
});