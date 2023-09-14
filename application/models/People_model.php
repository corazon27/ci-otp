<?php 
use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;
class People_model extends CI_Model
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
    
    public function getAllPeoples()
    {
        return $this->db->get('peoples')->result_array();
    }

    public function getPeoples($params)
    {
        $this->db->select('p.*, u.id_user');
        $this->db->from('peoples p');
        $this->db->join('user u', 'p.id_user = u.id_user', 'inner');
        $this->db->where('u.id_user', $params['user_id']);
        $this->db->limit($params['limit'], $params['start']);

        return $this->db->get()->result_array();
    }


    public function countAllPeoples($id_user)
    {
        $key = "peoples_page_" . $id_user;
    
        // Coba mendapatkan data dari cache
        $cachedData = $this->InstanceCache->getItem($key);
        
        if (!$cachedData->isHit()) {
            // Jika data tidak ada di cache, lakukan query ke database
            $query = $this->db->from('peoples')
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
}

?>