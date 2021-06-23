@extends('admin.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')

    <div class="row justify-content-center">

        <div class="col-md-12 col-sm-12">
            <div class="card card-blue">
                <div class="card-header">
                    <h2 class="card-title">{{ $title }}</h2> &nbsp;
                    <button id="createRule" class="btn btn-sm btn-danger fa-pull-right"><i class="fas fa-plus"></i> Add New Rule</button>
                </div>
                <div class="card-body" id="rulesTableDiv">
                    <table id="rulesDataTable" width="100%" style="font-size: 100%; width:100%;" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="font-size: 11px; width:300px;">RULES</th>
                                <th style="font-size: 11px; width:150px; text-align:center;">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody id="rulesTbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



      <!-- Modal - Edit Account Modal -->
    <div class="modal fade" id="editRuleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editRuleFrm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Rule</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="editRule" class="control-label">Rule</label>
                        <textarea name="rule" id="editRule" class="form-control" cols="30" rows="8"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <div class="spinner spinner-border spinner-border-sm"></div>
                        Update
                    </button>
                </div>
              </div>
            </form>
        </div>
      </div>


        <!-- Modal - Create New Account Modal -->
    <div class="modal fade" id="createRuleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="createRuleFrm">
                @csrf
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Add New Rule</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="addRule">Rule</label>
                        <textarea name="rule" rows="8" id="addRule" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <div class="spinner spinner-border spinner-border-sm"></div>
                        Add Rule
                    </button>
                </div>
              </div>
            </form>
        </div>
      </div>

@endsection

@section('extra_script')
    <script>
        $(function(){

            //Fetch all Rule
            function getRules(){
                $("#rulesDataTable").DataTable({
                    ajax:{
                        url: '/admin/rule/all',
                        dataSrc: 'rules'
                    },
                    columns:[
                        {data: "rule"},
                        {
                            data: "id",
                            render: function(id){
                                return `
                                <div class='btn-group'>
                                    <a href="#" class="edit_rule btn btn-sm btn-info" data-edit_rule="${id}"><i class="fa fa-edit"> Edit</i></a>
                                    <a href="#" class="delete_rule btn btn-sm btn-danger" data-delete_rule="${id}"><i class="fa fa-remove"></i>
                                        <div class="spinner spinner-border spinner-border-sm" style="display:none;"></div>
                                        Delete
                                    </a>
                                </div>
                                `;
                            }
                        }
                    ]
                });
            }
            getRules();

            //Create New Rule
            function createRule(){
                $("#createRule").on('click', function(){
                    $("#createRuleModal").modal('show');
                    $("button[type=submit] div.spinner").hide();
                });

                $("#createRuleFrm").submit(function(e){
                    e.preventDefault();
                    var csrfToken = $("input[name=_token]");
                    var textareaRule = $("textarea[id=addRule]");
                    $.ajax({
                        url: '/admin/rule/create',
                        method: 'POST',
                        dataType: 'JSON',
                        data:{
                            '_token': csrfToken.val(),
                            'rule' : textareaRule.val()
                        },
                        beforeSend: function(){
                            $("button[type=submit] div.spinner").show();
                            $("button[type=submit]").attr('disabled', true);
                        },
                        complete: function(){
                            $("button[type=submit] div.spinner").hide();
                            $("button[type=submit]").attr('disabled', false);
                        },
                        success: function(res){
                            if(res.errors)
                            {
                                $('span.error_msg').remove();
                                $(`<span class="error_msg" style="font-size:12px; color:red;">${res.errors.rule ? res.errors.rule : ''}</span>`)
                                .insertAfter(textareaRule);
                            }

                            if(res.success){
                                swal.fire({
                                    title: "Site Rule",
                                    text: `${res.success}`,
                                    icon: "success"
                                })
                                window.location.reload();
                            }
                        }
                    });
                });
            }
            createRule();

            //Edit Rule
            function editRule()
            {
                $("#rulesTbody").on('click', '.edit_rule', function(e){
                    var rule_id = e.currentTarget.dataset.edit_rule;
                    $("#editRuleFrm button[type=submit] div.spinner").hide();
                    $.ajax({
                        url: '/admin/rule/edit/' + rule_id,
                        method: 'GET',
                        success: function(res){
                            $("textarea[id=editRule]").val(res.rule.rule);
                            $(`<input type="hidden" name="rule_id" value="${res.rule.id}">`)
                            .insertAfter(`input[name=_token]`);
                            $("#editRuleModal").modal('show');
                        }
                    });
                });

                $("#editRuleFrm").submit(function(e){
                    e.preventDefault();
                    var ruleID = $("input[name=rule_id]").val();
                    var textareaRule = $("textarea[id=editRule]");
                    var csrfToken = $("input[name=_token]");
                    $.ajax({
                        url: '/admin/rule/update/' + ruleID,
                        method: 'POST',
                        dataType: 'JSON',
                        data: {
                            '_token': csrfToken.val(),
                            'rule'  : textareaRule.val()
                        },
                        beforeSend: function(){
                            $("#editRuleFrm button[type=submit] div.spinner").show();
                            $("#editRuleFrm button[type=submit]").attr('disabled', true);
                        },
                        complete: function(){
                            $("#editRuleFrm button[type=submit] div.spinner").hide();
                            $("#editRuleFrm button[type=submit]").attr('disabled', false);
                        },
                        success: function(res){
                            if(res.errors){
                                $("span.error_msg").remove();
                                $(`<span class="error_msg" style="font-size:12px; color:red;">${res.errors.rule ? res.errors.rule : ''}</span>`)
                                .insertAfter(textareaRule);
                            }
                            if(res.success){
                                swal.fire({
                                    title: "Site Rule Update",
                                    text: `${res.success}`,
                                    icon: "success"
                                });
                                window.location.reload();
                            }
                        }
                    });
                });
            }
            editRule();

            //Delete Rule
            function deleteRule(){
                $("#rulesTbody").on('click', '.delete_rule', function(e){
                    var ruleID = e.currentTarget.dataset.delete_rule;
                    swal.fire({
                        title: "Are you sure?",
                        text: "Once deleted, you have to create a new rule",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url:'/admin/rule/delete/' + ruleID,
                                method: 'GET',
                                beforeSend: function(){
                                    e.currentTarget.children[0].style.display = 'none';
                                    e.currentTarget.children[1].style.display = 'inline-block';
                                    e.currentTarget.setAttribute('disabled', true);
                                },
                                complete: function(){
                                    e.currentTarget.children[0].style.display = 'inline-block';
                                    e.currentTarget.children[1].style.display = 'none';
                                    e.currentTarget.setAttribute('disabled', false);
                                },
                                success: function(res){
                                    if(res.success){
                                        swal.fire({
                                            title: 'Success!',
                                            text: `${res.success}`,
                                            icon: 'success'
                                        });
                                        e.currentTarget.parentNode.parentNode.remove();
                                    }
                                }
                            })
                        } else {
                            swal("Delete action cancel");
                        }
                    });
                });
            }
            deleteRule();

        });
    </script>
@endsection
