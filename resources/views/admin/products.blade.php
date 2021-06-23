@extends('admin.layouts.master')

@section('title')
    {{ $data['title'] }}
@endsection

@section('content')

    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12" style="text-align: center;">

            <div class="card card-warning">
                <div class="card-body justify-content-center">
                    <a href="#" class="badge badge-danger" id="all_product_btn" style="padding: 10px;">All Products</a>
                    @foreach ($data['categories'] as $category)
                    <a href="#" class="badge badge-danger view_product_btn" data-category_id="{{ $category->id }}" style="padding: 10px;">{{ $category->category_name }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 mt-0">

            <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">{{ $data['title'] }}</h3> &nbsp;
                  <button id="addProductBtn" class="btn btn-sm btn-danger fa-pull-right">Add New Product</button>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="productsTbl" width="100%" style="font-size: 100%; width:100%;" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="font-size: 11px; width:50px;">TYPE</th>
                                <th style="font-size: 11px; width:30px;">COUNTRY</th>
                                <th style="font-size: 11px; width:300px;">INFORMATION</th>
                                <th style="font-size: 11px; width:15px;">PRICE</th>
                                <th style="font-size: 11px; width:200px; text-align:center;">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
              </div>
        </div>
    </div>

    <!-- ============= VIEW PRODUCT DETAILS ============== -->
    @include('admin.partials._product-view')
    <!-- ============== END OF PRODUCT DETAILS ============= -->


    <!-- ========= ADD PRODUCT ============ -->
    @include('admin.forms._product-add')
    <!-- //.========== ADD PRODUCT ============== -->


    <!-- ============== EDIT PRODUCT ==================== -->
    @include('admin.forms._product-edit')
    <!-- ================ // END OF EDIT PRODUCT ============== -->

@endsection

@section('extra_script')
    <script>
    $(function(){

        //Configure X-CSRF-TOKEN header in ajaxsetup
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content'),
            }
        });

        //Initialize product datatable with all products
        var productsTbl = $("#productsTbl").DataTable({
            ajax:{
                url: '/admin/product/all'
            },
            columns:[
                {data: 'sub_category.sub_category_name'},
                {data: 'country'},
                {data: 'name'},
                {data: 'price'},
                {
                    data: 'id',
                    render:(id)=>{
                        return `
                        <div class='btn-group'>
                            <button class='btn btn-sm btn-warning view_product' data-product_id='${id}'><i class='fas fa-file'></i> details</button>
                            <button class='btn btn-sm btn-info edit_product' data-product_id='${id}'><i class='fas fa-edit'></i> edit</button>
                            <button class='btn btn-sm btn-danger delete_product' data-product_id='${id}'><i class='fas fa-trash'></i> delete</button>
                        </div>
                        `;
                    }
                }
            ],
        });
        // end of product datatable initialization

        //======================== CREATE NEW PRODUCT ===============================
        $("#addProductBtn").on('click', function(){
            // Reset add product form
            $('#addProductFrm').trigger('reset');

            // assign all form element to variables
            var categoryEl = $('select[name=addCategory]');
            var subCategoryEl = $('select[name=addSubCategory]');
            var nameEl = $('input[name=addName]');
            var priceEl = $('input[name=addPrice]');
            var countryEl = $('input[name=addCountry]');
            var descriptionEl = $('textarea[name=addDescription]');
            var spinnerEl = $('button[type=submit] div.spinner');

            //Hide submit button spinner
            spinnerEl.hide();

            //Fetch all categories to populate main category select element
            $.ajax({
                url: '/api/categories',
                method: "GET",
                success:(res)=>{
                    $('option.add_category_option').remove();
                    $.each(res, function(k, v){
                        categoryEl.append(`
                        <option value='${v.id}' class='add_category_option'>${v.category_name}</option>
                        `);
                    });
                }
            });

            //Fetch all subcategories when main category is selected to populate subategory select element
            $('select[name=addCategory]').on('change', function(e){
                var category_id = e.currentTarget.value;
                $.ajax({
                    url: `/api/category/subcategories/${category_id}`,
                    method: "GET",
                    success:(res)=>{
                        $('option.add_subcategory_option').remove();
                        $.each(res, function(k, v){
                            subCategoryEl.append(`
                            <option value='${v.id}' class='add_subcategory_option'>${v.sub_category_name}</option>
                            `);
                        });
                    }
                });
            });

            //Show Add Product Form Modal
            $('#addProductModal').modal('show');

            //Get form values and post to server
            $('#addProductFrm').submit(function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                var formData = new FormData(this);
                $.ajax({
                    url: '/admin/product/store',
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend:()=>{spinnerEl.show();},
                    complete:()=>{spinnerEl.hide();},
                    success:(res)=>{
                        //check for submitted form errors
                        if(res.errors)
                        {
                            `${(res.errors.addCategory) ? categoryEl.addClass('is-invalid'):categoryEl.removeClass('is-invalid') }`;
                            `${(res.errors.addSubCategory) ? subCategoryEl.addClass('is-invalid'):subCategoryEl.removeClass('is-invalid') }`;
                            `${(res.errors.addName) ? nameEl.addClass('is-invalid'):nameEl.removeClass('is-invalid') }`;
                            `${(res.errors.addPrice) ? priceEl.addClass('is-invalid'):priceEl.removeClass('is-invalid') }`;
                            `${(res.errors.addDescription) ? descriptionEl.addClass('is-invalid'):descriptionEl.removeClass('is-invalid') }`;
                        }

                        //check for success
                        if(res.success)
                        {
                            $('#addProductModal').modal('hide');
                            productsTbl.ajax.reload();
                        }

                    }
                })
            });
        });
        //======================== END OF CREATE NEW PRODUCT ===============================


        //======================== EDIT/UPDATE NEW PRODUCT ===============================
        $('#productsTbl').on('click', '.edit_product', function(e){
            e.preventDefault();
            e.stopImmediatePropagation();

            $("#editProductFrm").trigger('reset');

            //clear all error class 'is-invalid' from form elements
            $('#editProductFrm .is-invalid').removeClass('is-invalid');

            var product_id = e.currentTarget.dataset['product_id'];

            //Get all edit product form elements
            var editCategoryEl = $('select[name=editCategory]');
            var editSubCategoryEl = $('select[name=editSubCategory]');
            var editNameEl = $('input[name=editName]');
            var editProductHiddelEl = $('input[type][name=product_id]');
            var editPriceEl = $('input[name=editPrice]');
            var editCountryEl = $('input[name=editCountry]');
            var editDescriptionEl = $('textarea[name=editDescription]');
            var buttonSpinnerEl = $('#editProductFrm button[type=submit] div.spinner');

            //hide submit button spinner
            buttonSpinnerEl.hide();

            //Fetch product by id to populate editProductForm for update
            $.ajax({
                url: `/admin/product/edit-update/${product_id}`,
                method: "GET",
                success:(res)=>{
                    //Fetch all Categories for editCategory element
                    $.ajax({
                        url:'/api/categories',
                        method:"GET",
                        success:(cat)=>{
                            $('option[class=edit_category_option]').remove();
                            $.each(cat, function(catk, catv){
                                editCategoryEl.append(`
                                <option value='${catv.id}' ${(catv.id == res.category_id) ? 'selected' : ''} class='edit_category_option'>${catv.category_name}</option>
                                `);
                            });
                        }
                    });

                    //Fetch all subcategories by categoryid for editSubCategory elelment
                    $.ajax({
                        url: `/api/category/subcategories/${res.category_id}`,
                        method: "GET",
                        success:(subcat)=>{
                            $('option[class=edit-subcategory-option]').remove();
                            $.each(subcat, function(subcatk, subcatv){
                                editSubCategoryEl.append(`
                                <option value='${subcatv.id}' ${(subcatv.id == res.sub_category_id) ? 'selected' : ''} class='edit-subcategory-option'>${subcatv.sub_category_name}</option>
                                `);
                            });
                        }
                    });
                    
                    // populate all form field with fetch product data for update.
                    editNameEl.val(res.name);
                    editProductHiddelEl.val(res.id);
                    editCountryEl.val(res.country);
                    editPriceEl.val(res.price);
                    editDescriptionEl.val(res.description);
                }
            });

            //show editProductForm Modal
            $('#editProductModal').modal('show');

            // submit updated form
            $("#editProductFrm").submit(function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                var formData = new FormData(this);
                $.ajax({
                    url: '/admin/product/edit-update',
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend:()=>{buttonSpinnerEl.show()},
                    complete:()=>{buttonSpinnerEl.hide()},
                    success:(res)=>{
                        if(res.errors)
                        {
                            `${(res.errors.editCategory) ? editCategoryEl.addClass('is-invalid'):editCategoryEl.removeClass('is-invalid') }`;
                            `${(res.errors.editSubCategory) ? editSubCategoryEl.addClass('is-invalid'):editSubCategoryEl.removeClass('is-invalid') }`;
                            `${(res.errors.editName) ? editNameEl.addClass('is-invalid'):editNameEl.removeClass('is-invalid') }`;
                            `${(res.errors.editPrice) ? editPriceEl.addClass('is-invalid'):editPriceEl.removeClass('is-invalid') }`;
                            `${(res.errors.editDescription) ? editDescriptionEl.addClass('is-invalid'):editDescriptionEl.removeClass('is-invalid') }`;
                        }

                        if(res.success)
                        {
                            $("#editProductModal").modal('hide');
                            $("#editProductFrm").trigger('reset');
                            productsTbl.ajax.reload();
                        }
                    }
                });
            });
        });
        //======================== END OF EDIT/UPDATE NEW PRODUCT ===============================


        //======================== DELETE PRODUCT ===============================
        $("#productsTbl").on('click', '.delete_product', function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            var product_id = e.currentTarget.dataset['product_id'];
            swal.fire({
                title: 'Error!',
                text: `Delete will totally gone`,
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                //confirmButtonText: 'Ok!'
                }).then((result)=>{
                    if(result.isConfirmed)
                    {
                        $.ajax({
                            url: `/admin/product/delete/`,
                            method: "POST",
                            data:{product_id: product_id},
                            success:(res)=>{
                                swal.fire({
                                title: 'Success!',
                                text: `${res.success}`,
                                icon: 'success',
                                //showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                //cancelButtonColor: '#d33',
                                //confirmButtonText: 'Yes, delete it!'
                                confirmButtonText: 'Ok!'
                                });
                                productsTbl.ajax.reload();
                            }
                        });
                    }
                });
        });
        //======================== END OF DELETE PRODUCT ===============================


        //====================== VIEW PRODUCT DETAILS =================================
        $("#productsTbl").on('click', '.view_product', function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            var product_id = e.currentTarget.dataset['product_id'];
            $.ajax({
                url: `/admin/product/view/${product_id}`,
                method: "GET",
                success:(res)=>{
                    $("#viewProductModal .modal-body").empty();
                    $("#viewProductModal .modal-body").append(`
                    <p><stringTitle:</strong> ${res.name}</p>
                    <hr>
                    <p><span class='badge badge-success'>Price:$</span> ${res.price}</p>
                    <p><span class='badge badge-success'>Category</span> ${res.category.category_name}</p>
                    <p><span class='badge badge-success'>SubCategory</span> ${res.sub_category.sub_category_name}</p>
                    <p><span class='badge badge-success'>Country:</span> ${(res.country) ? res.country : 'N/A'}</p>
                    <hr />
                    <p><strong>Details</strong></p>
                    <p>${res.description}</p>
                    `);
                    $('#viewProductModal').modal('show');
                }
            });
        });
        //======================= END OF VIEW PRODUCT DETAILS =========================


        //================== VIEW ALL PRODUCT ========================================
        $('#all_product_btn').on('click', function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            $.ajax({
                url: '/admin/product/all',
                method: "GET",
                success:(res)=>{
                    productsTbl.clear();
                    productsTbl.rows.add(res.data);
                    productsTbl.draw();
                }
            });
        });
        //================== END OF VIEW ALL PRODUCT ================================

        //==================== VIEW PRODUCT BY CATEGORY ID===========================
        $('a.view_product_btn').on('click', function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            var product_id = e.currentTarget.dataset['category_id'];
            $.ajax({
                url:`/api/category/products/${product_id}`,
                method: "GET",
                success:(res)=>{
                    productsTbl.clear();
                    productsTbl.rows.add(res.data);
                    productsTbl.draw();
                }
            });
        });
        //===================== END OF VIEW PRODUCT BY CATEGORY ID =================


    });   
    </script>
@endsection
