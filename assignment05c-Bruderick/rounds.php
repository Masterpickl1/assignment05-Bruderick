<?php
    require_once("database.php");
    require_once("table.php");
    
    class Rounds implements Table {
        // DATA MEMBERS
        private $id;
        private $userID;
        private $userIDErr;
        private $courseID;
        private $courseIDErr;
		private $seqNum;
        
        // CONSTRUCTOR
        function __construct($id, $userID, $courseID, $seqNum, $hole1, $hole2, $hole3, $hole4, $hole5, $hole6, $hole7,
											$hole8, $hole9, $hole10, $hole11, $hole12, $hole13, $hole14,
											$hole15, $hole16, $hole17, $hole18) {
            $this->id     = $id;
            $this->userID = $userID;
            $this->courseID = $courseID;
			$this->seqNum = $seqNum;
            $this->hole1  = $hole1;
            $this->hole2  = $hole2;
            $this->hole3  = $hole3;
            $this->hole4  = $hole4;
            $this->hole5  = $hole5;
            $this->hole6  = $hole6;
            $this->hole7  = $hole7;
            $this->hole8  = $hole8;
            $this->hole9  = $hole9;
            $this->hole10  = $hole10;
            $this->hole11  = $hole11;
            $this->hole12  = $hole12;
            $this->hole13  = $hole13;
            $this->hole14  = $hole14;
            $this->hole15  = $hole15;
            $this->hole16  = $hole16;
            $this->hole17  = $hole17;
            $this->hole18  = $hole18;
        }

	
        // Display a table containing details about every record in the database.
        public function displayListScreen() {
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Rounds: Users, Course, and Scores</h3>
                        </div>
                        <div class='row'>
                            <a class='btn btn-primary' onclick='roundsRequest(\"displayCreateScreen\")'>Add Round</a>
                            <table class='table table-striped table-bordered' style='background-color: lightgrey !important'>
                                <thead>
                                    <tr>
										<th>Player</th>
                                        <th>Course Name</th>
										<th>Round Number</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>6</th>
                                        <th>7</th>
                                        <th>8</th>
                                        <th>9</th>
                                        <th>10</th>
                                        <th>11</th>
                                        <th>12</th>
                                        <th>13</th>
                                        <th>14</th>
                                        <th>15</th>
                                        <th>16</th>
                                        <th>17</th>
                                        <th>18</th>
                                    </tr>
                                </thead>
                                <tbody>";                                    
            foreach (Database::prepare('SELECT r.*, p.name, c.courseName
										from tt_rounds r
										inner join tt_persons p
										on r.userID = p.id
										inner join tt_courses c
										on r.courseID = c.id
										order by r.userID, courseID, seqNum', array()) as $row) {
                echo "
                    <tr>
                        <td>{$row['name'] }</td>
                        <td>{$row['courseName'] }</td>
                        <td>{$row['seqNum'] }</td>
                        <td>{$row['hole1'] }</td>
                        <td>{$row['hole2'] }</td>
                        <td>{$row['hole3'] }</td>
                        <td>{$row['hole4'] }</td>
                        <td>{$row['hole5'] }</td>
                        <td>{$row['hole6'] }</td>
                        <td>{$row['hole7'] }</td>
                        <td>{$row['hole8'] }</td>
                        <td>{$row['hole9'] }</td>
                        <td>{$row['hole10'] }</td>
                        <td>{$row['hole11'] }</td>
                        <td>{$row['hole12'] }</td>
                        <td>{$row['hole13'] }</td>
                        <td>{$row['hole14'] }</td>
                        <td>{$row['hole15'] }</td>
                        <td>{$row['hole16'] }</td>
                        <td>{$row['hole17'] }</td>
                        <td>{$row['hole18'] }</td>
                        <td>
                            <button class='btn' onclick='roundsRequest(\"displayRead\", {$row['id']})'>Read</button><br>
                            <button class='btn btn-success' onclick='roundsRequest(\"displayUpdate\", {$row['id']})'>Update</button><br>
                            <button class='btn btn-danger' onclick='roundsRequest(\"displayDelete\", {$row['id']})'>Delete</button>
                        </td>
                    </tr>";
            }
            echo "</tbody></table></div></div></div>";
        }		
        
        // Display a form for adding a record to the database.
        public function displayCreateScreen() {
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Create Round</h3>
                        </div>
                        <div class='form-horizontal'>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->userIDErr))?'':' error') ."'>userID</label>
                                <div class='controls'>
                                    <input id='userID' type='text' required>
                                    <span class='help-inline'>{$this->userIDErr}</span>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->courseIDErr))?'':' error') ."'>courseID</label>
                                <div class='controls'>
                                    <input id='courseID' type='text' required>
                                    <span class='help-inline'>{$this->courseIDErr}</span>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->seqNumErr))?'':' error') ."'>seqNum</label>
                                <div class='controls'>
                                    <input id='seqNum' type='text' required>
                                    <span class='help-inline'>{$this->seqNumErr}</span>
                                </div>
                            </div>`";
							for( $i = 1; $i<19; $i++ ) {
								echo "<div class='control-group'>
											<label class='control-label'>hole" . $i . "</label>
											<div class='controls'>
												<input id='hole" . $i . "' type='text' required>
											</div>
									</div>";
							}			
                            echo "<div class='form-actions'>
                                <button class='btn btn-success' onclick='roundsRequest(\"createRecord\")'>Create</button>
                                <a class='btn' onclick='roundsRequest(\"displayList\")'>Back</a>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        
        // Adds a record to the database.
        public function createRecord() {
            if ($this->validate()) {
                Database::prepare(
                    "INSERT INTO tt_courses (courseName, hole1, hole2, hole3, hole4, hole5, hole6, hole7, hole8,
					hole9, hole10, hole11, hole12, hole13, hole14, hole15, hole16, hole17, hole18)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                    array($this->courseName, $this->hole1, $this->hole2, $this->hole3, $this->hole4, $this->hole5,
					$this->hole6, $this->hole7, $this->hole8, $this->hole9, $this->hole10, $this->hole11,
					$this->hole12, $this->hole13, $this->hole14, $this->hole15, $this->hole16, $this->hole17,
					$this->hole18)
                );
                $this->displayListScreen();
            } else {
                $this->displayCreateScreen();
            }
        }
        
        // Display a form containing information about a specified record in the database.
        public function displayReadScreen() {
            $rec = Database::prepare(
                "SELECT r.*, p.name as Name , c.courseName as Course
										from tt_rounds r
										inner join tt_persons p
										on r.userID = p.id
										inner join tt_courses c
										on r.courseID = c.id
										order by r.userID, courseID, seqNum", 
                array($this->id)
            )->fetch(PDO::FETCH_ASSOC);
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Course Details</h3>
                        </div>
                        <div class='form-horizontal'>
                            <div class='control-group'>
                                <label class='control-label'>Name</label>
                                <div class='controls'>
                                    <label class='checkbox'>
                                        {$rec['Name']}
                                    </label>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label'>Course</label>
                                <div class='controls'>
                                    <label class='checkbox'>
                                        {$rec['Course']}
                                    </label>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label'>seqNum</label>
                                <div class='controls'>
                                    <label class='checkbox'>
                                        {$rec['seqNum']}
                                    </label>
                                </div>
                            </div>";
							for( $i = 1; $i<19; $i++ ) {								
							echo 	"<div class='control-group'>
										<label class='control-label'>hole" . $i . "</label>
										<div class='controls'>
											<label class='checkbox'>
												{$rec['hole' . $i]}
											</label>
										</div>
									</div>";
							}
                            
                            echo "<div class='form-actions'>
                                <a class='btn' onclick='roundsRequest(\"displayList\")'>Back</a>
								</div>
                        </div>
                    </div>
                </div>";
        }
        
        // Display a form for updating a record within the database.
        public function displayUpdateScreen() {
            $rec = Database::prepare(
                "SELECT * FROM tt_rounds WHERE id = ?", 
                array($this->id)
            )->fetch(PDO::FETCH_ASSOC);
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Update Course</h3>
                        </div>
                        <div class='form-horizontal'>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->userIDErr))?'':' error') ."'>userID</label>
                                <div class='controls'>
                                    <input id='userID' type='text' value='{$rec['userID']}' required>
                                    <span class='help-inline'>{$this->userIDErr}</span>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->courseIDErr))?'':' error') ."'>courseID</label>
                                <div class='controls'>
                                    <input id='courseID' type='text' value='{$rec['courseID']}' required>
                                    <span class='help-inline'>{$this->courseIDErr}</span>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label'>seqNum</label>
                                <div class='controls'>
                                    <input id='seqNum' type='text' value='{$rec['seqNum']}' required>
                                </div>
                            </div>";
							
							for( $i = 1; $i<19; $i++ ) {								
							echo 	"<div class='control-group'>
										<label class='control-label'>hole" . $i . "</label>
										<div class='controls'>
											<input id='hole" . $i . "' type='text' value='{$rec['hole' . $i]}' required>
										</div>
									</div>";
							}
							
							
                            echo "<div class='form-actions'>
                                <button class='btn btn-success' onclick='roundsRequest(\"updateRecord\", {$this->id})'>Update</button>
                                <a class='btn' href='../'>Back</a>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        
        // Updates a record within the database.
        public function updateRecord() {
            if ($this->validate()) {
                Database::prepare(
                    "UPDATE tt_courses SET courseName = ?, hole1 = ?, hole2 = ?, hole3 = ?,
					hole4 = ?, hole5 = ?, hole6 = ?, hole7 = ?, hole8 = ?, hole9 = ?,
					hole10 = ?, hole11 = ?, hole12 = ?, hole13 = ?, hole14 = ?, hole15 = ?,
					hole16 = ?, hole17 = ?, hole18 = ? WHERE id = ?",
                    array($this->courseName, $this->hole1, $this->hole2, $this->hole3, $this->hole4, $this->hole5,
					$this->hole6, $this->hole7, $this->hole8, $this->hole9, $this->hole10, $this->hole11,
					$this->hole12, $this->hole13, $this->hole14, $this->hole15, $this->hole16, $this->hole17,
					$this->hole18, $this->id)
                );
                $this->displayListScreen();
            } else {
                $this->displayUpdateScreen();
            }
        }
        
        // Display a form for deleting a record from the database.
        public function displayDeleteScreen() {
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Delete Course</h3>
                        </div>
                        <div class='form-horizontal'>
                            <p class='alert alert-error'>Are you sure you want to delete ?</p>
                            <div class='form-actions'>
                                <button id='submit' class='btn btn-danger' onClick='roundsRequest(\"deleteRecord\", {$this->id});'>Yes</button>
                                <a class='btn' onclick='roundsRequest(\"displayList\")'>Back</a>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        
        // Removes a record from the database.
        public function deleteRecord() {
            Database::prepare(
                "DELETE FROM tt_courses WHERE id = ?",
                array($this->id)
            );
            $this->displayListScreen();
        }
		
		    
        // Display a table containing details about every record in the database.
        public function displayCourses() {
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Courses: courseName and s</h3>
                        </div>
                        <div class='row'>
                            <a class='btn btn-primary' onclick='roundsRequest(\"displayCourseCreate\")'>Add Course</a>
                            <table class='table table-striped table-bordered' style='background-color: lightgrey !important'>
                                <thead>
                                    <tr>
                                        <th>Course courseName</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>6</th>
                                        <th>7</th>
                                        <th>8</th>
                                        <th>9</th>
                                        <th>10</th>
                                        <th>11</th>
                                        <th>12</th>
                                        <th>13</th>
                                        <th>14</th>
                                        <th>15</th>
                                        <th>16</th>
                                        <th>17</th>
                                        <th>18</th>
                                    </tr>
                                </thead>
                                <tbody>";                                    
            foreach (Database::prepare('SELECT * FROM `tt_courses`', array()) as $row) {
                echo "
                    <tr>
                        <td>{$row['courseName'] }</td>
                        <td>{$row['hole1'] }</td>
                        <td>{$row['hole2'] }</td>
                        <td>{$row['hole3'] }</td>
                        <td>{$row['hole4'] }</td>
                        <td>{$row['hole5'] }</td>
                        <td>{$row['hole6'] }</td>
                        <td>{$row['hole7'] }</td>
                        <td>{$row['hole8'] }</td>
                        <td>{$row['hole9'] }</td>
                        <td>{$row['hole10'] }</td>
                        <td>{$row['hole11'] }</td>
                        <td>{$row['hole12'] }</td>
                        <td>{$row['hole13'] }</td>
                        <td>{$row['hole14'] }</td>
                        <td>{$row['hole15'] }</td>
                        <td>{$row['hole16'] }</td>
                        <td>{$row['hole17'] }</td>
                        <td>{$row['hole18'] }</td>
                        <td>
                            <button class='btn' onclick='roundsRequest(\"coursesRead\", {$row['id']})'>Read</button><br>
                            <button class='btn btn-success' onclick='roundsRequest(\"coursesUpdate\", {$row['id']})'>Update</button><br>
                            <button class='btn btn-danger' onclick='roundsRequest(\"coursesDelete\", {$row['id']})'>Delete</button>
                        </td>
                    </tr>";
            }
            echo "</tbody></table></div></div></div>";
        }		
		    
        // Display a table containing details about every record in the database.
        public function displayRounds() {
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Rounds: Users, Course, and Scores</h3>
                        </div>
                        <div class='row'>
                            <a class='btn btn-primary' onclick='roundsRequest(\"displayRoundCreate\")'>Add Round</a>
                            <table class='table table-striped table-bordered' style='background-color: lightgrey !important'>
                                <thead>
                                    <tr>
										<th>Player</th>
                                        <th>Course courseName</th>
										<th>Round Number</th>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>6</th>
                                        <th>7</th>
                                        <th>8</th>
                                        <th>9</th>
                                        <th>10</th>
                                        <th>11</th>
                                        <th>12</th>
                                        <th>13</th>
                                        <th>14</th>
                                        <th>15</th>
                                        <th>16</th>
                                        <th>17</th>
                                        <th>18</th>
                                    </tr>
                                </thead>
                                <tbody>";                                   
            foreach (Database::prepare('SELECT r.*, p.courseName, c.courseName
										from tt_rounds r
										inner join tt_courses p
										on r.userID = p.id
										inner join tt_courses c
										on r.coursesID = c.id
										order by r.userID, coursesID, seqNum', array()) as $row) {
                echo "
                    <tr>
                        <td>{$row['courseName'] }</td>
                        <td>{$row['courseName'] }</td>
                        <td>{$row['seqNum'] }</td>
                        <td>{$row['hole1'] }</td>
                        <td>{$row['hole2'] }</td>
                        <td>{$row['hole3'] }</td>
                        <td>{$row['hole4'] }</td>
                        <td>{$row['hole5'] }</td>
                        <td>{$row['hole6'] }</td>
                        <td>{$row['hole7'] }</td>
                        <td>{$row['hole8'] }</td>
                        <td>{$row['hole9'] }</td>
                        <td>{$row['hole10'] }</td>
                        <td>{$row['hole11'] }</td>
                        <td>{$row['hole12'] }</td>
                        <td>{$row['hole13'] }</td>
                        <td>{$row['hole14'] }</td>
                        <td>{$row['hole15'] }</td>
                        <td>{$row['hole16'] }</td>
                        <td>{$row['hole17'] }</td>
                        <td>{$row['hole18'] }</td>
                        <td>
                            <button class='btn' onclick='roundsRequest(\"coursesRead\", {$row['id']})'>Read</button><br>
                            <button class='btn btn-success' onclick='roundsRequest(\"coursesUpdate\", {$row['id']})'>Update</button><br>
                            <button class='btn btn-danger' onclick='roundsRequest(\"coursesDelete\", {$row['id']})'>Delete</button>
                        </td>
                    </tr>";
            }
            echo "</tbody></table></div></div></div>";
        }
		
        
        // Validates user input.
        private function validate() {
            $valid = true;
            // Check for empty input.
            if (empty($this->courseName)) { 
                $this->courseNameErr = "Please enter a courseName.";
                $valid = false; 
            }
            return $valid;
        }
    }
?>