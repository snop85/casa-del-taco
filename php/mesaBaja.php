<?php  
// -----------------------------------------------------
// mesaBaja.php
// baja de una mesa
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['numeroOculto']))
{
	// Obtiene el Numero de mesa a dar de baja
	$numero = $_POST['numeroOculto'];

	// Prepara el Query para la Modificación
	$query  = " DELETE FROM mesas";
	$query .= " WHERE numero='$numero'";
	echo $query;

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
        	$titulo      = "Exito Baja Mesa";
        	$descripcion = "Se ha realizado con exito la Baja de: $numero";
        	$enlace      = "mesas.php";

        	// Lanzando Aplicación por Tipo
        	header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
		else
		{
			// Devuelve el Error encontrado 
	    	$titulo      = "Error en Baja de Mesa";
	    	$descripcion = "No se realizaró la Baja de la Mesa porque ya no existe";
	    	$enlace      = "mesa.php";
	    	
	    	// Presenta ventana de Error
			header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
	    
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Baja de Mesa:<br>Faltaron datos");	
}

