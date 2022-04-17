<?php
$title = 'Mesaj Yönetimi';
include_once 'mainClass.php';
include_once 'header.php';
if ($admin->checkUserStatus($_SESSION['uye_id'])!=2) {
    Header("Location:dashboard.php?error=403");
}
?>
			<div class="row justify-content-center my-2">
				<div class="col-lg-10 mt-4" id="showAllNotification">
					
				</div>
			</div>
			
			<!-- footer end -->
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script type="text/javascript">
  	$(document).ready(function(){

  		checkNotification();

      function checkNotification(){
        $.ajax({
          url: 'actions.php',
          method: 'post',
          data: {action: 'notificationCheck'},
          success: function(response){
            $("#showNotificationCheck").html(response);
          }
        });
      }


      //Delete notification
  		$("body").on("click", ".close", function(e){
  			e.preventDefault();
	      notification_id = $(this).attr('id');
	      $.ajax({
	      	url: 'actions.php',
	      	method: 'post',
	      	data:  {notification_id: notification_id},
	      	success:function(response){
	      		fetchAllNotification();
	      		checkNotification();
	      	}
	      });
  		});

  		fetchAllNotification();

  		function fetchAllNotification(){
				$.ajax({
					url: 'actions.php',
					method: 'post',
					data: {action:'fetchAllNotification'},
					success:function(response){
						$("#showAllNotification").html(response);
					}
				});
			}

  	});
  </script>
</body>

</html>