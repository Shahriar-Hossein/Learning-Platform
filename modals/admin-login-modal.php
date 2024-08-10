<!-- Start Admin Login Modal -->
<div class="modal fade" id="adminLoginModalCenter" tabindex="-1" role="dialog" aria-labelledby="adminLoginModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adminLoginModalCenterTitle">Admin Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearAdminLoginWithStatus()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" id="adminLoginForm">
                    <div class="form-group">
                        <i class="fas fa-envelope"></i>
                        <label for="adminLogEmail" class="pl-2 font-weight-bold">Email</label>
                        <input type="email" class="form-control" placeholder="Email" name="adminLogEmail" id="adminLogEmail">
                    </div>
                    <div class="form-group">
                        <i class="fas fa-key"></i>
                        <label for="adminLogPass" class="pl-2 font-weight-bold">Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="adminLogPass" id="adminLogPass">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <small id="statusAdminLogMsg"></small>
                <button type="button" class="btn btn-primary" id="adminLoginBtn" onclick="checkAdminLogin()">Login</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="clearAdminLoginWithStatus()">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- End Admin Login Modal -->