<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    public function showOrAddKategori()
    {
        $data['judul'] = 'Kategori Mobil';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['kategori'] = $this->ModelMobil->getKategori()->result_array();

        $this->form_validation->set_rules('kategori', 'Kategori', 'required', [
            'required' => 'Nama Kategori Harus Diisi'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/header', $data);
            $this->load->view('admin/sidebar', $data);
            $this->load->view('admin/topbar', $data);
            $this->load->view('kategori/kategori', $data);
            $this->load->view('admin/footer');
        } else {
            $data = [
                'nama_kategori' => $this->input->post('kategori')
            ];

            $this->ModelMobil->simpanKategori($data);
            redirect('kategori/showOrAddKategori');
        }
    }

    public function ubahKategori()
    {
        $data['judul'] = 'Ubah Kategori';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();

        $where = ['id_kategori' => $this->uri->segment(3)];
        $data['kategori'] = $this->ModelMobil->kategoriWhere($where)->row_array();
        $nama_kategori = $data['kategori']['nama_kategori'];

        $this->form_validation->set_rules('kategori', 'Nama Kategori', 'required|trim', [
            'required' => 'Nama Kategori tidak boleh kosong'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('admin/header', $data);
            $this->load->view('admin/sidebar', $data);
            $this->load->view('admin/topbar', $data);
            $this->load->view('kategori/ubah-kategori', $data);
            $this->load->view('admin/footer');
            validation_errors();
            $this->session->set_flashdata('kategori_error', '<div class="alert alert-danger alert-message" role="alert">Nama Kategori Tidak Boleh Kosong</div>');
        } else {
            $kategori = $this->input->post('kategori', true);
            $id = $this->input->post('id', true);
            $back = $this->input->post('back', true);

            if ($back == 'back' || $kategori == $nama_kategori) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-message" role="alert">Nama Kategori Tidak Berubah</div>');
                redirect('kategori/showOrAddKategori');
            } else {
                $this->db->set('nama_kategori', $kategori);
                $this->db->where('id_kategori', $id);
                $this->db->update('kategori');

                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Nama Kategori Berhasil Diubah</div>');
                redirect('kategori/showOrAddKategori');
            }
        }
    }

    public function hapusKategori()
    {
        $where = ['id_kategori' => $this->uri->segment(3)];
        $this->ModelMobil->hapusKategori($where);
        redirect('kategori/showOrAddKategori');
    }
}
