
        <!-- ============ Body content start ============= -->
        <div class="main-content">
                <div class="breadcrumb">
                    <h1>Employee Documents upload</h1>
                </div>
                <div class="separator-breadcrumb border-top" ></div>
                <div class="row">
                        <div class="col-md-4">
                              <div class="progress mt-2" style="height:20px; display:none;" id="progressBox">
                              <div class="progress-bar progress-bar-striped progress-bar-animated"
                                    role="progressbar"
                                    style="width:0%" id="progressBar">0%</div>
                              </div>

                              <img id="previewImg" style="max-width:150px;display:none;margin-top:10px;">

                        </div>


                        <div class="col-md-4">
                              <div class="card mb-12">
                            <div class="card-body">
                              <div class="card-title" >Select Your File</div>
                                    <div class="form-row">
                                    
                                    <div class="col-md-12">
                                          <ol>
                                                <li>Profile_pic : JPG, JPEG, PNG (Passport size photo)',</li>
                                                <li>Resume_photo : PDF, DOC, DOCX (Resume only)'</li>
                                                <li> Adhar / ESI/ PF/ Bank    : JPG, PNG, PDF',</li>
                                                <li> Other   :  JPG, PNG, PDF'</li>
                                          </ol>
                                   
                                    </div>
                                            
                                          
                                         <form id="empDpForm"
                                                action="<?php echo base_url('index.php/Hr/emp_dp_save2');?>"
                                                method="post"
                                                enctype="multipart/form-data" class="col-md-12">

                                                <div class="col-md-12">
                                                      <label>Type of Documents</label>
                                                      <select class="form-control" name="type" id="type" required>
                                                            <option value="profile_pic">DP</option>
                                                            <option value="epf_photo">EPF Photo</option>
                                                            <option value="esi_photo">ESI Photo</option>
                                                            <option value="adhar_photo">Aadhar Photo</option>
                                                            <option value="bank_photo">Bank Photo</option>
                                                            <option value="other_id_photo">Pan Card Photo</option>
                                                            <option value="resume_photo">Resume Photo</option>
                                                            <option value="other_docs_photo">Other Docs Photo 1</option>
                                                            <option value="other_docs2_photo">Other Docs Photo 2</option>
                                                            <option value="other_docs3_photo">Other Docs Photo 3</option>
                                                            <option value="other_docs4_photo">Other Docs Photo 4</option>
                                                      </select>
                                                </div>

                                                <div class="col-md-12">
                                                      <label>Emp Code</label>
                                                      <input type="text" class="form-control"  name="emp_code" required>
                                                </div>

                                                <div class="col-md-12">
                                                      <label>Select Pic</label>
                                                      <input type="file" class="form-control" name="img1" required>
                                                </div>

                                                <div class="col-md-12 mt-4 text-center">
                                                      <button type="submit" class="btn btn-success">
                                                            Save
                                                      </button>
                                                      <span id="wait" style="display:none;color:orange;">
                                                            Uploading...
                                                      </span>
                                                </div>
                                          </form>

                          
                                    </div>
                                    
                               
                            </div>
                             
                        </div>
                        
                    </div>
                    
                </div><!-- end of main-content -->   


<script>
      



$(function () {

    const docHelp = {
        profile_pic  : 'Allowed: JPG, JPEG, PNG (Passport size photo)',
        resume_photo : 'Allowed: PDF, DOC, DOCX (Resume only)',
        epf_photo    : 'Allowed: JPG, PNG, PDF',
        esi_photo    : 'Allowed: JPG, PNG, PDF'
    };

    function updateHint() {
        let type = $('#type').val();
        $('#docHint').text(docHelp[type] ?? '');
    }

    updateHint();               // page load
    $('#type').on('change', updateHint);

});

$(function () {

    // Preview (image only)
   $('input[name="img1"]').on('change', function () {
            let type = $('#type').val();
            let file = this.files[0];
            if (!file) return;

            const allow = {
                  profile_pic  : ['image/jpeg','image/png'],
                  resume_photo : ['application/pdf',
                                    'application/msword',
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
                  epf_photo    : ['image/jpeg','image/png','application/pdf'],
                  esi_photo    : ['image/jpeg','image/png','application/pdf'],
                  adhar_photo    : ['image/jpeg','image/png','application/pdf'],
                  bank_photo    : ['image/jpeg','image/png','application/pdf'],
                  other_id_photo    : ['image/jpeg','image/png','application/pdf'],
                  other_docs_photo    : ['image/jpeg','image/png','application/pdf'],
                  other_docs2_photo    : ['image/jpeg','image/png','application/pdf'],
                  other_docs3_photo    : ['image/jpeg','image/png','application/pdf'],
                  other_docs4_photo    : ['image/jpeg','image/png','application/pdf']
            };

            if (!allow[type].includes(file.type)) {
                  //alert('Wrong file type selected. See allowed formats below.');
                  fun_message('error','Error','Wrong file type selected. See allowed formats below.','toast-bottom-right');
                  this.value = '';
            }

            if (file.type.startsWith('image/')) {
                  let reader = new FileReader();
                  reader.onload = e => {
                  $('#previewImg').attr('src', e.target.result).show();
                  };
                  reader.readAsDataURL(file);
            } else {
            $('#previewImg').hide();
            }
      });


    $('#empDpForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $('#wait').show();
        $('#progressBox').show();
        $('#progressBar').css('width', '0%').text('0%');

        $.ajax({
            url: this.action,
            type: 'POST',
            data: formData,
            dataType: 'json', 
            processData: false,
            contentType: false,
           
            xhr: function () {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (e) {
                    if (e.lengthComputable) {
                        let percent = Math.round((e.loaded / e.total) * 100);
                        $('#progressBar').css('width', percent + '%').text(percent + '%');
                    }
                });
                return xhr;
            },

            success: function (res) {
                  console.log(res);

                  if (res.status === 'success') {
                        $('input[name="img1"]').val('');
                        $('#previewImg').hide();
                        //alert(res.message);
                        fun_message('success',res.message,'Save Successfully','toast-bottom-right');
                  } else {
                        //alert(res.message ?? 'Upload failed');
                        fun_message('error','Error','Upload failed','toast-bottom-right');return false;
                  }
            },

            error: function () {
                //alert('Upload failed');
                fun_message('error','Error','Upload failed','toast-bottom-right');return false;
            },

            complete: function () {
                $('#wait').hide();
                $('#progressBox').hide();
            }
        });
    });

});
</script>

<?php $this->load->view('js/hr_js');?>

