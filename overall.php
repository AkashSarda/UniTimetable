<?php
//include js
function utt_overall_scripts(){
    //include eventScripts
//    wp_enqueue_script( 'eventScripts',  plugins_url('js/eventScripts.js', __FILE__) );
    //localize eventScripts
    wp_localize_script( 'eventScripts', 'eventStrings', array(
        'deleteForbidden' => __( 'Delete is forbidden while completing the form!', 'UniTimetable' ),
        'deleteEvent' => __( 'Are you sure that you want to delete this Event?', 'UniTimetable' ),
        'eventDeleted' => __( 'Event deleted successfully!', 'UniTimetable' ),
        'eventNotDeleted' => __( 'Failed to delete Event.', 'UniTimetable' ),
        'editForbidden' => __( 'Edit is forbidden while completing the form!', 'UniTimetable' ),
        'editEvent' => __( 'Edit Event', 'UniTimetable' ),
        'cancel' => __( 'Cancel', 'UniTimetable' ),
        'typeVal' => __( 'Please choose an Event type.', 'UniTimetable' ),
        'titleVal' => __( 'Event title is required.', 'UniTimetable' ),
        'classroomVal' => __( 'Please select a Classroom.', 'UniTimetable' ),
        'dateVal' => __( 'Invalid date.', 'UniTimetable' ),
        'startTimeVal' => __( 'Invalid start time.', 'UniTimetable' ),
        'endTimeVal' => __( 'Invalid end time.', 'UniTimetable' ),
        'timeVal' => __( 'Start time cannot be after end time.', 'UniTimetable' ),
        'insertEvent' => __( 'Insert Event', 'UniTimetable' ),
        'reset' => __( 'Reset', 'UniTimetable' ),
        'failAdd' => __( 'Failed to insert Event. Check if Classroom is used.', 'UniTimetable' ),
        'successAdd' => __( 'Event inserted successfully!', 'UniTimetable' ),
        'failEdit' => __( 'Failed to edit Event. Check if Classroom is used.', 'UniTimetable' ),
        'successEdit' => __( 'Event edited successfully!', 'UniTimetable' ),
    ));
    //include css and js files
    wp_enqueue_style( 'jqueryui_style', plugins_url('css/jquery-ui.css', __FILE__) );
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_script('jquery-ui-spinner');
    wp_enqueue_style( 'smoothnesscss',  plugins_url('css/smoothness-jquery-ui.css', __FILE__) );
    wp_enqueue_script('jquerymousewheel', plugins_url('js/jquery.mousewheel.js', __FILE__));
    wp_enqueue_script('globalize', plugins_url('js/globalize.js', __FILE__));
    wp_enqueue_script('globalizede', plugins_url('js/globalize.culture.de-DE.js', __FILE__));
}
//events page
function utt_create_overall_page(){

     global $wpdb;
    //set table names
    $periodsTable=$wpdb->prefix."utt_periods";
    $subjectsTable=$wpdb->prefix."utt_subjects";
    $groupsTable=$wpdb->prefix."utt_groups";
    $teachersTable=$wpdb->prefix."utt_teachers";
    $classroomsTable=$wpdb->prefix."utt_classrooms";
    $lecturesTable=$wpdb->prefix."utt_lectures";
    $holidaysTable=$wpdb->prefix."utt_holidays";
    $eventsTable=$wpdb->prefix."utt_events";
    ?>
    <div class="wrap container">
        <h3><?php
        //show database records
        _e("Current Status Of Records","UniTimetable"); ?></h3>
        <?php $teachers = $wpdb->get_row("SELECT count(*) as counter FROM $teachersTable;") ?>
        
        <?php $periods = $wpdb->get_row("SELECT count(*) as counter FROM $periodsTable;") ?>
        
        <?php $subjects = $wpdb->get_row("SELECT count(*) as counter FROM $subjectsTable;") ?>
        
        <?php $classrooms = $wpdb->get_row("SELECT count(*) as counter FROM $classroomsTable;") ?>
        
        <?php $groups = $wpdb->get_row("SELECT count(*) as counter FROM $groupsTable;") ?>
        
        <?php $holidays = $wpdb->get_row("SELECT count(*) as counter FROM $holidaysTable;") ?>
        
        <?php $events = $wpdb->get_row("SELECT count(*) as counter FROM $eventsTable;") ?>
       
        <?php $lectures = $wpdb->get_row("SELECT count(*) as counter FROM $lecturesTable;") ?>
        
        
        <div class="container col-sm-3">
  
  <table class="table">
    <thead>
      <tr>
        <th>Entity Name</th>
        <th>Records</th>
 
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?php _e("Teachers","UniTimetable"); ?></td>
        <td><?php echo " ".$teachers->counter." ";?></td>
       </tr>
      <tr>
        <td><?php _e("Periods","UniTimetable"); ?></td>
        <td><?php echo " ".$periods->counter." ";?></td>
       </tr>
       <tr>
        <td><?php _e("Subjects","UniTimetable"); ?></td>
        <td><?php echo " ".$subjects->counter." ";?></td>
       </tr>
       <tr>
        <td><?php _e("Classrooms","UniTimetable"); ?></td>
        <td><?php echo " ".$classrooms->counter." ";?></td>
       </tr>
       <tr>
        <td><?php _e("Groups","UniTimetable"); ?></td>
        <td><?php echo " ".$groups->counter." ";?></td>
       </tr>
       <tr>
        <td><?php _e("Holidays","UniTimetable"); ?></td>
        <td><?php echo " ".$holidays->counter." ";?></td>
       </tr>
       <tr>
        <td><?php _e("Events","UniTimetable"); ?></td>
        <td><?php echo " ".$events->counter." ";?></td>
       </tr>
       <tr>
        <td><?php _e("Lectures","UniTimetable"); ?></td>
        <td><?php echo " ".$lectures->counter." ";?></td>
       </tr>
    </tbody>
  </table>
  
  
 <!-- Teacher table -->
 <?php
 $teachersTable=$wpdb->prefix."utt_teachers";
        
    //show registered teachers
    $teachers = $wpdb->get_results("SELECT * FROM $teachersTable ORDER BY surname");
 ?>
 		<div class = "col-sm-6">
 		<table class = "table">
 		<thead>
			<th>Name</th>
			<th>Assigned Workload</th> 		
 		</thead>
		<?php
		foreach($teachers as $teacher){
            //a record
            echo "<tr><td>$teacher->surname</td><td>$teacher->assignedWorkLoad</td></tr>";
        } 		
 		?>		
 		</table>
 	   </div>
    </div>
<?php
}
?>
