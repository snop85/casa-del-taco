<?php  
// -----------------------------------------------------
// productoEntregado.php
// Registro de Producto Entregado
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado datos
if (isset($_GET["servicio"]) &&
    isset($_GET["comanda"])  &&
    isset($_GET["producto"]))
{
	// Obtiene los datos
	$servicio = $_GET["servicio"];
	$comanda  = $_GET["comanda"];
	$producto = $_GET["producto"];

    // Prepara el Query para actualizar el Servicio
	$query  = " UPDATE comandas
				SET    comandas.estado ='F'
				WHERE  servicio = $servicio
				AND    numero   = $comanda
				AND    producto ='$producto'";

	// Ejecuta el Query
	$registros = $conexion->query($query);

	// Verifica que los haya obtenido
	if (!$registros)
	{        
		
		// Variables para el Error
	    $titulo      = "Error en productoEntregado";
	    $descripcion = "[".$query."]".$conexion->error;
	    $enlace      = "atencion.php";

	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
    }
	else
	{
    	// Variables para el exito
		$titulo      = "Exito Entrega de Productos";
		$descripcion = "Se ha actualizado con Éxito el Status de los Productos";
		$enlace      = "entregas.php";

		// Lanzando Aplicación por Tipo
		header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en productoEntregado:<br>Faltaron datos");	
}

?>