var url = '';
var checkboxClass = '.sources_checkboxes';

var actionsArray = {
  'delete'        : '/admin/sources/delete-for-ids',
  'statusPublished'  : '/admin/sources/change-status?status=1',
  'statusUnpublished'  : '/admin/sources/change-status?status=0',
  'statusActive'  : '/admin/sources/change-update-status?status=1',
  'statusInactive' : '/admin/sources/change-update-status?status=0',
};

function selectAllSources(){
    $('.select_all_sources').on('change', function() {

        if( $(checkboxClass + ':checked').length == $(checkboxClass).length ) {
          $(checkboxClass).each(function() {
            $(this).prop('checked', false);
          });
        }
        else {
          $(checkboxClass).each(function() {
            $(this).prop('checked', true);
          });
        }

    });
}


function selectAction(){
  $('.sources-do-btn').on('click', function(e){
      e.preventDefault();

      var url = $('#sources_action option:selected').val();

      var ids = {};
      $(".sources_checkboxes:checked").each(function(){
           ids[$(this).attr('data-id')] = $(this).attr('data-id');

           // Instead selected in db
           if(url == 'statusPublished'){
              $('tr#' + $(this).attr('data-id') + ' td.status').text('Published');
           }else if(url == 'statusUnpublished'){
              $('tr#' + $(this).attr('data-id') + ' td.status').text('Unpublished');
           }else if(url == 'statusActive'){
              $('tr#' + $(this).attr('data-id') + ' td.update_status').text('Active');
           }else if(url == 'statusInactive'){
              $('tr#' + $(this).attr('data-id') + ' td.update_status').text('Inactive');
           }else{
              $(this).parents('tr').hide();
           }

      });

      ajax(actionsArray[url], ids);

  });
}


function ajax(url, ids){

    $.ajax({
        type: "POST",
        url: url,
        data: {ids: ids},
    });

}


$(document).ready(function(){
    selectAllSources();
    selectAction();
});
