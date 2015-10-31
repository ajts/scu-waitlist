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
                        <a href="core/storage/waitlists/COEN.csv">Download waitlist for departmentt</a>
                </div>
        </body>
<html>
        
<script src="core/js/main.js"></script>
       
