<div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
             

                <form action="<?php echo base_url(); ?>upload/runWinnowing" method="post" enctype="multipart/form-data">
    			<table class = "table">
                    <tr>
                        <td class ="col-lg-5"><label>Nama Uploader</label></td>
                        <td class ="col-lg-7"><h4 class="text-primary" id="comment"><?php echo $user['nama'];?></h4></td>
                    </tr>
                    <tr>
                        <td class ="col-lg-5"><label>Judul Skripsi Anda</label></td>
                        <td class ="col-lg-7"><h4 class="text-primary" id="comment"><?php echo $user['judul'];?></h4></td>
                    </tr>
                    <tr>
                        <td class ="col-lg-5"><label for="usr">Hasil Preprocessing File Anda</label></td>
                        <td class ="col-lg-7"><textarea readonly class="form-control" rows="5" name ="cleantext" id="cleantext"><?php echo $user['text'];?></textarea></td>
                    </tr>
                     <tr>
                        <td class ="col-lg-5"><label for="usr">K Gram</label></td>
                        <td class ="col-lg-7"><textarea class="form-control" rows="1" name="kgram" id="kgram"></textarea></td>
                    </tr>
                     <tr>
                        <td class ="col-lg-5"><label for="usr">W Gram</label></td>
                        <td class ="col-lg-7"><textarea class="form-control" rows="1" name="wgram" id="wgram"></textarea></td>
                    </tr>
                     
                </table>
                        <span class="error has-error"><?php echo $this->session->flashdata('Message'); ?></span>
                        <button type="submit" class="btn btn-block btn-success">Process File Anda</button>
                        <button type="button" class="btn btn-success btn-block" id="save"><span class="glyphicon glyphicon-file"></span> Save</button>
                        <a href="<?php echo base_url('upload'); ?> " class="btn btn-block btn-danger"> <span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a> 
                        
                </form>
            </div>
        </div>
    </div><script>
    $(document).ready(function(){
        $("#save").click(function(){
            $.post("<?php echo base_url(); ?>upload/simpandata",
            function(){
                alert("Upload Sukses \n\nFile Sudah Tersimpan Di Database ");
            });
        });
    });
    </script>