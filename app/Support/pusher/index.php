<?php
  require __DIR__ . '/vendor/autoload.php';

  $options = array(
    'cluster' => 'ap2',
    'useTLS' => false
  );
  $pusher = new Pusher\Pusher(
    '2d0ba9e169bf6ee75802',
    '2a1a0ab2f348aeb61111',
    '1418827',
    $options
  );

  $data['message'] = 'hello world';
  $pusher->trigger('my-channel', 'my-event', $data);
?>
