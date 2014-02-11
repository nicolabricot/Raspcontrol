<?php

namespace lib;

class Secret {
  
    const PHPPREFIX = '<?php /* ';
    const PHPSUFFIX = ' */ ?>';
    const SECRET_FILE = 'unicorn.php';
    const TOKEN_LENGTH = 25;

    private $data;

    public function __construct() {
      $this->check();
      $this->read();
    } 

    private function check() {
      if (!file_exists(self::SECRET_FILE)) {
        $this->data['username'] = 'admin';
        $this->data['password'] = $this->hashPassword($this->data['username'], 'secret');
        $this->generateApiToken();
        file_put_contents(self::SECRET_FILE, self::PHPPREFIX.base64_encode(gzdeflate(serialize($this->data))).self::PHPSUFFIX);
      }
    }


    private function read() {
      $this->data = (file_exists(self::SECRET_FILE) ? unserialize(gzinflate(base64_decode(substr(file_get_contents(self::SECRET_FILE),strlen(self::PHPPREFIX),-strlen(self::PHPSUFFIX))))) : array() );
    }

    private function save() {
      file_put_contents(self::SECRET_FILE, self::PHPPREFIX.base64_encode(gzdeflate(serialize($this->data))).self::PHPSUFFIX);
    }


    private function generateApiToken() {
      $this->data['api_token'] = substr(sha1(rand()), 0, self::TOKEN_LENGTH);
    }

    private function hashPassword($user, $password) {
      hash('sha512', $user . $password . $user);
    }

    public function verify($username, $password) {
      if ($username != $this->data['username']) { return false; }
      return $this->hashPassword($username, $password) == $this->data['password'];
    }

    public function verifyToken($username, $token) {
      if ($username != $this->data['username']) { return false; }
      return $token == $this->data['api_token']; 
    }

    public function setData($username, $password) {
      $this->data['username'] = $username;
      $this->data['password'] = $this->hashPassword($this->data['username'], $password);
      $this->generateApiToken();
      $this->save();
    }

    public function changeApiToken() {
      $this->generateApiToken();
      $this->save();
    }

    public function getUsername() {
      return $this->data['username'];
    }

    public function getApiToken() {
      return $this->data['api_token'];
    }
}

?>
