<?php
include('./dbConnection.php');

const TITLE = "Maria's School";
const PAGE = "Maria's School";
const DIRECTORY = "";

include(DIRECTORY . 'mainInclude/navbar.php');
?>

<div class="bg-violet-300"> 
  <!-- Start Course Page Banner -->
  <div class="relative">
    <img src="./image/coursebanner.jpg" alt="courses" class="w-full h-[300px] object-cover shadow-md"/>
  </div> 
  <!-- End Course Page Banner -->
</div>

<div class="container mx-auto my-8">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Login Section -->
    <div class="p-6 bg-white shadow-lg rounded-lg">
      <h5 class="text-2xl font-semibold text-violet-600 mb-6">If Already Registered, Login</h5>
      <form id="stuLoginForm">
        <div class="mb-4">
          <label for="stuLogEmail" class="block text-gray-700 font-medium mb-2">Email</label>
          <input type="email" id="stuLogEmail" name="stuLogEmail" placeholder="Email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500">
        </div>
        <div class="mb-6">
          <label for="stuLogPass" class="block text-gray-700 font-medium mb-2">Password</label>
          <input type="password" id="stuLogPass" name="stuLogPass" placeholder="Password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500">
        </div>
        <button type="button" class="bg-violet-600 text-white px-6 py-2 rounded-md hover:bg-violet-700" id="stuLoginBtn" onclick="checkStuLogin()">Login</button>
        <small id="statusLogMsg" class="block text-red-500 mt-2"></small>
      </form>
    </div>

    <!-- Signup Section -->
    <div class="p-6 bg-white shadow-lg rounded-lg">
      <h5 class="text-2xl font-semibold text-violet-600 mb-6">New User, Sign Up</h5>
      <form id="stuRegForm">
        <div class="mb-4">
          <label for="stuname" class="block text-gray-700 font-medium mb-2">Name</label>
          <input type="text" id="stuname" name="stuname" placeholder="Name" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500">
        </div>
        <div class="mb-4">
          <label for="stuemail" class="block text-gray-700 font-medium mb-2">Email</label>
          <input type="email" id="stuemail" name="stuemail" placeholder="Email" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500">
          <small class="block text-gray-500 mt-1">We'll never share your email with anyone else.</small>
        </div>
        <div class="mb-6">
          <label for="stupass" class="block text-gray-700 font-medium mb-2">New Password</label>
          <input type="password" id="stupass" name="stupass" placeholder="Password" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-violet-500">
        </div>
        <button type="button" class="bg-violet-600 text-white px-6 py-2 rounded-md hover:bg-violet-700" id="signup" onclick="addStu()">Sign Up</button>
        <small id="successMsg" class="block text-green-500 mt-2"></small>
      </form>
    </div>
  </div>
</div>

<?php 
// Footer Section
include(DIRECTORY . 'mainInclude/footer.php'); 
?>
