<?php 
$row = $data['data'];
$roles = $data['roles'];
?>
<form action="/php/user/update/<?php echo $row['id'] ?>" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $row['username'] ?>" placeholder="Enter username">
    </div>
    <select class="form-select" name="id_role" aria-label="Default select example">
        <?php 
            foreach($roles as $role){ 
                if($row['id_role'] == $role['id']){
                ?>
                 <option selected value="<?=$role['id']?>"><?=$role['role_name']?></option>
            <?php
                }else{ 
                ?>
                 <option value="<?=$role['id']?>"><?=$role['role_name']?></option>
            <?php           
                }
            ?>                   
        <?php
            }
        ?>
    </select>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" name="password" value="<?php echo $row['password'] ?>" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>