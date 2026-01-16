@extends('nav_head')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
       
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css"/>
    <!-- <link rel="stylesheet" type="text/css" href="Datatables/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.css">
    <script type="text/javascript" charset="utf8" src="DataTables/datatables.js"></script> -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
   
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
@section('form')
    <h1>Exam List</h1>

<table id='my' margin="6" style='text-align:left, text-indent:50px;'>
    <thead>
        <th>Id</th>
        <th>Name</th>
        <!-- <th><input type="button" value="Add Class" onclick="window.location.href='http://localhost//class/add'"></th> -->
        <th><button type="button" class="btn btn-primary add" onclick="location.href='{{ url('exam') }}'">Add Exam</button>
        </th>
    </thead>
    <tbody>
      
    </tbody>
</table>
@endsection
<!-- <script>$(document).ready(function () {
    $("#my").DataTable();
    } );
</script> -->
<script>
        $(document).ready(function() {
            $('#my').DataTable( {
                "ajax": "{{url('exam/list/ajax')}}"
    } );
} );  
</script>
<script>
// var edit_id=0

// $('.edit').on('click', function(){
//   var id = $(this).attr('id');
//   edit_id=id;
// //   $('#examdata').html('');
// // $('#myModal').on('click', '#editexam', function (event) {

// $.ajax({
//  url: 'exam/edit/'+ id,
//  dataType:"json",
//  success:function(data){
//   $('#id').val(data.data.id);
//   $('.code').val(data.data.name);
//   $('#class_id').myfunction();
//   $('#check').val(data.data.subject_id);
//   $('#max').val(data.data.max_marks);
//   $('#pass').val(data.data.total);
//   // $('.modal-title').text("Update Record");
//   $('#submit').text("Update");
//   $('#examdata').show;
//   // window.location.reload('http://localhost//exam');
// }
// });
// });

$(document).on('click', '.delete', function(){
  var id = $(this).attr('id');
  $('#confirmModal').modal('show');
//  });

 $('#ok_button').click(function(){
  $.ajax({
   url: 'class/delete/'+id,

   success:function(data)
   {
    setTimeout(function(){
     $('#confirmModal').modal('hide');
     $('#my').DataTable().ajax.reload();
    });
   }
  })
 });
 });
 


</script>

<div id="confirmModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h2 class="modal-title">Confirmation</h2>
            </div>
            <div class="modal-body">
                <h4 style="margin:0;">Are you sure you want to delete?</h4>
            </div>
            <div class="modal-footer">
             <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

</body>
</html> 