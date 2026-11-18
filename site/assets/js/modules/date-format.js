// All match times are German local time, whatever time zone the visitor is in.
const TIME_ZONE = 'Europe/Berlin';

const formats = {
  dayMonth: new Intl.DateTimeFormat('de-DE', { timeZone: TIME_ZONE, day: '2-digit', month: '2-digit' }),
  time: new Intl.DateTimeFormat('de-DE', { timeZone: TIME_ZONE, hour: '2-digit', minute: '2-digit' }),
  long: new Intl.DateTimeFormat('de-DE', { timeZone: TIME_ZONE, weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }),
  date: new Intl.DateTimeFormat('de-DE', { timeZone: TIME_ZONE, day: '2-digit', month: '2-digit', year: 'numeric' }),
};

export const formatDayMonth = (iso) => formats.dayMonth.format(new Date(iso));
export const formatTime = (iso) => `${formats.time.format(new Date(iso))} Uhr`;
export const formatLongDate = (iso) => formats.long.format(new Date(iso));
export const formatDate = (iso) => formats.date.format(new Date(iso));
