/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// any CSS you require will output into a single css file (app.css in this case)
/* Jquery */
const $ = require('jquery');
global.$ = global.jQuery = $;
require('popper.js');
require('bootstrap');

/* TinyMCE */
import tinymce from 'tinymce/tinymce';
import 'tinymce/themes/modern/theme';
global.tinymce = tinymce;

$('#add-review-btn').on('click', function() {
   $.get($(this).attr('data-url'), function (data) {
      $('#add-review').html(data);
   });
});

$('#add-review').on('click', '#review-submit', function() {

   let form = $('#review-form');

   $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(),
      success: function(data) {
         $.get($('#reviews-list').attr('data-url'), function(response) {
            $('#reviews-list').html(response);
         });

         $('#add-review').collapse('toggle');
      },
      error: function(response) {
         $('#add-review').html(response.responseText);
      }
   });

   return false;
});

function retrieveReviews() {
   var url = $('#reviews-list').attr('data-url') + '?tri=' + $('#review-filters').attr('data-tri');
   if ($('#review-filters').attr('data-filter') !== 'none') {
      url = url+'&filter='+$('#review-filters').attr('data-filter');
   }

   $.get(url, function (response) {
      $('#reviews-list').html(response);
   });
}

$('#review-filters').on('click', 'a.filter-note', function(e) {
   if ($(this).attr('data-note') === 'none') {
      $('#filter-label').text('none');
   } else {
      $('#filter-label').text('Note = '+$(this).attr('data-note'));
      // Force tri on date when filter != none
      $('button.btn-tri[data-tri="date"]').trigger('click');
   }

   $('#review-filters').attr('data-filter', $(this).attr('data-note'));

   retrieveReviews();

   e.preventDefault();
});

$('#review-filters').on('click', 'button.btn-tri', function (e) {
   // If tri already selected or filter != none : do nothing
   if (!$(this).hasClass('btn-warning') && $('#review-filters').attr('data-filter') === 'none') {
      $('button.btn-tri').removeClass('btn-warning');
      $(this).addClass('btn-warning');
      $('#review-filters').attr('data-tri', $(this).attr('data-tri'));

      retrieveReviews();
   }

   e.preventDefault();
});

$('#review-form').on('click', 'button.btn-note', function() {
   $('#review_note').val($(this).attr('data-note'));

   $('button.btn-note').removeClass('btn-warning');
   $(this).addClass('btn-warning');
});
