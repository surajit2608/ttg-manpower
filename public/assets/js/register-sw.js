function showRefreshUI(registration) {
  let div = document.createElement('div');
  div.style.position = 'absolute';
  div.style.textAlign = 'center';
  div.style.bottom = '1rem';
  div.style.right = '1rem';
  div.style.left = '1rem';
  div.style.zIndex = 9999;

  let button = document.createElement('button');
  button.classList.add('btn', 'danger', 'box-shadow-3');
  button.textContent = 'New version available. Click to install';

  button.addEventListener('click', () => {
    if (!registration.waiting) {
      return;
    }

    button.disabled = true;
    registration.waiting.postMessage('skipWaiting');
  });

  div.appendChild(button);
  document.body.appendChild(div);
};

function onNewServiceWorker(registration, callback) {
  if (registration.waiting) {
    return callback();
  }

  function listenInstalledStateChange() {
    registration.installing.addEventListener('statechange', event => {
      if (event.target.state === 'installed') {
        callback();
      }
    });
  };

  if (registration.installing) {
    return listenInstalledStateChange();
  }

  registration.addEventListener('updatefound', listenInstalledStateChange);
}

window.addEventListener('load', () => {
  if ('serviceWorker' in navigator) {
    let refreshing;
    navigator.serviceWorker.addEventListener('controllerchange', event => {
      if (refreshing) return;
      refreshing = true;
      window.location.reload();
    });

    navigator.serviceWorker.register('/sw.js', { scope: '/' })
      .then(registration => {
        if (!navigator.serviceWorker.controller) {
          return;
        }
        registration.update();

        onNewServiceWorker(registration, () => {
          showRefreshUI(registration);
        });
      });
  }
});
