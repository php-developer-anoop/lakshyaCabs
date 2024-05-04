<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=$meta_title?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous"/>
    <?=link_tag(base_url('assets/select2/css/select2.min.css'))."\n";?>
    <?=link_tag(base_url('assets/select2-bootstrap4-theme/select2-bootstrap4.min.css'))."\n";?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/user/')?>dash-styles.css">
    <script src="https://sdk.cashfree.com/js/v3/cashfree.js"></script>
    <?=link_tag(base_url('assets/toastr/toastr.min.css'))."\n";?>
    <?=link_tag(base_url('assets/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'))."\n";?>
    <link rel="icon" type="image/x-icon" href="<?=$favicon?>" />
  </head>
  <body>
    <div class="container-fluid">
    <div class="row">