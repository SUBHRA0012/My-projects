<?php
session_start();
include '../../partials/_dbconnect.php';
if (!isset($_SESSION['admin_loggedin']) || $_SESSION['admin_loggedin'] != true) {
    exit;
}

//$admin_name = $_SESSION['admin_name'];

class imageUploader
{
    private $target_dir;

    public function __construct($dir = '../../partials/images/productImages/')
    {
        $this->target_dir = $dir;
    }

    public function upload($fileArray)
    {
        $fileName = $fileArray['name'];
        $fileTmp = $fileArray['tmp_name'];

        if (!empty($fileName)) {
            move_uploaded_file($fileTmp, $this->target_dir . $fileName);
        }
        return $fileName;
    }
}


class productManager
{
    private $conn;
    private $uploader;

    //$dbconnection -> the $conn variable of _dbconnect.php
    // $imageuploader -> the whole object of imageuploader class
    public function __construct($dbConnection, $imageUploader)
    {
        $this->conn = $dbConnection;
        $this->uploader = $imageUploader;
    }
    //$postData will contain $_POST and $fileData will coontain $_FILES
    public function saveProduct($postData, $fileData)
    {
        $product_name = mysqli_real_escape_string($this->conn, $postData['product_name']);
        $parent_product = strtolower(trim(explode('-', $product_name)[0]));
        $cat_id = $postData['category_id'];
        list($category_id, $category_name) = explode('|', $cat_id);
        $price = $postData['price'];
        $old_price = !empty($postData['old_price']) ? $postData['old_price'] : $price;
        $stock = $postData['stock'];
        $product_desc = mysqli_real_escape_string($this->conn, $postData['product_desc']);
        $detail_desc = mysqli_real_escape_string($this->conn, $postData['detail_desc']);
        $unitWhat = $category_id == 4 ? 'liter' : 'kg';

        $is_update = isset($postData['edit_product_id']) && !empty($postData['edit_product_id']);
        if ($is_update) {
            $pid = $postData['edit_product_id'];
            $sql_prod_upd = "UPDATE `products` SET `category_id`='$category_id', `product_name`='$product_name', `price`='$price', `old_price`='$old_price', `parent_product`='$parent_product', `stock`='$stock', `product_desc`='$product_desc' WHERE `id`='$pid'";
            mysqli_query($this->conn, $sql_prod_upd);

            $sql_det_upd = "UPDATE `detailsproduct` SET `detail_desc`='$detail_desc' WHERE `product_id`='$pid'";
            mysqli_query($this->conn, $sql_det_upd);

            $imageFields = [
                'image' => 'products',
                'thumb_img1' => 'detailsproduct',
                'thumb_img2' => 'detailsproduct',
                'thumb_img3' => 'detailsproduct',
                'thumb_img4' => 'detailsproduct'
            ];

            foreach ($imageFields as $colName => $tableName) {
                //it checks !empty($_FILES['image']['name'])
                if (!empty($fileData[$colName]['name'])) {
                    //->upload($_FILES['image'])
                    $uploadFile = $this->uploader->upload($fileData[$colName]);
                    $idCol = ($tableName == 'products') ? 'id' : 'product_id';
                    mysqli_query($this->conn, "UPDATE `$tableName` SET `$colName` = '$uploadFile' WHERE `$idCol` = '$pid'");
                }
            }
        } else {
            $image = $this->uploader->upload($fileData['image']);
            $thumb_img1 = $this->uploader->upload($fileData['thumb_img1']);
            $thumb_img2 = $this->uploader->upload($fileData['thumb_img2']);
            $thumb_img3 = $this->uploader->upload($fileData['thumb_img3']);
            $thumb_img4 = $this->uploader->upload($fileData['thumb_img4']);

            $sql_product = "INSERT INTO `products` ( `category_id`, `product_name`, `price`, `old_price`, `parent_product`, `image`, `stock`, `product_desc`) VALUES ('$category_id', '$product_name', '$price', '$old_price', '$parent_product', '$image', '$stock', '$product_desc')";

            if (mysqli_query($this->conn, $sql_product)) {
                $product_id = mysqli_insert_id($this->conn);
                $sql_detailsproduct = "INSERT INTO `detailsproduct`(`product_id`, `detail_desc`, `thumb_img1`, `thumb_img2`, `thumb_img3`, `thumb_img4`) VALUES ('$product_id', '$detail_desc', '$thumb_img1', '$thumb_img2', '$thumb_img3', '$thumb_img4')";
                if (mysqli_query($this->conn, $sql_detailsproduct)) {

                    return [
                        'status' => 'success',
                        'products' => [
                            'id' => $product_id,
                            'image' => $image,
                            'product_name' => $product_name,
                            'category' => $category_name,
                            'price' => $price,
                            'old_price' => $old_price,
                            'stock' => $stock,
                            'unit' => $unitWhat
                        ]
                    ];
                } else {
                    return ['status' => 'error', 'message' => 'Error in details ' . mysqli_error($this->conn)];
                }
            } else {
                return ['status' => 'error', 'message' => 'Error in products ' . mysqli_error($this->conn)];
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['delete_tr'])) {
        $del_product_id = $_POST['delete_tr'];
        $sql_details_product = "DELETE FROM `detailsproduct` WHERE `product_id` = '$del_product_id'";
        if (mysqli_query($conn, $sql_details_product)) {
            $products_del_sql = "DELETE FROM `products` WHERE `id` = '$del_product_id'";
            if (mysqli_query($conn, $products_del_sql)) {
                echo "deleted";
            } else {
                echo "faild_delete";
            }
        }
        exit;
    }

    if (isset($_POST['edit_tr_data'])) {
        $edit_product_id = $_POST['edit_tr_data'];
        $sql = "SELECT p.*, d.detail_desc, d.thumb_img1, d.thumb_img2, d.thumb_img3, d.thumb_img4, c.category_name 
            FROM `products` p LEFT JOIN `detailsproduct` d ON p.id = d.product_id 
            LEFT JOIN `categories` c ON p.category_id = c.id WHERE p.id = '$edit_product_id'";

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $product_data = mysqli_fetch_assoc($result);
            echo json_encode(['status' => 'edited', 'data' => $product_data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Cant get table Data']);
        }
        exit;
    }

    $uploader = new imageUploader();
    $product_manager = new productManager($conn, $uploader);
    $response = $product_manager->saveProduct($_POST, $_FILES);
    if (isset($_POST['edit_product_id']) && !empty($_POST['edit_product_id'])) {
        header('location: ../products.php?msg=updated');
        exit;
    } else {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}
