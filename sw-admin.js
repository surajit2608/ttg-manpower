const NAME = 'MPWV1.0.0';
const ASSETS_V = '1.0.0';
const OFFLINE = '/utility/offline';
const ASSETS = [
  OFFLINE,

  '/assets/css/flexboxgrid.min.css?v='+ASSETS_V,
  '/assets/css/icomoon.css?v='+ASSETS_V,
  '/assets/css/app.css?v='+ASSETS_V,
  '/assets/css/sidebar.css?v='+ASSETS_V,
  '/assets/css/theme.css?v='+ASSETS_V,
  '/assets/css/cropper.min.css?v='+ASSETS_V,
  '/assets/css/responsive.css?v='+ASSETS_V,

  '/assets/js/jquery.min.js?v='+ASSETS_V,
  '/assets/js/cropper.min.js?v='+ASSETS_V,
  '/assets/js/framework.min.js?v='+ASSETS_V,
  '/assets/js/app.min.js?v='+ASSETS_V,
  '/assets/js/register-admin-sw.js?v='+ASSETS_V,

  '/assets/fonts/baskervville/Baskervville-Regular.ttf',

  '/assets/fonts/icomoon/icomoon.eot',
  '/assets/fonts/icomoon/icomoon.svg',
  '/assets/fonts/icomoon/icomoon.ttf',
  '/assets/fonts/icomoon/icomoon.woff',

  '/assets/fonts/rubik/Rubik-Bold.ttf',
  '/assets/fonts/rubik/Rubik-Light.ttf',
  '/assets/fonts/rubik/Rubik-Medium.ttf',
  '/assets/fonts/rubik/Rubik-Regular.ttf',

  '/assets/fonts/saira/Saira-Black.ttf',
  '/assets/fonts/saira/Saira-Bold.ttf',
  '/assets/fonts/saira/Saira-ExtraBold.ttf',
  '/assets/fonts/saira/Saira-ExtraLight.ttf',
  '/assets/fonts/saira/Saira-Light.ttf',
  '/assets/fonts/saira/Saira-Medium.ttf',
  '/assets/fonts/saira/Saira-Regular.ttf',
  '/assets/fonts/saira/Saira-Thin.ttf',

  '/assets/images/logo.png',
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(NAME).then(cache => {
      return cache.addAll(ASSETS);
    })
  );
});

self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys => {
      return Promise.all(
        keys.filter(key => {
          return !key.startsWith(NAME);
        })
        .map(key => {
          return caches.delete(key);
        })
      );
    })
    .then(async () => {
      if('navigationPreload' in self.registration){
        await self.registration.navigationPreload.enable();
      }
    })
  );

  self.clients.claim();
});

self.addEventListener('fetch', event => {
  if(event.request.mode === 'navigate'){
    event.respondWith(
      (async () => {
        try{
          const preloadResponse = await event.preloadResponse;
          if(preloadResponse){
            return preloadResponse;
          }

          const networkResponse = await fetch(event.request);
          return networkResponse;
        }catch(error){
          const cache = await caches.open(NAME);
          const cachedResponse = await cache.match(OFFLINE);
          return cachedResponse;
        }
      })()
    );
  }else{
    event.respondWith(
      (async () => {
        const cache = await caches.open(NAME);
        const cachedResponse = await cache.match(event.request);
        return cachedResponse || fetch(event.request);
      })()
    );
  }
});

self.addEventListener('message', event => {
  if(event.data === 'skipWaiting'){
    self.skipWaiting();
  }
});
