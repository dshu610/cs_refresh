<?php
// src/Dshu/Chat/ChatBundle/Document/Chat.php

namespace Dshu\ChatBundle\Document;

class Chat{
	/**
     * @var MongoId $id
     */
    protected $id;

    /**
     * @var string $user
     */
    protected $user;

    /**
     * @var string $chatid
     */
    protected $chatid;

    /**
     * @var string $message
     */
    protected $message;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param string $user
     * @return \Chat
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * Get user
     *
     * @return string $user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set chatid
     *
     * @param string $chatid
     * @return \Chat
     */
    public function setChatid($chatid)
    {
        $this->chatid = $chatid;
        return $this;
    }

    /**
     * Get chatid
     *
     * @return string $chatid
     */
    public function getChatid()
    {
        return $this->chatid;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return \Chat
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get message
     *
     * @return string $message
     */
    public function getMessage()
    {
        return $this->message;
    }
    
    /**
     * Get JSON
     * 
     * @return json encoded string
     */
    public function getJSON(){
    	return '{"id":"' . $this->id .  '", "chatid":"' . $this->chatid . '", "user":"' . $this->user . '", "message":"' . $this->message . '"}';
    }
}
