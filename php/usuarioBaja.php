<?php  
// -----------------------------------------------------
// usuarioBaja.php
// baja de un usuario
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['codigoOculto']))
{
	// Obtiene los datos
	$codigo = $_POST['codigoOculto'];

	// Prepara el Query para la Modificación
	$query  = " DELETE FROM usuarios";
	$query .= " WHERE codigo='$codigo'";
	

	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

    // Verifica
	if (!$registros)
	{   
	    // Devuelve el Error encontrado 
	    $titulo      = "Error en Baja de Usuario";
	    $descripcion = "[".$query."]".$conexion->error;
	    $enlace      = "usuarios.php";

	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}   
	else
	{   
		//echo $conexion->mysql_affected_rows();
		if (mysqli_affected_rows($conexion)>0)
		{
			// Se han realizado los cambios al Usuario
        	$titulo      = "Exito Baja Usuario";
        	$descripcion = "Se ha realizado con exito la Baja de: $codigo";
        	$enlace      = "usuarios.php";

        	// Lanzando Aplicación por Tipo
        	header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
		else
		{
			// Devuelve el Error encontrado 
	    	$titulo      = "Error en Baja de Usuario";
	    	$descripcion = "No se realizó la Baja del Usuario porque ya no existe";
	    	$enlace      = "usuarios.php";
	    	
	    	// Presenta ventana de Error
			header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
	    
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Baja de Usuario:<br>Faltaron datos");	
}

