<?php
  // Inicia o Activa Sesion
  session_start();
  
  // Carga las Funciones de Base de Datos 
  include ("php/func_bd.php");

  // Verifico que si no hay una sesión abierta mande a error
  if (isset($_SESSION['codigo'])  && 
      isset($_SESSION['usuario']) &&
      isset($_SESSION['tipo'])    &&
      (isset($_GET['servicio']) &&
       isset($_GET['mesa'])     || 
       isset($_GET["servicio-mesa"])) )
  {
     // Obtiene los datos del usuario
     $codigo   = $_SESSION['codigo'];
     $usuario  = $_SESSION['usuario'];
     $tipo     = $_SESSION['tipo'];        
     
     // Verifica que el tipo sea atencion
     if ($tipo != "atencion")
     {
        // Variables para el error
        $titulo      = "Error Acceso";
        $descripcion = "Intento de Violación de Acceso de Usuario";
        $enlace      = "index.php";

        // Lanzando Aplicación por Tipo
        header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");

     }

     // Verifica si es servicio-mesas     
     if (isset($_GET["servicio-mesa"]))
     {
        // Convierte a arreglo
        $servicioMesa = $_GET["servicio-mesa"];
        $arrServMesa = explode("-", $servicioMesa);

        // Coloca el Servicio y Mesa
        $servicio = $arrServMesa[0];
        $mesa     = $arrServMesa[1];
        $cancelar = "nBtnCancelar";
     }
     else
     {
        $servicio = $_GET['servicio'];
        $mesa     = $_GET['mesa'];
        $cancelar = "nBtnEliminar";
     }

     // Verifico si es cobranza
     if (isset($_GET["proceso"]))
     {
        // Verificasi el proceso es cobrar
        if ($_GET["proceso"]=="cobrar")
        {
           // Lanzando el Cobro
           header("Location: cobrar.php?servicio=$servicio&mesa=$mesa");
        }
     }
  }
  else
  {
     // Variables para el error
     $titulo      = "Error Acceso";
     $descripcion = "Intento de Violación de Acceso";
     $enlace      = "index.php";

     // Lanzando Aplicación por Tipo
     header("Location: error.php?titulo=$titulo&descripcion=$descripcion&enlace=$enlace");
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Casa del taco</title>
  <!-- // Incluye bootstrap -->
  <?php include "bootstrap.html"; ?>
  <!-- // Incluimos las reglas de estilo de la aplicación--> 
  <link rel="stylesheet" type="text/css" href="css/comandas.css" media="screen" />

  <script LANGUAGE="JavaScript">
    
    function fnFormatFloat(amount, decimals) 
    {

      amount += ''; // por si pasan un numero en vez de un string
      amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

      decimals = decimals || 0; // por si la variable no fue fue pasada

      // si no es un numero o es igual a cero retorno el mismo cero
      if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

      // si es mayor o menor que cero retorno el valor formateado como numero
      amount = '' + amount.toFixed(decimals);

      var amount_parts = amount.split('.'),
      regexp = /(\d+)(\d{3})/;

      while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

      return amount_parts.join('.');
    }

    function fnCalculaTotales()
    {

      // Obtiene la referencia a todos los input
      var listaInputs = document.getElementsByTagName("input");
      
      // Valor de los input
      sumaProductos = 0;
      sumaImporte   = 0.00;

      // Ciclo para desplegar los datos
      for (let item of listaInputs) 
      {          
          if (Number.isInteger(parseInt(item.value)) &&
              item.name !='servicio' && item.name !="mesa" &&
              item.name.substring(0,6)!="precio") 
          {
             // Lo Convierte a Entero
             cantidad = parseInt(item.value);

             // Lo agrega a la Suma
             sumaProductos = sumaProductos + cantidad;               

             // Obtengo el Id del Precio
             idPrecio = "precio"+ item.name.substring(8);
             

             // Obtengo la referencia al Precio
             precioProducto = document.getElementById(idPrecio);
             
             // Obtiene el Precio
             precio = parseFloat(precioProducto.innerHTML);

             // Calcula el Importe
             sumaImporte = sumaImporte + cantidad * precio;
          }          
      }      

      // Despliega la Suma
      total = document.getElementById("idTotal");
      total.innerHTML = "Totales-> Productos: <strong>"+sumaProductos+"</strong> Importe: <strong>"+fnFormatFloat(sumaImporte,2)+"</strong>";
    }

    // Valida que haya capturado por lo menos un dato
    function fnValida(event)
    {  
       // Verifica si no es el botón de cancelar
       if (!gBotonCancelar)
       {
          // Obtengo la referencia al total
         total = document.getElementById("idTotal");
         
         // Ubica la posición del Total
         posIniTotal = total.innerHTML.indexOf("$")+1;
         posFinTotal = total.innerHTML.lastIndexOf("</");

         // Obtiene el total
         importe = total.innerHTML.substring(posIniTotal,posFinTotal); 

         if (importe=="0.00")
         {
            // Cancela el Submit
            event.preventDefault(); 
            
            // Ejecuta
            $("#myModal").modal();

            if (gBotonCancelar)
               alert("Era Cancelacion");
         }
       }                          
    }  

    function fnBotonPresionado(boton)
    {
       // Verifica que botón se presionó
       if (boton.id=="btnAceptar")
          gBotonCancelar = false;
       else    
          gBotonCancelar = true;
    }

    function fnClearForm()
    {
      // Captura el Evento de que Muestra la Página
      window.addEventListener("pageshow", () => 
      {
         // Resetea la Form
         document.form1.reset();
      });        
    }
    
  </script>

</head>
<body onload="fnClearForm()">

<nav class="navbar navbar-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="img/logo.png" alt="Logo" style="width:100px;"></a>
      <button type="button" class="btn btn-warning">
        <?php
        echo strtoupper($usuario);
        ?>
      </button>

      <button type="button" class="btn btn-outline-warning">
        <?php
        echo strtoupper($tipo);
        ?>
      </button>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="servicios.php">
              <h2 class="text-white">Servicios</h2>
            </a>
          </li>
          <li class="nav-item">
            <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="comandas.php">
              <h2 class="text-white">Comandas</h2>
            </a>
          </li>
          <li class="nav-item">
            <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="entregas.php">
              <h2 class="text-white">Entregas</h2>
            </a>
          </li>
          <li class="nav-item">
            <a type="button" class="btn btn-outline-danger btn-lg btn-block" href="php/salida.php">
              <h2 class="text-white">Salir</h2>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <br>

  <div class="container">
  <div class="alert alert-success" role="alert">
    <strong>Tomar el pedido</strong>
    Selecciona los productos.
</div>
    <form name ="form1" action='php/comandaAgregar.php' id="form1"
          class='was-validated' method='POST' onsubmit="fnValida(event)">
        
        <div class="form-group">   
          <div id="comanda">
            <?php
                // Coloco el servicio y la mesas ocultos oculto
                
                

                
                echo "<input type='text' value=$servicio name='servicio' hidden>"."\n";
                echo "<input type='text' value=$mesa name='mesa' hidden>"."\n";
                // Obtengo las Clases
                $clases = fnGetDatos($conexion,"clases");

                // Ciclo para procesar cada registro de Clase
                while ($fila = $clases->fetch_assoc()) 
                {
                    // Obtengo la Clase
                    $clase = $fila['nombre'];
                    echo '<div class="card text-white bg-danger mb-3">'."\n";
                    echo '  <div class="card-header">'."\n";
                    echo '    <a class="card-link" data-toggle="collapse"'."\n";
                    echo '       href="#collapse'.$clase.'" style="color:white ;font-size:50px;">'."\n";
                    echo '       '.$clase."\n";
                    echo '    </a>'."\n";
                    echo '  </div>'."\n";
                    echo '  <div id="collapse'.$clase.'"'."\n";
                    echo '       class="collapse" '."\n";
                    echo '       data-parent="#comanda">'."\n";
                    echo '    <div class="card-body">'."\n";
                    echo '       <table class="table table-hover table-danger">'."\n";
                    echo '       <thead class="thead-danger">'."\n";
                    echo '       <tr>'."\n";
                    echo '       <th>Producto</th>'."\n";
                    echo '       <th>Precio</th>'."\n";
                    echo '       <th>Cantidad</th>'."\n";
                    echo '       <th>Comentario</th>'."\n";
                    echo '       </tr>'."\n";
                    echo '       </thead>'."\n";
                    echo '       <tbody>'."\n";

                    // Obtiene los Productos de esa Clase
                    $productos = fnGetProductosPorClase($conexion,$clase);
                    
                    // Ciclo para los productos de la Clase
                    while ($row =$productos->fetch_assoc()) 
                    {
                        echo '         <tr>'."\n";
                        echo '            <td width="25%">'."\n";
                        echo '              '.$row['nombre']."\n";
                        echo '            </td>'."\n";
                        echo '            <td align=right id="precio'.$row['codigo'].'">'."\n";
                        echo '              '.$row['precio'].'</td>'."\n";
                        //Campo oculto para el precio
                        echo "<input type='hidden' name=precio".$row['codigo']." value=".$row['precio'].">";
                        echo '            <td>'."\n";
                        echo '                <input type="number"'."\n";
                        echo '                       onchange =fnCalculaTotales()'."\n";
                        echo '                       value =  0'."\n";
                        echo '                       min   =  0'."\n";
                        echo '                       max   = 10'."\n";
                        echo '                       name  = "cantidad'.$row['codigo'].'">'."\n";
                        echo '            </td>'."\n";
                        echo '            <td width="25%">'."\n";
                        echo '                <select name="comentario'.$row['codigo'].'">'."\n";

                        // Obtener los Comentarios de la Clase
                        $comentarios = fnGetComentariosPorClase($conexion,$clase);
                        echo '                    <option value="">Seleccione</option>'."\n";

                        // Ciclo para los productos de la Clase
                        while ($reg =$comentarios->fetch_assoc()) 
                        {

                           echo '                    <option value="'.$reg["descripcion"].'">'.$reg["descripcion"].'</option>'."\n";
                        }
                        echo '                </select>'."\n";
                        echo '            </td>'."\n";
                        echo '         </tr>'."\n";
                    }                       
                    echo '       </tbody>'."\n";
                    echo '       </table>'."\n";
                    echo '    </div>'."\n";
                    echo '  </div>'."\n";
                    echo '</div>'."\n";
                }                    
            ?>                        
          </div>          
        </div>



        
        
        <div class="alert alert-success" id="idTotal">
          Totales-> Productos: <strong>0</strong> Importe: <strong>$0.00</strong>
        </div>
        
        <button type="submit" id="btnAceptar" 
                onclick="fnBotonPresionado(this)"
                class="btn btn-success">Aceptar
        </button>
        <button type="submit" id="btnCancelar"
           <?php 
              echo "name ='$cancelar'";
           ?>   
                onclick="fnBotonPresionado(this)"
                class="btn btn-danger">Cancelar</button>
    </form>    
  </div>

  
  <br><br><br>


    <!-- La ventana para el Mensaje de Falta de Productos -->
    <div class="modal fade" id="myModal">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Mensaje del Sistema</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            Debe capturar un producto para Aceptar
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>

        </div>
      </div>
    </div>
</body>
</html>