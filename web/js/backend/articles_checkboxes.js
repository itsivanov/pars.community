function Articles_checkboxes() {
  this.actions = {
    'delete'        : '/admin/articles/delete-selected',
    'statusEnable'  : '/admin/articles/change-status?status=1',
    'statusDisable' : '/admin/articles/change-status?status=0',
  };
  this.checkboxClass = false;
  this.sending = false;

  this.init = function(checkboxClass) {
    var self = this;
    self.checkboxClass = checkboxClass;

    $('.articles-do-btn').on('click', function(e){
      e.preventDefault();
      self.doSelected();
    });

    self.reinitCheckboxes();

  }


  this.reinitCheckboxes = function(){
    var self = this;

    $('.select_all_articles').on('change', function() {
      self.toogleSelectionAll($(this).attr('data-id'));
    });
  }


  this.toogleSelectionAll = function() {
    var self = this;

    if( $(self.checkboxClass + ':checked').length == $(self.checkboxClass).length ) {
      $(self.checkboxClass).each(function() {
        $(this).prop('checked', false);
      });
    }
    else {
      $(self.checkboxClass).each(function() {
        $(this).prop('checked', true);
      });
    }

  }


  this.getAllChecked = function(callback)
  {
    var self = this;
    var data = [];
    var count = $(self.checkboxClass).length;
    $(self.checkboxClass).each(function(i) {
      if($(this).prop('checked'))
        data[data.length] = $(this).attr('data-id');

      if((count-1) == i)
      {
        callback(data);
      }
    });
  }


  this.doSelected = function()
  {
    var self = this;
    self.getAllChecked(function(ids)
    {
        if(ids.length == 0)
          return false;

        if(self.sending)
          return false;

        loader.show();
        self.sending = true;

        var action = $('#article_action').val();

        $.ajax({
          method : 'POST',
          url    : self.actions[action],
          data   : {ids : ids},
        })
        .done(function(data)
        {

          $.pjax.reload({container: '#articles-pjax'}).done(function() {
            console.log('Success works!');
            loader.hide();
            self.sending = false;
            self.reinitCheckboxes();
          });
        });
    });
  }

}


var articles_checkboxes = false;
$(document).ready( function() {
  articles_checkboxes = new Articles_checkboxes();
  articles_checkboxes.init('.articles_checkboxes');
});
