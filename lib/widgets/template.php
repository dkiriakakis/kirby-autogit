<style>
#autogit-widget .btn {
  margin-bottom: .5em;
  width: 100%; }

#autogit-widget footer {
  color: #777;
  font-size: .8em;
  margin-top: .5em;
  text-align: right; }

.autogit-status {
  display: none;
  margin-bottom: .75em;
  margin-top: .5em;
  text-align: center; }

.icon-left.fa-spinner {
  margin-right: .5em;
  padding-right: 0 !important; }

.icon.fa-spinner {
  -webkit-animation: spinner .8s infinite linear;
          animation: spinner .8s infinite linear;
  -webkit-transform-origin: 50% 46%;
          transform-origin: 50% 46%; }

@-webkit-keyframes spinner {
  0% {
    -webkit-transform: rotate(0);
            transform: rotate(0); }
  100% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg); } }
</style>

<div class="autogit-widget">
  <div class="autogit-status"></div>
  <button href="/panel/autogit/push" data-action="push" class="btn btn-rounded btn-positive autogit-action">
    <i class="icon icon-left fa fa-cloud-upload"></i>
    Publish changes
  </button>
  <button href="/panel/autogit/pull" data-action="pull" class="btn btn-rounded btn-positive autogit-action">
    <i class="icon icon-left fa fa-cloud-download"></i>
    Get latest changes
  </button>
  <footer>Powered by Auto Git</footer>
</div>

<script>
  var $widget = $('#autogit-widget')
  var $loadingIcon = $('<i class="icon icon-left fa fa-spinner" />')
  var $successIcon = $('<i class="icon icon-left fa fa-check" />')
  var $errorIcon = $('<i class="icon icon-left fa fa-times" />')

  $widget.find('.autogit-action').click(function (event) {
    if (event.target !== this) event.target = this

    var $button = $(event.target)
    var $defaultIcon = $button.find('.icon')
    var $status = $('.autogit-status')

    $button.find('.icon').replaceWith($loadingIcon)

    $.post('/panel/autogit/' + $button.data('action'))
      .done(function (res) {
        $button.find('.icon').replaceWith($successIcon)
        $status.text(res.message).show(600)
      })
      .fail(function (res) {
        $button.find('.icon').replaceWith($errorIcon)
        $button.removeClass('btn-positive').addClass('btn-negative')
        $status.text(res.responseJSON.message).show(600)
      })
      .always(function () {
        setTimeout(function () {
          $button.find('.icon').replaceWith($defaultIcon)
          $button.removeClass('btn-negative').addClass('btn-positive')
          $status.hide(600, function () {
            $(this).text('')
          })
        }, 4000)
      })
    })
</script>