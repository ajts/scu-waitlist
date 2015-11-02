	var lines = [];	
	var courses = [];
	$(document).ready(function() {
		// $("#submit").attr('disabled', 'disabled');
	    $.ajax({
	        type: "GET",
	        url: "./core/storage/courses/coen.csv",
	        dataType: "text",
	        success: function(data) {processData(data);}
	     });
		 $.validator.addMethod("validateEmail", validateEmail());
		 $.validator.addMethod("validateId", validateId());
		 $.validator.addMethod("validateName", validateName());
		$(".submitbutton").click(function(){
			var department = $('#dpmnt option:selected').text();
			var course = $('#course option:selected').text();
			var section = $('#section option:selected').text();
			if(department == "Select Option" || course == "Select Option" || section == "Select Option")
					return;
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
			$("#submit").attr('disabled', 'disabled');
		}
		else{
			$("#id").removeAttr('style');
			return true;
		}
	}
	function validateName(){
		var fname=$('#fname');
		var lname=$('#lname');
		if(fname.length>25){
			$("#fname").css('border-color', 'red');
			$("#submit").attr('disabled', 'disabled');
			return false;
		}
		else if(lname.length>25){
			$("#lname").css('border-color', 'red');
			$("#submit").attr('disabled', 'disabled');
			return false;
		}
		else{
			$('#submit').attr('disabled', false);
			return true;
		}
	}
	function validateEmail(){
		var emailRegex = /.*@scu.edu/;
		var email=document.getElementById("email").value;
		if(!emailRegex.test(email)){
			$("#email").css('border-color', 'red');
			$("#submit").attr('disabled', 'disabled');
			return false;
		}
		else{
			$("#email").removeAttr('style');
			$('#submit').attr('disabled', false);
			return true;		
		}
	}
	
	function validate(){
		$("#form").validate();
		var vId=validateId();
		var vEmail=validateEmail();
		var vName=validateName();
		if(vId == false || vEmail==false || vName==false){
			$(":button").preventDefault();
		}
	}