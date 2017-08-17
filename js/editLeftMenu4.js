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
                container.appendChild(document.createTextNode("Element " + (numberField)));
                container.appendChild(document.createElement("br"));
                container.appendChild(document.createTextNode("Name (required)"));
                var input = document.createElement("input");
                input.type = "text";
                input.id = numberField;
                //input.name = "name_"+numberField;
                input.name = "menu_left_name";
                container.appendChild(input);
                container.appendChild(document.createElement("br"));
                container.appendChild(document.createTextNode("Link : "));
                var inputLink = document.createElement("input");
                inputLink.type = "text";
                //inputLink.name = "link_"+numberField;
                inputLink.name = "menu_left_link";
                inputLink.value = "";
                container.appendChild(inputLink);
                container.appendChild(document.createElement("br"));
                container.appendChild(document.createTextNode("Long Text"));
                container.appendChild(document.createElement("br"));
                var inputTextarea = document.createElement("textarea");
                
                //inputTextarea.name = "textarea_"+numberField;
                inputTextarea.name = "menu_left_text";
                inputTextarea.value = "";
                 container.appendChild(inputTextarea);
                var inputHiddenNew = document.createElement("input");
                inputHiddenNew.type = "hidden";
                inputHiddenNew.name = "new";
                inputHiddenNew.value = "true";
                container.appendChild(inputHiddenNew);
                container.appendChild(document.createElement("br"));

         //  }
        }

         function readyToSubmit(){
            return submit;
         }

         function submitOk(){
            submit=true;
         }

         function hasClass(element, cls) {
            return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
        }

         function showButton(id) {
          var element = document.getElementById('existingEntry' + id);
          if(hasClass(element,'hidden')){
            document.getElementById('existingEntry' + id).classList.remove('hidden');
          }
          else{
            document.getElementById('existingEntry' + id).classList.add('hidden');
          }
        }
