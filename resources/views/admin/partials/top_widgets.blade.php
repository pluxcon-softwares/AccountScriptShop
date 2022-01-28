<div class="row">
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-info">
      <div class="inner">
        <h3>{{ $data['products'] }}</h3>

        <p>All Products</p>
      </div>
    
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-success">
      <div class="inner">
        <h3>{{ $data['users'] }}</h3>

        <p>User Registrations</p>
      </div>
      
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-warning">
      <div class="inner">
        <h3>${{ $data['payments'] ? sprintf('%.2f', $data['payments']) : sprintf('%.2f', 0) }}</h3>

        <p>Wallet</p>
      </div>
      
    </div>
  </div>
  <!-- ./col -->
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-danger">
      <div class="inner">
        <h3>{{ $data['tickets'] }}</h3>

        <p>Support/Ticket</p>
      </div>
      
    </div>
  </div>
  <!-- ./col -->
</div>