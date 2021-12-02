<?php  
// -----------------------------------------------------
// comentarioAlta.php
// Alta de Comentario
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['numeroABC']) &&
    isset($_POST['claseABC']) &&
    isset($_POST['descripcionABC']))
{
	// Obtiene los datos
	$numero      = $_POST['numeroABC'];
	$clase       = $_POST['claseABC'];
	$descripcion = $_POST['descripcionABC'];

	// Prepara el Query para la Inserción
	$query  = " INSERT INTO comentarios ";
	$query .= " (numero, clase, descripcion)";
	$query .= " VALUES ";
	$query .= " ('$numero','$clase','$descripcion')";

	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

    // Verifica
	if (!$registros)
	{   
	    // Variables para el Error
	    $titulo      = "Error en Alta de Comentario";
	    $descripcion = "[".$query."]".$conexion->error;
	    $enlace      = "comentarios.php";

	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}   
	else
	{   	    	    
	    // Variables para el error
        $titulo      = "Exito Alta Comentarios";
        $descripcion = "Se ha realizado con exito el Alta de: $numero";
        $enlace      = "comentarios.php";

        // Lanzando Aplicación por Tipo
        header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Alta de Comentario:<br>Faltaron datos");	
}
?>
