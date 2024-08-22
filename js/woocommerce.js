(function ($) {
    'use strict';

	$( document ).ready(function() {
    /**
     * Custom wooCommerce ordering
     */
     $('.woocommerce-ordering select').each(function(){
         var $this = $(this), numberOfOptions = $(this).children('option').length;

         $this.addClass('select-hidden');
         $this.wrap('<div class="select"></div>');
         $this.after('<div class="select-styled"></div>');

         var $styledSelect = $this.next('div.select-styled'),
             $otpSelectedVal = $this.children('option[selected="selected"]').val(),
             $otpSelctedText = $this.children('option[selected="selected"]').text();

         $styledSelect.text($otpSelctedText);

         var $list = $('<ul />', {
             'class': 'select-options'
         }).insertAfter($styledSelect);

         for (var i = 0; i < numberOfOptions; i++) {
             $('<li />', {
                 text: $this.children('option').eq(i).text(),
                 rel: $this.children('option').eq(i).val()
             }).appendTo($list);
         }

         var $listItems = $list.children('li');

         $listItems.each(function(){
           $this.val($(this).attr('rel'))

           if ( $this.val() == $otpSelectedVal ) {
             $(this).addClass('selected');
           }
         });

         $styledSelect.click(function(e) {
             e.stopPropagation();
             $('div.select-styled.active').not(this).each(function(){
                 $(this).removeClass('active').next('ul.select-options').hide();
             });
             $(this).toggleClass('active').next('ul.select-options').toggle();
         });

         $listItems.click(function(e) {
             e.stopPropagation();
             $styledSelect.text($(this).text()).removeClass('active');
             $this.val($(this).attr('rel'));
             $list.hide();
             //console.log($this.val());

             if ( $this.val() != $otpSelectedVal ) {
               $('form.woocommerce-ordering').submit();
             }

         });

         $(document).click(function() {
             $styledSelect.removeClass('active');
             $list.hide();
         });

     });

    /**
     * Change product quantity
     */
    function aloneCustomQuantity() {
      $('.quantity').on('click', '.increase, .decrease', function (event) {
         event.preventDefault();
         var $this = $(this),
            $qty = $this.siblings('.qty'),
            current = parseInt($qty.val(), 10),
            min = parseInt($qty.attr('min'), 10),
            max = parseInt($qty.attr('max'), 10),
            step = parseInt($qty.attr('step'));

         current = current ? current : 0;
         min = min ? min : 1;
         max = max ? max : current + 1;

         if ($this.hasClass('decrease') && current > min) {
            $qty.val(current - step);
            $qty.trigger('change');
         }
         if ($this.hasClass('increase') && current < max) {
            $qty.val(current + step);
            $qty.trigger('change');
         }
     });
    }

    aloneCustomQuantity();

    $( document.body ).on( 'updated_cart_totals', function(){
      aloneCustomQuantity();
    });

	});

})
(jQuery);
