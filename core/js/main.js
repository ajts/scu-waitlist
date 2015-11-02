	var lines = [];	
	var courses = [];
	$(document).ready(function() {
	    $.ajax({
	        type: "POST",
	        url: "./core/storage/courses/coen.csv",
	        dataType: "text",
	        success: function(data) {processData(data);}
	     });
		$(".submitbutton").click(function(){
			var department = $('#dpmnt option:selected').text();
			var course = $('#course option:selected').text();
			var section = $('#section option:selected').text();
			if(department == "Select Option" || course == "Select Option" || section == "Select Option") {
					alert("Please select all options from dropdown lists");
					return;
			}
			$.post('./core/scripts/getWaitlist.php', {department:department, course:course, section:section},
					function(data) {
							$(".waitlist").html(data);
					}, 'html');
        });
	});
	function processData(allText) {
	    var allTextLines = allText.split(/\r\n|\n/);
	    for (var i=0; i<allTextLines.length; i++) {
	        var data = allTextLines[i].split(',');
	        lines.push(data);
	    }
	}
	function fillCourses(dept, coursesDd){
		switch(dept.value){
			case 'Computer Engineering':
			coursesDd.options.length = 1;
			for(i = 1; i < lines.length; i ++)
			{
				add = true;
				var j = 0;
				while(j < i && add==true){
					if(lines[j][0]==lines[i][0]){
						add=false;
					}
					j++;
				}
				if(add == true){
					addOption(coursesDd, lines[i][0], lines[i][0]);
				}
				
			}
			break;
		}
	}
	function fillSection(coursesDd, sectionDd){
		var course = document.getElementById("course").value;
		sectionDd.options.length=1;
		for(var i = 0; i < lines.length; i++)
		{
			if(lines[i][0]==course){
				addOption(sectionDd, lines[i][1], lines[i][1]);
			}
		}
	}
	function addOption(dd, text, value){
		var x = document.createElement("option");
		x.value = value;
		x.text = text;
		dd.add(x);
	}
	function validateId(){
		var idRegex = /00000\d\d\d\d\d\d$/;
		var id=document.getElementById("id").value;
		if(!idRegex.test(id)){
			$("#id").css('border-color', 'red');
		}
		else{
			$("#id").removeAttr('style');
			return true;
		}
	}
	function validateName(){
		var fname=$('#fname').val();
		var lname=$('#lname').val();
		if(fname!=null && lname!= null){
			if(fname.length>25){
				$("#fname").css('border-color', 'red');
			}
			else if(lname.length>25){
				$("#lname").css('border-color', 'red');
			}
			else return true;
		}
	}
	function validateEmail(){
		var emailRegex = /.*@scu.edu/;
		var email=document.getElementById("email").value;
		if(email!=null){
			if(!emailRegex.test(email)){
				$("#email").css('border-color', 'red');
			}
			else{
				$("#email").removeAttr('style');
				return true;
			}
		}
	}	
	function validateForm(){
		if(!validateName() || !validateEmail() || !validateId() || grecaptcha.getResponse()==""){
			event.preventDefault();
			return false;
		}
	}
