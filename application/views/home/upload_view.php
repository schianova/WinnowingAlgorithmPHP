<div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <form action="<?php echo base_url(); ?>upload/uploadValidation" method="post" enctype="multipart/form-data">
    			
                <label for="usr">Masukan Nama Anda</label>
                <input class="form-control" type="text" name="namauploader">

                <label for="usr">Masukan Judul Skripsi</label>
                <input class="form-control" type="text" name="judulskripsi">
                
                
                <br>
                <label class="btn btn-danger btn-file center-block">
                <span class="glyphicon glyphicon-file"></span>
                    Pilih File Upload
    			<input accept=".pdf" style="display: none;" type="file" name="fileToUpload" id="fileToUpload">
    			</label>
                
                <br>                
                <button class="btn btn-info center-block" type="submit" value="Upload File" name="submit">
                <span class="glyphicon glyphicon-upload"></span>
                Upload File
				</button>
                <br>
                <span class="error has-error"><?php echo $this->session->flashdata('Message'); ?></span>
                </form>
            </div>
        </div>
    </div>