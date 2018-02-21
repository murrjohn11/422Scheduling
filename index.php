<?php
    include 'class/sql.php';
    $SQL = new SQL;
    if(session_unset()){
      session_start();
    }else{
      session_destroy();
      session_start();
    }
?>

<html>
  <head>
    <title>422 Process Scheduling</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="./css/print.css">  
      <script type="text/javascript" src='jquery/jquery.js'></script>
  </head>
  <body style="margin-top: 2%;">
      <center>
        <h1><a href="index.html">Process Table</h1></a>
      </center>
      <center>
      <div class='col-lg-12'>
      <table class="table-bordered table-striped" id="tab">
        <thead>
            <th class='td1' width='5%' id='type-th-1'></th>
            <th class='td1'>Arrival Time</th>
            <th class='td1' width="10%">Turnaround</th>
            <th class='td1'>Service Time</th>
            <th class='td1'>Finish Time</th>
            <th class='td1' width='10%'>Remaining Turnarounds</th>
            <th class='td1' width='10%' id='prio-th'>Priority</th>
        </thead>
        <tbody id='tbody-1'></tbody>
      </table>
      <table class="table-bordered table-striped col-lg-12" id="tab2" style="margin-top:2%;">
        <thead>
            <th class='td1' width='5%' id='type-th-2'></th>
            <th class='td1'>Arrival Time</th>
            <th class='td1' width="10%">Turnaround</th>
            <th class='td1'>Service Time</th>
            <th class='td1'>Finish Time</th>
            <th class='td1' width='10%'>Remaining Turnarounds</th>
        </thead>
        <tbody id='tbody-2'></tbody>
      </table>
      </div>
      </center>
      <footer style="position: fixed;bottom: 2%;" class='col-lg-12'>
        <div class='fcfs row col-md-12' id='fcfs'>
          <div class='col-sm-4'>
            <label class="form-label" for="fcfs-input">Turnarounds</label>
            <input type='text' class='form-control' id='fcfs-input'>
            <label class="form-label" for="fcfs-input-waiting">Average Waiting Time:</label>
            <input type="text" class='form-control' id='fcfs-input-waiting' disabled="true">
          </div>
          <button class='btn' id='fcfs-add'>Add</button>
          &nbsp;<button class='btn btn-danger' id='fcfs-reset'>Reset</button>
        </div>
        <div class='fcfs row col-md-12' id='sjn'>
          <div class='col-sm-4'>
            <label class="form-label" for="sjn-input">Turnarounds</label>
            <input type='text' class='form-control' id='sjn-input'>
            <label class="form-label" for="sjn-input-waiting">Average Waiting Time:</label>
            <input type="text" class='form-control' id='sjn-input-waiting' disabled="true">
          </div>
          <button class='btn' id='sjn-add'>Add</button>
          &nbsp;<button class='btn btn-danger' id='sjn-reset'>Reset</button>
        </div>
        <div class='fcfs row col-md-12' id='ps'>
          <div class='col-sm-4'>
            <label class="form-label" for="ps-input">Turnarounds</label>
            <input type='text' class='form-control' id='ps-input'>
            <label class="form-label" for="ps-input-priority">Priority</label>
            <input type='text' class='form-control' id='ps-input-priority'>
            <label class="form-label" for="ps-input-waiting">Average Waiting Time:</label>
            <input type="text" class='form-control' id='ps-input-waiting' disabled="true">
          </div>
          <button class='btn' id='ps-add'>Add</button>
          &nbsp;<button class='btn btn-danger' id='ps-reset'>Reset</button>
        </div>
        <div class='fcfs row col-md-12' id='srt'>
          <div class='col-sm-4'>
            <label class="form-label" for="srt-input">Turnarounds</label>
            <input type='text' class='form-control' id='srt-input'>
            <label class="form-label" for="srt-input-waiting">Average Waiting Time:</label>
            <input type="text" class='form-control' id='srt-input-waiting' disabled="true">
          </div>
          <button class='btn' id='srt-add'>Add</button>
          &nbsp;<button class='btn btn-danger' id='srt-reset'>Reset</button>
        </div>
        <div class='fcfs row col-md-12' id='rr'>
          <div class='col-sm-4'>
            <label class="form-label" for="rr-input">Turnarounds</label>
            <input type='text' class='form-control' id='rr-input'>
            <label class="form-label" for="rr-input-waiting">Average Waiting Time:</label>
            <input type="text" class='form-control' id='rr-input-waiting' disabled="true">
          </div>
          <button class='btn' id='rr-add'>Add</button>
          &nbsp;<button class='btn btn-danger' id='rr-reset'>Reset</button>
        </div>
        <div class='fcfs row col-md-12' id='mlq'>
          <div class='col-sm-4'>
            <label class="form-label" for="mlq-input">Turnarounds</label>
            <input type='text' class='form-control' id='mlq-input'>
            <label class="form-label" for="mlq-type">Process Type: </label>
            &nbsp;&nbsp;<select class="form-select" id='mlq-type'>
              <option value="Foreground">Foreground</option>
              <option value="Background">Background</option>
            </select>
          </div>
          <button class='btn' id='mlq-add'>Add</button>
          &nbsp;<button class='btn btn-danger' id='mlq-reset'>Reset</button>
        </div>
        <br>
        <button class='btn btn-primary' id='fcfs-set'>First Come First Serve</button>
        <button class='btn btn-secondary' id='sjn-set'>Shortest Job Next</button>
        <button class='btn btn-warning' id='ps-set'>Priority Scheduling</button>
        <button class='btn btn-success' id='srt-set'>Shortest Remaining Time</button>
        <button class='btn btn-danger' id='rr-set'>Round Robin</button>
        <button class='btn' id='mlq-set'>Multiple-Level Queues</button>
      </footer>
  </body>
</html>
<script type="text/javascript" src='js/index.js'></script>