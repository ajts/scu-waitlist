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
                        <p>Please select department, course, and section to view a waitlist.</p>
                </div>
                <div class="container" id="container">
                        <div class="form container">
                                <div class="left">
                                        <p class="leftItem"><label for="selectDept">Select Department:</label>
                                                <select class="leftItem" id="dpmnt" name="dpmnt" required onclick="fillCourses(this, document.getElementById('course'))">
                                                        <option>Select Option</option>
                                                        <option>Computer Engineering</option>
                                                </select>
                                        </p>
                                        <p class="leftItem">
                                                <label for="selectCourse">Select Course:</label>
                                                <select class="leftItem" id="course" name="course" required onclick="fillSection(this, document.getElementById('section'))">
                                                        <option>Select Option</option>
                                                </select>
                                        </p>
                                        <p class="leftItem">
                                                <label for="sectionNumber">Section Number:</label>
                                                <select class="leftItem" id="section" class="section" required>
                                                        <option>Select Option</option>
                                                </select>
                                        </p>
                                        <p class="leftItem">
                                                <button class="submitbutton">Enter</button>
                                        </p>
                                </div>
                                <div class="right">
                                        <div class="waitlist"></div>

                                </div>
                        </div>
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
				add = true;
				var j = 0;
				while(j < i && add==true){
					if(lines[j][0]==lines[i][0])
						add=false;
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
        $(".submitbutton").click(function(){
                var department = $('#dpmnt option:selected').text();
                var course = $('#course option:selected').text();
                var section = $('#section option:selected').text();
                if(department == "" || course == "")
                        return;
                $.post('./core/scripts/getWaitlist.php', {department:department, course:course, section:section},
                        function(data) {
                                $(".waitlist").html(data);
                        }, 'html');
        });

</script>
       
