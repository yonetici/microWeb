<?php
$title = 'Yeni Kategori Ekleme Paneli';
include_once 'mainClass.php';
include_once 'header.php';
$tur=$_GET["tur"];
?>

<div class="row">

    <!-- Textual inputs start -->
    <div class="col-12 mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Yeni Kategori Bilgileri</h4>
                <form method="POST" action="" id="addUserForm">
                    <div id="userAddAlert"></div>
                    <div class="form-group">
                        <label for="example-text-input" class="col-form-label"><b>Kategori İsmi*</b></label>
                        <input class="form-control" required="" name="kategori_ad" type="text" id="example-text-input">
                    </div>

                    <br>
                    <button type="submit" name="uyeekle" id="addUserBtn" class="btn btn-primary btn-lg btn-block">Yeni Kategori Ekle</button>
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

        $("#addUserBtn").click(function(e){
            if($("#addUserForm")[0].checkValidity()){
                e.preventDefault();
                $(this).val('Lütfen Bekleyin...');
                $.ajax({
                    url: 'actions.php',
                    method: 'post',
                    data: $("#addUserForm").serialize()+'&action=addNewCat&tur=<?php echo $tur; ?>',
                    success:function(response){
                        if(response === 'cat_added'){
                            window.location = 'categories.php?addNewCat=1&tur=<?php echo $tur; ?>';
                        }else{
                            $("#userAddAlert").html(response);
                        }
                        $("#addUserBtn").val('Yeni Kategori Ekle');
                    }
                });
            }
        });



    });
</script>
</body>

</html>
