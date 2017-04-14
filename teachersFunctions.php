<?php
//include js
function utt_teacher_scripts(){
    //include teacher scripts
    wp_enqueue_script( 'teacherScripts',  plugins_url('js/teacherScripts.js', __FILE__) );
    //localize teacher scripts
    wp_localize_script( 'teacherScripts', 'teacherStrings', array(
        'deleteForbidden' => __( 'Delete is forbidden while completing the form!', 'UniTimetable' ),
        'deleteRecord' => __( 'Are you sure that you want to delete this record?', 'UniTimetable' ),
        'teacherDeleted' => __( 'Teacher deleted successfully!', 'UniTimetable' ),
        'teacherNotDeleted' => __( 'Failed to delete Teacher. Check if Teacher is connected with a Lecture.', 'UniTimetable' ),
        'editForbidden' => __( 'Edit is forbidden while completing the form!', 'UniTimetable' ),
        'editTeacher' => __( 'Edit Teacher', 'UniTimetable' ),
        'cancel' => __( 'Cancel', 'UniTimetable' ),
        'surnameVal' => __( 'Surname field is required. Please avoid using special characters.', 'UniTimetable' ),
        'nameVal' => __( 'Please avoid using special characters at Name field.', 'UniTimetable' ),
        'minmaxWork' => __( 'Please provide valid working hours' ),
        'insertTeacher' => __( 'Insert Teacher', 'UniTimetable' ),
        'reset' => __( 'Reset', 'UniTimetable' ),
        'failAdd' => __( 'Failed to add Teacher. Check if the Teacher already exists.', 'UniTimetable' ),
        'successAdd' => __( 'Teacher successfully added!', 'UniTimetable' ),
        'failEdit' => __( 'Failed to edit Teacher. Check if the Teacher already exists.', 'UniTimetable' ),
        'successEdit' => __( 'Teacher successfully edited!', 'UniTimetable' ),
    ));
}

//teachers page
function utt_create_teachers_page(){
    //teachers form
?>
<div class="wrap">
    <h2 id="teacherTitle"><?php _e('Insert Teacher','UniTimetable'); ?></h2>
    <div class = "container form-line" id = "formcontainer">
    <form action="" name="teacherForm" method="post">
        <input type="hidden" name="teacherid" id="teacherid" value=0 />
	<div class = "ip col-sm-6 pull-left">
		<label for="lastname"><?php _e("Surname:", "UniTimeTable"); ?></label>
        	<br/>
        	 <input type="text" name="lastname" id="lastname" class="form-control dirty" required placeholder="<?php _e("Required","UniTimetable"); ?>"/>
        	<br/>
	</div>
	<div class = "ip col-sm-6 pull-left">
		<label for="firstname"><?php _e("Name:", "UniTimeTable"); ?></label><br/>
        	<input type="text" name="firstname" id="firstname" class="form-control dirty"/><br/>
	</div>
	<div class = "ip col-sm-6 pull-left">
		<label for="minwork"><?php _e("Minimum Workload:", "UniTimeTable"); ?></label><br/>
        	<input type="text" name="minwork" id="minwork" class="form-control dirty" required placeholder="<?php _e("Required","UniTimetable"); ?>"/>
        <br/>
	</div>
	<div class = "ip col-sm-6 pull-left">
		<label for="maxwork"><?php _e("Maximum Workload:", "UniTimeTable"); ?></label><br/>
        	<input type="text" name="maxwork" id="maxwork" class="form-control dirty" required placeholder="<?php _e("Required","UniTimetable"); ?>"/>
        <br/>
	</div>
        <div id="secondaryButtonContainer" class = "container" style = "background-color:#D3D3D3">
        <input type="submit" value="<?php _e("Submit","UniTimetable"); ?>" id="insert-updateTeacher" class="btn button-primary"/>
        <a href='#' class='btn button-secondary' id="clearTeacherForm"><?php _e("Reset","UniTimetable"); ?></a>
	</br></br>
        </div>
    </form>
	</div>
    <!-- place to view messages -->
    <div id="messages"></div>
    <!-- place to view table with registered teachers -->
    </br></br>
    <div id="teachersResults" class = "container pull-center" >
        <?php utt_view_teachers(); ?>
    </div>

</div>

<?php
}

add_action('wp_ajax_utt_view_teachers', 'utt_view_teachers');
function utt_view_teachers(){
    global $wpdb;
    $teachersTable=$wpdb->prefix."utt_teachers";
        
    //show registered teachers
    $teachers = $wpdb->get_results("SELECT * FROM $teachersTable ORDER BY surname");
    ?>
    <div class="container col-sm-10">
        <!-- table with registered teachers -->
        <table class="widefat bold-th container">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><?php _e("Surname","UniTimetable"); ?></th>
                    <th><?php _e("Name","UniTimetable"); ?></th>
                    <th><?php _e("Min workload","UniTimetable"); ?></th>
                    <th><?php _e("Max workload","UniTimetable"); ?></th>
                    <th><?php _e("Assigned workload","UniTimetable"); ?></th>
                    <th><?php _e("Actions","UniTimetable"); ?></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th><?php _e("Surname","UniTimetable"); ?></th>
                    <th><?php _e("Name","UniTimetable"); ?></th>
                    <th><?php _e("Min workload","UniTimetable"); ?></th>
                    <th><?php _e("Max workload","UniTimetable"); ?></th>
                    <th><?php _e("Assigned workload","UniTimetable"); ?></th>
                    <th><?php _e("Actions","UniTimetable"); ?></th>
                </tr>
            </tfoot>
            <tbody>
        </div>
        <?php
        //show grey and white records in order to be more recognizable
        $bgcolor = 1;
        foreach($teachers as $teacher){
            if($bgcolor == 1){
                $addClass = "class='grey'";
                $bgcolor = 2;
            }else{
                $addClass = "class='white'";
                $bgcolor = 1;
            }
            //a record
            echo "<tr id='$teacher->teacherID' $addClass><td>$teacher->teacherID</td><td>$teacher->surname</td><td>$teacher->name</td><td>$teacher->minWorkLoad</td><td>$teacher->maxWorkLoad</td><td>$teacher->assignedWorkLoad</td><td><a href='#' onclick='deleteTeacher($teacher->teacherID);' class='deleteTeacher'><img id='edit-delete-icon' src='".plugins_url('icons/delete_icon.png', __FILE__)."'/> ".__("Delete","UniTimetable")."</a>&nbsp; <a href='#' onclick=\"editTeacher($teacher->teacherID, '$teacher->surname', '$teacher->name', $teacher->minWorkLoad, $teacher->maxWorkLoad);\" class='editTeacher'><img id='edit-delete-icon' src='".plugins_url('icons/edit_icon.png', __FILE__)."'/> ".__("Edit","UniTimetable")."</a></td></tr>";
        }
        
        ?>
            </tbody>
        </table>
        <?php
        die();
}

//ajax response delete teacher
add_action('wp_ajax_utt_delete_teacher', 'utt_delete_teacher');
function utt_delete_teacher(){
    global $wpdb;
    $teachersTable=$wpdb->prefix."utt_teachers";
    $safeSql = $wpdb->prepare("DELETE FROM $teachersTable WHERE teacherID= %d ", $_GET['teacher_id']);
    $success = $wpdb->query($safeSql);
    //if success is 1, delete succeeded
    echo $success;
    die();
}

//ajax response insert-update teacher
add_action('wp_ajax_utt_insert_update_teacher','utt_insert_update_teacher');
function utt_insert_update_teacher(){
    global $wpdb;
    //data
    $firstname=$_GET['teacher_name'];
    $lastname=$_GET['teacher_surname'];
    $teacherid=$_GET['teacher_id'];
    $maxhour=$_GET['teacher_max_work'];
    $minhour=$_GET['teacher_min_work'];
    $teachersTable=$wpdb->prefix."utt_teachers";
    //insert
    if($teacherid==0){
        $safeSql = $wpdb->prepare("INSERT INTO $teachersTable (name, surname, minWorkLoad, maxWorkLoad, assignedWorkLoad) VALUES (%s,%s,%d,%d,0)",$firstname,$lastname,$minhour,$maxhour);
        $success = $wpdb->query($safeSql);
        if($success == 1){
            //success
            echo 1;
        }else{
            //fail
            echo 0; 
        }
    //edit
    }else{
        $safeSql = $wpdb->prepare("UPDATE $teachersTable SET name=%s, surname=%s, minWorkLoad=%d, maxWorkLoad=%d WHERE teacherID=%d; ",$firstname,$lastname,$minhour,$maxhour,$teacherid);
        $success = $wpdb->query($safeSql);
        if($success == 1){
            //success
            echo 1;
        }else{
            //fail
            echo 0;
        }
    }
die();
}

?>
