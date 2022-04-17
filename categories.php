<?php
$title = 'Tür Yönetimi';
include_once 'mainClass.php';
include_once 'header.php';
?>

<div class="row">
    <div class="col-lg-12">
        <?php
        if(isset($_GET["addNewCat"]) && $_GET["addNewCat"]==1) {
            ?>
            <div class="bg-danger d-flex justify-content-center card my-2">
                <p class="text-center lead align-self-center text-white m-2">Kategori başarıyla eklendi.</p>
            </div>
            <?php
        }
        if(isset($_GET["editCat"]) && $_GET["editCat"]==1) {
            ?>
            <div class="bg-danger d-flex justify-content-center card my-2">
                <p class="text-center lead align-self-center text-white m-2">Kategori başarıyla düzenlendi.</p>
            </div>
            <?php
        }

        if(isset($_GET["editNews"]) && $_GET["editNews"]=="error") {
            ?>
            <div class="bg-danger d-flex justify-content-center card my-2">
                <p class="text-center lead align-self-center text-white m-2">Lütfen paneldeki linkleri takip ediniz.</p>
            </div>
            <?php
        }

        ?>
        <div class="card my-2 border-success">
            <div class="card-header bg-success text-white">
                <a href="addCat.php?tur=<?php echo $_GET['tur']?>"><button type="button" class="btn btn-success float-right">YENİ EKLE</button></a><h4 class="m-1">Kategoriler</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="showAllNews">
                    <p class="text-center lead align-self-center">Lütfen Bekleyin</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Display User in details Modal -->
<div class="modal fade" id="showUserDetailsModal">
    <div class="modal-dialog modal-dialog-centered mw-100 w-50">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="getName"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <div class="card-deck">
                    <div class="card border-primary">
                        <div class="card-body">
                            <p id="getEmail"></p>
                            <p id="getPhone"></p>
                            <p id="getDob"></p>
                            <p id="getGender"></p>
                            <p id="getCreatedAt"></p>
                            <p id="getVerified"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        // Delete a user ajax request
        $("body").on("click", ".userDeleteIcon", function(e){
            e.preventDefault();
            cat_id = $(this).attr('id');
            Swal.fire({
                title: 'Emin misiniz?',
                text: "Bu işlem geri döndürülemez!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, Silinsin!',
                cancelButtonText: 'İşlemi iptal et!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'actions.php',
                        type: 'post',
                        data: { cat_id: cat_id,tur:'<?php echo $_GET["tur"]; ?>' },
                        success: function(response) {
                            console.log(response);
                            Swal.fire(
                                'Silindi!',
                                'Silme işlemi sorunsuz tamamlandı!',
                                'success'
                            )
                            fetchAllCats();
                        }
                    });
                }
            });
        });


        //Fetch All Users Ajax Request
        fetchAllCats();

        function fetchAllCats(){
            $.ajax({
                url: 'actions.php',
                method: 'post',
                data: {action:'fetchAllCats',tur:'<?php echo $_GET["tur"]?>'},
                success:function(response){
                    $("#showAllNews").html(response);
                    $("table").DataTable({
                        "order": [0, 'asc'],
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