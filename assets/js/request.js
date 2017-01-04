
$('#desativar').click(function () {
    $('#url').val('');
    $('#form').submit();
    alert('Bot desativado com sucesso !');
});


$('#ativar').click(function () {
    $('#url').val('https://url_your_server/file_response.php');
    $('#form').submit();
    alert('Bot ativado com sucesso !');
});

$('#form').submit(function (e) {
    $.ajax({
        url: 'https://api.telegram.org/botxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx/setWebhook',
        type: 'POST',
        data: new FormData(this),
        processData: false,
        contentType: false
    });
    e.preventDefault();
});

