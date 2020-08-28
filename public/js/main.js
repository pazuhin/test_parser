$('#inputDate').on('click', function(e){
    let alert = $('.alert');
    let date = $('#date').val();
    $.ajax({
        url: '/main/index',
        data: {date: date},
        type: 'GET',
        success: function(data){
            if (data === false) {
                alert('Данные за этот день отсутствуют')
            }
        },
        error: function(){

        }
    });
});

$('#parse').on('click', function(){
    const btn = $(this);
    btn.attr('disabled', true);
    $.ajax({
        url: '/main/parse',
        data: {},
        type: 'get',
        success: function(res){
            alert('Данные успешно загружены');
            btn.attr('disabled', false);
        },
        error: function(){
            alert('Ошибка загрузки данных');
        }
    });
});
