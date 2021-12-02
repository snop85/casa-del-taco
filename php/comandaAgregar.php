<?php  
// incluye conexion
require("conexion.php");

$fecha = date('Y-m-d');
$hora     = date("H:i:s");


// Verifico que haya llegado el Servicio
if (isset($_POST['servicio']) && 

	isset($_POST['mesa']))

{
	// El Servicio lo debe tomar del POST
	$servicio = $_POST['servicio'];	

	$mesa     = $_POST['mesa'];		

	// Verifico si no llegó el boton de Cancelar
	if (!isset($_POST["nBtnEliminar"]) && 
		!isset($_POST["nBtnCancelar"]))
	{	
    	// ----------------------------
    	// Agregar Comandas al Servicio
    	// ----------------------------

		// Arreglo para lo que se va a grabar
		$lstProd = [];		
		$lstPrec = [];
		$lstCant = [];
		$lstCome = [];

		// Filtra los datos que si se graba
		foreach ($_POST as $key => $value) 
		{
			if (!($key=="servicio" || $key=="mesa"))
			{
				
				// Verifica si es un precio
				if (strstr($key, "precio")!="")
				{	
				   // Obtiene el Producto	
				   $producto  = substr($key,6);		

				   // lo agrega el Arreglo de Productos
				   array_push($lstProd, $producto);
				   
				   // lo agrega el Arreglo de Precio
				   array_push($lstPrec, $value);

                }
				elseif (strstr($key, "cantidad")!="")
				{
				    // lo agrega a cantidad
				    array_push($lstCant, $value);	
				}
				else
                {
					// lo agrega al Arreglo de Comentarios
				    array_push($lstCome, $value);	
                }  
			}		
		}

	    // ----------------------
		// Ciclo para insertar

		// Se inicia transacción
		$conexion->autocommit(FALSE);

		// Prepara el Query para obtener el Servicio 
		$query  = " SELECT MAX(numero)+1 AS consecutivo";
	    $query .= " FROM   comandas ";
	    $query .= " WHERE  DATE(fecha) = CURDATE()";

	    // Ejecuta el Query
		$Registros = $conexion->query($query);

		// Verifica que los haya obtenido
		if (!$Registros)
		{        
			// Cancela la Transacción
		    $conexion->rollback();
		    
	        // Variables para el Error
		    $titulo      = "Error al Obtener el Consecutivo de Comanda";
		    $descripcion = "[".$query."]".$conexion->error;
		    $enlace      = "atencion.php";
	        

		    // Presenta ventana de Error
			header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}   
		else
		{
			// Obtengo el Registro		
		    $row = $Registros->fetch_assoc();

			// obtiene la Comanda
			$comanda = $row['consecutivo'];

			// Verifica si es null
			if (is_null($comanda))
				
				// Le coloca el valor de 1
	            $comanda = "1";

	        // Variable de Error
	        $bHuboError = False;

	        // Ciclo para insertar cada uno de los Productos
	        for ($i = 0; $i < count($lstProd); $i++) 
	        {
	        	// Verifica que la cantidad se mayor que 0
	        	if ($lstCant[$i] > 0)
	        	{
	        		// Pasamos a variables
	        		$producto   = $lstProd[$i];
	        		$cantidad   = $lstCant[$i];
	        		$precio     = $lstPrec[$i];
	        		$comentario = $lstCome[$i];

	        		// Preparamos el Query de Inserción a Servicios
					$query  = " INSERT INTO comandas ";
					$query .= " (`servicio`, `fecha`, `hora`, `numero`, `producto`, `cantidad`, `precio`, `comentario`) ";
					$query .= " VALUES ('$servicio','$fecha','$hora','$comanda','$producto','$cantidad','$precio','$comentario')";


					// Ejecuta Query y obtiene Registros
					$registros = $conexion->query($query);

					if (!$registros)
					{ 			    
						// Cancela la Transacción
					    $conexion->rollback();
					    		       
					    // Activa Bandera de Error
				        $bHuboError = True;
				        
				        // Sale del Ciclo
				        break;
					}
	        	}	        	   						
	        }		
	        // Verifica si hubo error al Final de Ciclo
	        if ($bHuboError)
	        {
	        	// Variables para el Error
	 		    $titulo      = "Error en Alta de Servicio hi";
				$descripcion = "[".$query."]".$conexion->error;
				$enlace      = "atencion.php";
				
	            // Presenta ventana de Error
		        header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");   	       
	        }
	        else
	        {
	        	// Confirma transacción
			    if (!$conexion->commit()) 
			    {
			        // RollBack     
				    $conexion->rollback();

				    // Variables para el Error
		            $titulo      = "Error al Confirmar Transacción";
		            $descripcion = "[".$query."]".$conexion->error;
		            $enlace      = "atencion.php";

		            // Presenta ventana de Error
			        header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
			    }
			    else
			    {			    	
			    	// Variables para el exito
	        		$titulo      = "Exito Alta Servicio";
	        		$descripcion = "Se ha realizado con exito el Alta del Servicio y Comandas";
	        		$enlace      = "atencion.php";

	        		// Lanzando Aplicación por Tipo
	        		header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
			    }
	        }
		}
	    
	}
	elseif (isset($_POST["nBtnEliminar"]))
	{
        // Baja del Servicio

        // Se inicia transacción
		$conexion->autocommit(FALSE);

		// Preparamos el Query de Inserción a Servicios
		$query  = " DELETE FROM servicios ";
		$query .= " WHERE  numero = $servicio";
		$query .= " AND    fecha  = CURDATE()";

		// Ejecuta Query y obtiene Registros
		$registros = $conexion->query($query);

		if (!$registros)
		{ 			    
			// Cancela la Transacción
		    $conexion->rollback();

		    // Variables para el Error
 		    $titulo      = "Error en Cancelación de Servicio";
			$descripcion = "[".$query."]".$conexion->error;
			$enlace      = "atencion.php";
				
            // Presenta ventana de Error
	        header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
		}
		else
		{

			// Preparamos el Query para Actualizar la Mesa
			$query  = " UPDATE mesas ";
			$query .= " SET    mesero = NULL";
			$query .= " WHERE  numero = $mesa";

			// Ejecuta Query y obtiene Registros
			$registros = $conexion->query($query);

			if (!$registros)
			{ 			    
				// Cancela la Transacción
			    $conexion->rollback();

			    // Variables para el Error
	 		    $titulo      = "Error en Actualización de Mesa";
				$descripcion = "[".$query."]".$conexion->error;
				$enlace      = "atencion.php";
					
	            // Presenta ventana de Error
		        header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
			}
			else
			{
				// Confirma transacción
			    if (!$conexion->commit()) 
			    {
			        // RollBack     
				    $conexion->rollback();

				    // Variables para el Error
		            $titulo      = "Error al Confirmar Transacción de Cancelación de Servicio";
		            $descripcion = "[".$query."]".$conexion->error;
		            $enlace      = "atencion.php";

		            // Presenta ventana de Error
			        header("Location: ../error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
			    }
			    else
			    {
			    	// Variables para el exito
	        		$titulo      = "Exito Alta de Servicio";
	        		$descripcion = "Se ha realizado con exito la Cancelación del Servicio";
	        		$enlace      = "atencion.php";

	        		// Lanzando Aplicación por Tipo
	        		header("Location: ../exito.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
			    }
			}
		}		
	}
	else
	{
		// Cancelación de las Comandas, no se hace nada
        header("Location: ../atencion.php");			
	}
}
else
{
	// Despliega mensaje de Error
   	die ("Error en Alta de Comandas:<br>Faltaron datos");	
}
?>
