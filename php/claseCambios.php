<?php  
// -----------------------------------------------------
// claseCambios.php
// cambios en los datos de un usuario
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['numeroOculto']) &&
    isset($_POST['nombreABC']) &&
    isset($_POST['tipoABC']))
{
	// Obtiene los datos
	$numero = $_POST['numeroOculto'];
	$nombre = $_POST['nombreABC'];
	$tipo   = $_POST['tipoABC'];

	// Prepara el Query para la Modificación
	$query  = " UPDATE clases SET";
	$query .= " nombre = '$nombre',";
	$query .= " tipo   = '$tipo' ";
	$query .= " WHERE numero='$numero'";
	
	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

    // Verifica
	if (!$registros)
	{   
	    // Devuelve el Error encontrado 
	    $titulo      = "Error en Cambios de Clase";
	    $descripcion = "[".$query."]".$conexion->error;
	    $enlace      = "clases.php";

	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}   
	else
	{   
		//echo $conexion->mysql_affected_rows();
		if (mysqli_affected_rows($conexion)>0)
		{
			// Se han realizado los cambios al Usuario
        	$titulo      = "Exito Cambios Clase";
        	$descripcion = "Se ha realizado con exito los Cambios de: $codigo";
        	$enlace      = "clases.php";

        	// Lanzando Aplicación por Tipo
        	header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
		else
		{
			// Devuelve el Error encontrado 
	    	$titulo      = "Error en Cambios de Clase";
	    	$descripcion = "No se realizaron cambios a la Clase porque no modificaste datos o ya no existe";
	    	$enlace      = "clases.php";
	    	
	    	// Presenta ventana de Error
			header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
	    
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Cambios de Clase:<br>Faltaron datos");	
}
?>
