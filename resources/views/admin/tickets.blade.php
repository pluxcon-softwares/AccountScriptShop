@extends('admin.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')

    <div class="row mt-5">

        <div class="col-md-12 col-sm-12 mt-0">
            <div class="card card-blue">
                <div class="card-header">
                    <h2 class="card-title">{{ $title }}</h2>
                </div>
                <div class="card-body" id="productsTableDiv">
                    <table id="ticketsDataTable" width="100%" style="font-size: 100%; width:100%;" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="font-size: 11px; width:50px;">USERNAME</th>
                                <th style="font-size: 11px; width:30px;">EMAIL</th>
                                <th style="font-size: 11px; width:300px;">SUBJECT</th>
                                <th style="font-size: 11px; width:15px;">STATUS</th>
                                <th style="font-size: 11px; width:15px; text-align:center;">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody id="ticketsTbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal - Create New Account Modal -->
    <div class="modal fade" id="replyTicketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="ticketReplyFrm">
                @csrf
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Ticket Reply</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <hr>
                    <div class="form-group">
                        <label for="name">Reply User</label>
                        <textarea name="reply" rows="8" id="add_reply" class="form-control"></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <div class="spinner spinner-border spinner-border-sm"></div>
                        Reply</button>
                </div>
              </div>
            </form>
        </div>
      </div>

@endsection

@section('extra_script')
    <script>
        $(function(){
            // Fetch all Tickets
            $("#ticketsDataTable").DataTable({
                ajax:{
                    url: '/admin/ticket/all',
                    method: 'GET',
                    dataSrc: 'tickets'
                },
                columns:[
                    {"data": "username"},
                    {"data": "email"},
                    {"data": "subject"},
                    {
                        "data": "status",
                        render: function(status){

                            if (status === 0) {
                                return `<i class="badge badge-danger badge-pill" style="font-size:14px;">Unresolved</i>`;
                            }

                            if (status === 1) {
                                return `<i class="badge badge-success badge-pill" style="font-size:14px;">Resolved</i>`;
                            }
                        }
                    },
                    {
                        "data": "id",
                        render: function(id){
                            return `
                            <a href="#" class="btn btn-primary btn-sm reply_ticket" data-reply_ticket="${id}"><i class="fa fa-file"></i> View</a>
                            <a href="#" class="btn btn-danger btn-sm delete_ticket" data-delete_ticket="${id}"><i class="fa fa-remove"></i>
                                <div class="spinner spinner-border spinner-border-sm" style="display:none;"></div>
                                Delete</a>
                            `;
                        }
                    }
                ]
            });
            // Fetch All Tickets --- EOC

            //View and Reply Ticket
            function reply()
            {
                $("#ticketsTbody").on('click', '.reply_ticket', function(e){
                    e.preventDefault();
                    var ticket_id = e.currentTarget.dataset.reply_ticket;
                    $.ajax({
                        url: '/admin/ticket/'+ticket_id,
                        method: 'GET',
                        success: function(res){
                            console.log(res)
                            $("input[id=ticket_id]").remove();
                            $("input[id=user_id]").remove();
                            $("#ticketReplyFrm")
                            .prepend(`
                            <input type="hidden" name="ticket_id" id="ticket_id" value="${res.ticket.id}">
                            <input type="hidden" name="user_id" id="user_id" value="${res.ticket.user_id}">
                            `);
                            $("#replyTicketModal .modal-body .ticket_msg").remove();
                            $("#replyTicketModal .modal-body").prepend(`
                            <div class="ticket_msg">
                                <h2>${res.ticket.subject}</h2>
                                <p style="width:450px;">${res.ticket.message}</p>
                                <span><strong>Status:</strong> ${res.ticket.status ? 'Resolved' : 'Unresolved'}</span><br>
                                <span><strong>Username:</strong> ${res.ticket.username}</span><br>
                                <span><strong>Email:</strong> ${res.ticket.email}</span>
                            </div>
                            `);
                        }
                    });
                    $("#replyTicketModal").modal('show');
                    $("#replyTicketModal div.spinner").hide();
                    $("#ticketReplyFrm").submit(function(e){
                        e.preventDefault();
                        var ticket_id = $("input[id=ticket_id]").val();
                        var user_id = $("input[id=user_id]").val();
                        var csrfToken = $("input[name=_token]").val();
                        var reply = $("textarea[id=add_reply]").val();
                        $.ajax({
                            url: '/admin/ticket/store/reply',
                            method: 'POST',
                            dataType: 'JSON',
                            data:{
                                '_token': csrfToken,
                                'ticket_id': ticket_id,
                                'user_id' : user_id,
                                'reply': reply
                            },
                            beforeSend: function(){
                                $("#replyTicketModal div.spinner").show();
                                $("button[type=submit]").attr('disabled', true);
                            },
                            complete: function(){
                                $("#replyTicketModal div.spinner").hide();
                                $("button[type=submit]").attr('disabled', false);
                            },
                            success: function(res){
                                if(res.errors)
                                {
                                    $("span.error_msg").remove();
                                    $(`<span style="font-size:14px; color:red;" class="error_msg">${res.errors.reply}</span>`)
                                    .insertAfter($("textarea[id=add_reply]"));
                                }

                                if(res.success){
                                    swal.fire({
                                        title: "Ticket Reply",
                                        text: "ticke reply successful",
                                        icon: "success"
                                    });
                                    window.location.reload();
                                }
                            }
                        })
                    });
                });
            }
            reply();

            //Delete Ticket
            function deleteTicket(){
                $("#ticketsTbody").on('click', '.delete_ticket', function(e){
                    e.preventDefault();
                    var ticket_id = e.currentTarget.dataset.delete_ticket;
                    $.ajax({
                        url: '/admin/ticket/delete/' + ticket_id,
                        method: 'GET',
                        beforeSend: function(){
                            e.currentTarget.children[0].style.display = 'none';
                            e.currentTarget.children[1].style.display = 'inline-block';
                            e.currentTarget.setAttribute('disabled', true);
                        },
                        complete: function(){
                            e.currentTarget.children[0].style.display = 'inline-block';
                            e.currentTarget.children[1].style.display = 'none';
                            e.currentTarget.setAttribute('enabled', true);
                        },
                        success: function(res){
                            if(res.status){
                                swal.fire({
                                    title: "Delete Ticket",
                                    text: "Ticket deleted succesfully!",
                                    icon : "success"
                                });
                                e.currentTarget.parentNode.parentNode.remove();
                            }
                        }
                    });
                });
            }
            deleteTicket();
        });
    </script>
@endsection
