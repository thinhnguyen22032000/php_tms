<?php
if (isset($_SESSION['notify'])) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Notify!</strong> <?= $_SESSION['notify'] ?>.
        <a href="#" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </a>
    </div>
<?php
    unset($_SESSION['notify']);
}
?>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Request Management </h2>           
        </div>
    </div>
</div>
<main style="min-height: 91vh ;">
    <div class="card">
        <div class="card-body">
            <form>
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-sm-6">
                        <label class="control-label">Times request from</label>
                        <input type="date" name="start_date" id="start-date" class="form-control" />
                        <div class="invalid-feedback">
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6">
                        <label class="control-label">Times request to</label>
                        <input type="date" name="end_date" id="end-date" class="form-control" />
                        <div class="invalid-feedback">
                        </div>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6">
                        <label class="mdb-main-label">Request Type</label>
                        <select style="width: 100%" id="request-type" name="request_type[]" class="multiple-select form-control" multiple>
                        </select>
                    </div>
                    <div class="col-md-3 col-lg-3 col-sm-6">
                        <label class="mdb-main-label">Request Status</label>
                        <select style="width: 100%" name="request_status[]" class="multiple-select form-control" multiple>
                            <option value="submitted">Submitted</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-9 col-lg-9 col-sm-6"></div>
                    <div class="col-md-3 col-ld-3 col-sm-6 text-right">
                        <button id="submit" class="btn btn-primary mt-2">
                            Search
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-body" style="width: 100%">
                <div class="table-responsive" style="width: 100%">
                    <table class="table table table-bordered">
                        <thead class="col-md-12 col-lg-12 col-sm-12">
                            <tr class="text-center">
                                <th class="th-lg">No</th>
                                <th class="th-lg">Request Type</th>
                                <th class="th-lg">Account</th>
                                <th class="th-lg">Time Request</th>
                                <th class="th-lg">Duration (Days)</th>
                                <th class="th-lg">Reason</th>
                                <th class="th-lg">Confirm</th>
                                <th class="th-lg">Status</th>
                                <th class="th-lg">Created at</th>
                            </tr>
                        </thead>
                        <tbody id='table-data'>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<div id="modal-edit"></div>

<script>
    function renderModal(data) {
        document.querySelector('#modal-edit').innerHTML = `
          <div class="modal-data">
                <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Time Off (Leave) Requests and Balances in 2022</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                ${data?.status == 'submitted'?
                     `<div class="mb-2">
                        <a href="<?= $GLOBALS['url'] ?>/request/edit/${data.id}" type="button" class="btn" style="background-color: #008299; color: #fff">EDIT</a>
                        <a href="<?= $GLOBALS['url'] ?>/request/request_stutus_change/${data.id}/cancelled" type="button" class="btn" style="background-color: #FAB05F; color: #fff">CANCEL</a>
                </div>`
                     : ''}
                <table class="table">
                    <tbody>
                        <tr>
                            <th scope="row">Requester</th>
                            <td>${data.fullname}</td>
                        </tr>
                        <tr>
                            <th scope="row">Request Type</th>
                            <td>${data.name}</td>
                        </tr>
                        <tr>
                            <th scope="row">Status</th>
                            <td>${data.status || 'Error(connect with admin ....)'}</td>
                        </tr>
                        <tr>
                            <th scope="row">Start Date</th>
                            <td>${data.start_date}</td>
                        </tr>
                        <tr>
                            <th scope="row">End Date</th>
                            <td>${data.end_date}</td>
                        </tr>
                        <tr>
                            <th scope="row">Total Day Duration</th>
                            <td>${data.duration} day</td>
                        </tr>
                        <tr>
                            <th scope="row">Reason</th>
                            <td>${data.content||'Other'}</td>
                        </tr>
                        <tr>
                            <th scope="row">Detail Reason</th>
                            <td>${data.detail_reason || 'None'}</td>
                        </tr>
                        <tr>
                            <th scope="row">Approver</th>
                            <td><?= $_SESSION['user_info']['approver'] ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Supervisor</th>
                            <td><?= $_SESSION['user_info']['supervisor'] ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Expected approve</th>
                            <td>${data.expected_date}</td>
                        </tr>
                        <tr>
                            <th scope="row">Last modify</th>
                            <td>${data.last_modify}</td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
             </div>
           </div>
        </div>
        `;
    }

    function apiGetRequest(request_id) {
        fetch(`http://localhost/mini_project_2/request/get/${request_id}`)
            .then((response) => response.json())
            .then((data) => {
                console.log(data)
                const request = data[0]
                renderModal(request)
                $('#exampleModal').modal('show')
            });
    }

    function handleModalEdit(user_id) {
        apiGetRequest(user_id)
    }
</script>

<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', (event) => {
        const app = {
            init() {
                this.api.getRequestUser();
                this.api.getRequestType();
                this.listen.start();
            },
            untils: {
                renderHtml(data) {
                    $('#table-data').empty();
                    if (data.length === 0) {
                        $('#table-data').append(`<h5 class="mt-2">Not founds data</h5>`)
                    }else{
                        let i = 0;
                        for (let item of data ) {
                            $('#table-data').append(`
                        <tr>
                            <td>${++i}</td>
                            <td>
                                <h6 class="m-0">${item.name}</h6>
                            </td>
                            <td>${item.fullname}</td>
                            <td>${item.start_date + ' - ' + item.end_date} <br> On ${item.partial_day == 'all'?'All Day': 'Part Day'}</td>
                            <td>${item.duration}</td>
                            <td>${item.content || item.detail_reason}</td>
                            <td>
                            ${item.status == 'submitted' ? 
                                `<a onclick="return confirm('Are you sure?')" class="text-primary" style="text-decoration: underline" href="<?= $GLOBALS['url'] ?>/request/request_stutus_change/${item.id}/confirmed">confirm</a>`:''}
                            </td>
                            <td>${item.status}</td>
                            <td>${item.created_at}</td>
                        </tr>                  
                        `)
                        }
                    }
                },
                differrenceDate(start, end) {
                    let startDate = new Date(start);
                    let endDate = new Date(end);
                    return endDate - startDate;
                }
            },
            listen: {
                start() {
                    this.event();
                },
                event() {
                    $("#submit").click(function(e) {
                        e.preventDefault()
                        const request_type = $('select[name="request_type[]"]').val();
                        const request_status = $('select[name="request_status[]"]').val();
                        const start_date = $('input[name="start_date"]').val();
                        const end_date = $('input[name="end_date"]').val();
                        const start = $('#start-date').val();
                        const end = $('#end-date').val();
                        if(start && end){
                            const dif = app.untils.differrenceDate(start, end)
                            if(dif < 0){
                                $('#start-date').addClass('is-invalid')
                                $('#end-date').addClass('is-invalid')
                                return
                            }
                        }
                        $('#start-date').removeClass('is-invalid')
                        $('#end-date').removeClass('is-invalid')
                        app.api.search(request_type, request_status, start_date, end_date);
                    })
                }
            },

            api: {
                getRequestUser() {
                    fetch(`http://localhost/mini_project_2/request/user_request`)
                        .then((response) => response.json())
                        .then((data) => {
                            // $('#reasons').empty();
                            console.log(data)
                            app.untils.renderHtml(data)
                        });
                },
                getRequestType() {
                    fetch('http://localhost/mini_project_2/requesttype/request_type')
                        .then((response) => response.json())
                        .then((data) => {
                            for (let i = 0; i < data.length; i++) {
                                $('#request-type').append(`<option value="${data[i].id}">${data[i].name}</option>`)
                            }
                        });
                },
                search(request_type, request_status, start_date, end_date) {
                    var formData = new FormData();
                    formData.append('request_type', request_type);
                    formData.append('request_status', request_status);
                    formData.append('start_date', start_date);
                    formData.append('end_date', end_date);
                    fetch(`http://localhost/mini_project_2/request/request_search_supervisor`, {
                            method: 'POST', // or 'PUT'
                            body: formData,
                        })
                        .then((response) => response.json())
                        .then((data) => {  
                           app.untils.renderHtml(data);
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                }
            }
        }
        app.init()

    })
</script>