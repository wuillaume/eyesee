    var submit=false;
    var numberField = 1;
    var numberCategory = 1;
    var name = "";

        function addMenuEntry(){
      //  var buttons = document.getElementsBy("field");
  		//	currentButton = buttons[buttons.length - 1],
			//	input = currentButton.previousSibling;
      //  var number = buttons[buttons.length - 1].name;
    
            //var number = document.getElementById("field").name;
            var container = document.getElementById("container");
          	numberField=numberField+1;
          //  for (i=0;i<number;i++){
                container.appendChild(document.createTextNode("Member " + (numberField)));
                var input = document.createElement("input");
                input.type = "text";
                input.id = numberField;
                input.name = "cat_"+numberCategory+"|field_"+numberField;
                container.appendChild(input);
                container.appendChild(document.createElement("br"));
                var inputFail = document.createElement("input");
                inputFail.type = "radio";
                inputFail.name = "cat_"+numberCategory+"|field_"+numberField+"|fail_pass";
                inputFail.value = "0";
                container.appendChild(inputFail);
                container.appendChild(document.createTextNode("Fail"));
                container.appendChild(document.createElement("br"));
                var inputPass = document.createElement("input");
                inputPass.type = "radio";
                inputPass.name = "cat_"+numberCategory+"|field_"+numberField+"|fail_pass";
                inputPass.value = "1";
                 container.appendChild(inputPass);
                 container.appendChild(document.createTextNode("Pass"));
                container.appendChild(document.createElement("br"));

         //  }
        }

         function readyToSubmit(){
            return submit;
         }

         function submitOk(){
            submit=true;
         }