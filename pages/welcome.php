      <div class="container">
        <div class="alert alert-info">
            It seems to be the first time you access Raspcontrol.
            <br />Please create your ID to go on!
        </div>
    </div>

      <div class="container">
        <div class="center">
    			<form class="form-inline form-login" method="post" action="<?php echo LOGIN; ?>">
    			  <input type="text" name="username" id="username" placeholder="Username" autofocus />
    			  <input type="password" name="password" id="password" placeholder="Password" />
    			  <input type="hidden" name="unicorn" value="beautiful" />
    			  <input type="submit" class="btn btn-primary" value="Create" />
    			</form>
        </div>
      </div>
