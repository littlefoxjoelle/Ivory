$(document).ready(function(){
    $('.delete').click(function(){
        var rel = $(this).attr("rel");

        $.confirm({
              'title':' Подтверждение удаления',
              'message':'Вы действительно хотите удалить запись?',
              'buttons' : {
                  'Да' :{
                      'class' : 'blue',
                      'action': function(){
                          location.href = rel;
                      }
                  },
                  'Нет' : {
                      'class':'gray',
                      'action': function(){}
                  }
              }
            });
            
    });

$('.block-clients').click(function(){
    $(this).find('ul').slideToggle(300);
});
});

