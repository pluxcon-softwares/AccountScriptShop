@extends('user.layouts.master')

@section('title')

@endsection

@section('content')

<div class="row mt-3">

    <div class="col-md-7">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><i class="fa fa-comment"></i> Message Board</h3>

          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-nowrap" id="messageTbl" style="width: 100%">
              <thead>
                <tr>
                  <th>Message</th>
                  <th width='10%'>Action</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>


      <div class="col-md-5" style="text-align: center">

      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title"><i class="fas fa-money-bill-alt"></i> Account Balance ${{ sprintf('%.2f', Auth::user()->wallet) }}</h3>
        </div>
        
      </div>

      <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user"></i> My Account</h3>

          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <a href="{{route('add.money')}}" class="btn btn-sm btn-danger" style="padding: 20px 10px 20px 10px; font-size:15px; margin-right:10px;"><i class="fas fa-plus-circle"></i> Add Balance</a>
            <a href="{{route('purchases')}}" class="btn btn-sm btn-primary" style="padding: 20px 10px 20px 10px; font-size:15px; margin-right:10px;"><i class="fas fa-shopping-cart"></i> My Orders</a>
            <a href="{{route('tickets')}}" class="btn btn-sm btn-primary" style="padding: 20px 10px 20px 10px; font-size:15px;"><i class="fas fa-comments-o"></i> Open Ticket</a>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
       
      </div>

</div>

@include('user.partials._view-message')

@endsection

@section('extra_script')

<script>
$(function(){

    //Initialize message datatabl
    var messageTbl = $('#messageTbl').DataTable({
      ajax:{
        url: '/messages',
      },
      columns:[
        {data: 'title'},
        {
          data: 'id',
          render: (id)=>{
            return `
              <button class='btn btn-sm btn-primary view_message' data-message_id='${id}'>
              <div class='spinner spinner-border spinner-border-sm' style='display:none;'></div>
              view  
              </button>
            `;
          }
        }
      ]
    });

    // View Message
    $('#messageTbl').on('click', '.view_message', function(e){
      e.stopImmediatePropagation();
      var message_id = e.currentTarget.dataset['message_id'];
      $.ajax({
        url: `/message/${message_id}`,
        beforeSend:()=>{
          e.currentTarget.children[0].style.display = 'inline-block';
        },
        complete:()=>{
          e.currentTarget.children[0].style.display = 'none';
        },
        success:(res)=>{
          $('#viewMessageModal .modal-body .message').remove();
          $('#viewMessageModal .modal-body').append(`
          <div class='message'>
            <h5>${res.message.title}</h5>
            <p><span class='badge badge-success'>Date ${moment(res.message.created_at).format('ll')}</span></p>
            <p>${res.message.body}</p>
          </div>
          `);
        }
      });
      $('#viewMessageModal').modal('show');
    });

    
});
</script>

@endsection
