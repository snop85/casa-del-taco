<?php  
// -------------------------------------------
// Funciones para Control de la Base de Datos
// baseDatos.php
// -------------------------------------------

// requiere la conexion
require("php/conexion.php");

// Funcion para obtener datos de una tabla
function fnGetDatos($conexion, $tabla)
{
	// Preparamos el Query de Consulta 
	$query =  " SELECT *";
    $query .= " FROM   $tabla";
	
	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

	if (!$registros)
	{    
	    die ("Error: en Consulta de tabla $tabla:<br>".$conexion->error);
	}   

	// Devuelve los registros
	return $registros;
}

// Funcion para obtener las Mesas Libres
function fnGetMesasLibres($conexion)
{
	// Preparamos el Query de Consulta 
	$query =  " SELECT *";
    $query .= " FROM   mesas";
    $query .= " WHERE  mesero IS NULL";
	
	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

	if (!$registros)
	{    
	    die ("Error: en Consulta de Mesas Libres:<br>".$conexion->error);
	}   

	// Devuelve los registros
	return $registros;
}

// Funcion para obtener los Productos por Clase
function fnGetProductosPorClase($conexion,$clase)
{
	// Preparamos el Query de Consulta 
	$query =  " SELECT *";
    $query .= " FROM   productos";
    $query .= " WHERE  clase ='$clase'";
	
	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

	if (!$registros)
	{    
	    die ("Error: en Consulta de Productos por Clase:<br>".$conexion->error);
	}   

	// Devuelve los registros
	return $registros;
}

// Funcion para obtener los Comentarios por Clase
function fnGetComentariosPorClase($conexion,$clase)
{
	// Preparamos el Query de Consulta 
	$query =  " SELECT *";
    $query .= " FROM   comentarios";
    $query .= " WHERE  clase ='$clase'";
	
	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

	if (!$registros)
	{    
	    die ("Error: en Consulta de Comentarios por Clase:<br>".$conexion->error);
	}   

	// Devuelve los registros
	return $registros;
}

function fnGetMesasUsuario($conexion,$usuario)
{
    // Preparamos el Query de Consulta 
	$query =  " SELECT servicios.numero,
	servicios.mesa,
	servicios.total, 
	mesas.nombre

    FROM   servicios, 
	       mesas
    WHERE  servicios.total IS NULL
	AND    servicios.mesa = mesas.numero
    ";

	
	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

	if (!$registros)
	{    
	    die ("Error: en fnGetMesasUsuario<br>".$conexion->error);
	}   

	// Devuelve los registros
	return $registros;	
}

// Obtiene los servicios para Cobrar
function fnGetServicioCobrar($conexion,$usuario,$servicio)
{
    // Preparamos el Query de Consulta 
	$query = "SELECT producto, 
	productos.nombre,
	cantidad, 
	comandas.precio,
	comandas.precio * cantidad AS importe
FROM   servicios, comandas, productos
WHERE  servicios.numero = comandas.servicio
AND    productos.codigo = comandas.producto
AND    servicio = $servicio"; 



	
	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

	if (!$registros)
	{    
	    die ("Error: en fnGetServicioCobrar<br>".$conexion->error);
	}   

	// Devuelve los registros
	return $registros;	
}

// Obtiene los Productos De Cocina en Preparación
function fnGetProductosDeCocina($conexion)
{
    // Preparamos el Query de Consulta 
	$query = "SELECT *
              FROM   comandas,
                     productos
              WHERE  comandas.producto = productos.codigo
              AND    comandas.estado   = 'P'"; 

	
	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);
	

	if (!$registros)
	{    
	    die ("Error: en fnGetProductosDeCocina<br>".$conexion->error);
	}   

	// Devuelve los registros
	
	return $registros;	
}

// Obtiene los Productos De Barra en Preparación
function fnGetProductosDeBarra($conexion)
{
    // Preparamos el Query de Consulta 
	$query = "SELECT comandas.servicio,
	                 comandas.numero,
	                 comandas.producto,
                     productos.nombre,
                     comandas.cantidad

              FROM   comandas, 
                     productos,
		             servicios,
		             clases       
       
              WHERE  comandas.producto = productos.codigo
              AND    comandas.servicio = servicios.numero
              AND    comandas.fecha    = servicios.fecha
              AND    productos.clase   = clases.nombre
              AND    clases.tipo       = 'barra'
              AND    comandas.estado   = 'P'
              AND    DATE(comandas.fecha) = CURDATE()"; 

	
	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

	if (!$registros)
	{    
	    die ("Error: en fnGetProductosDeBarra<br>".$conexion->error);
	}   

	// Devuelve los registros
	return $registros;	
}

// Obtiene los Productos a Entregar
function fnGetProductosAEntregar($conexion,$usuario)
{
    // Preparamos el Query de Consulta 



	$query = "SELECT comandas.servicio,
	servicios.numero,
	comandas.numero,
	servicios.mesa, 
	comandas.producto,
	productos.codigo,
	productos.nombre,
	comandas.cantidad,
	comandas.comentario

	FROM    comandas, 
            productos,
		    servicios
					   
		   
	WHERE  comandas.servicio = servicios.numero
	AND    comandas.producto = productos.codigo
	AND    comandas.estado   = 'E'
	AND    servicios.mesero = '$usuario'";

			  
	
	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

	if (!$registros)
	{    
	    die ("Error: en fnGetProductosAEntregar<br>".$conexion->error);
	}   

	// Devuelve los registros
	return $registros;	
}

// Obtiene la Venta del Dia
function fnGetVentaDia($conexion,$usuario)
{
    // Preparamos el Query de Consulta 
	$query = "SELECT *
              FROM   servicios              
              WHERE  DATE(fecha) = CURDATE()";
	
	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

	if (!$registros)
	{    
	    die ("Error: en fnGetVentaDia<br>".$conexion->error);
	}   

	// Devuelve los registros
	return $registros;	
}

// Obtiene Información de un Servicio
function fnGetServicio($conexion,$servicio)
{
    // Preparamos el Query de Consulta 
	$query = "SELECT *
              FROM   comandas              
              WHERE  servicio = $servicio
              ";
	
	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

	if (!$registros)
	{    
	    die ("Error: en fnGetServicio<br>".$conexion->error);
	}   

	// Devuelve los registros
	return $registros;	
}