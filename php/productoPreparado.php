<?php  
// -----------------------------------------------------
// productoPreparado.php
// Registro de un Producto que se ha Preparado en Cocina
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
	            SET    comandas.estado ='E'
				WHERE  servicio = $servicio
				AND    numero   = $comanda
				AND    producto ='$producto'";

	// Ejecuta el Query
	$registros = $conexion->query($query);

	// Verifica que los haya obtenido
	if (!$registros)
	{        
		// Variables para el Error
	    $titulo      = "Error en productoPreparado";
	    $descripcion = "[".$query."]".$conexion->error;
	    $enlace      = "cocina.php";

	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
    }
	else
	{
      	// Variables para el exito
   		$titulo      = "Exito Preparación de Producto";
   		$descripcion = "Se ha actualizado con Éxito el Status del Producto";
   		$enlace      = "cocina.php";

   		// Lanzando Aplicación por Tipo
   		header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");	
	}
}
else
{
	// Imprime el GET
	print_r($_GET);
	echo "<br><br>";
   
    // Despliega mensaje de Error
   	die ("Error en productoPreparado:<br>Faltaron datos");	
}

?>