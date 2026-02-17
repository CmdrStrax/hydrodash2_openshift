
<footer class="footer mt-auto py-3 bg-dark text-white-50">
  <div class="container-fluid">
    <div class="row align-items-start">
      <div class="col-sm-4 mb-4">
        <p>&copy; <?php echo date("Y"); ?> Amt der Kärntner Landesregierung | Abt. 12 - Hydrographie</p>
        <i>Kontakt</i><br />
        Amt der Kärntner Landesregierung<br />
        Abt. 12 - Wasserwirtschaft - Hydrographie<br />
        Flatschacher Straße 70<br />
        A-9021 Klagenfurt am Wörthersee<br />
        E-Mail: <a href="mailto:abt12.hydrographie@ktn.gv.at" class="link-secondary">abt12.hydrographie@ktn.gv.at</a>
      </div>
      <div class="col-sm-8 text-md-end mt-4 mt-md-0">
        <nav>
          <ul class="navbar-nav ms-md-auto">
            <?php if (!is_null(auth()->user())): ?>
            <li class="nav-item">
              Hi <?php echo auth()->user()->username; ?>!
            </li>
            <?php endif ?>
            <li class="nav-item">
              <a class="link-white-50 link-underline link-underline-opacity-0 link-secondary" href="<?php echo base_url()?>info">
                Berechnungsgrundlage <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16" style="margin-left: 4px; margin-bottom: 4px;">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>              
              </svg></a>
            </li>
            <li class="nav-item">
              <a class="link-white-50 link-underline link-underline-opacity-0 link-secondary" href="<?php echo base_url()?>datenschutz">
                Datenschutzinformation <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16" style="margin-left: 4px; margin-bottom: 2px;">
                <path d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                <path d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
              </svg></a>
            </li>
            <li class="nav-item">
              <a class="link-white-50 link-underline link-underline-opacity-0 link-secondary" href="<?php echo base_url()?>impressum">
                Impressum <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16" style="margin-left: 4px; margin-bottom: 2px;">
                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8m0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5"/>
              </svg></a>
            </li>
            <?php if (!is_null(auth()->user())): ?>
            <li class="nav-item">
              <a href="<?php echo base_url()?>admin" class="link-secondary link-underline-opacity-0">
                Admin <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16" style="margin-left: 4px; margin-bottom: 2px;">
                <path fill-rule="evenodd" d="M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5M12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5M1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8m9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5m1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
              </svg></a>
            </li>

            <li class="nav-item">
              <a href="<?php echo base_url()?>logout" class="link-secondary link-underline-opacity-0">
                Logout <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16" style="margin-left: 4px; margin-bottom: 2px;">
                <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3zm1 13h8V2H4z"/>
                <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0"/>
              </svg></a>
            </li>
            <?php endif ?>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</footer>

</body>
</html>
