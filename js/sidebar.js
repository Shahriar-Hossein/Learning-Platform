function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('overlay');
  sidebar.classList.toggle('sidebar-hidden');
  overlay.classList.toggle('hidden');
}

function toggleDropdown(event, dropdownId) {
  event.stopPropagation();
  const dropdown = document.getElementById(dropdownId);
  const isVisible = dropdown.classList.contains('hidden');
  document.querySelectorAll('.dropdown-content').forEach(el => el.classList.add('hidden'));
  dropdown.classList.toggle('hidden', !isVisible);
}

document.addEventListener('click', function(event) {
  if (!event.target.matches('.dropdown-content, .dropdown-content *')) {
    document.querySelectorAll('.dropdown-content').forEach(el => el.classList.add('hidden'));
  }
});

// Swiper initialization
var swiper = new Swiper('#testimonial-slider', {
  slidesPerView: 1,
  spaceBetween: 30,
  loop: true,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
  breakpoints: {
    640: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
    },
    1024: {
      slidesPerView: 3,
    },
  }
});
