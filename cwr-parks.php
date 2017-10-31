<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php

// Parse Data
$success = '';
if(isset($_POST['submit'])){
    $fileName = 'cwr-parks.json';
    $jsonData = array();
    if(isset($_FILES['file']['tmp_name'])){
        $fileExt = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        if($fileExt == 'csv' || $fileExt == 'xls' || $fileExt == 'xlsx' || $fileExt == 'txt'){
            if($fileExt == 'csv'){
                $flag = true;
                $handle = fopen($_FILES['file']['tmp_name'], "r");
                while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                    if ($flag) {
                        $flag = false;
                        continue;
                    }

                    $parkName = $data[0];
                    $streetAddress = $data[1];
                    $city = $data[2];
                    $province = $data[3];
                    $playground = $data[4];
                    $picnicArea = $data[5];
                    $fishing = $data[6];
                    $trails = $data[7];
                    $washrooms = $data[8];
                    $swimming= $data[9];


                    $jsonData[] = array(
                        $parkName => array(
                            "Street Address" => $streetAddress,
                            "City" => $city,
                            "Province" => $province,
                            "Playground" => $playground,
                            "Picnic Area" => $picnicArea,
                            "Fishing" => $fishing,
                            "Trails" => $trails,
                            "Washrooms" => $washrooms,
                            "Swimming" => $swimming
                        )
                    );

                }
                fclose($handle);

            }else if($fileExt == 'xlsx'){
                require_once 'class/SimpleXLSX.php';
                if ($xlsx = SimpleXLSX::parse($_FILES['file']['tmp_name'])) {
                    $xlsxRow = $xlsx->rows();
                    for($i = 1; $i < count($xlsxRow); $i++){
                        $parkName = $xlsxRow[$i][0];
                        $streetAddress = $xlsxRow[$i][1];
                        $city = $xlsxRow[$i][2];
                        $province = $xlsxRow[$i][3];
                        $playground = $xlsxRow[$i][4];
                        $picnicArea = $xlsxRow[$i][5];
                        $fishing = $xlsxRow[$i][6];
                        $trails = $xlsxRow[$i][7];
                        $washrooms = $xlsxRow[$i][8];
                        $swimming= $xlsxRow[$i][9];

                        $jsonData[] = array(
                            $parkName => array(
                                "Street Address" => $streetAddress,
                                "City" => $city,
                                "Province" => $province,
                                "Playground" => $playground,
                                "Picnic Area" => $picnicArea,
                                "Fishing" => $fishing,
                                "Trails" => $trails,
                                "Washrooms" => $washrooms,
                                "Swimming" => $swimming
                            )
                        );
                    }
                } else {
                    echo SimpleXLSX::parse_error();
                }


            }else if($fileExt == 'xls'){
                require_once 'class/SimpleXLSX.php';
                require_once 'class/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
                $objPHPExcel = PHPExcel_IOFactory::load($_FILES['file']['tmp_name']);
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
                $xlsxFile = str_replace('.php', '.xlsx', __FILE__);
                if ($xlsx = SimpleXLSX::parse($xlsxFile)) {
                    $xlsxRow = $xlsx->rows();
                    for($i = 1; $i < count($xlsxRow); $i++){
                        $parkName = $xlsxRow[$i][0];
                        $streetAddress = $xlsxRow[$i][1];
                        $city = $xlsxRow[$i][2];
                        $province = $xlsxRow[$i][3];
                        $playground = $xlsxRow[$i][4];
                        $picnicArea = $xlsxRow[$i][5];
                        $fishing = $xlsxRow[$i][6];
                        $trails = $xlsxRow[$i][7];
                        $washrooms = $xlsxRow[$i][8];
                        $swimming= $xlsxRow[$i][9];

                        $jsonData[] = array(
                            $parkName => array(
                                "Street Address" => $streetAddress,
                                "City" => $city,
                                "Province" => $province,
                                "Playground" => $playground,
                                "Picnic Area" => $picnicArea,
                                "Fishing" => $fishing,
                                "Trails" => $trails,
                                "Washrooms" => $washrooms,
                                "Swimming" => $swimming
                            )
                        );
                    }
                } else {
                    echo SimpleXLSX::parse_error();
                }
            }else if($fileExt == 'txt'){

                $handle = fopen($_FILES['file']['tmp_name'], "r");
                $fh = fread($handle, filesize($_FILES['file']['tmp_name']));
                $fileRows = explode("\n", $fh);
                for($i = 1; $i < count($fileRows); $i++){
                        $fileColumn = explode(",", $fileRows[$i]);
                        $parkName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileColumn[0]);
                        $streetAddress = preg_replace('/[^A-Za-z0-9\-]/', '', $fileColumn[1]);
                        $city = preg_replace('/[^A-Za-z0-9\-]/', '', $fileColumn[2]);
                        $province = preg_replace('/[^A-Za-z0-9\-]/', '', $fileColumn[3]);
                        $playground = preg_replace('/[^A-Za-z0-9\-]/', '', $fileColumn[4]);
                        $picnicArea = preg_replace('/[^A-Za-z0-9\-]/', '', $fileColumn[5]);
                        $fishing = preg_replace('/[^A-Za-z0-9\-]/', '', $fileColumn[6]);
                        $trails = preg_replace('/[^A-Za-z0-9\-]/', '', $fileColumn[7]);
                        $washrooms = preg_replace('/[^A-Za-z0-9\-]/', '', $fileColumn[8]);
                        $swimming= preg_replace('/[^A-Za-z0-9\-]/', '', $fileColumn[9]);

                        $jsonData[] = array(
                            $parkName => array(
                                "Street Address" => $streetAddress,
                                "City" => $city,
                                "Province" => $province,
                                "Playground" => $playground,
                                "Picnic Area" => $picnicArea,
                                "Fishing" => $fishing,
                                "Trails" => $trails,
                                "Washrooms" => $washrooms,
                                "Swimming" => $swimming
                            )
                        );
                }


            }


            $fh = fopen($fileName, 'w+');
            fwrite($fh, json_encode($jsonData, JSON_PRETTY_PRINT));
            fclose($fh);

            $success = true;
        }else{
            $success = false;

        }
    }else{
        $success = false;
    }

}

if(isset($_GET['mode'])){
    $mode = $_GET['mode'];
    switch($mode){
        case 'admin':
            $successMessage = '';
            if($success === ''){
                $successMessage = '';
            }else if($success == true){
                $successMessage = '<div class="alert alert-success">
                                      <strong>Success!</strong> File Successfully Uploaded.
                                    </div>';
            }else if($success == false){

                $successMessage = '<div class="alert alert-danger">
                                      <strong>Error</strong> Something went wrong, please check your file and try again.
                                    </div>';
            }
            echo '
                   <div class="container text-center" style="margin-top: 20%;">
                                ' . $successMessage . '
                                <form action="" method="POST" enctype="multipart/form-data" class="form-inline">
                                <div class="form-group">
                                    <label for="file">URL to Parks Data </label>
                                    <input class="form-control" id="file" type="file" name="file"> 
                                    <input class="btn btn-primary" type="submit" name="submit" value="Save">
                                </div>
                                </form>      
                   </div>
                ';

            break;

        case 'view':

            $json = file_get_contents('cwr-parks.json');
            echo '<pre>';
            print_r ($json);
            echo '</pre>';
            break;
    }

}
?>
</body>
