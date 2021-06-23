@if (session()->has('error'))
<div class="alert alert-danger alert-dismissible sg-flash-message" role="alert">
    <strong>Error:</strong> {{ session('error') }}
  </div>
@endif


@if (session()->has('success'))
<div class="alert alert-success alert-dismissible sg-flash-message" role="alert">
    <strong>Success:</strong> {{ session('success') }}
  </div>
@endif
