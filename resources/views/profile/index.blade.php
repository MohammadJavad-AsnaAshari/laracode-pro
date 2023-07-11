@extends("profile.layout")

@section("main")
    <h4>Your Profile</h4>
    <hr>

    <h5>Name: {{$user->name}}</h5>
    <h5>Email: {{$user->email}}</h5>
@endsection
