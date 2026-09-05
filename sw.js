self.addEventListener("install", (event) => {
  self.skipWaiting();
});

self.addEventListener("activate", (event) => {
  event.waitUntil(self.clients.claim());
});

// Tämä palauttaa kaiken suoraan verkosta, ei cachea mitään
self.addEventListener("fetch", (event) => {
  event.respondWith(fetch(event.request));
});

