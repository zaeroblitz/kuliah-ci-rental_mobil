<?php
defined('BASEPATH') or exit('No direct scipt access allowed');

class Mobil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();
    }

    public function index()
    {
        $data['judul'] = 'Data Mobil';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['mobil'] = $this->ModelMobil->getMobil()->result_array();
        $data['kategori'] = $this->ModelMobil->getKategori()->result_array();

        $this->form_validation->set_rules('kode_mobil', 'Nama Mobil', 'required|min_length[3]', [
            'required' => 'Nama Mobil harus diisi',
            'min_length' => 'Nama Mobil terlalu pendek',
        ]);

        $this->form_validation->set_rules('id_kategori', 'Kategori', 'required', [
            'required' => 'Nama Kategori harus diisi'
        ]);

        $this->form_validation->set_rules('merek', 'Merek', 'required|min_length[3]', [
            'required' => 'Merek harus diisi',
            'min_length' => 'Merek terlalu pendek',
        ]);

        $this->form_validation->set_rules('warna', 'Warna Mobil', 'required|min_length[3]', [
            'required' => 'Warna Mobil harus diisi',
            'min_length' => 'Warna Mobil terlalu pendek',
        ]);

        $this->form_validation->set_rules('tahun_pembuatan', 'Tahun Pembuatan', 'required|min_length[3]|max_length[4]|numeric', [
            'required' => 'Tahun Pembuatan harus diisi',
            'min_length' => 'Tahun Pembuatan terlalu pendek',
            'max_length' => 'Tahun Pembuatan terlalu panjang',
            'numeric' => 'Hanya dapat diisi oleh angka'
        ]);

        $this->form_validation->set_rules('plat_no', 'Plat Nomor', 'required|min_length[3]', [
            'required' => 'Plat Nomor harus diisi',
            'min_length' => 'Plat Nomor terlalu pendek',
        ]);

        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric', [
            'required' => 'Stok harus diisi',
            'numeric' => 'Hanya dapat diisi oleh angka',
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/header', $data);
            $this->load->view('admin/sidebar', $data);
            $this->load->view('admin/topbar', $data);
            $this->load->view('mobil/index', $data);
            $this->load->view('admin/footer');
        } else {

            // Jika ada gambar yang akan diupload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                // Konfigurasi sebelum gambar diupload
                $config['upload_path'] = './assets/img/upload/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                // $config['max_size'] = '3000';
                // $config['max_width'] = '1024';
                // $config['max_height'] = '1024';
                $config['file_name'] = 'img' . time();

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $image = $this->upload->data('file_name');
                } else {
                    $image = 'default.png';
                }
            } else {
            }

            $data = [
                'kode_mobil' => $this->input->post('kode_mobil', true),
                'id_kategori' => $this->input->post('id_kategori', true),
                'merek' => $this->input->post('merek', true),
                'warna' => $this->input->post('warna', true),
                'tahun_pembuatan' => $this->input->post('tahun_pembuatan', true),
                'plat_no' => $this->input->post('plat_no', true),
                'stok' => $this->input->post('stok', true),
                'dipinjam' => 0,
                'dibooking' => 0,
                'image' => $image,
            ];

            $this->ModelMobil->simpanMobil($data);
            redirect('mobil');
        }
    }

    public function ubahMobil()
    {
        $data['judul'] = 'Ubah Data Mobil';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['mobil'] = $this->ModelMobil->mobilWhere(['id' => $this->uri->segment(3)])->row_array();
        $data['kategori'] = $this->ModelMobil->joinKategoriMobil(['mobil.id' => $this->uri->segment(3)])->row_array();
        $data['kategori'] = $this->ModelMobil->getKategori()->result_array();

        $this->form_validation->set_rules('kode_mobil', 'Nama Mobil', 'required|min_length[3]', [
            'required' => 'Nama Mobil harus diisi', 'min_length' => 'Nama Mobil terlalu pendek'
        ]);

        $this->form_validation->set_rules('id_kategori', 'Kategori', 'required', [
            'required' => 'Nama kategori harus diisi',
        ]);

        $this->form_validation->set_rules('merek', 'Merek', 'required|min_length[3]', [
            'required' => 'Merek harus diisi',
            'min_length' => 'Merek terlalu pendek'
        ]);

        $this->form_validation->set_rules('warna', 'Warna', 'required|min_length[3]', [
            'required' => 'Warna harus diisi',
            'min_length' => 'Warna terlalu pendek'
        ]);

        $this->form_validation->set_rules('tahun_pembuatan', 'Tahun Pembuatan', 'required|min_length[3]|max_length[4]|numeric', [
            'required' => 'Tahun pembuatan harus diisi',
            'min_length' => 'Tahun pembuatan terlalu pendek',
            'max_length' => 'Tahun pembuatan terlalu panjang',
            'numeric' => 'Hanya boleh diisi angka'
        ]);

        $this->form_validation->set_rules('plat_no', 'Plat Nomor', 'required|min_length[3]', [
            'required' => 'Plat Nomor harus diisi', 'min_length' => 'Plat Nomor terlalu pendek'
        ]);

        $this->form_validation->set_rules('stok', 'Stok', 'required|numeric', [
            'required' => 'Stok harus diisi',
            'numeric' => 'Yang anda masukan bukan angka'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/header', $data);
            $this->load->view('admin/sidebar', $data);
            $this->load->view('admin/topbar', $data);
            $this->load->view('mobil/ubah-mobil', $data);
            $this->load->view('admin/footer');
        } else {
            $dataPost = [
                'kode_mobil' => $this->input->post('kode_mobil', true),
                'id_kategori' => $this->input->post('id_kategori', true),
                'merek' => $this->input->post('merek', true),
                'warna' => $this->input->post('warna', true),
                'tahun_pembuatan' => $this->input->post('tahun_pembuatan', true),
                'plat_no' => $this->input->post('plat_no', true),
                'stok' => $this->input->post('stok', true),
            ];

            $back = $this->input->post('back', true);

            $similarDataPost =
            $dataPost['kode_mobil'] == $data['mobil']['kode_mobil'] && 
            $dataPost['id_kategori'] == $data['mobil']['id_kategori'] &&
            $dataPost['merek'] == $data['mobil']['merek'] &&
            $dataPost['warna'] == $data['mobil']['warna'] &&
            $dataPost['tahun_pembuatan'] == $data['mobil']['tahun_pembuatan'] &&
            $dataPost['plat_no'] == $data['mobil']['plat_no'] &&
            $dataPost['stok'] == $data['mobil']['stok'];

            if ($back == 'back' || $similarDataPost) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-message" role="alert">Data Mobil Tidak Berubah</div>');
                redirect('mobil');
            } else {
                // Jika ada gambar yang akan diupload
                $upload_image = $_FILES['image']['name'];

                if ($upload_image) {
                    // Konfigurasi sebelum gambar diupload
                    $config['upload_path'] = './assets/img/upload/';
                    $config['allowed_types'] = 'jpg|png|jpeg';
                    // $config['max_size'] = '3000';
                    // $config['max_width'] = '1024';
                    // $config['max_height'] = '1000';
                    $config['file_name'] = 'img' . time();

                    // Membuat atau memanggil library upload
                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('image')) {
                        $gambar_lama = $data['mobil']['images'];
                        if ($gambar_lama != 'default.png') {
                            unlink(FCPATH . 'assets/img/upload/' . $gambar_lama);
                        }

                        $gambar_baru = $this->upload->data('file_name');
                        $this->db->set('image', $gambar_baru);
                    } else {
                    }
                }

                $this->ModelMobil->updateMobil($dataPost, ['id' => $this->input->post('id')]);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Data Berhasil Diubah</div>');
                redirect('mobil');
            }
        }
    }

    public function hapusMobil()
    {
        $where = ['id' => $this->uri->segment(3)];
        $this->ModelMobil->hapusMobil($where);
        redirect('mobil');
    }
}
