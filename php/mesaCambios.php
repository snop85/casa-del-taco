<?php  
// -----------------------------------------------------
// mesaBaja.php
// baja de una mesa
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['numeroOculto']) && isset($_POST['nombreABC']))
{
	// Obtiene el Numero de mesa y el Nombre
	$numero = $_POST['numeroOculto'];
	$nombre = $_POST['nombreABC'];

	// Prepara el Query para la Modificación
	$query  = " UPDATE mesas SET";
	$query .= " nombre = '$nombre'";
	$query .= " WHERE numero='$numero'";
	
	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

    // Verifica 
	if (!$registros)
	{   
	    // Devuelve el Error encontrado 
	    $titulo      = "Error en Baja de Mesa";
	    $descripcion = "[".$query."]".$conexion->error;
	    $enlace      = "mesas.php";

	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}   
	else
	{   
		//echo $conexion->mysql_affected_rows();
		if (mysqli_affected_rows($conexion)>0)
		{
			// Se han realizado los cambios al Usuario
        	$titulo      = "Exito Cambios Mesa";
        	$descripcion = "Se ha realizado con exito los Cambios de: $numero";
        	$enlace      = "mesas.php";

        	// Lanzando Aplicación por Tipo
        	header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
		else
		{
			// Devuelve el Error encontrado 
	    	$titulo      = "Error en Cambios de Mesa";
	    	$descripcion = "No se realizaron cambios a la Mesa no modificaste datos o porque ya no existe";
	    	$enlace      = "mesa.php";
	    	
	    	// Presenta ventana de Error
			header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
	    
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Cambios de Mesa:<br>Faltaron datos");	
}

