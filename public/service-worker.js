self.addEventListener('install', (event) => {
    event.waitUntil(
      caches.open('v1').then((cache) => {
        return cache.addAll([
          '/',
          '/css/sb-admin-2.min.css',
          '/js/app.js',
          '/icons/icon-192.png',
          '/icons/icon-512.png',
          // Adicione outros recursos que deseja armazenar no cache
        ]);
      })
    );
  });

  self.addEventListener('fetch', (event) => {
    event.respondWith(
      caches.match(event.request).then((cachedResponse) => {
        return cachedResponse || fetch(event.request);
      })
    );
  });
