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

{{-- +++++++++++++++ --}}
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3>Add New Product</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Details</label>
                    <input type="text" name="details" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" name="price" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Featured</label>
                    <select name="featured" class="form-select">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Product Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Additional Images</label>
                    <input type="file" name="images[]" class="form-control" multiple>
                </div>

                <button type="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>
    </div>
</div>
{{-- +++++++++++++++++++++ --}}
@endsection

@section('scripts')
@endsection

