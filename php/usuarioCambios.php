<?php  
// -----------------------------------------------------
// usuarioCambios.php
// cambios en los datos de un usuario
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['codigoOculto']) &&
    isset($_POST['claveABC'])  &&
    isset($_POST['nombreABC']) &&
    isset($_POST['tipoABC']))
{
	// Obtiene los datos
	$codigo = $_POST['codigoOculto'];
	$clave  = $_POST['claveABC'];
	$nombre = $_POST['nombreABC'];
	$tipo   = $_POST['tipoABC'];

	// Prepara el Query para la Modificación
	$query  = " UPDATE usuarios SET";
	$query .= " clave  = '$clave' ,";
	$query .= " nombre = '$nombre',";
	$query .= " tipo   = '$tipo' ";
	$query .= " WHERE codigo='$codigo'";
	

	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

    // Verifica
	if (!$registros)
	{   
	    // Devuelve el Error encontrado 
	    $titulo      = "Error en Cambios de Usuario";
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
        	$titulo      = "Exito Cambios Usuario";
        	$descripcion = "Se ha realizado con exito los Cambios de: $codigo";
        	$enlace      = "usuarios.php";

        	// Lanzando Aplicación por Tipo
        	header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
		else
		{
			// Devuelve el Error encontrado 
	    	$titulo      = "Error en Cambios de Usuario";
	    	$descripcion = "No se realizaron cambios al Usuario porque no modificaste datos o ya no existe";
	    	$enlace      = "usuarios.php";
	    	
	    	// Presenta ventana de Error
			header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
	    
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Cambios de Usuario:<br>Faltaron datos");	
}

