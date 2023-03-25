<?php 

/**
 * 
 */
class Company {

  function __construct() {
    $this->alert = [
      'visible' => false,
      'color' => 'danger',
      'text' => '',
    ];

    $this->company_contacts_category = $this->getCompanyContactsCategory();
    $this->company_phones = $this->getCompanyPhones();
    $this->company_phones_arr = json_decode($this->company_phones->post_content, true);
    if (isset($_POST['add_company_phone'])) {
      $this->addCompanyPhone();
      $this->company_phones = $this->getCompanyPhones();
      $this->company_phones_arr = json_decode($this->company_phones->post_content, true);
    }
    if (isset($_POST['delete_company_phone'])) {
      array_splice($this->company_phones_arr, $_POST['delete_company_phone'], 1);
      $this->saveCompanyPhones();
    }

    $this->company_email = $this->getCompanyEmail();
    $this->company_email_arr = json_decode($this->company_email->post_content, true);
    if (isset($_POST['add_company_email'])) {
      $this->addCompanyEmail();
      $this->company_email = $this->getCompanyEmail();
      $this->company_email_arr = json_decode($this->company_email->post_content, true);
    }
    if (isset($_POST['delete_company_email'])) {
      array_splice($this->company_email_arr, $_POST['delete_company_email'], 1);
      $this->saveCompanyEmail();
    }

    $this->company_address = $this->getCompanyAddress();
    $this->company_address_arr = json_decode($this->company_address->post_content, true);
    if (isset($_POST['add_company_address'])) {
      $this->addCompanyAddress();
      $this->company_address = $this->getCompanyAddress();
      $this->company_address_arr = json_decode($this->company_address->post_content, true);
    }
    if (isset($_POST['delete_company_address'])) {
      array_splice($this->company_address_arr, $_POST['delete_company_address'], 1);
      $this->saveCompanyAddress();
    }

    $this->work_time = $this->getWorkTime();
    if (isset($_POST['work_time'])) {
      $this->setWorkTime();
      $this->work_time = $this->getWorkTime();
    }

    $this->social_networks = $this->getSocialNetworks();
    $this->social_networks_arr = json_decode($this->social_networks->post_content, true);
    if (isset($_POST['social_networks_save'])) {
      $this->saveSocialNetworks();
      $this->social_networks = $this->getSocialNetworks();
      $this->social_networks_arr = json_decode($this->social_networks->post_content, true);
    }    

    $this->company_name = $this->getCompanyName();
    if (isset($_POST['company_name'])) {
      $this->setCompanyName();
      $this->company_name = $this->getCompanyName();
    }
  }

  function setCompanyName () {
     $insert = wp_update_post([
      'ID' => $this->company_name->ID,
      'post_content' => $_POST['post_content'], 
    ]);
    $this->alertShow($insert);
  }

  function getCompanyName () {
    $company_name = get_posts([
      'category_name' => 'company_contacts',
      'post_type' => 'post',
      'name' => 'company_name',
    ]);
    if (!isset($company_name) or empty($company_name)) {
      $post_id = wp_insert_post([
        'post_title' => 'Название компании (сайта)',
        'post_name' => 'company_name',
        'post_content' => '',
        'post_status' => 'publish',
        'post_category' => [$this->company_contacts_category->cat_ID, ],
      ], true);
      $company_name = get_posts([
        'category_name' => 'company_contacts',
        'post_type' => 'post',
        'name' => 'company_name',
      ]);
    }
    return $company_name[0];
  }

  function saveSocialNetworks () {
    $arr = $_POST;
    unset($arr['social_networks_save']);
    $str = json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $insert = wp_update_post([
      'ID' => $this->social_networks->ID,
      'post_content' => $str, 
    ]);
    $this->alertShow($insert);
  }

  function getSocialNetworks () {
    $networks = get_posts([
      'category_name' => 'company_contacts',
      'post_type' => 'post',
      'name' => 'social_networks',
    ]);

    if (!isset($networks) or empty($networks)) {
      $arr = [
        'facebook' => '',
        'instagram' => '',
        'odnoklassniki' => '',
        'telegram' => '',
        'twitter' => '',
        'vk' => '',
        'whatsapp' => '',
      ];
      $str = json_encode($arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
      $post_id = wp_insert_post([
        'post_title' => 'Социальные сети',
        'post_name' => 'social_networks',
        'post_content' => $str,
        'post_status' => 'publish',
        'post_category' => [$this->company_contacts_category->cat_ID, ],
      ], true);
      $networks = get_posts([
        'category_name' => 'company_contacts',
        'post_type' => 'post',
        'name' => 'social_networks',
      ]);
    }
    return $networks[0];
  }

  function setWorkTime () {
    $insert = wp_update_post([
      'ID' => $this->work_time->ID,
      'post_content' => $_POST['post_content'], 
    ]);
    $this->alertShow($insert);
  }

  function getWorkTime () {
    $time = get_posts([
      'category_name' => 'company_contacts',
      'post_type' => 'post',
      'name' => 'work_time',
    ]);
    if (!isset($time) or empty($time)) {
      $post_id = wp_insert_post([
        'post_title' => 'График работы',
        'post_name' => 'work_time',
        'post_content' => '',
        'post_status' => 'publish',
        'post_category' => [$this->company_contacts_category->cat_ID, ],
      ], true);
      $time = get_posts([
        'category_name' => 'company_contacts',
        'post_type' => 'post',
        'name' => 'work_time',
      ]);
    }

    return $time[0];
  }

  function saveCompanyAddress () {
    $str = json_encode($this->company_address_arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $insert = wp_update_post([
      'ID' => $this->company_address->ID,
      'post_content' => $str, 
    ]);
    $this->alertShow($insert);
  }

  function addCompanyAddress () {
    $this->company_address_arr[] = $_POST['post_content-edit'];
    $this->saveCompanyAddress();
  }

  function getCompanyAddress () {
    $address = get_posts([
      'category_name' => 'company_contacts',
      'post_type' => 'post',
      'name' => 'company_address',
    ]);
    if (!isset($address) or empty($address)) {
      $post_id = wp_insert_post([
        'post_title' => 'Адрес компании',
        'post_name' => 'company_address',
        'post_content' => '',
        'post_status' => 'publish',
        'post_category' => [$this->company_contacts_category->cat_ID, ],
      ], true);
      $address = get_posts([
        'category_name' => 'company_contacts',
        'post_type' => 'post',
        'name' => 'company_address',
      ]);
    }
    return $address[0];
  }


  function saveCompanyEmail () {
    $str = json_encode($this->company_email_arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $insert = wp_update_post([
      'ID' => $this->company_email->ID,
      'post_content' => $str, 
    ]);
    $this->alertShow($insert);
  }

  function addCompanyEmail () {
    $this->company_email_arr[] = $_POST['post_content'];
    $this->saveCompanyEmail();
  }

  function getCompanyEmail () {
    $email = get_posts([
      'category_name' => 'company_contacts',
      'post_type' => 'post',
      'name' => 'company_email',
    ]);
    if (!isset($email) or empty($email)) {
      $post_id = wp_insert_post([
        'post_title' => 'Email компании',
        'post_name' => 'company_email',
        'post_content' => '',
        'post_status' => 'publish',
        'post_category' => [$this->company_contacts_category->cat_ID, ],
      ], true);
      $email = get_posts([
        'category_name' => 'company_contacts',
        'post_type' => 'post',
        'name' => 'company_email',
      ]);
    }
    return $email[0];
  }



  function saveCompanyPhones () {
    $str = json_encode($this->company_phones_arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $insert = wp_update_post([
      'ID' => $this->company_phones->ID,
      'post_content' => $str, 
    ]);
    $this->alertShow($insert);
  }

  function addCompanyPhone () {
    $this->company_phones_arr[] = $_POST['post_content'];
    $this->saveCompanyPhones();
  }

  function getCompanyPhones () {
    $phones = get_posts([
      'category_name' => 'company_contacts',
      'post_type' => 'post',
      'name' => 'company_phones',
    ]);
    if (!isset($phones) or empty($phones)) {
      $post_id = wp_insert_post([
        'post_title' => 'Телефоны компании',
        'post_name' => 'company_phones',
        'post_content' => '',
        'post_status' => 'publish',
        'post_category' => [$this->company_contacts_category->cat_ID, ],
      ], true);
      $phones = get_posts([
        'category_name' => 'company_contacts',
        'post_type' => 'post',
        'name' => 'company_phones',
      ]);
    }
    return $phones[0];
  }

  function alertShow ($insert) {
    if ($insert) {
      $this->alert['visible'] = true;
      $this->alert['color'] = 'success';
      $this->alert['text'] = 'Изменения сохранены в базу данных';
    } else {
      $this->alert['visible'] = true;
      $this->alert['color'] = 'danger';
      $this->alert['text'] = 'Ошибка базы данных';
    }
  }


  function getCompanyContactsCategory () {
    $category = get_category_by_slug('company_contacts');
    if (!isset($category_id) or empty($category_id)) {
      $category_id = wp_insert_category([
        'cat_ID' => 0,
        'cat_name' => 'Компания, контакты',
        'category_description' => 'Информация о компании, контакты',
        'category_nicename' => 'company_contacts',
        'category_parent' => 0,
        'taxonomy' => 'category',
      ]);
      $category = get_category_by_slug('company_contacts');
    }
    return $category;
  }
}

?>