<?php
session_start();
include '_dbconnect.php';

if(!isset($_SESSION['user_id'])){
    exit();
}

$user_id = $_SESSION['user_id'];
// ==========================================
// show address list (FETCH)
// ==========================================
if(isset($_POST['action']) && $_POST['action'] == 'fetch_addresses'){
    $active_id = isset($_SESSION['active_address_id']) ? $_SESSION['active_address_id'] : 0;

    $sql = "SELECT * FROM `user_address` WHERE `user_id` = '$user_id'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $count = 0;
        while($row = mysqli_fetch_assoc($result)){
            $count++;
            $add_id = $row['id'];

            $full_address = $row['address_line1'];
            if(!empty($row['locality'])){
                $full_address .= ', ' . $row['locality'];
            }
            $full_address .= ', ' . $row['state'] . ' - ' . $row['pincode'];

            //badge color logic (Home=Green, Work=Blue, Other=Grey)
            $badge_color = 'secondary';
            if($row['address_type'] == 'Home') $badge_color = 'success';
            if($row['address_type'] == 'Work') $badge_color = 'primary';

            $is_checked = ($add_id == $active_id || ($active_id == 0 && $count == 1)) ? 'checked' : '';

            echo '
            <label class="d-flex align-items-start border rounded p-3 mb-2 w-100 shadow-sm" style="cursor: pointer;">
                <input type="radio" name="selected_address" value="'.$add_id.'" class="form-check-input mt-1 me-3" '.$is_checked.'>
                <div>
                    <span class="fw-bold d-block">
                        '.$row['name'].' 
                        <span class="badge bg-'.$badge_color.' ms-1" style="font-size: 10px;">'.$row['address_type'].'</span>
                    </span>
                    <small class="text-muted d-block my-1">'.$full_address.'</small>
                    <span class="small fw-bold"><i class="fas fa-phone-alt me-1 text-secondary"></i> '.$row['phone'].'</span>
                    <button class="btn btn-sm btn-light border ms-2 text-success" 
                            onclick="openEditMode(this)"
                            data-id="'.$row['id'].'"
                            data-name="'.$row['name'].'"
                            data-phone="'.$row['phone'].'"
                            data-pincode="'.$row['pincode'].'"
                            data-locality="'.$row['locality'].'"
                            data-line1="'.$row['address_line1'].'"
                            data-state="'.$row['state'].'"
                            data-type="'.$row['address_type'].'">
                            <i class="fas fa-edit"></i>
                    </button>
                    
                    <button type="button" class="btn btn-sm btn-light border py-0 px-2 text-danger shadow-sm ms-2" 
                        onclick="event.preventDefault(); deleteAddress('.$row['id'].')"
                        title="Delete Address">
                        <small class="fw-bold">Delete</small> <i class="fas fa-trash ms-1" style="font-size: 10px;"></i>
                    </button>
                </div>
            </label>
            ';
        }
    }else{
        echo 
        '<div class="text-center text-muted py-4">
            <i class="fas fa-map-marker-alt fa-2x mb-2 text-secondary"></i><br>
            No address found. Please add a new address.
        </div>';
    }
    exit();
}

// ==========================================
// select address (FETCH)
// ==========================================

if(isset($_POST['action']) && $_POST['action'] == 'save_active_address'){
    $_SESSION['active_address_id'] = $_POST['address_id'];
    echo "success";
    exit();
}

// ==========================================
// new address (ADD)
// ==========================================

if(isset($_POST['action']) && $_POST['action'] == 'add_new_address'){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $locality = mysqli_real_escape_string($conn, $_POST['locality']);
    $address_line1 = mysqli_real_escape_string($conn, $_POST['address_line1']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $type = mysqli_real_escape_string($conn, $_POST['address_type']);
    $aid = $_POST['address_id'];
    if(!empty($aid)){
        $sql = "UPDATE `user_address` SET `name`='$name', `phone`='$phone', `pincode`='$pincode', `locality`='$locality', 
                `address_line1`='$address_line1', `state`='$state', `address_type`='$type' WHERE `id`='$aid' AND `user_id`='$user_id'";
    }else{
        $sql = "INSERT INTO `user_address` (`user_id`, `name`, `phone`, `pincode`, `locality`, `address_line1`, `state`, `address_type`) 
                VALUES ('$user_id', '$name', '$phone', '$pincode', '$locality', '$address_line1', '$state', '$type')";
    }
    //select the newly added address 
    $result = mysqli_query($conn, $sql);
    if($result){
        echo "success";
    }else{
        echo "error";
    }
    exit();
}

// ==========================================
// 4. DELETE ADDRESS
// ==========================================

if(isset($_POST['action']) && $_POST['action'] == 'delete_address'){
    $del_id = $_POST['del_id'];

    $sql = "DELETE FROM `user_address` WHERE `id`='$del_id' AND `user_id`='$user_id'";
    if(mysqli_query($conn, $sql)){
        if(isset($_SESSION['active_address_id']) && $_SESSION['active_address_id'] == $del_id){
            unset($_SESSION['active_address_id']);
        }
        echo "success";
    }else{
        echo "error";
    }
    exit();
}

?>