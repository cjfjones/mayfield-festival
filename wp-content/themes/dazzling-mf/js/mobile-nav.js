/* Mobile nav toggle without Bootstrap */
jQuery(function ($) {
  var $btn = $('.navbar-toggle');
  var $target = $('#navbar'); // matches data-target="#navbar"
  if (!$btn.length || !$target.length) return;

  // Ensure expected classes are present
  if (!$target.hasClass('navbar-collapse')) $target.addClass('navbar-collapse');
  if (!$target.hasClass('collapse')) $target.addClass('collapse');

  // Initial ARIA state
  $btn.attr('aria-controls', 'navbar').attr('aria-expanded', 'false');
  $target.attr('aria-expanded', 'false');

  $btn.off('click.mf').on('click.mf', function (e) {
    e.preventDefault();
    var open = $target.hasClass('in');
    $target.toggleClass('in', !open).attr('aria-expanded', String(!open));
    $btn.attr('aria-expanded', String(!open));
  });
});


// Helpers to open/close consistently
function setOpen(open) {
  $target.toggleClass('in', open).attr('aria-expanded', String(open));
  $btn.attr('aria-expanded', String(open));
}

// Close menu after tapping a link (mobile only)
$target.on('click', 'a', function () {
  if (window.innerWidth < 768) setOpen(false);
});

// Close on Escape
jQuery(document).on('keydown.mf', function (e) {
  if (e.key === 'Escape') setOpen(false);
});

// Keep state sane across resizes (desktop shows menu)
jQuery(window).on('resize.mf', function () {
  setOpen(window.innerWidth >= 768);
}).trigger('resize.mf');
