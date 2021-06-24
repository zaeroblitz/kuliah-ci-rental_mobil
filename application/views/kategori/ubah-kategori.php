<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9">
            <form action="<?=  base_url('kategori/ubahKategori/') . $kategori['id_kategori']; ?>" method="POST">
            <div class="form-group row">
                <label for="id" class="col-sm-2 col-formlabel">ID</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="id" name="id" value="<?= $kategori['id_kategori']; ?>" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label for="kategori" class="col-sm-2 col-formlabel">Nama Kategori</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="kategori" name="kategori" value="<?= $kategori['nama_kategori']; ?>">                    
                    <?= $this->session->flashdata('kategori_error'); ?>
                </div>
            </div>
            <div class="form-group row justify-content-end">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                    <button class="btn btn-dark" onclick="window.history.go(-1)" id='back' name='back' value='back'> Kembali
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->