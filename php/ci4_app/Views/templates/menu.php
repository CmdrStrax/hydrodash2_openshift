<?php helper('url');  ?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
  <div class="container-fluid">
    <div class="navbar-collapse order-1">
      <a class="navbar-brand" href="<?php echo base_url();?>">HydroDash</a>
      <ul class="navbar-nav me-auto">
        <?php foreach ($menu as $menu_item): ?>
        <li class="nav-item">
        <a class="nav-link <?= esc($menu_item[2]) ?>" href="<?php echo base_url();?><?= esc($menu_item[1]) ?>"><?= esc($menu_item[0]) ?></a>
        </li>
        <?php endforeach ?>
      </ul>
    </div>
  </div>
  <span class="navbar-text me-3 d-none d-md-block">
    <a href="<?php echo base_url();?>"><img class="d-flex" src="<?php echo base_url();?>logo.png" height="24"></a>
  </span>
</nav>
