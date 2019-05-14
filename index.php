<?php 
require_once 'functions/initialize.php';


if (!empty($_GET['res'])){
  $res = $_GET['res'];
  $subject_tareas1 = find_all_tareas();
  $conttareas = mysqli_num_rows($subject_tareas1);
  switch ($res) {
    case 1:
      $nombre = $_POST['nombre'];
      if (!validate_campo($nombre)) {
        insert_alumno($nombre, $conttareas); 
      } else {
        echo '<script type="text/javascript">
          alert("Necesita registrar un nombre"); 
          </script>';
      }
      break;
    case 2:
      $subject_set = find_all_subjects();
      $result = mysqli_num_rows($subject_set);

      insert_tarea();
      if ($result != 0) {
        $alumnos = find_all_subjects();
        $noalumnos = mysqli_num_rows($alumnos);
        $datos = mysqli_fetch_assoc($alumnos);
        
        $id = $datos['id'];
        if ($datos['tareas'] == "") {
          
          insert_tareas_vacias($conttareas,$noalumnos);
        }else{
          $tareas = $datos['tareas'];
          agregar_tarea_vacia($conttareas,$noalumnos);
        }
        
        //si es diferente de 0 voy a agregar el array a la tabla de calificaciones en la columna tareas 
        //con la cantidad de tareas que hay en la tabla tareas pero con atributos vacios
      }
        break;
    case 3:
      delete_tareas();
      break;
    case 4:
      delete_alumnos();
      break;
  }
}



?>

<?php
  // Obtenemos una única vez los registros de la tabla "calificacion"
  $calificacion = find_all_subjects();
  // Almacenamos todos los registros en $calificacion
  $subject_set = mysqli_fetch_all($calificacion, MYSQLI_ASSOC);
  // Liberamos los recursos asociados a la consulta
  mysqli_free_result($calificacion);
  // No repetimos la misma consulta, copiamos los datos (en realidad, no hace ni falta)
  $subject_set2 = $subject_set;
  $subject_tareas1 = find_all_tareas();
  $conttareas = mysqli_num_rows($subject_tareas1);

  $result = count($subject_set);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/estilo.css">
	<title>Maestro</title>
</head>
<body>

	  	<table border="1" width="90%" align="left" > 
 <tr> 
 	<th bgcolor="#E9EAEA">NO.</th>
    <th>NOMBRE DEL</th> 
    <th>TAREAS</th>
 	<th>EXAMENES</th>
 	<th>PROMEDIO</th>

     
 </tr> 
 
 	<tr>
 	<th>#</th>
 	<th align="center">ALUMNO</th>
 	<td><table  border="1" width="100%"> 
       <tr> 

          <?php if ($conttareas != 0) {   ?>

          <?php for ($i=1; $i <= $conttareas ; $i++) {
            $tareas = "T" . $i;
           ?>
            <!--<th align="center"><a href="http://www.google.com"><?= $hw[1]; ?></a></th> -->
            <th align="center"><a href="http://www.google.com"><?= $tareas?></a></th>


         <?php } ?>

       <?php }else{  ?>
        <th align="center"><a href="http://www.google.com">.</a></th>
      <?php } ?>
        
          

       </tr> 
      
        </table></td>

        <td><table  border="1" width="100%"> 
       <tr> 
            <th align="center">EX1</th> 
            <th align="center">EX2</th> 
            <th align="center">EX3</th>
       </tr> 
       
        </table></td>
        <td bgcolor="#E9EAEA"><table bgcolor="#E9EAEA"  width="100%"> 
       <tr> 
            <th align="center">GENERAL</th> 
            
       </tr> 
       
        </table></td>


        
        <?php foreach($subject_set as $i => $subject) { ?>
          
      <tr>  
      <td align="center"><?= $i ?></td>
      <td><?= htmlspecialchars($subject['nombre']) ?></td>   
      <?php var_dump($subject) ?>  
      <!--calificaciones de cada alumno-->
      <td><table  border="1" width="100%"> 
       <tr> 

          <?php $tareas = json_decode($subject['tareas']);
          if (count($tareas) > 0) {
          foreach ($tareas as $tarea) { ?>
            <td align="center"><a href="http://www.google.com"><?= htmlspecialchars($tarea) ?></a></td>
         <?php } ?>

       <?php } else {  ?>
        <td align="center"><a href="http://www.google.com">.</a></td>
      <?php } ?>
        
          

       </tr> 
      
        </table></td>
      </tr>

     

    <?php } ?>
 		</tr>




</table>
	
	</br>
  <form action="index.php?res=2"  method="post" enctype="multipart/form-data">
      <dl>
        <dt>nueva tarea <input type="submit" value="Agregar" /></dt>

          
      </dl>
   
      <div id="operations">
      </div>
      
    </form>
 
    <form action="index.php?res=3" method="post" enctype="multipart/form-data">
      <dl>
        <dt>Borrar<input type="submit" value="Borrar Todas" /></dt>
        
          
      </dl>
   
      <div id="operations">
      </div>
      
    </form>

  <form action="index.php?res=1" method="post" enctype="multipart/form-data">
      <dl>
      </br></br></br> </br> </br></br></br>
    </br></br></br></br></br></br></br>
      </br></br></br></br></br></br></br>

        <dt>Nombre Completo <input type="text" name="nombre" value="" /></dt>
          
      </dl>
   
      <div id="operations">
        <input type="submit" value="Agregar" />
      </div>
      
    </form>
  </br></br></br>

<form action="index.php?res=4" method="post" enctype="multipart/form-data">
      <dl>
      </br></br>

        <dt>Borrar Alumnos<input type="submit" value="Borrar" /></dt>
          
      </dl>
   
      <div id="operations">
        
      </div>
      
    </form>





</body>
</html>

  	

