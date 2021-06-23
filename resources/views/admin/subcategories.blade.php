@extends('admin.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')

    <div class="row justify-content-center">

        <div class="col-md-6 col-sm-12" style="text-align:center;">
            <div class="card card-blue">
                <div class="card-header">
                    <h3 class="card-title">Main Categories</h3>
                </div>
                <div class="card-body">
                    <p>
                        <a href="#" id="top_category_btn" class="badge badge-pill badge-success" style="font-size: 14px; margin-bottom:10px;"><span class="spinner spinner-border spinner-border-sm" style="display: none;"></span> All</a>
                        @if(isset($categories))
                            @foreach ($categories as $category)
                            <a href="#" data-category_id="{{$category->id}}" class="badge badge-pill badge-success top_category_btn" style="font-size: 14px; margin-bottom:10px;">
                                <span class="spinner spinner-border spinner-border-sm" style="display: none;"></span>
                                {{$category->category_name}}
                            </a>
                            @endforeach
                        @endif
                    </p>
                </div>
            </div>

        </div>

        <div class="col-md-6 col-sm-12 mt-0">
            <div class="card card-blue">
                <div class="card-header">
                    <h2 class="card-title">{{ $title }}</h2> &nbsp;
                    <button id="addSubCategoryBtn" class="btn btn-sm btn-danger fa-pull-right">
                        Add Sub Category
                    </button>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">
                    <table id="subCategoryTbl" width="100%" style="font-size: 100%; width:100%;" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="font-size: 11px; width:30px;">SUBCATEGORY</th>
                                <th style="font-size: 11px; width:15px; text-align:center;">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

      <!-- Modal - Add Product Modal -->
    <div class="modal fade" id="addSubCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addSubCategoryForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                        <div class="form-group">
                            <label for="addCategory" class="control-label">Main Category</label>
                            <select name="addCategory" id="addCategory" class="form-control">
                                <option value="">Select Main Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{$category->id}}">{{$category->category_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="addFile" class="control-label">Choose Subcategory Image</label>
                            <input type="file" name="addFile" id="addFile" class="form-control form-control-sm">
                        </div>

                        <div class="form-group">
                            <label for="addSubCategory" class="control-label">Sub Category</label>
                            <input type="text" name="addSubCategory" id="addSubCategory" placeholder="Enter sub-category name (required)" class="form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">
                        <div class="spinner spinner-border spinner-border-sm"></div>
                        Add Category</button>
                </div>
              </div>
            </form>
        </div>
      </div>



        <!-- Modal - Edit Product Modal -->
        <div class="modal fade" id="editSubCategoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form id="editSubCategoryForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                            <div class="form-group">
                                <label for="editCategory" class="control-label">Main Category</label>
                                <select name="editCategory" id="editCategory" class="form-control">
                                    <option value="">Select Main Category</option>
                                    
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="editFile" class="control-label">Choose Subcategory Image</label>
                                <input type="file" name="editFile" id="editFile" class="form-control form-control-sm">
                            </div>

                            <div class="form-group">
                                <label for="editSubCategory" class="control-label">Sub Category</label>
                                <input type="text" name="editSubCategory" id="editSubCategory" class="form-control">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <div class="spinner spinner-border spinner-border-sm"></div>
                            Update Category
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

            //Initialize CSRF TOKEN IN HEADER
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name=csrf-token]').attr('content'),
                }
            });

            //Initialize subCategoryTbl with subcategory data
            var subCategoryTbl = $("#subCategoryTbl").DataTable({
                ajax:{
                    url: '/admin/sub-categories'
                },
                columns:[
                    {data: 'sub_category_name'},
                    {
                        data: 'id',
                        render: (id)=>{
                            return `
                            <div class='btn-group'>
                            <a href="#" class="edit_sub_category btn btn-success btn-sm" data-sub_category_id="${id}"><i class="fa fa-edit"></i> Edit</a>
                            <a href="#" class="delete_sub_category btn btn-danger btn-sm" data-sub_category_id="${id}"><i class="fa fa-remove"></i>
                                <div class="spinner spinner-border spinner-border-sm" style="display:none;"></div>
                            Delete</a>
                            </div>
                            `;
                        }
                    }
                ]
            });
            
            //Fetch Subcategories
            $('#top_category_btn').on('click', function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                $.ajax({
                    url: '/admin/sub-categories',
                    method:'GET',
                    beforeSend:()=>{
                        e.currentTarget.children[0].style.display = 'inline-block';
                    },
                    complete:()=>{
                        e.currentTarget.children[0].style.display = 'none';
                    },
                    success:(res)=>{
                        subCategoryTbl.clear();
                        subCategoryTbl.rows.add(res.data);
                        subCategoryTbl.draw();
                    }
                });
            });



            // Prodcuts Category buttons at the top
            $('div.card-body').on('click', '.top_category_btn', function(e){
                e.preventDefault();
                
                var category_id = e.currentTarget.dataset['category_id'];
                $.ajax({
                    url: `/admin/sub-categories/${category_id}`,
                    method: "GET",
                    beforeSend:()=>{ e.currentTarget.children[0].style.display = 'inline-block'; },
                    complete:()=>{ e.currentTarget.children[0].style.display = 'none'; },
                    success: (res)=>{
                        subCategoryTbl.clear();
                        subCategoryTbl.rows.add(res.data);
                        subCategoryTbl.draw();
                    }
                }); //end of ajax call
            });
            // END ---- Prodcuts Category buttons at the top

            //============== Add Sub Category ====================

            $('#addSubCategoryBtn').on('click', function(e){
                $("#addSubCategoryForm").trigger('reset');
                $("#addSubCategoryForm div.spinner").hide();
                $("#addSubCategoryModal").modal('show');

                //Submit subcategory form
                $('#addSubCategoryForm').submit(function(e){
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    var categoryEl = $('select[name=addCategory]');
                    var subcategoryEl = $('input[name=addSubCategory]');
                    var fileEl = $('input[type=file][name=addFile]');
                    
                    //Remove all for error mesages
                    $('span.error-msg').remove();

                    //Create form object
                    var formData = new FormData(this);

                    $.ajax({
                        url: '/admin/sub-category/add',
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend:()=>{$("#addSubCategoryForm div.spinner").show();},
                        complete:()=>{$("#addSubCategoryForm div.spinner").hide();},
                        success:(res)=>{
                            if(res.errors)
                            {
    
                                `${(res.errors.addCategory) ? categoryEl.addClass('is-invalid') : categoryEl.removeClass('is-invalid')}`;
                                `${(res.errors.addSubCategory) ? subcategoryEl.addClass('is-invalid') : categoryEl.removeClass('is-invalid')}`;
                                `${(res.errors.addFile) ? $(`<span style='font-size:14px; color:yellow;font-weight:bold' class='error-msg'>${res.errors.addFile}</span>`).insertAfter(fileEl) : $('span.error-msg').remove()}`;
                            }

                            if(res.success)
                            {
                                swal.fire({
                                    title: 'Success!',
                                    text: `${res.success}`,
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Ok!',
                                });
                                $("#addSubCategoryModal").modal('hide');
                                subCategoryTbl.ajax.reload();
                            }
                        }
                    });
                });
            });

            //================ Update Product ==================

                $("#subCategoryTbl").on('click', '.edit_sub_category', function(e){
                    $("#editSubCategoryForm").trigger('reset');
                    $("#editSubCategoryForm div.spinner").hide();
                    e.preventDefault();
                    var sub_category_id = e.currentTarget.dataset.sub_category_id;
                    $.ajax({
                        url: '/admin/sub-category/edit/' + sub_category_id,
                        method:'GET',
                        success: function(res){
                            $(`<input type="hidden" name="sub_category_id" value="${res.subCategory.id}">`)
                            .insertAfter($("input[name=_token]"));

                            $("select[name=editCategory] option").remove();
                            $("select[name=editCategory]").append(`<option value="">Select Main Category</option>`);
                            $.each(res.categories, function(k, v){
                                $("select[name=editCategory]").append(`
                                <option value="${v.id}" ${(v.id === res.subCategory.category_id) ? "selected" : ""}>${v.category_name}</option>
                                `);
                            });

                            $("input[id=editSubCategory]").val(res.subCategory.sub_category_name);
                        }
                    });
                    $("#editSubCategoryModal").modal('show');
                });
            
            //================ END OF uPDATE pRODUCT
                $("#editSubCategoryForm").submit(function(e){
                    e.preventDefault();
                    e.stopImmediatePropagation();

                    var formData = new FormData(this);

                    var sub_category_id = $("input[name=sub_category_id]").val();
                    var csrfToken = $("input[name=_token]");
                    var editCategoryEl = $("select[id=editCategory]");
                    var editFileEl = $('input[type=file][name=editFile]');
                    var editSubCategoryEl = $("input[id=editSubCategory]");
                    $.ajax({
                        url: '/admin/sub-category/update/' + sub_category_id,
                        method: 'POST',
                        dataType: 'JSON',
                        data:formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function(){
                            $("#editSubCategoryForm div.spinner").show();
                        },
                        complete: function(){
                            $("#editSubCategoryForm div.spinner").hide();
                        },
                        success: function(res){
                            if(res.errors){
                                $('span.error_msg').remove();
                                $(`<span class="error_msg" style="font-size:12px;color:red;">${res.errors.category_id ? res.errors.category_id : ''}</span>`).insertBefore(category);
                                $(`<span class="error_msg" style="font-size:12px;color:red;">${res.errors.sub_category_name ? res.errors.sub_category_name : ''}</span>`).insertBefore(subCategory);
                            }

                            if(res.success){
                                        swal.fire({
                                            title: 'Success!',
                                            text: `${res.success}`,
                                            icon: 'success',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'Ok!',
                                        });
                                        $("#editSubCategoryModal").modal('hide');
                                        subCategoryTbl.ajax.reload();
                            }
                        }
                    });
                });


            // Delete Account
            function deleteSubCategory()
            {
                $("#subCategoryTbl").on('click', '.delete_sub_category', function(e){
                    e.preventDefault();
                    var sub_category_id = e.currentTarget.dataset.sub_category_id;
                    swal.fire({
                        title: 'Error!',
                        text: `Once deleted, you will not be able to recover!`,
                        icon: 'error',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        //confirmButtonText: 'Ok!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/admin/sub-category/delete/${sub_category_id}`,
                                method: 'get',
                                beforeSend: function(){
                                    e.currentTarget.children[0].style.display = 'none';
                                    e.currentTarget.children[1].style.display = 'inline-block';
                                },
                                complete: function(){
                                    e.currentTarget.children[0].style.display = 'inline-block';
                                    e.currentTarget.children[1].style.display = 'none';
                                },
                                success:function(res){
                                    if(res.success){
                                        swal.fire({
                                            title: 'Success!',
                                            text: `${res.success}`,
                                            icon: 'success',
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'Ok!',
                                        });
                                        subCategoryTbl.ajax.reload();
                                    }
                                }
                            });
                        }
                    });
                });
            }
            deleteSubCategory();
        });
    </script>
@endsection
