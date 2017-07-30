<?php
    require_once("database.php");
    require_once("table.php");
    
    class Courses implements Table {
        // DATA MEMBERS
        private $id;
        private $courseName;
        private $courseNameErr;
        
        // CONSTRUCTOR
        function __construct($id, $courseName, $holePar1, $holePar2, $holePar3, $holePar4, $holePar5, $holePar6, $holePar7,
											$holePar8, $holePar9, $holePar10, $holePar11, $holePar12, $holePar13, $holePar14,
											$holePar15, $holePar16, $holePar17, $holePar18) {
            $this->id     = $id;
            $this->courseName   = $courseName;
            $this->holePar1  = $holePar1;
            $this->holePar2  = $holePar2;
            $this->holePar3  = $holePar3;
            $this->holePar4  = $holePar4;
            $this->holePar5  = $holePar5;
            $this->holePar6  = $holePar6;
            $this->holePar7  = $holePar7;
            $this->holePar8  = $holePar8;
            $this->holePar9  = $holePar9;
            $this->holePar10  = $holePar10;
            $this->holePar11  = $holePar11;
            $this->holePar12  = $holePar12;
            $this->holePar13  = $holePar13;
            $this->holePar14  = $holePar14;
            $this->holePar15  = $holePar15;
            $this->holePar16  = $holePar16;
            $this->holePar17  = $holePar17;
            $this->holePar18  = $holePar18;
        }

	
        // Display a table containing details about every record in the database.
        public function displayListScreen() {
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Courses: courseName and Pars</h3>
                        </div>
                        <div class='row'>
                            <a class='btn btn-primary' onclick='coursesRequest(\"displayCreate\")'>Add Course</a>
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
                        <td>{$row['holePar1'] }</td>
                        <td>{$row['holePar2'] }</td>
                        <td>{$row['holePar3'] }</td>
                        <td>{$row['holePar4'] }</td>
                        <td>{$row['holePar5'] }</td>
                        <td>{$row['holePar6'] }</td>
                        <td>{$row['holePar7'] }</td>
                        <td>{$row['holePar8'] }</td>
                        <td>{$row['holePar9'] }</td>
                        <td>{$row['holePar10'] }</td>
                        <td>{$row['holePar11'] }</td>
                        <td>{$row['holePar12'] }</td>
                        <td>{$row['holePar13'] }</td>
                        <td>{$row['holePar14'] }</td>
                        <td>{$row['holePar15'] }</td>
                        <td>{$row['holePar16'] }</td>
                        <td>{$row['holePar17'] }</td>
                        <td>{$row['holePar18'] }</td>
                        <td>
                            <button class='btn' onclick='coursesRequest(\"displayRead\", {$row['id']})'>Read</button><br>
                            <button class='btn btn-success' onclick='coursesRequest(\"displayUpdate\", {$row['id']})'>Update</button><br>
                            <button class='btn btn-danger' onclick='coursesRequest(\"displayDelete\", {$row['id']})'>Delete</button>
                        </td>
                    </tr>";
            }
            echo "</tbody></table></div><div class='form-actions'>
                                <a class='btn' href='../'>Back</a></div></div>";
        }		
        
        // Display a form for adding a record to the database.
        public function displayCreateScreen() {
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Create Courses</h3>
                        </div>
                        <div class='form-horizontal'>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->courseNameErr))?'':' error') ."'>courseName</label>
                                <div class='controls'>
                                    <input id='courseName' type='text' required>
                                    <span class='help-inline'>{$this->courseNameErr}</span>
                                </div>
                            </div>";
							for( $i = 1; $i<19; $i++ ) {
								echo "<div class='control-group'>
											<label class='control-label'>holePar" . $i . "</label>
											<div class='controls'>
												<input id='holePar" . $i . "' type='text' required>
											</div>
									</div>";
							}			
                            echo "<div class='form-actions'>
                                <button class='btn btn-success' onclick='coursesRequest(\"createRecord\")'>Create</button>
                                <a class='btn' onclick='coursesRequest(\"displayList\")'>Back</a>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        
        // Adds a record to the database.
        public function createRecord() {
            if ($this->validate()) {
                Database::prepare(
                    "INSERT INTO tt_courses (courseName, holePar1, holePar2, holePar3, holePar4, holePar5, holePar6, holePar7, holePar8,
					holePar9, holePar10, holePar11, holePar12, holePar13, holePar14, holePar15, holePar16, holePar17, holePar18)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                    array($this->courseName, $this->holePar1, $this->holePar2, $this->holePar3, $this->holePar4, $this->holePar5,
					$this->holePar6, $this->holePar7, $this->holePar8, $this->holePar9, $this->holePar10, $this->holePar11,
					$this->holePar12, $this->holePar13, $this->holePar14, $this->holePar15, $this->holePar16, $this->holePar17,
					$this->holePar18)
                );
                $this->displayListScreen();
            } else {
                $this->displayCreateScreen();
            }
        }
        
        // Display a form containing information about a specified record in the database.
        public function displayReadScreen() {
            $rec = Database::prepare(
                "SELECT * FROM tt_courses WHERE id = ?", 
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
                                <label class='control-label'>courseName</label>
                                <div class='controls'>
                                    <label class='checkbox'>
                                        {$rec['courseName']}
                                    </label>
                                </div>
                            </div>";
							for( $i = 1; $i<19; $i++ ) {								
							echo 	"<div class='control-group'>
										<label class='control-label'>holePar" . $i . "</label>
										<div class='controls'>
											<label class='checkbox'>
												{$rec['holePar' . $i]}
											</label>
										</div>
									</div>";
							}
                            
                            echo "<div class='form-actions'>
                                <a class='btn' onclick='coursesRequest(\"displayList\")'>Back</a>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        
        // Display a form for updating a record within the database.
        public function displayUpdateScreen() {
            $rec = Database::prepare(
                "SELECT * FROM tt_courses WHERE id = ?", 
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
                                <label class='control-label". ((empty($this->courseNameErr))?'':' error') ."'>courseName</label>
                                <div class='controls'>
                                    <input id='courseName' type='text' value='{$rec['courseName']}' required>
                                    <span class='help-inline'>{$this->courseNameErr}</span>
                                </div>
                            </div>";
							
							for( $i = 1; $i<19; $i++ ) {								
							echo 	"<div class='control-group'>
										<label class='control-label'>holePar" . $i . "</label>
										<div class='controls'>
											<input id='holePar" . $i . "' type='text' value='{$rec['holePar' . $i]}' required>
										</div>
									</div>";
							}
							
							
                            echo "<div class='form-actions'>
                                <button class='btn btn-success' onclick='coursesRequest(\"updateRecord\", {$this->id})'>Update</button>
                                <a class='btn' onclick='coursesRequest(\"displayList\")'>Back</a>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        
        // Updates a record within the database.
        public function updateRecord() {
            if ($this->validate()) {
                Database::prepare(
                    "UPDATE tt_courses SET courseName = ?, holePar1 = ?, holePar2 = ?, holePar3 = ?,
					holePar4 = ?, holePar5 = ?, holePar6 = ?, holePar7 = ?, holePar8 = ?, holePar9 = ?,
					holePar10 = ?, holePar11 = ?, holePar12 = ?, holePar13 = ?, holePar14 = ?, holePar15 = ?,
					holePar16 = ?, holePar17 = ?, holePar18 = ? WHERE id = ?",
                    array($this->courseName, $this->holePar1, $this->holePar2, $this->holePar3, $this->holePar4, $this->holePar5,
					$this->holePar6, $this->holePar7, $this->holePar8, $this->holePar9, $this->holePar10, $this->holePar11,
					$this->holePar12, $this->holePar13, $this->holePar14, $this->holePar15, $this->holePar16, $this->holePar17,
					$this->holePar18, $this->id)
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
                                <button id='submit' class='btn btn-danger' onClick='coursesRequest(\"deleteRecord\", {$this->id});'>Yes</button>
                                <a class='btn' onclick='coursesRequest(\"displayList\")'>Back</a>
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
                            <h3>Courses: courseName and Pars</h3>
                        </div>
                        <div class='row'>
                            <a class='btn btn-primary' onclick='coursesRequest(\"displayCourseCreate\")'>Add Course</a>
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
                        <td>{$row['holePar1'] }</td>
                        <td>{$row['holePar2'] }</td>
                        <td>{$row['holePar3'] }</td>
                        <td>{$row['holePar4'] }</td>
                        <td>{$row['holePar5'] }</td>
                        <td>{$row['holePar6'] }</td>
                        <td>{$row['holePar7'] }</td>
                        <td>{$row['holePar8'] }</td>
                        <td>{$row['holePar9'] }</td>
                        <td>{$row['holePar10'] }</td>
                        <td>{$row['holePar11'] }</td>
                        <td>{$row['holePar12'] }</td>
                        <td>{$row['holePar13'] }</td>
                        <td>{$row['holePar14'] }</td>
                        <td>{$row['holePar15'] }</td>
                        <td>{$row['holePar16'] }</td>
                        <td>{$row['holePar17'] }</td>
                        <td>{$row['holePar18'] }</td>
                        <td>
                            <button class='btn' onclick='coursesRequest(\"coursesRead\", {$row['id']})'>Read</button><br>
                            <button class='btn btn-success' onclick='coursesRequest(\"coursesUpdate\", {$row['id']})'>Update</button><br>
                            <button class='btn btn-danger' onclick='coursesRequest(\"coursesDelete\", {$row['id']})'>Delete</button>
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
                            <a class='btn btn-primary' onclick='coursesRequest(\"displayRoundCreate\")'>Add Round</a>
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
                            <button class='btn' onclick='coursesRequest(\"coursesRead\", {$row['id']})'>Read</button><br>
                            <button class='btn btn-success' onclick='coursesRequest(\"coursesUpdate\", {$row['id']})'>Update</button><br>
                            <button class='btn btn-danger' onclick='coursesRequest(\"coursesDelete\", {$row['id']})'>Delete</button>
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