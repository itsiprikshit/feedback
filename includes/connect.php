<?php

	require("config.php");
    $conn = @mysql_connect(mysql_host, mysql_user, mysql_pass);

	if (!$conn)
			die(conn_error);
    else
    {
        if(!@mysql_select_db(mysql_db))
        {
            $sql = 'CREATE Database '.mysql_db;
            $create_db = mysql_query($sql, $conn);

            if(!$create_db)
                die('Could not create database.');
            
            $sql_admin = "CREATE TABLE admin("."admin varchar(30),
                                             "."admin_password varchar(25));";
                                                   
            $sql_student = "CREATE TABLE student("."r_no INT(5) PRIMARY KEY,
                                                   "."s_name VARCHAR(30),  
                                                   "."dept VARCHAR(5),
                                                   "."sem INT(2),
                                                   "."password VARCHAR(32) NOT NULL,
                                                   "."email VARCHAR(50)  NOT NULL,
                                                   "."confirm INT(1) DEFAULT 0,
                                                   "."token INT(16),
                                                   "."fb_done INT(1) DEFAULT 0,
                                                   "."c1 INT(1) DEFAULT 0,
                                                   "."c2 INT(1) DEFAULT 0,
                                                   "."c3 INT(1) DEFAULT 0,
                                                   "."c4 INT(1) DEFAULT 0,
                                                   "."c5 INT(1) DEFAULT 0);";
            
             $sql_courses = "CREATE TABLE courses("."c_id VARCHAR(6) PRIMARY KEY,
                                                   "."c_name VARCHAR(30),
                                                   "."dept VARCHAR(5),
                                                   "."sem INT(2));";
                                                  
             $sql_teacher = "CREATE TABLE teacher("."t_id INT(5) PRIMARY KEY,
                                                   "."t_name VARCHAR(30),
                                                   "."t_password VARCHAR(25),
                                                   "."t_branch VARCHAR(5),
                                                   "."c_id1 VARCHAR(6),    
                                                   "."c_id2 VARCHAR(6),
                                                   "."c_id3 VARCHAR(6));";
                                                   
            $sql_teacher_rep = "CREATE TABLE report("."c_id VARCHAR(6) PRIMARY KEY,
                                                   "."t_id INT(5),
                                                   "."q1 numeric(4,2) DEFAULT 0,
                                                   "."q2 numeric(4,2) DEFAULT 0,
                                                   "."q3 numeric(4,2) DEFAULT 0,
                                                   "."q4 numeric(4,2) DEFAULT 0,
                                                   "."q5 numeric(4,2) DEFAULT 0,
                                                   "."count INT(3),
                                                   "."FOREIGN KEY (t_id) REFERENCES teacher(t_id));";
                                                
            $sql_questions = "CREATE TABLE questions("."s_no INT(1) PRIMARY KEY,
                                                   "."que1 VARCHAR(100),
                                                   "."que2 VARCHAR(100),
                                                   "."que3 VARCHAR(100),
                                                   "."que4 VARCHAR(100),
                                                   "."que5 VARCHAR(100));";
                                           
            mysql_select_db(mysql_db);
            
            $create_table_student = mysql_query( $sql_student, $conn );
            $create_table_admin = mysql_query( $sql_admin, $conn );
            $create_table_courses = mysql_query( $sql_courses, $conn );
            $create_table_teacher = mysql_query( $sql_teacher, $conn );
            $create_table_questions = mysql_query( $sql_questions, $conn );
            $create_table_teacher_rep = mysql_query( $sql_teacher_rep, $conn );
            
            if(!$create_table_student && !$create_table_admin && !$create_table_strength && !$create_table_course_list && !$create_table_courses && !$create_table_report && !$create_table_teacher && !$create_table_questions)
                die('Could not create table.');
                
            $query_courses = "INSERT INTO `courses` (`c_id`, `c_name`, `dept`, `sem`) VALUES
                                    ('CS-211', 'Discrete Structure', 'CSE', 3),
                                    ('CS-212', 'Object oriented Paradigm', 'CSE', 3),
                                    ('CS-213', 'Computer Graphics', 'CSE', 3),
                                    ('CS-214', 'Microprocessors', 'CSE', 3),
                                    ('CS-216', 'TOC', 'CSE', 3),
                                    ('CS-311', 'Modelling & Simulation', 'CSE', 5),
                                    ('CS-312', 'Analysis & Design of Algorithm', 'CSE', 5),
                                    ('CS-313', 'DBMS', 'CSE', 5),
                                    ('CS-314', 'Compiler Design', 'CSE', 5),
                                    ('CS-315', 'System Software', 'CSE', 5),
                                    ('CS-410', 'Information Security', 'CSE', 7),
                                    ('CS-412', 'Advanced OS', 'CSE', 7),
                                    ('CS-413', 'Advance Computer Architecture', 'CSE', 7),
                                    ('CS-416', 'Artificial Intelligence', 'CSE', 7),
                                    ('EC-211', 'Analog Electronics', 'ECE', 3),
                                    ('EC-212', 'Digital Electronics', 'ECE', 3),
                                    ('EC-213', 'Communication Theory', 'ECE', 3),
                                    ('EC-214', 'EFT', 'ECE', 3),
                                    ('EC-215', 'Network Analysis ', 'ECE', 3),
                                    ('EC-311', 'Microprocessor', 'ECE', 5),
                                    ('EC-312', 'Digital Communication', 'ECE', 5),
                                    ('EC-313', 'Antenna & Wave', 'ECE', 5),
                                    ('EC-314', 'Device Modelling', 'ECE', 5),
                                    ('EC-315', 'Signal & Waves', 'ECE', 5),
                                    ('EC-411', 'Data Communication', 'ECE', 7),
                                    ('EC-412', 'Digital Signal processing', 'ECE', 7),
                                    ('EC-414', 'Optical Fibres', 'ECE', 7),
                                    ('EC-416', 'Control System', 'ECE', 7),
                                    ('ME-211', 'Thermodynamics', 'ME', 3),
                                    ('ME-212', 'Manufacturing', 'ME', 3),
                                    ('ME-213', 'Metallurgy', 'ME', 3),
                                    ('ME-214', 'Mechanics of Materials', 'ME', 3),
                                    ('ME-311', 'Thermal Engineering', 'ME', 5),
                                    ('ME-312', 'Machine Design', 'ME', 5),
                                    ('ME-313', 'Measurement', 'ME', 5),
                                    ('ME-314', 'Dynamics of Materials', 'ME', 5),
                                    ('ME-411', 'Manufacturing Processes', 'ME', 7),
                                    ('ME-413', 'Fluid Mechanics', 'ME', 7),
                                    ('ME-414', 'Heat Transfer', 'ME', 7),
                                    ('ME-415', 'Numerical Analysis', 'ME', 7)";
            
            $query_questions = "INSERT INTO `questions` (`s_no`, `que1`, `que2`, `que3`, `que4`, `que5`) VALUES
                                (1, 'Regularity and Punctuality.', 'Knowledge of the subject.', 'Communication skills and interaction with students.', 'Marking.', 'Coverage of syllabus.');";                        
            
            $query_faculty = "INSERT INTO `teacher` (`t_id`, `t_name`, `t_password`, `t_branch`, `c_id1`, `c_id2`, `c_id3`) VALUES
                                                    (20301, 'Rajesh Sharma', 'rajesh', 'ME', 'ME-212', 'ME-312', 'ME-411'),
                                                    (20302, 'Sidharth Vashishth', 'sidharth', 'ME', 'ME-211', '', 'ME-413'),
                                                    (20303, 'Mohit Pant', 'mohit', 'ME', 'ME-214', 'ME-313', 'ME-414'),
                                                    (20304, 'Sant Ram', 'sant', 'ME', 'ME-213', 'ME-314', ''),
                                                    (20305, 'Varun Sharma', 'varun', 'ME', '', 'ME-311', 'ME-415'),
                                                    (20401, 'Amita Nandal', 'amita', 'ECE', 'EC-212', 'EC-311', 'EC-411'),
                                                    (20402, 'Gagnesh Kumar', 'gagnesh', 'ECE', 'EC-213', 'EC-313', 'EC-414'),
                                                    (20403, 'Daniel', 'daniel', 'ECE', 'EC-215', 'EC-314', 'EC-412'),
                                                    (20404, 'Gargi Khanna', 'gargi', 'ECE', 'EC-214', 'EC-312', ''),
                                                    (20405, 'Ashwani Rana', 'ashwani', 'ECE', 'EC-211', 'EC-315', 'EC-416'),
                                                    (20501, 'Nitin Gupta', 'nitin', 'CSE', 'CS-214', 'CS-313', 'CS-412'),
                                                    (20502, 'Triveni Lal Pal', 'triveni', 'CSE', 'CS-216', 'CS-315', ''),
                                                    (20503, 'Menka Goswami', 'menka', 'CSE', 'CS-213', 'CS-311', 'CS-416'),
                                                    (20504, 'Rajeev Bhardwaj', 'rajeev', 'CSE', 'CS-211', 'CS-312', 'CS-413'),
                                                    (20505, 'Naveen Chauhan', 'naveen', 'CSE', 'CS-212', 'CS-314', 'CS-410');";
            
            $query_admin = "INSERT INTO `admin` (`admin`, `admin_password`) VALUES
                                                ('prikshit', 'root');";
                                                
            mysql_query($query_courses);
            mysql_query($query_questions);
            mysql_query($query_faculty);
            mysql_query($query_admin);
        }
        else
            mysql_select_db(mysql_db);
    }
?>
