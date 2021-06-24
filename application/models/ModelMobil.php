<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ModelMobil extends CI_Model
{
    // Manajemen Mobil
    public function getMobil()
    {
        return $this->db->get('mobil');
    }

    public function mobilWhere($where)
    {
        return $this->db->get_where('mobil', $where);
    }

    public function simpanMobil($data = null)
    {
        $this->db->insert('mobil', $data);
    }

    public function updateMobil($data = null, $where = null)
    {
        $this->db->update('mobil', $data, $where);
    }

    public function hapusMobil($where = null)
    {
        $this->db->delete('mobil', $where);
    }

    public function total($field, $where)
    {
        $this->db->select_sum($field);
        if (!empty($where) && count($where) > 0) {
            $this->db->where($where);
        }
        $this->db->from('mobil');
        return $this->db->get()->row($field);
    }

    // Manajemen Kategori
    public function getKategori()
    {
        return $this->db->get('kategori');
    }
    public function kategoriWhere($where)
    {
        return $this->db->get_where('kategori', $where);
    }
    public function simpanKategori($data = null)
    {
        $this->db->insert('kategori', $data);
    }
    public function hapusKategori($where = null)
    {
        $this->db->delete('kategori', $where);
    }
    public function updateKategori($data = null, $where = null)
    {
        $this->db->update('kategori', $data, $where);
    }
    
    //join
    public function joinKategoriMobil($where)
    {
        $this->db->select('mobil.id_kategori,kategori.id_kategori');
        $this->db->from('mobil');
        $this->db->join('kategori','kategori.id_kategori = mobil.id_kategori');
        $this->db->where($where);
        return $this->db->get();
    }
}
