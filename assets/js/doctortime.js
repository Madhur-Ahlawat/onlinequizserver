console.log($("#siteurl").val());
$(document).ready(function() {
    $('#servicestable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#siteurl").val() + '/servicestable',
        columns: [{
            data: 'id',
            name: 'id'
        }, {
            data: 'icon',
            name: 'icon'
        }, {
            data: 'name',
            name: 'name'
        }, {
            data: 'action',
            name: 'action'
        }],
        columnDefs: [{
            targets: 1,
            render: function(data) {
                return '<img src="' + data + '" height="50">';
            }
        }]
    });
});

function delete_record(url) {
    if (confirm($("#delete_record").val())) {
        if ($("#demo").val() == '1') {
            window.location.href = url;
        } else {
            disablebtn();
        }
    } else {
        window.location.reload();
    }
}
$(document).ready(function() {
    $('#appointmenttable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#siteurl").val() + '/appointmenttable',
        columns: [{
            data: 'id',
            name: 'id'
        }, {
            data: 'doctor_name',
            name: 'doctor_name'
        }, {
            data: 'patient_name',
            name: 'patient_name'
        }, {
            data: 'date',
            name: 'date'
        }, {
            data: 'phone',
            name: 'phone'
        }, {
            data: 'u_desc',
            name: 'u_desc'
        }, {
            data: 'status',
            name: 'status'
        }]
    });
});
$(document).ready(function() {
    $('#compaintable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#siteurl").val() + '/compaintable',
        columns: [{
            data: 'id',
            name: 'id'
        }, {
            data: 'username',
            name: 'username'
        }, {
            data: 'title',
            name: 'title'
        }, {
            data: 'description',
            name: 'description'
        }, {
            data: 'action',
            name: 'action'
        }]
    });
});
$(document).ready(function() {
    $('#latsrappointmenttable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#siteurl").val() + '/latsrappointmenttable',
        columns: [{
            data: 'id',
            name: 'id'
        }, {
            data: 'doctor_name',
            name: 'doctor_name'
        }, {
            data: 'patient_name',
            name: 'patient_name'
        }, {
            data: 'date',
            name: 'date'
        }, {
            data: 'phone',
            name: 'phone'
        }, {
            data: 'u_desc',
            name: 'u_desc'
        }, {
            data: 'status',
            name: 'status'
        }]
    });
});
$(document).ready(function() {
    $('#notificationtable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#siteurl").val() + '/notificationtable',
        columns: [{
            data: 'id',
            name: 'id'
        }, {
            data: 'message',
            name: 'message'
        }]
    });
});
$(document).ready(function() {
    $('#upload_image').on('change', function(e) {
        readURL(this, "basic_img");
    });
});

function readURL(input, field) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $("#basic_img1").val(e.target.result);
            $('#' + field).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function() {
    $('#reviewtable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#siteurl").val() + '/reviewtable',
        columns: [{
            data: 'id',
            name: 'id'
        }, {
            data: 'doctor_name',
            name: 'doctor_name'
        }, {
            data: 'username',
            name: 'username'
        }, {
            data: 'ratting',
            name: 'ratting'
        }, {
            data: 'comment',
            name: 'comment'
        }, {
            data: 'action',
            name: 'action'
        }]
    });
});
$(document).ready(function() {
    $('#doctorstable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#siteurl").val() + '/doctorstable',
        columns: [{
            data: 'id',
            name: 'id'
        }, {
            data: 'image',
            name: 'image'
        }, {
            data: 'name',
            name: 'name'
        }, {
            data: 'email',
            name: 'email'
        }, {
            data: 'phone',
            name: 'phone'
        }, {
            data: 'service',
            name: 'service'
        }, {
            data: 'action',
            name: 'action'
        }],
        columnDefs: [{
            targets: 1,
            render: function(data) {
                return '<img src="' + data + '" height="50">';
            }
        }]
    });
});
$(document).ready(function() {
    $('#lastestordertable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#siteurl").val() + '/lastestordertable',
        columns: [{
            data: 'id',
            name: 'id'
        }, {
            data: 'name',
            name: 'name'
        }, {
            data: 'email',
            name: 'email'
        }, {
            data: 'payment_type',
            name: 'payment_type'
        }, {
            data: 'subtotal',
            name: 'subtotal'
        }, {
            data: 'action',
            name: 'action'
        }]
    });
});
$(document).ready(function() {
    $('#userstable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#siteurl").val() + '/userstable',
        columns: [{
            data: 'id',
            name: 'id'
        }, {
            data: 'name',
            name: 'name'
        }, {
            data: 'email',
            name: 'email'
        }, {
            data: 'phone',
            name: 'phone'
        }, {
            data: 'action',
            name: 'action'
        }]
    });
});
$(document).ready(function() {
    $('#contacttable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#siteurl").val() + '/contacttable',
        columns: [{
            data: 'id',
            name: 'id'
        }, {
            data: 'name',
            name: 'name'
        }, {
            data: 'email',
            name: 'email'
        }, {
            data: 'subject',
            name: 'subject'
        }, {
            data: 'message',
            name: 'message'
        }, {
            data: 'action',
            name: 'action'
        }]
    });
});

function checkduration(day_id, cid) {
    console.log(day_id);
    console.log(cid);
    if ($("#start_time_" + day_id + "_" + cid).val() == "") {
        alert($("#start1val").val());
    } else {
        var strStartTime = $("#start_time_" + day_id + "_" + cid).val();
        var strEndTime = $("#end_time_" + day_id + "_" + cid).val();
        var startTime = new Date().setHours(GetHours(strStartTime), GetMinutes(strStartTime), 0);        
        var endTime = new Date(startTime)
        endTime = endTime.setHours(GetHours(strEndTime), GetMinutes(strEndTime), 0);
        if (startTime > endTime) {
            alert($("#sge").val());
            $("#start_time_" + day_id + "_" + cid).val("");
            $("#end_time_" + day_id + "_" + cid).val("");
        }
        if (startTime == endTime) {
            alert($("#sequale").val());
            $("#start_time_" + day_id + "_" + cid).val("");
            $("#start_time_" + day_id + "_" + cid).val("");
        }
        if (startTime < endTime) {
            $.ajax({
                url: $("#siteurl").val() + "/findpossibletime",
                method: "get",
                data: {
                    start_time: strStartTime,
                    end_time: $("#end_time_" + day_id + "_" + cid).val(),
                    duration: $("#duration_" + day_id + "_" + cid).val()
                },
                success: function(data) {
                    var duval = $("#duration_" + day_id + "_" + cid).val();
                    if ($("#duration_" + day_id + "_" + cid).val() != "") {
                        $.ajax({
                            url: $("#siteurl").val() + "admin/doctors/generateslot",
                            method: "get",
                            data: {
                                start_time: $("#start_time_" + day_id + "_" + cid).val(),
                                end_time: $("#end_time_" + day_id + "_" + cid).val(),
                                duration: $("#duration_" + day_id + "_" + cid).val()
                            },
                            success: function(data) {
                                console.log(data);
                                $("#slot_" + day_id + "_" + cid).html(data);
                            }
                        });
                    }
                    $("#duration_" + day_id + "_" + cid).html(data);
                }
            });
        }
    }
}

function getslot(value, day_id, cid) {


    if ($("#start_time_" + day_id + "_" + cid).val() == "") {
        alert($("#start1val").val());
    } else {

        var strStartTime = $("#start_time_" + day_id + "_" + cid).val();
        var strEndTime = $("#end_time_" + day_id + "_" + cid).val();

        var startTime = new Date().setHours(GetHours(strStartTime), GetMinutes(strStartTime), 0);
        var endTime = new Date(startTime)
        endTime = endTime.setHours(GetHours(strEndTime), GetMinutes(strEndTime), 0);


        if (startTime > endTime) {
            alert($("#sge").val());
            $("#start_time_" + day_id + "_" + cid).val("");
            $("#end_time_" + day_id + "_" + cid).val("");
        }
        if (startTime == endTime) {
            alert($("#sequale").val());
            $("#start_time_" + day_id + "_" + cid).val("");
            $("#start_time_" + day_id + "_" + cid).val("");
        }
        if (startTime < endTime) {
            if ($("#duration_" + day_id + "_" + cid) != "") {
                $.ajax({
                    url: $("#siteurl").val() + "admin/doctors/generateslot",
                    method: "get",
                    data: {
                        start_time: $("#start_time_" + day_id + "_" + cid).val(),
                        end_time: $("#end_time_" + day_id + "_" + cid).val(),
                        duration: $("#duration_" + day_id + "_" + cid).val()
                    },
                    success: function(data) {
                        console.log(data);
                        $("#slot_" + day_id + "_" + cid).html(data);
                    }
                });
            } else {
                alert($("#selduration").val());
            }
        }
    }
}

function GetHours(d) {

    // return d;
    var h = parseInt(d.split(':')[0]);
    if (d.split(':')[1].split(' ')[1] == "PM") {
        h = h + 12;
    }
    return h;
}

function GetMinutes(d) {
    // return d;
    return parseInt(d.split(':')[1].split(' ')[0]);
}

function addnewslot(day_id) {
    var slotid = $("#total_slot_day_" + day_id).val();
    var txt = '<div class="slotdiv slotsecond" id="slotdiv' + day_id + slotid + '">';
        txt += '<div class="row"><div class="col-md-3">';
        txt += '<label for="formrow-firstname-input"> START TIME </label>';
        txt += '<input type="time" class="form-control" id="start_time_' + day_id + '_' + slotid + '" required="" name="arr[' + day_id + '][start_time][]" onchange="checkduration(' + day_id + ',' + slotid + ')">';
        txt += '</div><div class="col-md-3"><label for="formrow-firstname-input"> END TIME </label>';
        txt += '<input type="time" required="" class="form-control" id="end_time_' + day_id + '_' + slotid + '" name="arr[' + day_id + '][end_time][]"  onchange="checkduration(' + day_id + ',' + slotid + ')"></div>';
        txt += '<div class="col-md-3">';
        txt += '<label for="formrow-firstname-input">Duration</label>';
        txt += '<select class="form-control" required="" name="arr[' + day_id + '][duration][]" id="duration_' + day_id + '_' + slotid + '" onchange="getslot(this.value,' + day_id + ',' + slotid + ')">';
        txt += '<option value="">Select Duration</option>';
        txt += '<option value="15">15 Minutes</option>';
        txt += '<option value="30">30 Minutes</option>';
        txt += '<option value="45">45 Minutes</option>';
        txt += '</select>';
        txt += '</div>';
        txt += '<div class="col-md-3" style="margin-top: 28px;">';
        txt += '<button type="button" class="btn btn-danger" onclick="removescdehule(' + day_id + ',' + slotid + ')"> Delete </button>';
        txt += '</div>';
        txt += '</div>';
        txt += '<div class="row boxmargin" id="slot_' + day_id + '_' + slotid + '">';
        txt += '</div>';
        txt += '</div>';

    $("#day_" + day_id).append(txt);
    $("#total_slot_day_" + day_id).val(parseInt(slotid) + parseInt(1));
}

function removescdehule(day_id, cid) {
    $("#slotdiv" + day_id + cid).remove();
}