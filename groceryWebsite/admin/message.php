<?php
session_start();
include '../partials/_dbconnect.php';
include 'components/_sidebar.php';
?>

<div class="container-fluid px-4 mt-4 mb-5">
    <h2 class="mb-4 fw-bold">Customer Messages Inbox</h2>
    
    <div class="row mb-4">
        <div class="col-md-8 col-lg-6">
            <div class="input-group shadow-sm">
                <input type="text" id="searchMsgInput" class="form-control" placeholder="Search by Mail ID, Name or Subject...">
                <select id="statusFilter" class="form-select bg-light" style="max-width: 150px; cursor: pointer;">
                    <option value="All">All Status</option>
                    <option value="Replied">Replied</option>
                    <option value="Reply">Not Replied Yet</option>
                </select>
            </div>
        </div>
    </div>



    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th class="px-4 py-3">S.No.</th>
                            <th class="py-3">Name</th>
                            <th class="py-3">Email</th>
                            <th class="py-3">Subject</th>
                            <th class="py-3">Message (Preview)</th>
                            <th class="py-3">Date</th>
                            <th class="px-4 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM message_customer");
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $sno = $row['sno'];
                                $name = $row['name'];
                                $email = $row['email'];
                                $subject = $row['subject'];
                                $message = substr($row['message'], 0, 20);
                                $dot = (strlen($row['message']) > 16) ? '...' : '';
                                $status = $row['status'];
                                echo '
                                    <tr>
                                        <td class="px-4">'.$sno.'</td>
                                        <td class="fw-medium">'.$name.'</td>
                                        <td>'.$email.'</td>
                                        <td>'.$subject.'</td>
                                        <td class="text-truncate" style="max-width: 250px;">'.$message.''.$dot.'</td>
                                        <td>2026-02-24</td>
                                        <td class="px-4 text-center">';
                                        if($status == 1){
                                            echo '
                                            <button class="btn btn-success btn-sm disabled">
                                                <i class="bi bi-check-circle"></i> Replied
                                            </button>';
                                        }else{
                                            echo '
                                            <button id="btn-'.$sno.'" type="button" msg-text="'.htmlspecialchars($row['message']).'" msg-sno="'.$sno.'" msg-name="'.$name.'"
                                            class="btn reply-btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#replyModal">
                                                Reply
                                            </button>
                                            ';
                                        }
                                        echo
                                        '
                                        </td>
                                    </tr>
                                ';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" id="replyModalLabel">Reply to Message #1 (John Doe)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                
                <div class="mb-4 p-3 rounded" style="background-color: #f8f9fa; border-left: 4px solid #0d5c25;">
                    <label class="fw-bold mb-1 text-secondary">Original Message:</label>
                    <p class="mb-0 text-dark" id="fullMsg">Hi, I was wondering if you have organic apples in stock right now?</p>
                </div>

                <form id="adminReplyForm">
                    <div class="mb-3">
                        <label for="replyMessage" class="form-label fw-bold">Your Reply Message</label>
                        <input type="hidden" id="hidden_sno" name="sno">
                        <textarea class="form-control bg-light" name="replyMessage" rows="6" placeholder="Type your reply here..." required></textarea>
                    </div>
                </form>

            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="adminReplyForm" class="btn text-white px-4" style="background-color: #0d5c25;">Send Reply</button>
            </div>
        </div>
    </div>
</div>
<script src="javascripts/message.js"></script>
<?php include 'components/_footer.php' ?>