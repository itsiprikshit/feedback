<?php

	require("config.php");
    $conn = @mysql_connect(mysql_host, mysql_user, mysql_pass);

	if (!$conn){
            echo 'Incorrect Credentials<br />';
			die(conn_error);
    }
    else
    {
        if(!@mysql_select_db(mysql_db))
        {
            $sql = 'CREATE Database '.mysql_db;
            $create_db = mysql_query($sql, $conn);

            if(!$create_db)
                die('Could not create database.');
            
            $sql_admin = "CREATE TABLE admin("."admin_id varchar(30),
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
                die('Could not create tables.');
        }
        else{
            mysql_select_db(mysql_db);
        }
    }
?>
