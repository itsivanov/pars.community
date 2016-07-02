var modalJS =
{
    popup : false,
    statusBlock : false,
    modalBtn : false,
    actionUrl : "/admin/categories/edit-category",
    sending : false,

    init : function()
    {
      var self = this;
        this.popup = $('.modal-popup');
        this.statusBlock = $('.proccess');
        this.modalBtn = $('#modalAction');

        this.modalBtn.on('click', function(){
          self.sendReq();
        });
    },

    showModal : function()
    {
      this.popup.show();
    },

    hideModal : function()
    {
      this.popup.hide();
    },

    changeProccess : function(status, statusText)
    {
      this.modalBtn.hide();
      this.statusBlock.removeClass('processing success error').addClass(status).text(statusText);
      this.showStatus();
    },

    showStatus : function()
    {
      this.statusBlock.show();
    },

    hideStatus : function()
    {
      this.statusBlock.hide();
    },


    sendReq : function()
    {
      var self = this;

      if(this.sending)
       return false;

      var data = {};
      $('.modal-popup input, .modal-popup textarea, .modal-popup select').each(function(){
        data[$(this).attr('name')] = $(this).val();
      });

      this.sending = true;
      this.changeProccess('processing', 'processing...');
      $.ajax({
          type: "POST",
          url: "/admin/categories/edit-category",
          data: data,
          dataType : 'json',
      }).success(function(data){
        self.sending = false;
        if(data.success == 1)
          window.location.reload();
      });
    }
}
