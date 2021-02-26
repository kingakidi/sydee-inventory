<div class="item" id="item">
    
    <div class="item-link-container" id="item-link-container">
        <div>
            <a href="?p=users" class="item-link" id="viewusers">VIEW USERS</a>
        </div>
        <div>
            <a class="item-link" name="p-link" id="personaldetails">ADD USER</a>
        </div>
    </div>
    <div class="show-item mt-3" id="show-item">
        <?php
        
            // GET ALL REGISTERED USERS 
            $uQuery = mysqli_query($conn, "SELECT * FROM users");
            if (!$uQuery) {
                die("FAILED TO FETCH USERS ".mysqli_error($conn));
            }else if(mysqli_num_rows($uQuery) > 0){
                echo '
                    <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>USERNAME</th>
                            <th>FULLNAME</th>
                            <th>EMAIL ADDRESS</th>
                            <th>PHONE </th>
                            <th>TYPE</th>
                            <th>GENDER</th>
                            <th>STATUS</th>
                   
                            <th>USER TOOLS</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
                $sn = 1;
                while ($row = mysqli_fetch_assoc($uQuery)) {
                    $id = $row['id'];
                    $username = $row['username'];
                    $fullname = ucwords($row['fullname']);
                    $email = $row['email'];
                    $phone = $row['phone'];
                    $gender = ucwords($row['gender']);
                    $type = strtoupper($row['type']);
                    $status = ucwords($row['status']);
                    $date = $row['date'];
                    
                    echo "
                    <tr>
                    <td>$sn </td>
                        <td>$username</td>
                        <td>$fullname</td>
                        <td>$email</td>
                        <td>$phone </td>
                        <td>$type</td>
                        <td>$gender</td>
                        <td>$status</td>
                     
                        <td>
                            <div class='form-group'>
                                <select name='user-tools' id='$id' class='user-tools'>
                                    <option value='' selected>Select Action</option>
                                    <option value='editProfile'>Edit Profile</option>
                                    <option value='role'>Change Role</option>
                                    <option value='toggleActivation'>Toggle Activation</option>
                                    <option value='assign'>Assign </option>
                                    <option value='chart'>View Chart</option>
                                    <option value='log'>Logs</option>
                                    <option value='changeEmail'>Change Email</option>
                                </select>
                            </div>
                        </td>
                   </tr>
                    
                    ";
                    $sn++;
                }
                echo ' </tbody>
                </table>';
            }else{
                echo "<span class='text-primary'>NO USER IN DB</span>";
            }
        ?>
    </div>
</div>