<!-- Include the tabstrip styles -->
<link rel="stylesheet" type="text/css" media="screen" href="Static_Tabstrip.css">

            <div class="tabstrip">
                &nbsp;
                                    <div class="tabstrip_tab active" id="tab_1">
                                                    <img src="images/tab_active_tl.png" style="position: absolute; top: -1px; left: -1px" width="5" height="5" />
                            <img src="images/tab_active_tr.png" style="position: absolute; top: -1px; right: -1px" width="5" height="5" />
                                                
                        <a href="example.php" onmouseover="window.status = 'Visit Google!'; return true" onmouseout="window.status = ''">Antecedentes Generales</a>                    </div>
                                    <div class="tabstrip_tab " id="tab_2">
                                                    <img src="images/tab_tl.png" style="position: absolute; top: -1px; left: -1px" width="5" height="5" />
                            <img src="images/tab_tr.png" style="position: absolute; top: -1px; right: -1px" width="5" height="5" />
                                                
                        <a href="example.php?tab=2" onmouseover="window.status = 'Or not...'; return true" onmouseout="window.status = ''">Otros Antecedentes</a>                    </div>
                                    <div class="tabstrip_tab " id="tab_3">
                                                    <img src="images/tab_tl.png" style="position: absolute; top: -1px; left: -1px" width="5" height="5" />
                            <img src="images/tab_tr.png" style="position: absolute; top: -1px; right: -1px" width="5" height="5" />
                                                
                        Third (disabled)                    </div>
                                &nbsp;
            </div>
        
<div class="tab_body">
  <?php if(empty($_GET['tab'])):?>
    <h1>Some content</h1>
 
    <p>
      Put the main content in here
    </p>
  <?elseif($_GET['tab'] ?? '' == 2):?>
    <h1>More content</h1>
 
    <p>
      Put more content in here. Use seperate files for better organisation.
    </p>
  <?endif?>
</div>


Este artículo fue extraido de http://www.infrabios.com/index.php?topic=532.0#ixzz0nY0kfQkX
Visita el sitio original para más información
InfraBios - Tu Comunidad WebMaster
