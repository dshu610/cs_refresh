<?php 
// src/Dshu/ChatBundle/Service/ChatService.php

namespace Dshu\ChatBundle\Service;
use Dshu\ChatBundle\Document\Chat;

class ChatService{
	protected $chatId;
	protected $mongo;

	public function setMongo($m){
		$this->mongo = $m;
	}
	
	public function sendMessage(Chat $chatObj){
		$dm = $this->mongo->getManager();
		$dm->persist($chatObj);
		$dm->flush();
	}
	
	public function getMessage($chatId,$time,$limit=200){
		$dm = $this->mongo->getManager();
		$id = $time . '0000000000000000';
		$results = $dm->createQueryBuilder('DshuChatBundle:Chat')
			->field('_id')->gt($id)
			->field('chatid')->equals($chatId)
			->sort('_id','DESC')
			->limit($limit)
			->getQuery()
			->execute();
		return array_reverse($results->toArray());
	}
}

?>