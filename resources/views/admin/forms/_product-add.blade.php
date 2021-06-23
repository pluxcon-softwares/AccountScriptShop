<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="addProductFrm" action="#" method="POST">
                @csrf
                
                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label for="addCategory">Main Category</label>
                            <select name="addCategory" id="addCategory" class="form-control">
                                <option value="">select category</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <label for="addSubCategory">Sub Category</label>
                            <select name="addSubCategory" id="addSubCategory" class="form-control">
                                <option value="">select sub-category</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="addName">Product Name</label>
                    <input type="text" name="addName" id="addName" placeholder="Enter product title" class="form-control">
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-6">
                            <label for="addPrice">Price</label>
                            <input type="text" class="form-control" name="addPrice" id="addPrice" placeholder="Enter Product Price(0.00)">
                        </div>

                        <div class="col-6">
                            <label for="addCountry">Country</label>
                            <input type="text" class="form-control" name="addCountry" id="addCountry" placeholder="Enter Country(optional)">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <textarea name="addDescription" id="addDescription" class="form-control" placeholder="Enter Product Details" cols="30" rows="5"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-block btn-primary fa-pull-right">
                        <div class="spinner spinner-border spinner-border-sm"></div>
                        Add Product
                    </button>    
                </div>
                </form>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
    </div>
  </div>