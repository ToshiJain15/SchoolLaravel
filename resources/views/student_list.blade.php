@extends('nav_head')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->

    <!-- <script src="sweetalert2.min.js"></script> -->
    <!-- <link rel="stylesheet" href="sweetalert2.min.css"> -->
    
    <script src="jquery-3.6.0.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <!-- <script src="jquery-3.6.0.js"></script> -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
    .delete{
    font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif; 
    }
    </style>
<script>
  $( function() {
    $( "#datepicker" ).datepicker({
      dateFormat: 'yy-mm-dd'
    })
  } );
</script>
 </head>
<body>
@section('form')
    <h1>Student List</h1>

    <table id="myTable" style='text-align:center;'>
        <thead>
              <th>Name</th>
              <th>Address</th>
              <th>Email</th>
              <th>Date of Birth</th>
              <th>Gender</th>
              <th>Hobbies</th>
              <th>Class</th>
              <th>Occupation</th>
              <th>Languages</th>
              <th>Photo</th>
              <!-- <th ><input type="button" value="Add" onclick="window.location.href='{{ url('student/render') }}'"></th> -->

              <th><button type="button" class="add btn btn-primary" data-toggle="modal" data-target="#myModal">Add Student</button>

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
        <form method="post" id="studentdata">       
        <fieldset padding="5" margin="6">
        <legend id="leged" padding= "5px 10px">Student Details</legend>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
          <div class="form-group">
            <input type="hidden" id="student_id" name="id" value="{{$data->id}}">
            <label for="student-name" class="col-form-label">Name:</label>
            <input type="text" name="name" id="name" value="" placeholder="Enter student name" class="code" value='{{$data->name}}' required>
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
             @enderror
          </div> 
          <div><label for='address'>Enter address:</label></div> 
            <div><textarea name='address' id='address' rows="5" cols="40" value='' required>{{$data->address}}</textarea>
            @error('address')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          </div>
            
            
           <div><label for='s_email'>Enter email: </label></div>
           <div><input type='email' id='email' placeholder='type here' name='email' value='{{$data->email}}' required email>
           @error('email')
           <div class="alert alert-danger">{{ $message }}</div>
           @enderror
          </div>
            
           <div><label for='s_email'>Enter date of birth: </label></div>
           <div><input type="text" id="datepicker" placeholder='type here' name='dob' value='{{$data->dob}}'>
           @error('dob')
           <div class="alert alert-danger">{{ $message }}</div>
           @enderror
          </div>
           
            <div><label for='gender'>Gender: </gender></div>  
            <div>
           <input type="radio"  class='gender'  name='gender' id='male' value='Male'<?php echo ($data['gender'] == 'Male') ? 'checked' : ''; ?> >Male
           <input type="radio" class='gender'  name='gender' id='female' value='Female'<?php echo ($data['gender'] == 'Female') ? 'checked' : ''; ?>>Female</div>
          <div> @error('gender')
           <div class="alert alert-danger">{{ $message }}</div>
           @enderror</div>
        

        
       <div><label for='hobbies[]'>Hobbies: </label><br>
      @php 
      $hobby=['Cricket', 'Bowling', 'Singing', 'Dancing', 'Gardening'];
      @endphp
      <?php 
   foreach ($hobby as $val){
     if ($data['hobbies'] == '')
       { 
         echo "<input type='checkbox' value = ".$val." id=".$val." class='hobbies' name = 'hobbies[]' >".$val."<br>";
       }
       else
       {
        $hobbies=explode(', ', $data->hobbies); 
       echo "<input type='checkbox' value = ".$val." id=".$val." class='hobbies' name = 'hobbies[]' ". (in_array($val,$hobbies) ? 'checked' : '') ." >".$val."<br>";
      
       }
   }
   
   ?>         @error('hobbies') <div class="alert alert-danger">{{ $message }}</div> @enderror </div>

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
           <div><label for='occupation' >Enter occupation:</label></div> 
            <div><select name="occupation" id="occupation" required min=1>
            <option disabled selected value> -- select occupation -- </option>
            @php
            $res = DB::select('SELECT Distinct id,name FROM occupations');
            @endphp
            @foreach($res as $rec) 
              <option  id="{{$rec->id}}" value="{{$rec->id}}"<?php echo ($data['occupation'] == $rec->name) ? 'selected' : '';?> >{{$rec->name}}</option>
            @endforeach
            </select>
            @error('occupation')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          </div>

            
              <div> <label for="languages[]">Select the languages:</label></div>
              <div><select name="languages[]" class='languages' multiple="multiple" >
              @php  
              $language=['English', 'Hindi', 'French', 'Bengali', 'Malayalam', 'Marathi', 'Tamil']; 
              @endphp
              <?php 
              foreach ($language as $rec){
                if ($data['languages'] == '')
                { 
                  echo "<option id=".$rec." value=".$rec."> $rec</option>";
                }
                else
                {
                  $languages=explode(', ', $data->languages); 
                  echo " <option value=".$rec." name='languages[]' id=".$rec." ". (in_array($rec,$languages) ? 'selected' : '') ."> $rec</option>";
                }
              }
              ?> 

            </div>
            <br>
              <div for='photo'>Select image to upload:</div>
              <div><input type="file" name="photo" id='photo'  value='<?php echo $data['photo']?>'/>{{$data['photo']}}   
              <?php if($data['photo']){ echo "<div><img src=".$data['photo']."></div>"; } ?></div>
              <!-- <div id="progress-wrp">
                <div class="progress-bar"></div>
                <div class="status">0%</div>
              </div> -->
              @error('photo')
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror</div>
                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        @if(Request::url() == url('student'))
    <input type="submit"  id="submit" class="add btn btn-primary" value="Add"/>
    @else
    <input type="submit"  id="submit" class="update btn btn-primary" value="Update"/>
    @endif
        </fieldset>
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
    $("#my").DataTable();
    } );
</script> -->
<script>
$(document).ready(function() {
    $('#myTable').DataTable( {
                "ajax": "{{url('student/ajax')}}"
    } );
} );  
</script>
<script>
  // if(jQuery('.add').click){
//   $('#submit').val("Add");
// }else if(jQuery('.edit').click) {
//   $('#submit').val("Update");
// }
$(document).ready(function (){

$.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});

$('#myModal').on('click', '#submit', function (event) {
  
    event.preventDefault();

    var id = $("#student_id").val();
    var name = $("#name").val();
    // var formdata = $($("#studentdata")[0].elements).not("id").serialize();
    var formd = $("#studentdata :input[name!='id']").serialize()+(photo);
    console.log(formd);
    // var Upload = function (file) {
    // this.file = file;
    //  };

    //  Upload.prototype.getType = function() {
    //      return this.file.type;
    //  };
    //  Upload.prototype.getSize = function() {
    //      return this.file.size;
    //  };
    //  Upload.prototype.getName = function() {
    //      return this.file.name;
    //  };
    //  Upload.prototype.doUpload = function () {
    //      var that = this;
    //      var formData = new FormData();
     

    // // add assoc key values, this will be posts values
    // formData.append("file", this.file, this.getName());
    // formData.append("upload_file", true);
    
    // $("#photo").on("change", function (e) {
    // var file = $(this)[0].files[0];
    // var upload = new Upload(file);

    // // maby check size or type here with upload.getSize() and upload.getType()

    // // execute upload
    // upload.doUpload();
    // });


    if($('#submit').val() == 'Add'){

    $.ajax({

      url: 'student/save',
    
      type: "post",

      // xhr: function () {
      //       var myXhr = $.ajaxSettings.xhr();
      //       if (myXhr.upload) {
      //           myXhr.upload.addEventListener('progress', that.progressHandling, false);
      //       }
      //       return myXhr;
      //   },

      data: $("#studentdata :input[name!='id']").serialize(),

      dataType: 'json',

      success: function (data) {
          $('#studentdata').trigger("reset");
          $('#myModal').modal('hide');
         
          // window.location.reload(true);
          $('#myTable').DataTable().ajax.reload();
      },

        // async: true,
        // data: formData,
        // cache: false,
        // contentType: false,
        // processData: false,
        // timeout: 60000
  });
  }else if($('#submit').val() == 'Update'){
    $.ajax({
      url: 'student/update/'+edit_id,

      type: "post",

      // xhr: function () {
      //       var myXhr = $.ajaxSettings.xhr();
      //       if (myXhr.upload) {
      //           myXhr.upload.addEventListener('progress', that.progressHandling, false);
      //       }
      //       return myXhr;
      //   },

      data: $("#studentdata :input[name!='id']").serialize(),
      // data: {
      //   // id: id,
      //   name: name,
      //   address: address,
      //   email: email,
      //   gender: gender,
      //   hobbies: hobbies,
      //   class_id: class_id,
      //   occupation: occupation,
      //   languages:  languages,
      //   photo: photo,
      // },
      dataType: 'json',

      success: function (data) {
          $('#studentdata').trigger("reset");
          $('#myModal').modal('hide');
          $('#submit').val("Add");
          $(".hobbies").removeAttr('checked');
          // $(".gender").attr('checked', false);
          // jQuery('[name="hobbies[]"]').attr("checked",false);
          $('.modal-title').text("Add New Record");
          // window.location.reload(true);
          $('#myTable').DataTable().ajax.reload();
      },
  
        // async: true,
        // data: formData,
        // cache: false,
        // contentType: false,
        // processData: false,
        // timeout: 60000
});
}
// };
// Upload.prototype.progressHandling = function (event) {
//   var percent = 0;
//   var position = event.loaded || event.position;
//   var total = event.total;
//   var progress_bar_id = "#progress-wrp";
//   if (event.lengthComputable) {
//       percent = Math.ceil(position / total * 100);
//   }
//   // update progressbars classes so it fits your code
//   $(progress_bar_id + " .progress-bar").css("width", +percent + "%");
//   $(progress_bar_id + " .status").text(percent + "%");
// };
});
});
var edit_id=0;

$(document).on('click', '.edit', function(){
  var id = $(this).attr('id');
  edit_id=id;
  $('#form_result').html('');
// $('#myModal').on('click', '#editstudent', function (event) {

$.ajax({
 url: 'student/edit/'+ id,
 dataType:"json",
 success:function(data){
  $('#hidden_id').val(data.data.data.id);
  $('.code').val(data.data.data.name);
  $('#address').val(data.data.data.address);
  $('#email').val(data.data.data.email);
  $('#datepicker').val(data.data.data.dob);
  $(".gender").removeAttr('checked');
  $(".gender[value='"+data.data.data.gender+"']").prop('checked', true);
  // $('#gender').val(data.data.data.gender);
  var hobbies =[];
  hobbies = ((data.data.data.hobbies).split(','));
  $.each( hobbies, function( key, a) {
  jQuery('[name="hobbies[]"][value='+a+']').attr("checked","checked");
  });
 
  // var hobbies=[];
  // $("input[name='hobbies[]']").each(function(){if($(this).is(':checked')){hobbies.push($(this).val());}});

  $('#class_id').val(data.data.data.class_id);
  $('#occupation').val(data.data.data.occupation);  
  $('.languages').val((data.data.data.languages).split(', '));
 
  // $('#photo').val(data.data.data.photo);
  $('.modal-title').text("Update Record");
  $('#submit').val("Update");
  $('#myModal').modal('show');
}
});
});

// $(document).on('click', '.delete', function(){
//   var id = $(this).attr('id');
//   $('#confirmModal').modal('show');
// //  });

//  $('#ok_button').click(function(){
//   $.ajax({
//    url: 'student/delete/'+id,

//    success:function(data)
//    {
//     setTimeout(function(){
//      $('#confirmModal').modal('hide');
//      $('#myTable').DataTable().ajax.reload();
//     });
//    }
//   })
//  });
//  });
// }); 


$(document).on('click', '.delete', function(){
  event.preventDefault();
  var id = $(this).attr('id');

  Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    $.ajax({
        // method: 'POST',
        // data: {'delete': true, 'v_id' : id },
        url: 'student/delete/'+id,
        success: function(data) {
          $('#myTable').DataTable().ajax.reload();
        }
    });
    Swal.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )
  }
})
});

</script>

<!-- // <div id="confirmModal" class="modal fade" role="dialog">
//     <div class="modal-dialog">
//         <div class="modal-content">
//             <div class="modal-header">
//                 <button type="button" class="close" data-dismiss="modal">&times;</button>
//                 <h2 class="title"></h2>
//             </div>
//             <div class="modal-body">
//                 <h4 style="margin:0;"></h4>
//             </div>
//             <div class="modal-footer">
//              <button type="button" name="ok_button" id="ok_button" class="btn btn-danger"></button>
//                 <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
//             </div>
//         </div>
//     </div>
// </div>  -->

</body>
</html>