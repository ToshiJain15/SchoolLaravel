@extends('nav_head')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
</head>
<body>
@section('form')
<h1>Add Form</h1>
    <form method="post" action="{{url('class/save')}}" padding="10">
        <fieldset padding="5" margin="6">
        <legend padding= "5px 10px">Add</legend>
        <input type='hidden' name='id' value="{{$data->id}}" />
    <!-- <input type="hidden" name="_method" value="PUT"> -->
        @csrf
    <table>
        <tr><td>Name : </td>
        <td><input type="text" placeholder='type here' name="name" value="{{$data['name']}}" required/>
        @error('name')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    </td></tr>      
    </table>
</br>
    
    @if(Request::url() == ('http://localhost/example-app/public/class/edit/'.$data['id']))
    <input type="submit" value="Update"/>
    @else
    <input type="submit" value="Add"/>
    @endif
</br>  
        </fieldset>
    </form>
@endsection
<!-- <script>
$("form").validate();
</script> -->
<script>
$().ready(function(){
  $("form").validate({
    rules:{
      name:"required",
    },
    messages:{
      name:"<br>Please enter your name.",

    }
  });
});
</script>
</body>
</html> 