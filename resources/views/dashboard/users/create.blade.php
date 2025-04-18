@extends('dashboard.layouts.master')

{{-- اول سكشن هوي العناون  --}}
{{-- انا كنت عامل يلد اسمو تايتل هون عم اعطيه قيمة  --}}
@section('title')
@endsection
{{-- فينا نحط اند سكشن او ستووب نفس الشي --}}
{{-- تاني يلد تبع السي اس اس  --}}
{{-- بحط فيه السي اس اس الخاص بهي الصفحة فقط  --}}
@section('css')
@stop

@section('title_page')

@stop
@section('tiltle_page2')
@stop

@section('contant')
<div class="container">
    <h2>Create New User</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required   autocomplete="off">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required autocomplete="new-password">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
                <option value="super-admin">Super Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>
@endsection

@section('scripts')
@endsection

