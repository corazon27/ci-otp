<?php
use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;
class Product_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        CacheManager::setDefaultConfig(new ConfigurationOption([
            'path' => APPPATH.'/cache', // or in windows "C:/tmp/"
        ]));
        
        // In your class, function, you can call the Cache
        $this->InstanceCache = CacheManager::getInstance('files');
    }

    public function get_total_data($id_user)
    {
        $key = "product_page_" . $id_user;
    
        // Coba mendapatkan data dari cache
        $cachedData = $this->InstanceCache->getItem($key);
        
        if (!$cachedData->isHit()) {
            // Jika data tidak ada di cache, lakukan query ke database
            $query = $this->db->from('products')
                ->where('id_user', $id_user)
                ->count_all_results();
    
            // Simpan hasil query ke dalam cache
            $cachedData->set($query)->expiresAfter(300);
            $this->InstanceCache->save($cachedData);
    
            return $query;
        } else {
            // Jika data ada di cache, kembalikan data dari cache
            return $cachedData->get();
        }
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
    
    //models
    public function get_all_data_product($params)
    {
        $this->db->select('p.*, u.id_user');
        $this->db->from('products p');
        $this->db->join('user u', 'p.id_user = u.id_user', 'inner');
        $this->db->where('u.id_user', $params['user_id']);
        $this->db->order_by('p.created_at', 'DESC'); // Menambahkan sorting
        $this->db->limit($params['limit'], $params['start']);

        return $this->db->get()->result_array();

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