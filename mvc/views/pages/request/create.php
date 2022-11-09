<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
            <h2 class="pageheader-title">Create request </h2>           
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="msg-error"></div>
        <div class="card">
            <div class="form-group row ml-2">
                <div class="col col-sm-10 col-lg-9 offset-sm-1 offset-lg-0 mt-2">
                    <button type="submit" id="btn-submit" class="btn btn-space btn-primary">Submit</button>
                    <a href="<?= $GLOBALS['url'] ?>/request" class="btn btn-space btn-secondary">Cancel</a>
                </div>
            </div>
            <!-- <h5 class="card-header">Basic Form</h5> -->
            <form id="form" class="card-body" method="post" action="<?= $GLOBALS['url'] ?>/request/store">
                <a data-toggle="modal" data-target="#exampleModal" style="cursor: pointer">
                    <h5>Time Off (Leave) Requests and Balances</h5>
                </a>
                <div class="row">

                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="inputEmail">Request Type</label> <span class="required" style="color: red">*</span>
                            <select class="form-select form-control" id="request-type" name="request_type_id">
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 mt-3 mb-3 d-none" style="color: #629629" id="no-salary-policy">
                        Thời gian nghỉ không lương từ 14 ngày làm việc trở lên thì thời gian nghỉ đó CBNV không được hưởng các khoản hỗ trợ phục vụ cho công việc, các chế độ (FPTcare, lương tháng 13, BHXH, BHYT, BHTN, ..), và không được tính thâm niên công tác. Nghỉ không lương tối đa 1 tháng, nếu nghỉ hơn thì chuyển sang "Tạm hoãn Hợp đồng". Trong thời gian NKL/Tạm hoãn nếu có đóng BHXH ở nơi khác thì cần phải báo cho SSC để tránh bị ghi nhận trùng quà trình đóng và khó khăn cho việc chốt sổ BHXH. Nếu nhân viên nghỉ không lương > 14 ngày làm việc của tháng N+1 thì phải log đơn nghỉ và có phê duyệt trước ngày 28 của tháng N (ví dụ: nghỉ từ ngày 14/10 thì phải log đơn và xin phê duyệt trước ngày 28/9), trong trường hợp nhân viên log đơn nghỉ muộn thì sẽ bị truy thu chi phí BHYT của các tháng tương ứng 4.5% lương BH. Nếu nhân viên có thay đổi đơn nghỉ không lương (hủy, cập ngày nghỉ) thông báo cho SSC (HN: NgocPH2, HCM/CT: ThuyNT48, DN/QNH: LyLT2) trước ngày 10 của tháng hiện tại để kịp thời cập nhật bảng lương. Nếu sau ngày 10 thì sẽ được bù lương vào tháng tiếp theo.
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="inputEmail">Start Date</label> <span class="required" style="color: red">*</span>
                            <input id="start-date" type="date" name="start_date" class="form-control">
                            <div class="invalid-feedback">
                                Start date is require
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="inputEmail">End Date</label> <span class="required" style="color: red">*</span>
                            <input id="end-date" type="date" name="end_date" class="form-control">
                            <div class="invalid-feedback">
                                The field Start Date must be less than or equal to End Date.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="inputEmail">Partial Day</label> <span class="required" style="color: red">*</span>
                            <select class="form-select form-control" name="partial_day" id="parial-day">
                                <option value="all">All Day</option>
                                <option value="mor">Morning</option>
                                <option value="aft">Afternoon </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label id="lable-duration" class="col-form-label pt-0">Duration (note: if the time smaller or by 0, could not create request )</label>
                            <input disabled type="text" id="duration" value="" class="form-control">
                            <div class="invalid-feedback">
                            </div>
                            </input>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="inputEmail">Reason</label> <span class="required" style="color: red">*</span>
                            <select class="form-select form-control" name="reason_id" id="reasons">
                            </select>
                        </div>

                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="inputLarge" class="col-form-label pt-0">Approver</label>
                            <input type="text" disabled value="<?= $_SESSION['user_info']['approver'] ?>" class="form-control form-control">
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Detail Reason</label> <span id="detail-reason-require" class="required d-none" style="color: red">*</span>
                            <textarea class="form-control" name="detail_reason" id="detail-reason" rows="3"></textarea>
                            <div class="invalid-feedback" id="detail-reason-msg">
                                Detail reason is invalid.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="inputLarge" class="col-form-label pt-0">Supervisor</label>
                            <input type="text" disabled value="<?= $_SESSION['user_info']['supervisor'] ?>" class="form-control form-control">
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label for="inputEmail">Expected Approve</label>
                            <input id="expected-date" type="date" name="expected_date" class="form-control">
                            <div class="invalid-feedback">
                            Expected date should not be less than current date
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<div class="overlay"></div>
<div class="spanner">
    <div class="loader"></div>
    <p>Waiting...</p>
</div>


<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Time Off (Leave) Requests and Balances in 2022 - <?= $data['user_fullname'] ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Request Name</th>
                            <th scope="col">Unit</th>
                            <th scope="col">Maximum Allowed</th>
                            <th scope="col">Approved Quotas</th>
                            <th scope="col">Number Of Days Off</th>
                            <th scope="col">Pending Quotas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $time_data = [];
                        if(!empty($data['time_off_data'][0])){
                            $time_data = $data['time_off_data'][0];
                        }
                        ?>
                        <tr>
                            <td><?= array_key_exists('name_request', $time_data)?$time_data['name_request']: 'Nghi Khong luong'?></td>
                            <td><?= array_key_exists('unit', $time_data)?$time_data['unit']: 'month' ?></td>
                            <td><?= array_key_exists('maximun_allowed', $time_data)?$time_data['maximun_allowed']: '1' ?></td>
                            <td><?= array_key_exists('remainning_quotas', $time_data)?$time_data['remainning_quotas']: '' ?></td>
                            <td><?= array_key_exists('num_day_off', $time_data)?$time_data['num_day_off']: 0 ?></td>
                            <td><?= array_key_exists('pending_quotas', $time_data)?$time_data['pending_quotas']: 0 ?></td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', (event) => {
        const app = {
            start: null,
            end: null,
            duration: 1,
            partialday: 'all',
            hasError: false,
            isLoading: false,
            num_day_off: null,
            day_off_allowed: null,
            untils: {
                compareDate: null, // func
                differrenceDate: null, //func
                showErr(msg) {
                    const msgEle = document.querySelector('.msg-error');
                    msgEle.innerHTML = `
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> ${msg}.
                        <a href="#" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                    </a>
                    </div>
                    `;
                    setTimeout(() => {
                        msgEle.innerHTML = ""
                    }, 4000)
                }
            },
            init() {
                this.handleDate.start();
                this.handleSelect.start();
                this.api.start();
                this.handleSubmit.start();
            },
            handleDate: {
                start() {
                    this.init();
                    this.listenEvent.init();
                    app.untils.compareDate = this.listenEvent.compareDate;
                },
                init() {
                    let now = new Date();
                    let day = ("0" + now.getDate()).slice(-2);
                    let month = ("0" + (now.getMonth() + 1)).slice(-2);
                    let today = now.getFullYear() + "-" + (month) + "-" + (day);
                    $('#start-date').val(today)
                    $('#end-date').val(today) //'2022-10-09'
                    $('#expected-date').val(today)
                    app.start = today
                    app.end = today
                    let isWeekend = this.listenEvent.untils.isWeekend(new Date(today))
                    isWeekend ? app.duration = 0 : app.duration = 1;
                    $('#duration').val(app.duration + ' day');
                },
                listenEvent: {
                    init() {
                        this.listen();
                        app.untils.differrenceDate = this.untils.differrenceDate;
                    },
                    listen() {
                        let _this = this
                        $('#start-date').change(function(e) {
                            app.start = e.target.value
                            $('#end-date').val(app.start)
                            app.end = e.target.value;
                            _this.compareDate();
                            app.handleSelect.untils.handleDuration(app.partialday);
                        })
                        $("#start-date").on("keydown", function(e) {
                            e.preventDefault();
                        });
                        $("#end-date").on("keydown", function(e) {
                            e.preventDefault();
                        });
                        $('#end-date').change(function(e) {
                            app.end = e.target.value;
                            _this.compareDate();
                            app.handleSelect.untils.handleDuration(app.partialday);
                        })
                    },
                    untils: {
                        isWeekend(date) {
                            if (date.getDay() == 6 || date.getDay() == 0) {
                                return true;
                            } else {
                                return false;
                            }
                        },
                        duration(startDate, endDate) {
                            let start = new Date(startDate);
                            let end = new Date(endDate);
                            let countDay = 0;
                            for (var d = start; d <= end; d.setDate(d.getDate() + 1)) {
                                if (!this.isWeekend(d)) {
                                    countDay++;
                                }
                            }
                            return countDay;
                        },
                        differrenceDate(start, end) {
                            let startDate = new Date(start);
                            let endDate = new Date(end);
                            return endDate - startDate;
                        }
                    },
                    compareDate() {
                        let compareDate = app.untils.differrenceDate(app.start, app.end)
                        let duration = 1;
                        if (compareDate < 0) {
                            app.hasError = true;
                            duration = 0;
                            document.querySelector('#end-date').classList.add('is-invalid')
                        } else {
                            duration = app.handleDate.listenEvent.untils.duration(app.start, app.end);
                            document.querySelector('#end-date').classList.remove('is-invalid')
                            app.hasError = false;
                        }
                        app.duration = duration; //g
                        $('#duration').val(duration + ' day');
                    },

                }
            },
            handleSelect: {
                start() {
                    this.listen()
                },
                untils: {
                    handleRequireDetailReason(value) {
                        const detailReasonEle = document.querySelector('#detail-reason-require');
                        value == '' ? detailReasonEle.classList.remove('d-none') : detailReasonEle.classList.add('d-none')
                    },
                    handlePolicy(reType, policyEle) {
                        if (reType == '3') {
                            policyEle.classList.remove('d-none')
                        } else {
                            policyEle.classList.add('d-none')
                        }
                    },
                    refreshPartialDay() {
                        document.querySelector('#parial-day').value = 'all'
                    },
                    handleDuration(value) {
                        switch (value) {
                            case 'mor':
                                $('#duration').val(app.duration / 2 + ' day')
                                break;
                            case 'aft':
                                $('#duration').val(app.duration / 2 + ' day')
                                break;
                            default:
                                $('#duration').val(app.duration + ' day')
                                break;
                        }
                    },
                    durationValue(value) {
                        switch (value) {
                            case 'mor':
                                return app.duration / 2
                                break;
                            case 'aft':
                                return app.duration / 2
                                break;
                            default:
                            return app.duration
                                break;
                        }
                    },
                    refreshForm() {
                        $('#start-date').removeClass('is-invalid');
                        $('#lable-duration').removeClass('text-danger');
                    }
                },
                listen() {
                    let _this = this
                    //request type change
                    $('#request-type').change(function(e) {
                        app.handleDate.init();
                        app.untils.compareDate();

                        const reType = e.target.value;
                        const policyEle = document.querySelector("#no-salary-policy");
                        _this.untils.handlePolicy(reType, policyEle);
                        _this.untils.handleRequireDetailReason('no-other');
                        _this.untils.refreshPartialDay();
                        _this.untils.refreshForm()
                        document.querySelector('#detail-reason').classList.remove('is-invalid');
                        //call api load reasons by request type
                        app.api.getReasons(reType)
                    })
                    //partial day change
                    $('#parial-day').change(function(e) {
                        app.partialday = e.target.value;
                        _this.untils.handleDuration(e.target.value);
                    })
                    //reason chnage
                    $('#reasons').change(function(e) {
                        const value = e.target.value;
                        _this.untils.handleRequireDetailReason(value);
                        document.querySelector('#detail-reason').classList.remove('is-invalid');

                    })
                },
            },
            api: {
                start() {
                    this.getRequestType();
                    this.getReasons();
                    this.getTimeOff();
                },
                untils: {
                    appendHTML(arrData, idSelectTag) {
                        arrData.foreach(ele => {
                            $(idSelectTag).append(`<option>${ele.NAME}</option>`)
                        })
                    }
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
                getReasons(requestType = 1) {
                    fetch(`http://localhost/mini_project_2/reason/reasons_by_id/${requestType}`)
                        .then((response) => response.json())
                        .then((data) => {
                            $('#reasons').empty();
                            for (let i = 0; i < data.length; i++) {
                                $('#reasons').append(`<option value="${data[i].id}">${data[i].content}</option>`)
                            }
                            $('#reasons').append(`<option value="">Other</option>`)
                        });
                },
                getTimeOff() {
                    fetch(`http://localhost/mini_project_2/request/time_off_valid`)
                        .then((response) => response.json())
                        .then((data) => {
                            app.day_off_allowed = data.max_day_off
                            app.num_day_off = data.num_day_off
                            console.log(data)
                        });
                },
            },
            handleSubmit: {
                start() {
                    this.listenEvent();
                },
                untils: {
                    validate(value) {
                        let flag = true;
                        value = value.trim();
                        if (value.length <= 0) {
                            flag = false;
                        }
                        var pattern = /^([,\.a-zA-Z0-9ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹwfz@\s]+)$/;
                        if(!pattern.test(value)){
                            flag = false;
                        }
                        return flag;
                    },
                },
                listenEvent() {
                    const _this = this
                    $('#btn-submit').click(function(e) {
                        app.loading.show()
                        setTimeout(() => {
                            let isSubmit = true;
                            const reasonOptionEle = document.querySelector('#reasons');
                            if (reasonOptionEle.value == '') {
                                const detailReasonValue = document.querySelector('#detail-reason').value;
                                let validate = _this.untils.validate(detailReasonValue);
                                if (!validate) {
                                    isSubmit = false;
                                    document.querySelector('#detail-reason').classList.add('is-invalid');
                                }
                            }
                            if (app.hasError) {
                                isSubmit = false;
                            }
                            if (app.duration == 0) {
                                $('#lable-duration').addClass('text-danger');
                                isSubmit = false;
                            }

                            if(!app.start){
                                $('#start-date').addClass('is-invalid');
                                isSubmit = false;
                            }

                            let detail_reason = $('#detail-reason').val();
                            console.log('trim', $.trim(detail_reason))
                            if($.trim(detail_reason).length > 0){
                                console.log('trim', $.trim(detail_reason))
                                let result = app.handleSubmit.untils.validate(detail_reason)
                                if(!result) {
                                    isSubmit = false;
                                    $('#detail-reason').addClass('is-invalid')
                                }
                            }

                            let timeAllowed = app.day_off_allowed - app.num_day_off;
                            const duration_value = app.handleSelect.untils.durationValue(app.partialday);
                            console.log(app.day_off_allowed, app.num_day_off)
                            console.log(timeAllowed, duration_value)
                            if(timeAllowed < duration_value){
                                isSubmit = false;
                                app.untils.showErr(`Do not take more than the allowed number of days off (Allowed: ${(app.day_off_allowed - app.num_day_off)})`)
                            }
                            const time = app.untils.differrenceDate(app.start, new Date())
                            let day = Math.floor(time / (24 * 60 * 60 * 1000))
                            if (day > 30) {
                                isSubmit = false;
                                app.untils.showErr('Request not under 30 days so with current')
                            }

                            let expectedVal = $('#expected-date').val();
                            let d = Math.floor(new Date() - new Date(expectedVal));
                            let day2 = Math.floor(d / (24 * 60 * 60 * 1000))
            
                            if (day2 > 0) {
                                isSubmit = false;
                                $('#expected-date').addClass('is-invalid');
                            }                          
                            if (isSubmit) {
                                $('#form').submit();
                            }
                            app.loading.hide();
                        }, 500)
                    })
                }
            },
            loading: {
                show() {
                    $("div.spanner").addClass("show");
                    $("div.overlay").addClass("show");
                },
                hide() {
                    $("div.spanner").removeClass("show");
                    $("div.overlay").removeClass("show");
                }
            }
        }
        app.init();

       

    });
</script>