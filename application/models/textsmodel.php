<?php

/**
 * Description of Textsmodel
 *
 * @author remroyal
 */
class Textsmodel extends CI_Model {

    public function  __construct() {
        parent::__construct();
    }

    public function getTodayTextByUID($uid, $date, $create_if_none = FALSE) {
        $criteria = array(
            'user_id' => new MongoId($uid),
            'created_at' => $date
        );

        $text = $this->mongo->db->texts->findOne($criteria);

        if( $text == NULL && $create_if_none ) {
            $data = array(
                'created_at'    => strftime('%Y-%m-%d', time()),
                'saved_at'      => new MongoDate(time()),
                'text'          => '',
                'user_id'       => new MongoId($uid),
                'count'         => 0,
            );

            $this->mongo->db->texts->insert($data);
            $text = $this->mongo->db->texts->findOne($criteria);
        }

        return $text;
    }

    public function saveTodayText($uid, $text, $count = 0) {
        $created_at = strftime('%Y-%m-%d',time());

        $data = array(
            '$set'  => array(
                'text'  => $text,
                'count'  => $count,
                'saved_at'  => new MongoDate(time())
             )
        );

        $criteria = array(
            'user_id'   => new MongoId($uid),
            'created_at'    => $created_at
        );

        $this->mongo->db->texts->update($criteria, $data);

        return $this->getTodayTextByUID($uid, $created_at);
    }

    public function getTodayTextByDate($uid, $date) {

        $criteria = array(
            'user_id' => new MongoId($uid),
            'created_at' => $date
        );

        return $this->mongo->db->texts->findOne($criteria);
    }

    public function getTextsByUser($uid) {

        $criteria = array(
            'user_id' => new MongoId($uid)
        );

        return $this->mongo->db->texts->find($criteria);
    }
}
?>
