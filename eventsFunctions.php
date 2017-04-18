<?php
//include js
function utt_event_scripts(){
    //include eventScripts
    wp_enqueue_script( 'eventScripts',  plugins_url('js/eventScripts.js', __FILE__) );
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
function utt_create_events_page(){
    global $wpdb;
    ?>
    <div class="wrap container" style="background-color : #d3d3d3">
        <h2 id="eventTitle"><?php _e("Insert Event","UniTimetable"); ?></h2>
        <form action="" name="eventForm" method="post">
            <input type="hidden" name="eventID" id="eventID" value=0 />
	    <div class = "container">
	    <div class = "col-sm-6">
            <label for = "eventType"><?php _e("Event type:","UniTimetable"); ?><br/></label>
            <select name="eventType" id="eventType" class="form-control dirty">
                <option value="0"><?php _e("- select -","UniTimetable"); ?></option>
                <option value="Thesis"><?php _e("Thesis","UniTimetable"); ?></option>
                <option value="Speech"><?php _e("Speech","UniTimetable"); ?></option>
                <option value="Presentation"><?php _e("Presentation","UniTimetable"); ?></option>
                <option value="Students Team"><?php _e("Students Team","UniTimetable"); ?></option>
                <option value="Graduation"><?php _e("Graduation","UniTimetable"); ?></option>
            </select><br/>
	    </div>
	    <div class = "col-sm-6">
            <label for = "title"><?php _e("Event title:","UniTimetable"); ?><br/></label>
            <input type="text" name="title" id="title" class="form-control dirty" size="40" placeholder="<?php _e("Required","UniTimetable"); ?>"/><br/>
	    </div>
	    <div class = "col-sm-6">
            <label for = "eventDescr"><?php _e("Event description:","UniTimetable"); ?><br/></label>
            <textarea rows="4" cols="38" class="form-control dirty" id="eventDescr" name="eventDescr"></textarea><br/>
	    </div>
            <div class="element2 firstInRow col-sm-6">
            <label for = "classroom"> <?php _e("Classroom:","UniTimetable"); ?><br/></label>
            <select name="classroom" id="classroom" class="form-control dirty">
                <?php
                $classroomsTable=$wpdb->prefix."utt_classrooms";
                $classrooms = $wpdb->get_results( "SELECT * FROM $classroomsTable ORDER BY name");
                echo "<option value='0'>".__("- select -","UniTimetable")."</option>";
                foreach($classrooms as $classroom){
                    //translate classroom type to selected language
                    if($classroom->type == "Lecture"){
                        $classroomType = __("Lecture","UniTimetable");
                    }else{
                        $classroomType = __("Laboratory","UniTimetable");
                    }
                    //show classrooms into combo-box
                    echo "<option value='$classroom->classroomID'>$classroom->name $classroomType</option>";
                }
                ?>
            </select>
            </div>
            <div class="element2 col-sm-6">
            <label for = "date"><?php _e("Date:","UniTimetable"); ?><br/></label>
            <input type="text" name="date" id="date" class="form-control dirty" size="14"/> </br>
            </div>
            <div class="element2 firstInRow last col-sm-6">
            <label for = "time"><?php _e("Start time:","UniTimetable"); ?><br/></label>
            <input name="time" id="time" class="form-control dirty" value="8:00" size="10"/>
            <label for = "endTime"><?php _e("End time:","UniTimetable"); ?><br/></label>
            <input name="endTime" id="endTime" class="form-control dirty" value="10:00" size="10"/>
            </div>
	    </div>
	    </br>
            <div id="secondaryButtonContainer" class = "container">
                <input type="submit" value="<?php _e("Submit","UniTimetable"); ?>" id="insert-updateEvent" class="button-primary"/>
                <a href='#' class='button-secondary' id="clearEventForm"><?php _e("Reset","UniTimetable"); ?></a>
            </div>
            </form>
            <!-- place to show messages -->
            <div id="messages"></div>
	    </br>
	    <div class = "container">
            <?php _e("Events of Year:","UniTimetable"); ?>
            <!-- filter events by year -->
            <select name="yearFilter" id="yearFilter" onchange="viewEvents();">
                <option value="0"><?php _e("All","UniTimetable"); ?></option>
                <?php
                $curYear = date("Y");
                $nextYear = $curYear+1;
                //show this years events on first load
                echo "<option value='$curYear' selected='selected'>$curYear</option>";
                echo "<option value='$nextYear'>$nextYear</option>";
                ?>
            </select>
	    </div>
            <!-- place to show registered events -->
            <div id="eventsResults" class = "container">
                <?php utt_view_events(); ?>
                </br>
            </div>
    </div>
<?php
}

//ajax response view events
add_action('wp_ajax_utt_view_events','utt_view_events');
function utt_view_events(){
    global $wpdb;
    //register events table
    $eventsTable = $wpdb->prefix."utt_events";
    //register classrooms table
    $classroomsTable = $wpdb->prefix."utt_classrooms";
    //get selected year
    if(isset($_GET['selectedYear'])){
        $selectedYear = $_GET['selectedYear'];
    }else{
        $selectedYear = date("Y");
    }
    //if not selected year, show all events, else filter
    if($selectedYear == 0){
        $safeSql = "SELECT eventID, DATE_FORMAT(eventStart, '%d/%m/%Y') date, eventType, eventTitle, eventDescr, name,$classroomsTable.classroomID, TIME(eventStart) as start, TIME(eventEnd) as end, eventStart, eventEnd
                                         FROM $eventsTable, $classroomsTable
                                         WHERE $eventsTable.classroomID=$classroomsTable.classroomID ORDER BY date, start;";
    }else{
        $safeSql = $wpdb->prepare("SELECT eventID, DATE_FORMAT(eventStart, '%%d/%%m/%%Y') date, eventType, eventTitle, eventDescr, name,$classroomsTable.classroomID, TIME(eventStart) as start, TIME(eventEnd) as end, eventStart, eventEnd
                                         FROM $eventsTable, $classroomsTable
                                         WHERE $eventsTable.classroomID=$classroomsTable.classroomID AND YEAR(eventStart)=%s ORDER BY date, start;",$selectedYear);
    }
    ?>
    <!-- show events table -->
    <table class="widefat bold-th">
        <thead>
            <tr>
                <th><?php _e("Date","UniTimetable"); ?></th>
                <th><?php _e("Type","UniTimetable"); ?></th>
                <th><?php _e("Title","UniTimetable"); ?></th>
                <th><?php _e("Description","UniTimetable"); ?></th>
                <th><?php _e("Classroom","UniTimetable"); ?></th>
                <th><?php _e("Start time","UniTimetable"); ?></th>
                <th><?php _e("End time","UniTimetable"); ?></th>
                <th><?php _e("Actions","UniTimetable"); ?></th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th><?php _e("Date","UniTimetable"); ?></th>
                <th><?php _e("Type","UniTimetable"); ?></th>
                <th><?php _e("Title","UniTimetable"); ?></th>
                <th><?php _e("Description","UniTimetable"); ?></th>
                <th><?php _e("Classroom","UniTimetable"); ?></th>
                <th><?php _e("Start time","UniTimetable"); ?></th>
                <th><?php _e("End time","UniTimetable"); ?></th>
                <th><?php _e("Actions","UniTimetable"); ?></th>
            </tr>
        </tfoot>
        <tbody>
            <?php
            //select events
            $events = $wpdb->get_results($safeSql);
            //show grey and white records in order to be more recognizable
            $bgcolor = 1;
            foreach($events as $event){
                if($bgcolor == 1){
                    $addClass = "class='grey'";
                    $bgcolor = 2;
                }else{
                    $addClass = "class='white'";
                    $bgcolor = 1;
                }
                //translate event type
                switch($event->eventType){
                    case "Thesis":
                        $eventType = __("Thesis","UniTimetable");
                        break;
                    case "Speech":
                        $eventType = __("Speech","UniTimetable");
                        break;
                    case "Presentation":
                        $eventType = __("Presentation","UniTimetable");
                        break;
                    case "Students Team":
                        $eventType = __("Students Team","UniTimetable");
                        break;
                    case "Graduation":
                        $eventType = __("Graduation","UniTimetable");
                        break;
                }
                $start = explode(":",$event->start);
                $eventStart = $start[0].":".$start[1];
                $end = explode(":",$event->end);
                $eventEnd = $end[0].":".$end[1];
                //a record
                echo "<tr id='$event->eventID' $addClass><td>$event->date</td><td>$eventType</td><td>$event->eventTitle</td><td>$event->eventDescr</td><td>$event->name</td><td>$eventStart</td><td>$eventEnd</td>
                <td><a href='#' onclick='deleteEvent($event->eventID);' class='deleteEvent'><img id='edit-delete-icon' src='".plugins_url('icons/delete_icon.png', __FILE__)."'/> ".__("Delete","UniTimetable")."</a>&nbsp;
                <a href='#' onclick=\"editEvent($event->eventID, '$event->eventType', '$event->eventTitle', '$event->eventDescr', $event->classroomID, '$event->eventStart', '$event->eventEnd');\" class='editEvent'><img id='edit-delete-icon' src='".plugins_url('icons/edit_icon.png', __FILE__)."'/> ".__("Edit","UniTimetable")."</a></td></tr>";
            }
            ?>
        </tbody>
    </table>
    <?php
if(isset($_GET['selectedYear'])){
    die();
}
}

//ajax response insert-update event
add_action('wp_ajax_utt_insert_update_event','utt_insert_update_event');
function utt_insert_update_event(){
    global $wpdb;
    //data to be inserted/updated
    $eventID = $_GET['eventID'];
    $eventType = $_GET['eventType'];
    $eventTitle = $_GET['eventTitle'];
    $eventDescr = $_GET['eventDescr'];
    $classroom = $_GET['classroom'];
    $date = $_GET['date'];
    $time = $_GET['time'];
    $endTime = $_GET['endTime'];
    $eventStart = $date." ".$time;
    $eventEnd = $date." ".$endTime;
    //register tables
    $eventsTable = $wpdb->prefix."utt_events";
    $lecturesTable = $wpdb->prefix."utt_lectures";
    //if eventID is 0, it is insert
    if($eventID==0){
        //check if classroom is available
        $busyClassroom1 = $wpdb->get_row($wpdb->prepare("SELECT * FROM $lecturesTable WHERE classroomID=%d AND %s<end AND %s>start;",$classroom,$eventStart,$eventEnd));
        $busyClassroom2 = $wpdb->get_row($wpdb->prepare("SELECT * FROM $eventsTable WHERE classroomID=%d AND %s<eventEnd AND %s>eventStart;",$classroom,$eventStart,$eventEnd));
        if($busyClassroom1="" || $busyClassroom2=""){
            //classroom is not available
            echo 0;
        }else{
            //classroom is available
            $safeSql = $wpdb->prepare("INSERT INTO $eventsTable (eventType, eventTitle, eventDescr, classroomID, eventStart, eventEnd) VALUES (%s, %s,%s, %d, %s, %s);",$eventType,$eventTitle,$eventDescr,$classroom,$eventStart,$eventEnd);
            $wpdb->query($safeSql);
            echo 1;
        }
    //it is edit
    }else{
        //check if classroom is available
        $busyClassroom1 = $wpdb->get_row($wpdb->prepare("SELECT * FROM $lecturesTable WHERE classroomID=%d AND %s<end AND %s>start;",$classroom,$eventStart,$eventEnd));
        $busyClassroom2 = $wpdb->get_row($wpdb->prepare("SELECT * FROM $eventsTable WHERE classroomID=%d AND %s<eventEnd AND %s>eventStart AND eventID<>%d;",$classroom,$eventStart,$eventEnd,$eventID));
        if($busyClassroom1!="" || $busyClassroom2!=""){
            //classroom is not available
            echo 0;
        }else{
            //classroom is available
            $safeSql = $wpdb->prepare("UPDATE $eventsTable SET eventType=%s, eventTitle=%s, eventDescr=%s, classroomID=%d, eventStart=%s, eventEnd=%s WHERE eventID=%d;",$eventType,$eventTitle,$eventDescr,$classroom,$eventStart,$eventEnd,$eventID);
            $success = $wpdb->query($safeSql);
            if($success==1){
                echo 1;
            }else{
                echo 0;
            }
            
        }
    }
    die();
}

//ajax response delete event
add_action('wp_ajax_utt_delete_event', 'utt_delete_event');
function utt_delete_event(){
    global $wpdb;
    $eventsTable=$wpdb->prefix."utt_events";
    $safeSql = $wpdb->prepare("DELETE FROM `$eventsTable` WHERE eventID=%d",$_GET['eventID']);
    $success = $wpdb->query($safeSql);
    //if success is 1, delete succeeded
    echo $success;
    die();
}
?>
