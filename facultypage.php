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
                        <form method="post" action="core/scripts/submitRequest.php" class="container">
                                <div class="left">
                                        <p class="leftItem"><label for="selectDept">Select Department:</label>
                                                <select class="leftItem" id="dpmnt" name="dpmnt" required onchange="fillCourses(this, document.getElementById('course'))">
                                                        <option></option>
                                                        <option>Computer Engineering</option>
                                                </select>
                                        </p>
                                        <p class="leftItem">
                                                <label for="selectCourse">Select Course:</label>
                                                <select class="leftItem" id="course" name="course" required onchange="fillSection(this, document.getElementById('section'))">
                                                        <option></option>
                                                </select>
                                        </p>
                                        <p class="leftItem">
                                                <label for="sectionNumber">Section Number:</label>
                                                <select class="leftItem" id="section" class="section" required>
                                                        <option></option>
                                                </select>
                                        </p>
                                </div>
                                <div class="right">
                                        <div class="info">
                                        </div>
                                        <div class="below">
                                        </div>

                                </div>
                        </form>
                </div>
        </body>
<html>
