<?php
$title = 'Yeni Kullanıcı Ekleme Paneli';
include_once 'mainClass.php';
include_once 'header.php';
?>

<div class="row">

    <!-- Textual inputs start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Yeni Kullanıcı Bilgileri</h4>
                <form method="POST" action="" id="addUserForm">
                    <div id="userAddAlert"></div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Ad Soyad*</b></label>
                        <input class="form-control" required="" name="uye_ad" type="text" id="example-text-input">
                    </div>

                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Mail*</b></label>
                        <input class="form-control" required="" name="uye_mail" type="email" value="" onBlur="checkUniqueEmail()" id="username"><span id="user-availability-status"></span>
                    </div>
                    <p><img src="https://phppot.com/demo/live-username-availability-check-using-php-and-jquery-ajax/LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Parola*</b></label>
                        <input class="form-control" required="" name="uye_parola" type="password" value="" id="example-text-input">
                    </div>

                    <label class="col-form-label"><b>Rol/Durum*</b></label>
                    <select name="uye_durum" required="" class="form-control">
                        <!--<option value="0">Banlı</option>-->
                        <option value="2">Ana Yönetici</option>
                        <option value="3">AADYM Birim Yöneticisi</option>
                        <option value="4">Sosyal İşler ve İaşe Birim Yöneticisi</option>
                        <option value="5">Arama Kurtarma Birim Yöneticisi</option>
                    </select>
                    <br>
                    <button type="submit" name="uyeekle" id="addUserBtn" class="btn btn-primary btn-lg btn-block">Yeni Kullanıcı Ekle</button>
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
    function checkUniqueEmail() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "check_availability.php",
            data:'username='+$("#username").val(),
            type: "POST",
            success:function(data){
                $("#user-availability-status").html(data);
                $("#loaderIcon").hide();
            },
            error:function (){}
        });
    }
    $(document).ready(function(){
        $("#addUserBtn").click(function(e){
            if($("#addUserForm")[0].checkValidity()){
                e.preventDefault();
                $(this).val('Lütfen Bekleyin...');
                $.ajax({
                    url: 'actions.php',
                    method: 'post',
                    data: $("#addUserForm").serialize()+'&action=addNewUser',
                    success:function(response){
                        if(response === 'user_added'){
                            window.location = 'users.php?addNewUser=1';
                        }else{
                            $("#userAddAlert").html(response);
                        }
                        $("#addUserBtn").val('Yeni Kullanıcı Ekle');
                    }
                });
            }
        });



    });
</script>
</body>

</html>
