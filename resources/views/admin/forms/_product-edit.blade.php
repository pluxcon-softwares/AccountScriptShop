<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <form id="editProductFrm" action="#" method="POST">
              @csrf
              <input type="hidden" name="product_id">
              <div class="form-group">
                  <div class="row">
                      <div class="col-6">
                          <label for="editCategory">Main Category</label>
                          <select name="editCategory" id="editCategory" class="form-control">
                              <option value="">select category</option>
                          </select>
                      </div>

                      <div class="col-6">
                          <label for="editSubCategory">Sub Category</label>
                          <select name="editSubCategory" id="editSubCategory" class="form-control">
                              <option value="">select sub-category</option>
                          </select>
                      </div>
                  </div>
              </div>

              <div class="form-group">
                  <label for="editName">Product Name</label>
                  <input type="text" name="editName" id="editName" placeholder="Enter product title" class="form-control">
              </div>

              <div class="form-group">
                  <div class="row">
                      <div class="col-6">
                          <label for="editPrice">Price</label>
                          <input type="text" class="form-control" name="editPrice" id="editPrice" placeholder="Enter Product Price(0.00)">
                      </div>

                      <div class="col-6">
                          <label for="editCountry">Country</label>
                          <input type="text" class="form-control" name="editCountry" id="editCountry" placeholder="Enter Country(optional)">
                      </div>
                  </div>
              </div>

              <div class="form-group">
                  <textarea name="editDescription" id="editDescription" class="form-control" placeholder="Enter Product Details" cols="30" rows="5"></textarea>
              </div>

              <div class="form-group">
                  <button type="submit" class="btn btn-sm btn-block btn-primary fa-pull-right">
                      <div class="spinner spinner-border spinner-border-sm"></div>
                      Update Product
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