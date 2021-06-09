
<ul id="errorUpdate" class="list-unstyled"></ul>
<div class="form-group">
    <label>Photo</label>
    <input type="file" id="img" name="img" class="form-control-file">
    <span id="image"><img src="{{asset('Upload/users/'.$data->img)}}" width="50px" alt=""></span>
    <input type="hidden" value="{{$data->id}}" id="id" name="id">
</div>


<div class="form-group">
    <label>Name</label>
    <input type="text" id="name" name="name" value="{{$data->name}}" class="form-control">
</div>

<div class="form-group">
    <label>Email</label>
    <input type="email" id="email" name="email" value="{{$data->email}}" class="form-control">
</div>

<div class="form-group">
    <label>Password</label>
    <input type="password" id="password" name="password" value="{{$data->password}}"
           class="form-control">
</div>

@foreach($data->phone->pluck('phone') as $index=>$number)

    <div class="form-group input_fields_wrap">
        @if($index==0)
            <button class="btn btn-primary btn-sm add_field_button">Add Phone</button>
            <input type="text" id="phone" name="phone[]" value="{{$number}}" class="form-control">
        @else
            <input type="text" id="phone" name="phone[]" value="{{$number}}" class="form-control">
            <a href="#" class="remove_field btn-sm btn-danger">Remove</a>
        @endif
    </div>
@endforeach

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
</script>
