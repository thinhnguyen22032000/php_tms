<div class="card">
    <div class="card-body">
        <div class="card-body" style="width: 100%">
            <div class="table-responsive" style="width: 100%">
                <table class="table table table-bordered">
                    <thead class="col-md-12 col-lg-12 col-sm-12">
                        <tr class="text-center">
                            <th>No</th>
                            <th>User id</th>
                            <th>Query</th>
                            <!-- <th >Result</th> -->
                            <th >Created_at</th>
                        </tr>
                    </thead>
                    <tbody id='table-data'>
                        <?php
                        $idx = 0;
                        foreach ($data['log'] as $log) { ?>
                            <tr>
                                <th scope="row"><?= ++$idx ?></th>
                                <td><?= $log['user_id'] ?></td>
                                <td><code>
                                <?= $log['query'] ?>
                                </code></td>
                                <!-- <td><?= $log['result'] ?></td> -->
                                <td><?= $log['created_at'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>