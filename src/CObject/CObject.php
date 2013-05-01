<?php
/**
 * Holding a instance of CNexus to enable use of $this in subclasses and provide some helpers.
 *
 * @package NexusCore
 */
class CObject {

	/**
	 * Members
	 */
	public $config;
	public $request;
	public $data;
	public $db;
	public $views;
	public $session;


	/**
	 * Constructor
	 */
	protected function __construct() {
    $nx = CNexus::Instance();
    $this->config   = &$nx->config;
    $this->request  = &$nx->request;
    $this->data     = &$nx->data;
    $this->db       = &$nx->db;
    $this->views    = &$nx->views;
    $this->session  = &$nx->session;
  }


	/**
	 * Redirect to another url and store the session
	 */
	protected function RedirectTo($url) {
    $nx = CNexus::Instance();
    if(isset($nx->config['debug']['db-num-queries']) && $nx->config['debug']['db-num-queries'] && isset($nx->db)) {
      $this->session->SetFlash('database_numQueries', $this->db->GetNumQueries());
    }    
    if(isset($nx->config['debug']['db-queries']) && $nx->config['debug']['db-queries'] && isset($nx->db)) {
      $this->session->SetFlash('database_queries', $this->db->GetQueries());
    }    
    if(isset($nx->config['debug']['timer']) && $nx->config['debug']['timer']) {
	    $this->session->SetFlash('timer', $nx->timer);
    }    
    $this->session->StoreInSession();
    header('Location: ' . $this->request->CreateUrl($url));
  }


}
  