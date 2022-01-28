<div class="modal fade" id="editMessageModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Compose Message</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="editMessageFrm" action="#" method="POST">
                @csrf
                
                <div class="form-group">
                    <input type="hidden" name="message_id" id="message_id">
                </div>

                <div class="form-group">
                        <label for="editTitle">Title</label>
                        <input type="text" name="editTitle" class="form-control" id="editTitle" placeholder="Enter Title">
                </div>

                <div class="form-group">
                    <label for="editBody">Content</label>
                    <textarea name="editBody" id="editBody" class="form-control" cols="30" rows="4" placeholder="Update Content"></textarea>
                </div>

                <div class="form-group">
                    <label for="editPublished">Select Published</label>
                    <select name="editPublished" id="editPublished" class="form-control">
                    <option value="1" selected>Yes</option>
                    <option value="0">No</option>
                    </select>
                </div>

                

                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-block btn-primary fa-pull-right">
                        <div class="spinner spinner-border spinner-border-sm"></div>
                        Update Message
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