<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');


	}
	/**
	 * crea un usuario con doctrine
	 * @return [type] [description]
	 */
	public function create()
	{
	    //creamos una instancia de la entidad User
	    $user = new Entities\User;

	    //establecemos las propiedades a través de los setters
	    $user->setUsername("pepe");
	    $user->setEmail("pepe@mail.com");
	    $user->setPassword("123456");

	    //guardamos la entidad en la tabla users
	    $this->doctrine->em->persist($user);
	    $this->doctrine->em->flush();
	    echo "Se ha creado el usuario con ID " . $user->getId() . "\n";
	}




}
