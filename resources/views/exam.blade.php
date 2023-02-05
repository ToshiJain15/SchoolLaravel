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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.1/js/bootstrap-multiselect.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/1.1.1/css/bootstrap-multiselect.css">   -->

</head>
<body>
@section('form')
    <h1>Exam Form</h1>
    <form method="post" id="examdata">
    <fieldset>
        <legend>Exam</legend>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
          <div class="form-group">
            <input type="hidden" id="id" name="id" value="{{$data['id']}}">
            <label for="exam-name" class="col-form-label">Name:</label>
            <input type="text" name="name" id="name" value="{{$data['name']}}" placeholder="Enter exam name" class="code" required>
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          </div>     
          <div><label for='class'>Select class:</label></div> 
            <div><select name="class_id" id="class_id" required min=1>
            <option name='select' disabled selected value> -- select a class -- </option>
            @php
            $result = DB::select('SELECT Distinct id,name FROM classes');
            @endphp
            @foreach($result as $rec) 
              <option  value="{{$rec->id}}"<?php echo ($data['class_id'] == $rec->id) ? 'selected' : '';?> >{{$rec->name}}</option>
            @endforeach
            </select></div>      
            @error('class_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror</div>
<br><br>
            <div id="my">
              <table id="example"  style='border:2px solid black; border-collapse:collapse; text-indent:5px;'>
              <thead>
                <!-- <th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th> -->
                <th>Id</th>
                <th>Name</th>
                <th>Maximum Marks</th>
                <th>Passing Marks</th>
              </thead>
              <tbody>
              </tbody>
              </table>
              </div>

            <!-- <div>  
            <select name="sub_id[]" id="sub_id" multiple="multiple" required min=1>
              
            @php
            $result = DB::select('SELECT subjects.id, subjects.name FROM subjects left join classes on classes.id=subjects.class_id group by subjects.id');
            @endphp
            @foreach($result as $rec) 
              <option  value="{{$rec->id}}" >{{$rec->name}}</option>
            @endforeach
            </select></div>      
            @error('sub_id')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror</div> -->


      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
        <button  type="submit" value="Submit" id="submit" class="submit btn btn-primary">Save</button>
        </form>
      </div>


@endsection
<script>
  var edit_id=0;
function myfunction() {
  if(id['value']==''){
  var class_id=this.value;}
  else{
  var a= $('#class_id').val()
    class_id=a;
  }
  // class_id=i;
  $.ajax({
    
    url:"<?php echo url('/')?>/exam/ajax",
    type:'get',
    data:{class_id: class_id, exam_id:"{{$data['id']}}"},
    dataType: 'json',
    success: function(data){
      console.log(data)
      $('#example tbody').html("");
      // $('#example tbody').trigger("reset");
      console.log(data)
            var len = data.data.length;
            for(var i=0; i<len; i++){
              if(! data.subject){
                var id=data.data[i][0];
                var name = data.data[i][1];
                var tr_str = "<tr><td align='center'><input type='checkbox' name='subject_id[]' id='check' value="+id+" required></td>" +
                    "<td align='center'>" + name + "</td>" +
                    "<td align='center'><input type='text' name='max_marks[]' id='max' value='{{$data['max_marks']}}' placeholder='Enter max. marks' /></td>" +
                    "<td align='center'><input type='text' name='pass_marks[]' id='pass' value='{{$data['pass_marks']}}' placeholder='Enter passing marks' /></td></tr>";
                    }else{
                var id=data.data[i][0];
                edit_id=id;
                var name = data.data[i][1];
                var subject= data.subject[i][0];
                var max = data.subject[i][1];
                var pass = data.subject[i][2];
                console.log(subject)
                var tr_str = "<tr><td align='center'><input type='checkbox' name='subject_id[]' "+((subject == id) ?  'checked' : '') +" id='check' required value="+id+"></td>" +
                    "<td align='center'>" + name + "</td>" +
                    "<td align='center'><input type='text' name='max_marks[]' id='max' value="+max+" '{{$data['max_marks']}}' placeholder='Enter max. marks' /></td>" +
                    "<td align='center'><input type='text' name='pass_marks[]' id='pass' value="+pass+" '{{$data['pass_marks']}}' placeholder='Enter passing marks' /></td></tr>";
                    $('#submit').text('Update');
                    // $('#check').val(data.subject[i][0]);
                    // $('#max').val(data.subject[i][1]);
                    // $('#pass').val(data.subject[i][2]);
                    }
                $("#example tbody").append(tr_str);


            }
            // $('#check').click(function(){
            //       $("#"+id+).removeAttr("disabled");
            //     $("#"+id+).focus();
            //     //  $("#"+id+).prop("enabled", true);
            //     });
        // }

//       success: function (data) {
//         var $tableS = $('#example'); 
//         $tableS.html(''); 
//         data.forEach(function(row) {
//           $tableS.append("<tr><td><input type='text'  /></td><td>"+ row.name +"</td><td><input type='text'  /></td><td><input type='text'  /></td></tr>");
// });
        // $('#example').reload('exam #example');
      }
  });
$("#my").show();
}


// $(document).ready(function() {
//     var table =$('#example').DataTable( {
            
//     "processing": true,
//     "serverSide": true,
//     // "bDestroy": true,
//     // "bJQueryUI": true,
//     // "ajax": "{{url('/exam/ajax')}}"
//     "ajax": {
//         'url': '/exam/ajax',
//         'data': {
//           class_id: i
//         },
//     }
// });
//     // } );
// } );  
//   $(document).ready(function() {
//     // $('#sub_id').attr('disabled', 'disabled');
//     $("#sub_id").children('option').hide();
//     // $("#class_id").change(function() {
//     //     $("#sub_id").children('option').hide();
//         // $("#sub_id").children("option[value^=" + $(this).val() + "]").show()
//     // })
// })

  // $(document).ready(function() {       
//     $("#sub_id").hide();
//  $("#class_id").change(function() {

//   $("#sub_id").children('option').hide();
//   $("#sub_id").children("option[value^=" + $(this).val() + "]").show();
// 	$('#sub_id').multiselect({		
// 		nonSelectedText: 'Select'				
	// });
//   });
// });
$(document).ready(function () {
$.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
});


//  var i;   
if($("#class_id option[name='select']:selected")){
$("#my").hide();
}else if("#class_id option[name!='select']"){
  $("#class_id").myfunction();
}
// $("#example").hide();

$("#class_id").change(myfunction);
console.log(id['value']);
if(id['value']>0){
    
  $("#class_id").attr("disabled", true);
  function response(data){ var class_id=data.data.class_id;}
  var i = class_id['value'];
  // class_id=i;
  console.log(class_id['value'])
  $("#class_id").ready(myfunction);
  // $.ajax({
  //   url:"/exam/ajax",
  //   type:'get',
  //   dataType: 'json',
  //   success: function(data){
  //     $('#check').val(data.subject.subject_id);
  //     $('#max').val(data.subject.max_marks);
  //     alert($('#pass').val(data.subject.total))
  //   }
  // });
}
// var table = $('#example').DataTable({
//       'ajax': 'https://gyrocode.github.io/files/jquery-datatables/arrays_id.json',
//       'columnDefs': [{
//          'targets': 0,
//          'searchable':false,
//          'orderable':false,
//          'className': 'dt-body-center',
//          'render': function (data, type, full, meta){
//              return '<input type="checkbox" name="id[]" value="' 
//                 + $('<div/>').text(data).html() + '">';
//          }
//       }],
//       'order': [1, 'asc']
//    });
// // Handle click on "Select all" control
// $('#example-select-all').on('click', function(){
//       // Check/uncheck all checkboxes in the table
//       var rows = table.rows({ 'search': 'applied' }).nodes();
//       $('input[type="checkbox"]', rows).prop('checked', this.checked);
//    });

//    // Handle click on checkbox to set state of "Select all" control
//    $('#example tbody').on('change', 'input[type="checkbox"]', function(){
//       // If checkbox is not checked
//       if(!this.checked){
//          var el = $('#example-select-all').get(0);
//          // If "Select all" control is checked and has 'indeterminate' property
//          if(el && el.checked && ('indeterminate' in el)){
//             // Set visual state of "Select all" control 
//             // as 'indeterminate'
//             el.indeterminate = true;
//          }
//       }
//    });
    
//    $('#examdata').on('submit', function(e){
//       var form = this;

//       // Iterate over all checkboxes in the table
//       table.$('input[type="checkbox"]').each(function(){
//          // If checkbox doesn't exist in DOM
//          if(!$.contains(document, this)){
//             // If checkbox is checked
//             if(this.checked){
//                // Create a hidden element 
//                $(form).append(
//                   $('<input>')
//                      .attr('type', 'hidden')
//                      .attr('name', this.name)
//                      .val(this.value)
//                );
//             }
//          } 
//       });

//       // FOR TESTING ONLY
      
//       // Output form data to a console
//       $('#example-console').text($(form).serialize()); 
//       console.log("Form submission", $(form).serialize()); 
       
//       // Prevent actual form submission
//       e.preventDefault();
//    });


$('#examdata').on('click', '#submit', function (event) {
  // event.preventDefault();
  $("#examdata").validate({
    errorPlacement: function(error, element) {
    error.insertAfter( element.parent() );
    },
    rules:{
      name:"required",
      class_id :"required",
      subject_id :"required",

    },
    messages:{
      name:"Please enter your name.",
      class_id:"Please select your class.",
      subject_id:"Please select the subject.",
    },

  submitHandler: function(form) {
    var id = $("#exam_id").val();
    var name = $("#name").val();
    if($('#submit').text() == 'Save'){
    $.ajax({

      url: 'exam/save',
    
      type: "post",

      data: $("#examdata").serialize(),
      dataType: 'json',

      success: function (data) {
        // window.location.reload(true);
        location.href = "http://localhost/example-app/public/exam_list"
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
  }
});
});

$('.edit').on('click', function(){
  var id = $(this).attr('id');
  edit_id=id;
  $('#examdata').html('');
// $('#myModal').on('click', '#editexam', function (event) {

$.ajax({
 url: 'exam/edit/'+ id,
 dataType:"json",
 success:function(data){
  $('#id').val(data.data.id);
  $('.code').val(data.data.name);
  $('#class_id').myfunction();
  $('#check').val(data.data.subject_id);
  $('#max').val(data.data.max_marks);
  $('#pass').val(data.data.total);
  // $('.modal-title').text("Update Record");
  $('#submit').text("Update");
  $('#examdata').show;
  // window.location.reload('http://localhost/example-app/public/exam');
}
});
});

// $(document).on('click', '.delete', function(){
//   var id = $(this).attr('id');
//   $('#confirmModal').modal('show');
// //  });

//  $('#ok_button').click(function(){
//   $.ajax({
//    url: 'exam/delete/'+id,

//    success:function(data)
//    {
//     setTimeout(function(){
//      $('#confirmModal').modal('hide');
//      $('#example').DataTable().ajax.reload();
//     });
//    }
//   })
//  });
//  });
}); 


</script>

<!-- <div id="confirmModal" class="modal fade" role="dialog">
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
</div> -->
</body>
</html> 