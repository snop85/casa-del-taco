<?php
  // ----------
  // salida.php
  // ----------

  // Destruye la sesion activa
  session_start();
  session_destroy();

  // Llama al index.php
  header("Location: ../index.php");	
  
?>