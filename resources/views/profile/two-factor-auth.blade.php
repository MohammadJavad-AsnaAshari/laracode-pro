@extends("profile.layout")

@section("main")
    <h4>Two Factor Auth</h4>
    <hr>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>
                        {{$error}}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="#" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="type">Type</label>
            <select name="type" class="form-control" id="type">
                <option value="off">off</option>
                <option value="sms">sms</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Please add you phone number">
        </div>

        <div class="form-group mb-3">
            <button class="btn btn-primary">Update</button>
        </div>

    </form>
@endsection
