<?php
//header('Access-Control-Allow-Origin: *');

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
{
	parent::__construct();
	$this->load->model('Model_welcome');
	$this->load->helper('guarda_excel_helper');
	$this->load->library('Descarga');
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

					$idInmo  = $_POST["idInmo"];
					$idProy  = $_POST["idProy"];
					$tipo    = $_POST["idTipo"];
					$fInicio = $_POST["fIni"];
					$fFinal  = $_POST["fTer"];

				if($fInicio >  $fFinal){
						echo "fIni > fTer";
					exit;
				
				}else{
					//echo "fIni < fTer";
				}

				$data["idInmo"] = $idInmo;
				$data["idProy"] = $idProy;
				$data["idTipo"] = $tipo;
				$data["fIni"]   = $fInicio;
				$data["fTer"]   = $fFinal;

		$a = new Descarga(); 
		
	switch ($tipo) {


		case 1:
	//echo "***** Descarga de categorizados ***** <br>";
			$a->descargaCategorizados($idInmo,$idProy,$fInicio,$fFinal);
				break;
		case 2:
        //	echo "***** Descarga de Promesas ***** <br>";
        	descargaPromesa($idInmo,$idProy,$fInicio,$fFinal);
        		break;
        
        case 3:
        	//echo "***** Descarga de Cotizaciones ***** <br>";
        	descargaCotizaciones($idInmo,$idProy,$fInicio,$fFinal);
        		break;

		case 4:
			//	echo "***** Descarga de Consultas ***** <br>";
			$a->descargaConsultas($idInmo,$idProy,$fInicio,$fFinal);
		break;

		case 5:
			//	echo "***** Gestiones Cot ***** <br>";
			descargaGestionesCot($idInmo,$idProy,$fInicio,$fFinal);
		break;

		case 6:
			//	echo "***** Gestiones Cat ***** <br>";
			descargaGestionesCat($idInmo,$idProy,$fInicio,$fFinal);
		break;

		case 7:
			

			
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



	public function prueba(){

	descargaCategorizados();
	}

}
