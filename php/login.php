<?php  
// Inicia o Activa Sesion
session_start();

// requiere la conexion
require("conexion.php");

// Verifica que haya recibido los datos
if (isset($_POST["codigo"]) && isset($_POST["clave"]))
{
	// crea las variables para la conexion
	$codigo = $_POST["codigo"];
	$clave  = $_POST["clave"];

	// Preparamos el Query de Consulta a Usuarios
	$query  = " SELECT * FROM usuarios ";
	$query .= " WHERE  codigo = '".$codigo."'";
	$query .= " AND    clave  = '".$clave."'";


	// Ejecuta Query y obtiene Registros
	$registros = $conexion->query($query);

    // Verifica que no haya habido error en Consulta
	if (!$registros)
	{    
		echo "<h1>Comandas 2021</h1>";
		die ("Error en Consulta de Usuarios:<br>".$conexion->error);
	}   

	// Verifica si hubo resultados
	if ($registros->num_rows<=0)
	{
	    //echo "Error en Usuario y Clave <br>";
	    //echo "<META HTTP-EQUIV='REFRESH' CONTENT='2;URL=index.php'>";
		
	    // Variables para el Mensaje de error
		$titulo      = "Error de Acceso";
		$descripcion = "El Usuario y Clave no son Correctos";
		$enlace      = "index.php";
	    // Presenta ventana de Error
		header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");	    	    	    

	}
	else
	{	    
	    // Obtiene el Registro
		$row = $registros->fetch_assoc();

	    // Obtiene el usuario y tipo
		$usuario = $row['nombre'];
		$tipo    = $row['tipo'];

	    // Crea los objetos para la sesión
		$_SESSION['codigo']  = $codigo;
		$_SESSION['usuario'] = $usuario;
		$_SESSION['tipo']    = $tipo;
		
	    // Lanzando Aplicación por Tipo
		header("Location: ../$tipo.php");	    	    	    
	}   
}
else
{
	// Despliega el Mensaje de Error
	echo "<h1>Comandas 2021</h1>";
	echo "<h2>Error al Ingresar</h2>";
	echo "<p>No se proporcionaron los datos de acceso</p>";
	die ("El Programa se ha detenido");
}

?>
