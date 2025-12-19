document.addEventListener('DOMContentLoaded', function(){
  const forms = document.querySelectorAll('form');
  forms.forEach(f => {
    f.addEventListener('submit', function(e){
      const name = f.querySelector('input[name="name"]');
      if (name && name.value.trim().length < 2) {
        e.preventDefault();
        alert('Veuillez indiquer un nom valide.');
      }
    });
  });
});
