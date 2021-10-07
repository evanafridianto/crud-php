<?php
function base_url($a = '')
{
  $getbase_url = $GLOBALS['setUri']['base'];
  return $getbase_url . $a;
}

function assets($a = '')
{
  $getbase_assets = $GLOBALS['setUri']['assets'];
  return base_url($getbase_assets . $a);
}

function url($a = '', $b = '')
{
  return base_url($b . '?halaman=' . $a);
}

function redirect($a = '')
{
  header("location: " . $a);
  exit;
}

function templates($a = '')
{
  return assets($GLOBALS['template'] . $a);
}


function content_open($title = '')
{
  return '
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">' . $title . '</h3>

        </div>
        <div class="box-body">';
}
function content_close()
{
  return '
	  </div>
       
      </div>
      <!-- /.box -->

    </section>';
}
