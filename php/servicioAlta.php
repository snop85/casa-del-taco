<?php  
// -----------------------------------------------------
// servicioAlta.php
// Alta de un Servicio
// -----------------------------------------------------
// Inicia o Activa Sesion
session_start();

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['fecha']) &&
    isset($_POST['hora']) &&
    isset($_POST['mesa']) &&
	isset($_POST['comensales']))
{
	// Obtiene los datos
	$fecha       = $_POST['fecha'];
    $hora        = $_POST['hora'];
	$mesa        = $_POST['mesa'];
	$comensales  = $_POST['comensales'];
	$btnCancelar = $_POST['btnCancelar'];
	$mesero      = $_SESSION['codigo'];

	// Busca la posición del Corchete Cierre
	$posCorcheteCierre = strpos($mesa, "]");

	// Obtiene solo el numero
	$mesa =  substr($mesa, 1,$posCorcheteCierre-1);  

    // ---------------------
    // Se inicia transacción
	$conexion->autocommit(FALSE);

	// Prepara el Query para obtener el Servicio 
	$query  = " SELECT MAX(numero)+1 AS consecutivo";
    $query .= " FROM   servicios ";
    $query .= " WHERE  DATE(fecha) = fecha";

    // Ejecuta el Query
	$Registros = $conexion->query($query);

	// Verifica que los haya obtenido
	if (!$Registros)
	{        
		// Cancela la Transacción
	    $conexion->rollback();
	    
        // Variables para el Error
	    $titulo      = "Error al Obtener el Consecutivo de Servicio";
	    $descripcion = "[".$query."]".$conexion->error;
	    $enlace      = "atencion.php";
        

	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}   
	else
	{
		// Obtengo el Servicio		
	    $row = $Registros->fetch_assoc();

		// obtiene el Servicio
		$servicio = $row['consecutivo'];

		// Verifica si es null
		if (is_null($servicio))
			
			// Le coloca el valor de 1
            $servicio = "1";


		// Preparamos el Query de Inserción a Servicios
		$query  = " INSERT INTO servicios ";
		$query .= " (`numero`,`fecha`,`hora`,`mesa`, `mesero`, `comensales`) ";
		$query .= " VALUES ('$servicio','$fecha','$hora','$mesa','$mesero','$comensales')";

		// Ejecuta Query y obtiene Registros
		$Registros = $conexion->query($query);

		if (!$Registros)
		{        
			// Cancela la Transacción
		    $conexion->rollback();
		    
	        // Variables para el Error
		    $titulo      = "Error en Alta de Servicio hola hola!!!";
		    $descripcion = "[".$query."]".$conexion->error;
		    $enlace      = "atencion.php";
	        

		    // Presenta ventana de Error
			header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}   
		else
		{
		    // Preparando Query para Indicar el Mesero que atiende la Mesa
		    $query  = " UPDATE mesas SET ";
		    $query .= " mesero ='".$mesero."'";
		    $query .= " WHERE numero =".$mesa;

		    // Ejecuta Query y obtiene Registros
		    $Registros = $conexion->query($query);

		    if (!$Registros)
			{   
			    // RollBack     
				$conexion->rollback();

				// Variables para el Error
		        $titulo      = "Error en Actualización de Status de Mesa";
		        $descripcion = "[".$query."]".$conexion->error;
		        $enlace      = "atencion.php";

		        // Presenta ventana de Error
			    header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
			}   
			else
			{

			    // Confirma transacción
			    if (!$conexion->commit()) 
			    {
			        // RollBack     
				    $conexion->rollback();

				    // Variables para el Error
		            $titulo      = "Error al Confirmar Transacción";
		            $descripcion = "[".$query."]".$conexion->error;
		            $enlace      = "atencion.php";

		            // Presenta ventana de Error
			        header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
			    }
			    else
			    {
			    	// Variables para el exito
	        		//$titulo      = "Exito Alta Servicio";
	        		//$descripcion = "Se ha realizado con exito el Alta del Servicio";
	        		//$enlace      = "comandas.php?mesa=$mesa";

	        		// Lanzando Aplicación por Tipo
	        		header("Location: ../comandasAgregar.php?servicio=$servicio&mesa=$mesa&cancelar=$btnCancelar");	 	       	
			    }
		    }
		}
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Alta de Servicio:<br>Faltaron datos");	
}

