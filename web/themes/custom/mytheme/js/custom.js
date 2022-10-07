(function ($) {
  Drupal.behaviors.myModuleBehavior = {
    attach: function (context, settings) {
      $(context).find('.field--name-field-label').once('myCustomBehavior').click(function () {
        alert('Hello, World!');
      });
    }
  };
})(jQuery);
