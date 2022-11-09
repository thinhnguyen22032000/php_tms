<a href="/php/user/create" class="btn btn-primary" role="button" aria-pressed="true">
    <i class="fa fa-plus"></i> Create
</a>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Username</th>
            <th scope="col">Password</th>
            <th scope="col">Role</th>
            <th scope="col">Handle</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $idx = 1;
        $rows = $data["data"];
        foreach ($rows as $item) { ?>
            <tr>
                <th scope="row"><?php echo $idx ?></th>
                <td><?php echo $item['username'] ?></td>
                <td><?php echo $item['password'] ?></td>
                <td>
                    <?php echo $item['id_role'] == 1 ? 'Admin' : 'User' ?>
                </td>
                <td>
                    <a href="/php/user/detail/<?php echo $item['id'] ?>" class="btn btn-danger">Edit</a>
                    <a onclick="return confirm('You want delete user?')" class="btn btn-warning" href="./delete/<?php echo $item['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php
            $idx++;
        }
        ?>

    </tbody>
</table>