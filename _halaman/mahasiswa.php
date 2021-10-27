<?php
$title = "Data Mahasiswa";
$judul = $title;
$url = 'mahasiswa';
;

if (isset($_POST['simpan'])) {
    // cek validasi
    $validation=null;
    // cek nim apakah sudah ada
    if($_POST['id']!=""){
        $db->where('id !='.$_POST['id']);
    }
    $db->where('nim',$_POST['nim']);
    $db->get('tb_mahasiswa');
    if($db->count>0){
        $validation[]='NIM Sudah Ada';
    }

    //tidak boleh string
    $nimm = $_POST['nim'];
    if (!preg_match("/^[1-9][0-9]{0,15}$/",$nimm)) {
        $validation[]='Input NIM berupa angka!';
    }
    
    //input tidak boleh kosong
  
    if($_POST['nim']==''){
        $validation[]='NIM Tidak Boleh Kosong!';
    }
    if($_POST['nama']==''){
        $validation[]='Nama Tidak Boleh Kosong!';
    }

    if($_POST['alamat']==''){
        $validation[]='Alamat Tidak Boleh Kosong!';
    }

    //cek validasi
    if(!empty($validation)){
        $setTemplate=false;
        $session->set('error_validation',$validation);
        $session->set('error_value',$_POST);
        redirect($_SERVER['HTTP_REFERER']);
        return false;
    }


    if ($_POST['id'] == "") {


        $data['nama'] = $_POST['nama'];
        $data['nim'] =$_POST['nim'];
        $data['alamat'] = $_POST['alamat'];
        $exec=$db->insert('tb_mahasiswa', $data);
        $info= '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>SUKSES!</strong> Data Sukses ditambah.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
        </div>';

    }
    else {
        $data['nama'] = $_POST['nama'];
        $data['nim'] = $_POST['nim'];
        $data['alamat'] = $_POST['alamat'];
        $db->where('id', $_POST['id']);
        $exec=$db->update("tb_mahasiswa", $data);
        $info= '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>SUKSES!</strong> Data Sukses diubah.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
        </div>';
    }

    if($exec){
        $session->set('info',$info);
    }
    else{
      $session->set("info",'<div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Error!</h4> Proses gagal dilakukan
        </div>');
  }
  redirect(url($url));
}

if (isset($_GET['hapus'])) {
    $db->where('id', $_GET['id']);
    $exec=$db->delete('tb_mahasiswa');
    $info= '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>SUKSES!</strong> Data Sukses dihapus.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
    </div>';

    if($exec){
        $session->set('info',$info);
    }
    else{
        $session->set("info",'<div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>GAGAL!</strong>Proses Gagal dilakukan.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
          </div>');
    }
    redirect(url($url));
}


elseif (isset($_GET['tambah']) or isset($_GET['ubah'])) {

    $id = "";
    $nama = "";
    $nim = "";
    $alamat = "";
    if (isset($_GET['ubah']) and isset($_GET['id'])) {

        $id = $_GET['id'];
        $db->where('id', $id);
        $row = $db->ObjectBuilder()->getOne('tb_mahasiswa');
        if ($db->count > 0) {
            $id = $row->id;
            $nama = $row->nama;
            $nim = $row->nim;
            $alamat = $row->alamat;
        }
    }
    if($session->get('error_value')){
        extract($session->pull('error_value'));
    }
    ?>


<?= content_open('Form') ?>
<div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">

    <div class="card-body card mb-4">
        <form role="form" method="POST" enctype="multipart/form-data">
            <?php
            // menampilkan error validasi
                if($session->get('error_validation')){
                    foreach ($session->pull('error_validation') as $key => $value) {
                        echo '<p style="color:red">'.$value.'</p>';
                    }
                }
                ?>
            <?= input_hidden('id', $id) ?>
            <label>Nama</label>
            <div class=" mb-2">
                <?= input_text('nama', $nama) ?>
            </div>
            <label>NIM</label>
            <div class="mb-2">
                <?= input_text('nim', $nim) ?>
            </div>
            <label>Alamat</label>
            <div class="mb-2">
                <?= input_text('alamat', $alamat) ?>
            </div>
            <div class="form-group">
                <button type="submit" name="simpan" class="btn bg-gradient-info  mt-2 mb-0">Simpan</button>
                <a href="<?= url($url) ?>" class="btn bg-gradient-danger  mt-2 mb-0">Batal</a>
            </div>

        </form>
    </div>
</div>
<?= content_close() ?>

<?php } else { ?>
<?= content_open('Data Mahasiswa') ?>
<div class="row">
    <div class="box-header with-border">
        <a class="btn bg-gradient-dark mb-0" href="<?= url($url . '&tambah') ?>"> <i
                class="fas fa-plus"></i>&nbsp;&nbsp;Add New</a>
        <br><br>
        <?=$session->pull("info")?>
    </div>

    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">NIM</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Alamat
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                $getdata = $db->ObjectBuilder()->get('tb_mahasiswa');
                                foreach ($getdata as $key) {
                                    ?>
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <p class="text-xs font-weight-bold mb-0"><?= $no++ ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <p class="text-xs font-weight-bold mb-0"><?= $key->nama ?></h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <p class="text-xs font-weight-bold mb-0"><?= $key->nim ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <p class="text-xs font-weight-bold mb-0"><?= $key->alamat ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a class="btn btn-link text-dark px-3 mb-0"
                                        href="<?= url($url . '&ubah&id=' . $key->id) ?>"><i
                                            class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
                                    <a class="btn btn-link text-danger text-gradient px-3 mb-0"
                                        onclick="return confirm('Hapus data?')"
                                        href="<?= url($url . '&hapus&id=' . $key->id) ?>"><i
                                            class="far fa-trash-alt me-2"></i>Delete</a>

                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= content_close() ?>
<?php } ?>