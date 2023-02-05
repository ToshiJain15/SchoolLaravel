@extends('nav_head')
<!-- action="{{url('exam/save')}}"  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css"/> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <!-- <script src="https://chart.js-3.5.1/package"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.1/js/bootstrap-multiselect.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.1/css/bootstrap-multiselect.css">  
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.esm.js" integrity="sha512-IPqefcmFCuGcYxl/uIjvyCXwh5T9+EB2MFT7W9RUZd20d7PLfgdT975xdhyesvdXH6Au8SyXOw1236LY1lFl5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.esm.min.js" integrity="sha512-2Vi/lCX8NaXlAhzc28RAoteYAiJVoz4y3Xq/IpHQCw7KU25I34fDqJSVSUml2tQRVYFnf3IMy6O59zKJh79hiw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/helpers.esm.min.js" integrity="sha512-b3xZ1Eh852+/Ltha4XJd59YP2d+I+B6NPdB4H+Wns29GX9x5pLwlp8jnQtJYog3d5Xk1SWvhT2lgJDDBvpV0ow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
</head>
<body>
@section('form')
    <h1>Chart</h1>
    <form method="post" id="examdata">
    <fieldset>
        <legend>Exam</legend>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
          <div class="form-group">
            <input type="hidden" id="id" name="id" >  
          <div><label for='class'>Select class:</label></div> 
            <div><select name="class_id" id="class_id" required min=1>
            <option name='select' disabled selected value> -- select a class -- </option>
            @php
            $result = DB::select('SELECT Distinct id,name FROM classes');
            @endphp
            @foreach($result as $rec) 
              <option  value="{{$rec->id}}" >{{$rec->name}}</option>
            @endforeach
            </select></div>      
            @error('class_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror</div><br><br>
            
<!-- <script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
}); -->
<!-- </script> -->


      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <!-- <button  type="submit" value="Submit" id="submit" class="submit btn btn-primary">Save</button> -->
        </form>
      </div>


      <canvas id="myChart" width="400" height="150"></canvas>
<script>
  function renderGraph(data){
    // if(window.myChart!=null){
    //       window.myChart.destroy();
    //     }
    // mychart.clearRect(0, 0, canvas.width, canvas.height);
    var ctx = document.getElementById('myChart').getContext('2d');

    // var ctx= $("#myChart")[0].getContext("2d");
      window.myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: [data.data[0].name, data.data[0].name, data.data[0].name, data.data[0].name],
            datasets: [{ 
                data: [3,10, 3, 4],
                label: "Pass",
                pointBorderWidth:10,
                strokeColor : "rgba(220,220,220,1)",
                pointColor : "rgba(220,220,220,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(220,220,220,1)",
                borderColor: "#71d1bd",
                backgroundColor: "#7bb6dd",
                fill: false,
              }, { 
                data: [10,0,1,4],
                label: "Fail",
                pointBorderWidth:10,
                strokeColor : "rgba(220,220,220,1)",
                pointColor : "rgba(220,220,220,1)",
                pointStrokeColor : "#fff",
                pointHighlightFill : "#fff",
                pointHighlightStroke : "rgba(220,220,220,1)",
                borderColor: "#c45850",
                // backgroundColor: "#71d1bd",
                backgroundColor: "#FF1413",
                fill: false,
              }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                position: 'top',
              },
              title: {
                display: true,
                text: 'Exam Report'
              }
            }
          },
          scales: {
            y: {
              type: 'linear',
              display: true,
              position: 'left',
            },
            y1: {
              type: 'linear',
              display: true,
              position: 'right',
            
              // grid line settings
              grid: {
                drawOnChartArea: false, // only want the grid lines for one axis to show up
              },
            },
          }
          
        });
        
  }
  // var ctx = document.getElementById('myChart').getContext('2d');;
  //     var myChart = new Chart(ctx, {
  //         type: 'line',
  //         data: {
  //           labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
  //           datasets: [{ 
  //               data: [86,114,106,106,107,111,133],
  //               label: "Pass",
  //               borderColor: "#71d1bd",
  //               backgroundColor: "#7bb6dd",
  //               fill: false,
  //             }, { 
  //               data: [70,90,44,60,83,90,100],
  //               label: "Fail",
  //               borderColor: "#c45850",
  //               backgroundColor: "#71d1bd",
  //               fill: false,
  //             },
  //             //  { 
  //             //   data: [10,21,60,44,17,21,17],
  //             //   label: "Pending",
  //             //   borderColor: "#ffa500",
  //             //   backgroundColor:"#ffc04d",
  //             //   fill: false,
  //             // }, { 
  //             //   data: [6,3,2,2,7,0,16],
  //             //   label: "Rejected",
  //             //   borderColor: "#c45850",
  //             //   backgroundColor:"#d78f89",
  //             //   fill: false,
  //             // }
  //           ]
  //         },
  //         scales: {
  //           y: {
  //             type: 'linear',
  //             display: true,
  //             position: 'left',
  //           },
  //           y1: {
  //             type: 'linear',
  //             display: true,
  //             position: 'right',
            
  //             // grid line settings
  //             grid: {
  //               drawOnChartArea: false, // only want the grid lines for one axis to show up
  //             },
  //           },
  //         }
  //       });
$('#class_id').on('change',function(event) {
  // event.preventDefault();
    $.ajax({

      url: '<?php echo url('/')?>/chart/data',
    
      type: "get",

      data: {class_id:$("#class_id").val()},
      dataType: 'json',

      success: function (data) {
        console.log(data.data[0]);
        try {
        myChart.destroy()
          
        } catch (error) {
          
        }

        // $('#myChart').destroy();
        renderGraph(data);
        // window.location.reload(true);
        // location.href = "http://localhost/example-app/public/chart"
      }
    });
    });

// const DATA_COUNT = 7;
// const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};

// const labels = Utils.months({count: 7});
// const data = {
//   labels: labels,
//   datasets: [
//     {
//       label: 'Dataset 1',
//       data: Utils.numbers(NUMBER_CFG),
//       borderColor: Utils.CHART_COLORS.red,
//       backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
//     },
//     {
//       label: 'Dataset 2',
//       data: Utils.numbers(NUMBER_CFG),
//       borderColor: Utils.CHART_COLORS.blue,
//       backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.5),
//     }
//   ]
// };
// const config = {
//   type: 'line',
//   data: data,
//   options: {
//     responsive: true,
//     plugins: {
//       legend: {
//         position: 'top',
//       },
//       title: {
//         display: true,
//         text: 'Chart.js Line Chart'
//       }
//     }
//   },
// };
// const actions = [
//   {
//     name: 'Randomize',
//     handler(chart) {
//       chart.data.datasets.forEach(dataset => {
//         dataset.data = Utils.numbers({count: chart.data.labels.length, min: -100, max: 100});
//       });
//       chart.update();
//     }
//   },
//   {
//     name: 'Add Dataset',
//     handler(chart) {
//       const data = chart.data;
//       const dsColor = Utils.namedColor(chart.data.datasets.length);
//       const newDataset = {
//         label: 'Dataset ' + (data.datasets.length + 1),
//         backgroundColor: Utils.transparentize(dsColor, 0.5),
//         borderColor: dsColor,
//         data: Utils.numbers({count: data.labels.length, min: -100, max: 100}),
//       };
//       chart.data.datasets.push(newDataset);
//       chart.update();
//     }
//   },
//   {
//     name: 'Add Data',
//     handler(chart) {
//       const data = chart.data;
//       if (data.datasets.length > 0) {
//         data.labels = Utils.months({count: data.labels.length + 1});

//         for (var index = 0; index < data.datasets.length; ++index) {
//           data.datasets[index].data.push(Utils.rand(-100, 100));
//         }

//         chart.update();
//       }
//     }
//   },
//   {
//     name: 'Remove Dataset',
//     handler(chart) {
//       chart.data.datasets.pop();
//       chart.update();
//     }
//   },
//   {
//     name: 'Remove Data',
//     handler(chart) {
//       chart.data.labels.splice(-1, 1); // remove the label first

//       chart.data.datasets.forEach(dataset => {
//         dataset.data.pop();
//       });

//       chart.update();
//     }
//   }
// ];
$(document).ready(function () {
$.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});


// $("#class_id").change(myfunction);
// console.log(id['value']);
// if(id['value']>0){
    
//   $("#class_id").attr("disabled", true);
//   function response(data){ var class_id=data.data.class_id;}
//   var i = class_id['value'];
//   // class_id=i;
//   console.log(class_id['value'])
//   $("#class_id").ready(myfunction);
//   }

$('#class_id').on('change',function (event) {
  // event.preventDefault();

    var id = $("#exam_id").val();
    var name = $("#name").val();
    if($('#submit').text() == 'Save'){
    $.ajax({

      url: '/chart',
    
      type: "post",

      data: $("#examdata").serialize(),
      dataType: 'json',

      success: function (data) {
        // window.location.reload(true);
        location.href = "http://localhost/example-app/public/chart"
      }
    });
    }else if($('#submit').text() == 'Update'){
    $.ajax({
      url: 'http://localhost/example-app/public/exam/update/'+edit_id,

      type: "post",

      data: $("#examdata").serialize(),
      dataType: 'json',

      success: function (data) {
          
          // window.location.reload(true);
          location.href = "http://localhost/example-app/public/exam_list"
          
      }
    });
    }
  })
});

// });



</script>
@endsection
</body>
</html> 