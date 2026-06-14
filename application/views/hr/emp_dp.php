<?php /*
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

*/?>

<div class="main-content">
    <div class="breadcrumb">
        <h1>Employee Documents Upload</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>

    <!-- EMP CODE TOP -->
    <div class="row mb-3">
        <div class="col-md-4">
            <label>Emp Code</label>
            <input type="text" class="form-control" id="emp_code">
        </div>
    </div>

    <div class="row" id="docContainer"></div>
</div>

<script>
$(function () {

    const docs = [
        {type:'profile_pic', label:'DP', accept:'image/*'},
        {type:'epf_photo', label:'EPF', accept:'image/*,application/pdf'},
        {type:'esi_photo', label:'ESI', accept:'image/*,application/pdf'},
        {type:'adhar_photo', label:'Aadhar', accept:'image/*,application/pdf'},
        {type:'bank_photo', label:'Bank', accept:'image/*,application/pdf'},
        {type:'other_id_photo', label:'PAN', accept:'image/*,application/pdf'},
        {type:'resume_photo', label:'Resume', accept:'.pdf,.doc,.docx'},
        {type:'other_docs_photo', label:'Other 1', accept:'image/*,application/pdf'},
        {type:'other_docs2_photo', label:'Other 2', accept:'image/*,application/pdf'},
        {type:'other_docs3_photo', label:'Other 3', accept:'image/*,application/pdf'},
        {type:'other_docs4_photo', label:'Other 4', accept:'image/*,application/pdf'}
    ];

    // CREATE UI
    docs.forEach(d => {

        let html = `
        <div class="col-md-3 mb-4">
            <div class="card p-2">
                <h6>${d.label}</h6>

                <input type="file" class="form-control fileInput" data-type="${d.type}" accept="${d.accept}">

                <img class="preview mt-2" style="max-width:100%;display:none;">

                <div class="progress mt-2" style="height:15px; display:none;">
                    <div class="progress-bar" style="width:0%">0%</div>
                </div>

                <button class="btn btn-success btn-sm mt-2 uploadBtn" data-type="${d.type}">
                    Upload
                </button>
            </div>
        </div>`;

        $('#docContainer').append(html);
    });


    // PREVIEW
    $(document).on('change', '.fileInput', function () {
        let file = this.files[0];
        let preview = $(this).closest('.card').find('.preview');

        if (!file) return;

        if (file.type.startsWith('image/')) {
            let reader = new FileReader();
            reader.onload = e => {
                preview.attr('src', e.target.result).show();
            };
            reader.readAsDataURL(file);
        } else {
            preview.hide();
        }
    });


    // UPLOAD
    $(document).on('click', '.uploadBtn', function () {

        let card = $(this).closest('.card');
        let fileInput = card.find('.fileInput')[0];
        let file = fileInput.files[0];
        let type = $(this).data('type');
        let emp_code = $('#emp_code').val();

        if (!emp_code) {
            fun_message('error','Error','Enter Emp Code','toast-bottom-right');
            return;
        }

        if (!file) {
            fun_message('error','Error','Select file first','toast-bottom-right');
            return;
        }

        let formData = new FormData();
        formData.append('emp_code', emp_code);
        formData.append('type', type);
        formData.append('img1', file);

        let progressBox = card.find('.progress');
        let progressBar = card.find('.progress-bar');

        progressBox.show();
        progressBar.css('width','0%').text('0%');

        $.ajax({
            url: "<?= base_url('index.php/Hr/emp_dp_save2');?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            xhr: function () {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (e) {
                    if (e.lengthComputable) {
                        let percent = Math.round((e.loaded / e.total) * 100);
                        progressBar.css('width', percent + '%').text(percent + '%');
                    }
                });
                return xhr;
            },

            success: function (res) {
                if (res.status === 'success') {
                    fun_message('success','Success','Uploaded','toast-bottom-right');
                    fileInput.value = '';
                    card.find('.preview').hide();
                } else {
                    fun_message('error','Error',res.message,'toast-bottom-right');
                }
            },

            error: function () {
                fun_message('error','Error','Upload failed','toast-bottom-right');
            },

            complete: function () {
                setTimeout(() => {
                    progressBox.hide();
                }, 1500);
            }
        });

    });

});

</script>