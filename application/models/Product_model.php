<?php
class Product_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('phpfastcache_library');
    }

    public function get_total_data($id_user)
	{
	    $this->db->from('products');
	    $this->db->where('id_user', $id_user);
	    return $this->db->count_all_results();
	}

    public function get_data_pdf($id_user)
    {
        $query = $this->db->get_where('products', ['id_user' => $id_user]);
        if ($query->num_rows() > 0) 
        {
            return $query->result_array();
        } else 
        {
            return array();
        }
    }
    
    public function get_cached_data($cache_key, $callback)
    {
        $cached_data = $this->phpfastcache_library->get($cache_key);

        if ($cached_data === null) {
            // Data tidak ada di cache, panggil callback untuk mengambil data
            $data = $callback();
            

            // Simpan data ke dalam cache
            $this->phpfastcache_library->set($cache_key, $data, 3600); // Cache berlaku selama 1 jam
        } else {
            // Data ada di cache, gunakan data tersebut
            $data = $cached_data;
        }

        return $data;
    }

    public function get_all_data_product($params)
    {
        $cache_key = 'all_data_product_' . md5(serialize($params));

        return $this->get_cached_data($cache_key, function () use ($params) {
            $sql = "SELECT a.*, b.id_user 
                    FROM products a
                    INNER JOIN user b ON a.id_user = b.id_user
                    WHERE b.id_user = ?
                    ORDER BY a.created_at DESC
                    LIMIT ?, ?";
            return $this->db->query($sql, $params)->result_array();
        });
    }

    public function get_product_by_id($id)
    {
        // Query database untuk mendapatkan data produk berdasarkan ID
        $query = $this->db->get_where('products', array('id' => $id));
        return $query->row();
    }

    public function create($data)
    {
        $this->db->insert('products', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('products', $data);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('products');
        return $this->db->affected_rows();
    }

    public function delete_products($id, $jmlData)
    {
       for($i=0; $i < $jmlData; $i++){
        $this->db->delete('products', ['id' => $id[$i]]);
       }

       return true;
    }
}