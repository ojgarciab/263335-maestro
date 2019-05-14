<?php

  require_once('database.php');
 
function find_all_subjects(){

	global $db;

	$sql = "SELECT * FROM calificacion ";
	$sql .= "ORDER BY nombre ASC";
	//echo $sql;
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}


function find_all_tareas(){

  global $db;

 $sql = "SELECT * FROM tareas ";
  //echo $sql;
  $result = mysqli_query($db, $sql);
  confirm_result_set($result);
  return $result;
}

function find_subject_by_id($id){
	global $db;

	$sql = "SELECT * FROM calificaciones ";
	$sql .= "WHERE id='" . $id . "'";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	$subject = mysqli_fetch_assoc($result);
	mysqli_free_result($result);
	return $subject; //return an assoc. array

}

function has_unique_page_menu_name($nombre) {
    global $db;
    $sql = "SELECT * FROM peliculas ";
    $sql .= "WHERE nombre='" . $nombre . "' ";
    $page_set = mysqli_query($db, $sql);
    $page_count = mysqli_num_rows($page_set);
    mysqli_free_result($page_set);
    if ($page_count === 0) {
      return true;
    }
  }


function find_all_pages(){
	global $db;

	$sql = "SELECT * FROM pages ";
	$sql .= "ORDER BY subject_id ASC, position ASC";
	$result = mysqli_query($db, $sql);
	confirm_result_set($result);
	return $result;
}

function insert_alumno($nombre,$cont){
  //$nombre = $_POST['nombre'];
	global $db;
  if ($cont != 0) {
    insert_alumno2($nombre,$cont);
  }else{

 $sql = "INSERT INTO calificacion ";
  $sql .= "(nombre, tareas, examenes) ";
  $sql .= "VALUES (";
  $sql .= "'" . $nombre . "'," . "''," . "''";
  $sql .= ")";

  $result = mysqli_query($db, $sql);
  //for INSERT statements, $result is true/false
  if ($result) {
   
    header('Location: ../maestro/index.php?');
    
  }else{
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
      exit;
  }

  }

 

}

function insert_alumno2($nombre,$cont){
  //$nombre = $_POST['nombre'];
  global $db;
 

 $array = array();

 for ($i=1; $i <$cont ; $i++) { 
   array_push($array, "T" . $i);
 }
 
 array_push($array, "T" . $cont);

 $arrayencoded = json_encode($array);

 $sql = "INSERT INTO calificacion ";
  $sql .= "(nombre, tareas, examenes) ";
  $sql .= "VALUES (";
  $sql .= "'" . $nombre . "'," . "'$arrayencoded'," . "''";
  $sql .= ")";

  $result = mysqli_query($db, $sql);
  //for INSERT statements, $result is true/false
  if ($result) {
   
    header('Location: ../maestro/index.php?');
    
  }else{
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
      exit;
  }

  

 

}

function insert_tarea(){
  
  global $db;
  $subject_tareas1 = find_all_tareas();
  $conttareas = mysqli_num_rows($subject_tareas1) + 1;

  $sql = "INSERT INTO tareas ";
  $sql .= "(tarea) ";
  $sql .= "VALUES (";
  $sql .= "'" . "T" . $conttareas . "'";
  $sql .= ")";

  $result = mysqli_query($db, $sql);
  //for INSERT statements, $result is true/false
  if ($result) {
    
    
  }else{
    // INSERT failed
    echo mysqli_error($db);
    db_disconnect($db);
      exit;
  }

}

function insert_tareas_vacias($cont,$noalumnos){
  
  global $db;
  $alumnos = find_all_subjects();
          $datos = mysqli_fetch_assoc($alumnos);



 //$example = array("", "", 3);
  $array = array("T" . 1);



 
//Encode $example array into a JSON string.
$arrayencoded = json_encode($array);


for ($i=1; $i <=$noalumnos ; $i++) { 
  $id = $datos['id'];

  $sql = "UPDATE calificacion SET tareas =" . "'$arrayencoded' where id=" . $id;
  $result = mysqli_query($db, $sql);
   $datos = mysqli_fetch_assoc($alumnos);

}


if ($result) {
  return true;
}else{
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
}


}


function agregar_tarea_vacia($cont,$noalumnos){
  
  global $db;
          $alumnos = find_all_subjects();
          $datos = mysqli_fetch_assoc($alumnos);
          $tareas =  array($datos['tareas']);
          
          $example = json_decode($datos['tareas'], true);
          $array = array();

          for ($i=1; $i <$cont ; $i++) { 
            array_push($array, $example[$i-1]);
          }
          array_push($array, "T" . $cont);
          $i2 = $cont +1;
          array_push($array, "T" . $i2);
          

         $arrayencoded = json_encode($array);

for ($i=1; $i <=$noalumnos ; $i++) { 
  $id = $datos['id'];

  
  $sql = "UPDATE calificacion SET tareas =" . "'$arrayencoded'" . "where id=" . $id;
  $result = mysqli_query($db, $sql);
  $datos = mysqli_fetch_assoc($alumnos);
}
 
//for UPDATE statements, $result is true/false

/*if ($result) {
  return true;
}else{
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
}
*/

}

function update_subject() {

	global $db;


$array = array('T1' => '');
$array_texto = json_encode($array);

  $b = serialize($array);
 $sql = "UPDATE calificacion SET tareas =" . "'$array_texto'";


$result = mysqli_query($db, $sql);
//for UPDATE statements, $result is true/false

if ($result) {
  return true;
}else{
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
}

}




function update_subject2($subject) {

  global $db;


$sql = "UPDATE peliculas SET ";
$sql .= "nombre='" . $subject['nombre'] . "',";
$sql .= "genero='" . $subject['genero'] . "', ";
$sql .= "idioma='" . $subject['idioma'] . "',";
$sql .= "duracion='" . $subject['duracion'] . "', ";
$sql .= "clasificacion='" . $subject['clasificacion'] . "',";
$sql .= "funcion='" . $subject['funcion'] . "',";
$sql .= "imagen='" . $subject['imagen'] . "' ";
$sql .= "WHERE id='" . $subject['id'] . "' ";
$sql .= "LIMIT 1";

$result = mysqli_query($db, $sql);
//for UPDATE statements, $result is true/false

if ($result) {
  return true;
}else{
  echo mysqli_error($db);
  db_disconnect($db);
  exit;
}

}

function delete_tareas(){
global $db;

$sql = "truncate table tareas";


  $result = mysqli_query($db, $sql);

  //for DELETE statements, $result is true/false

  if ($result) {
      header('Location: ../maestro/index.php?');
    }else{
      //DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;

    } 

}

function delete_alumnos(){
global $db;

$sql = "truncate table calificacion";


  $result = mysqli_query($db, $sql);

  //for DELETE statements, $result is true/false

  if ($result) {
      header('Location: ../maestro/index.php?');
    }else{
      //DELETE failed
      echo mysqli_error($db);
      db_disconnect($db);
      exit;

    } 

}

?>