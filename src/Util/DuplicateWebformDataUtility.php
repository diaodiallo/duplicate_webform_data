<?php

namespace Drupal\duplicate_webform_data\Util;

class DuplicateWebformDataUtility {

  public function splitTids($tids) {
    $tidsArray = explode(",", $tids);

    return $tidsArray;
  }

  public function groupMapping() {
    return [
      '130' => 13, // Loima
      '210' => 43, // Mandera
      '229' => 44, // Banissa
      '213' => 45, // Mandera north
      '211' => 46, // Mandera west
      '218' => 15, // Mombasa
      '226' => 22, // Mvita
      '225' => 21, // Likoni
      '132' => 19, // Kisauni Nyali
      '222' => 20, // Changamwe Jomvu
      '95' => 23, // Nairobi county
      '96' => 31, // Westlands
      '97' => 41, // Starehe Mathare
      '98' => 40, // Ruaraka Roysambu
      '101' => 36, // Makadara
      '102' => 35, // 	Langata Kibra
      '104' => 33, // Kasarani Embakasi North
      '105' => 32, // Kamukunji
      '106' => 28, // Embakasi West Central
      '109' => 27, // 	Embakasi East South
      '112' => 24, // Dagoretti North South
      '216' => 47, // 	Nyeri
      '232' => 63, // Tetu
      '135' => 48, // Nyeri south
      '233' => 49, // 	Nyeri central
      '234' => 50, // 	Mukurweini
      '235' => 51, // Mathira West East
      '134' => 52, // Kieni west
      '133' => 53, // 	Kieni east
      '119' => 60, // Samburu county
      '120' => 61, // Samburu east
      '118' => 62, // Samburu central
      '217' => 54, // Trans Nzoia
      '117' => 55, // Saboti
      '116' => 56, // 	Kwanza
      '115' => 57, // Kiminini
      '243' => 58, // 	Endebess
      '113' => 59, // Cherangany
      '219' => 64, // Wajir county
      '244' => 66, // Wajir west
      '129' => 65, // Wajir north
      '122' => 67, // Tarbaj
      '131' => 10, // Turkana county
      '114' => 12, // Kibish
      '123' => 14, // Turkana south
      '220' => 76, // Siaya county
      '237' => 81, // Ugunja
      '238' => 82, // Ugenya
      '239' => 80, // Rarieda
      '240' => 78, // Gem
      '241' => 79, // Bondo
      '242' => 77, // Alego_Usonga
      '100' => 37, // Starehe Mathare 5 OK
      '231' => 18, // Changamwe Jomvu 5 OK
      '111' => 25, // Dagoretti North South 5 OK
      '107' => 30, // Embakasi East South 5 OK
      '110' => 26, // Embakasi West Central 5 OK
      '108' => 29, // Kasarani Embakasi North 5 OK
      '230' => 17, // Kisauni Nyali 5 OK
      '103' => 34, // Langata Kibra 5 OK
      '236' => 84, // Mathira West East 5 OK
      '99' => 39, // Ruaraka Roysambu 5 OK
    ];
  }

  public function duplicateMapping() {
    // primary to secondary
    return [
      '97' => 100, // Starehe Mathare
      '222' => 231, // Changamwe Jomvu
      '112' => 111, // Dagoretti North South
      '109' => 107, // Embakasi East South
      '106' => 110, // Embakasi West Central
      '104' => 108, // Kasarani Embakasi North
      '132' => 230, // Kisauni Nyali
      '102' => 103, // Langata Kibra
      '235' => 236, // Mathira West East
      '98' => 99, // Ruaraka Roysambu
    ];
  }

  public function getTn($tid) {
    $query = \Drupal::database()->select('taxonomy_term_field_data', 'td');
    $query->addField('td', 'name');
    $query->condition('td.tid', $tid);
    $term = $query->execute();
    $tname = $term->fetchField();

    return $tname;
  }
}