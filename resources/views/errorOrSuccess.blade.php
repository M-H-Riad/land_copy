@if (count($errors) > 0)
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if (session('success'))
<div class="alert alert-success">
    <p>{{session('success')}}</p>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger">
    <p>{{session('error')}}</p>
</div>
@endif