@extends('dashboard.common.app')
@section('title','dashboard')
@section('content')

    <h1 class="p-3">All Users! <i class="fas fa-ad"></i></h1>

    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12">
                <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"> Add New User</button>
                <hr>
            </div>
            <div class="col-sm-12">
                <h3 class="col alert alert-info text-center"> All Users</h3>
                <table class="table">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#Id</th>
                        <th scope="col">image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">password</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody class="cont-data">
                    @foreach($users as $user)
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
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addClient" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="error" class="list-unstyled"></ul>
                        <div class="form-group">
                            <label>Photo</label>
                            <input type="file" name="img" class="form-control-file">
                        </div>

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group input_fields_wrap">
                            <button class="btn btn-primary btn-sm add_field_button">Add Phone</button>
                            <input type="text" name="phone[]" class="form-control">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Save changes" name="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="updateClient" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body edit-aa">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit"id="change" class="btn btn-primary" value="Save changes" name="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>

@section('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
{{--    <script src="{{asset('/assets')}}/js/jquery-3.4.1.js"></script>--}}
{{--    <script src="{{asset('/assets')}}/js/popper.min.js"></script>--}}
{{--    <script src="{{asset('/assets')}}/js/bootstrap.min.js"></script>--}}
    <script>

            $(document).ready(function () {
            // var max_fields = 2;
            var wrapper = $(".input_fields_wrap");
            var add_button = $(".add_field_button");
            // var x = 1;
            $(add_button).click(function (e) {
            e.preventDefault();
            $(wrapper).append('<div><input type="text" name="phone[]" class="form-control"/><a  href="#" class="remove_field btn-sm btn-danger">Remove</a></div>');
            // x++;
        });

            $(wrapper).on("click", ".remove_field", function (e) {

            e.preventDefault();
            $(this).parent('div').remove();
            // x--;
        })
        });

///////////////////////////////////////////////////////////////
        $.ajaxSetup({
            headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $("#addClient").submit(function (e)
        {
            e.preventDefault();
            var formData = new FormData(jQuery('#addClient')[0]);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "{{route('users.store')}}",
                data: formData,
                contentType: false,
                processData: false,

                success: function (dataBack) {

                    $("#error").html("<li class='alert alert-success text-center p-1'> Added Success </li>");
                    $(".cont-data").prepend(dataBack)
                    $('#exampleModal').modal('hide')


                }, error: function (xhr, status, error)
                {
                     var html;
                    $.each(xhr.responseJSON.errors, function (key, item)
                    {
                       html+=  "<li class='alert alert-danger text-center p-1'>" + item + " </li>"
                        // $("#error").html("<li class='alert alert-danger text-center p-1'>" + item + " </li>");
                    })
                    $("#error").html(html);
                }
            })

        })

        $(".edit").click(function () {
            var route = $(this).attr("data-route");
            var num ;
            $.ajax({
                url: route,
                type: "GET",
                // dataType: "JSON",

                success: function (dataBack) {

                         $(".edit-aa").html(dataBack)

                    {{--$("#phone").each(function (){--}}
                    {{--    num+=  '<input type="text" name="phone[]" value="('+dataBack.phone+')" class="form-control"/>';--}}
                    {{--})--}}
                    {{--$("#phone").html(num);--}}

                    {{--$("#image").html("<img width='100px' src='{{asset('Upload/users/')}}/"+dataBack.img+"' >");--}}
                    {{--$("#name").val(dataBack.name);--}}
                    {{--$("#email").val(dataBack.email);--}}
                    {{--$("#password").val(dataBack.password);--}}
                    {{--// $("#phone").val(dataBack.phone);--}}
                    {{--// $(wrapper).append('<div><input type="text" name="phone[]" value="('+dataBack.phone+')" class="form-control"/><a  href="#" class="remove_field btn-sm btn-danger">Remove</a></div>');--}}
                    {{--$("#id").val(dataBack.id);--}}

                }

            });
        })

        $("#updateClient").submit(function (e) {
            e.preventDefault();
            var formData  = new FormData(jQuery('#updateClient')[0]);
            formData.append('_method','PUT');
            var idRow = $("#id").val();
            $.ajax({

                url: "/{{App::getLocale()}}/admin/users/" + idRow,
                type: "POST",
                enctype: 'multipart/form-data',
                data: formData,
                contentType: false,
                processData: false,
                cache: false,

                success: function (dataBack) {

                    $("#errorUpdate").html("<li class='alert alert-success text-center p-1'> Added Success </li>");
                    $("#" + idRow).html(dataBack);
                    $('#exampleModal2').modal('hide')


                }, error: function (xhr, status, error) {

                    $("#errorUpdate").html('');

                    $.each(xhr.responseJSON.errors, function (key, item) {

                        $("#errorUpdate").html("<li class='alert alert-danger text-center p-1'>" + item + " </li>");
                    })
                }
            })

        })

        $(document).on("click", ".delete", function () {
            var route = $(this).attr("data-route");
            $.ajax({
                type: "DELETE",
                url: route,
                success: function (data) {
                    alert(data.message);
                    $("#" + data.id).remove();
                }

            });
        })

    </script>

@endsection
@endsection
