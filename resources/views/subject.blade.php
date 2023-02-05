@extends('nav_head')
<!-- action="{{url('sub/save')}}"  -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
   
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
@section('form')
    <h1>Subject List</h1>

<table id="myTable" style='text-align:left;'>
    <thead>
        <th>Id</th>
        <th>Class Id</th>
        <th>Name</th>
        <th>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary add" data-toggle="modal" data-target="#myModal">
  Add Subject
</button>

<div class="modal fade" class="btn btn-primary add" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="myModalLabel">Add New Record</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" id="form_result">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="subdata">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <div><label for='class'>Enter class:</label></div> 
            <div><select name="class_id" id="class_id" required min=1>
            <option disabled selected value> -- select class -- </option>
            @php
            $result = DB::select('SELECT Distinct id,name FROM classes');
            @endphp
            @foreach($result as $rec) 
              <option  value="{{$rec->id}}"<?php echo ($data['class_id'] == $rec->name) ? 'selected' : '';?> >{{$rec->name}}</option>
            @endforeach
            </select>        
            @error('class_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror</div>
          <div class="form-group">
            <input type="hidden" id="sub_id" name="id" value="{{$data->id}}">
            <label for="sub-name" class="col-form-label">Name:</label>
            <input type="text" name="name" id="name" value="{{$data['name']}}" placeholder="Enter sub name" class="code">
          </div>     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button  type="submit" value="Submit" id="submit" class="submit btn btn-primary">Add</button>
        </form>
      </div>
    </div>
  </div>
</div>
        </th>
    </thead>
    <tbody>
      
    </tbody>
</table>
@endsection
<!-- <script>$(document).ready(function () {
    $("#myTable").DataTable();
    } );
</script> -->

<script>
$(document).ready(function() {
    var table =$('#myTable').DataTable( {
            "ajax": "{{url('sub/ajax')}}"
    } );
} );  
</script>
<script>
$(document).ready(function () {

$.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});


$('#myModal').on('click', '#submit', function (event) {
  
    event.preventDefault();

    var id = $("#sub_id").val();
    var name = $("#name").val();
    if($('#submit').text() == 'Add'){
    $.ajax({

      url: 'sub/save',
    
      type: "post",

      data: $("#subdata :input[name!='id']").serialize(),

      dataType: 'json',

      success: function (data) {
          $('#subdata').trigger("reset");
          $('#myModal').modal('hide');
          // window.location.reload(true);
          $('#myTable').DataTable().ajax.reload();
      }
  });
  }else if($('#submit').text() == 'Update'){
    $.ajax({
      url: 'sub/update/'+edit_id,

      type: "post",

      data: $("#subdata :input[name!='id']").serialize(),

      dataType: 'json',

      success: function (data) {
          $('#subdata').trigger("reset");
          $('#myModal').modal('hide');
          $('#submit').text("Add");
          $('.modal-title').text("Add New Record");
          // window.location.reload(true);
          $('#myTable').DataTable().ajax.reload();
      }
});
  }
});
var edit_id=0

$(document).on('click', '.edit', function(){
  var id = $(this).attr('id');
  edit_id=id;
  $('#form_result').html('');
// $('#myModal').on('click', '#editsub', function (event) {

$.ajax({
 url: 'sub/edit/'+ id,
 dataType:"json",
 success:function(data){
  $('#hidden_id').val(data.data.data.id);
  $('#class_id').val(data.data.data.class_id);
  $('.code').val(data.data.data.name);
  $('.modal-title').text("Update Record");
  $('#submit').text("Update");
  $('#myModal').modal('show');
}
});
});

$(document).on('click', '.delete', function(){
  var id = $(this).attr('id');
  $('#confirmModal').modal('show');
//  });

 $('#ok_button').click(function(){
  $.ajax({
   url: 'sub/delete/'+id,

   success:function(data)
   {
    setTimeout(function(){
     $('#confirmModal').modal('hide');
     $('#myTable').DataTable().ajax.reload();
    });
   }
  })
 });
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