<!-- Start Student Login Modal -->
<div class="modal fade" id="stuLoginModalCenter" tabindex="-1" role="dialog" aria-labelledby="stuLoginModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stuLoginModalCenterTitle">Student Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearStuLoginWithStatus()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="stuLoginForm">
                    <div class="form-group">
                        <label for="stuLogEmail" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email
                            <small id="statusLogMsg1" class="text-muted"></small>
                        </label>
                        <input type="email" class="form-control" placeholder="Enter your email" name="stuLogEmail" id="stuLogEmail">
                    </div>
                    <div class="form-group">
                        <label for="stuLogPass" class="form-label">
                            <i class="fas fa-key me-2"></i>Password
                        </label>
                        <input type="password" class="form-control" placeholder="Enter your password" name="stuLogPass" id="stuLogPass">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <small id="statusLogMsg" class="text-muted me-auto"></small>
                <button type="button" class="btn btn-primary" id="stuLoginBtn" onclick="checkStuLogin()">Login</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearStuLoginWithStatus()">Cancel</button>
            </div>
            <div class="mt-3 text-center">
                <?php
                if (isset($_SESSION['is_admin_login'])) {
                    echo '<a href="admin/adminDashboard.php" class="btn btn-link text-violet-400 hover:underline">Admin Dashboard</a> <a href="logout.php" class="btn btn-link text-violet-400 hover:underline">Logout</a>';
                } else {
                    echo '<a href="#login" data-toggle="modal" data-target="#adminLoginModalCenter" class="btn btn-link text-violet-400 hover:underline">Admin Login</a>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- End Student Login Modal -->