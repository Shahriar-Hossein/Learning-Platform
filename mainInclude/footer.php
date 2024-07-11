 <!-- Start Footer -->
 <footer class="container-fluid bg-dark text-center p-2">
    <small class="text-white">Copyright &copy; 2024 || Designed By E-Learning || <?php   
          
    ?>
  </small> 
  
 </footer> <!-- End Footer -->

    <!-- Start Student Registration Modal -->
    <div class="modal fade" id="stuRegModalCenter" tabindex="-1" role="dialog" aria-labelledby="stuRegModalCenterTitle" aria-hidden="true" >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="stuRegModalCenterTitle">Student Registration</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearAllStuReg()">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!--Start Form Registration-->
            <?php include('studentRegistration.php'); ?>
            <!-- End Form Registration -->
          </div>
        </div>
      </div>
    </div> <!-- End Student Registration Modal -->


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
                     echo '<a href="admin/adminDashboard.php" class="btn btn-link">Admin Dashboard</a> <a href="logout.php" class="btn btn-link">Logout</a>';
                 } else {
                     echo '<a href="#login" data-toggle="modal" data-target="#adminLoginModalCenter" class="btn btn-link">Admin Login</a>';
                 }
                 ?>
             </div>
         </div>
     </div>
 </div>
 <!-- End Student Login Modal -->


  <!-- Start Admin Login Modal -->
  <div class="modal fade" id="adminLoginModalCenter" tabindex="-1" role="dialog" aria-labelledby="adminLoginModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="adminLoginModalCenterTitle">Admin Login</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="clearAdminLoginWithStatus()">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form role="form" id="adminLoginForm">
              <div class="form-group">
                <i class="fas fa-envelope"></i><label for="adminLogEmail" class="pl-2 font-weight-bold">Email</label><input type="email"
                    class="form-control" placeholder="Email" name="adminLogEmail" id="adminLogEmail">
                </div>
                <div class="form-group">
                  <i class="fas fa-key"></i><label for="adminLogPass" class="pl-2 font-weight-bold">Password</label><input type="password" class="form-control" placeholder="Password" name="adminLogPass" id="adminLogPass">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <small id="statusAdminLogMsg"></small>
            <button type="button" class="btn btn-primary" id="adminLoginBtn" onclick="checkAdminLogin()">Login</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="clearAdminLoginWithStatus()">Cancel</button>
          </div>
        </div>
      </div>
    </div> <!-- End Admin Login Modal -->

    <!-- Jquery and Boostrap JavaScript -->
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>

    <!-- Font Awesome JS -->
    <script type="text/javascript" src="js/all.min.js"></script>

    <!-- Student Testimonial Owl Slider JS  -->
    <script type="text/javascript" src="js/owl.min.js"></script>
    <script type="text/javascript" src="js/testyslider.js"></script>

    <!-- Student Ajax Call JavaScript -->
    <script type="text/javascript" src="js/ajaxrequest.js"></script>

    <!-- Admin Ajax Call JavaScript -->
    <script type="text/javascript" src="js/adminajaxrequest.js"></script>

    <!-- Custom JavaScript -->
    <script type="text/javascript" src="js/custom.js"></script>
    <script>
     $(document).ready(function() {
         $('#stuRegModalCenter').on('hide.bs.modal', function (e) {
             // logged for debugging
             // console.log('Modal is about to be hidden');
             clearAllStuReg();
         });
         $('#stuLoginModalCenter').on('hide.bs.modal', function (e) {
             // logged for debugging
             // console.log('Modal is about to be hidden');
             clearStuLoginWithStatus();
         });
     });
    </script>


 <style>

 </style>
  </body>

</html>