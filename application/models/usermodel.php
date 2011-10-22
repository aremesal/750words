<?php

/**
 * Description of user
 *
 * @author remroyal
 */
class Usermodel extends CI_Model {
    public function  __construct() {
        parent::__construct();
    }

    public function createUser($data) {
        $uid = $this->mongo->db->users->insert($data);

        return $uid['_id'];
    }

    public function getUserByLogin($data) {

        $criteria = array(
            'email' => $data['email']
        );

        $user = $this->mongo->db->users->findOne($criteria);

        if( $user ) {
            $criteria = array(
                'email' => $data['email'],
                'pass' => hash('sha256', $this->input->post('pass') . $user['salt'] )
            );

            $user = $this->mongo->db->users->findOne($criteria);
        }
        
//print_r($user);exit();
        return $user;
    }

    public function getUserByEmail($email) {

        $criteria = array(
            'email' => $email
        );

        $user = $this->mongo->db->users->findOne($criteria);

        return $user ? TRUE : FALSE;
    }

    public function getUserByToken($token) {

        $criteria = array(
            'token' => $token
        );

        $user = $this->mongo->db->users->findOne($criteria);

        return $user ? $user : FALSE;
    }

    public function generatePassTokenByEmail($email) {

        $criteria = array(
            'email' => $email
        );

        $user = $this->mongo->db->users->findOne($criteria);

        if( $user ) {
            
            $token = encrypt_safeencode($user['_id'] . '~~' . $user['email'] . '~~' . strftime('%Y-%m-%d %T') );
            $token = hash('sha256', $token);

            $data = array(
                '$set'  => array(
                    'token'  => $token
                 )
            );

            $this->mongo->db->users->update($criteria, $data);

            return array(
                'email' => $user['email'],
                'token'     => $token
            );
        }
        else
            return FALSE;

        return $user ? TRUE : FALSE;
    }

    public function resetUserPass($pass, $uid, $token) {
        $criteria = array(
            '_id' => new MongoId($uid),
            'token' => $token
        );

        $user = $this->mongo->db->users->findOne($criteria);

        if( $user ) {

            $data = array(
                '$set'  => array(
                    'token'  => '',
                    'pass'  => $pass
                 )
            );

            $this->mongo->db->users->update($criteria, $data);

            return TRUE;
        }
        else
            return FALSE;
    }

    public function getUserByUID($uid) {

        $data = array(
            '_id' => new MongoId($uid)
        );

        $user = $this->mongo->db->users->findOne($data);

        return $user;
    }


}
?>
