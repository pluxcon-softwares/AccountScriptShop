@extends('admin.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')

    <div class="row">
      <div class="col-12">
        <div class="card card-primary">
        
          <div class="card-header">
            <div class="card-title">Message Board</div>
            <button class="btn btn-danger btn-sm fa-pull-right" id="createMessageBtn"><i class="fas fa-plus"></i> Compose Message</button>
          </div>
  
          <div class="card-body">
            <table class="table" id="messageTbl">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Topic</th>
                  <th>Published</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    @include('admin.forms._message-add')
    @include('admin.forms._message-edit')
    @include('admin.partials._message-view')

@endsection

@section('extra_script')
    <script>
        $(function(){

          //Set CSRF TOKEN header in ajaxSetup
          $.ajaxSetup({
            headers:{
              'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content')
            }
          });

          //Initialize messageboard datatable
          var messageTbl = $('#messageTbl').DataTable({
            ajax:{
                url: '/admin/messages',
                method: 'GET'
            },
            columns:[
              {
                data: 'created_at',
                render:(data)=>{
                  return `${moment(data).format('ll')}`;
                }
              },
              {data: 'title'},
              {
                data: 'is_published',
                render:(is_published)=>{
                  return `
                    ${is_published ? 'yes' : 'no'}
                  `;
                }
              },
              {
                data: 'id',
                render:(id)=>{
                  return `
                    <div class='btn-group'>
                      <button class='btn btn-primary btn-sm view_message' data-message_id='${id}'>
                        <i class='fas fa-file'></i>
                        view
                      </button>

                      <button class='btn btn-warning btn-sm edit_message' data-message_id='${id}'>
                        <i class='fas fa-edit'></i>
                        edit
                      </button>

                      <button class='btn btn-danger btn-sm delete_message' data-message_id='${id}'>
                        <i class='fas fa-trash'></i>
                        delete
                      </button>

                    </div>
                  `;
                }
              }
            ],
          });


          //========================= CREATE MESSAGE ================================
          $("#createMessageBtn").on('click', function(){
              
              //Assign all form elements to variables
              var addTitleEl = $('input[name=addTitle]');
              var addBodyEl = $('textarea[name=addBody]');
              var addPublishedEl = $('select[name=addPublished]');

              //Remove all error message elements
              $('#createMessageFrm span.error_msg').remove();
              $('*').removeClass('is-invalid');

              //Reset Form
              $('#createMessageFrm').trigger('reset');

              //hide submit button spinner
              var submitSpinner = $('#createMessageFrm button .spinner');
              submitSpinner.hide();

              //Show create message modal
              $('#createMessageModal').modal('show');

              //Submit create message form
              $('#createMessageFrm').submit(function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                //create new formData object
                var formData = new FormData(this);

                // process form data
                $.ajax({
                  url: `/admin/message/create`,
                  method: 'POST',
                  data: formData,
                  contentType: false,
                  processData: false,
                  beforeSend:()=>{ submitSpinner.show(); },
                  complete:()=>{ submitSpinner.hide(); },
                  success:(res)=>{

                    if(res.errors)
                    {
                      if(res.errors.addTitle)
                      {
                        addTitleEl.addClass('is-invalid');
                        $(`<span style='color:yellow' class='error_msg'>${res.errors.addTitle}</span>`).insertBefore(addTitleEl);
                      }
                      else{
                        addTitleEl.removeClass('is-invalid');
                        $('span.error_msg').remove();
                      }

                      if(res.errors.addBody)
                      {
                        addBodyEl.addClass('is-invalid');
                        $(`<span style='color:yellow' class='error_msg'>${res.errors.addBody}</span>`).insertBefore(addBodyEl);
                      }
                      else{
                        addBodyEl.removeClass('is-invalid');
                        $('span.error_msg').remove();
                      }
                    } // end of checking error messages

                    if(res.success)
                    {
                      swal.fire({
                        title: 'Success!',
                        text: `${res.success}`,
                        icon: 'success'
                      });
                      $('#createMessageModal').modal('hide');
                      messageTbl.ajax.reload();
                    }

                  }
                });
              });
          });
          //======================== END OF CREATE MESSAGE ============================


          // ======================= EDIT/UPDATE MESSAGE ==============================
          $('#messageTbl').on('click', '.edit_message', function(e){
            var message_id = e.currentTarget.dataset['message_id'];
            
            // Assign all edit message form elements to variables
            var messageIdEl = $('input[name=message_id]');
            var editTitleEl = $('input[name=editTitle]');
            var editBodyEl = $('textarea[name=editBody]');
            var editPublishedEl = $('select[name=editPublished]');

            //Reset editMessage form
            $("#editMessageFrm").trigger('reset');

            //Clear/Delete all error messages
            $('#editMessageFrm span.error_msg').remove();
            $('*').removeClass('is-invalid');

            //Hide submit button spinner
            var editSubmitSpinner = $('#editMessageFrm button .spinner');
            editSubmitSpinner.hide();

            //Fetch message by ID for edit and updating
            $.ajax({
              url: `/admin/message/edit/${message_id}`,
              method: "GET",
              success:(res)=>{
                messageIdEl.val(res.data.id);
                editTitleEl.val(res.data.title);
                editBodyEl.val(res.data.body);
                `${ (res.data.is_published) ? editPublishedEl[0].children[0].selected = 'selected' : editPublishedEl[0].children[1].selected = 'selected' }`
              }
            });

            //Show editMessage Modal
            $('#editMessageModal').modal('show');

            //Submit Updated Form
            $("#editMessageFrm").submit(function(e){
              e.preventDefault();
              e.stopImmediatePropagation();
              var formData = new FormData(this);
              $.ajax({
                url: '/admin/message/update',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend:()=>{ editSubmitSpinner.show(); },
                complete:()=>{ editSubmitSpinner.hide(); },
                success:(res)=>{
                  if(res.errors)
                    {
                      if(res.errors.editTitle)
                      {
                        editTitleEl.addClass('is-invalid');
                        $(`<span style='color:yellow' class='error_msg'>${res.errors.editTitle}</span>`).insertBefore(editTitleEl);
                      }
                      else{
                        editTitleEl.removeClass('is-invalid');
                        $('span.error_msg').remove();
                      }

                      if(res.errors.editBody)
                      {
                        editBodyEl.addClass('is-invalid');
                        $(`<span style='color:yellow' class='error_msg'>${res.errors.editBody}</span>`).insertBefore(editBodyEl);
                      }
                      else{
                        editBodyEl.removeClass('is-invalid');
                        $('span.error_msg').remove();
                      }
                    } // end of checking error messages

                    if(res.success)
                    {
                      swal.fire({
                        title: 'Success!',
                        text: `${res.success}`,
                        icon: 'success'
                      });
                      $('#editMessageModal').modal('hide');
                      messageTbl.ajax.reload();
                    }
                }
              });
            });

          });
          // ======================= END OF EDIT/UPDATE MESSAGE ==============================


          // ============================= VIEW MESSAGE =======================================
          $("#messageTbl").on('click', '.view_message', function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            var message_id = e.currentTarget.dataset['message_id'];
            $.ajax({
              url: '/admin/message/view/' + message_id,
              method: "GET",
              success:(res)=>{
                $('#viewMessageModal .modal-body').empty().html(`<div>
                <h5><span class='badge badge-success'>Title:</span> ${res.data.title}</h5>
                <p><span class='badge badge-success'>Date:</span> ${ moment(res.data.created_at).format('ll') }</p>
                <p><span class='badge badge-success'>Is Published?:</span> ${res.data.is_published ? 'Yes' : 'No'}</p>
                <hr>
                <p>Message: <br> ${res.data.body}</p>
                </div>`);

                $('#viewMessageModal').modal('show');
              }
            });
          });
          // =========================== END OF VIEW MESSAGE ==================================

          
          // ============================ DELETE MESSAGE ======================================
          $('#messageTbl').on('click', '.delete_message', function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            var message_id = e.currentTarget.dataset['message_id'];
            swal.fire({
              title: 'Error!',
              text: 'Deleting message cannot be recover, Are you sure?',
              icon: 'error',
              showCancelButton: true,
              //showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, delete it!'
              //confirmButtonText: 'Ok!'
            }).then((result)=>{
              $.ajax({
                url: `/admin/message/delete/${message_id}`,
                method: "GET",
                success:(res)=>{
                  swal.fire({
                    title: 'Success!',
                    text: `${res.success}`,
                    icon: 'success'
                  });
                  messageTbl.ajax.reload();
                }
              });
            });
          });
          // ============================ END OF DELETE MESSAGE ==============================
        });
    </script>
@endsection
