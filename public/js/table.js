document.addEventListener('DOMContentLoaded', function () {
      
      bindUserActionButtons();
      bindDeleteButtons();
      
      // Mobile menu toggle
      const mobileMenuButton = document.getElementById('mobileMenuButton');
      const mobileMenu = document.getElementById('mobileMenu');
      if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function () {
          mobileMenu.classList.toggle('hidden');
        });
      }

      // Mobile dropdowns
      const mobileDropdowns = document.querySelectorAll('.mobile-dropdown');
      mobileDropdowns.forEach(dropdown => {
        const button = dropdown.querySelector('button');
        const content = dropdown.querySelector('div');
        if (button && content) {
          button.addEventListener('click', function () {
            content.classList.toggle('hidden');
            const icon = button.querySelector('i.ri-arrow-down-s-line');
            if (icon) {
              icon.classList.toggle('ri-arrow-down-s-line');
              icon.classList.toggle('ri-arrow-up-s-line');
            }
          });
        }
      });
     });    

  

function bindUserActionButtons() {

  //Ver usuarios

  document.querySelectorAll('.view-user').forEach(button => {
    button.addEventListener('click', function () {
      const userId = this.getAttribute('data-user-id');
      
      fetch(`${baseUrl}/usuarios/show/${userId}`)
        .then(response => {
          if (!response.ok) throw new Error('Usuario no encontrado');
          return response.json();
        })
        .then(user => {
          document.getElementById('detailName').textContent = user.nombre;
          document.getElementById('detailRole').textContent = user.rol;
          document.getElementById('detailEmail').textContent = user.correo;
          document.getElementById('detailPhone').textContent = user.dui;
          document.getElementById('detailLastLogin').textContent = user.last_login ?? 'No registrado';
          document.getElementById('detailRegistration').textContent = user.created_at ?? 'Desconocida';
          document.getElementById('userDetailModal').classList.remove('hidden');
        
          document.getElementById('editUserButton').setAttribute('data-user-id', user.idusuario);
        })
        .catch(() => {
          alert('Error al cargar el usuario');
        });
    });
  });

  //Eliminar usuario

  document.querySelectorAll('.delete-user').forEach(button => {
  button.addEventListener('click', function () {
    const userId = this.getAttribute('data-user-id');
    if (confirm('¿Estás seguro que deseas eliminar este usuario?')) {
      fetch(`${baseUrl}/usuarios/delete/${userId}`, {
        method: 'DELETE',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(response => {
        if (!response.ok) throw new Error('Error al eliminar usuario');
        return response.json();
      })
      .then(data => {
        alert('Usuario eliminado exitosamente');
        location.reload(); // Actualizar tabla
      })
      .catch(() => alert('Error al eliminar usuario'));
    }
  });
  });

  //Botones de cerrar/cancelar

  document.getElementById('closeDetailModalButton')?.addEventListener('click', () => {
    document.getElementById('userDetailModal').classList.add('hidden');
  });

  document.getElementById('closeDetailButton')?.addEventListener('click', () => {
    document.getElementById('userDetailModal').classList.add('hidden');
  });

  //Editar

  document.getElementById('editUserButton')?.addEventListener('click', () => {
  const userId = document.getElementById('editUserButton').getAttribute('data-user-id');

  fetch(`${baseUrl}/usuarios/show/${userId}`)
    .then(response => {
      if (!response.ok) throw new Error('Usuario no encontrado');
      return response.json();
    })
    .then(user => {
      document.getElementById('editUserId').value = user.idusuario;
      document.getElementById('editNombre').value = user.nombre;
      document.getElementById('editUsuario').value = user.user;
      document.getElementById('editCorreo').value = user.correo;
      document.getElementById('editDui').value = user.dui;
      document.getElementById('editRol').value = user.rol;
      document.getElementById('editEstado').value = user.estado ? '1' : '0';

      document.getElementById('userDetailModal').classList.add('hidden');
      document.getElementById('editUserModal').classList.remove('hidden');
    })
    .catch(err => {
      alert('No se pudo cargar el usuario.');
      console.error(err);
    });
});

}



    

  

