<div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
             
                
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th class ="col-lg-2"></th>
                        <th class ="col-lg-5">File TA Anda</th>
                        <th class ="col-lg-5">File TA Database</th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class ="col-lg-2"><label>Judul</label></td>
                        <td class ="col-lg-5"><h4 class="text-primary" id="comment"><?php echo $text1['judul'];?></h4></td>
                        <td class ="col-lg-5"><h4 class="text-primary" id="comment"><?php echo $text2['judul'];?></h4></td>
                    </tr>
                    <tr>
                        <td class ="col-lg-2"><label>Fingerprint</label></td>
                        <td class ="col-lg-5"><textarea disabled class="form-control" rows="5" name ="cleantext" id="cleantext"><?php echo implode('|', $text1['fingerprint']);?></textarea></td>
                        <td class ="col-lg-5"><textarea disabled class="form-control" rows="5" name ="cleantext" id="cleantext"><?php echo implode('|', $text2['fingerprint']);?></textarea></td>
                    </tr>
                    <tr>
                        <td class ="col-lg-2"><label>Similarity</label></td>
                        <td colspan="2"><?php echo $similarity;?> %</td>
                    </tr>
                    </tbody>
                </table>
                
                <a href="<?php echo base_url('upload/status'); ?> " class="btn btn-block btn-info"><span class="glyphicon glyphicon-circle-arrow-left"></span>  Input N-Gram Lain</a>
                <button type="button" class="btn btn-success btn-block" id="save"><span class="glyphicon glyphicon-file"></span> Save</button>
                <a href="<?php echo base_url('upload/result'); ?> " class="btn btn-block btn-danger"> <span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a> 
            </div>
        </div>
    </div>
    <script>
    $(document).ready(function(){
        $("#save").click(function(){
            $.post("<?php echo base_url(); ?>upload/simpandata",
            function(){
                alert("Upload Sukses \nFile Sudah Tersimpan Di Database ");
            });
        });
    });
    </script>