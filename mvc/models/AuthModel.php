<?php

class AuthModel extends DB
{
    // check username
    // check password
    function login($username, $password)
    {
        $user = $this->db->row(
            "SELECT * FROM users WHERE username = ?",
            $username
        );
        if (!empty($user)) {
            if ($password != $user['password']) {
                return array();
            } else {
                $user_info_more = $this->db->row(
                   "SELECT            
                    s.fullname as 'supervisor',
                    a.fullname as 'approver'
                FROM
                    users AS u,
                    users AS s,
                    users AS a
                WHERE
                    u.supervisor_id = s.id AND u.approver_id = a.id AND u.id =?",
                    $user['id']
                );
                return array_merge($user, $user_info_more);
            }
        } else {
            return array();
        }
    }

    function register($username, $password)
    {
        $flag = true;
        $checkUser = $this->db->row(
            "SELECT * FROM tbl_user WHERE username = ?",
            $username
        );
        if (!empty($checkUser)) {
            $flag = false;
        } else {
            $pwd_peppered = hash_hmac("sha256", $password, $_ENV['SECRECT_KEY']);
            $pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID);
            $result = $this->db->insert('tbl_user', [
                'user_id' => null,
                'username' => $username,
                'password' => $pwd_hashed,
            ]);
            $result < 1 && $flag = false;
        }
        return $flag;
    }
}
