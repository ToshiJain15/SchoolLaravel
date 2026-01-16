<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>User Form</h1>
    <form method="post" action="{{url('save')}}">
        <input type='hidden' name='id' value="{{$data->id}}" />
    <!-- <input type="hidden" name="_method" value="PUT"> -->
        @csrf
    <table text-align="center">
        <tr><td>User: </td>
        <td><input type="email" placeholder='type here' name="email" value="{{$data['email']}}"/></td></tr>
        <td>Password :</td>
        <td><input type="password" placeholder='type here' name="password" value="{{$data['password']}}" /> </td></tr>      
    </table>
</br>
    <!-- <button type="submit">Save</button>  -->
    @if(Request::url() == url('edit/'.$data['id']))
  
    <input type="submit" value="Update"/>
    @else
    <input type="submit" value="Add"/>
    @endif
</br>  
</form>
</br>

<!-- <table style='border:2px solid black; border-collapse:collapse; text-indent:5px;'>
    <thead>
        <th>Id</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        @foreach($user as $rec) 
        <tr>
            <td>{{$rec->id}}</td>
            <td>{{$rec->first_name}}</td>
            <td>{{$rec->last_name}}</td>
            <td>{{$rec->email}}</td>
            <td>
                <a href="{{url('edit/'.$rec->id)}}" >Edit</a>
            </td>
            <td>
                <a href="{{url('delete/'.$rec->id)}}" >Delete</a>
            </td>
        </tr>
        @endforeach
</tabel> -->

</body>
</html> 