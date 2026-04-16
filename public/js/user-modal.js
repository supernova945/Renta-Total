document.getElementById('userForm')?.addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);
  fetch(`${baseUrl}/usuarios/ajax-add`, {
    method: "POST",
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'ok') {
        alert(data.message);
        document.getElementById('userForm').reset();
        document.getElementById('addUserModal')?.classList.add('hidden');
      } else {
        alert("Error al agregar usuario.");
      }
    })
    .catch(err => {
      console.error(err);
      alert("Error en el servidor.");
    });
});

document.getElementById('addUserButton')?.addEventListener('click', () => {
  document.getElementById('addUserModal')?.classList.remove('hidden');
});

document.getElementById('closeModalButton')?.addEventListener('click', () => {
  document.getElementById('addUserModal')?.classList.add('hidden');
});

document.getElementById('cancelAddUser')?.addEventListener('click', () => {
  document.getElementById('addUserModal')?.classList.add('hidden');
});

