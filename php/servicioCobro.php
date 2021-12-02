<?php  

// -----------------------------------------------------
// servicioCobro.php
// Cobro de un Servicio
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['servicio']) &&
	isset($_POST['mesa']) &&
    isset($_POST['total']))
{
	// Obtiene los datos
	$servicio = $_POST['servicio'];
	$mesa     = $_POST['mesa'];
	$total    = $_POST['total'];

	// Se inicia transacción
	$conexion->autocommit(FALSE);

	// Prepara el Query para actualizar el Servicio
	$query  = " UPDATE servicios";
    $query .= " SET    total       = $total";
    $query .= " WHERE  DATE(fecha) = CURDATE()";
    $query .= " AND    numero      = $servicio";

    // Ejecuta el Query
	$Registros = $conexion->query($query);

	// Verifica que los haya obtenido
	if (!$Registros)
	{        
		// Cancela la Transacción
	    $conexion->rollback();
	    
        // Variables para el Error
	    $titulo      = "Error al Actualizar Total del Servicio";
	    $descripcion = "[".$query."]".$conexion->error;
	    $enlace      = "atencion.php";
        
	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}   
	else
	{
		// Prepara el Query para actualizar la Mesa		
		$query  = " UPDATE mesas";
        $query .= " SET    mesero = NULL";
        $query .= " WHERE  numero = $mesa";

        // Ejecuta el Query        
	    $Registros = $conexion->query($query);

		// Verifica que los haya obtenido
		if (!$Registros)
		{
			// Cancela la Transacción
	    	$conexion->rollback();
	    
        	// Variables para el Error
	    	$titulo      = "Error al Actualizar Status de Mesa";
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
        		$titulo      = "Exito Cobro de Servicio";
        		$descripcion = "Se ha realizado con exito el Cobro del Servicio";
        		$enlace      = "atencion.php";

        		// Lanzando Aplicación por Tipo
        		header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		    }
        }
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Servicio Cobro:<br>Faltaron datos");	
}

?>