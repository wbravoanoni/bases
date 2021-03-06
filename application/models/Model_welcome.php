<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_welcome extends CI_Model {

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

	public function getInmobiliariaModel()
	{
		$this->db->select('idInmobiliaria,nombre');
		$this->db->from('zz_glead_inmobiliaria');
		$this->db->where("estado",1);
		$r=$this->db->get();
		return $r->result();
	}

		public function getProyectosModel($idInmobiliaria)
	{
		$this->db->select('idProyecto,nombreM');
		$this->db->from('zz_glead_proyectos');
		$this->db->where("idInmobiliaria",$idInmobiliaria);
		$this->db->where("estado",1);
		$r=$this->db->get();
		return $r->result();
	}

		public function getCatModel($idInmo,$idProy,$fInicio,$fFinal)
	{

		$query=$this->db->query('	
		SELECT idRepuesta,idPuente,idRespuestaEncuesta,
		idInmobiliaria,idProyecto,idUser,idPais,fechaPuntos
		FROM zz_glead_respuestas 
		WHERE idInmobiliaria='.$idInmo.' 
		AND idProyecto IN ('.$idProy.')
		AND fechaPuntos BETWEEN "'.$fInicio.'" AND "'.$fFinal.'"
		LIMIT 10'
		);

		return $query;
	}

	public function getCatModelFull($idInmo,$idProy,$fInicio,$fFinal){

		if($fInicio==$fFinal){
			$filtroFecha=' AND a.fechaPuntos like "'.$fInicio.'%" ';
		}else{
			$filtroFecha=' AND a.fechaPuntos >="'.$fInicio.'" AND a.fechaPuntos <="'.$fFinal.'" ';
		}

$query=$this->db->query('

						SELECT a.idRepuesta,d.nombre,b.nombreP as Proyecto,d.nombre as Inmobiliaria,
						date(a.fechaPuntos) as FechaPuntos, 
						CASE
						when a.Puntos BETWEEN 0 AND 25 then "0% - 25%" 
						when a.Puntos BETWEEN 25.1 AND 35 then "25% - 35%"
						when a.Puntos BETWEEN 35.1 AND 45 then "35% - 45%"
						when a.Puntos BETWEEN 45.1 AND 50 then "45% - 50%"
						when a.Puntos BETWEEN 50.1 AND 55 then "50% - 55%"
						when a.Puntos BETWEEN 55.1 AND 65 then "55% - 65%"
						when a.Puntos BETWEEN 65.1 AND 75 then "65% - 75%"
						when a.Puntos BETWEEN 75.1 AND 100 then "75% - 100%" 
						ELSE "null_Intervalo" END AS Intervalo,
						CONCAT(c.nombre," ",c.apellido) AS Cliente,  a.Correo, c.rut, a.donde,a.mejor
						FROM zz_glead_respuestas AS a
						LEFT JOIN zz_glead_proyectos as b on  a.idInmobiliaria = b.idInmobiliaria 
						AND a.idProyecto=b.idProyecto 
						left join zz_glead_datos_personas AS c ON a.Correo=c.mail AND 
						((c.idInmobiliaria = a.idInmobiliaria OR c.fechaIngreso = (SELECT MAX(z.fechaIngreso) 
															   FROM zz_glead_datos_personas z
															   WHERE z.mail=a.Correo)) OR c.idInmobiliaria = 0)
						LEFT JOIN zz_glead_inmobiliaria AS d  ON a.idInmobiliaria=d.idInmobiliaria
						LEFT JOIN app_user AS e ON a.idUser=e.idUser
						WHERE a.idInmobiliaria = '.$idInmo.'
						AND a.idProyecto IN ('.$idProy.')
						AND a.fechaPuntos NOT LIKE "%0000-00-00%"
						AND a.X1 NOT LIKE "%0%"
						AND a.prueba=0
						AND a.cancelada=0
						AND a.descarte=0
						AND b.estado = 1
					    '.$filtroFecha.'
						GROUP BY a.idRepuesta
						ORDER BY a.fechaPuntos ASC
						LIMIT 6000;');

								return $query;
	
	}

	public function getPromesas($idInmo,$idProy,$fInicio,$fFinal){

if($fInicio==$fFinal){
			$filtroFecha=' AND a.fechaGuardado like "'.$fInicio.'%" ';
		}else{
			$filtroFecha=' AND a.fechaGuardado >="'.$fInicio.'" AND a.fechaGuardado <="'.$fFinal.'" ';
		}




$query=$this->db->query("
					SELECT 
					a.idPromesaIn, e.nombre as Inmobiliaria,
					a.idInmobiliaria,a.idUser, concat(d.Nombre,' ',d.Apellido) as ejecutivo, a.email,b.nombre,
					b.rut,DATE_FORMAT(a.fechaPromesa,'%d-%m-%Y %k:%i:%s') as fechaPromesa,
					DATE_FORMAT(fechaGuardado,'%d-%m-%Y %k:%i:%s') as fechaGuardado ,
					a.idProyecto,c.nombreP, a.programa,a.donde
					FROM zz_glead_promesa as a
					left join zz_glead_vendedor_categoriza b on a.email=b.email
					LEFT JOIN zz_glead_proyectos c on a.idProyecto=c.idProyecto
					LEFT JOIN zz_glead_inmobiliaria e on a.idInmobiliaria=e.idInmobiliaria
					AND a.idInmobiliaria=c.idInmobiliaria
					LEFT JOIN app_user d on a.idUser=d.idUser
					AND a.idInmobiliaria=d.idempresa
					WHERE a.idInmobiliaria =".$idInmo."
					AND a.idProyecto IN (".$idProy.")
					AND c.estado=1
					".$filtroFecha."
					AND a.cancelada = 0
					AND a.prueba=0
					AND a.descarte=0
					GROUP BY idPromesaIn
					ORDER BY a.fechaPromesa ASC
					LIMIT 6000
					");

								return $query;
	}

		public function getCot($idInmo,$idProy,$fInicio,$fFinal){

if($fInicio==$fFinal){
			$filtroFecha=' AND a.fechaCotizacion = "'.$fInicio.'" ';
		}else{
			$filtroFecha=' AND a.fechaCotizacion >="'.$fInicio.'" AND a.fechaCotizacion <="'.$fFinal.'" ';
		}

$query=$this->db->query("
					SELECT a.idCategorizar, c.nombre as Inmobiliaria, a.idProyecto, b.nombreP as Proyecto, a.fechaCotizacion as FechaCotizacion,
					a.nombre as Cliente, a.rut, a.email, a.fono, a.idPortal, a.portal,a.dondeviene, a.programa,a.comentario
					from zz_glead_vendedor_categoriza AS a
					LEFT JOIN zz_glead_proyectos as b on a.idProyecto=b.idProyecto 
					AND a.idInmobiliaria=b.idInmobiliaria
					LEFT JOIN zz_glead_inmobiliaria as c  on a.idInmobiliaria=c.idInmobiliaria
					LEFT JOIN app_user as d ON a.idUser= d.idUser
					WHERE a.idInmobiliaria =".$idInmo."
					AND a.idProyecto IN (".$idProy.")
					and a.email not LIKE '%prueba'
					AND b.estado=1
					".$filtroFecha."
					AND a.prueba=0
					AND a.cancelada=0
					AND a.descarte=0
					AND b.idProyecto IS NOT NULL
					GROUP BY a.idCategorizar
					ORDER BY a.fechaCotizacion ASC
					LIMIT 6000");


							return $query;
	}

		public function getConsultas($idInmo,$idProy,$fInicio,$fFinal){

if($fInicio==$fFinal){
			$filtroFecha=' AND a.fecha like "'.$fInicio.'%" ';
		}else{
			$filtroFecha=' AND a.fecha >="'.$fInicio.'" AND a.fecha <="'.$fFinal.'" ';
		}

$query=$this->db->query("
			SELECT  
			a.idConsultas,a.idInmobiliaria,
			d.nombreMin as Inmobiliaria,
			date(a.fecha) as FechaConsulta, b.NombreM as Proyecto, 
			a.nombre as Cliente, a.email,a.fono, a.rut, a.donde,
			 a.estado, a.mensaje
			FROM zz_glead_vendedor_consulta as a
			LEFT JOIN zz_glead_proyectos as b on a.idProyecto=b.idProyecto
			LEFT JOIN app_user as c on a.idUser=c.idUser
			LEFT JOIN zz_glead_inmobiliaria as d  on a.idInmobiliaria=d.idInmobiliaria
			LEFT JOIN zz_glead_datos_personas as e on a.email=e.mail 
			AND ((e.idInmobiliaria = a.idInmobiliaria 
			OR e.fechaIngreso = (SELECT MAX(z.fechaIngreso) 
			FROM zz_glead_datos_personas z
			WHERE z.mail=a.email)) OR e.idInmobiliaria = 0)
			WHERE a.idInmobiliaria =".$idInmo."
			AND a.idProyecto IN (".$idProy.")
			and a.email not LIKE '%prueba%'
			AND a.prueba=0
			AND a.cancelada=0
			AND a.descarte=0
			".$filtroFecha."
			GROUP BY a.idConsultas
			ORDER BY a.fecha ASC
			LIMIT 6000
			");

				return $query;
	}


			public function getGestCot($idInmo,$idProy,$fInicio,$fFinal){

if($fInicio==$fFinal){
$filtroFecha='  AND a.fecha like "'.$fInicio.'%" 
 				AND b.fechaCotizacion like "'.$fInicio.'%" ';
}else{
$filtroFecha=' AND a.fecha >="'.$fInicio.'" 
			   AND a.fecha <="'.$fFinal.'"
			   AND b.fechaCotizacion >="'.$fInicio.'" 
			   AND b.fechaCotizacion <="'.$fFinal.'" ';
		}

$query=$this->db->query("
			SELECT
			a.idGestionProMaster,b.idCategorizar,
			e.nombre AS Inmobiliaria,
			concat(d.Nombre, ' ', d.Apellido) AS Ejecutivo,
			date(a.fecha) AS FechaGestion,b.fechacotizacion,
			DATEDIFF(a.fecha, b.fechaCotizacion) AS Dif,a.tipo,
			CASE 
			WHEN a.typeAction = 0 THEN 	'Gestiones'
			WHEN a.typeAction = 1 THEN 	'Agenda'
			WHEN a.typeAction = 2 THEN 	'Asignación'
			WHEN a.typeAction = 3 THEN 	'Referencia'
			WHEN a.typeAction = 4 THEN 	'Reserva'
			WHEN a.typeAction = 5 THEN 	'Categorización' 
			ELSE 	'Null' END AS TipoDeAccion,
			c.opcion,a.email,b.nombre AS Cliente,b.rut,
			b.fono,a.proyectos AS idProyectos,
			f.nombreP AS Proyecto,b.portal,
			b.dondeviene,a.comentario
			FROM zz_glead_gestion_pro_master AS a
			LEFT JOIN zz_glead_vendedor_categoriza AS b 
			ON b.idEmail_unico = a.idEmail_unico
			AND a.idInmobiliaria = b.idInmobiliaria
			LEFT JOIN zz_glead_gestion_pro_opcion c 
			ON c.idOpcion = a.idOpcion
			AND (c.catCotCon = 0 OR c.catCotCon = a.tipo)
			AND a.idOpcion = c.idOpcion
			LEFT JOIN zz_glead_inmobiliaria AS e 
			ON a.idInmobiliaria = e.idInmobiliaria 
			LEFT JOIN zz_glead_proyectos AS f 
			ON a.idInmobiliaria = f.idInmobiliaria
			AND a.proyectos = f.idProyecto
			LEFT JOIN app_user AS d ON a.idUser = d.idUser
			WHERE a.idInmobiliaria =".$idInmo."
			AND f.estado = 1 
			".$filtroFecha."
			AND a.prueba = 0
			AND a.descarte = 0
			AND a.cancelada = 0
			AND b.prueba = 0
			AND b.descarte = 0
			AND b.cancelada = 0
			AND a.fecha >= b.fechaCotizacion 
			GROUP BY a.idGestionProMaster
			ORDER BY a.idInmobiliaria ASC
			LIMIT 6000;
");

				return $query;
	}


				public function getGestCat($idInmo,$idProy,$fInicio,$fFinal){

if($fInicio==$fFinal){
$filtroFecha='  AND a.fecha like "'.$fInicio.'%" 
 				AND b.fechaPuntos like "'.$fInicio.'%" ';
}else{
$filtroFecha=' AND a.fecha >="'.$fInicio.'" 
			   AND a.fecha <="'.$fFinal.'"
			   AND b.fechaPuntos >="'.$fInicio.'" 
			   AND b.fechaPuntos <="'.$fFinal.'" ';
		}

$query=$this->db->query("
			
				SELECT 
				a.idGestionProMaster,b.idRepuesta,
				e.nombre as Inmobiliaria,a.tipo,
				concat(i.Nombre, ' ', i.Apellido) AS Ejecutivo,
				CASE
				WHEN a.typeAction = 0 THEN 'Gestiones'
				WHEN a.typeAction = 1 THEN 'Agenda'
				WHEN a.typeAction = 2 THEN 'Asignación'
				WHEN a.typeAction = 3 THEN 'Referencia'
				WHEN a.typeAction = 4 THEN 'Reserva'
				WHEN a.typeAction = 5 THEN 'Categorización' 
				ELSE 'Null' END as TipoDeAccion,
				a.idOpcion,c.opcion,a.email,
				concat(h.nombre, ' ', h.apellido) AS Cliente,
				h.rut,
				date(a.fecha) as FechaGestion,
				date(b.fechaPuntos) as fechapuntos,
				DATEDIFF(a.fecha, b.fechaPuntos) AS Dif,
				CASE
				WHEN b.puntos BETWEEN 0 AND 25 THEN	'0% - 25%'
				WHEN b.puntos BETWEEN 25.1 AND 35 THEN 	'25% - 35%'
				WHEN b.puntos BETWEEN 35.1 AND 45 THEN 	'35% - 45%'
				WHEN b.puntos BETWEEN 45.1 AND 50 THEN 	'45% - 50%'
				WHEN b.puntos BETWEEN 50.1 AND 55 THEN 	'50% - 55%'
				WHEN b.puntos BETWEEN 55.1 AND 65 THEN 	'55% - 65%'
				WHEN b.puntos BETWEEN 65.1 AND 75 THEN 	'65% - 75%'
				WHEN b.puntos BETWEEN 75.1 AND 100 THEN '75% - 100%'
				ELSE 'null_Intervalo' END AS Intervalo,
				f.nombreP AS Proyecto,b.donde,a.principal,
				g.portal, g.dondeviene,j.donde AS Consulta,
				g.programa,a.comentario
				FROM  zz_glead_gestion_pro_master  AS a
				LEFT JOIN zz_glead_respuestas AS b 
				ON a.idEmail_unico=b.idEmail_unico
				AND a.idInmobiliaria=b.idInmobiliaria
				LEFT JOIN zz_glead_gestion_pro_opcion c 
				ON c.idOpcion = a.idOpcion 
				AND (c.catCotCon = 0 OR c.catCotCon = a.tipo)
				AND a.idOpcion=c.idOpcion
				LEFT JOIN zz_glead_inmobiliaria AS e  
				ON a.idInmobiliaria=e.idInmobiliaria
				LEFT JOIN zz_glead_proyectos  AS f 
				ON a.idInmobiliaria = f.idInmobiliaria 
				AND a.proyectos = f.idProyecto 
				LEFT JOIN zz_glead_datos_personas h 
				ON a.idEmail_unico = h.idEmail_unico
				AND ((h.idInmobiliaria = a.idInmobiliaria 
				OR h.fechaIngreso = ( SELECT MAX(z.fechaIngreso) 
				FROM zz_glead_datos_personas z
				WHERE z.mail = a.email )) OR h.idInmobiliaria = 0)
				LEFT JOIN zz_glead_vendedor_categoriza AS g 
				ON a.idEmail_unico=g.idEmail_unico
				AND a.idInmobiliaria=g.idInmobiliaria
				LEFT JOIN app_user i ON a.idUser = i.idUser
				AND a.idInmobiliaria = i.idempresa
				LEFT JOIN zz_glead_vendedor_consulta AS j ON a.idEmail_unico=j.idEmail_unico
				AND a.idInmobiliaria=j.idInmobiliaria
				WHERE a.idInmobiliaria =".$idInmo."
				AND a.cancelada = 0
				AND f.estado = 1 
				AND b.cancelada = 0
				AND a.prueba = 0
				AND b.prueba = 0
				AND a.descarte = 0
				AND b.descarte = 0
				AND a.fecha > b.fechaPuntos 
				".$filtroFecha."
				GROUP BY a.idGestionProMaster
				ORDER BY a.idinmobiliaria ASC
				LIMIT 6000;
");

				return $query;
	}


}
