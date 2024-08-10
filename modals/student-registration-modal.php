<!-- Start Student Registration Modal -->
<div class="modal fade" id="stuRegModalCenter" tabindex="-1" role="dialog" aria-labelledby="stuRegModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stuRegModalCenterTitle">Student Registration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearAllStuReg()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Start Form Registration -->
                <?php include('studentRegistration.php'); ?>
                <!-- End Form Registration -->
            </div>
        </div>
    </div>
</div>
<!-- End Student Registration Modal -->
