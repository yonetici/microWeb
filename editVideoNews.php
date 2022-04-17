<?php
$title = 'Video Haber Düzenleme Paneli';
include_once 'mainClass.php';
include_once 'header.php';

if (isset($_GET["videoId"])) {
    $videoId = intval($_GET["videoId"]);
} else {
    Header("Location:videoNews.php?status=error");
}
if ($admin->checkUserStatus($_SESSION['uye_id'])!=2) {

    Header("Location:dashboard.php?editNews=Izinsiz-Erisim");
    exit();
}

if ($admin->fetchVideoDetailsByID($videoId)) {
    $getVideo = $admin->fetchVideoDetailsByID($videoId);
} else {
    Header("Location:dashboard.php?editNews=Izinsiz-Erisim");
    exit();
}
?>

<div class="row">

    <!-- Textual inputs start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Video Haber Düzenle</h4>
                <form method="POST" action="" id="addUserForm">
                    <div id="userAddAlert"></div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Video Başlık</b></label>
                        <input class="form-control" required="" name="video_isim" value="<?php echo $getVideo["video_isim"]; ?>" type="text" id="example-text-input">
                    </div>

                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Video Adres</b></label>
                        <input class="form-control" required="" value="https://www.youtube.com/watch?v=<?php echo $getVideo["video_key"]; ?>" name="video_key" type="text" id="example-text-input">
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="video_durum[]" value="1" id="defaultCheck1" <?php echo ($getVideo["video_durum"] == 1) ? 'checked':''; ?>>
                        <label class="form-check-label" for="defaultCheck1">Video Yayın Durumu</label>
                    </div>
                    <input type="hidden" name="video_id" value="<?php echo $getVideo["video_id"]; ?>">
                    <button type="submit" name="videoekle" id="addUserBtn" class="btn btn-primary btn-lg btn-block">Düzenle</button>
                </form>
            </div>




        </div>
    </div>
</div>

<!-- footer end -->

</div>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" defer></script>
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
        $("#addUserBtn").click(function(e){
            if($("#addUserForm")[0].checkValidity()){
                e.preventDefault();
                $(this).val('Lütfen Bekleyin...');
                $.ajax({
                    url: 'actions.php',
                    method: 'post',
                    data: $("#addUserForm").serialize()+'&action=editVideoNews',
                    success:function(response){
                        if(response === 'user_added'){
                            window.location = 'videoNews.php?addNewUser=2';
                        }else{
                            $("#userAddAlert").html(response);
                        }
                        $("#addUserBtn").val('Düzenle');
                    }
                });
            }
        });



    });
</script>
</body>

</html>
