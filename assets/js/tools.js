$('.wf-block-header-action-disclosure').each(function() {
        $(this).closest('.wf-block-header').css('cursor', 'pointer');
        $(this).closest('.wf-block-header').on('click', function(e) {
          // Let links in the header work.
          if (e.target && e.target.nodeName === 'A' && e.target.href) {
            return;
          }
          e.preventDefault();
          e.stopPropagation();

          if ($(this).closest('.wf-block').hasClass('wf-disabled')) {
            return;
          }

          var isActive = $(this).closest('.wf-block').hasClass('wf-active');
          if (isActive) {
            //$(this).closest('.wf-block').removeClass('wf-active');
            $(this).closest('.wf-block').find('.wf-block-content').slideUp({
              always: function() {
                $(this).closest('.wf-block').removeClass('wf-active');
              }
            });
          }
          else {
            //$(this).closest('.wf-block').addClass('wf-active');
            $(this).closest('.wf-block').find('.wf-block-content').slideDown({
              always: function() {
                $(this).closest('.wf-block').addClass('wf-active');
              }
            });
          }

        });
      });
      //On/Off Option
      				$('.wf-option.wf-option-toggled .wf-option-checkbox').each(function() {
      					$(this).on('click', function(e) {
      						e.preventDefault();
      						e.stopPropagation();

      						var optionElement = $(this).closest('.wf-option');
      						if (optionElement.hasClass('wf-option-premium') || optionElement.hasClass('wf-disabled')) {
      							return;
      						}

      						var option = optionElement.data('option');
      						var value = false;
      						var isActive = $(this).hasClass('wf-checked');
      						if (isActive) {
      							$(this).removeClass('wf-checked');
      							value = optionElement.data('disabledValue');
      						}
      						else {
      							$(this).addClass('wf-checked');
      							value = optionElement.data('enabledValue');
      						}

      						var originalValue = optionElement.data('originalValue');
      					
      					});

      					$(this).parent().find('.wf-option-title').on('click', function(e) {
      						var links = $(this).find('a');
      						var buffer = 10;
      						for (var i = 0; i < links.length; i++) {
      							var t = $(links[i]).offset().top;
      							var l = $(links[i]).offset().left;
      							var b = t + $(links[i]).height();
      							var r = l + $(links[i]).width();

      							if (e.pageX > l - buffer && e.pageX < r + buffer && e.pageY > t - buffer && e.pageY < b + buffer) {
      								return;
      							}
      						}
      						$(this).parent().find('.wf-option-checkbox').trigger('click');
      					}).css('cursor', 'pointer');
      				});
