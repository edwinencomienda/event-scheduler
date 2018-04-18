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
    <center>
        <p>Republic of the Philippines</p>
        <h4>DAVAO DEL NORTE STATE COLLEGE</h4>
        <p>New Visayas, Panabo City</p>
        <!-- <h4>Day - 5 MARCH 1, 1996</h4> -->
    </center>
    <br>

    <hr>

    <center>
        <h4>Upcoming Activities</h4>
    </center>

    <table style="width:100%;" class="table-content">
        <thead>
            <tr>
                <th>NAME</th>
                <th>DATE FROM</th>
                <th>DATE TO</th>
                <TH>PERSON INVOLVED</TH>
                <th>VENUE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activities as $activity)
            <tr>
                <td class="text-center">{{ $activity->name }}</td>
                <td class="text-center">{{ $activity->date_from }}</td>
                <td class="text-center">{{ $activity->date_to }}</td>
                <td class="text-center">{{ $activity->description }}</td>
                <td class="text-center">{{ $activity->venue }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>