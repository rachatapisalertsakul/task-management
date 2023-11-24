@extends('layout')
@section('content')
<!DOCTYPE html>
<html>

<meta charset='utf-8' />
<link href={{ asset('fullcalendar/lib/main.css') }} rel='stylesheet' />
<script src={{ asset('fullcalendar/lib/main.js') }}></script>
<script src={{ asset('fullcalendar/lib/locales-all.js') }}></script>



<div class="nk-block nk-block-lg">
    <div class="row">
        <div class="d-flex  mb-3">
            <div class="p-2 ">
                <h4 class="nk-block-title">Dashboard</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="row">
                <div class="col-12 pb-2">
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">
                            <table class="table table-bordered" style="border: #FFF;">
                                <tbody>
                                    <tr>
                                        <th class="text-center text-warning" scope="row">TO DO :</th>
                                        <td>{{ $count_task[0] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center text-info" scope="row">DOING :</th>
                                        <td>{{ $count_task[1] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center text-success" scope="row">DONE :</th>
                                        <td>{{ $count_task[2] }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center text-danger" scope="row">REJECT :</th>
                                        <td>{{ $count_task[3] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card card-bordered card-preview">
                        <div class="card-inner">
                            <div class="card-head text-center">
                                <h6 class="title">อัตราส่วน Task จำแนกตามสถานะ</h6>
                            </div>
                            <div class="nk-ck-sm"><canvas class="pie-chart" id="pieChartData"></canvas></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"> <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1">Task Calendar</a> </li>
                        <li class="nav-item"> <a class="nav-link " data-bs-toggle="tab" href="#tabItem2">Meeting Calendar</a> </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabItem1">
                            <div id='calendar_task'></div>
                        </div>
                        <div class="tab-pane " id="tabItem2">
                            <div id='calendar_meeting'></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div id="ModalTask" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modalTitle" class="modal-title"></h4>
            </div>
            <div id="modalBody" class="modal-body">
                <div id="ref_project"></div>
                <div id="event_topic"></div>
                <div id="description_modal"></div>
                <div id="due_date"></div>
                <div id="status"></div>
                <div id="link_modal"></div>
            </div>
            <div id="modal-footer" class="modal-footer"></div>
        </div>
    </div>
</div>

<div id="ModalMeeting" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 id="modal_meeting_header" class="modal-title"></h4>
            </div>
            <div id="modalBody" class="modal-body">
                <div id="modal_meeting_description"></div>
                <div id="modal_meeting_link"></div>
                <div id="description_modal"></div>
                <div id="modal_meeting_date"></div>
            </div>
            <div id="modal-footer-meeting" class="modal-footer"></div>
        </div>
    </div>
</div>

@section('js_script')
<!-- <script src="../../assets/js/example-chartdeae.js?ver=3.2.1"></script> -->

<script>
    ! function(NioApp, $) {
        var pieChartData = {
            labels: ["TO DO", "DOING", "DONE", "REJECT"],
            dataUnit: "Task",
            legend: 1,
            datasets: [{
                label: 'จำนวนงาน',
                borderColor: "#fff",
                background: ["#f4bd0e", "#09c2de", "#1ee0ac", "#e85347"],
                data: <?php echo json_encode($count_task) ?>
            }]
        };

        function pieChart(selector, set_data) {
            var $selector = $(selector || ".pie-chart");
            $selector.each(function() {
                for (var $self = $(this), _self_id = $self.attr("id"), _get_data = void 0 === set_data ? eval(_self_id) : set_data, selectCanvas = document.getElementById(_self_id).getContext("2d"), chart_data = [], i = 0; i < _get_data.datasets.length; i++) chart_data.push({
                    backgroundColor: _get_data.datasets[i].background,
                    borderWidth: 2,
                    borderColor: _get_data.datasets[i].borderColor,
                    hoverBorderColor: _get_data.datasets[i].borderColor,
                    data: _get_data.datasets[i].data
                });
                var chart = new Chart(selectCanvas, {
                    type: "pie",
                    data: {
                        labels: _get_data.labels,
                        datasets: chart_data
                    },
                    options: {
                        plugins: {
                            legend: {
                                position: 'bottom',
                                display: _get_data.legend || !1,
                                rtl: NioApp.State.isRTL,
                                labels: {
                                    boxWidth: 20,
                                    padding: 15,
                                    color: "#6783b8"
                                }
                            },
                            tooltip: {
                                enabled: !0,
                                rtl: NioApp.State.isRTL,
                                callbacks: {
                                    label: function(a) {
                                        return "".concat(a.parsed, " ").concat(_get_data.dataUnit)
                                    }
                                },
                                backgroundColor: "#eff6ff",
                                titleFont: {
                                    size: 13
                                },
                                titleColor: "#6783b8",
                                titleMarginBottom: 6,
                                bodyColor: "#9eaecf",
                                bodyFont: {
                                    size: 12
                                },
                                bodySpacing: 4,
                                padding: 10,
                                footerMarginTop: 0,
                                displayColors: !1
                            }
                        },
                        rotation: -.2,
                        maintainAspectRatio: !1
                    }
                })
            })
        }
        pieChart();
    }(NioApp, jQuery);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar_task');

        var calendar = new FullCalendar.Calendar(calendarEl, {

            windowResize: function(arg) {
                alert('The calendar has adjusted to a window resize. Current view: ' + arg.view.type);
            },
            themeSystem: 'sketchy',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            firstDay: 0,
            locale: 'th',
            editable: true,
            initialDate: new Date(),
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            editable: true,
            selectable: true,

            events: <?php echo json_encode($task) ?>,

            eventDidMount: function(info) {
                // console.log(info);
                $(info.el).tooltip({
                    title: info.event.extendedProps.description,
                    placement: "top",
                    trigger: "hover",
                    container: "body"
                });
            },
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                if (info.event.url) {
                    window.stop(info.event.url);
                }
                console.log(info.event.extendedProps);

                // $('#modalBody').empty();
                $('#modalTitle').html(info.event.title);
                $('#event_topic').html('<b>ชื่อเรื่อง </b>: ' + info.event.title);
                $('#ref_project').html('<b>Project : </b>: ' + info.event.extendedProps.name_project);
                $('#description_modal').html('<b>รายละเอียด </b>: ' + info.event.extendedProps.description);
                $('#link_modal').html('<b>ลิ้ง </b>: <a class="btn btn-link btn-sm" href="' + info.event.extendedProps.link + '">' + info.event.extendedProps.link + '</a>');
                $('#status').html('<b>สถานะ </b>: ' + info.event.extendedProps.status);
                $('#due_date').html('<b>วันที่สิ้นสุด </b>: ' + info.event.extendedProps.due_date);
                if (1) {
                    $('#modal-footer').html('<br><a class="btn btn-outline-primary btn-sm" href="/task_list/' + info.event.extendedProps.id_project + '">Go to Project</a>');
                    // $('#modal-footer').append('<a href="/task_list/' + info.event.extendedProps.id_project + '" onclick="return confirm("ท่านต้องการยกเลิกรายการจองนี้หรือไม่");" class="btn btn-danger btn-sm">ยกเลิกคำขอ</a>');

                } else {
                    $('#modal-footer').html(' ');
                }
                $('#ModalTask').modal('show');
            }
        });

        calendar.render();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar_meeting');

        var calendar = new FullCalendar.Calendar(calendarEl, {

            windowResize: function(arg) {
                alert('The calendar has adjusted to a window resize. Current view: ' + arg.view.type);
            },
            themeSystem: 'sketchy',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            firstDay: 0,
            locale: 'th',
            editable: true,
            initialDate: new Date(),
            navLinks: true, // can click day/week names to navigate views
            businessHours: true, // display business hours
            editable: true,
            selectable: true,

            events: <?php echo json_encode($meeting_event) ?>,

            eventDidMount: function(info) {
                // console.log(info);
                $(info.el).tooltip({
                    title: info.event.extendedProps.description,
                    placement: "top",
                    trigger: "hover",
                    container: "body"
                });
            },

            eventClick: function(info) {
                info.jsEvent.preventDefault();
                if (info.event.url) {
                    window.stop(info.event.url);
                }
                console.log(info.event);

                // $('#modalBody').empty();
                $('#modal_meeting_header').html(info.event.title);
                $('#modal_meeting_title').html('<b>ชื่อเรื่อง </b>: ' + info.event.title);
                $('#modal_meeting_description').html('<b>รายละเอียด </b>: ' + info.event.extendedProps.description);
                $('#modal_meeting_link').html('<b>ลิ้ง </b>: <a target="_blank" class="btn btn-link btn-sm" href="' + info.event.extendedProps.link + '">' + info.event.extendedProps.link + '</a>');
                $('#modal_meeting_date').html('<b>วันที่สิ้นสุด </b>: ' + info.event.extendedProps.date_start);
                if (1) {
                    $('#modal-footer-meeting').html('<br><a class="btn btn-outline-primary btn-sm" href="/meet_list">Go to Meeting</a>');
                    // $('#modal-footer').append('<a href="/task_list/' + info.event.extendedProps.id_project + '" onclick="return confirm("ท่านต้องการยกเลิกรายการจองนี้หรือไม่");" class="btn btn-danger btn-sm">ยกเลิกคำขอ</a>');

                } else {
                    $('#modal-footer').html(' ');
                }
                $('#ModalMeeting').modal('show');
            }

        });

        

        calendar.render();
        $('.nav-tabs li a').click(function() {
            calendar.render();
        });
    });
</script>
@endsection


@endsection