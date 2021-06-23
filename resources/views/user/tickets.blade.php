@extends('user.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')

    <div class="row" style="margin-top: 3%;">
        <div class="col-md-12 ml-auto mr-auto">
            <div class="card card-blue">
                <div class="card-header">
                  <h2 class="card-title"><i class="fa fa-ticket"></i> Tickets</h2>
                  <a href="#" class="btn btn-sm btn-danger fa-pull-right" id="createTicketBtn"><i class="fa fa-plus-square"></i> Create Ticket</a>
                </div>
                <div class="card-body">
                    <table id="ticketsDataTable" class="table table-responsive" style="font-size: 14px; width:100%;">
                        <thead>
                            <tr>
                                <th style="width: 20%; font-size:12px;">DATE</th>
                                <th style="width: 40%; font-size:12px;">SUBJECT</th>
                                <th style="width: 15%; font-size:12px;">STATUS</th>
                                <th style="width: 20%; font-size:12px;">VIEW REPLY</th>
                                <th style="width: 20%; font-size:12px;">DELETE</th>
                            </tr>
                        </thead>
                        <tbody id="ticketsTbody">
                            @foreach ($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->created_at->diffForHumans() }}</td>
                                <td>{{ $ticket->subject }}</td>
                                <td>
                                    @if ($ticket->status)
                                        <i class="badge badge-success badge-pill">Resolved</i>
                                    @else
                                        <i class="badge badge-danger badge-pill">UnResolved</i>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if ($ticket->status)
                                        <button data-ticket_id="{{ $ticket->id }}" class="btn btn-xs btn-success view-reply-btn">View Reply</button>
                                    @else
                                        <h6>Not Replied</h6>
                                    @endif
                                </td>
                                <td style="text-align: center;">
                                    @if ($ticket->status)
                                        <button data-ticket_id="{{ $ticket->id }}" class="btn btn-xs btn-danger delete-reply-btn">
                                            <div class="spinner spinner-border spinner-border-sm" style="display: none;"></div>
                                            Delete</button>
                                    @else
                                        <h6>N/A</h6>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
              </div>
        </div>
    </div>


    <!-- Modal - Open Ticket Modal -->
<div class="modal fade" id="createTicketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('open.ticket') }}" method="POST" id="open_ticket_frm">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Open Ticket</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                </div>

                <div class="form-group">
                    <textarea name="message" id="message" class="form-control" cols="30" rows="8" placeholder="Your Message"></textarea>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-sm btn-primary">
                <div class="spinner spinner-border spinner-border-sm"></div>
                Submit
                </button>
            </div>
          </div>
      </form>
    </div>
  </div>


    <!-- Modal - View Ticket Reply Modal -->
<div class="modal fade" id="viewReplyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ticket Reply</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <!-- Content Here -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
    </div>
  </div>

@endsection

@section('extra_script')
    <script>
        $(function(){
            $("#ticketsDataTable").DataTable({});

            //Create Ticket Modal Window
            function openTicket()
            {
                $("#createTicketModal").modal('hide');
                $("#createTicketBtn").on('click', function(){
                    $("div.spinner").hide();
                    $("#createTicketModal").modal('show');
                });

                $("#open_ticket_frm").submit(function(e){
                    e.preventDefault();
                    var formAction = $("form[id='open_ticket_frm']").attr('action');
                    var csrfToken = $("input[name='_token']").val();
                    var subject = $("input[id='subject']").val();
                    var message = $("textarea[id='message']").val();
                    $.ajax({
                        url: formAction,
                        method: 'POST',
                        dataType: 'JSON',
                        data: {
                            '_token': csrfToken,
                            'subject': subject,
                            'message': message
                        },
                        beforeSend: function(){
                            $("div.spinner").show();
                            $("button[type=submit]").attr('disabled', true);
                        },
                        complete: function(){
                            $("div.spinner").hide();
                            $("button[type=submit]").attr('disabled', false);
                        },
                        success: function(res){
                            if(res.errors)
                            {
                                $("span.form_errors").remove();
                                $(`<span style="color:red" class="form_errors">${res.errors.subject}*</span>`).insertBefore("input[id='subject']");
                                $(`<span style="color:red" class="form_errors">${res.errors.message}*</span>`).insertBefore("textarea[id='message']");
                            }

                            if(res.status){
                                $("#createTicketModal").modal('hide');
                                swal.fire({
                                    title: "Open Ticket",
                                    text: "Your ticket has been sent, you will receive response soon!",
                                    icon: "success"
                                });
                                window.location.reload();
                            }
                        }
                    });
                });
            }
            // End of openTicket function
            openTicket();


            // View Ticket Replies
            function viewTicketReply()
            {
                $("#ticketsTbody").on('click', '.view-reply-btn', function(evt){
                    evt.preventDefault();
                    //Modal - #viewReplyModal - .modal-dialog
                    $.ajax({
                        url: '/ticket/view-ticket-reply/' + evt.currentTarget.dataset.ticket_id,
                        method: 'GET',
                        success: function(res){
                            var viewReplyModal = $("#viewReplyModal");
                            $("#viewReplyModal .modal-body").empty();
                            $.each(res.replies, function(k, v){
                                var replies = `
                                <div class="card" style="margin-bottom:20px;">
                                <div class="card-body">
                                    <p>${v.reply}</p>
                                    <p><span class="badge badge-danger badge-pill">Username: ${v.username}</p>
                                    <p><span class="badge badge-danger badge-pill">Date: ${moment(v.created_at).format('ll')}</span></p>
                                </div>
                                </div>
                                `;
                                $("#viewReplyModal .modal-body").append(replies);
                                viewReplyModal.modal('show');
                            });
                        }
                    });
                });
            }
            //End of viewTicketReply function
            viewTicketReply();

            //Delete Ticket Reply
            function deleteTicket(){
                $("#ticketsTbody").on('click', '.delete-reply-btn', function(e){
                    e.preventDefault();
                    var ticket_id = e.currentTarget.dataset.ticket_id;
                    $.ajax({
                        url: `/ticket/delete-ticket/${ticket_id}`,
                        method: 'GET',
                        beforeSend: function(){
                            e.currentTarget.children[0].style.display = 'inline-block';
                        },
                        complete: function(){
                            e.currentTarget.children[0].style.display = 'none';
                        },
                        success: function(res){
                            swal.fire({
                                title: "Support Ticket",
                                text: res.success,
                                icon: "success"
                            });
                            window.location.reload();
                        }
                    });
                });
            }
            deleteTicket();
        });
    </script>
@endsection
