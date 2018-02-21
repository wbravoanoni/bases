<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
{
	parent::__construct();
	$this->load->model('Model_welcome');
}

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

	public function getInmobiliariaController()
	{
	echo json_encode($this->Model_welcome->getInmobiliariaModel());
	}

	public function getProyectosController()
	{
	$idInmobiliaria= $this->input->post('idInmobiliaria');
	echo json_encode($this->Model_welcome->getProyectosModel($idInmobiliaria));
	}

	public function descarga()
	{
		
		if($_POST){
			if(isset($_POST["idInmo"]) && isset($_POST["idProy"]) && isset($_POST["idTipo"]) && isset($_POST["fIni"]) && isset($_POST["fTer"])){

				if($_POST["fIni"]< $_POST["fTer"]){
					echo "fIni < fTer";
				}else{
					echo "fIni > fTer";
					exit;
				}

				$data["idInmo"] = $_POST["idInmo"];
				$data["idProy"] = $_POST["idProy"];
				$data["idTipo"] = $_POST["idTipo"];
				$data["fIni"]   = $_POST["fIni"];
				$data["fTer"]   = $_POST["fTer"];

	switch ($_POST["idTipo"]) {
		case 1:
			echo "***** Descarga de categorizados ***** <br>";
			//echo json_encode($this->Model_welcome->getCatModel($data));
			print_r($_POST);
				break;
		case 2:
        	echo "***** Descarga de Consultas ***** <br>";
        	print_r($_POST);
        		break;
        
        case 3:
        	echo "***** Descarga de Cotizaciones ***** <br>";
        	print_r($_POST);
        		break;			
				
		default:
			exit;
				break;
			}	


			}else{
				exit;
			}
		}else{
			exit;
		}
	
	}
}
