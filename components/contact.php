
<!-- <script type="text/javascript" src="js/contact-us.js"></script> -->
<!-- Start Contact Us -->
<div class="container mx-auto pt-20 mt-10" id="Contact"> <!-- Start Contact Us Container -->
  <h2 class="text-center text-4xl font-extrabold text-violet-700 mb-8">Contact Us</h2> <!-- Contact Us Heading -->
  <div class="flex flex-wrap -mx-4"> <!-- Start Contact Us Row -->
    <div class="w-full md:w-2/3 px-4 mb-8 md:mb-0"> <!-- Start Contact Us 1st Column -->
      <form id="contact-form"  method="post" class="bg-white p-6 rounded-lg shadow-lg space-y-6">
      <!-- action="https://api.web3forms.com/submit"   -->
        <input type="hidden" name="access_key" value="327fee2f-fbfb-4b1b-891b-c013f15c640c">
        <input type="text" name="name" required placeholder="Name" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
        <input type="text" name="subject" required placeholder="Subject" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
        <input type="email" name="email" required placeholder="E-mail" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500">
        <textarea name="message" required placeholder="How can we help you?" class="form-control w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-violet-500" style="height:150px;"></textarea>
        <!-- Honeypot Spam Protection -->
        <input type="checkbox" name="botcheck" class="hidden" style="display: none;">

        <!-- Custom Confirmation / Success Page -->
        <!-- <input type="hidden" name="redirect" value="https://localhost/lms/index.php?contact=success"> -->

        <!-- <input type="submit" value="Send" name="submit" class="w-full bg-violet-600 hover:bg-violet-700 text-white font-bold py-3 rounded-lg transition duration-150 hover:cursor-pointer"> -->
        <div class="w-full bg-violet-600 hover:bg-violet-700 text-white font-bold py-3 rounded-lg transition duration-150 hover:cursor-pointer">
          <button type="submit" class="w-full bg-violet-600 hover:bg-violet-700 text-white font-bold py-3 rounded-lg transition duration-150 hover:cursor-pointer"> Submit </button>
        </div>
        <!--Response-->
      </form>
    </div> <!-- End Contact Us 1st Column -->

    <div class="w-full md:w-1/3 px-4 flex flex-col items-center justify-center text-white bg-violet-700 rounded-lg p-6 shadow-lg"> <!-- Start Contact Us 2nd Column -->
      <h4 class="text-2xl font-extrabold mb-4">Maria's School Pvt Ltd</h4>
      <p class="text-center">
        Maria's School, <br>
        Mirpur-Shewrapara, <br>
        Dhaka - 1216<br>
        Phone: +00000000 <br>
        <a href="#" class="text-white underline">www.mariasschool.com</a>
      </p>
    </div> <!-- End Contact Us 2nd Column -->
  </div> <!-- End Contact Us Row -->
</div>
<!-- End Contact Us Container -->
<!-- End Contact Us -->

  