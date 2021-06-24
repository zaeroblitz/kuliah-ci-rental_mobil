<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-9">
            <?= form_open_multipart('mobil/ubahMobil/' . $mobil['id']) ?>

            <!-- ID -->
            <div class="form-group row">
                <label for="id" class="col-sm-2 col-form-label">ID</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="id" name="id" value="<?= $mobil['id']; ?>" readonly>
                </div>
            </div>

            <!-- Nama Mobil -->
            <div class="form-group row">
                <label for="kode_mobil" class="col-sm-2 col-form-label">Nama Mobil</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="kode_mobil" name="kode_mobil" value="<?= $mobil['kode_mobil']; ?>">
                    <?= form_error('kode_mobil', '<small class="textdanger pl-3">', '</small>'); ?>
                </div>
            </div>

            <!-- Kategori Mobil -->
            <div class="form-group row">
                <label for="id_kategori" class="col-sm-2 col-form-label">Kategori Mobil</label>
                <div class="col-sm-10">
                    <select name="id_kategori" class="form-control">
                        <option value="<?= $mobil['id_kategori']; ?>">
                            <?php
                            $mobilKategori = $this->ModelMobil->kategoriWhere(['id_kategori' => $mobil['id_kategori']])->row_array();
                            echo $mobilKategori['nama_kategori'];
                            ?>
                        </option>
                        <?php
                        foreach ($kategori as $k) { ?>
                            <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <!-- Merek -->
            <div class="form-group row">
                <label for="merek" class="col-sm-2 col-form-label">Merek Mobil</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="merek" name="merek" value="<?= $mobil['merek']; ?>">
                    <?= form_error('merek', '<small class="textdanger pl-3">', '</small>'); ?>
                </div>
            </div>

            <!-- Warna -->
            <div class="form-group row">
                <label for="warna" class="col-sm-2 col-form-label">Warna Mobil</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="warna" name="warna" value="<?= $mobil['warna']; ?>">
                    <?= form_error('warna', '<small class="textdanger pl-3">', '</small>'); ?>
                </div>
            </div>

            <!-- Tahun Pembuatan -->
            <div class="form-group row justify-content-center align-items-center">
                <label for="tahun_pembuatan" class="col-sm-2 col-form-label">Tahun Pembuatan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="tahun_pembuatan" name="tahun_pembuatan" value="<?= $mobil['tahun_pembuatan']; ?>">
                    <?= form_error('tahun_pembuatan', '<small class="textdanger pl-3">', '</small>'); ?>
                </div>
            </div>

            <!-- Plat Nomor -->
            <div class="form-group row">
                <label for="plat_no" class="col-sm-2 col-form-label">Plat Nomor</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="plat_no" name="plat_no" value="<?= $mobil['plat_no']; ?>">
                    <?= form_error('plat_no', '<small class="textdanger pl-3">', '</small>'); ?>
                </div>
            </div>

            <!-- Stok -->
            <div class="form-group row">
                <label for="stok" class="col-sm-2 col-form-label">Stok</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="stok" name="stok" value="<?= $mobil['stok']; ?>">
                    <?= form_error('stok', '<small class="textdanger pl-3">', '</small>'); ?>
                </div>
            </div>

            <!-- Image -->
            <div class="form-group row">
                <label for="stok" class="col-sm-2 col-form-label">Gambar</label>
                <div class="col-sm-10">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="<?= base_url('assets/img/upload/') . $mobil['image']; ?>" class="img-thumbnail" alt="">
                        </div>
                        <div class="col-sm-9">
                            <div class="custom-file">
                                <input type="file" class="form-control form-control-user" id="image" name="image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Button -->
            <div class="form-group row justify-content-end">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                    <button class="btn btn-dark" onclick="window.history.go(-1)" id="back" name="back" value="back"> Kembali
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