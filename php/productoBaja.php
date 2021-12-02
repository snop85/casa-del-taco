<?php  
// -----------------------------------------------------
// productoBaja.php
// Baja de un producto
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['codigoOculto']))
{
	// Obtiene los datos
	$codigo = $_POST['codigoOculto'];

	// Prepara el Query para la Modificación
	$query  = " DELETE FROM productos";
	$query .= " WHERE codigo='$codigo'";
	

	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

    // Verifica
	if (!$registros)
	{   
	    // Devuelve el Error encontrado 
	    $titulo      = "Error en Baja de Producto";
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
        	$titulo      = "Exito Baja Producto";
        	$descripcion = "Se ha realizado con exito la Baja de: $codigo";
        	$enlace      = "productos.php";

        	// Lanzando Aplicación por Tipo
        	header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
		else
		{
			// Devuelve el Error encontrado 
	    	$titulo      = "Error en Baja de Producto";
	    	$descripcion = "No se realizó la Baja del Producto porque ya no existe";
	    	$enlace      = "productos.php";
	    	
	    	// Presenta ventana de Error
			header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
	    
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Baja de Producto:<br>Faltaron datos");	
}

