	var lines = [];	
	var courses = [];
	$(document).ready(function() {
	    $.ajax({
	        type: "GET",
	        url: "./core/storage/courses/coen.csv",
	        dataType: "text",
	        success: function(data) {processData(data);}
	     });
		 
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
		console.log("clicked");
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
		var idRegex = /00000\d\d\d\d\d$/;
		var id=document.getElementById("id").value;
		if(!idRegex.test(id)){
			document.getElementById("submit").disabled=true;
			alert('Please enter your Student ID according to the format: 0000012345');
		}
		else if(idRegex.test(id)){
			document.getElementById("submit").disabled=false;
		}
	}
	function validateEmail(){
		var emailRegex = /.*@scu.edu/;
		var email=document.getElementById("email").value;
		if(!emailRegex.test(email)){
			document.getElementById("submit").disabled=true;
			alert('Please enter your Student email according to the format: aperson@scu.edu');
		}
		else if(emailRegex.test(email)){
			document.getElementById("submit").disabled=false;
		}
	}
