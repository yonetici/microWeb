<?php

    $title="Ana Sayfa";
    include_once 'mainClass.php';
    include_once 'header.php';
?>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-deck mt-3 text-light text-center font-weight-bold">
						<div class="card bg-primary">
							<div class="card-header">Personel Sayısı</div>
							<div class="card-body">
								<h1 class="display-4">
									<?= $admin->totalCount('personel'); ?>
								</h1>
							</div>
						</div>
						<div class="card bg-warning">
							<div class="card-header">Birim Yöneticileri</div>
							<div class="card-body">
								<h1 class="display-4">
									<?= $admin->verified_users(2,'up'); ?>
								</h1>
							</div>
						</div>
						<div class="card bg-success">
							<div class="card-header">Ana Yönetici</div>
							<div class="card-body">
								<h1 class="display-4">
									<?= $admin->verified_users(3,'down'); ?>
								</h1>
							</div>
						</div>
						<div class="card bg-danger">
							<div class="card-header">Olay Sayısı</div>
							<div class="card-body">
								<h1 class="display-4">
                                    <?= $admin->totalCount('olaylar'); ?>
								</h1>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-deck mt-3 text-light text-center font-weight-bold">
						<div class="card bg-danger">
							<div class="card-header">Görev Sayısı</div>
							<div class="card-body">
								<h1 class="display-4">
									<?= $admin->totalCount('gorevlendirmeler'); ?>
								</h1>
							</div>
						</div>
						<div class="card bg-success">
							<div class="card-header">Aktif Görevli Personel</div>
							<div class="card-body">
								<h1 class="display-4">
									<?= $admin->activeModuleCount('gorevlendirmeler','gorevlendirme_bitis','yeni'); ?>
								</h1>
							</div>
						</div>
						<div class="card bg-info">
							<div class="card-header">Açık olay sayısı</div>
							<div class="card-body">
								<h1 class="display-4">
									<?= $admin->activeModuleEqual('olaylar','olay_bitis'); ?>
								</h1>
							</div>
						</div>
					</div>
				</div>
			</div>

<!-- Footer Start -->
      </div>
    </div>
  </div>
</body>

</html>