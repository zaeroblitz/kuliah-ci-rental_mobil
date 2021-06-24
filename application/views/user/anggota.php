<!-- Begin Page Content -->
<div class="container-fluid">
    <?= $this->session->flashdata('pesan'); ?>
    <div class="row">
        <div class="col-lg-3">
            <?php if (validation_errors()) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= validation_errors(); ?>
                </div>
            <?php } ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Picture</th>
                        <th></th>
                        <th></th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Registration Date</th>
                        <th colspan="2" >Pilihan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $num = 1;
                    foreach ($anggota as $a) { ?>
                        <tr>
                            <th scope="row"><?= $num++; ?></th>
                            <td><?= $a['nama']; ?></td>
                            <td><?= $a['email']; ?></td>
                            <td colspan="3">
                                <picture>
                                    <source srcset="" type="image/svg+xml">
                                    <img src="<?= base_url('assets/img/profile/') .$a['image']; ?>" class="img-fluid img-thumbnail" alt="..."
                                    style="object-fit: cover; background-position: center; width:350px; height:100px;">
                                </picture>
                            </td>
                            <td>
                                <?php 
                                    $roleID = $a['role_id'];
                                    switch ($roleID) {
                                        case '1':
                                            echo 'Administrator';
                                            break;
                                        
                                        default:
                                            echo 'Member';
                                            break;
                                    }                                    
                                ?>
                            </td>
                            <td>
                                <?php 
                                    $roleID = $a['is_active'];
                                    switch ($roleID) {
                                        case '0':
                                            echo 'Not Activated';
                                            break;
                                        
                                        default:
                                            echo 'Activated';
                                            break;
                                    }                                    
                                ?>
                            </td>
                            <td><?= date("Y-m-d H:i:s", $a['tanggal_input']); ?></td>
                            <td>
                                <a href="<?= base_url('user/ubahAnggota/') . $a['id'] ?>" class="badge badge-info"><i class="fas fa-edit"></i> Ubah</a>
                            </td>
                            <td>
                                <a href="<?= base_url('user/ubahAnggota/') . $a['id'] ?>" onclick="return confirm('Kamu yakin akan menghapus data <?= $a['nama'] ?>?');" class="badge badge-danger"><i class="fas fa-trash"></i>
                                    Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<!-- End of Main Content -->