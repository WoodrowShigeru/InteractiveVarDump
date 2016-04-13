(function($){

  $(document)
     // overhead: inline togglers
    .on('click', '.ivd_toggle_inline', function(e){
      var
        tree = $(this).closest('.ivd_tree'),
        inliners = $('.ivd_scalar', tree)
      ;
      if (inliners.first().is('.ivd_inline')) {
        inliners.removeClass('ivd_inline');
      } else {
        inliners.addClass('ivd_inline');
      }
    })


     // overhead: protected property togglers
    .on('click', '.ivd_toggle_protectedp', function(e){
      var
        tree = $(this).closest('.ivd_tree'),
        set = $('.ivd_protected', tree)
      ;
      if (set.first().is('.ivd_hidden')) {
        set.removeClass('ivd_hidden');
      } else {
        set.addClass('ivd_hidden');
      }
    })


     // overhead: private property togglers
    .on('click', '.ivd_toggle_privatep', function(e){
      var
        tree = $(this).closest('.ivd_tree'),
        set = $('.ivd_private', tree)
      ;
      if (set.first().is('.ivd_hidden')) {
        set.removeClass('ivd_hidden');
      } else {
        set.addClass('ivd_hidden');
      }
    })


     // overhead: batch-collaps0rs (but exclude root-lvl-content)
    .on('click', '.ivd_batch_collapse', function(e){
      var
        tree = $(this).closest('.ivd_tree')
      ;
      $('.ivd_item .ivd_content', tree).addClass('ivd_collapsed');
    })


     // overhead: batch-expand0rs (but exclude root-lvl-content)
    .on('click', '.ivd_batch_expand', function(e){
      var
        tree = $(this).closest('.ivd_tree')
      ;
      $('.ivd_item .ivd_content', tree).removeClass('ivd_collapsed');
    })


     // depth controllers
    .on('click', '.ivd_controller', function(e){
      var
        controller = $(this),
        content = controller.nextAll('.ivd_content:first')
      ;

      if (content.is('.ivd_collapsed')) {
        content.removeClass('ivd_collapsed');
      } else {
        content.addClass('ivd_collapsed');
      }
    })


    .ready(function(){

       // overhead controllers.
      $('.ivd_tree').each(function(){
        var
          tree = $(this),
          html = ''
        ;

         // only add the overhead to items with complexity (depth).
        if (tree.find('.ivd_key').length) {
          html =
            '<ul class="ivd_overhead">'
          +   '<li class="ivd_toggle_inline">toggle inline</li>'
          ;
          if ( $('.ivd_protected', tree).length ) {
            html += '<li class="ivd_toggle_protectedp">toggle protected properties</li>';
          }

          if ( $('.ivd_private', tree).length ) {
            html += '<li class="ivd_toggle_privatep">toggle private properties</li>';
          }
          if ( $('.ivd_content .ivd_controller', tree).length ) {
            html +=
                '<li class="ivd_batch_collapse">batch-collapse</li>'
            +   '<li class="ivd_batch_expand">batch-expand</li>'
            + '</ul><!-- /.ivd_overhead -->'
            ;
          }

          tree.prepend(html);
        }


         // comfort-wrap for CSS.
        $('.ivd_controller, .ivd_overhead li', tree).wrapInner('<span class="ivd_clickable"></span>');


      });  // end of ( init trees )


    })  //__ end of ( READY )
  ;  // end of ( document )

}(jQuery));
