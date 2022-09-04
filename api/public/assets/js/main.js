

timeago().register('fr_FR', fr)

timeago().render(document.querySelectorAll('.timeago'), 'fr_FR')

flatpickr('.datepicker', {
  enableTime: true,
  altInput: true,
  altFormat: 'j F Y, H:i',
  dateFormat: 'Y-m-d H:i:s',
  locale: French
})