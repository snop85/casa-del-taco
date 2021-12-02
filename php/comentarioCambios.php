<?php  
// -----------------------------------------------------
// comentarioCambios.php
// Cambios en los datos de un Comentario
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['numeroOculto']) &&
    isset($_POST['claseABC']) &&
    isset($_POST['descripcionABC']))
{
	// Obtiene los datos
	$numero      = $_POST['numeroOculto'];
	$clase       = $_POST['claseABC'];
	$descripcion = $_POST['descripcionABC'];

	// Prepara el Query para la Modificación
	$query  = " UPDATE comentarios SET";
	$query .= " clase = '$clase',";
	$query .= " descripcion = '$descripcion' ";
	$query .= " WHERE numero='$numero'";
	
	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

    // Verifica
	if (!$registros)
	{   
	    // Devuelve el Error encontrado 
	    $titulo      = "Error en Cambios de Comentario";
	    $descripcion = "[".$query."]".$conexion->error;
	    $enlace      = "comentarios.php";

	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}   
	else
	{   
		//echo $conexion->mysql_affected_rows();
		if (mysqli_affected_rows($conexion)>0)
		{
			// Se han realizado los cambios al Usuario
        	$titulo      = "Exito Cambios Comentario";
        	$descripcion = "Se ha realizado con exito los Cambios de: $codigo";
        	$enlace      = "comentarios.php";

        	// Lanzando Aplicación por Tipo
        	header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
		else
		{
			// Devuelve el Error encontrado 
	    	$titulo      = "Error en Cambios de Comentario";
	    	$descripcion = "No se realizaron cambios al Comentario porque no modificaste datos o porque ya no existe";
	    	$enlace      = "clases.php";
	    	
	    	// Presenta ventana de Error
			header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}	    
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Cambios de Comentarios:<br>Faltaron datos");	
}

