<?php

namespace Dshu\ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Dshu\ChatBundle\Document\Chat;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
	public function indexAction(){
		$form = $this->createFormBuilder()
			->add('user','text')
			->add('chatid','text')
			->getForm();
		
		return $this->render('DshuChatBundle:Default:index.html.twig',array('form' => $form->createView()));
	}
    public function chatAction(Request $request)
    {
    	//$request=$this->get('request');
    	$c = new Chat();
 	
    	$form = $this->createFormBuilder($c)
    		->add('chatid','hidden')
    		->add('user','hidden')
    		->add('message','text',array("required" => false))
    		->getForm();
    	
    	$form->bind($request);
    	
    	$cs = $this->get('chat_service');
    	$chats = $cs->getMessage($c->getChatid(),"00000000",20);
    	
    	return $this->render('DshuChatBundle:Default:chatwindow.html.twig', 
    				array('form' => $form->createView(),
    						'messages' => $chats,
    						'chatid' => $c->getChatid(),
    						'curTime' => dechex(time())
    	));
    }
    
    public function sendAction(Request $request){
    	$c = new Chat();
    	$c->setChatid($request->request->get('chatid'));
    	$c->setUser($request->request->get('user'));
    	$c->setMessage($request->request->get('message'));
    	$cs = $this->get('chat_service');
    	$cs->sendMessage($c);
    	return new Response('sucess');
    }
    
    public function getAction(Request $request){
    	// process message get requests
    	$chatid = $request->request->get('chatid');
    	$time = $request->request->get('time');
    	
    	$cs = $this->get('chat_service');
    	$messages = $cs->getMessage($chatid,$time);
    	$json = '{"messages":[';
    	foreach ($messages as $m){
    		$json .= $m->getJSON() . ",";
    	}
    	$json = substr($json,0,-1);
    	$json .= ']}';
    	$response = new Response($json);
    	$response->headers->set('Content-Type', 'application/json');
    	return $response;
    	
    }
    
   
}
