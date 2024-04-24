<?php
require_once "config.php";
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
   case 'GET':
         if(!empty($_GET["nim"]))
         {
            $nim=intval($_GET["nim"]);
            get_mahasiswa($nim);
         }
         else
         {
            get_all_mahasiswa();
         }
         break;
   case 'POST':
         if(!empty($_GET["nim"]))
         {
            $nim=intval($_GET["nim"]);
            update_mahasiswa($nim);
         }
         else
         {
            insert_mahasiswa();
         }     
         break; 
   case 'DELETE':
          $nim=intval($_GET["nim"]);
            delete_mahasiswa($nim);
            break;
   default:
         header("HTTP/1.0 405 Method Not Allowed");
         break;
      break;
 }



   function get_all_mahasiswa()
   {
      global $mysqli;
      $query="SELECT * FROM mahasiswa";
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
 
   function get_mahasiswa($nim=0)
   {
      global $mysqli;
      $query="SELECT * FROM mahasiswa";
      if($nim != 0)
      {
         $query.=" WHERE nim=".$nim." LIMIT 1";
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
 
   function insert_mahasiswa()
      {
         global $mysqli;
         if(!empty($_POST["nim"] && $_POST["nama"] && $_POST["alamat"] && $_POST["tanggal_lahir"])){
            $data=$_POST;
         }else{
            $data = json_decode(file_get_contents('php://input'), true);
         }

         $arrcheckpost = array('nim' => '', 'nama' => '','alamat' => '', 'tanggal_lahir' => '');
         $hitung = count(array_intersect_key($data, $arrcheckpost));
         if($hitung == count($arrcheckpost)){
          
               $result = mysqli_query($mysqli, "INSERT INTO mahasiswa SET
               nim = '$data[nim]',
               nama = '$data[nama]',
               alamat = '$data[alamat]',
               tanggal_lahir = '$data[tanggal_lahir]'");                
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
                     'message' =>'Mahasiswa Addition Failed.'
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
 
   function update_mahasiswa($nim)
      {
         global $mysqli;
         if(!empty($_POST["nama"] && $_POST["alamat"] && $_POST["tanggal_lahir"])){
            $data=$_POST;
         }else{
            $data = json_decode(file_get_contents('php://input'), true);
         }

         $arrcheckpost = array('nama' => '','alamat' => '', 'tanggal_lahir' => '');
         $hitung = count(array_intersect_key($data, $arrcheckpost));
         if($hitung == count($arrcheckpost)){
          
              $result = mysqli_query($mysqli, "UPDATE mahasiswa SET
              nama = '$data[nama]',
              alamat = '$data[alamat]'
              tanggal_lahir = '$data[tanggal_lahir]'
              WHERE nim='$nim'");
          
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
                  'message' =>'Mahasiswa Updation Failed.'
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
 
   function delete_mahasiswa($nim)
   {
      global $mysqli;
      $query="DELETE FROM mahasiswa WHERE nim=".$nim;
      if(mysqli_query($mysqli, $query))
      {
         $response=array(
            'status' => 1,
            'message' =>'Mahasiswa Deleted Successfully.'
         );
      }
      else
      {
         $response=array(
            'status' => 0,
            'message' =>'Mahasiswa Deletion Failed.'
         );
      }
      header('Content-Type: application/json');
      echo json_encode($response);
   }

 
?> 
