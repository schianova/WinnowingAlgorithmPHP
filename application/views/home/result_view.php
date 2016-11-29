
<div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
             

                <form action="<?php echo base_url(); ?>upload/similarity" method="post" enctype="multipart/form-data">
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
                        <td class ="col-lg-7"><textarea disabled class="form-control" rows="5" name ="cleantext" id="cleantext"><?php echo $user['text'];?></textarea></td>
                    </tr>
                     <tr>
                        <td class ="col-lg-5"><label for="usr">K Gram</label></td>
                        <td class ="col-lg-7"><h4 class="text-primary" id="wgram"><?php echo $kgram;?></h4></td>
                    </tr>
                     <tr>
                        <td class ="col-lg-5"><label for="usr">W Gram</label></td>
                        <td class ="col-lg-7"><h4 class="text-primary" id="wgram"><?php echo $wgram;?></h4></td>
                    </tr>
                     <tr>
                        <td class ="col-lg-5"><label for="usr">Nilai Hash Dokumen Anda</label></td>
                        <td class ="col-lg-7"><textarea disabled class="form-control" rows="5" id="comment"><?php echo implode(' | ', $hash);?></textarea></td>
                    </tr>
                    <tr>
                        <td class ="col-lg-5"><label for="usr">Fingerprint Dokumen Anda</label></td>
                        <td class ="col-lg-7"><textarea disabled class="form-control" rows="5" id="comment"><?php echo implode(' | ', $fingerprint);?></textarea></td>
                    </tr>
                    <tr>
                        <td class ="col-lg-2"><label>Time Elapsed</label></td>
                        <td colspan="2"><?php echo $time;?> Second</td>
                    </tr>
                </table>
                <div class="col-md-12">
                    <label for="usr">Pilih File TA Database Untuk Di Cocokan</label>
                
                <table class = "table" id="storage">
                    <thead>
                        <tr>
                            <td>Pilih</td>
                            <td>Nama Uploader</td>
                            <td>Judul Skripsi</td>
                            <td>Tanggal Upload</td>
                        </tr>
                    </thead>                   
                    <?php $i=0; foreach($table  as $r): ?>
                    <tr>
                        <td><input type="radio" name="selected" value="<?php echo $r->id; ?>" <?php if($i==0) echo "checked"; ?>></td>
                        <td><?php echo $r->nama; ?></td>
                        <td><?php echo $r->judul; ?></td>
                        <td><?php echo $r->date_upload; ?></td>
                        </tr>
                    <?php $i++;endforeach; ?>
                </table>
               
                </div>  
                        
                       <button type="submit" class="btn btn-block btn-success">Check Similarity <span class="glyphicon glyphicon-circle-arrow-right"></span></button>

                       <a href="<?php echo site_url('upload/status'); ?> " class="btn btn-block btn-danger"> <span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a> 
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript" scr="assets/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" scr="assets/js/jquery-1.12.3.js"></script>
    <script>
    $(document).ready(function() {
    $('#storage').DataTable( {
        select: {
        items: 'column'
        }
        "paging":   true,
        "ordering": false,
        "info":     false,
        "searching" : true
        } );
    } ); 
    </script>
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