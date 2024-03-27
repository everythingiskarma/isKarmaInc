<?php

trait Sessions {

    private function session() {
        if(isset($_SESSION['api'])) {
            $this->session = $_SESSION['api'];
        } else {
            $_SESSION['api'] = session_create_id();
            $this->session = $_SESSION['api'];
        }
        $this->cookie = $_SERVER['HTTP_COOKIE'];
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->agent = $_SERVER['HTTP_USER_AGENT'];
        $this->referer = $_SERVER['HTTP_REFERER'];
        $this->time = $_SERVER['REQUEST_TIME_FLOAT'];
        $this->host = $_SERVER['HTTP_HOST'];

        // create server info array
        //$this->report[] = $_SERVER;
        $this->report[] = array(
            'session' => $this->session,
            'cookie' => $this->cookie,
            'ip' => $this->ip,
            'agent' => $this->agent,
            'referer' => $this->referer,
            'time' => $this->time,
            'host' => $this->host
        );
        $this->report[] = $_SERVER;
        return true;
    }

}
 ?>
