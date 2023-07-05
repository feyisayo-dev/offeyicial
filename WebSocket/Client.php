<?php

namespace WebSocket;

class Client
{
    private $url;
    private $options;
    private $socket;

    public function __construct($url, $options = array())
    {
        $this->url = $url;
        $this->options = $options;
    }

    public function connect()
    {
        $this->socket = @stream_socket_client($this->url, $errno, $errstr, 2, STREAM_CLIENT_CONNECT, stream_context_create($this->options));
        
        if (!$this->socket) {
            throw new \Exception("Failed to connect to WebSocket server: $errstr ($errno)");
        }

        stream_set_timeout($this->socket, 2);

        return true;
    }

    public function send($data)
    {
        if ($this->socket) {
            return fwrite($this->socket, $data);
        }

        return false;
    }

    public function receive()
    {
        if ($this->socket) {
            return fread($this->socket, 8192);
        }

        return false;
    }

    public function close()
    {
        if ($this->socket) {
            fclose($this->socket);
            $this->socket = null;
        }
    }
}
