<tr id="{{$user->id}}">
    <td>{{$user->id}}</td>
    <td><img width="100px" src="{{asset('Upload/users/'.$user->img)}}" alt=""></td>
    <td>{{$user->name}}</td>
    <td>{{$user->email}}</td>
    <td style="overflow-wrap: anywhere;max-width: 200px">{{$user->password}}</td>
    <td style="overflow-wrap: anywhere;max-width: 150px"> {{ $user->phone->pluck('phone')->implode(',') }}</td>
    <td>
        <button class="btn btn-info edit btn-sm" data-route="{{route('users.edit',$user->id)}}"
                data-toggle="modal" data-target="#exampleModal2">Edit <i class="fa fa-edit"></i>
        </button>
        <button class="btn btn-danger delete btn-sm" data-route="{{route('users.destroy',$user->id)}}">
            Delete <i class="fa fa-times"></i></button>
    </td>
</tr>
