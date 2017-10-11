(function($) {
  $(function() {
    var jcarousel = $('.jcarousel');

    jcarousel.each(function() {
      var $this = $(this);

      $this.on('jcarousel:reload jcarousel:create', function() {
        var width = jcarousel.innerWidth();

        if (width >= 600) {
          width = width / 6;
        } else if (width >= 350) {
          width = width / 3;
        }
        $this.jcarousel('items').css('width', width + 'px');
      })
      .jcarousel({
        wrap: 'circular'
      });

    $this.parent().find('.jcarousel-control-prev')
      .jcarouselControl({
        target: '-=1'
      });

    $this.parent().find('.jcarousel-control-next')
      .jcarouselControl({
        target: '+=1'
      });

    $this.parent().find('.jcarousel-pagination')
      .on('jcarouselpagination:active', 'a', function() {
        $(this).addClass('active');
      })
      .on('jcarouselpagination:inactive', 'a', function() {
        $(this).removeClass('active');
      })
      .on('click', function(e) {
        e.preventDefault();
      })
      .jcarouselPagination({
        perPage: 1,
        item: function(page) {
          return '<a href="#' + page + '">' + page + '</a>';
        }
      });
    });

  });
})(jQuery);
