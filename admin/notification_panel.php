
<?php
    include("../db.php");
    $notification = $con->query("SELECT * FROM notification ORDER BY id DESC LIMIT 4");
    while ($rownoti = mysqli_fetch_array($notification)) {
    	if ($rownoti['noti_type'] == 'comment') {
    		echo '
	    		<a href="comment">
	                <li class="list-group-item primary">
	                    <a href="notification" class="email-user bg-blue">
	                        <i class="fa fa-comment"></i>
	                    </a>
	                    <div class="email-info">
	                        <span class="email-time">
	                            '.$rownoti['noti_time'].'
	                        </span>
	                        <h5 class="email-title">
	                            <a href="notification">'.$rownoti['noti_from'].'</a>
	                        </h5>
	                        <p class="email-desc" style="white-space: nowrap; width: 160px; border: 1px solid transparent; overflow: hidden; text-overflow: ellipsis;">'.$rownoti['content'].'
	                        </p>
	                    </div>
	                </li>
	            </a>
    		';
    	}
    	elseif ($rownoti['noti_type'] == 'order') {
    		echo '
	    		<a href="orderview">
	                <li class="list-group-item primary">
	                    <a href="notification" class="email-user bg-orange">
	                        <i class="fa fa-shopping-cart"></i>
	                    </a>
	                    <div class="email-info">
	                        <span class="email-time">
	                            '.$rownoti['noti_time'].'
	                        </span>
	                        <h5 class="email-title">
	                            <a href="notification">'.$rownoti['noti_from'].'</a>
	                        </h5>
	                        <p class="email-desc" style="white-space: nowrap; width: 160px; border: 1px solid transparent; overflow: hidden; text-overflow: ellipsis;">'.$rownoti['content'].'
	                        </p>
	                    </div>
	                </li>
               </a>
    		';
    	}
    	else{
    		echo '
    			<a href="notification">
	                <li class="list-group-item primary">
	                    <a href="notification" class="email-user bg-red">
	                        <i class="fa fa-warning"></i>
	                    </a>
	                    <div class="email-info">
	                        <span class="email-time">
	                            '.$rownoti['noti_time'].'
	                        </span>
	                        <h5 class="email-title">
	                            <a href="notification">'.$rownoti['noti_from'].'</a>
	                        </h5>
	                        <p class="email-desc" style="white-space: nowrap; width: 160px; border: 1px solid transparent; overflow: hidden; text-overflow: ellipsis;">'.$rownoti['content'].'
	                        </p>
	                    </div>
	                </li>
	            </a>
    		';
    	}
    }
?> 
								