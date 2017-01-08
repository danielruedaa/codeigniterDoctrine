<?php

class Users extends CI_Controller {


	public function __construct()
	 {
			 parent::__construct();

				// $this->load->model('Postm'); //cago el modelo
				 $this->load->library('session'); //cargo session
	 }
	public function index()
	{

		$this->load->view('login.html');

	}
	/**
	 * crea un usuario con doctrine
	 * @return [type] [description]
	 */
	function create()
	{
	    //creamos una instancia de la entidad User
	    $user = new Entities\User;

	    //establecemos las propiedades a través de los setters
	    $user->setUsername("lisa");
	    $user->setEmail("lisa@mail.com");
	    $user->setPassword("123456");

	    //guardamos la entidad en la tabla users
	    $this->doctrine->em->persist($user);
	    $this->doctrine->em->flush();
	    echo "Se ha creado el usuario con ID " . $user->getId() . "\n";
	}

/**
 * [ver description]
 * @return [type] [description]
 * retorna todos los usuarios registrados
 */
	public function ver()
{
    //obtenemos y mostramos todos los usuarios con el método findAll disponible en todo repositorio
    $users = $this->doctrine->em->getRepository("Entities\\User")->findAll();
    if( ! empty($users))
    {
        foreach ($users as $user)
        {
            echo sprintf(
                "- %s, %s, %s, %s <br>",
                $user->getUsername(), $user->getPassword(), $user->getEmail(), $user->getCreated()->format("d/m/Y")
            );
        }
    }
    else
    {
        echo "No hay usuarios";
    }
}

/**
 * [find description]
 * @param  [type] $id [description]
 * @return [type]     [description]
 * retorna un usuario por parametro id
 */
public function find($id)
{
    //obtiene un usuario con el método find de otra forma.
    $user = $this->doctrine->em->find("Entities\\User", $id);
    if ($user === null)
    {
        echo "No existe el usuario.\n";
        exit();
    }

    echo sprintf(
        "- %s, %s, %s, %s <br>",
        $user->getUsername(), $user->getPassword(), $user->getEmail(), $user->getCreated()->format("d/m/Y")
    );
}

/**
 * @param $id
 * @param $username
 * @desc Actualiza un usuario
 */
public function update_user($id, $username)
{
    //obtenemos el usuario
    $user = $this->doctrine->em->getRepository("Entities\\User")->find($id);

    if ($user === null)
    {
        echo "No existe el usuario.\n";
        exit();
    }

    //seteamos su nombre y lo actualizamos
    $user->setUsername($username);
    $this->doctrine->em->flush();

    echo "<pre>";
    print_r($user);
}

/**
 * @param $id
 * @desc Obtenemos un usuario por su id con el método findOneBy por su id y si existe lo eliminamos
 */
public function remove($id)
{
    $user = $this->doctrine->em->getRepository("Entities\\User")->findOneBy(["id" => $id]);
    if ($user === null)
    {
        echo "No existe el usuario.\n";
        exit();
    }
    $this->doctrine->em->remove($user);
    $this->doctrine->em->flush();
}

    /**
     * @Entity(repositoryClass="Repositories\UserRepository")
     * @Table(name="users")
     */
    public function find_by_username()
    {
        $user = $this->doctrine->em->getRepository("Entities\\User")->findByUsername("pepe");
        echo sprintf(
            "- %s, %s, %s, %s <br>",
            $user->getUsername(), $user->getPassword(), $user->getEmail(), $user->getCreated()->format("d/m/Y")
        );
    }



}
