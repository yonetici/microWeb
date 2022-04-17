<?php
$title = 'Kullanıcı Yönetimi';
include_once 'mainClass.php';
include_once 'header.php';
if ($admin->checkUserStatus($_SESSION['uye_id'])!=2) {
    Header("Location:dashboard.php?error=403");
    exit();
}
?>
       
			<div class="row">
				<div class="col-lg-12">
					<div class="card my-2 border-danger">
						<div class="card-header bg-danger text-white"><h4 class="m-0">Silinen Kullanıcılar</h4></div>
						<div class="card-body">
							<div class="table-responsive" id="showAllDeletedUsers">
								<p class="text-center lead align-self-center">Lütfen Bekleyiniz...</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- footer end -->
      </div>
    </div>
  </div>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
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
            // Delete a user ajax request
            $("body").on("click", ".userDeleteIcon", function(e){
                e.preventDefault();
                res_id = $(this).attr('id');
                Swal.fire({
                    title: 'Emin misiniz?',
                    text: "Bu işlem geri döndürülemez!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, Kullanıcıyı aktif hale getir!',
                    cancelButtonText: 'İşlemi iptal et!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: 'actions.php',
                            type: 'post',
                            data: { res_id: res_id },
                            success: function(response) {
                                console.log(response);
                                Swal.fire(
                                    'İşlem Tamam!',
                                    'Aktifleştirme işlemi sorunsuz tamamlandı!',
                                    'success'
                                )
                                fetchAllDeletedUsers();
                            }
                        });
                    }
                });
            });

			fetchAllDeletedUsers();

			function fetchAllDeletedUsers(){
				$.ajax({
					url: 'actions.php',
					method: 'post',
					data: {action:'fetchDeletedUsers'},
					success:function(response){
						$("#showAllDeletedUsers").html(response);
						$("table").DataTable({
                            "order": [0, 'desc'],
                            "columnDefs": [
                                { "type": "turkish-string", targets: 1 },
                                { "type": "num", targets: 0 }
                            ],
                            language: {
                                url: '//cdn.datatables.net/plug-ins/1.11.3/i18n/tr.json'
                            }
						});
					}
				});
			}

		});
	</script>
</body>

</html>