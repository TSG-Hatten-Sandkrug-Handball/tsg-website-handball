// The route link opens Google Maps by default. Phones and tablets have no
// common "choose a map app" link (iOS ignores geo:), so on touch devices the
// visitor picks Google Maps or Apple Maps instead.
export function initRouteLinks() {
  if (!window.matchMedia('(pointer: coarse)').matches) {
    return;
  }

  document.querySelectorAll('[data-route]').forEach((route) => {
    route.querySelector('[data-route-default]').hidden = true;
    route.querySelector('[data-route-choices]').hidden = false;
  });
}
