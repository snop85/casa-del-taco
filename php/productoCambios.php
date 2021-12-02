<?php  
// -----------------------------------------------------
// productoCambios.php
// Cambios en los datos de un producto
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['codigoOculto']) &&
    isset($_POST['nombreABC'])  &&
    isset($_POST['precioABC']) &&
    isset($_POST['claseABC']))
{
	// Obtiene los datos
	$codigo  = $_POST['codigoOculto'];
	$nombre  = $_POST['nombreABC'];
	$precio  = $_POST['precioABC'];
	$clase   = $_POST['claseABC'];

	// Prepara el Query para la Modificación
	$query  = " UPDATE productos SET";
	$query .= " nombre  = '$nombre',";
	$query .= " precio  = $precio,";
	$query .= " clase   = '$clase' ";
	$query .= " WHERE codigo='$codigo'";
	

	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

    // Verifica
	if (!$registros)
	{   
	    // Devuelve el Error encontrado 
	    $titulo      = "Error en Cambios de Producto";
	    $descripcion = "[".$query."]".$conexion->error;
	    $enlace      = "productos.php";

	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}   
	else
	{   
		//echo $conexion->mysql_affected_rows();
		if (mysqli_affected_rows($conexion)>0)
		{
			// Se han realizado los cambios al Usuario
        	$titulo      = "Exito Cambios Producto";
        	$descripcion = "Se ha realizado con exito los Cambios de: $codigo";
        	$enlace      = "productos.php";

        	// Lanzando Aplicación por Tipo
        	header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
		else
		{
			// Devuelve el Error encontrado 
	    	$titulo      = "Error en Cambios de Producto";
	    	$descripcion = "No se realizaron cambios al Producto porque no modificaste datos o ya no existe";
	    	$enlace      = "productos.php";
	    	
	    	// Presenta ventana de Error
			header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
	    
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Cambios de Producto:<br>Faltaron datos");	
}

