<?php
include_once __DIR__.'/admin-header.php';
include_once $theme_path.'/ug_ideal-core/Company.php';
$company_contacts = new Company();
?>
<div class="container pt-5">
  <?php if ($company_contacts->alert['visible']): ?>
    <div class="row pb-5">
      <div class="col-12">
        <div class="alert-<?php echo $company_contacts->alert['color'];?> alert text-center">
          <?php echo $company_contacts->alert['text']; ?>
        </div>
      </div>
    </div>
  <?php endif ?>
  
  <div class="row">
    <div class="col-12">
      <div class="h2 text-info">Данные компании:</div>
    </div>
  </div>

  <div class="row pt-5">
    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
      <form action="" method="post" class="border p-2">
        <input type="text" name="post_content" placeholder="+ _ ( ___ ) ___ - __ - __" class="form-control" required>
        <button class="btn btn-outline-success w-100 mt-1" name="add_company_phone" value="Y">
          <span class="dashicons dashicons-yes"></span>
          Добавить телефон
        </button>
      </form>
      <table class="table border mt-3">
        <tr><th class="text-info">Телефоны:</th><th></th></tr>
        <?php if ($company_contacts->company_phones_arr): ?>
          <?php foreach ($company_contacts->company_phones_arr as $key => $value): ?>
            <tr class="tr">
              <td class="td">
                <?php print_r($value); ?>
              </td>
              <td>
                <form action="" method="post">
                  <button name="delete_company_phone" value="<?php echo $key;?>" class="btn btn-outline-danger" title="Удалить">
                    <span class="dashicons dashicons-trash"></span>
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach ?>       
        <?php endif ?>
      </table>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
      <form action="" method="post" class="border p-2">
        <input type="email" name="post_content" class="form-control" required>
        <button class="btn btn-outline-success w-100 mt-1" name="add_company_email" value="Y">
          <span class="dashicons dashicons-yes"></span>
          Добавить email
        </button>
      </form>
      <table class="table border mt-3">
        <tr><th class="text-info">Email:</th><th></th></tr>
        <?php if ($company_contacts->company_email_arr): ?>
          <?php foreach ($company_contacts->company_email_arr as $key => $value): ?>
            <tr class="tr">
              <td class="td">
                <?php print_r($value); ?>
              </td>
              <td>
                <form action="" method="post">
                  <button name="delete_company_email" value="<?php echo $key;?>" class="btn btn-outline-danger" title="Удалить">
                    <span class="dashicons dashicons-trash"></span>
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach ?>   
        <?php endif ?>
      </table>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-12 col-12">
      <div class="text-info h5">Логотип:</div>
      <img src="<?php echo $theme_url.'/ug_ideal-libs/dompdf/img/ug-ideal.png?='.time(); ?>" width="200" alt="">
      <div class="h5 text-info">Заменить:</div>
      <form action="" enctype="multipart/form-data" method="post" id="company_logo-form">
        <input type="file" name="logotip" id="company_logo">
      </form>
      <div>(загружать изображение в формате .png на прозрачном фоне)</div>
      <script>
        $('#company_logo').change(function () {
          $('#company_logo-form')[0].submit();
        });
      </script>
      <?php
      if (isset($_FILES['logotip'])) {
        $ext = explode('.', $_FILES['logotip']['name']);
        $ext = array_pop($ext);
        if ($ext == 'png') {
          move_uploaded_file($_FILES['logotip']['tmp_name'], $theme_path.'/ug_ideal-libs/dompdf/img/ug-ideal.png');
          echo 'Логотип изменен';
        } else {
          echo 'Неверный формат файла';
        }
      }
      ?>
    </div>


    <div class="col-lg-3 col-md-6 col-sm-12">
      <div>
        <div class="h6 text-info">Название компании:</div>
        <?php print_r($company_contacts->company_name->post_content); ?>
        <form action="" method="post">
          <input value="<?php echo $company_contacts->company_name->post_content;?>"
          class="form-control" type="text" name="post_content">
          <button name="company_name" value="Y" class="btn btn-outline-success mt-1 w-100">
            <span class="dashicons dashicons-yes"></span>
            Изменить
          </button>
        </form>
      </div>
      <div class="h6 text-info">
        График работы:
        <form action="" method="post" class="input-group mb-3">
          <input type="text" value="<?php echo $company_contacts->work_time->post_content;?>" class="form-control" name="post_content">
          <button name="work_time" value="Y" class="input-group-text btn btn-outline-success">
            <span class="dashicons dashicons-yes"></span>
          </button>
        </form>
      </div>
    </div>

  </div>

  <div class="row pt-2 mt-2 mb-5 border border-info pb-2">
    <!-- <script src="https://cdn.ckeditor.com/4.20.2/basic/ckeditor.js"></script> -->
    <div class="col-12">
      <div class="h4">Адреса компании:</div>
      <table class="table border mt-3">
        <?php if ($company_contacts->company_address): ?>
          <?php foreach ($company_contacts->company_address as $key => $value): ?>
            <tr class="tr">
              <td class="td">
                <form action="" method="post" class="row">
                  <div class="col-10">
                    Адрес:
                    <textarea name="address" rows="1" class="form-control" required><?php echo $value->post_title?></textarea>
                    Код карты:
                    <textarea name="map" rows="2" class="form-control mt-1"><?php echo $value->post_content; ?></textarea>
                  </div>
                  <div class="col-2">
                    <br>
                    <button name="edit_company_address" value="<?php echo $value->ID; ?>"
                      class="btn btn-outline-success" title="Сохранить">
                      <span class="dashicons dashicons-yes"></span>
                    </button>
                  </div>
                </form>
              </td>
              <td width="100">
                <br>
                <form action="" method="post">
                  <button name="delete_company_address" value="<?php echo $value->ID; ?>" class="btn btn-outline-danger" title="Удалить">
                    <span class="dashicons dashicons-trash"></span>
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach ?>   
        <?php endif ?>
      </table>
      <form action="" method="post" class="border p-2">
        <div class="h5 text-info">Добавить адрес:</div>
        <textarea name="address" class="form-control" rows="1" placeholder="Адрес" required></textarea>
        <textarea name="map" class="form-control mt-1" rows="1" placeholder="Код карты"></textarea>
        <button class="btn btn-outline-success w-100 mt-1" name="add_company_address" value="Y">
          <span class="dashicons dashicons-yes"></span>
          Сохранить
        </button>
      </form>
    </div>
    <script>
      // CKEDITOR.replace( 'post_content-edit', {height: 200} );
    </script>
  </div>

  <form action="" method="post" class="row border">
    <div class="h5">Социальные сети:</div>
    <?php foreach ($company_contacts->social_networks_arr as $key => $value): ?>
      <div class="col-lg-4 col-md-6 col-sm-12 col-12 p-1">
        <div class="row">
          <div class="col-1 text-info h5">
            <i class="fa fa-<?php echo $key; ?>" aria-hidden="true"></i>
          </div>
          <div class="col-11">
            <input type="text" name="<?php echo $key;?>" value="<?php echo $value;?>" class="form-control w-75">
          </div>
        </div>
      </div>
    <?php endforeach ?>
    <div class="col-lg-4 col-md-6 col-sm-12 col-12 p-1">
      <button name="social_networks_save" value="Y" class="btn btn-outline-success w-100">
        <span class="dashicons dashicons-yes"></span>
        Сохранить
      </button>
    </div>    
  </form>


</div>