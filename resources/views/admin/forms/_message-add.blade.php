<div class="modal fade" id="createMessageModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Compose Message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="createMessageFrm" action="#" method="POST">
                @csrf
                
                <div class="form-group">
                        <label for="addTitle">Title</label>
                        <input type="text" name="addTitle" class="form-control" id="addTitle" placeholder="Enter Title">
                </div>

                <div class="form-group">
                    <label for="addBody">Content</label>
                    <textarea name="addBody" id="addBody" class="form-control" cols="30" rows="4" placeholder="Add Content"></textarea>
                </div>

                <div class="form-group">
                    <label for="addPublished">Select Published</label>
                    <select name="addPublished" id="addPublished" class="form-control">
                    <option value="1" selected>Yes</option>
                    <option value="0">No</option>
                    </select>
                </div>

                

                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-block btn-primary fa-pull-right">
                        <div class="spinner spinner-border spinner-border-sm"></div>
                        Create Message
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