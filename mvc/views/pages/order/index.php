<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }
</style>
<!-- title -->
<div class="alert alert-info p-2" role="alert">
    <h5><?= $lang['TITLE_ORDER'] ?></h5>
</div>
<!-- Name input -->
<div class="mb-4">
    <form class="mb-4" method="post" action="<?= Domain::get() . '/order/create' ?>" id="form-order">
        <table>
            <tr>
                <td><?= $lang['FRM_FOOD_NAME'] ?> (*)</td>
                <td>
                    <input type="text" name="food_name" class="w-100" />
                </td>
            </tr>
            <tr>
                <td><?= $lang['FRM_NOTE'] ?></td>
                <td>
                    <input type="text" name="note" class="w-100" />
                </td>
            </tr>
            <tr>
                <td><?= $lang['FRM_SP_ORDER'] ?></td>
                <td>
                    <input type="checkbox" id="checkbox" />
                    <label class="form-check-label">
                        Checked switch checkbox input
                    </label>
                </td>
            </tr>
            <tr>
                <td id="lable-sp-order"><?= $lang['FRM_ORDERER'] ?><span id="require"></span></td>
                <td>
                    <input id="orderSuport" name="orderer" type="text" disabled />
                </td>
            </tr>
        </table>
    </form>
    <div class="w-3 d-flex justify-content-center">
        <button type="button" class="btn btn-primary mr-2 col-2" id="btn-submit-order-form">
            <?= $lang['FRM_BTN_ORDER'] ?></button>
        <button type="button" class="btn btn-success ml-2 col-2" id="btn-clear-order-form">
            <?= $lang['FRM_BTN_RESET'] ?></button>
    </div>
</div>

<!-- table -->
<div class="alert alert-info p-2" role="alert">
    <h5><?= $lang['TBL_LIST'] ?>
        (<?= $data['configPaginate']['numCurrentItem'] ?> / <?= $data['configPaginate']['totalRow'] ?> <?= $lang['TBL_ROW'] ?>)</h5>
</div>
<div class="mb-2">
</div>
<div style="margin-bottom: 50px">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col"><?= $lang['TBL_ORDERER'] ?></th>
                <th scope="col"><?= $lang['TBL_FOOD_NAME'] ?></th>
                <th scope="col"><?= $lang['TBL_NOTE'] ?></th>
                <th scope="col"><?= $lang['TBL_CREATED']?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $idx = 0;
            foreach ($data['orders'] as $order) { ?>
                <tr>
                    <th scope="row"><?= ++$idx ?></th>
                    <td><?= $order['orderer'] ?></td>
                    <td><?= $order['food_name'] ?></td>
                    <td><?= $order['note'] ?></td>
                    <td><?= $order['created_at'] ?></td>
                </tr>
            <?php
            }
            ?>

        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php
            for ($i = 1; $i <= $data['configPaginate']['countPage']; $i++) { ?>
                <li class="page-item"><a class="page-link <?=$data['configPaginate']['currentPage']==$i?'border border-secondary':''?>" href="http://localhost/mini_project/order/index/<?= $i ?>"><?= $i ?></a></li>
            <?php
            }
            ?>
        </ul>
    </nav>
</div>

<script>
    const $ = document.querySelector.bind(document);
    const $$ = document.querySelectorAll.bind(document);

    const requireEle = $('#require');
    const checkBoxEle = $("#checkbox");
    const orderSPEle = $("#orderSuport");

    checkBoxEle.addEventListener('change', function() {

        orderSPEle.disabled = !this.checked;
        this.checked ? requireEle.innerText = ' (*)' : requireEle.innerText = null;
        if(!this.checked){
            orderSPEle.value = '';
        }
    })

    // submit form
    $('#btn-submit-order-form').addEventListener('click', function() {
        $('#form-order').submit();
    })
    //clear form
    $('#btn-clear-order-form').addEventListener('click', function() {
        $$('input[type="text"]').forEach(function(ele) {
            ele.value = '';
        });
        checkBoxEle.checked = false;
        requireEle.innerText = null;
        orderSPEle.disabled = true;

    })
</script>