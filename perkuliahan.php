<?php
require_once "config.php";
$request_method=$_SERVER["REQUEST_METHOD"];
switch ($request_method) {
   case 'GET':
         if(!empty($_GET["nim"]))
         {
            $nim=$_GET["nim"];
            get_nilai($nim);
         }
         else
         {
            get_all_nilai();
         }
         break;
   case 'POST':
         if(!empty($_GET["nim"] && $_GET["kode_mk"]))
         {
            $nim=$_GET["nim"];
            $kode_mk=$_GET["kode_mk"];
            update_nilai($nim, $kode_mk);
         }
         else
         {
            insert_nilai();
         }
         break; 
   case 'DELETE':
            $nim=$_GET["nim"];
            $kode_mk=$_GET["kode_mk"];
            delete_nilai($nim, $kode_mk);
            break;
   default:
      // Invalid Request Method
         header("HTTP/1.0 405 Method Not Allowed");
         break;
      break;
 }

   function get_all_nilai()
   {
      global $mysqli;
      $query="SELECT mahasiswa.*, matakuliah.*, perkuliahan.nilai FROM mahasiswa JOIN perkuliahan ON mahasiswa.nim = perkuliahan.nim JOIN matakuliah ON perkuliahan.kode_mk = matakuliah.kode_mk";
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
 
   function get_nilai($id)
   {
      global $mysqli;
      $query="SELECT mahasiswa.*, matakuliah.*, perkuliahan.nilai FROM mahasiswa JOIN perkuliahan ON mahasiswa.nim = perkuliahan.nim JOIN matakuliah ON perkuliahan.kode_mk = matakuliah.kode_mk";
      if($id != 0)
      {
         $query.=" WHERE mahasiswa.nim LIKE '$id'";
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
 
   function insert_nilai()
      {
         global $mysqli;
         if(!empty($_POST["nilai"] && $_POST["nim"] && $_POST["kode_mk"])){
            $data=$_POST;
         }else{
            $data = json_decode(file_get_contents('php://input'), true);
         }

         $arrcheckpost = array('nilai' => '', 'nim' => '','kode_mk' => '');
         $hitung = count(array_intersect_key($data, $arrcheckpost));
         if($hitung == count($arrcheckpost)){
          
               $result = mysqli_query($mysqli, "INSERT INTO perkuliahan SET
               nim = '$data[nim]',
               kode_mk = '$data[kode_mk]',
               nilai = '$data[nilai]'");                
               if($result)
               {
                  $response=array(
                     'status' => 1,
                     'message' =>'Success.',
                     'data' => $data
                  );
               }
               else
               {
                  $response=array(
                     'status' => 0,
                     'message' =>'Nilai Addition Failed.'
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
 
   function update_nilai($nim, $kode_mk)
      {
         global $mysqli;
         if(!empty($_POST["nilai"])){
            $data=$_POST;
         }else{
            $data = json_decode(file_get_contents('php://input'), true);
         }

         $arrcheckpost = array('nilai' => '');
         $hitung = count(array_intersect_key($data, $arrcheckpost));
         if($hitung == count($arrcheckpost)){
          
              $result = mysqli_query($mysqli, "UPDATE perkuliahan SET
              nilai = '$data[nilai]'
              WHERE nim='$nim' AND kode_mk='$kode_mk'");
          
            if($result)
            {
               $response=array(
                  'status' => 1,
                  'message' =>'Success.',
                  'data' => $data
               );
            }
            else
            {
               $response=array(
                  'status' => 0,
                  'message' =>'Nilai Updation Failed.'
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
 
   function delete_nilai($nim, $kode_mk)
   {
      global $mysqli;
      $query="DELETE FROM perkuliahan WHERE nim LIKE '$nim' AND kode_mk LIKE '$kode_mk'";
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
            'message' =>'Nilai Deletion Failed.'
         );
      }
      header('Content-Type: application/json');
      echo json_encode($response);
   }

 
?> 
