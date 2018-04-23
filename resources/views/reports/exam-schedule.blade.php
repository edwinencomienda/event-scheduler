<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<style>
body {
    font-family: Arial, Helvetica, sans-serif;
}
td, th {
    font-family: Arial, Helvetica, sans-serif;
}
table.table-content td, th {
    border: 1px solid;
}
table.table-content {
    border-collapse: collapse;
}
.text-center {
    text-align: center;
}
table.table-content td {
    font-size: 13px;
    padding: 5px 5px;
}
table.table-content th {
    padding: 17px 16px;
}
</style>

    <img src="{{ url('/dnsclogo.png') }}" alt="" style="position: absolute;
    max-width: 153px;
    margin-left: 8%;">

    <?php 
        $schedule = $schedules[0];
    ?>

    <center>
        <p>Republic of the Philippines</p>
        <h4>DAVAO DEL NORTE STATE COLLEGE</h4>
        <p>New Visayas, Panabo City</p>
        <h4>Day - {{ $schedule->day }} {{ date('F d, Y', strtotime($schedule->date)) }}</h4>
    </center>

    <hr>

    <center>
        <h4>{{ $schedule->term }} EXAMNINATION SCHEDULE</h4>
        <h4>Day - {{ $schedule->day }} {{ date('F d, Y', strtotime($schedule->date)) }}</h4>
    </center>

    <table style="width:100%;" class="table-content">
        <thead>
            <tr>
                <th>TIME OF EXAM</th>
                <th>SUBJECT</th>
                <th>SECTION</th>
                <TH>SUBJECT TIME SCHEDULE</TH>
                <th>ROOM FOR EXAM</th>
                <th>INSTRUCTOR</th>
                <th>PROCTOR</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
            <tr>
                <td class="text-center">{{ $schedule->time_start . '-' . $schedule->time_end }}</td>
                <td class="text-center">{{ optional($schedule->subject)->code }}</td>
                <td class="text-center">{{ optional($schedule->section)->code }}</td>
                <td class="text-center">{{ optional($schedule->subject)->time_start . '-' . optional($schedule->subject)->time_end . ' ' . optional($schedule->subject)->day_code }}</td>
                <td class="text-center">{{ $schedule->room->name }}</td>
                <td>{{ optional(optional($schedule->subject)->instructor)->name }}</td>
                <td>{{ $schedule->proctor->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>