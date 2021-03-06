<?php
    require_once("database.php");
    require_once("table.php");
    
    class Persons implements Table {
        // DATA MEMBERS
        private $id;
        private $name;
        private $nameErr;
        private $email;
        private $emailErr;
        private $mobile;
        private $mobileErr;
        
        // CONSTRUCTOR
        function __construct($id, $name, $email, $mobile) {
            $this->id     = $id;
            $this->name   = $name;
            $this->email  = $email;
            $this->mobile = $mobile;
        }

	
        // Display a table containing details about every record in the database.
        public function displayListScreen() {
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Persons</h3>
                        </div>
                        <div class='row'>
                            <a class='btn btn-primary' onclick='personsRequest(\"displayCreate\")'>Add Person</a>
                            <table class='table table-striped table-bordered' style='background-color: lightgrey !important'>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>";                                    
            foreach (Database::prepare('SELECT * FROM `tt_persons`', array()) as $row) {
                echo "
                    <tr>
                        <td>{$row['name']  }</td>
                        <td>{$row['email'] }</td>
                        <td>{$row['mobile']}</td>
                        <td>
                            <button class='btn' onclick='personsRequest(\"displayRead\", {$row['id']})'>Read</button><br>
                            <button class='btn btn-success' onclick='personsRequest(\"displayUpdate\", {$row['id']})'>Update</button><br>
                            <button class='btn btn-danger' onclick='personsRequest(\"displayDelete\", {$row['id']})'>Delete</button>
                        </td>
                    </tr>";
            }
            echo "</tbody></table></div>
                            <div class='form-actions'>
                                <a class='btn' href='../'>Back</a>
                            </div></div></div>";
        }
        
        // Display a form for adding a record to the database.
        public function displayCreateScreen() {
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Create Persons</h3>
                        </div>
                        <div class='form-horizontal'>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->nameErr))?'':' error') ."'>name</label>
                                <div class='controls'>
                                    <input id='name' type='text' required>
                                    <span class='help-inline'>{$this->nameErr}</span>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->emailErr))?'':' error') ."'>email</label>
                                <div class='controls'>
                                    <input id='email' type='text' placeholder='name@svsu.edu' required>
                                    <span class='help-inline'>{$this->emailErr}</span>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->mobileErr))?'':' error') ."'>mobile</label>
                                <div class='controls'>
                                    <input id='mobile' type='text' placeholder='555-5555-555' required>
                                    <span class='help-inline'>{$this->mobileErr}</span>
                                </div>
                            </div>
                            <div class='form-actions'>
                                <button class='btn btn-success' onclick='personsRequest(\"createRecord\")'>Create</button>
                                <a class='btn' onclick='personsRequest(\"displayList\")'>Back</a>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        
        // Adds a record to the database.
        public function createRecord() {
            if ($this->validate()) {
                Database::prepare(
					"INSERT INTO tt_persons (name, email, mobile) VALUES (?,?,?)",
                    array($this->name, $this->email, $this->mobile)
                );
                $this->displayListScreen();
            } else {
                $this->displayCreateScreen();
            }
        }
        
        // Display a form containing information about a specified record in the database.
        public function displayReadScreen() {
            $rec = Database::prepare(
                "SELECT * FROM tt_persons WHERE id = ?", 
                array($this->id)
            )->fetch(PDO::FETCH_ASSOC);
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Person Details</h3>
                        </div>
                        <div class='form-horizontal'>
                            <div class='control-group'>
                                <label class='control-label'>name</label>
                                <div class='controls'>
                                    <label class='checkbox'>
                                        {$rec['name']}
                                    </label>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label'>email</label>
                                <div class='controls'>
                                    <label class='checkbox'>
                                        {$rec['email']}
                                    </label>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label'>mobile</label>
                                <div class='controls'>
                                    <label class='checkbox'>
                                        {$rec['mobile']}
                                    </label>
                                </div>
                            </div>
                            <div class='form-actions'>
                                <a class='btn' onclick='personsRequest(\"displayList\")'>Back</a>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        
        // Display a form for updating a record within the database.
        public function displayUpdateScreen() {
            $rec = Database::prepare(
                "SELECT * FROM tt_persons WHERE id = ?", 
                array($this->id)
            )->fetch(PDO::FETCH_ASSOC);
            echo "
                <div class='container'>
                    <div class='span10 offset1'>
                        <div class='row'>
                            <h3>Update Person</h3>
                        </div>
                        <div class='form-horizontal'>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->nameErr))?'':' error') ."'>name</label>
                                <div class='controls'>
                                    <input id='name' type='text' value='{$rec['name']}' required>
                                    <span class='help-inline'>{$this->nameErr}</span>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->emailErr))?'':' error') ."'>email</label>
                                <div class='controls'>
                                    <input id='email' type='text' value='{$rec['email']}' required>
                                    <span class='help-inline'>{$this->emailErr}</span>
                                </div>
                            </div>
                            <div class='control-group'>
                                <label class='control-label". ((empty($this->mobileErr))?'':' error') ."'>mobile</label>
                                <div class='controls'>
                                    <input id='mobile' type='text' value='{$rec['mobile']}' required>
                                    <span class='help-inline'>{$this->mobileErr}</span>
                                </div>
                            </div>
                            <div class='form-actions'>
                                <button class='btn btn-success' onclick='personsRequest(\"updateRecord\", {$this->id})'>Update</button>
                                <a class='btn' onclick='personsRequest(\"displayList\")'>Back</a>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        
        // Updates a record within the database.
        public function updateRecord() {
            if ($this->validate()) {
                Database::prepare(
                    "UPDATE tt_persons SET name = ?, email = ?, mobile = ? WHERE id = ?",
                    array($this->name, $this->email, $this->mobile, $this->id)
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
                            <h3>Delete Person</h3>
                        </div>
                        <div class='form-horizontal'>
                            <p class='alert alert-error'>Are you sure you want to delete ?</p>
                            <div class='form-actions'>
                                <button id='submit' class='btn btn-danger' onClick='personsRequest(\"deleteRecord\", {$this->id});'>Yes</button>
                                <a class='btn' onclick='personsRequest(\"displayList\")'>Back</a>
                            </div>
                        </div>
                    </div>
                </div>";
        }
        
        // Removes a record from the database.
        public function deleteRecord() {
            Database::prepare(
                "DELETE FROM tt_persons WHERE id = ?",
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
                            <h3>Courses: Name and Pars</h3>
                        </div>
                        <div class='row'>
                            <a class='btn btn-primary' onclick='personsRequest(\"displayCourseCreate\")'>Add Course</a>
                            <table class='table table-striped table-bordered' style='background-color: lightgrey !important'>
                                <thead>
                                    <tr>
                                        <th>Course Name</th>
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
                            <button class='btn' onclick='courseRequest(\"courseRead\", {$row['id']})'>Read</button><br>
                            <button class='btn btn-success' onclick='courseRequest(\"courseUpdate\", {$row['id']})'>Update</button><br>
                            <button class='btn btn-danger' onclick='courseRequest(\"courseDelete\", {$row['id']})'>Delete</button>
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
                            <a class='btn btn-primary' onclick='personsRequest(\"displayRoundCreate\")'>Add Round</a>
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
                            <button class='btn' onclick='courseRequest(\"courseRead\", {$row['id']})'>Read</button><br>
                            <button class='btn btn-success' onclick='courseRequest(\"courseUpdate\", {$row['id']})'>Update</button><br>
                            <button class='btn btn-danger' onclick='courseRequest(\"courseDelete\", {$row['id']})'>Delete</button>
                        </td>
                    </tr>";
            }
            echo "</tbody></table></div></div></div>";
        }
		
        
        // Validates user input.
        private function validate() {
            $valid = true;
            // Validate Mobile
            if (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $this->mobile)) {
                $this->mobileErr = "Please enter a valid phone number.";
                $valid = false;
            }
            // Validate Email
            if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                $this->emailErr = "Please enter a valid email address.";
                $valid = false;
            }
            // Check for empty input.
            if (empty($this->name)) { 
                $this->nameErr = "Please enter a name.";
                $valid = false; 
            }
            if (empty($this->email)) { 
                $this->emailErr = "Please enter an email.";
                $valid = false; 
            }
            if (empty($this->mobile)) { 
                $this->mobileErr = "Please enter a phone number.";
                $valid = false; 
            } print_r($valid);
            return $valid;
        }
    }
?>