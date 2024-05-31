<!-- Overlay utilizzato quando si apre la sidebar (col-sx) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="sideClose()" title="Chiudi menu"></div>

<!-- Button per aprire la sidebar su dispositivi mobile -->
<button onclick="sideOpen()" id="sidebarOpen" title="Apri menu"> <i class="bi bi-arrow-bar-right"></i> </button>

<div class="col-sx" id="colsx">
	<div class="container">
		<div>
			
			<form method="GET" action="<?php echo $link_ricerca; ?>">
				<input name="ricerca" type="text" placeholder="cerca zone, famiglie, etc..." required>
			</form> <!-- form -->
			
			<ul class="menu">
				<li> 
					<a href="<?= $link_home; ?>"> 
						<i class="bi bi-house"></i> 
						Home
					</a> 
				</li> <!-- Home -->
				<hr>
				<li> 
					<a href="<?= $link_zone; ?>"> 
						<i class="bi bi-geo"></i> 
						Zone
					</a> 
				</li> <!-- Zone -->
				<li> 
					<a href="<?= $link_famiglie; ?>"> 
						<i class="bi bi-people"></i>
						Famiglie
					</a> 
				</li> <!-- Famiglie -->
				<li> 
					<a href="<?= $link_referenti; ?>"> 
						<i class="bi bi-person"></i> 
						Referenti
					</a>
				</li> <!-- Referenti -->
				<li> 
					<a href="<?= $link_prodotti; ?>"> 
						<i class="bi bi-egg-fried"></i>
						Prodotti
					</a> 
				</li> <!-- Prodotti -->
				<li> 
					<a href="<?= $link_distribuzioni; ?>"> 
						<i class="bi bi-cart"></i> 
						Distribuzioni
					</a> 
				</li> <!-- Distribuzioni -->
			</ul> <!-- menu -->

		</div> <!-- first div -->
		<div>

			<div class="version">
				<p>ver. 1.0.0</p>	
			</div> <!-- version -->
			
		</div> <!-- second div -->
	</div>
</div> <!-- col-sx -->