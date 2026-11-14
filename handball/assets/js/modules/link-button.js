// Links that act as buttons once JS runs (they keep a no-JS fallback href).
// Gives them button semantics and Space-key activation.
export function asButton(link, onActivate) {
  link.setAttribute('role', 'button');

  link.addEventListener('click', (event) => {
    event.preventDefault();
    onActivate(event);
  });

  link.addEventListener('keydown', (event) => {
    if (event.key === ' ') {
      event.preventDefault();
      onActivate(event);
    }
  });
}
