$(document).ready(function () {
  const urlParams = new URLSearchParams(window.location.search);
  const code = urlParams.get('code');

  $(document).on('click', '#targetButton', function () {
    const actionUrl = $(this).attr('data-action');
    const redirectUrl = $(this).attr('data-redirect');
    $.ajax({
      type: 'POST',
      url: actionUrl,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      data: {
        'code': code
      },
      dataType: 'json',
      success: function (data) {
        console.log(data);
        $(location).attr('href', redirectUrl);
      },
      error: function (data) {
        console.log(data);
      }
    });
  });
});