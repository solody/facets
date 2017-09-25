/**
 * @file
 * Provides the soft limit functionality.
 */

(function ($) {

  'use strict';

  Drupal.behaviors.facetSoftLimit = {
    attach: function (context, settings) {
      if (settings.facets.softLimit !== 'undefined') {
        $.each(settings.facets.softLimit, function (facet, limit) {
          Drupal.facets.applySoftLimit(facet, limit, settings);
        })
      }
    }
  };

  Drupal.facets = Drupal.facets || {};

  /**
   * Applies the soft limit UI feature to a specific facets list.
   *
   * @param {string} facet
   *   The facet id.
   * @param {string} limit
   *   The maximum amount of items to show.
   * @param {object} settings
   *   Settings.
   */
  Drupal.facets.applySoftLimit = function (facet, limit, settings) {
    var zero_based_limit = (limit - 1);
    var facetsList = $('ul[data-drupal-facet-id="' + facet + '"]');

    // Hide facets over the limit.
    facetsList.children('li:gt(' + zero_based_limit + ')').once().hide();

    // Add "Show more" / "Show less" links.
    facetsList.once().filter(function () {
      return $(this).find('li').length > limit;
    }).each(function () {
      var facet = $(this);
      var id = facet.data('drupal-facet-id');
      var showLessLabel = settings.facets.softLimitSettings[id].showLessLabel;
      var showMoreLabel = settings.facets.softLimitSettings[id].showMoreLabel;
      $('<a href="#" class="facets-soft-limit-link"></a>')
        .text(showMoreLabel)
        .on('click', function () {
          if (facet.find('li:hidden').length > 0) {
            facet.find('li:gt(' + zero_based_limit + ')').slideDown();
            $(this).addClass('open').text(showLessLabel);
          }
          else {
            facet.find('li:gt(' + zero_based_limit + ')').slideUp();
            $(this).removeClass('open').text(showMoreLabel);
          }
          return false;
      }).insertAfter($(this));
    });
  };

})(jQuery);
