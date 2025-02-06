<form role="form" id="stuRegForm">
    <div class="form-group mb-3">
        <label for="stuname" class="form-label">
            <i class="fas fa-user me-2"></i>Name
            <small id="statusMsg1" class="text-muted"></small>
        </label>
        <input type="text" class="form-control" placeholder="Enter your name" name="stuname" id="stuname">
    </div>
    <div class="form-group mb-3">
        <label for="stuemail" class="form-label">
            <i class="fas fa-envelope me-2"></i>Email
            <small id="statusMsg2" class="text-muted"></small>
        </label>
        <input type="email" class="form-control" placeholder="Enter your email" name="stuemail" id="stuemail">
        <small class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group mb-3">
        <label for="stupass" class="form-label">
            <i class="fas fa-key me-2"></i>New Password
            <small id="statusMsg3" class="text-muted"></small>
        </label>
        <input type="password" class="form-control" placeholder="Enter your password" name="stupass" id="stupass">
    </div>
    <button type="submit" class="btn btn-primary w-100 mt-3" id="signup" onclick="addStu()">Register</button>
</form>

<!-- Add some basic styles for better visuals -->
<style>
    .form-group {
        position: relative;
    }
    .form-label {
        font-weight: bold;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #004085;
    }
    .form-text {
        font-size: 0.875rem;
    }
    .p-4 {
        padding: 1.5rem;
    }
    .mb-3 {
        margin-bottom: 1rem;
    }
    .me-2 {
        margin-right: 0.5rem;
    }
    .w-100 {
        width: 100%;
    }
    .mt-3 {
        margin-top: 1rem;
    }
</style>
