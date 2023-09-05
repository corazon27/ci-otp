<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Biodata_model extends CI_Model
{
    //join antara tabel user dan tabel biodata
    public function dataProfile($params)
    {
        $this->db->select('a.jk, a.alamat, a.no_telp, b.id_user');
        $this->db->from('biodata a');
        $this->db->join('user b', 'a.id_user = b.id_user', 'left');
        $this->db->where('b.id_user', $params);
        return $this->db->get()->row_array();
    }

    public function dataDomisili($params)
    {
        $this->db->select('a.id_user, b.id_provinsi, c.id_kota, d.id_kecamatan');
        $this->db->from('user a');
        $this->db->join('provinsi b', 'a.id_provinsi = b.id_provinsi', 'left');
        $this->db->join('kota c', 'a.id_kota = c.id_kota', 'left');
        $this->db->join('kecamatan d', 'a.id_kecamatan = d.id_kecamatan', 'left');
        $this->db->where('a.id_user', $params);
        return $this->db->get()->row_array();
    }

    public function dataProvinsi()
    {
        $this->db->select('a.*');
        $this->db->from('provinsi a');
        $this->db->order_by('a.provinsi', 'ASC');
        return $this->db->get()->result_array();
    }
    public function dataKota($provinsiId)
    {
        $this->db->where('id_provinsi',$provinsiId);
        $kota = $this->db->get('kota')->result_array();
        //echo $this->db->last_query();
        return $kota;
    }
    public function dataKecamatan($kotaId)
    {
        $this->db->where('id_kota',$kotaId);
        $kota = $this->db->get('kecamatan')->result_array();
        //echo $this->db->last_query();
        return $kota;
    }

    public function getKotaByProvinsi($provinsi_id)
    {
        $this->db->select('a.*');
        $this->db->from('kota a');
        $this->db->where('a.id_provinsi', $provinsi_id);
        $this->db->order_by('a.kota', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getKecamatanByKota($kota_id)
    {
    $this->db->select('a.*');
    $this->db->from('kecamatan a');
    $this->db->where('a.id_kota', $kota_id);
    $this->db->order_by('a.kecamatan', 'ASC');
    return $this->db->get()->result_array();
    }

    // Model biodata
    public function update($id_user, $data)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->update('biodata', $data);
    }

    public function create($data)
    {
        return $this->db->insert('biodata', $data);
    }

    public function isExists($id_user)
    {
        return $this->db->get_where('biodata', array('id_user' => $id_user))->num_rows() > 0;
    }

    public function getUser($id) {
        $this->db->where('id_user',$id);
        $user = $this->db->get('user')->row_array();
        return $user;
    }
}