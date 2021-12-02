<?php  
// -----------------------------------------------------
// comentarioBaja.php
// Baja de un Comentario
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['numeroOculto']))
{
	// Obtiene los datos
	$numero = $_POST['numeroOculto'];

	// Prepara el Query para la Modificación
	$query  = " DELETE FROM comentarios";
	$query .= " WHERE numero='$numero'";
	
	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

    // Verifica
	if (!$registros)
	{   
	    // Devuelve el Error encontrado 
	    $titulo      = "Error en Baja de Comentario";
	    $descripcion = $conexion->error;
	    $descripcion = "[".$query."]".$conexion->error;

	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}   
	else
	{   
		//echo $conexion->mysql_affected_rows();
		if (mysqli_affected_rows($conexion)>0)
		{
			// Se han realizado los cambios al Usuario
        	$titulo      = "Exito Baja Comentario";
        	$descripcion = "Se ha realizado con exito la Baja de: $numero";
        	$enlace      = "comentarios.php";

        	// Lanzando Aplicación por Tipo
        	header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
		else
		{
			// Devuelve el Error encontrado 
	    	$titulo      = "Error en Baja de Comentario";
	    	$descripcion = "No se realizó la Baja del Comentario porque ya no existe";
	    	$enlace      = "clases.php";
	    	
	    	// Presenta ventana de Error
			header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
	    
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Baja de Clase:<br>Faltaron datos");	
}

