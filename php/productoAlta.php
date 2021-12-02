<?php  
// -----------------------------------------------------
// productoAlta.php
// Alta de un producto
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['codigoABC']) &&
    isset($_POST['nombreABC'])  &&
    isset($_POST['precioABC']) &&
    isset($_POST['claseABC']))
{
	// Obtiene los datos
	$codigo = $_POST['codigoABC'];
	$nombre = $_POST['nombreABC'];
	$precio = $_POST['precioABC'];
	$clase  = $_POST['claseABC'];

	// Prepara el Query para la Inserción
	$query  = " INSERT INTO productos ";
	$query .= " (codigo, nombre, precio, clase)";
	$query .= " VALUES ";
	$query .= " ('$codigo','$nombre','$precio.','$clase')";


	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

    // Verifica
	if (!$registros)
	{   
	    // Variables para el Error
	    $titulo      = "Error en Alta de Producto";
	    $descripcion = "[".$query."]".$conexion->error;
	    $enlace      = "productos.php";

	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}   
	else
	{   
	    // Variables para el mensaje de Exito
        $titulo      = "Exito Alta Usuario";
        $descripcion = "Se ha realizado con exito el Alta de: $codigo";
        $enlace      = "productos.php";

        // Lanzando Aplicación por Tipo
        header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Alta de Producto:<br>Faltaron datos");	
}