@extends('admin.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-12 col-sm-12 mt-3">
            <div class="card card-blue">
                <div class="card-header">
                    <h2 class="card-title">{{ $title }}</h2>
                    <button id="createUserAccountBtn" class="btn btn-sm btn-danger fa-pull-right">Create New User Account</button>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <table id="userAccountDataTable" width="100%" style="font-size: 100%; width:100%;" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="font-size: 11px; width:50px;">USERNAME</th>
                                <th style="font-size: 11px; width:50px;">EMAIL</th>
                                <th style="font-size: 11px; width:50px;">WALLET</th>
                                <th style="font-size: 11px; width:50px;">LAST IP</th>
                                <th style="font-size: 11px; width:50px;">LAST LOGOUT</th>
                                <th style="font-size: 11px; width:50px;">REGISTERED DATE</th>
                                <th style="font-size: 11px; width:50px;">ACTIVE</th>
                                <th style="font-size: 11px; width:150px;">ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="userAccountTbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



        <!-- Modal - Create New Account Modal -->
    <div class="modal fade" id="createUserAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="createUserAccountFrm">
                @csrf
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Create New User Account</h5>
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

                    <div class="form-group">
                        <label for="wallet">Wallet</label>
                        <input type="text" name="wallet" id="addWallet" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="wallet">Active</label>
                        <select name="active" id="addActive" class="form-control">
                            <option value="1" class="selectActiveOption" selected>Enabled</option>
                            <option value="0" class="selectActiveOption">Disable</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Create User Account</button>
                </div>
              </div>
            </form>
        </div>
      </div>


      <!-- Modal - Update Admin Account Modal -->
    <div class="modal fade" id="editUserAccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editUserAccountFrm">
                @csrf
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Update User Account</h5>
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

                    <div class="form-group">
                        <label for="wallet">Wallet</label>
                        <input type="text" name="wallet" id="editWallet" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="wallet">Active</label>
                        <select name="active" id="editActive" class="form-control">
                            <option value="1" class="selectActiveOption" selected>Enabled</option>
                            <option value="0" class="selectActiveOption">Disable</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Update User Account</button>
                </div>
              </div>
            </form>
        </div>
      </div>

@endsection

@section('extra_script')

<script>
    $(function(){

        //fetch all User account
        function getUserAccounts()
        {
            $("#userAccountDataTable").DataTable({
                ajax:{
                    url: '/admin/user/accounts/all',
                    dataSrc: 'user-accounts'
                },
                columns:[
                    {data: "username"},
                    {data: "email"},
                    {
                        data: "wallet",
                        render: function(wallet){
                            return `$${wallet ? wallet : "0.00"}`;
                        }
                    },
                    {data: "login_ip"},
                    {
                        data: "last_logout",
                        render: function(logout_time){
                            return `${(logout_time ? moment(logout_time).format("MMMM Do YYYY, h:mm:ss a") : "N/A")}`;
                        }
                    },
                    {
                        data: "created_at",
                        render: function(created_at){
                            return `${moment(created_at).format("MMMM Do YYYY")}`;
                        }
                    },
                    {
                        data: "active",
                        render: function(active){
                            return `
                            ${active ? "<span class='badge badge-primary badge-pill'>Enabled</span>" : "<span class='badge badge-danger badge-pill'>Disabled</span>"}
                            `;
                        }
                    },
                    {
                        data: "id",
                        render: function(id){
                            return `
                            <a href="#" class="edit_user btn btn-sm btn-info" data-user_id="${id}"><i class="fa fa-edit"></i> Edit</a>
                            <a href="#" class="delete_user btn btn-sm btn-danger" data-user_id="${id}"><i class="fa fa-remove"></i> Delete</a>
                            `;
                        }
                    }
                ]
            });
        }
        getUserAccounts();

        //Create New User Account
        function createNewUserAccount(){
            $("#createUserAccountBtn").on('click', function(){
                $("#createUserAccountModal").modal('show');
            });

            $("#createUserAccountFrm").submit(function(e){
                e.preventDefault();
                var csrfToken = $("input[name=_token]");
                var username = $("input[id=addUsername]");
                var email = $("input[id=addEmail]");
                var password = $("input[id=addPassword]");
                var wallet = $("input[id=addWallet]");
                var active = $("select[id=addActive]");
                $.ajax({
                    url: `/admin/user/account/create`,
                    method: 'POST',
                    dataType: 'JSON',
                    data: {
                        '_token': csrfToken.val(),
                        'username': username.val(),
                        'email': email.val(),
                        'password': password.val(),
                        'wallet': wallet.val(),
                        'active': active.val()
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
                                title: "User Account",
                                text: res.success,
                                icon: "success"
                            })

                            window.location.reload();
                        }
                    }
                });
            })
        }
        createNewUserAccount();

        //Edit User Account
        function editUserAccount(){
            $("#userAccountTbody").on('click', '.edit_user', function(e){
                e.preventDefault();
                var user_id = e.currentTarget.dataset.user_id;
                $.ajax({
                    url: '/admin/user/account/edit/' + user_id,
                    method:'GET',
                    success: function(res){
                        if(res.userAccount)
                        {
                            $(`<input type="hidden" name="edit_user_id" value="${res.userAccount.id}">`)
                            .insertBefore($("input[id=editUsername]"));
                            $("input[id=editUsername]").val(res.userAccount.username);
                            $("input[id=editEmail]").val(res.userAccount.email);
                            $("input[id=editPassword]").val('');
                            $("input[id=editWallet]").val(res.userAccount.wallet);
                            $("option.selectActiveOption").remove();
                            $("select[id=editActive]").append(`
                            <option value="1" class="selectActiveOption" ${res.userAccount.active ? "selected": ""}>Enabled</option>
                            <option value="0" class="selectActiveOption" ${res.userAccount.active ? "": "selected"}>Disable</option>
                            `);
                            $("#editUserAccountModal").modal('show');
                        }

                    }
                });
                $("#editUserAccountFrm").submit(function(e){
                    e.preventDefault();
                    var user_id = $("input[name=edit_user_id]").val();
                    $.ajax({
                        url: '/admin/user/account/update/' + user_id,
                        method: 'POST',
                        dataType: 'JSON',
                        data:{
                            '_token': $("input[name=_token]").val(),
                            'username': $("input[id=editUsername]").val(),
                            'email': $("input[id=editEmail]").val(),
                            'password' : $("input[id=editPassword]").val(),
                            'wallet' : $("input[id=editWallet]").val(),
                            'active' : $("select[id=editActive]").val()
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
                                    title: "User Account",
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
        editUserAccount();


        //Delete User Account
        function deleteUserAccount(){
            $("#userAccountTbody").on('click', '.delete_user', function(e){
                e.preventDefault();
                var user_id = e.currentTarget.dataset.user_id;
                $.ajax({
                    url: `/admin/user/account/delete/${user_id}`,
                    method: 'GET',
                    success: function(res){
                        if(res.success){
                            swal({
                                title: "User Account",
                                text: res.success,
                                icon: "success"
                            });
                            window.location.reload();
                        }
                    }
                });
            });
        }
        deleteUserAccount();
    });
</script>

@endsection
