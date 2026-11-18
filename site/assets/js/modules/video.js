// The match-stage video is a short silent loop. The pause button only appears
// with JavaScript; visitors who prefer reduced motion see the poster and can
// start the video themselves (WCAG 2.2.2 pause, stop, hide).
export function initVideos() {
  document.querySelectorAll('[data-video]').forEach((wrapper) => {
    const video = wrapper.querySelector('video');
    const playButton = wrapper.querySelector('[data-video-play]');

    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      video.removeAttribute('autoplay');
      video.pause();
    }

    const sync = () => {
      playButton.dataset.state = video.paused ? 'paused' : 'playing';
      playButton.querySelector('.visually-hidden').textContent = video.paused ? 'Video abspielen' : 'Video anhalten';
    };

    playButton.addEventListener('click', () => {
      if (video.paused) {
        video.play();
      } else {
        video.pause();
      }
    });

    ['play', 'pause'].forEach((event) => video.addEventListener(event, sync));
    wrapper.querySelector('.match-video__controls').hidden = false;
    sync();
  });
}
