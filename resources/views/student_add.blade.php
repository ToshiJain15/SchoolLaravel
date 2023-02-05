@extends('nav_head')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <script src="http://code.jquery.com/jquery-2.1.1.min.js" > </script> -->
    <!-- <script src="js/jquery.validate.js"></script> -->
        <!-- <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <!-- <script src="js/jquery.signup .js"></script> -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script> 
<script type='text/javascript'>
        function previewImage(event) 
        {
            let read = new FileReader();
            read.onload = function(){
            let output = document.getElementById('prev');
            output.src = read.result;
           }
         read.readAsDataURL(event.target.files[0]);
        }
</script>
</head>
<body>
@section('form')
<h1>Student Form</h1>
    <form id="form" method="post" action="{{url('student/save')}}" padding="10">
        <fieldset padding="5" margin="6">
        <legend padding= "5px 10px">Student Details</legend>
        <input type='hidden' name='id' value="{{$data->id}}" required/>
        @csrf
        <table>
            <tr>
           <td><label for='s_name'>Enter name: </label></td>
           <td><input type='text' placeholder='type here' name='name' value='{{$data->name}}' />
           @error('name')
           <div class="alert alert-danger">{{ $message }}</div>
           @enderror
          </td></tr>
            <tr>
            <td><label for='address'>Enter address:</label></td> 
            <td><textarea name='address' rows="5" cols="40" value='' required>{{$data->address}}</textarea>
            @error('address')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          </td>
            </tr>
            <tr>
           <td><label for='s_email'>Enter email: </label></td>
           <td><input type='email' placeholder='type here' name='email' value='{{$data->email}}' required email>
           @error('email')
           <div class="alert alert-danger">{{ $message }}</div>
           @enderror
          </td></tr>
           <tr>
            <td><label for='gender'>Gender: </gender></td>  
            <td>
           <input type="radio"  id='male' name='gender' value='Male'<?php echo ($data['gender'] == 'Male') ? 'checked' : ''; ?> >Male
           <input type="radio"  id='female' name='gender' value='Female'<?php echo ($data['gender'] == 'Female') ? 'checked' : ''; ?>>Female</td>
          <td> @error('gender')
           <div class="alert alert-danger">{{ $message }}</div>
           @enderror</td>
        </tr>

        <tr>
       <td><label for='hobbies[]'>Hobbies: </label><br>
      @php 
      $hobby=['Cricket', 'Bowling', 'Singing', 'Dancing', 'Gardening'];
      @endphp
      <?php 
   foreach ($hobby as $val){
     if ($data['hobbies'] == '')
       { 
         echo "<input type='checkbox' value = ".$val." name = 'hobbies[]' >".$val."<br>";
       }
       else
       {
        $hobbies=explode(', ', $data->hobbies); 
       echo "<input type='checkbox' value = ".$val." name = 'hobbies[]' ". (in_array($val,$hobbies) ? 'checked' : '') ." >".$val."<br>";
      
       }
   }
   
   ?>         @error('hobbies') <div class="alert alert-danger">{{ $message }}</div> @enderror </td></tr>

           <tr><td><label for='class'>Enter class:</label></td> 
            <td><select name="class_id" required min=1>
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
            @enderror</td></tr>
           <tr><td><label for='occupation' >Enter occupation:</label></td> 
            <td><select name="occupation" required min=1>
            <option disabled selected value> -- select occupation -- </option>
            @php
            $res = DB::select('SELECT Distinct id,name FROM occupations');
            @endphp
            @foreach($res as $rec) 
              <option  value="{{$rec->id}}"<?php echo ($data['occupation'] == $rec->name) ? 'selected' : '';?> >{{$rec->name}}</option>
            @endforeach
            </select>
            @error('occupation')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
          </td></tr>

            <tr>
              <td> <label for="languages[]">Select the languages:</label></td>
              <td><select name="languages[]" multiple="multiple" >
              @php  
              $language=['English', 'Hindi', 'French', 'Bengali', 'Malayalam', 'Marathi', 'Tamil']; 
              @endphp
              <?php 
              foreach ($language as $rec){
                if ($data['languages'] == '')
                { 
                  echo "<option value=".$rec."> $rec</option>";
                }
                else
                {
                  $languages=explode(', ', $data->languages); 
                  echo " <option value=".$rec." name='languages[]' ". (in_array($rec,$languages) ? 'selected' : '') ."> $rec</option>";
                }
              }
              ?> 

            </td>
            </tr><br>
            <tr>
              <td>Select image to upload:</td>
              <td><input type="file" name="photo" onchange="previewImage(event)" value='<?php echo $data['photo']?>'/>{{$data['photo']}}   
              <?php if($data['photo']){ echo "<tr><td><img src=".$data['photo']."></td></tr>"; } ?> <tr><td><img id="prev"/></td>
              @error('photo')
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror</td>
            </tr>
            <tr>
              <td> @if(Request::url() == ('http://localhost/example-app/public/student/edit/'.$data['id']))
            <input type="submit" value="Update"/>
            @else
            <input type="submit" value="Add"/>
            @endif
              </td>
            </tr>
        </table>  
    </fieldset>
    </form>
@endsection
<!-- <script>
$("form").validate();
</script> -->
<script>
$().ready(function(){
  $("form").validate({
    errorPlacement: function(error, element) {
    error.insertAfter( element.parent() );
  },
    rules:{
      name:"required",
      address : {
        required:true,
        minlength: 3,
          maxlength: 30,
        },
      email : {
        required:true,
        email:true
        },
        gender:"required",
     'hobbies[]': {
        required:true,
        minlength:1
        },
      class_id : "required",
      occupation : "required",
      'languages[]' :  {
        required:true,
        minlength:1
        },
     photo:{
       required:true,
      //  accept:"jpg|jpeg|png|ico|bmp"
       accept:"image/*"
     },
    },
    messages:{
      name:"Please enter your name.",
      address : "Please enter your address.",
      email : {
        required:"Please enter your email.",
        email:"Please enter a valid email address."
        },
       gender : "Please select your gender",
      'hobbies[]' : "Please select at least 1.",
      'languages[]' : "Please select at least 1.",
       photo: {
        required:"Please select an image.",
        accept:"Please select a valid image type."
        },
    }
  });

});
</script>
<script></script>
</body>
</html> 
