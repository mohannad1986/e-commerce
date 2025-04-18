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
{{-- ++++++++++++++++++++++++++++++ --}}
<div class="container mt-5">
    <h2>قائمة المستخدمين</h2>
      {{-- زر لإضافة مستخدم جديد --}}
      <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">
        إضافة مستخدم جديد
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>الدور</th>
                <th>الصلاحيات</th>
                <th>تاريخ الإنشاء</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        {{-- @foreach($user->permissions as $permission)
                            <span class="badge bg-success">{{ $permission->name }}</span>
                        @endforeach --}}
                        @foreach($user->getAllPermissions() as $permission)
                        <span class="badge bg-success">{{ $permission->name }}</span>
                    @endforeach                       
                    </td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- +++++++++++++++++++++++++++++++++ --}}
@endsection

@section('scripts')
@endsection

