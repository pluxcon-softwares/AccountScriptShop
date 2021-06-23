@extends('admin.layouts.master')

@section('content')
    <div class="row justify-content-center mt-3">

        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title"><i class='fas fa-cog'></i> Change Site Logo</div>
                </div>
                <div class="card-body">
                    <form id="siteLogoUploadFrm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="siteLogo">Choose Image</label>
                        <input type="file" name="sitelogo" class="form-control" id="siteLogo">
                    </div>
                    <div class="form-group">
                        <p>Note: upload file size: 2MB maxinum</p>
                        <p></p>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger fa-pull-right">Upload</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title"><i class='fas fa-cog'></i> Change Site Name</div>
                </div>
                <div class="card-body">
                    <form id="siteNameFrm" method="POST">
                        <div class="form-group">
                            <label for="sitename">Site Name</label>
                            <input type="text" class="form-control" placeholder="Enter site name" name="sitename" id="sitename">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-danger fa-pull-right">
                                <div class="spinner spinner-border spinner-border-sm"></div>
                                Change
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


    <div class="row">
        <div class="col-6">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title"><i class='fas fa-cog'></i> Change Site Background</div>
                </div>
                <div class="card-body">
                    <form id="backgroudUploadFrm" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="sitebackground">Choose Image</label>
                        <input type="file" name="sitebackground" class="form-control" id="sitebackground">
                    </div>
                    <div class="form-group">
                        <p>Note: upload file size: 2MB maxinum</p>
                        <p></p>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger fa-pull-right">
                            <div class="spinner spinner-border spinner-border-sm"></div>
                            Upload
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('extra_script')
    <script>
        $(function(){
            //Configure CSRF Token Header
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content'),
                }
            });

            //Upload SIte Logo
            $("#siteLogoUploadFrm").submit(function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                var uploadInputEl = $('input[type=file][name=sitelogo]');
                var formData = new FormData(this);
                $.ajax({
                    url: '/admin/setting/upload/site/logo',
                    method: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    success:(res)=>{
                
                        $('div.error-msg').remove();
                        if(res.errors)
                        {
                            if(res.errors.sitelogo)
                            {
                                $(`<div style='color:yellow' class='error-msg'>${res.errors.sitelogo}</div>`).insertBefore(uploadInputEl);
                                uploadInputEl.addClass('is-invalid');
                            }
                            else{
                                uploadInputEl.removeClass('is-invalid');
                            }
                        }

                        if(res.success)
                        {
                            swal.fire({
                                title: 'Success!',
                                text: `${res.success}`,
                                icon: 'success'
                            }).then((result)=>{
                                window.location.reload();    
                            });
                            
                        }
                    }
                });
            });

            //Change site name
            var buttonSpinner = $('#siteNameFrm button div.spinner');
            buttonSpinner.hide();
            $('#siteNameFrm').submit(function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                var sitenameEl = $('input[name=sitename]');
                var formData = new FormData(this);
                $.ajax({
                    url: '/admin/setting/change/sitename',
                    method: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend:()=>{ buttonSpinner.show() },
                    complete:()=>{ buttonSpinner.hide() },
                    success:(res)=>{
                        if(res.errors)
                        {
                            $('div.error-msg').remove();
                            if(res.errors.sitename)
                            {
                                $(`<div style='color:yellow' class='error-msg'>${res.errors.sitename}</div>`).insertBefore(sitenameEl);
                                sitenameEl.addClass('is-invalid');
                            }
                            else{
                                sitenameEl.removeClass('is-invalid');
                            }
                        }

                        if(res.success)
                        {
                            $('div.error-msg').remove();
                            swal.fire({
                                title: 'Success!',
                                text: `${res.success}`,
                                icon: 'success'
                            })
                            .then((result)=>{
                                window.location.reload();
                            })
                        }
                    }
                });
            });

            //Change background image
            var buttonSpinner = $('#backgroudUploadFrm button div.spinner');
            buttonSpinner.hide();
            $('#backgroudUploadFrm').submit(function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                var formData = new FormData(this);
                var inputEl = $('input[name=sitebackground]');
                $.ajax({
                    url: '/admin/setting/change/background-image',
                    method:'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    beforeSend:()=>{ buttonSpinner.show() },
                    complete:()=>{ buttonSpinner.hide() },
                    success:(res)=>{
                        if(res.errors)
                        {
                            $('div.error-msg').remove();
                            if(res.errors.sitebackground)
                            {
                                $(`<div style='color:yellow; font-size:12px;' class='error-msg'>${res.errors.sitebackground}</div>`).insertBefore(inputEl);
                                inputEl.addClass('is-invalid')
                            }
                            else{
                                inputEl.removeClass('is-invalid');
                            }
                        }

                        if(res.success)
                        {
                            swal.fire({
                                title: 'Success!',
                                text: `${res.success}`,
                                icon: 'success'
                            }).then( (result)=>{
                                $('#backgroudUploadFrm').trigger('reset');
                                window.location.reload();
                            } );
                        }
                    }
                });
            });
        });
    </script>
@endsection