	// $response="";
	var response = [];
	$(document).ready(function() {
		fillDepartments();
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

	function fillDepartments(){
		$html='<option>Select Department</option>'+
		'<option value="AMTH">Applied Mathematics</option>'+
		'<option value="BIOE">Bioengineering</option>'+
		'<option value="CENG">Civil Engineering</option>'+
		'<option value="COEN">Computer Engineering</option>'+
		'<option value="ELEN">Electrical Engineering</option>'+
		'<option value="ENGR">Engineering</option>'+
		'<option value="MECH">Mechanical Engineering</option>';
		$('#dpmnt').html($html);
	}
	function fillCourses(){
		$('#course').html('<option>Select Course</option>');
		var dpmnt = $('#dpmnt').val();
		$.post('./core/scripts/getCourses.php', {dpmnt: dpmnt},function(r){
			response = JSON.parse(r);
			$.each(response, function (key, value){
				$html='<option value='+key+'>'+dpmnt + " " +key+'</option>'
				$('#course').append($html);
			});
		});
	}
	function fillSection(){
		$('#section').html('<option>Select Section</option>');
		$course=$('#course').val();
		console.log(response);
		for($i = 0; $i < response[$course].length; $i++){
			$html='<option value="'+response[$course][$i]+'">'+response[$course][$i]+'</option>';
			$('#section').append($html);
		}
	}
	function validateId(){
		var idRegex = /\d\d\d\d\d\d\d\d\d\d\d$/;
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
