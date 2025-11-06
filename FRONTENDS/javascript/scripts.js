// scripts.js - global behavior: active nav, carousel init, cart counter (session-free)
document.addEventListener('DOMContentLoaded', function(){
  // Active nav link
  const links = document.querySelectorAll('.navbar .nav-link');
  links.forEach(a => {
    const href = a.getAttribute('href');
    if(href && location.pathname.endsWith(href)) {
      a.classList.add('active');
    }
  });

  // Simple carousel auto start (Bootstrap handled via data attributes)
  // Cart count (front-only, stored in localStorage for persistence between pages)
  const cartCountEl = document.getElementById('globalCartCount');
  let count = parseInt(localStorage.getItem('cartCount') || '0');
  if(cartCountEl) cartCountEl.textContent = count;

  document.body.addEventListener('click', function(e){
    if(e.target.matches('.btn-add-cart')){
      count++;
      localStorage.setItem('cartCount', String(count));
      if(cartCountEl) cartCountEl.textContent = count;
      // show simple toast
      const toast = document.createElement('div');
      toast.className = 'toast align-items-center show';
      toast.style.position='fixed'; toast.style.right='18px'; toast.style.bottom='18px'; toast.style.zIndex=2000;
      toast.innerHTML = '<div class="d-flex"><div class="toast-body">Producto agregado al carrito</div></div>';
      document.body.appendChild(toast);
      setTimeout(()=> toast.remove(),1600);
    }
  });
});