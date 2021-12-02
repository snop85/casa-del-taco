<?php  
// -----------------------------------------------------
// usuarioAlta.php
// da de alta un usuario
// -----------------------------------------------------

// incluye conexion 
require("conexion.php");

// Verifica que hayan llegado los datos
if (isset($_POST['codigoABC']) &&
    isset($_POST['claveABC'])  &&
    isset($_POST['nombreABC']) &&
    isset($_POST['tipoABC']))
{
	// Obtiene los datos
	$codigo = $_POST['codigoABC'];
	$clave  = $_POST['claveABC'];
	$nombre = $_POST['nombreABC'];
	$tipo   = $_POST['tipoABC'];

	// Prepara el Query para la Inserción
	$query  = " INSERT INTO usuarios ";
	$query .= " (codigo, clave, nombre, tipo)";
	$query .= " VALUES ";
	$query .= " ('$codigo','$clave','$nombre.','$tipo')";


	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

    // Verifica
	if (!$registros)
	{   
	    // Devuelve el Error encontrado 
	    //die ("Error en Inserción :".$conexion->error);
	    // Variables para el Error
	    $titulo      = "Error en Alta de Usuario";
	    $descripcion = "[".$query."]".$conexion->error;
	    $enlace      = "usuarios.php";

	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}   
	else
	{   // Se ha insertado el Usuario	    
	    // echo "<META HTTP-EQUIV='REFRESH' CONTENT='3;URL=../usuarios.php?codigo=$codigo&usuario=$usuario&tipo=$tipo'>";
	    // echo "Se ha Insertado el Usuario ...<br>";
	    // echo "Serás direccionado a Usuarios ...";
	    // Variables para el error
        $titulo      = "Exito Alta Usuario";
        $descripcion = "Se ha realizado con exito el Alta de: $codigo";
        $enlace      = "usuarios.php";

        // Lanzando Aplicación por Tipo
        header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
	}
}
else
{
    // Despliega mensaje de Error
   	die ("Error en Alta de Usuario:<br>Faltaron datos");	
}

