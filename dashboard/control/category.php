<div class="item" id="item">
    
    <div class="item-link-container" id="item-link-container">
        <div>
            <a href="?p=category" class="item-link" id="category">CATEGORY</a>
        </div>
        <div>
            <a class="item-link" name="p-link" id="add-category">ADD CATEGORY</a>
        </div>
      
        <div>
            <a class="item-link" name="p-link" id="sub-category">SUB CATEGORY</a>
        </div>
        
        
        
    </div>
    <div class="show-item mt-3" id="show-item">
            <?php 
                $categoryQuery = mysqli_query($conn, "SELECT * FROM category");
                if (!$categoryQuery) {
                    die("FAILED ");
                }else{
                    echo '
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>NAME</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                    ';
                    $sn = 1;
                    while ($row = mysqli_fetch_assoc($categoryQuery)) {
                        $id = $row['id'];
                        $cName = ucwords($row['category_name']);
                        echo "<tr>
                                <td>$sn </td>
                                <td>$cName </td>
                                <td><button class='btn btn-info' id='$id' name='edit-category'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></button>
                               </td>
                            </tr>
                        ";
                        $sn++;
                    }
                }
            ?>
    </div>
</div>


    </tbody>
</table>

