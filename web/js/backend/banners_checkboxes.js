function Banners_checkboxes() {
  this.deleteUrl = false;
  this.checkboxClass = false;
  this.sending = false;

  this.init = function(checkboxClass, checkAllClass, deleteAllBtn, deleteUrl) {
    var self = this;
    self.deleteUrl = deleteUrl;
    self.checkboxClass = checkboxClass;

    $(deleteAllBtn).on('click', function(e){
      e.preventDefault();
      self.deleteSelected();
    });




    $(checkAllClass).on('change', function() {
      self.toogleSelectionAlls($(this).attr('data-id'));
    });
  }


  /*
  this.toogleSelection = function(checkbox) {
     var self = this;
     var id = $(checkbox).attr('data-id');

     if($(checkbox).prop('checked')) {
       $(checkbox).prop('checked', false);
       //var selectedIndes = self.selected.indexOf(id);
     }
     else {
       $(checkbox).prop('checked', true);
      //self.selected[self.selected.length] = id;
     }
  }*/


  this.toogleSelectionAlls = function() {
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


  this.deleteSelected = function()
  {
    var self = this;
    self.getAllChecked(function(ids)
    {
        if(ids.length == 0)
          return false;

        if(self.sending)
          return false;

        self.sending = true;
        console.log(ids);
        $.ajax({
          method : 'POST',
          url    : self.deleteUrl,
          data   : {ids : ids},
        })
        .done(function(data)
        {
          self.sending = false;
          $.pjax.reload({container: '#banners-pjax'});
        });
    });
  }

}


var banners_checkboxes = false;
$(document).ready( function() {
  banners_checkboxes = new Banners_checkboxes();
  banners_checkboxes.init('.banner_checkboxes', '.select_all_banners', '.banner-delete-btn', '/admin/bnrs/delete-banners-ajax');
});
