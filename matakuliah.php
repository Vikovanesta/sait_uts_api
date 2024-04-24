<?php
require_once "config.php";
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
   case 'GET':
         if(!empty($_GET["kode_mk"]))
         {
            $id=intval($_GET["kode_mk"]);
            get_matakuliah($id);
         }
         else
         {
            get_all_matakuliah();
         }
         break;
   case 'POST':
         if(!empty($_GET["kode_mk"]))
         {
            $id=intval($_GET["kode_mk"]);
            update_matakuliah($id);
         }
         else
         {
            insert_matakuliah();
         }     
         break; 
   case 'DELETE':
          $id=intval($_GET["kode_mk"]);
            delete_matakuliah($id);
            break;
   default:
      // Invalid Request Method
         header("HTTP/1.0 405 Method Not Allowed");
         break;
      break;
 }



   function get_all_matakuliah()
   {
      global $mysqli;
      $query="SELECT * FROM matakuliah";
      $data=array();
      $result=$mysqli->query($query);
      while($row=mysqli_fetch_object($result))
      {
         $data[]=$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Success.',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
   }
 
   function get_matakuliah($id=0)
   {
      global $mysqli;
      $query="SELECT * FROM matakuliah";
      if($id != 0)
      {
         $query.=" WHERE kode_mk=".$id." LIMIT 1";
      }
      $data=array();
      $result=$mysqli->query($query);
      while($row=mysqli_fetch_object($result))
      {
         $data[]=$row;
      }
      $response=array(
                     'status' => 1,
                     'message' =>'Success.',
                     'data' => $data
                  );
      header('Content-Type: application/json');
      echo json_encode($response);
        
   }
 
   function insert_matakuliah()
      {
         global $mysqli;
         if(!empty($_POST["kode_mk"] && $_POST["nama_mk"] && $_POST["sks"])){
            $data=$_POST;
         }else{
            $data = json_decode(file_get_contents('php://input'), true);
         }

         $arrcheckpost = array('kode_mk' => '', 'nama_mk' => '','sks' => '');
         $hitung = count(array_intersect_key($data, $arrcheckpost));
         if($hitung == count($arrcheckpost)){
          
               $result = mysqli_query($mysqli, "INSERT INTO matakuliah SET
               kode_mk = '$data[kode_mk]',
               nama_mk = '$data[nama_mk]',
               sks = '$data[sks]'");              
               if($result)
               {
                  $response=array(
                     'status' => 1,
                     'message' =>'Success.'
                  );
               }
               else
               {
                  $response=array(
                     'status' => 0,
                     'message' =>'Matakuliah Addition Failed.'
                  );
               }
         }else{
            $response=array(
                     'status' => 0,
                     'message' =>'Parameter Do Not Match'
                  );
         }
         header('Content-Type: application/json');
         echo json_encode($response);
      }
 
   function update_matakuliah($id)
      {
         global $mysqli;
         if(!empty($_POST["nama_mk"] && $_POST["sks"])){
            $data=$_POST;
         }else{
            $data = json_decode(file_get_contents('php://input'), true);
         }

         $arrcheckpost = array('nama_mk' => '','sks' => '');
         $hitung = count(array_intersect_key($data, $arrcheckpost));
         if($hitung == count($arrcheckpost)){
          
              $result = mysqli_query($mysqli, "UPDATE matakuliah SET
              nama_mk = '$data[nama_mk]',
              sks = '$data[sks]'
              WHERE kode_mk='$id'");
          
            if($result)
            {
               $response=array(
                  'status' => 1,
                  'message' =>'Success.'
               );
            }
            else
            {
               $response=array(
                  'status' => 0,
                  'message' =>'matakuliah Updation Failed.'
               );
            }
         }else{
            $response=array(
                     'status' => 0,
                     'message' =>'Parameter Do Not Match'
                  );
         }
         header('Content-Type: application/json');
         echo json_encode($response);
      }
 
   function delete_matakuliah($id)
   {
      global $mysqli;
      $query="DELETE FROM matakuliah WHERE kode_mk=".$id;
      if(mysqli_query($mysqli, $query))
      {
         $response=array(
            'status' => 1,
            'message' =>'Success.'
         );
      }
      else
      {
         $response=array(
            'status' => 0,
            'message' =>'matakuliah Deletion Failed.'
         );
      }
      header('Content-Type: application/json');
      echo json_encode($response);
   }

 
?> 
