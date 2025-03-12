//contact-us.js
$(document).ready(function () {

  const form = document.getElementById('contact-form');
  //on submit, POST to web3Forms and get response
  form.addEventListener('submit', function (e) {
    e.preventDefault();
    const formData = new FormData(form);
    const object = Object.fromEntries(formData);
    const json = JSON.stringify(object);
    const notyf = new Notyf({ position: { x: 'right', y: 'top' }, duration: 4000 });
    //fetch result
    fetch('https://api.web3forms.com/submit', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: json
    })
      .then(async (response) => {//show response
        let json = await response.json();
        console.log(json);
        if (response.status == 200) {
          notyf.success("Mail sent successfully!")
        } else {
          notyf.error("Failed to send mail")
        }
      })
      .catch(error => {//show error
        console.log(error);
        notyf.error("Something went wrong!");
      })
      .then(function () {//reset form
        form.reset();
      });
  });
});