<script>
// Notification functions
function initializeNotifications() {
  // Load initial notification count
  updateNotificationCount();

  // Set up periodic updates every 5 minutes
  setInterval(updateNotificationCount, 300000);

  // Handle notification button click
  const notificationButton = document.getElementById('notificationButton');
  const notificationDropdown = document.getElementById('notificationDropdown');

  if (notificationButton && notificationDropdown) {
    notificationButton.addEventListener('click', (e) => {
      e.stopPropagation();
      toggleNotificationDropdown();
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!notificationButton.contains(e.target) && !notificationDropdown.contains(e.target)) {
        hideNotificationDropdown();
      }
    });
  }
}

function updateNotificationCount() {
  // Fetch both lease and service notifications, plus activity notifications
  Promise.all([
    fetch('<?= base_url('rentas/expiring-count') ?>', {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      }
    }),
    fetch('<?= base_url('servicios/upcoming-count') ?>', {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      }
    }),
    fetch('<?= base_url('notifications/count') ?>', {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      }
    })
  ])
  .then(responses => Promise.all(responses.map(r => r.json())))
  .then(data => {
    const badge = document.getElementById('notificationBadge');
    const leaseCount = (data[0] && typeof data[0].count === 'number') ? data[0].count : 0;
    const serviceCount = (data[1] && typeof data[1].count === 'number') ? data[1].count : 0;
    const activityCount = (data[2] && typeof data[2].count === 'number') ? data[2].count : 0;
    const totalCount = leaseCount + serviceCount + activityCount;

    if (badge) {
      if (totalCount > 0) {
        badge.textContent = totalCount > 99 ? '99+' : totalCount;
        badge.classList.remove('hidden');
      } else {
        badge.classList.add('hidden');
      }
    }
  })
  .catch(error => {
    console.error('Error updating notification count:', error);
  });
}

function toggleNotificationDropdown() {
  const dropdown = document.getElementById('notificationDropdown');

  if (dropdown) {
    if (dropdown.classList.contains('opacity-0')) {
      showNotificationDropdown();
    } else {
      hideNotificationDropdown();
    }
  }
}

function showNotificationDropdown() {
  const dropdown = document.getElementById('notificationDropdown');
  if (dropdown) {
    dropdown.classList.remove('opacity-0', 'invisible');
    dropdown.classList.add('opacity-100', 'visible');

    // Load notification list
    loadNotificationList();
  }
}

function hideNotificationDropdown() {
  const dropdown = document.getElementById('notificationDropdown');
  if (dropdown) {
    dropdown.classList.remove('opacity-100', 'visible');
    dropdown.classList.add('opacity-0', 'invisible');
  }
}

function loadNotificationList() {
  const notificationList = document.getElementById('notificationList');

  if (!notificationList) return;

  // Show loading
  notificationList.innerHTML = '<div class="text-center py-4 text-gray-500 text-sm"><i class="ri-loader-4-line animate-spin text-xl"></i><p>Cargando...</p></div>';

  // Fetch lease, service, and activity notifications
  Promise.all([
    fetch('<?= base_url('rentas/expiring-leases') ?>', {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      }
    }),
    fetch('<?= base_url('servicios/upcoming-services') ?>', {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      }
    }),
    fetch('<?= base_url('notifications/list') ?>', {
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
      }
    })
  ])
  .then(responses => Promise.all(responses.map(r => r.json())))
  .then(data => {
    const leaseNotifications = Array.isArray(data[0]) ? data[0] : [];
    const serviceNotifications = Array.isArray(data[1]) ? data[1] : [];
    const activityNotifications = Array.isArray(data[2]) ? data[2] : [];
    const allNotifications = [...leaseNotifications, ...serviceNotifications, ...activityNotifications];

    if (allNotifications && allNotifications.length > 0) {
      renderNotificationList(allNotifications);
    } else {
      notificationList.innerHTML = '<div class="text-center py-4 text-gray-500 text-sm"><i class="ri-notification-off-line text-2xl mb-2"></i><p>No hay notificaciones</p></div>';
    }
  })
  .catch(error => {
    console.error('Error loading notifications:', error);
    notificationList.innerHTML = '<div class="text-center py-4 text-red-500 text-sm"><i class="ri-error-warning-line text-xl mb-2"></i><p>Error al cargar notificaciones</p></div>';
  });
}

function renderNotificationList(notifications) {
  const notificationList = document.getElementById('notificationList');
  if (!notificationList) return;

  let html = '';

  // Separate activity notifications from time-based notifications
  const activityNotifications = notifications.filter(n => n.type && (n.type === 'motorcycle' || n.type === 'service' || n.type === 'rental' || n.type === 'activity'));
  const timeBasedNotifications = notifications.filter(n => !n.type || (n.type !== 'motorcycle' && n.type !== 'service' && n.type !== 'rental' && n.type !== 'activity'));

  // Sort time-based notifications by date (earliest first)
  timeBasedNotifications.sort((a, b) => {
    let dateA, dateB;

    if (a.fecha_renovacion) { // Lease notification
      dateA = new Date(a.fecha_renovacion);
    } else if (a.fecha_completado) { // Service with completion date
      dateA = new Date(a.fecha_completado);
    } else if (a.fecha_inicio) { // Service with start date
      dateA = new Date(a.fecha_inicio);
    } else { // Service with request date
      dateA = new Date(a.fecha_solicitud);
    }

    if (b.fecha_renovacion) { // Lease notification
      dateB = new Date(b.fecha_renovacion);
    } else if (b.fecha_completado) { // Service with completion date
      dateB = new Date(b.fecha_completado);
    } else if (b.fecha_inicio) { // Service with start date
      dateB = new Date(b.fecha_inicio);
    } else { // Service with request date
      dateB = new Date(b.fecha_solicitud);
    }

    return dateA - dateB;
  });

  // Sort activity notifications by creation date (newest first)
  activityNotifications.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

  // Combine notifications: time-based first, then activity
  const sortedNotifications = [...timeBasedNotifications, ...activityNotifications];

  sortedNotifications.forEach(notification => {
    // Check if this is an activity notification (our new format)
    if (notification.type === 'activity') {
      // Our new activity notifications
      let linkUrl = '<?= base_url('activity-log') ?>';

      let iconClass = 'ri-information-line text-blue-600';

      if (notification.title.includes('Nuevo') || notification.title.includes('Agregada') || notification.title.includes('Creado')) {
        iconClass = 'ri-add-circle-line text-green-600';
      } else if (notification.title.includes('Modificada') || notification.title.includes('Actualizada')) {
        iconClass = 'ri-edit-line text-yellow-600';
      } else if (notification.title.includes('Eliminada')) {
        iconClass = 'ri-delete-bin-line text-red-600';
      }

      html += `
        <div class="p-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer" onclick="window.location.href='${linkUrl}'">
          <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
              <i class="${iconClass} text-lg"></i>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-gray-900">
                ${notification.title}
              </p>
              <p class="text-xs text-gray-600 mt-1">
                ${notification.message}
              </p>
              <p class="text-xs text-gray-500 mt-1">
                ${notification.relative_time}
              </p>
            </div>
          </div>
        </div>
      `;
    } else if (notification.type && (notification.type === 'motorcycle' || notification.type === 'service' || notification.type === 'rental')) {
      // Legacy activity notifications (old format)
      let linkUrl = '#';
      if (notification.type === 'service') {
        linkUrl = '<?= base_url('servicios/') ?>';
      } else if (notification.type === 'motorcycle' || notification.type === 'rental') {
        linkUrl = '<?= base_url('motocicleta/') ?>';
      }

      let iconClass = 'ri-information-line text-blue-600';

      if (notification.title.includes('Nuevo') || notification.title.includes('Agregada') || notification.title.includes('Creado')) {
        iconClass = 'ri-add-circle-line text-green-600';
      } else if (notification.title.includes('Modificada') || notification.title.includes('Actualizada')) {
        iconClass = 'ri-edit-line text-yellow-600';
      } else if (notification.title.includes('Eliminada')) {
        iconClass = 'ri-delete-bin-line text-red-600';
      }

      html += `
        <div class="p-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer" onclick="window.location.href='/activity-log'">
          <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
              <i class="${iconClass} text-lg"></i>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-gray-900">
                ${notification.title}
              </p>
              <p class="text-xs text-gray-600 mt-1">
                ${notification.message}
              </p>
              <p class="text-xs text-gray-500 mt-1">
                ${notification.relative_time}
              </p>
            </div>
          </div>
        </div>
      `;
    } else {
      // Time-based notification (lease or service) - always try to render with fallbacks
      let targetDate = new Date();
      let dateLabel = 'Notificación';
      let linkUrl = '/';
      let typeLabel = 'Sistema';
      let clientOrUser = '';
      let titleText = 'Notificación del sistema';
      let subtitleText = '';

      if (notification.fecha_renovacion && !isNaN(new Date(notification.fecha_renovacion).getTime())) {
        // Lease notification
        targetDate = new Date(notification.fecha_renovacion);
        dateLabel = 'Vence';
        linkUrl = '<?= base_url('rentas/') ?>';
        typeLabel = 'Renta';
        clientOrUser = `Cliente: ${notification.nombre_cliente || 'Desconocido'}`;
        titleText = `${notification.nombre_marca || ''} ${notification.modelo || ''}`.trim() || `Placa: ${notification.placa || notification.placa_motocicleta || 'N/A'}`;
        subtitleText = `Placa: ${notification.placa || notification.placa_motocicleta || 'N/A'}`;
      } else if ((notification.fecha_inicio && !notification.fecha_completado && !isNaN(new Date(notification.fecha_inicio).getTime())) ||
                 (notification.fecha_completado && !isNaN(new Date(notification.fecha_completado).getTime())) ||
                 (notification.fecha_solicitud && !isNaN(new Date(notification.fecha_solicitud).getTime()))) {
        // Service notification
        if (notification.fecha_inicio && !notification.fecha_completado && !isNaN(new Date(notification.fecha_inicio).getTime())) {
          targetDate = new Date(notification.fecha_inicio);
          dateLabel = 'Inicia';
          typeLabel = 'Servicio programado';
        } else if (notification.fecha_completado && !isNaN(new Date(notification.fecha_completado).getTime())) {
          targetDate = new Date(notification.fecha_completado);
          dateLabel = 'Finaliza';
          typeLabel = 'Servicio por completar';
        } else {
          targetDate = new Date(notification.fecha_solicitud || Date.now());
          dateLabel = 'Solicitado';
          typeLabel = 'Servicio solicitado';
        }

        linkUrl = '<?= base_url('servicios/') ?>';
        clientOrUser = `Técnico: ${notification.tecnico_responsable || 'Pendiente'}`;
        titleText = `${notification.nombre_marca || ''} ${notification.modelo || ''}`.trim() || notification.tipo_servicio || 'Servicio';
        subtitleText = notification.placa_motocicleta || notification.placa ? `Placa: ${notification.placa_motocicleta || notification.placa}` : '';
      } else {
        // Generic notification with minimal data
        linkUrl = '/';
        titleText = 'Notificación del sistema';
        typeLabel = 'Sistema';
        clientOrUser = 'Información general';
      }

      const today = new Date();
      const daysDiff = Math.ceil((targetDate - today) / (1000 * 60 * 60 * 24));

      let urgencyClass = 'text-yellow-600';
      let urgencyIcon = 'ri-time-line';

      if (daysDiff <= 1) {
        urgencyClass = 'text-red-600';
        urgencyIcon = 'ri-alarm-warning-line';
      } else if (daysDiff <= 3) {
        urgencyClass = 'text-orange-600';
        urgencyIcon = 'ri-alert-line';
      }

      html += `
        <div class="p-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer" onclick="window.location.href='${linkUrl}'">
          <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
              <i class="${urgencyIcon} ${urgencyClass} text-lg"></i>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-gray-900 truncate">
                ${titleText}
              </p>
              <p class="text-xs text-gray-500">
                ${subtitleText}
              </p>
              <p class="text-xs text-gray-500">
                ${typeLabel}: ${notification.tipo_servicio || typeLabel}
              </p>
              <p class="text-xs text-gray-500">
                ${clientOrUser}
              </p>
              <p class="text-xs ${urgencyClass} font-medium">
                ${dateLabel}: ${targetDate.toLocaleDateString('es-ES')} (${daysDiff} día${daysDiff !== 1 ? 's' : ''})
              </p>
            </div>
          </div>
        </div>
      `;
    }
  });

  notificationList.innerHTML = html;
}



// Initialize notifications when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
  initializeNotifications();
});
</script>
