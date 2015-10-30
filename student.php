<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	</head>
	<body>
		<div class="header" id="header">
			<h1>SCU Waitlist</h1>
			<p>Please fill out the form below to submit a request to be added to the waitlist.</p>
		</div>
		<div class="container" id="container">
			<form method="post" action="core/scripts/submitRequest.php" class="container">
				<div class="left">
				<!--
					<p class="leftItem"><label for="year">Select Year:</lable>
						<select class="leftItem" id="year" name="year">
							<option></option>
						</select>
					</p>
					<p class="leftItme"><label for="quarter">Select Quarter:</label>
						<select class="leftItem" id="quarter" name="quarter">
							<option>Fall</option>
							<option>Winter</option>
							<option>Spring</option>
							<option>Summer</option>
						</select>
					</p>
				-->
					<p class="leftItem"><label for="selectDept">Select Department:</label>
						<select class="leftItem" id="dpmnt" name="dpmnt" required onchange="fillCourses(this, document.getElementById('course')) & fillC()">
							<option>Select Department</option>
							<option>Computer Engineering</option>
						</select>
					</p>
					<p class="leftItem">
						<label for="selectCourse">Select Course:</label>
						<select class="leftItem" id="course" name="course" required onclick="fillSection(this, document.getElementById('section'))">
							<option>Select Course</option>
						</select>
					</p>
					<p class="leftItem">
						<label for="sectionNumber">Section Number:</label>
						<select class="leftItem" id="section" name="section" class="section" required>
							<option>Selection Section</option>
						</select>
					</p>
				</div>
				<div class="right">
					<div class="info">
						<div>
							<label for="fname">First Name:</label>
							<input type="text" id="fname" name="fname" required>
						</div>
						<div>
							<label for="lname">Last Name:</label>
							<input type="text" id="lname" name="lname" required>
						</div>
						<div>
							<label for="id">Student ID:</label>
							<input type="text" id="id" name="id" required onchange="validateId()" placeholder="Ex. 0000012345">
						</div>
						<div>
							<label for="email">SCU email:</label>
							<input type="email" id="email" name="email" required onchange="validateEmail()">
						</div>
					</div>
					<div class="below">
						<label for="reason">Please explain why you need this class</label><br>
						<textarea rows="3" id="reason" name="reason" required></textarea>
						<div class="text-center">
							<button id="submit" class="btn btn-default" type="Submit">Submit</button>
						</div>
					</div>

				</div>
			</form>
		</div>
	</body>
<html>
<script type="text/javascript">
	
	var lines = [];	
	var courses = [];
	$(document).ready(function() {
	    $.ajax({
	        type: "GET",
	        url: "./core/storage/courses/coen.csv",
	        dataType: "text",
	        success: function(data) {processData(data);}
	     });
	});
	function processData(allText) {
	    var allTextLines = allText.split(/\r\n|\n/);
	    for (var i=0; i<allTextLines.length; i++) {
	        var data = allTextLines[i].split(',');
	        lines.push(data);
	    }			    // alert(lines);
	}
	function fillCourses(dept, coursesDd){
		switch(dept.value){
			case 'Computer Engineering':
			coursesDd.options.length = 0;
			for(i = 1; i < lines.length; i ++)
			{
				if(lines[i][0]!=(lines[i-1][0])){
					addOption(coursesDd, lines[i][0], lines[i][0]);
				}
			}
			break;
		}
	}
	function fillSection(coursesDd, sectionDd){
		var course = document.getElementById("course").value;
		sectionDd.options.length=0;
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

	var list = [];
	
	function course(title, section){
		this.title = title;
		this.section = [];
		for(var i = 0; i < section.length; i++){
			this.section.push(section[i]);
		}
	}
	function fillC(){
		for(i = 0; i < lines.length; i++){
			var x = new course(lines[i][0], lines[i][1]);
			list.push(x);
			console.log(list[i].title);
		}
	}

</script>