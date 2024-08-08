<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
  <div style="width:400px; background-color:orange;"><a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#" style=" background-color:orange;"><img src="image/admin.jpg" alt="aoole" style="width:40px; background-color:orange;"> <span style="padding-left:15px; font-size:20px; font-weight:bolder;">Admin</span></a></div>

  <ul class="navbar-nav px-3" style="background-color:orange; margin-right:20px;border-radius:15px;   box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.25);">
    <li class="nav-item text-nowrap">
    	<?php
    		if (isset($_SESSION['admin'])) {
    			?>
    				<a class="nav-link" href="../admin/admin-logout.php" style="color:white;">Sign out</a>
    			<?php
    		}
    	?>
      
    </li>
  </ul>
</nav>