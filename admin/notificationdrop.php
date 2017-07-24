
<?php
    include("../db.php");
    $notification = $con->query("SELECT * FROM notification ORDER BY id DESC LIMIT 5");
    $sqlcount = mysqli_num_rows($notification);
    while ($rownoti = mysqli_fetch_array($notification)) {
    	if ($rownoti['noti_type'] == 'comment') {
    		echo '
                <li class="media">
                    <a href="comment">
                        <div class="media-left"><i class="fa fa-comment media-object bg-green"></i></div>
                        <div class="media-body">
                        	<h4 class="media-heading" style="white-space: nowrap; width: 155px; border: 1px solid transparent; overflow: hidden; text-overflow: ellipsis;">'.$rownoti['noti_from'].'</h4>
                            <h6 class="media-heading" style="white-space: nowrap; width: 100px; border: 1px solid transparent; overflow: hidden; text-overflow: ellipsis;">'.$rownoti['content'].'</h6>
                            <div class="text-muted f-s-11">'.$rownoti['noti_time'].'</div>
                        </div>
                    </a>
                </li>
    		';
    	}
    	elseif ($rownoti['noti_type'] == 'order') {
    		echo '
                <li class="media">
                    <a href="orderview">
                        <div class="media-left"><i class="fa fa-shopping-cart media-object bg-orange"></i></div>
                        <div class="media-body">
                        	<h4 class="media-heading" style="white-space: nowrap; width: 155px; border: 1px solid transparent; overflow: hidden; text-overflow: ellipsis;">'.$rownoti['noti_from'].'</h4>
                            <h6 class="media-heading" style="white-space: nowrap; width: 150px; border: 1px solid transparent; overflow: hidden; text-overflow: ellipsis;">'.$rownoti['content'].'</h6>
                            <div class="text-muted f-s-11">'.$rownoti['noti_time'].'</div>
                        </div>
                    </a>
                </li>
    		';
    	}
    	else{
    		echo '
                <li class="media">
                    <a href="notification">
                        <div class="media-left"><i class="fa fa-warning media-object bg-red"></i></div>
                        <div class="media-body">
                        	<h4 class="media-heading" style="white-space: nowrap; width: 155px; border: 1px solid transparent; overflow: hidden; text-overflow: ellipsis;">'.$rownoti['noti_from'].'</h4>
                            <h6 class="media-heading" style="white-space: nowrap; width: 150px; border: 1px solid transparent; overflow: hidden; text-overflow: ellipsis;">'.$rownoti['content'].'</h6>
                            <div class="text-muted f-s-11">'.$rownoti['noti_time'].'</div>
                        </div>
                    </a>
                </li>
    		';
    	}
    }
    echo '
        <li class="dropdown-footer text-center">
            <a href="notification">View more</a>
        </li>
    ';
?> 