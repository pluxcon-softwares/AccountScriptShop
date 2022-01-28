@extends('admin.layouts.admin-master')

@section('title')
    {{ $title }}
@endsection

@section('content')
    @include('admin.partials.top_widgets')

    <div class="row">

        <div class="col-md-7 col-sm-12 mt-5 mr-auto ml-auto">
            <div class="x_panel sg-shadow">
                <div class="x_title">
                    <h2>{{ $title }}</h2>
                    <button id="createAdminAccountBtn" class="btn btn-sm btn-danger pull-right">Create New Admin Account</button>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="adminAccountDataTable" width="100%" style="font-size: 100%; width:100%;" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="font-size: 11px; width:50px;">USERNAME</th>
                                <th style="font-size: 11px; width:200px;">EMAIL</th>
                                <th style="font-size: 11px; width:150px;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="adminAccountTbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



        <!-- Modal - Create New Account Modal -->
    <div class="modal fade" id="createAdminAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="createAdminAccountFrm">
                @csrf
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Create New Admin Account</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="username">username</label>
                        <input type="text" name="username" id="addUsername" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="addEmail" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="addPassword" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Create Admin Account</button>
                </div>
              </div>
            </form>
        </div>
      </div>


      <!-- Modal - Update Admin Account Modal -->
    <div class="modal fade" id="editAdminAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editAdminAccountFrm">
                @csrf
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Update Admin Account</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="username">username</label>
                        <input type="text" name="username" id="editUsername" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="editEmail" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="editPassword" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Update Admin Account</button>
                </div>
              </div>
            </form>
        </div>
      </div>

@endsection

@section('extra_script')

<script>
    $(function(){

        //fetch all admin account
        function getAdminAccounts()
        {
            $("#adminAccountDataTable").DataTable({
                ajax:{
                    url: '/admin/admin/accounts/all',
                    dataSrc: 'admin_accounts'
                },
                columns:[
                    {data: "username"},
                    {data: "email"},
                    {
                        data: "id",
                        render: function(id){
                            return `
                            <a href="#" class="edit_admin btn btn-sm btn-info" data-admin_id="${id}"><i class="fa fa-edit"></i> Edit</a>
                            <a href="#" class="delete_admin btn btn-sm btn-danger" data-admin_id="${id}"><i class="fa fa-remove"></i> Delete</a>
                            `;
                        }
                    }
                ]
            });
        }
        getAdminAccounts();

        //Create New Admin Account
        function createNewAdminAccount(){
            $("#createAdminAccountBtn").on('click', function(){
                $("#createAdminAccountModal").modal('show');
            });

            $("#createAdminAccountFrm").submit(function(e){
                e.preventDefault();
                var csrfToken = $("input[name=_token]");
                var username = $("input[id=addUsername]");
                var email = $("input[id=addEmail]");
                var password = $("input[id=addPassword]");
                $.ajax({
                    url: `/admin/admin/account/create`,
                    method: 'POST',
                    dataType: 'JSON',
                    data: {
                        '_token': csrfToken.val(),
                        'username': username.val(),
                        'email': email.val(),
                        'password': password.val()
                    },
                    success: function(res){
                        if(res.errors){
                            $("span.error_msg").remove();
                            $(`<span class="error_msg" style="color:red;">${res.errors.username ? res.errors.username : ""}</span>`)
                            .insertAfter(username);

                            $(`<span class="error_msg" style="color:red;">${res.errors.email ? res.errors.email : ""}</span>`)
                            .insertAfter(email);

                            $(`<span class="error_msg" style="color:red;">${res.errors.password ? res.errors.password : ""}</span>`)
                            .insertAfter(password);
                        }

                        if(res.success){
                            swal({
                                title: "Admin Account",
                                text: res.success,
                                icon: "success"
                            })

                            window.location.reload();
                        }
                    }
                });
            })
        }
        createNewAdminAccount();

        //Edit Admin Account
        function editAdminAccount(){
            $("#adminAccountTbody").on('click', '.edit_admin', function(e){
                e.preventDefault();
                var admin_id = e.currentTarget.dataset.admin_id;
                $.ajax({
                    url: '/admin/admin/account/edit/' + admin_id,
                    method:'GET',
                    success: function(res){
                        if(res.admin_account)
                        {
                            $(`<input type="hidden" name="edit_admin_id" value="${res.admin_account.id}">`)
                            .insertBefore($("input[id=editUsername]"));
                            $("input[id=editUsername]").val(res.admin_account.username);
                            $("input[id=editEmail]").val(res.admin_account.email);
                            $("input[id=editPassword]").val('');
                            $("#editAdminAccountModal").modal('show');
                        }

                    }
                });
                $("#editAdminAccountFrm").submit(function(e){
                    e.preventDefault();
                    var admin_id = $("input[name=edit_admin_id]").val();
                    $.ajax({
                        url: '/admin/admin/account/update/' + admin_id,
                        method: 'POST',
                        dataType: 'JSON',
                        data:{
                            '_token': $("input[name=_token]").val(),
                            'username': $("input[id=editUsername]").val(),
                            'email': $("input[id=editEmail]").val(),
                            'password' : $("input[id=editPassword]").val()
                        },
                        success:function(res){
                            if(res.errors){
                                $("span.error_msg").remove();
                                $(`<span class="error_msg" style="color:red;">${res.errors.username ? res.errors.username : ""}</span>`)
                                .insertAfter($("input[id=editUsername]"));

                                $(`<span class="error_msg" style="color:red;">${res.errors.email ? res.errors.email : ""}</span>`)
                                .insertAfter($("input[id=editEmail]"));
                            }

                            if(res.success){
                                swal({
                                    title: "Admin Account",
                                    text: res.success,
                                    icon: "success"
                                });
                                window.location.reload();
                            }
                        }
                    });
                });
            });
        }
        editAdminAccount();


        //Delete Admin Account
        function deleteAdminAccount(){
            $("#adminAccountTbody").on('click', '.delete_admin', function(e){
                e.preventDefault();
                var admin_id = e.currentTarget.dataset.admin_id;
                $.ajax({
                    url: `/admin/admin/account/delete/${admin_id}`,
                    method: 'GET',
                    success: function(res){
                        if(res.success){
                            swal({
                                title: "Admin Account",
                                text: res.success,
                                icon: "success"
                            });
                            window.location.reload();
                        }
                    }
                });
            });
        }
        deleteAdminAccount();
    });
</script>

@endsection
