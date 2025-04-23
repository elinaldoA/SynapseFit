require('./bootstrap');
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function () {
      navigator.serviceWorker.register('/service-worker.js')
        .then(function (registration) {
          console.log('[SW] Registrado com sucesso:', registration);
        })
        .catch(function (error) {
          console.log('[SW] Erro no registro:', error);
        });
    });
  }
